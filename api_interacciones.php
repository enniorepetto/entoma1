<?php
session_start();
include("conexion.php");

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$usuario_id = $_SESSION['usuario_id'] ?? null;

switch($action) {
    case 'like':
        handleLike($conexion, $usuario_id);
        break;
    case 'save':
        handleSave($conexion, $usuario_id);
        break;
    case 'comment':
        handleComment($conexion, $usuario_id);
        break;
    case 'get_comments':
        getComments($conexion);
        break;
    case 'delete_comment':
        deleteComment($conexion, $usuario_id);
        break;
    default:
        echo json_encode(['error' => 'Acción no válida']);
    case 'check_comments_allowed':
        checkCommentsAllowed($conexion);
        break;
        
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
    
    // Actualizar contador en la tabla publicaciones
    $update_sql = "UPDATE publicaciones SET likes = ? WHERE id_publicaciones = ?";
    $stmt = $conexion->prepare($update_sql);
    $stmt->bind_param("ii", $row['total'], $post_id);
    $stmt->execute();
    
    echo json_encode([
        'success' => true,
        'action' => $action,
        'total_likes' => $row['total']
    ]);
    
    $stmt->close();
}

function handleSave($conexion, $usuario_id) {
    if (!$usuario_id) {
        echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
        return;
    }
    
    $post_id = $_POST['post_id'] ?? 0;
    
    if (!$post_id) {
        echo json_encode(['success' => false, 'message' => 'ID de publicación inválido']);
        return;
    }
    
    // Verificar si ya guardó la publicación
    $check_sql = "SELECT id_guardado FROM guardados WHERE id_usuario = ? AND id_publicacion = ?";
    $stmt = $conexion->prepare($check_sql);
    $stmt->bind_param("ii", $usuario_id, $post_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        // Ya está guardado, entonces quitar
        $delete_sql = "DELETE FROM guardados WHERE id_usuario = ? AND id_publicacion = ?";
        $stmt = $conexion->prepare($delete_sql);
        $stmt->bind_param("ii", $usuario_id, $post_id);
        $stmt->execute();
        
        $action = 'unsaved';
        $message = 'Publicación eliminada de guardados';
    } else {
        // No está guardado, entonces agregar
        $insert_sql = "INSERT INTO guardados (id_usuario, id_publicacion) VALUES (?, ?)";
        $stmt = $conexion->prepare($insert_sql);
        $stmt->bind_param("ii", $usuario_id, $post_id);
        $stmt->execute();
        
        $action = 'saved';
        $message = 'Publicación guardada';
    }
    
    echo json_encode([
        'success' => true,
        'action' => $action,
        'message' => $message
    ]);
    
    $stmt->close();
}

function handleComment($conexion, $usuario_id) {
    if (!$usuario_id) {
        echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
        return;
    }
    
    $post_id = $_POST['post_id'] ?? 0;
    $comentario = trim($_POST['comentario'] ?? '');
    
    if (!$post_id || empty($comentario)) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        return;
    }
    
    // Insertar comentario
    $insert_sql = "INSERT INTO comentarios (id_usuario, id_publicacion, comentario) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($insert_sql);
    $stmt->bind_param("iis", $usuario_id, $post_id, $comentario);
    
    if ($stmt->execute()) {
        $comment_id = $conexion->insert_id;
        
        // Actualizar contador en la tabla publicaciones
        $update_sql = "UPDATE publicaciones SET comentarios = comentarios + 1 WHERE id_publicaciones = ?";
        $stmt = $conexion->prepare($update_sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        
        // Obtener información del usuario para devolver
        $user_sql = "SELECT nombre, apellido FROM usuario WHERE id_usuario = ?";
        $stmt = $conexion->prepare($user_sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $user = $resultado->fetch_assoc();
        
        echo json_encode([
            'success' => true,
            'message' => 'Comentario agregado',
            'comment' => [
                'id' => $comment_id,
                'comentario' => $comentario,
                'user_name' => $user['nombre'] . ' ' . $user['apellido'],
                'user_avatar' => strtoupper(substr($user['nombre'], 0, 1)),
                'fecha' => date('Y-m-d H:i:s'),
                'is_owner' => true
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar comentario']);
    }
    
    $stmt->close();
}

function getComments($conexion) {
    $post_id = $_GET['post_id'] ?? 0;
    
    if (!$post_id) {
        echo json_encode(['error' => 'ID de publicación inválido']);
        return;
    }
    
    $sql = "SELECT c.*, u.nombre, u.apellido 
            FROM comentarios c 
            JOIN usuario u ON c.id_usuario = u.id_usuario 
            WHERE c.id_publicacion = ? 
            ORDER BY c.fecha_comentario DESC";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $comments = [];
    $usuario_id = $_SESSION['usuario_id'] ?? null;
    
    while ($row = $resultado->fetch_assoc()) {
        $comments[] = [
            'id' => $row['id_comentario'],
            'comentario' => $row['comentario'],
            'user_name' => $row['nombre'] . ' ' . $row['apellido'],
            'user_avatar' => strtoupper(substr($row['nombre'], 0, 1)),
            'fecha' => $row['fecha_comentario'],
            'is_owner' => $usuario_id == $row['id_usuario']
        ];
    }
    
    echo json_encode($comments);
    $stmt->close();
}

function deleteComment($conexion, $usuario_id) {
    if (!$usuario_id) {
        echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
        return;
    }
    
    $comment_id = $_POST['comment_id'] ?? 0;
    
    if (!$comment_id) {
        echo json_encode(['success' => false, 'message' => 'ID de comentario inválido']);
        return;
    }
    
    // Verificar que el comentario pertenece al usuario
    $check_sql = "SELECT id_publicacion FROM comentarios WHERE id_comentario = ? AND id_usuario = ?";
    $stmt = $conexion->prepare($check_sql);
    $stmt->bind_param("ii", $comment_id, $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'No tienes permiso para eliminar este comentario']);
        return;
    }
    
    $row = $resultado->fetch_assoc();
    $post_id = $row['id_publicacion'];
    
    // Eliminar comentario
    $delete_sql = "DELETE FROM comentarios WHERE id_comentario = ?";
    $stmt = $conexion->prepare($delete_sql);
    $stmt->bind_param("i", $comment_id);
    
    if ($stmt->execute()) {
        // Actualizar contador en la tabla publicaciones
        $update_sql = "UPDATE publicaciones SET comentarios = comentarios - 1 WHERE id_publicaciones = ?";
        $stmt = $conexion->prepare($update_sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        
        echo json_encode([
            'success' => true,
            'message' => 'Comentario eliminado'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar comentario']);
    }
    
    $stmt->close();
}
function checkCommentsAllowed($conexion) {
    $post_id = $_GET['post_id'] ?? 0;
    
    if (!$post_id) {
        echo json_encode(['allowed' => false]);
        return;
    }
    
    // Obtener el dueño del post
    $sql = "SELECT id_usuario FROM publicaciones WHERE id_publicaciones = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows == 0) {
        echo json_encode(['allowed' => false]);
        return;
    }
    
    $post = $resultado->fetch_assoc();
    $owner_id = $post['id_usuario'];
    
    // Verificar configuración del dueño
    $config_sql = "SELECT permitir_comentarios FROM configuraciones_usuario WHERE id_usuario = ?";
    $stmt = $conexion->prepare($config_sql);
    $stmt->bind_param("i", $owner_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows == 0) {
        // Si no tiene configuración, permitir por defecto
        echo json_encode(['allowed' => true]);
        return;
    }
    
    $config = $resultado->fetch_assoc();
    echo json_encode(['allowed' => (bool)$config['permitir_comentarios']]);
    
    $stmt->close();
}
$conexion->close();
?>