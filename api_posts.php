<?php
session_start();
include("conexion.php");

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$action = $_GET['action'] ?? '';
$usuario_id = $_SESSION['usuario_id'] ?? null;

switch($action) {
    case 'feed':
        getFeedPosts($conexion, $usuario_id);
        break;
    case 'explore':
        getExplorePosts($conexion);
        break;
    case 'trending':
        getTrendingPosts($conexion);
        break;
    case 'user':
        getUserPosts($conexion, $_GET['user_id'] ?? $usuario_id);
        break;
    case 'saved':
        getSavedPosts($conexion, $usuario_id);
        break;
    case 'like':
        handleLike($conexion, $usuario_id);
        break;
    default:
        echo json_encode(['error' => 'Acción no válida']);
}

function getFeedPosts($conexion, $usuario_id) {
    // Obtener publicaciones reales de la BD
    $sql = "SELECT p.*, u.nombre, u.apellido, u.foto as user_foto,
            (SELECT COUNT(*) FROM likes WHERE id_publicacion = p.id_publicaciones) as total_likes,
            (SELECT COUNT(*) FROM comentarios WHERE id_publicacion = p.id_publicaciones) as total_comentarios
            FROM publicaciones p 
            JOIN usuario u ON p.id_usuario = u.id_usuario 
            WHERE u.borrado = 0 AND p.activo = 1
            ORDER BY p.fecha_creacion DESC 
            LIMIT 50";
    
    $resultado = mysqli_query($conexion, $sql);
    
    if (!$resultado) {
        echo json_encode(['error' => mysqli_error($conexion)]);
        return;
    }
    
    $posts = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $posts[] = formatPost($row, $usuario_id, $conexion);
    }
    
    echo json_encode($posts);
}

function getExplorePosts($conexion) {
    // Similar a feed pero aleatorio
    $sql = "SELECT p.*, u.nombre, u.apellido, u.foto as user_foto,
            (SELECT COUNT(*) FROM likes WHERE id_publicacion = p.id_publicaciones) as total_likes,
            (SELECT COUNT(*) FROM comentarios WHERE id_publicacion = p.id_publicaciones) as total_comentarios
            FROM publicaciones p 
            JOIN usuario u ON p.id_usuario = u.id_usuario 
            WHERE u.borrado = 0 AND p.activo = 1
            ORDER BY RAND() 
            LIMIT 50";
    
    $resultado = mysqli_query($conexion, $sql);
    $posts = [];
    
    while ($row = mysqli_fetch_assoc($resultado)) {
        $posts[] = formatPost($row, $_SESSION['usuario_id'] ?? null, $conexion);
    }
    
    echo json_encode($posts);
}

function getTrendingPosts($conexion) {
    // Posts ordenados por likes
    $sql = "SELECT p.*, u.nombre, u.apellido, u.foto as user_foto,
            (SELECT COUNT(*) FROM likes WHERE id_publicacion = p.id_publicaciones) as total_likes,
            (SELECT COUNT(*) FROM comentarios WHERE id_publicacion = p.id_publicaciones) as total_comentarios
            FROM publicaciones p 
            JOIN usuario u ON p.id_usuario = u.id_usuario 
            WHERE u.borrado = 0 AND p.activo = 1
            ORDER BY total_likes DESC, p.fecha_creacion DESC
            LIMIT 50";
    
    $resultado = mysqli_query($conexion, $sql);
    $posts = [];
    
    while ($row = mysqli_fetch_assoc($resultado)) {
        $posts[] = formatPost($row, $_SESSION['usuario_id'] ?? null, $conexion);
    }
    
    echo json_encode($posts);
}

function getUserPosts($conexion, $user_id) {
    if (!$user_id) {
        echo json_encode([]);
        return;
    }
    
    $sql = "SELECT p.*, u.nombre, u.apellido, u.foto as user_foto,
            (SELECT COUNT(*) FROM likes WHERE id_publicacion = p.id_publicaciones) as total_likes,
            (SELECT COUNT(*) FROM comentarios WHERE id_publicacion = p.id_publicaciones) as total_comentarios
            FROM publicaciones p 
            JOIN usuario u ON p.id_usuario = u.id_usuario 
            WHERE p.id_usuario = ? AND u.borrado = 0 AND p.activo = 1
            ORDER BY p.fecha_creacion DESC";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $posts = [];
    while ($row = $resultado->fetch_assoc()) {
        $posts[] = formatPost($row, $_SESSION['usuario_id'] ?? null, $conexion);
    }
    
    echo json_encode($posts);
    $stmt->close();
}

function getSavedPosts($conexion, $usuario_id) {
    if (!$usuario_id) {
        echo json_encode([]);
        return;
    }
    
    $sql = "SELECT p.*, u.nombre, u.apellido, u.foto as user_foto,
            (SELECT COUNT(*) FROM likes WHERE id_publicacion = p.id_publicaciones) as total_likes,
            (SELECT COUNT(*) FROM comentarios WHERE id_publicacion = p.id_publicaciones) as total_comentarios
            FROM guardados g
            JOIN publicaciones p ON g.id_publicacion = p.id_publicaciones
            JOIN usuario u ON p.id_usuario = u.id_usuario 
            WHERE g.id_usuario = ? AND u.borrado = 0 AND p.activo = 1
            ORDER BY g.fecha_guardado DESC";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $posts = [];
    while ($row = $resultado->fetch_assoc()) {
        $posts[] = formatPost($row, $usuario_id, $conexion);
    }
    
    echo json_encode($posts);
    $stmt->close();
}

function handleLike($conexion, $usuario_id) {
    if (!$usuario_id) {
        echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
        return;
    }
    
    $post_id = $_POST['post_id'] ?? 0;
    
    if (!$post_id) {
        echo json_encode(['success' => false, 'message' => 'ID de publicación inválido']);
        return;
    }
    
    // Verificar si ya dio like
    $check_sql = "SELECT id_like FROM likes WHERE id_usuario = ? AND id_publicacion = ?";
    $stmt = $conexion->prepare($check_sql);
    $stmt->bind_param("ii", $usuario_id, $post_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        // Ya dio like, entonces quitar
        $delete_sql = "DELETE FROM likes WHERE id_usuario = ? AND id_publicacion = ?";
        $stmt = $conexion->prepare($delete_sql);
        $stmt->bind_param("ii", $usuario_id, $post_id);
        $stmt->execute();
        
        $action = 'unliked';
    } else {
        // No ha dado like, entonces agregar
        $insert_sql = "INSERT INTO likes (id_usuario, id_publicacion) VALUES (?, ?)";
        $stmt = $conexion->prepare($insert_sql);
        $stmt->bind_param("ii", $usuario_id, $post_id);
        $stmt->execute();
        
        $action = 'liked';
    }
    
    // Obtener total de likes actualizado
    $count_sql = "SELECT COUNT(*) as total FROM likes WHERE id_publicacion = ?";
    $stmt = $conexion->prepare($count_sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'action' => $action,
        'total_likes' => $row['total']
    ]);
    
    $stmt->close();
}

function formatPost($row, $usuario_id, $conexion) {
    $username = strtolower(str_replace(' ', '', $row['nombre']));
    
    // Verificar si el usuario actual dio like
    $liked_by_user = false;
    if ($usuario_id) {
        $check_sql = "SELECT id_like FROM likes WHERE id_usuario = ? AND id_publicacion = ?";
        $stmt = $conexion->prepare($check_sql);
        $stmt->bind_param("ii", $usuario_id, $row['id_publicaciones']);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $liked_by_user = $resultado->num_rows > 0;
        $stmt->close();
    }
    
    return [
        'id' => $row['id_publicaciones'],
        'title' => $row['titulo'] ?? 'Sin título',
        'description' => $row['descripcion'] ?? '',
        'image' => 'uploads/publicaciones/' . $row['foto'],
        'user' => '@' . $username,
        'user_name' => $row['nombre'] . ' ' . ($row['apellido'] ?? ''),
        'user_avatar' => strtoupper(substr($row['nombre'], 0, 1)),
        'tags' => $row['etiquetas'] ? explode(',', $row['etiquetas']) : [],
        'location' => $row['ubicacion'] ?? '',
        'likes' => (int)($row['total_likes'] ?? 0),
        'comments' => (int)($row['total_comentarios'] ?? 0),
        'created_at' => $row['fecha_creacion'],
        'liked_by_user' => $liked_by_user
    ];
}

$conexion->close();
?>