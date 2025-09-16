<?php
$servername = "localhost";  
$username = "root";  
$password = "";
$database = "entoma"; 

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $database);

// Configurar charset para evitar problemas con caracteres especiales
$conexion->set_charset("utf8mb4");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar zona horaria
$conexion->query("SET time_zone = '-03:00'");
?>