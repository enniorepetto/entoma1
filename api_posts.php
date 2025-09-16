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
    // Para explorar, mostrar datos de ejemplo mezclados
    $samplePosts = getSamplePosts();
    // Mezclar array
    shuffle($samplePosts);
    echo json_encode($samplePosts);
}

function getTrendingPosts($conexion) {
    // Para trending, mostrar datos de ejemplo ordenados por likes
    $samplePosts = getSamplePosts();
    usort($samplePosts, function($a, $b) {
        return $b['likes'] - $a['likes'];
    });
    echo json_encode($samplePosts);
}

function getUserPosts($conexion, $user_id) {
    if (!$user_id) {
        echo json_encode([]);
        return;
    }
    
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
        'user_name' => $row['nombre'] . ' ' . ($row['apellido'] ?? ''),
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
            'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=300&h=400&fit=crop',
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
            'image' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=300&h=500&fit=crop',
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
            'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=300&h=450&fit=crop',
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
            'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=300&h=400&fit=crop',
            'user' => '@nightowl',
            'user_name' => 'Night Owl',
            'user_avatar' => 'N',
            'tags' => ['noche', 'elegante', 'fiesta'],
            'location' => 'Recoleta',
            'likes' => 203,
            'comments' => 15,
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours'))
        ],
        [
            'id' => 5,
            'title' => 'Estilo Minimalista',
            'description' => 'Menos es más en este look clean',
            'image' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=300&h=380&fit=crop',
            'user' => '@minimal_chic',
            'user_name' => 'Minimal Chic',
            'user_avatar' => 'C',
            'tags' => ['minimalista', 'clean', 'moderno'],
            'location' => 'Villa Crespo',
            'likes' => 67,
            'comments' => 5,
            'created_at' => date('Y-m-d H:i:s', strtotime('-8 hours'))
        ],
        [
            'id' => 6,
            'title' => 'Vintage Vibes',
            'description' => 'Inspirado en los 90s pero con twist moderno',
            'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=300&h=420&fit=crop',
            'user' => '@retro_queen',
            'user_name' => 'Retro Queen',
            'user_avatar' => 'R',
            'tags' => ['vintage', '90s', 'retro'],
            'location' => 'San Telmo',
            'likes' => 245,
            'comments' => 31,
            'created_at' => date('Y-m-d H:i:s', strtotime('-12 hours'))
        ]
    ];
}

$conexion->close();
?>