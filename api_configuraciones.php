<?php
session_start();
include("conexion.php");

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$usuario_id = $_SESSION['usuario_id'] ?? null;

if (!$usuario_id) {
    echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
    exit();
}

switch($action) {
    case 'get_config':
        getConfiguraciones($conexion, $usuario_id);
        break;
    case 'update_config':
        updateConfiguraciones($conexion, $usuario_id);
        break;
    case 'update_profile':
        updateProfile($conexion, $usuario_id);
        break;
    case 'change_password':
        changePassword($conexion, $usuario_id);
        break;
    default:
        echo json_encode(['error' => 'Acción no válida']);
}

function getConfiguraciones($conexion, $usuario_id) {
    // Verificar si existen configuraciones para este usuario
    $check_sql = "SELECT * FROM configuraciones_usuario WHERE id_usuario = ?";
    $stmt = $conexion->prepare($check_sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows == 0) {
        // Crear configuraciones por defecto
        $insert_sql = "INSERT INTO configuraciones_usuario (id_usuario) VALUES (?)";
        $stmt = $conexion->prepare($insert_sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        
        // Obtener las configuraciones recién creadas
        $stmt = $conexion->prepare($check_sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
    }
    
    $config = $resultado->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'config' => [
            'perfil_publico' => (bool)$config['perfil_publico'],
            'permitir_comentarios' => (bool)$config['permitir_comentarios'],
            'notificaciones_email' => (bool)$config['notificaciones_email'],
            'notificaciones_push' => (bool)$config['notificaciones_push']
        ]
    ]);
    
    $stmt->close();
}

function updateConfiguraciones($conexion, $usuario_id) {
    $perfil_publico = isset($_POST['perfil_publico']) ? (int)$_POST['perfil_publico'] : 0;
    $permitir_comentarios = isset($_POST['permitir_comentarios']) ? (int)$_POST['permitir_comentarios'] : 0;
    $notificaciones_email = isset($_POST['notificaciones_email']) ? (int)$_POST['notificaciones_email'] : 0;
    $notificaciones_push = isset($_POST['notificaciones_push']) ? (int)$_POST['notificaciones_push'] : 0;
    
    // Verificar si ya existe configuración
    $check_sql = "SELECT id_configuracion FROM configuraciones_usuario WHERE id_usuario = ?";
    $stmt = $conexion->prepare($check_sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        // Actualizar configuración existente
        $update_sql = "UPDATE configuraciones_usuario 
                      SET perfil_publico = ?, 
                          permitir_comentarios = ?, 
                          notificaciones_email = ?, 
                          notificaciones_push = ? 
                      WHERE id_usuario = ?";
        $stmt = $conexion->prepare($update_sql);
        $stmt->bind_param("iiiii", $perfil_publico, $permitir_comentarios, $notificaciones_email, $notificaciones_push, $usuario_id);
    } else {
        // Insertar nueva configuración
        $insert_sql = "INSERT INTO configuraciones_usuario 
                      (id_usuario, perfil_publico, permitir_comentarios, notificaciones_email, notificaciones_push) 
                      VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($insert_sql);
        $stmt->bind_param("iiiii", $usuario_id, $perfil_publico, $permitir_comentarios, $notificaciones_email, $notificaciones_push);
    }
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Configuración actualizada correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar configuración: ' . $stmt->error
        ]);
    }
    
    $stmt->close();
}

function updateProfile($conexion, $usuario_id) {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    
    if (empty($nombre) || empty($apellido)) {
        echo json_encode(['success' => false, 'message' => 'Nombre y apellido son requeridos']);
        return;
    }
    
    $sql = "UPDATE usuario SET nombre = ?, apellido = ?, bio = ? WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $apellido, $bio, $usuario_id);
    
    if ($stmt->execute()) {
        // Actualizar sesión
        $_SESSION['usuario_nombre'] = $nombre;
        $_SESSION['usuario_apellido'] = $apellido;
        
        echo json_encode([
            'success' => true,
            'message' => 'Perfil actualizado correctamente',
            'user' => [
                'nombre' => $nombre,
                'apellido' => $apellido,
                'bio' => $bio,
                'avatar' => strtoupper(substr($nombre, 0, 1))
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar perfil: ' . $stmt->error
        ]);
    }
    
    $stmt->close();
}

function changePassword($conexion, $usuario_id) {
    $password_actual = $_POST['password_actual'] ?? '';
    $password_nueva = $_POST['password_nueva'] ?? '';
    $password_confirmar = $_POST['password_confirmar'] ?? '';
    
    if (empty($password_actual) || empty($password_nueva) || empty($password_confirmar)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
        return;
    }
    
    if ($password_nueva !== $password_confirmar) {
        echo json_encode(['success' => false, 'message' => 'Las contraseñas nuevas no coinciden']);
        return;
    }
    
    if (strlen($password_nueva) < 6) {
        echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
        return;
    }
    
    // Verificar contraseña actual
    $sql = "SELECT contraseña FROM usuario WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
    
    if (!password_verify($password_actual, $usuario['contraseña'])) {
        echo json_encode(['success' => false, 'message' => 'La contraseña actual es incorrecta']);
        return;
    }
    
    // Actualizar contraseña
    $password_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
    $update_sql = "UPDATE usuario SET contraseña = ? WHERE id_usuario = ?";
    $stmt = $conexion->prepare($update_sql);
    $stmt->bind_param("si", $password_hash, $usuario_id);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Contraseña cambiada correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al cambiar contraseña'
        ]);
    }
    
    $stmt->close();
}

$conexion->close();
?>