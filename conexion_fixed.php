<?php
$servername = "localhost";  
$username = "root";  
$password = "";
$database = "entoma"; 

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $database);

// Configurar charset
$conexion->set_charset("utf8");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>