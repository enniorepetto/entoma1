<?php
include("auth_check.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $etiquetas = mysqli_real_escape_string($conexion, $_POST['etiquetas']);
    $ubicacion = mysqli_real_escape_string($conexion, $_POST['ubicacion']);
    $usuario_id = (int)$_POST['usuario_id'];
    
    // Verificar que el usuario_id coincida con el usuario logueado
    if ($usuario_id !== $_SESSION['usuario_id']) {
        echo "<script>alert('Error de seguridad'); window.location='dashboard.php';</script>";
        exit();
    }

    // Manejo de archivo de imagen
    $foto_nombre = null;
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
        $directorio = "uploads/publicaciones/";
        
        // Crear carpeta si no existe
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Generar nombre único para la imagen
        $extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
        $foto_nombre = "outfit_" . $usuario_id . "_" . time() . "." . $extension;
        $ruta_archivo = $directorio . $foto_nombre;

        // Verificar que sea una imagen válida
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if($check === false) {
            echo "<script>alert('El archivo no es una imagen válida'); window.history.back();</script>";
            exit();
        }

        // Verificar tamaño (máximo 5MB)
        if ($_FILES["foto"]["size"] > 5000000) {
            echo "<script>alert('La imagen es demasiado grande (máximo 5MB)'); window.history.back();</script>";
            exit();
        }

        // Mover archivo
        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta_archivo)) {
            echo "<script>alert('Error al subir la foto'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Debes seleccionar una imagen'); window.history.back();</script>";
        exit();
    }

    // Insertar en la base de datos
    $fecha_creacion = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO publicaciones (titulo, descripcion, foto, etiquetas, ubicacion, id_usuario, fecha_creacion, likes, comentarios) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 0, 0)";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssis", $titulo, $descripcion, $foto_nombre, $etiquetas, $ubicacion, $usuario_id, $fecha_creacion);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('¡Outfit publicado exitosamente!');
                window.location='dashboard.php';
              </script>";
    } else {
        // Si hay error, eliminar la imagen subida
        if (file_exists($ruta_archivo)) {
            unlink($ruta_archivo);
        }
        echo "<script>
                alert('Error al publicar el outfit: " . mysqli_error($conexion) . "');
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