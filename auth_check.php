<?php
session_start();
include("conexion.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos del usuario actual
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuario WHERE id_usuario = ? AND borrado = 0";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    // Usuario no encontrado, cerrar sesión
    session_destroy();
    header("Location: login.php");
    exit();
}

$usuario_actual = $resultado->fetch_assoc();
$stmt->close();
?>