<?php
session_start();
include("conexion.php");

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch($action) {
    case 'login':
        handleLogin($conexion);
        break;
    case 'register':
        handleRegister($conexion);
        break;
    case 'logout':
        handleLogout();
        break;
    case 'check_session':
        checkSession();
        break;
    default:
        echo json_encode(['error' => 'Acción no válida']);
}

function handleLogin($conexion) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email y contraseña son requeridos']);
        return;
    }
    
    $sql = "SELECT * FROM usuario WHERE correo = ? AND borrado = 0";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos']);
        return;
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        if (password_verify($password, $usuario['contraseña'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_email'] = $usuario['correo'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_apellido'] = $usuario['apellido'];
            
            echo json_encode([
                'success' => true,
                'message' => 'Login exitoso',
                'user' => [
                    'id' => $usuario['id_usuario'],
                    'email' => $usuario['correo'],
                    'nombre' => $usuario['nombre'],
                    'apellido' => $usuario['apellido'],
                    'avatar' => strtoupper(substr($usuario['nombre'], 0, 1))
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    }
    
    $stmt->close();
}

function handleRegister($conexion) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    
    if (empty($email) || empty($password) || empty($nombre) || empty($apellido)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
        return;
    }
    
    // Verificar si el email ya existe
    $sql = "SELECT id_usuario FROM usuario WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'El email ya está registrado']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Crear nuevo usuario
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $fecha_alta = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO usuario (nombre, apellido, correo, contraseña, fecha_alta, borrado) VALUES (?, ?, ?, ?, ?, 0)";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos']);
        return;
    }
    
    $stmt->bind_param("sssss", $nombre, $apellido, $email, $password_hash, $fecha_alta);
    
    if ($stmt->execute()) {
        $usuario_id = $conexion->insert_id;
        
        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['usuario_email'] = $email;
        $_SESSION['usuario_nombre'] = $nombre;
        $_SESSION['usuario_apellido'] = $apellido;
        
        echo json_encode([
            'success' => true,
            'message' => 'Usuario registrado exitosamente',
            'user' => [
                'id' => $usuario_id,
                'email' => $email,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'avatar' => strtoupper(substr($nombre, 0, 1))
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar usuario']);
    }
    
    $stmt->close();
}

function handleLogout() {
    session_destroy();
    echo json_encode(['success' => true, 'message' => 'Logout exitoso']);
}

function checkSession() {
    if (isset($_SESSION['usuario_id'])) {
        echo json_encode([
            'logged_in' => true,
            'user' => [
                'id' => $_SESSION['usuario_id'],
                'email' => $_SESSION['usuario_email'],
                'nombre' => $_SESSION['usuario_nombre'],
                'apellido' => $_SESSION['usuario_apellido'] ?? '',
                'avatar' => strtoupper(substr($_SESSION['usuario_nombre'], 0, 1))
            ]
        ]);
    } else {
        echo json_encode(['logged_in' => false]);
    }
}

$conexion->close();
?>