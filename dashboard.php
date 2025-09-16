<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("auth_check.php");

include("auth_check.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entoma - Tu estilo, tu comunidad</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <div class="logo-icon">🪲</div>
                <h1>entoma</h1>
                <p>Tu estilo, tu comunidad</p>
            </div>
            
            <nav class="menu">
                <a href="#" class="menu-item active" data-section="feed">
                    <span class="icon">🏠</span>
                    Inicio
                </a>
                <a href="#" class="menu-item" data-section="explore">
                    <span class="icon">🔍</span>
                    Explorar
                </a>
                <a href="#" class="menu-item" data-section="create">
                    <span class="icon">+</span>
                    Crear
                </a>
                <a href="#" class="menu-item" data-section="notifications">
                    <span class="icon">🔔</span>
                    Notificaciones
                </a>
                <a href="#" class="menu-item" data-section="trending">
                    <span class="icon">📈</span>
                    Tendencia
                </a>
                <a href="#" class="menu-item" data-section="config">
                    <span class="icon">⚙️</span>
                    Configuración
                </a>
            </nav>

            <div class="user-info" onclick="openProfileModal()">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($usuario_actual['nombre'], 0, 1)); ?>
                </div>
                <div class="user-details">
                    <span class="user-name"><?php echo htmlspecialchars($usuario_actual['nombre']); ?></span>
                    <span class="user-handle">@<?php echo htmlspecialchars(explode('@', $usuario_actual['correo'])[0]); ?></span>
                </div>
            </div>
            
            <div class="logout-btn">
                <a href="logout.php" style="color: #767676; text-decoration: none; font-size: 12px;">Cerrar sesión</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Feed Section -->
            <section id="feed" class="content-section active">
                <div class="header">
                    <h2>Tu Feed</h2>
                    <p>Descubre los últimos outfits de las personas que sigues</p>
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Buscar outfits, estilos..." id="searchInput">
                </div>
                <div class="feed-grid" id="feedGrid">
                    <!-- Los posts se cargarán aquí dinámicamente -->
                </div>
            </section>

            <!-- Explore Section -->
            <section id="explore" class="content-section">
                <div class="header">
                    <h2>Explorar</h2>
                    <p>Descubre nuevos estilos y tendencias</p>
                </div>
                <div class="explore-content">
                    <div class="category-filters">
                        <button class="filter-btn active">Todos</button>
                        <button class="filter-btn">Casual</button>
                        <button class="filter-btn">Elegante</button>
                        <button class="filter-btn">Street</button>
                        <button class="filter-btn">Trabajo</button>
                    </div>
                    <div class="explore-grid" id="exploreGrid">
                        <!-- Los posts de explorar se cargarán aquí -->
                    </div>
                </div>
            </section>

            <!-- Create Section -->
            <section id="create" class="content-section">
                <div class="header">
                    <h2>Crear Outfit</h2>
                    <p>Comparte tu estilo con la comunidad</p>
                </div>
                <div class="create-form">
                    <form id="createOutfitForm" action="crear_publicacion.php" method="POST" enctype="multipart/form-data">
                        <div class="upload-area" onclick="document.getElementById('foto').click()">
                            <div class="upload-placeholder">
                                <div class="upload-icon">⬆️</div>
                                <p>Sube tu foto de outfit</p>
                                <p class="upload-hint">Arrastra y suelta tu imagen aquí, o haz clic para seleccionar</p>
                            </div>
                            <input type="file" id="foto" name="foto" accept="image/*" style="display: none;" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="titulo">Título del outfit</label>
                            <input type="text" id="titulo" name="titulo" placeholder="Ej: Look casual para fin de semana" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" placeholder="Cuenta la historia detrás de tu outfit, dónde lo usarías, qué te inspiró..."></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="etiquetas">Etiquetas</label>
                            <input type="text" id="etiquetas" name="etiquetas" placeholder="casual, streetwear, vintage (separado por comas)">
                        </div>
                        
                        <div class="form-group">
                            <label for="ubicacion">Ubicación (opcional)</label>
                            <input type="text" id="ubicacion" name="ubicacion" placeholder="¿Dónde tomaste esta foto?">
                        </div>
                        
                        <input type="hidden" name="usuario_id" value="<?php echo $usuario_actual['id_usuario']; ?>">
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="saveDraft()">Guardar borrador</button>
                            <button type="submit" class="btn-primary">Publicar outfit</button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Notifications Section -->
            <section id="notifications" class="content-section">
                <div class="header">
                    <h2>Notificaciones</h2>
                    <button class="mark-read-btn">Marcar todas como leídas</button>
                </div>
                <div class="notifications-list" id="notificationsList">
                    <!-- Las notificaciones se cargarán aquí -->
                </div>
            </section>

            <!-- Trending Section -->
            <section id="trending" class="content-section">
                <div class="header">
                    <h2>Tendencia</h2>
                    <p>Los outfits más populares del momento</p>
                </div>
                <div class="trending-content">
                    <div class="trending-grid" id="trendingGrid">
                        <!-- Los posts trending se cargarán aquí -->
                    </div>
                </div>
            </section>

            <!-- Config Section -->
            <section id="config" class="content-section">
                <div class="header">
                    <h2>Configuración</h2>
                    <p>Personaliza tu experiencia en Entoma</p>
                </div>
                <div class="config-content">
                    <form id="configForm" action="actualizar_perfil.php" method="POST">
                        <div class="config-section">
                            <h3>Perfil</h3>
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario_actual['nombre']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($usuario_actual['apellido']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="bio">Biografía</label>
                                <textarea id="bio" name="bio" placeholder="Cuéntanos sobre tu estilo..."></textarea>
                            </div>
                        </div>
                        
                        <div class="config-section">
                            <h3>Privacidad</h3>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="perfil_publico" checked>
                                    <span class="checkmark"></span>
                                    Perfil público
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="permitir_comentarios" checked>
                                    <span class="checkmark"></span>
                                    Permitir comentarios en mis outfits
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="notificaciones_email">
                                    <span class="checkmark"></span>
                                    Recibir notificaciones por email
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="modal">
        <div class="modal-content profile-content">
            <div class="profile-header">
                <div class="profile-banner"></div>
                <div class="profile-info">
                    <div class="profile-avatar">
                        <?php echo strtoupper(substr($usuario_actual['nombre'], 0, 1)); ?>
                    </div>
                    <div class="profile-details">
                        <h2><?php echo htmlspecialchars($usuario_actual['nombre'] . ' ' . $usuario_actual['apellido']); ?></h2>
                        <p class="profile-bio">Apasionada de la moda y el street style ✨<br>📍 <?php echo htmlspecialchars($usuario_actual['calle'] . ' ' . $usuario_actual['numero']); ?><br>💌 Colaboraciones: <?php echo htmlspecialchars($usuario_actual['correo']); ?></p>
                        <div class="profile-stats">
                            <div class="stat">
                                <span class="stat-number" id="userPosts">0</span>
                                <span class="stat-label">publicaciones</span>
                            </div>
                            <div class="stat">
                                <span class="stat-number"><?php echo $usuario_actual['seguidores']; ?></span>
                                <span class="stat-label">seguidores</span>
                            </div>
                            <div class="stat">
                                <span class="stat-number">0</span>
                                <span class="stat-label">siguiendo</span>
                            </div>
                        </div>
                        <div class="profile-categories">
                            <span class="category">C</span>
                            <span class="category">E</span>
                            <span class="category selected">S</span>
                            <span class="category">T</span>
                        </div>
                    </div>
                </div>
                <button class="close-modal" onclick="closeProfileModal()">&times;</button>
            </div>
            
            <div class="profile-tabs">
                <button class="tab-btn active" data-tab="publications">PUBLICACIONES</button>
                <button class="tab-btn" data-tab="saved">GUARDADO</button>
            </div>
            
            <div class="profile-grid" id="profilePublications">
                <!-- Las publicaciones del usuario se cargarán aquí -->
            </div>
            
            <div class="profile-grid" id="profileSaved" style="display: none;">
                <!-- Los posts guardados se cargarán aquí -->
            </div>
        </div>
    </div>

    <script>
        // Variables PHP para JavaScript
        const currentUserId = <?php echo $usuario_actual['id_usuario']; ?>;
        const currentUserName = "<?php echo htmlspecialchars($usuario_actual['nombre']); ?>";
        const currentUserEmail = "<?php echo htmlspecialchars($usuario_actual['correo']); ?>";
        
        function closeProfileModal() {
            document.getElementById('profileModal').classList.remove('active');
        }
        
        function openProfileModal() {
            document.getElementById('profileModal').classList.add('active');
            loadUserProfile();
        }
        
        function saveDraft() {
            alert('Función de guardar borrador en desarrollo');
        }
    </script>
    <script src="dashboard_simple.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard loaded');
    
    // Configurar navegación
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remover active
            menuItems.forEach(mi => mi.classList.remove('active'));
            this.classList.add('active');
            
            // Mostrar sección
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(s => s.classList.remove('active'));
            
            const sectionName = this.getAttribute('data-section');
            const targetSection = document.getElementById(sectionName);
            if (targetSection) {
                targetSection.classList.add('active');
            }
        });
    });
});
</script>
</body>
</html>