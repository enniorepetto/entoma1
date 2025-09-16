<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $email = mysqli_real_escape_string($conexion, $_POST['correo']);
    $pass = $_POST['contraseña'];

    // Preparar consulta (corregido el nombre de tabla)
    $sql = "SELECT * FROM usuario WHERE correo = ? AND borrado = 0";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificar contraseña (corregido el nombre del campo)
        if (password_verify($pass, $usuario['contraseña'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_email'] = $usuario['correo'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            
            echo "<script>alert('Bienvenido " . $usuario['nombre'] . "'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('El correo no existe'); window.history.back();</script>";
    }

    $stmt->close();
}
$conexion->close();
?>