<?php
session_start();
include("conexion.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$usuario_id = $_SESSION['usuario_id'];

switch($action) {
    case 'feed':
        getFeedPosts($conexion);
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
        getSavedPosts($conexion);
        break;
    default:
        echo json_encode(['error' => 'Acción no válida']);
}

function getFeedPosts($conexion) {
    // Verificar si existen publicaciones
    $sql = "SELECT COUNT(*) as total FROM publicaciones p 
            JOIN usuario u ON p.id_usuario = u.id_usuario 
            WHERE u.borrado = 0";
    $result = mysqli_query($conexion, $sql);
    $count = mysqli_fetch_assoc($result)['total'];
    
    if ($count == 0) {
        // Si no hay publicaciones, crear datos de ejemplo
        echo json_encode(getSamplePosts());
        return;
    }
    
    $sql = "SELECT p.*, u.nombre, u.apellido, u.foto as user_foto 
            FROM publicaciones p 
            JOIN usuario u ON p.id_usuario = u.id_usuario 
            WHERE u.borrado = 0 
            ORDER BY p.fecha_creacion DESC 
            LIMIT 20";
    
    $resultado = mysqli_query($conexion, $sql);
    if (!$resultado) {
        echo json_encode(['error' => mysqli_error($conexion)]);
        return;
    }
    
    $posts = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $posts[] = formatPost($row);
    }
    
    if (empty($posts)) {
        $posts = getSamplePosts();
    }
    
    echo json_encode($posts);
}

function getExplorePosts($conexion) {
    // Para explorar, mostrar datos de ejemplo
    echo json_encode(getSamplePosts());
}

function getTrendingPosts($conexion) {
    // Para trending, mostrar datos de ejemplo
    echo json_encode(getSamplePosts());
}

function getUserPosts($conexion, $user_id) {
    $sql = "SELECT p.*, u.nombre, u.apellido, u.foto as user_foto 
            FROM publicaciones p 
            JOIN usuario u ON p.id_usuario = u.id_usuario 
            WHERE p.id_usuario = ? AND u.borrado = 0 
            ORDER BY p.fecha_creacion DESC";
    
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Error preparando consulta']);
        return;
    }
    
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $posts = [];
    while ($row = $resultado->fetch_assoc()) {
        $posts[] = formatPost($row);
    }
    
    if (empty($posts)) {
        $posts = []; // Array vacío si no hay posts del usuario
    }
    
    echo json_encode($posts);
    $stmt->close();
}

function getSavedPosts($conexion) {
    // Por ahora retornamos array vacío
    echo json_encode([]);
}

function formatPost($row) {
    $username = strtolower(str_replace(' ', '', $row['nombre']));
    
    return [
        'id' => $row['id_publicaciones'] ?? 0,
        'title' => $row['titulo'] ?? 'Sin título',
        'description' => $row['descripcion'] ?? '',
        'image' => 'uploads/publicaciones/' . ($row['foto'] ?? 'placeholder.jpg'),
        'user' => '@' . $username,
        'user_name' => $row['nombre'] . ' ' . $row['apellido'],
        'user_avatar' => strtoupper(substr($row['nombre'], 0, 1)),
        'tags' => $row['etiquetas'] ? explode(',', $row['etiquetas']) : [],
        'location' => $row['ubicacion'] ?? '',
        'likes' => (int)($row['likes'] ?? 0),
        'comments' => (int)($row['comentarios'] ?? 0),
        'created_at' => $row['fecha_creacion'] ?? date('Y-m-d H:i:s')
    ];
}

function getSamplePosts() {
    return [
        [
            'id' => 1,
            'title' => 'Street Style Casual',
            'description' => 'Look perfecto para un día casual en la ciudad',
            'image' => 'https://via.placeholder.com/300x400/FF6B6B/FFFFFF?text=Street+Style',
            'user' => '@maria_style',
            'user_name' => 'Maria Style',
            'user_avatar' => 'M',
            'tags' => ['street', 'casual', 'urbano'],
            'location' => 'Buenos Aires',
            'likes' => 124,
            'comments' => 8,
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
        ],
        [
            'id' => 2,
            'title' => 'Elegante para la oficina',
            'description' => 'Combinación perfecta para una reunión importante',
            'image' => 'https://via.placeholder.com/300x500/4ECDC4/FFFFFF?text=Elegant+Look',
            'user' => '@fashionlover',
            'user_name' => 'Fashion Lover',
            'user_avatar' => 'F',
            'tags' => ['elegante', 'trabajo', 'formal'],
            'location' => 'CABA',
            'likes' => 89,
            'comments' => 12,
            'created_at' => date('Y-m-d H:i:s', strtotime('-5 hours'))
        ],
        [
            'id' => 3,
            'title' => 'Look casual viernes',
            'description' => 'Cómodo pero con estilo para el fin de semana',
            'image' => 'https://via.placeholder.com/300x450/45B7D1/FFFFFF?text=Casual+Friday',
            'user' => '@style_guru',
            'user_name' => 'Style Guru',
            'user_avatar' => 'S',
            'tags' => ['casual', 'viernes', 'relajado'],
            'location' => 'Palermo',
            'likes' => 156,
            'comments' => 23,
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ],
        [
            'id' => 4,
            'title' => 'Outfit de noche',
            'description' => 'Perfecto para una salida nocturna',
            'image' => 'https://via.placeholder.com/300x400/96CEB4/FFFFFF?text=Night+Out',
            'user' => '@nightowl',
            'user_name' => 'Night Owl',
            'user_avatar' => 'N',
            'tags' => ['noche', 'elegante', 'fiesta'],
            'location' => 'Recoleta',
            'likes' => 203,
            'comments' => 15,
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours'))
        ]
    ];
}

$conexion->close();
?>