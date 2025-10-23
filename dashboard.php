<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entoma - Tu estilo, tu comunidad</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;

        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: #ffffff;
            border-right: 1px solid #e1e5e9;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
        width: 90px;
        height: 90px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        overflow: hidden;
        }

        .logo-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;

        }

        .logo h1 {
            font-size: 24px;
            font-weight: 700;
            color: #111;
            margin-bottom: 4px;
        }

        .logo p {
            font-size: 12px;
            color: #767676;
        }

        .menu {
            margin-bottom: 40px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            text-decoration: none;
            color: #111;
            border-radius: 24px;
            margin-bottom: 4px;
            transition: background-color 0.2s ease;
            font-weight: 500;
            cursor: pointer;
        }

        .menu-item:hover {
            background-color: #f1f3f4;
        }

        .menu-item.active {
            background-color: #111;
            color: #ffffff;
        }

        .menu-item .icon {
            margin-right: 16px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 24px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .user-info:hover {
            background-color: #f1f3f4;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, #e91e63, #9c27b0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 12px;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
        }

        .user-handle {
            font-size: 12px;
            color: #767676;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: 240px;
            padding: 20px;
            overflow-y: auto;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .header {
            margin-bottom: 24px;
        }

        .header h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            color: #767676;
            font-size: 16px;
        }

        .search-bar {
            margin-bottom: 32px;
        }

        .search-bar input {
            width: 100%;
            max-width: 500px;
            padding: 12px 20px;
            border: 1px solid #e1e5e9;
            border-radius: 24px;
            font-size: 16px;
            background-color: #f8f9fa;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #1976d2;
            background-color: #ffffff;
        }

        /* FEED GRID */
        .feed-grid, .explore-grid, .trending-grid, .profile-grid {
            columns: 4;
            column-gap: 16px;
            margin: 0 -8px;
        }

        .post-card {
            break-inside: avoid;
            margin: 0 8px 16px;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }

        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .post-image {
            width: 100%;
            height: auto;
            display: block;
            background-color: #f1f3f4;
        }

        .post-content {
            padding: 12px 16px;
        }

        .post-title {
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .post-user {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .post-user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: linear-gradient(45deg, #e91e63, #9c27b0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
            margin-right: 8px;
        }

        .post-user-name {
            font-weight: 500;
            font-size: 14px;
        }

        .post-description {
            color: #767676;
            font-size: 14px;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .post-tags {
            margin-bottom: 8px;
        }

        .tag {
            display: inline-block;
            background-color: #f1f3f4;
            color: #333;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-right: 4px;
            margin-bottom: 4px;
        }

        .post-stats {
            display: flex;
            align-items: center;
            gap: 16px;
            color: #767676;
            font-size: 14px;
        }

        .post-stats span {
            cursor: pointer;
            transition: color 0.2s;
        }

        .post-stats span:hover {
            color: #111;
        }

        /* LOGIN OVERLAY */
        .login-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .login-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .login-modal {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            max-width: 800px;
            width: 90%;
            max-height: 90vh;
            display: flex;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .login-left {
            flex: 1;
            background: linear-gradient(45deg, #e91e63, #9c27b0);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        .login-left::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="3" fill="rgba(255,255,255,0.1)"/><circle cx="60" cy="30" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="30" cy="70" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.3;
        }

        .login-decoration {
            color: white;
            text-align: center;
            z-index: 1;
        }

        .login-decoration h2 {
            font-size: 28px;
            margin-bottom: 16px;
        }

        .login-decoration p {
            opacity: 0.9;
            font-size: 16px;
        }

        .login-right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h3 {
            margin-bottom: 24px;
            font-size: 24px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #e91e63;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #e91e63, #9c27b0);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 20px;
            transition: transform 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            transform: none;
            cursor: not-allowed;
        }

        .login-switch {
            text-align: center;
            color: #767676;
            font-size: 14px;
        }

        .login-switch a {
            color: #e91e63;
            text-decoration: none;
            font-weight: 600;
        }

        .close-login {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .error-message {
            color: #e53e3e;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }

        .success-message {
            color: #38a169;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }

        /* CREATE FORM */
        .create-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .upload-area {
            border: 2px dashed #e1e5e9;
            border-radius: 16px;
            padding: 48px 24px;
            text-align: center;
            margin-bottom: 24px;
            cursor: pointer;
            transition: border-color 0.2s ease;
        }

        .upload-area:hover {
            border-color: #1976d2;
        }

        .upload-icon {
            font-size: 32px;
            margin-bottom: 16px;
        }

        .upload-hint {
            color: #767676;
            font-size: 14px;
            margin-top: 8px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            resize: vertical;
            min-height: 100px;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #1976d2;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .btn-secondary {
            padding: 12px 24px;
            background-color: #ffffff;
            color: #111;
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-secondary:hover {
            background-color: #f1f3f4;
        }

        /* LOADING STATES */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: #767676;
        }

        .loading::after {
            content: "Cargando...";
            animation: loading-dots 1.5s infinite;
        }

        @keyframes loading-dots {
            0% { content: "Cargando"; }
            25% { content: "Cargando."; }
            50% { content: "Cargando.."; }
            75% { content: "Cargando..."; }
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-right: none;
                border-bottom: 1px solid #e1e5e9;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .menu {
                display: flex;
                overflow-x: auto;
                gap: 8px;
            }
            
            .menu-item {
                flex-shrink: 0;
                margin-bottom: 0;
                margin-right: 8px;
                padding: 8px 16px;
                white-space: nowrap;
            }
            
            .feed-grid, .explore-grid, .trending-grid {
                columns: 2;
            }
            
            .login-modal {
                flex-direction: column;
                max-height: 85vh;
                overflow-y: auto;
            }
        }

        .logout-btn {
            margin-top: 20px;
            padding: 8px 16px;
            background: none;
            border: 1px solid #e1e5e9;
            border-radius: 20px;
            color: #767676;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: #f1f3f4;
        }
    </style>
</head>
<body>
    <!-- Login Overlay -->
    <div id="loginOverlay" class="login-overlay">
        <div class="login-modal">
            <button class="close-login" onclick="closeLogin()">&times;</button>
            <div class="login-left">
                <div class="login-decoration">
                    <h2>Bienvenido a Entoma</h2>
                    <p>Descubre, comparte y conecta con la comunidad de moda más creativa</p>
                </div>
            </div>
            <div class="login-right">
                <div class="login-form">
                    <h3 id="formTitle">Iniciar Sesión</h3>
                    <div id="errorMessage" class="error-message" style="display: none;"></div>
                    <div id="successMessage" class="success-message" style="display: none;"></div>
                    <form id="authForm">
                        <div class="form-group">
                            <input type="email" id="email" placeholder="Correo electrónico" required>
                        </div>
                        <div class="form-group" id="nameGroup" style="display: none;">
                            <input type="text" id="nombre" placeholder="Nombre">
                        </div>
                        <div class="form-group" id="lastNameGroup" style="display: none;">
                            <input type="text" id="apellido" placeholder="Apellido">
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" placeholder="Contraseña" required>
                        </div>
                        <button type="submit" class="btn-primary" id="submitBtn">Iniciar Sesión</button>
                    </form>
                    <div class="login-switch">
                        <span id="switchText">¿No tienes cuenta?</span>
                        <a href="#" id="switchLink" onclick="toggleForm()">Regístrate</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
            <div class="logo-icon">
            <img src="logo.png" alt="Entoma Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
</div>
                <h1>Entoma</h1>
                <p>Tu estilo, tu comunidad</p>
            </div>
            
            <nav class="menu">
                <div class="menu-item active" data-section="feed">
                    <span class="icon">🏠</span>
                    Inicio
                </div>
                <div class="menu-item" data-section="explore">
                    <span class="icon">🔍</span>
                    Explorar
                </div>
                <div class="menu-item" data-section="create" onclick="showLoginIfNeeded()">
                    <span class="icon">+</span>
                    Crear
                </div>
                <div class="menu-item" data-section="notifications" onclick="showLoginIfNeeded()">
                    <span class="icon">🔔</span>
                    Notificaciones
                </div>
                <div class="menu-item" data-section="trending">
                    <span class="icon">📈</span>
                    Tendencia
                </div>
                <div class="menu-item" data-section="config" onclick="showLoginIfNeeded()">
                    <span class="icon">⚙️</span>
                    Configuración
                </div>
            </nav>

            <div class="user-info" id="userInfo" style="display: none;">
                <div class="user-avatar" id="userAvatar">U</div>
                <div class="user-details">
                    <span class="user-name" id="userName">Usuario</span>
                    <span class="user-handle" id="userHandle">@usuario</span>
                </div>
            </div>

            <div class="user-info" id="guestInfo" onclick="showLogin()">
                <div class="user-avatar">👤</div>
                <div class="user-details">
                    <span class="user-name">Invitado</span>
                    <span class="user-handle">Haz clic para iniciar sesión</span>
                </div>
            </div>

            <button class="logout-btn" id="logoutBtn" onclick="logout()" style="display: none;">
                Cerrar Sesión
            </button>
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
                    <div class="loading"></div>
                </div>
            </section>

            <!-- Explore Section -->
            <section id="explore" class="content-section">
                <div class="header">
                    <h2>Explorar</h2>
                    <p>Descubre nuevos estilos y tendencias</p>
                </div>
                <div class="explore-grid" id="exploreGrid">
                    <div class="loading"></div>
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
                        
                        <input type="hidden" name="usuario_id" id="usuarioIdInput">
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="saveDraft()">Guardar borrador</button>
                            <button type="submit" class="btn-primary">Publicar outfit</button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Trending Section -->
            <section id="trending" class="content-section">
                <div class="header">
                    <h2>Tendencia</h2>
                    <p>Los outfits más populares del momento</p>
                </div>
                <div class="trending-grid" id="trendingGrid">
                    <div class="loading"></div>
                </div>
            </section>
        </main>
    </div>

    <script>
        let isLoggedIn = false;
        let currentUser = null;
        let isLoginMode = true;

        // Inicialización
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Inicializando dashboard...');
            setupNavigation();
            setupCreateForm();
            checkSession();
            loadFeedPosts();
        });

        // Verificar sesión al cargar
        async function checkSession() {
            try {
                const response = await fetch('auth_api.php?action=check_session');
                const data = await response.json();
                
                if (data.logged_in) {
                    isLoggedIn = true;
                    currentUser = data.user;
                    updateUserInterface();
                } else {
                    isLoggedIn = false;
                    currentUser = null;
                    updateUserInterface();
                    // Mostrar login después de un breve retraso para mejor UX
                    setTimeout(() => {
                        showLogin();
                    }, 1000);
                }
            } catch (error) {
                console.error('Error checking session:', error);
                updateUserInterface();
            }
        }

        // Navegación
        function setupNavigation() {
            const menuItems = document.querySelectorAll('.menu-item');
            
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    const section = this.getAttribute('data-section');
                    if (section) {
                        // Actualizar menu activo
                        menuItems.forEach(mi => mi.classList.remove('active'));
                        this.classList.add('active');
                        
                        // Mostrar sección
                        showSection(section);
                    }
                });
            });
        }

        function showSection(sectionName) {
            // Ocultar todas las secciones
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => section.classList.remove('active'));
            
            // Mostrar sección objetivo
            const targetSection = document.getElementById(sectionName);
            if (targetSection) {
                targetSection.classList.add('active');
                
                // Cargar contenido según sección
                if (sectionName === 'explore') loadExplorePosts();
                if (sectionName === 'trending') loadTrendingPosts();
            }
        }

        // Funciones de login
        function showLogin() {
            document.getElementById('loginOverlay').classList.add('active');
        }

        function closeLogin() {
                document.getElementById('loginOverlay').classList.remove('active');
        }

        function showLoginIfNeeded() {
            if (!isLoggedIn) {
                showLogin();
                return false;
            }
            return true;
        }

        function toggleForm() {
            isLoginMode = !isLoginMode;
            const formTitle = document.getElementById('formTitle');
            const submitBtn = document.getElementById('submitBtn');
            const switchText = document.getElementById('switchText');
            const switchLink = document.getElementById('switchLink');
            const nameGroup = document.getElementById('nameGroup');
            const lastNameGroup = document.getElementById('lastNameGroup');

            if (isLoginMode) {
                formTitle.textContent = 'Iniciar Sesión';
                submitBtn.textContent = 'Iniciar Sesión';
                switchText.textContent = '¿No tienes cuenta?';
                switchLink.textContent = 'Regístrate';
                nameGroup.style.display = 'none';
                lastNameGroup.style.display = 'none';
            } else {
                formTitle.textContent = 'Crear Cuenta';
                submitBtn.textContent = 'Crear Cuenta';
                switchText.textContent = '¿Ya tienes cuenta?';
                switchLink.textContent = 'Inicia Sesión';
                nameGroup.style.display = 'block';
                lastNameGroup.style.display = 'block';
            }
        }

        function showMessage(message, type = 'error') {
            const errorDiv = document.getElementById('errorMessage');
            const successDiv = document.getElementById('successMessage');
            
            // Ocultar ambos mensajes
            errorDiv.style.display = 'none';
            successDiv.style.display = 'none';
            
            // Mostrar el mensaje apropiado
            if (type === 'error') {
                errorDiv.textContent = message;
                errorDiv.style.display = 'block';
            } else {
                successDiv.textContent = message;
                successDiv.style.display = 'block';
            }
            
            // Ocultar después de 5 segundos
            setTimeout(() => {
                errorDiv.style.display = 'none';
                successDiv.style.display = 'none';
            }, 5000);
        }

        // Manejo del formulario de auth
        document.getElementById('authForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const nombre = document.getElementById('nombre').value;
            const apellido = document.getElementById('apellido').value;

            if (isLoginMode) {
                login(email, password);
            } else {
                register(email, password, nombre, apellido);
            }
        });

        async function login(email, password) {
            try {
                const formData = new FormData();
                formData.append('action', 'login');
                formData.append('email', email);
                formData.append('password', password);
                
                const response = await fetch('auth_api.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    isLoggedIn = true;
                    currentUser = data.user;
                    updateUserInterface();
                    closeLogin();
                    showMessage('¡Bienvenido de vuelta!', 'success');
                    loadFeedPosts(); // Recargar feed con datos del usuario
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                console.error('Error en login:', error);
                showMessage('Error de conexión. Intenta de nuevo.', 'error');
            } finally {
                document.getElementById('submitBtn').disabled = false;
            }
        }

        async function register(email, password, nombre, apellido) {
            if (!nombre || !apellido) {
                showMessage('Todos los campos son requeridos', 'error');
                document.getElementById('submitBtn').disabled = false;
                return;
            }
            
            try {
                const formData = new FormData();
                formData.append('action', 'register');
                formData.append('email', email);
                formData.append('password', password);
                formData.append('nombre', nombre);
                formData.append('apellido', apellido);
                
                const response = await fetch('auth_api.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    isLoggedIn = true;
                    currentUser = data.user;
                    updateUserInterface();
                    closeLogin();
                    showMessage('¡Cuenta creada exitosamente!', 'success');
                    loadFeedPosts();
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                console.error('Error en registro:', error);
                showMessage('Error de conexión. Intenta de nuevo.', 'error');
            } finally {
                document.getElementById('submitBtn').disabled = false;
            }
        }

        async function logout() {
            try {
                await fetch('auth_api.php?action=logout');
                isLoggedIn = false;
                currentUser = null;
                updateUserInterface();
                showLogin();
            } catch (error) {
                console.error('Error en logout:', error);
            }
        }

        function updateUserInterface() {
            if (isLoggedIn && currentUser) {
                document.getElementById('userInfo').style.display = 'flex';
                document.getElementById('guestInfo').style.display = 'none';
                document.getElementById('logoutBtn').style.display = 'block';
                
                document.getElementById('userAvatar').textContent = currentUser.avatar;
                document.getElementById('userName').textContent = currentUser.nombre;
                document.getElementById('userHandle').textContent = '@' + currentUser.email.split('@')[0];
                document.getElementById('usuarioIdInput').value = currentUser.id;
            } else {
                document.getElementById('userInfo').style.display = 'none';
                document.getElementById('guestInfo').style.display = 'flex';
                document.getElementById('logoutBtn').style.display = 'none';
            }
        }

        // Funciones para cargar posts
        async function loadFeedPosts() {
            const feedGrid = document.getElementById('feedGrid');
            feedGrid.innerHTML = '<div class="loading"></div>';
            
            try {
                const response = await fetch('api_posts.php?action=feed');
                const posts = await response.json();
                
                if (posts.error) {
                    throw new Error(posts.error);
                }
                
                feedGrid.innerHTML = '';
                
                if (posts.length === 0) {
                    feedGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #767676;">No hay publicaciones disponibles.</div>';
                    return;
                }
                
                posts.forEach(post => {
                    const postElement = createPostCard(post);
                    feedGrid.appendChild(postElement);
                });
                
            } catch (error) {
                console.error('Error cargando feed:', error);
                feedGrid.innerHTML = `
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #767676;">
                        Error al cargar las publicaciones<br>
                        <button onclick="loadFeedPosts()" style="margin-top: 10px; padding: 8px 16px; background: #111; color: white; border: none; border-radius: 8px; cursor: pointer;">Reintentar</button>
                    </div>
                `;
            }
        }

        async function loadExplorePosts() {
            const exploreGrid = document.getElementById('exploreGrid');
            exploreGrid.innerHTML = '<div class="loading"></div>';
            
            try {
                const response = await fetch('api_posts.php?action=explore');
                const posts = await response.json();
                
                exploreGrid.innerHTML = '';
                
                posts.forEach(post => {
                    const postElement = createPostCard(post);
                    exploreGrid.appendChild(postElement);
                });
                
            } catch (error) {
                console.error('Error cargando explore:', error);
                exploreGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #767676;">Error al cargar contenido</div>';
            }
        }

        async function loadTrendingPosts() {
            const trendingGrid = document.getElementById('trendingGrid');
            trendingGrid.innerHTML = '<div class="loading"></div>';
            
            try {
                const response = await fetch('api_posts.php?action=trending');
                const posts = await response.json();
                
                trendingGrid.innerHTML = '';
                
                posts.forEach((post, index) => {
                    const postElement = createPostCard(post, index < 3);
                    trendingGrid.appendChild(postElement);
                });
                
            } catch (error) {
                console.error('Error cargando trending:', error);
                trendingGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #767676;">Error al cargar tendencias</div>';
            }
        }

        function createPostCard(post, isTrending = false) {
            const card = document.createElement('div');
            card.className = 'post-card';
            
            const trendingBadge = isTrending ? 
                '<div style="background: linear-gradient(45deg, #ff6b6b, #feca57); color: white; padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: bold; margin-bottom: 8px; text-align: center;">🔥 Trending</div>' : '';
            
            const tags = Array.isArray(post.tags) ? post.tags : 
                         (post.tags ? String(post.tags).split(',').map(tag => tag.trim()) : []);
            
            card.innerHTML = `
                ${trendingBadge}
                <img src="${post.image}" alt="${post.title}" class="post-image" 
                     onerror="this.src='https://via.placeholder.com/300x400/f1f3f4/767676?text=Imagen+no+disponible'">
                <div class="post-content">
                    <h3 class="post-title">${post.title}</h3>
                    <div class="post-user">
                        <div class="post-user-avatar">${post.user_avatar}</div>
                        <span class="post-user-name">${post.user}</span>
                    </div>
                    ${post.description ? `<p class="post-description">${post.description.substring(0, 100)}${post.description.length > 100 ? '...' : ''}</p>` : ''}
                    <div class="post-tags">
                        ${tags.map(tag => `<span class="tag">#${tag}</span>`).join('')}
                    </div>
                    <div class="post-stats">
                        <span onclick="likePost(${post.id})" style="cursor: pointer;">❤️ ${post.likes}</span>
                        <span onclick="showLoginIfNeeded()">💬 ${post.comments}</span>
                        <span onclick="showLoginIfNeeded()">🔖</span>
                    </div>
                </div>
            `;
            
            return card;
        }

        // Configurar formulario de creación
        function setupCreateForm() {
            const uploadArea = document.querySelector('.upload-area');
            const fileInput = document.getElementById('foto');
            
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        handleFileSelect(e.target.files[0]);
                    }
                });
            }
            
            if (uploadArea) {
                uploadArea.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.style.borderColor = '#1976d2';
                });
                
                uploadArea.addEventListener('dragleave', function() {
                    this.style.borderColor = '#e1e5e9';
                });
                
                uploadArea.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.style.borderColor = '#e1e5e9';
                    
                    const files = e.dataTransfer.files;
                    if (files.length > 0 && fileInput) {
                        fileInput.files = files;
                        handleFileSelect(files[0]);
                    }
                });
            }
        }

        function handleFileSelect(file) {
            const uploadArea = document.querySelector('.upload-area');
            if (!uploadArea) return;
            
            if (!file.type.startsWith('image/')) {
                alert('Por favor selecciona una imagen válida');
                return;
            }
            
            if (file.size > 5000000) {
                alert('La imagen es demasiado grande (máximo 5MB)');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadArea.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" 
                         style="max-width: 100%; max-height: 200px; border-radius: 8px; object-fit: cover;">
                    <p style="margin-top: 12px; font-weight: 500;">Imagen seleccionada: ${file.name}</p>
                    <p class="upload-hint">Haz clic para cambiar la imagen</p>
                `;
            };
            reader.readAsDataURL(file);
        }

        // Funciones de interacción
        function likePost(postId) {
            if (!showLoginIfNeeded()) return;
            
            // Aquí podrías hacer una llamada al backend para guardar el like
            console.log('Like post:', postId);
            
            // Por ahora solo mostramos un mensaje
            const heartSpan = event.target;
            heartSpan.style.color = '#e91e63';
            
            // Incrementar contador visualmente
            const currentLikes = parseInt(heartSpan.textContent.replace('❤️ ', ''));
            heartSpan.textContent = '❤️ ' + (currentLikes + 1);
        }

        function saveDraft() {
            if (!showLoginIfNeeded()) return;
            alert('Función de guardar borrador en desarrollo');
        }

        // Búsqueda
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const posts = document.querySelectorAll('.post-card');
            
            posts.forEach(post => {
                const title = post.querySelector('.post-title').textContent.toLowerCase();
                const tags = Array.from(post.querySelectorAll('.tag')).map(tag => tag.textContent.toLowerCase());
                const description = post.querySelector('.post-description');
                const descText = description ? description.textContent.toLowerCase() : '';
                
                if (title.includes(searchTerm) || 
                    tags.some(tag => tag.includes(searchTerm)) || 
                    descText.includes(searchTerm)) {
                    post.style.display = 'block';
                } else {
                    post.style.display = 'none';
                }
            });
        });
        // Cerrar modal al hacer click fuera
        document.getElementById('loginOverlay').addEventListener('click', function(e) {
             if (e.target === this) {
        closeLogin();
            }
        });
        // Exponer funciones necesarias globalmente
        window.showLogin = showLogin;
        window.closeLogin = closeLogin;
        window.toggleForm = toggleForm;
        window.logout = logout;
        window.showLoginIfNeeded = showLoginIfNeeded;
        window.likePost = likePost;
        window.saveDraft = saveDraft;
        window.loadFeedPosts = loadFeedPosts;
    </script>
</body>
</html>