<?php
// test_posts.php - Archivo temporal para verificar publicaciones
session_start();
include("conexion.php");

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test de Publicaciones</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .card { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #e91e63; }
        pre { background: #f0f0f0; padding: 10px; border-radius: 4px; overflow-x: auto; }
        .success { color: #38a169; font-weight: bold; }
        .error { color: #e53e3e; font-weight: bold; }
        .info { color: #1976d2; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #e91e63; color: white; }
        img { max-width: 100px; height: auto; }
    </style>
</head>
<body>
    <h1>🔍 Diagnóstico de Publicaciones</h1>
    
    <div class="card">
        <h2>1. Conexión a Base de Datos</h2>
        <?php
        if ($conexion->connect_error) {
            echo "<p class='error'>❌ Error de conexión: " . $conexion->connect_error . "</p>";
        } else {
            echo "<p class='success'>✅ Conexión exitosa a la base de datos 'entoma'</p>";
        }
        ?>
    </div>
    
    <div class="card">
        <h2>2. Total de Publicaciones</h2>
        <?php
        $sql = "SELECT COUNT(*) as total FROM publicaciones WHERE activo = 1";
        $resultado = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_assoc($resultado);
        $total = $row['total'];
        
        if ($total > 0) {
            echo "<p class='success'>✅ Hay {$total} publicaciones activas</p>";
        } else {
            echo "<p class='error'>❌ No hay publicaciones en la base de datos</p>";
            echo "<p class='info'>💡 Necesitas crear publicaciones desde la sección 'Crear' del dashboard</p>";
        }
        ?>
    </div>
    
    <?php if ($total > 0): ?>
    <div class="card">
        <h2>3. Publicaciones con Likes</h2>
        <?php
        $sql = "SELECT 
                    p.id_publicaciones,
                    p.titulo,
                    p.likes,
                    p.comentarios,
                    p.foto,
                    u.nombre,
                    u.apellido,
                    p.fecha_creacion
                FROM publicaciones p
                JOIN usuario u ON p.id_usuario = u.id_usuario
                WHERE p.activo = 1
                ORDER BY p.likes DESC
                LIMIT 10";
        
        $resultado = mysqli_query($conexion, $sql);
        
        if (mysqli_num_rows($resultado) > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Imagen</th><th>Título</th><th>Usuario</th><th>Likes</th><th>Comentarios</th><th>Fecha</th></tr>";
            
            while ($post = mysqli_fetch_assoc($resultado)) {
                $imagePath = "uploads/publicaciones/" . $post['foto'];
                echo "<tr>";
                echo "<td>" . $post['id_publicaciones'] . "</td>";
                echo "<td><img src='{$imagePath}' alt='Preview' onerror='this.src=\"https://via.placeholder.com/100\"'></td>";
                echo "<td>" . htmlspecialchars($post['titulo']) . "</td>";
                echo "<td>" . htmlspecialchars($post['nombre'] . ' ' . $post['apellido']) . "</td>";
                echo "<td><strong>" . $post['likes'] . "</strong> ❤️</td>";
                echo "<td>" . $post['comentarios'] . " 💬</td>";
                echo "<td>" . date('d/m/Y', strtotime($post['fecha_creacion'])) . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        }
        ?>
    </div>
    
    <div class="card">
        <h2>4. Test de API (JSON)</h2>
        <p class='info'>Probando la API que usa el dashboard:</p>
        <?php
        // Simular la llamada a la API
        $sql = "SELECT p.*, u.nombre, u.apellido, u.foto as user_foto,
                (SELECT COUNT(*) FROM likes WHERE id_publicacion = p.id_publicaciones) as total_likes,
                (SELECT COUNT(*) FROM comentarios WHERE id_publicacion = p.id_publicaciones) as total_comentarios
                FROM publicaciones p 
                JOIN usuario u ON p.id_usuario = u.id_usuario 
                WHERE u.borrado = 0 AND p.activo = 1
                ORDER BY total_likes DESC, p.fecha_creacion DESC
                LIMIT 5";
        
        $resultado = mysqli_query($conexion, $sql);
        $posts = [];
        
        while ($row = mysqli_fetch_assoc($resultado)) {
            $posts[] = [
                'id' => $row['id_publicaciones'],
                'title' => $row['titulo'] ?? 'Sin título',
                'description' => $row['descripcion'] ?? '',
                'image' => 'uploads/publicaciones/' . $row['foto'],
                'likes' => (int)($row['total_likes'] ?? 0),
                'comments' => (int)($row['total_comentarios'] ?? 0)
            ];
        }
        
        echo "<pre>" . json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
        ?>
    </div>
    
    <div class="card">
        <h2>5. Crear Publicaciones de Prueba</h2>
        <?php
        if ($total == 0) {
            echo "<p class='info'>💡 ¿Quieres crear publicaciones de prueba automáticamente?</p>";
            echo "<form method='POST'>";
            echo "<button type='submit' name='crear_prueba' style='padding: 10px 20px; background: #e91e63; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px;'>Crear 5 publicaciones de prueba</button>";
            echo "</form>";
            
            if (isset($_POST['crear_prueba'])) {
                // Verificar que haya al menos un usuario
                $user_check = mysqli_query($conexion, "SELECT id_usuario FROM usuario LIMIT 1");
                if (mysqli_num_rows($user_check) > 0) {
                    $user = mysqli_fetch_assoc($user_check);
                    $user_id = $user['id_usuario'];
                    
                    $titulos = [
                        'Street Style Urbano',
                        'Elegante y Casual',
                        'Look Deportivo',
                        'Outfit de Verano',
                        'Estilo Minimalista'
                    ];
                    
                    $descripciones = [
                        'Perfecto para un día en la ciudad',
                        'Ideal para cualquier ocasión',
                        'Comodidad y estilo combinados',
                        'Fresco y moderno para días calurosos',
                        'Menos es más, simplicidad elegante'
                    ];
                    
                    $etiquetas = [
                        'streetwear,urbano,casual',
                        'elegante,casual,versatil',
                        'deportivo,comodo,activo',
                        'verano,fresco,ligero',
                        'minimalista,simple,elegante'
                    ];
                    
                    for ($i = 0; $i < 5; $i++) {
                        $likes = rand(5, 150);
                        $sql = "INSERT INTO publicaciones (titulo, descripcion, foto, etiquetas, id_usuario, fecha_creacion, likes, comentarios, activo) 
                                VALUES (?, ?, 'placeholder.jpg', ?, ?, NOW(), ?, 0, 1)";
                        $stmt = $conexion->prepare($sql);
                        $stmt->bind_param("sssii", $titulos[$i], $descripciones[$i], $etiquetas[$i], $user_id, $likes);
                        $stmt->execute();
                    }
                    
                    echo "<p class='success'>✅ Se crearon 5 publicaciones de prueba exitosamente!</p>";
                    echo "<p><a href='test_posts.php'>Recargar página</a></p>";
                } else {
                    echo "<p class='error'>❌ Necesitas crear al menos un usuario primero</p>";
                }
            }
        } else {
            echo "<p class='success'>✅ Ya tienes publicaciones. ¡El dashboard debería funcionar correctamente!</p>";
        }
        ?>
    </div>
    <?php endif; ?>
    
    <div class="card">
        <h2>6. Verificar Archivos</h2>
        <?php
        $archivos = [
            'dashboard.php' => file_exists('dashboard.php'),
            'api_posts.php' => file_exists('api_posts.php'),
            'api_interacciones.php' => file_exists('api_interacciones.php'),
            'uploads/publicaciones/' => is_dir('uploads/publicaciones/')
        ];
        
        echo "<ul>";
        foreach ($archivos as $archivo => $existe) {
            if ($existe) {
                echo "<li class='success'>✅ {$archivo} existe</li>";
            } else {
                echo "<li class='error'>❌ {$archivo} no encontrado</li>";
            }
        }
        echo "</ul>";
        
        if (!is_dir('uploads/publicaciones/')) {
            echo "<p class='info'>💡 Creando carpeta uploads/publicaciones/...</p>";
            if (mkdir('uploads/publicaciones/', 0777, true)) {
                echo "<p class='success'>✅ Carpeta creada exitosamente</p>";
            } else {
                echo "<p class='error'>❌ No se pudo crear la carpeta. Créala manualmente.</p>";
            }
        }
        ?>
    </div>
    
    <div class="card">
        <h2>✨ Siguiente Paso</h2>
        <p><strong>Volver al dashboard:</strong> <a href="dashboard.php" style="color: #e91e63; text-decoration: none; font-weight: bold;">dashboard.php</a></p>
    </div>
</body>
</html>

<?php
$conexion->close();
?>
