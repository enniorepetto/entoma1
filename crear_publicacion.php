<?php
session_start();
include("conexion.php");

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Debes iniciar sesión'); window.location='dashboard.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // DEBUG: Ver qué llegó
    echo "<h2>DEBUG - Datos recibidos:</h2>";
    echo "<pre>";
    echo "POST datos:\n";
    print_r($_POST);
    echo "\n\nFILES datos:\n";
    print_r($_FILES);
    echo "</pre>";
    
    // Verificar si llegó el archivo
    if (!isset($_FILES["foto"])) {
        echo "<script>alert('No se recibió ningún archivo'); window.history.back();</script>";
        exit();
    }
    
    if ($_FILES["foto"]["error"] != 0) {
        $error_msg = "";
        switch($_FILES["foto"]["error"]) {
            case 1: $error_msg = "El archivo excede upload_max_filesize en php.ini"; break;
            case 2: $error_msg = "El archivo excede MAX_FILE_SIZE"; break;
            case 3: $error_msg = "El archivo se subió parcialmente"; break;
            case 4: $error_msg = "No se subió ningún archivo"; break;
            case 6: $error_msg = "Falta carpeta temporal"; break;
            case 7: $error_msg = "Error al escribir en disco"; break;
            case 8: $error_msg = "Extensión PHP bloqueó la subida"; break;
            default: $error_msg = "Error desconocido: " . $_FILES["foto"]["error"];
        }
        echo "<script>alert('Error al subir: " . $error_msg . "'); window.history.back();</script>";
        exit();
    }
    
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion'] ?? '');
    $etiquetas = mysqli_real_escape_string($conexion, $_POST['etiquetas'] ?? '');
    $ubicacion = mysqli_real_escape_string($conexion, $_POST['ubicacion'] ?? '');
    $usuario_id = $_SESSION['usuario_id'];
    
    $directorio = "uploads/publicaciones/";
    
    // Crear carpeta si no existe
    if (!is_dir($directorio)) {
        echo "<p>Creando directorio: $directorio</p>";
        if (!mkdir($directorio, 0777, true)) {
            echo "<script>alert('No se pudo crear la carpeta uploads. Créala manualmente.'); window.history.back();</script>";
            exit();
        }
        echo "<p>✓ Directorio creado</p>";
    } else {
        echo "<p>✓ Directorio ya existe</p>";
    }
    
    // Verificar permisos
    if (!is_writable($directorio)) {
        echo "<script>alert('La carpeta uploads no tiene permisos de escritura'); window.history.back();</script>";
        exit();
    }
    echo "<p>✓ Directorio tiene permisos de escritura</p>";
    
    // Verificar imagen
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if($check === false) {
        echo "<script>alert('El archivo no es una imagen válida'); window.history.back();</script>";
        exit();
    }
    echo "<p>✓ Es una imagen válida: " . $check['mime'] . "</p>";
    
    // Verificar tamaño
    $size_mb = $_FILES["foto"]["size"] / 1024 / 1024;
    echo "<p>Tamaño: " . number_format($size_mb, 2) . " MB</p>";
    
    if ($_FILES["foto"]["size"] > 5000000) {
        echo "<script>alert('Imagen muy grande (max 5MB)'); window.history.back();</script>";
        exit();
    }
    
    $extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
    $foto_nombre = "outfit_" . $usuario_id . "_" . time() . "." . $extension;
    $ruta_archivo = $directorio . $foto_nombre;
    
    echo "<p>Intentando guardar en: $ruta_archivo</p>";
    
    if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta_archivo)) {
        echo "<script>alert('Error al mover el archivo'); window.history.back();</script>";
        exit();
    }
    
    echo "<p>✓ Archivo guardado exitosamente</p>";
    
    // Insertar en BD
    $fecha_creacion = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO publicaciones (titulo, descripcion, foto, etiquetas, ubicacion, id_usuario, fecha_creacion, likes, comentarios, activo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 0, 0, 1)";
    
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        echo "<p>Error preparando query: " . mysqli_error($conexion) . "</p>";
        if (file_exists($ruta_archivo)) unlink($ruta_archivo);
        exit();
    }
    
    $stmt->bind_param("sssssis", $titulo, $descripcion, $foto_nombre, $etiquetas, $ubicacion, $usuario_id, $fecha_creacion);
    
    if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
    }  else {
        echo "<p>Error al guardar: " . $stmt->error . "</p>";
        if (file_exists($ruta_archivo)) unlink($ruta_archivo);
    }
    
    $stmt->close();
    $conexion->close();
    }
?>