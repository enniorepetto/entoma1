<?php
include("auth_check.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $bio = mysqli_real_escape_string($conexion, $_POST['bio'] ?? '');
    $usuario_id = $_SESSION['usuario_id'];
    
    // Configuraciones de privacidad
    $perfil_publico = isset($_POST['perfil_publico']) ? 1 : 0;
    $permitir_comentarios = isset($_POST['permitir_comentarios']) ? 1 : 0;
    $notificaciones_email = isset($_POST['notificaciones_email']) ? 1 : 0;
    
    // Actualizar información básica del usuario
    $sql = "UPDATE usuario SET nombre = ?, apellido = ? WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $apellido, $usuario_id);
    
    if ($stmt->execute()) {
        // Actualizar variables de sesión
        $_SESSION['usuario_nombre'] = $nombre;
        
        // Aquí podrías agregar las configuraciones de privacidad a una tabla separada
        // Por ahora solo mostramos mensaje de éxito
        
        echo "<script>
                alert('Perfil actualizado correctamente');
                window.location='dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al actualizar el perfil: " . mysqli_error($conexion) . "');
                window.history.back();
              </script>";
    }
    
    $stmt->close();
} else {
    header("Location: dashboard.php");
    exit();
}

$conexion->close();
?>