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

        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --text-primary: #111;
            --text-secondary: #767676;
            --border-color: #e1e5e9;
            --hover-bg: #f1f3f4;
            --card-bg: #ffffff;
            --accent-color: #e91e63;
        }

        [data-theme="dark"] {
            --bg-primary: #1a1a1a;
            --bg-secondary: #2d2d2d;
            --text-primary: #ffffff;
            --text-secondary: #b0b0b0;
            --border-color: #3a3a3a;
            --hover-bg: #3a3a3a;
            --card-bg: #252525;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s, color 0.3s;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: var(--bg-primary);
            border-right: 1px solid var(--border-color);
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
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .logo p {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .menu {
            margin-bottom: 40px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            text-decoration: none;
            color: var(--text-primary);
            border-radius: 24px;
            margin-bottom: 4px;
            transition: background-color 0.2s ease;
            font-weight: 500;
            cursor: pointer;
        }

        .menu-item:hover {
            background-color: var(--hover-bg);
        }

        .menu-item.active {
            background-color: #111;
            color: #ffffff;
        }

        [data-theme="dark"] .menu-item.active {
            background-color: #ffffff;
            color: #111;
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
            background-color: var(--hover-bg);
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
            color: var(--text-secondary);
        }

        .logout-btn {
            margin-top: 20px;
            padding: 8px 16px;
            background: none;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
            width: 100%;
        }

        .logout-btn:hover {
            background: var(--hover-bg);
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
            color: var(--text-secondary);
            font-size: 16px;
        }

        .search-bar {
            margin-bottom: 32px;
        }

        .search-bar input {
            width: 100%;
            max-width: 500px;
            padding: 12px 20px;
            border: 1px solid var(--border-color);
            border-radius: 24px;
            font-size: 16px;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
        }

        .search-bar input:focus {
            outline: none;
            border-color: #1976d2;
            background-color: var(--bg-primary);
        }

        .feed-grid, .explore-grid, .trending-grid, .profile-grid {
            columns: 4;
            column-gap: 16px;
            margin: 0 -8px;
        }

        .post-card {
            break-inside: avoid;
            margin: 0 8px 16px;
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .post-image {
            width: 100%;
            height: auto;
            display: block;
            background-color: var(--bg-secondary);
            cursor: pointer;
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
            color: var(--text-secondary);
            font-size: 14px;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .post-tags {
            margin-bottom: 8px;
        }

        .tag {
            display: inline-block;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-right: 4px;
            margin-bottom: 4px;
        }

        /* POST STATS CON BOTONES DE INTERACCIÓN */
        .post-stats {
            display: flex;
            align-items: center;
            gap: 16px;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .stat-button {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s;
            padding: 6px 10px;
            border-radius: 8px;
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .stat-button:hover {
            background-color: var(--hover-bg);
            color: var(--text-primary);
        }

        .stat-button.liked {
            color: #e91e63;
        }

        .stat-button.saved {
            color: #ffd700;
        }

        .stat-button .icon {
            font-size: 18px;
            transition: transform 0.2s;
        }

        .stat-button:active .icon {
            transform: scale(1.2);
        }

        /* MODAL DE COMENTARIOS */
        .comments-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: 20px;
        }

        .comments-modal.active {
            display: flex;
        }

        .comments-modal-content {
            background: var(--card-bg);
            border-radius: 16px;
            max-width: 600px;
            width: 100%;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .comments-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .comments-header h3 {
            font-size: 20px;
            font-weight: 600;
        }

        .close-comments {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-secondary);
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background-color 0.2s;
        }

        .close-comments:hover {
            background-color: var(--hover-bg);
        }

        .comments-list {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .comment-item {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .comment-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(45deg, #e91e63, #9c27b0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }

        .comment-content {
            flex: 1;
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .comment-author {
            font-weight: 600;
            font-size: 14px;
        }

        .comment-time {
            color: var(--text-secondary);
            font-size: 12px;
        }

        .comment-text {
            font-size: 14px;
            line-height: 1.5;
            word-wrap: break-word;
        }

        .comment-delete {
            background: none;
            border: none;
            color: #e53e3e;
            font-size: 12px;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 4px;
            margin-top: 4px;
            transition: background-color 0.2s;
        }

        .comment-delete:hover {
            background-color: rgba(229, 62, 62, 0.1);
        }

        .comments-form {
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 12px;
        }

        .comments-form input {
            flex: 1;
            padding: 10px 16px;
            border: 1px solid var(--border-color);
            border-radius: 24px;
            font-size: 14px;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
        }

        .comments-form input:focus {
            outline: none;
            border-color: var(--accent-color);
        }

        .comments-form button {
            padding: 10px 20px;
            background: linear-gradient(45deg, #e91e63, #9c27b0);
            color: white;
            border: none;
            border-radius: 24px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .comments-form button:hover:not(:disabled) {
            transform: scale(1.05);
        }

        .comments-form button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .no-comments {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-secondary);
        }

        
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--card-bg);
            color: var(--text-primary);
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 3000;
            animation: slideUp 0.3s ease;
            border-left: 4px solid var(--accent-color);
        }

        @keyframes slideUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .toast.success {
            border-left-color: #38a169;
        }

        .toast.error {
            border-left-color: #e53e3e;
        }

        
        .profile-header {
            display: flex;
            align-items: center;
            gap: 32px;
            margin-bottom: 32px;
            padding: 24px;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(45deg, #e91e63, #9c27b0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: bold;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .profile-handle {
            color: var(--text-secondary);
            font-size: 18px;
            margin-bottom: 16px;
        }

        .profile-stats {
            display: flex;
            gap: 32px;
            margin-bottom: 16px;
        }

        .profile-stat {
            display: flex;
            flex-direction: column;
        }

        .profile-stat-value {
            font-size: 24px;
            font-weight: 700;
        }

        .profile-stat-label {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .profile-tabs {
            display: flex;
            gap: 24px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 24px;
        }

        .profile-tab {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .profile-tab.active {
            color: var(--text-primary);
            border-bottom-color: #e91e63;
        }

        
        .settings-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .settings-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .settings-card h3 {
            font-size: 18px;
            margin-bottom: 16px;
            font-weight: 600;
        }

        .settings-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .settings-item:last-child {
            border-bottom: none;
        }

        .settings-label {
            display: flex;
            flex-direction: column;
        }

        .settings-label-title {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .settings-label-desc {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 26px;
            background-color: var(--border-color);
            border-radius: 13px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .toggle-switch.active {
            background-color: #e91e63;
        }

        .toggle-slider {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            background-color: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        .toggle-switch.active .toggle-slider {
            transform: translateX(24px);
        }

        .btn-settings {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #e91e63, #9c27b0);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 16px;
        }

        .btn-settings:hover {
            transform: translateY(-1px);
        }

        
        .create-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .upload-area {
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            padding: 48px 24px;
            text-align: center;
            margin-bottom: 24px;
            cursor: pointer;
            transition: border-color 0.2s ease;
            background-color: var(--bg-secondary);
        }

        .upload-area:hover {
            border-color: #1976d2;
        }

        .upload-icon {
            font-size: 32px;
            margin-bottom: 16px;
        }

        .upload-hint {
            color: var(--text-secondary);
            font-size: 14px;
            margin-top: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #1976d2;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .btn-primary {
            padding: 12px 24px;
            background: linear-gradient(45deg, #e91e63, #9c27b0);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-secondary {
            padding: 12px 24px;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
        }

        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: var(--text-secondary);
        }

        
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
            background: var(--card-bg);
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

        .login-decoration {
            color: white;
            text-align: center;
            z-index: 1;
        }

        .login-decoration h2 {
            font-size: 28px;
            margin-bottom: 16px;
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

        .login-switch {
            text-align: center;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .login-switch a {
            color: #e91e63;
            text-decoration: none;
            font-weight: 600;
        }

        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .feed-grid, .explore-grid, .trending-grid, .profile-grid {
                columns: 2;
            }

            .login-modal {
                flex-direction: column;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    
    <div class="comments-modal" id="commentsModal">
        <div class="comments-modal-content">
            <div class="comments-header">
                <h3>Comentarios</h3>
                <button class="close-comments" onclick="closeCommentsModal()">&times;</button>
            </div>
            <div class="comments-list" id="commentsList">
                <div class="no-comments">Cargando comentarios...</div>
            </div>
            <div class="comments-form">
                <input type="text" id="commentInput" placeholder="Escribe un comentario...">
                <button onclick="submitComment()">Enviar</button>
            </div>
        </div>
    </div>

    
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
        <aside class="sidebar">
            <div class="logo">
                <div class="logo-icon">
                    <img src="logo.png" alt="Entoma Logo">
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

            <div class="user-info" id="userInfo" style="display: none;" onclick="showProfile()">
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

        <main class="main-content">
            
            <section id="feed" class="content-section active">
                <div class="header">
                    <h2>Tu Feed</h2>
                    <p>Descubre los últimos outfits de las personas que sigues</p>
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Buscar outfits, estilos..." id="searchInput">
                </div>
                <div class="feed-grid" id="feedGrid">
                    <div class="loading">Cargando...</div>
                </div>
            </section>

            
            <section id="explore" class="content-section">
                <div class="header">
                    <h2>Explorar</h2>
                    <p>Descubre nuevos estilos y tendencias</p>
                </div>
                <div class="explore-grid" id="exploreGrid">
                    <div class="loading">Cargando...</div>
                </div>
            </section>
            
            
            <section id="create" class="content-section">
                <div class="header">
                    <h2>Crear Outfit</h2>
                    <p>Comparte tu estilo con la comunidad</p>
                </div>
                <div class="create-form">
                    <form id="createOutfitForm" action="crear_publicacion.php" method="POST" enctype="multipart/form-data">
                        
                        <div id="imagePreviewContainer" style="display: none; margin-bottom: 20px; text-align: center;">
                            <img id="imagePreview" src="" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 12px; object-fit: contain;">
                            <p style="margin-top: 10px; color: var(--text-secondary); font-size: 14px;">
                                <span id="fileName"></span> (<span id="fileSize"></span>)
                            </p>
                        </div>
                        
                        <div class="upload-area" id="uploadArea" onclick="document.getElementById('fotoInput').click()">
                            <div class="upload-placeholder">
                                <div class="upload-icon">📸</div>
                                <p style="font-weight: 600; margin-bottom: 8px;">Sube tu foto de outfit</p>
                                <p class="upload-hint">Haz clic aquí para seleccionar una imagen (JPG, PNG, GIF - máx 5MB)</p>
                            </div>
                        </div>
                        
                        <input type="file" 
                               id="fotoInput" 
                               name="foto" 
                               accept="image/*" 
                               style="display: none;" 
                               required>
                        
                        <div class="form-group">
                            <label for="tituloInput">Título del outfit *</label>
                            <input type="text" 
                                   id="tituloInput" 
                                   name="titulo" 
                                   placeholder="Ej: Look casual para fin de semana" 
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcionInput">Descripción</label>
                            <textarea id="descripcionInput" 
                                      name="descripcion" 
                                      placeholder="Cuenta la historia detrás de tu outfit, dónde lo usarías, qué te inspiró..."></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="etiquetasInput">Etiquetas</label>
                            <input type="text" 
                                   id="etiquetasInput" 
                                   name="etiquetas" 
                                   placeholder="casual, streetwear, vintage (separado por comas)">
                        </div>
                        
                        <div class="form-group">
                            <label for="ubicacionInput">Ubicación (opcional)</label>
                            <input type="text" 
                                   id="ubicacionInput" 
                                   name="ubicacion" 
                                   placeholder="¿Dónde tomaste esta foto?">
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="resetForm()">Limpiar</button>
                            <button type="submit" class="btn-primary" id="submitCreateBtn">Publicar outfit</button>
                        </div>
                    </form>
                </div>
            </section>

            
            <section id="notifications" class="content-section">
                <div class="header">
                    <h2>Notificaciones</h2>
                    <p>Mantente al día con tu actividad</p>
                </div>
                <div style="text-align: center; padding: 60px 20px; color: var(--text-secondary);">
                    <div style="font-size: 64px; margin-bottom: 16px;">🔔</div>
                    <h3 style="margin-bottom: 8px;">Sin notificaciones nuevas</h3>
                    <p>Te avisaremos cuando alguien interactúe con tus publicaciones</p>
                </div>
            </section>

        

<!-- Reemplaza la sección TRENDING SECTION en dashboard.php con esto -->

<!-- TRENDING SECTION -->
<section id="trending" class="content-section">
    <div class="header">
        <h2>Tendencia</h2>
        <p>Los outfits más populares del momento</p>
    </div>
    
    <!-- Contenedor estilo TikTok -->
    <div class="tiktok-container" id="tiktokContainer">
        <div class="tiktok-feed" id="tiktokFeed">
            <div class="loading">Cargando tendencias...</div>
        </div>
        
        <!-- Controles de navegación -->
        <div class="tiktok-controls">
            <button class="tiktok-nav-btn prev" id="prevBtn" disabled>
                <span>↑</span>
            </button>
            <div class="tiktok-counter">
                <span id="currentIndex">1</span> / <span id="totalPosts">0</span>
            </div>
            <button class="tiktok-nav-btn next" id="nextBtn">
                <span>↓</span>
            </button>
        </div>
    </div>
</section>

<style>
/* Estilos para el contenedor TikTok */
.tiktok-container {
    position: relative;
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
    height: calc(100vh - 200px);
    background: var(--card-bg);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.tiktok-feed {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    scroll-snap-type: y mandatory;
    scroll-behavior: smooth;
}

.tiktok-post {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    opacity: 0;
    transform: translateY(100%);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    background: var(--card-bg);
}

.tiktok-post.active {
    opacity: 1;
    transform: translateY(0);
    z-index: 2;
}

.tiktok-post.prev {
    transform: translateY(-100%);
    opacity: 0;
    z-index: 1;
}

.tiktok-post.next {
    transform: translateY(100%);
    opacity: 0;
    z-index: 1;
}

.tiktok-image-container {
    flex: 1;
    position: relative;
    overflow: hidden;
    background: var(--bg-secondary);
}

.tiktok-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.tiktok-gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    z-index: 1;
}

.tiktok-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 20px;
    color: white;
    z-index: 2;
}

.tiktok-user {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
}

.tiktok-avatar {
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
    border: 2px solid white;
}

.tiktok-username {
    font-weight: 600;
    font-size: 16px;
}

.tiktok-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 8px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.tiktok-description {
    font-size: 14px;
    line-height: 1.4;
    margin-bottom: 12px;
    opacity: 0.9;
}

.tiktok-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 16px;
}

.tiktok-tag {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.tiktok-actions {
    position: absolute;
    right: 12px;
    bottom: 100px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    z-index: 3;
}

.tiktok-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    width: 56px;
    height: 56px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: white;
    font-size: 24px;
    justify-content: center;
}

.tiktok-action-btn:hover {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.3);
}

.tiktok-action-btn.liked {
    background: rgba(233, 30, 99, 0.8);
    border-color: #e91e63;
}

.tiktok-action-btn.saved {
    background: rgba(255, 215, 0, 0.8);
    border-color: #ffd700;
}

.tiktok-action-count {
    font-size: 12px;
    font-weight: 600;
    margin-top: 4px;
}

.tiktok-controls {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 12px;
    z-index: 10;
}

.tiktok-nav-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.tiktok-nav-btn:hover:not(:disabled) {
    background: white;
    transform: scale(1.1);
}

.tiktok-nav-btn:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.tiktok-counter {
    background: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
}

.trending-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: linear-gradient(45deg, #ff6b6b, #feca57);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 6px;
    z-index: 3;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Animación de like */
@keyframes heartPop {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.3); }
}

.tiktok-action-btn.liked {
    animation: heartPop 0.5s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .tiktok-container {
        max-width: 100%;
        height: calc(100vh - 150px);
        border-radius: 0;
    }
    
    .tiktok-actions {
        right: 8px;
        bottom: 80px;
    }
    
    .tiktok-action-btn {
        width: 48px;
        height: 48px;
        font-size: 20px;
    }
}

/* Dark mode */
[data-theme="dark"] .tiktok-nav-btn {
    background: rgba(45, 45, 45, 0.9);
    color: white;
}

[data-theme="dark"] .tiktok-nav-btn:hover:not(:disabled) {
    background: rgba(58, 58, 58, 0.9);
}
</style>

<script>
let trendingPosts = [];
let currentPostIndex = 0;
let isTransitioning = false;

// Cargar posts de tendencias
async function loadTrendingPosts() {
    const feedContainer = document.getElementById('tiktokFeed');
    feedContainer.innerHTML = '<div class="loading">Cargando tendencias...</div>';
    
    try {
        console.log('Cargando posts de tendencias...');
        const response = await fetch('api_posts.php?action=trending');
        const posts = await response.json();
        
        console.log('Posts recibidos:', posts);
        
        if (posts.error) {
            throw new Error(posts.error);
        }
        
        // Si no hay posts, intentar cargar del feed normal
        if (!posts || posts.length === 0) {
            console.log('No hay posts en trending, cargando feed...');
            const feedResponse = await fetch('api_posts.php?action=feed');
            const feedPosts = await feedResponse.json();
            
            // Ordenar por likes y tomar los primeros 20
            trendingPosts = feedPosts.sort((a, b) => b.likes - a.likes).slice(0, 20);
        } else {
            trendingPosts = posts;
        }
        
        console.log('Total posts para trending:', trendingPosts.length);
        
        if (trendingPosts.length === 0) {
            feedContainer.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--text-secondary); flex-direction: column; gap: 16px;"><div style="font-size: 48px;">📭</div><div>No hay publicaciones disponibles</div><div style="font-size: 14px; opacity: 0.7;">¡Sé el primero en crear contenido!</div></div>';
            return;
        }
        
        renderTikTokFeed();
        updateControls();
        setupSwipeGestures();
        
    } catch (error) {
        console.error('Error cargando trending:', error);
        feedContainer.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--text-secondary); flex-direction: column; gap: 12px;"><div style="font-size: 48px;">⚠️</div><div>Error al cargar tendencias</div><button onclick="loadTrendingPosts()" style="margin-top: 10px; padding: 8px 16px; background: #e91e63; color: white; border: none; border-radius: 8px; cursor: pointer;">Reintentar</button></div>';
    }
}

function renderTikTokFeed() {
    const feedContainer = document.getElementById('tiktokFeed');
    feedContainer.innerHTML = '';
    
    trendingPosts.forEach((post, index) => {
        const postElement = createTikTokPost(post, index);
        feedContainer.appendChild(postElement);
    });
    
    // Mostrar primer post
    const firstPost = feedContainer.querySelector('.tiktok-post');
    if (firstPost) {
        firstPost.classList.add('active');
    }
}

function createTikTokPost(post, index) {
    const postDiv = document.createElement('div');
    postDiv.className = 'tiktok-post';
    postDiv.dataset.index = index;
    
    const tags = Array.isArray(post.tags) ? post.tags : 
                 (post.tags ? String(post.tags).split(',').map(tag => tag.trim()) : []);
    
    const likeClass = post.liked_by_user ? 'liked' : '';
    const saveClass = post.saved_by_user ? 'saved' : '';
    const likeIcon = post.liked_by_user ? '❤️' : '🤍';
    const saveIcon = post.saved_by_user ? '🔖' : '📑';
    
    postDiv.innerHTML = `
        <div class="tiktok-image-container">
            <img src="${post.image}" alt="${post.title}" class="tiktok-image" 
                 onerror="this.src='https://via.placeholder.com/500x800/f1f3f4/767676?text=Imagen+no+disponible'">
            <div class="tiktok-gradient"></div>
            
            <div class="trending-badge">
                🔥 #${index + 1} Trending
            </div>
            
            <div class="tiktok-info">
                <div class="tiktok-user">
                    <div class="tiktok-avatar">${post.user_avatar}</div>
                    <span class="tiktok-username">${post.user_name}</span>
                </div>
                
                <h3 class="tiktok-title">${post.title}</h3>
                
                ${post.description ? `<p class="tiktok-description">${post.description}</p>` : ''}
                
                <div class="tiktok-tags">
                    ${tags.map(tag => `<span class="tiktok-tag">#${tag}</span>`).join('')}
                </div>
            </div>
        </div>
        
        <div class="tiktok-actions">
            <button class="tiktok-action-btn ${likeClass}" onclick="likeTikTokPost(${post.id}, ${index}, event)">
                <span>${likeIcon}</span>
                <span class="tiktok-action-count">${post.likes}</span>
            </button>
            
            <button class="tiktok-action-btn" onclick="openCommentsModal(${post.id})">
                <span>💬</span>
                <span class="tiktok-action-count">${post.comments}</span>
            </button>
            
            <button class="tiktok-action-btn ${saveClass}" onclick="saveTikTokPost(${post.id}, ${index}, event)">
                <span>${saveIcon}</span>
            </button>
        </div>
    `;
    
    return postDiv;
}

function navigatePost(direction) {
    if (isTransitioning || trendingPosts.length === 0) return;
    
    const newIndex = currentPostIndex + direction;
    
    if (newIndex < 0 || newIndex >= trendingPosts.length) return;
    
    isTransitioning = true;
    
    const posts = document.querySelectorAll('.tiktok-post');
    const currentPost = posts[currentPostIndex];
    const nextPost = posts[newIndex];
    
    // Animación de salida
    currentPost.classList.remove('active');
    if (direction > 0) {
        currentPost.classList.add('prev');
    } else {
        currentPost.classList.add('next');
    }
    
    // Animación de entrada
    nextPost.classList.add('active');
    nextPost.classList.remove('prev', 'next');
    
    currentPostIndex = newIndex;
    updateControls();
    
    setTimeout(() => {
        isTransitioning = false;
    }, 500);
}

function updateControls() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const currentIndexEl = document.getElementById('currentIndex');
    const totalPostsEl = document.getElementById('totalPosts');
    
    if (prevBtn) prevBtn.disabled = currentPostIndex === 0;
    if (nextBtn) nextBtn.disabled = currentPostIndex === trendingPosts.length - 1;
    
    if (currentIndexEl) currentIndexEl.textContent = currentPostIndex + 1;
    if (totalPostsEl) totalPostsEl.textContent = trendingPosts.length;
}

function setupSwipeGestures() {
    const container = document.getElementById('tiktokContainer');
    if (!container) return;
    
    let startY = 0;
    let currentY = 0;
    let isDragging = false;
    
    container.addEventListener('touchstart', (e) => {
        startY = e.touches[0].clientY;
        isDragging = true;
    });
    
    container.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        currentY = e.touches[0].clientY;
    });
    
    container.addEventListener('touchend', (e) => {
        if (!isDragging) return;
        
        const diff = startY - currentY;
        
        // Swipe up (siguiente)
        if (diff > 50) {
            navigatePost(1);
        }
        // Swipe down (anterior)
        else if (diff < -50) {
            navigatePost(-1);
        }
        
        isDragging = false;
    });
    
    // Soporte para mouse wheel
    container.addEventListener('wheel', (e) => {
        e.preventDefault();
        
        if (e.deltaY > 0) {
            navigatePost(1);
        } else {
            navigatePost(-1);
        }
    }, { passive: false });
    
    // Soporte para teclado
    document.addEventListener('keydown', (e) => {
        if (document.getElementById('trending').classList.contains('active')) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                navigatePost(1);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                navigatePost(-1);
            }
        }
    });
}

// Event listeners para controles
document.getElementById('prevBtn')?.addEventListener('click', () => navigatePost(-1));
document.getElementById('nextBtn')?.addEventListener('click', () => navigatePost(1));

// Funciones de interacción
async function likeTikTokPost(postId, index, event) {
    if (!showLoginIfNeeded()) return;
    
    event.stopPropagation();
    const button = event.currentTarget;
    
    try {
        const formData = new FormData();
        formData.append('action', 'like');
        formData.append('post_id', postId);
        
        const response = await fetch('api_interacciones.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            const icon = button.querySelector('span:first-child');
            const count = button.querySelector('.tiktok-action-count');
            
            if (data.action === 'liked') {
                button.classList.add('liked');
                icon.textContent = '❤️';
            } else {
                button.classList.remove('liked');
                icon.textContent = '🤍';
            }
            
            count.textContent = data.total_likes;
            trendingPosts[index].likes = data.total_likes;
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function saveTikTokPost(postId, index, event) {
    if (!showLoginIfNeeded()) return;
    
    event.stopPropagation();
    const button = event.currentTarget;
    
    try {
        const formData = new FormData();
        formData.append('action', 'save');
        formData.append('post_id', postId);
        
        const response = await fetch('api_interacciones.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            const icon = button.querySelector('span:first-child');
            
            if (data.action === 'saved') {
                button.classList.add('saved');
                icon.textContent = '🔖';
            } else {
                button.classList.remove('saved');
                icon.textContent = '📑';
            }
            
            showToast(data.message, 'success');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Actualizar la función showSection original para cargar trending
const originalShowSection2 = showSection;
showSection = function(sectionName) {
    originalShowSection2(sectionName);
    
    if (sectionName === 'trending') {
        loadTrendingPosts();
    }
};

// Exponer funciones globalmente
window.navigatePost = navigatePost;
window.likeTikTokPost = likeTikTokPost;
window.saveTikTokPost = saveTikTokPost;
</script>

            <!-- PROFILE SECTION -->
            <section id="profile" class="content-section">
                <div class="profile-header">
                    <div class="profile-avatar-large" id="profileAvatarLarge">U</div>
                    <div class="profile-info">
                        <h2 class="profile-name" id="profileName">Usuario</h2>
                        <p class="profile-handle" id="profileHandle">@usuario</p>
                        <div class="profile-stats">
                            <div class="profile-stat">
                                <span class="profile-stat-value" id="profilePosts">0</span>
                                <span class="profile-stat-label">Publicaciones</span>
                            </div>
                            <div class="profile-stat">
                                <span class="profile-stat-value" id="profileFollowers">0</span>
                                <span class="profile-stat-label">Seguidores</span>
                            </div>
                            <div class="profile-stat">
                                <span class="profile-stat-value" id="profileFollowing">0</span>
                                <span class="profile-stat-label">Siguiendo</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-tabs">
                    <div class="profile-tab active" data-tab="posts" onclick="switchProfileTab('posts')">
                        📸 Mis Publicaciones
                    </div>
                    <div class="profile-tab" data-tab="saved" onclick="switchProfileTab('saved')">
                        🔖 Guardados
                    </div>
                </div>

                <div id="profilePostsTab" class="profile-tab-content">
                    <div class="profile-grid" id="profilePostsGrid">
                        <div class="loading">Cargando...</div>
                    </div>
                </div>

                <div id="profileSavedTab" class="profile-tab-content" style="display: none;">
                    <div class="profile-grid" id="profileSavedGrid">
                        <div class="loading">Cargando...</div>
                    </div>
                </div>
            </section>

            <!-- CONFIG SECTION -->
            <section id="config" class="content-section">
                <div class="header">
                    <h2>Configuración</h2>
                    <p>Personaliza tu experiencia en Entoma</p>
                </div>

                <div class="settings-container">
                    <!-- Apariencia -->
                    <div class="settings-card">
                        <h3>🎨 Apariencia</h3>
                        <div class="settings-item">
                            <div class="settings-label">
                                <span class="settings-label-title">Modo Oscuro</span>
                                <span class="settings-label-desc">Cambia el tema de la aplicación</span>
                            </div>
                            <div class="toggle-switch" id="darkModeToggle" onclick="toggleDarkMode()">
                                <div class="toggle-slider"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Privacidad -->
                    <div class="settings-card">
                        <h3>🔒 Privacidad</h3>
                        <div class="settings-item">
                            <div class="settings-label">
                                <span class="settings-label-title">Perfil Público</span>
                                <span class="settings-label-desc">Permite que otros usuarios vean tu perfil</span>
                            </div>
                            <div class="toggle-switch active" id="publicProfileToggle" onclick="toggleSettingAndSave(this, 'perfil_publico')">
                                <div class="toggle-slider"></div>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="settings-label">
                                <span class="settings-label-title">Permitir Comentarios</span>
                                <span class="settings-label-desc">
                                    Los usuarios pueden comentar tus publicaciones
                                    <span id="commentsStatus" style="font-weight: 600; color: var(--accent-color);"></span>
                                </span>
                            </div>
                            <div class="toggle-switch active" id="commentsToggle" onclick="toggleSettingAndSave(this, 'permitir_comentarios')">
                                <div class="toggle-slider"></div>
                            </div>
                        </div>

                    <!-- Notificaciones -->
                    <div class="settings-card">
                        <h3>🔔 Notificaciones</h3>
                        <div class="settings-item">
                            <div class="settings-label">
                                <span class="settings-label-title">Notificaciones por Email</span>
                                <span class="settings-label-desc">Recibe notificaciones en tu correo</span>
                            </div>
                            <div class="toggle-switch active" id="emailNotificationsToggle" onclick="toggleSettingAndSave(this, 'notificaciones_email')">
                                <div class="toggle-slider"></div>
                            </div>
                        </div>
                        <div class="settings-item">
                            <div class="settings-label">
                                <span class="settings-label-title">Notificaciones Push</span>
                                <span class="settings-label-desc">Recibe notificaciones en tiempo real</span>
                            </div>
                            <div class="toggle-switch active" id="pushNotificationsToggle" onclick="toggleSettingAndSave(this, 'notificaciones_push')">
                                <div class="toggle-slider"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Cuenta -->
                    <div class="settings-card">
                        <h3>👤 Cuenta</h3>
                        <button class="btn-settings" onclick="showEditProfile()">Editar Perfil</button>
                        <button class="btn-settings" onclick="changePassword()" style="background: linear-gradient(45deg, #667eea, #764ba2);">Cambiar Contraseña</button>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        let isLoggedIn = false;
        let currentUser = null;
        let isLoginMode = true;
        let currentProfileTab = 'posts';
        let currentPostId = null;

        // Inicialización
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Inicializando dashboard...');
            setupNavigation();
            setupCreateForm();
            checkSession();
            loadFeedPosts();
            loadDarkModePreference();
        });

        // Dark Mode
        function loadDarkModePreference() {
            const darkMode = localStorage.getItem('darkMode') === 'true';
            if (darkMode) {
                document.body.setAttribute('data-theme', 'dark');
                document.getElementById('darkModeToggle').classList.add('active');
            }
        }

        function toggleDarkMode() {
            const toggle = document.getElementById('darkModeToggle');
            const isDark = document.body.getAttribute('data-theme') === 'dark';
            
            if (isDark) {
                document.body.removeAttribute('data-theme');
                toggle.classList.remove('active');
                localStorage.setItem('darkMode', 'false');
            } else {
                document.body.setAttribute('data-theme', 'dark');
                toggle.classList.add('active');
                localStorage.setItem('darkMode', 'true');
            }
        }

        function toggleSetting(element) {
            element.classList.toggle('active');
        }

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
                        menuItems.forEach(mi => mi.classList.remove('active'));
                        this.classList.add('active');
                        showSection(section);
                    }
                });
            });
        }

        function showSection(sectionName) {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => section.classList.remove('active'));
            
            const targetSection = document.getElementById(sectionName);
            if (targetSection) {
                targetSection.classList.add('active');
                
                if (sectionName === 'explore') loadExplorePosts();
                if (sectionName === 'trending') loadTrendingPosts();
                if (sectionName === 'profile') loadProfile();
            }
        }

        function showProfile() {
            if (!showLoginIfNeeded()) return;
            
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(mi => mi.classList.remove('active'));
            
            showSection('profile');
        }

        function switchProfileTab(tab) {
            currentProfileTab = tab;
            
            const tabs = document.querySelectorAll('.profile-tab');
            tabs.forEach(t => t.classList.remove('active'));
            
            const activeTab = document.querySelector(`.profile-tab[data-tab="${tab}"]`);
            if (activeTab) activeTab.classList.add('active');
            
            document.getElementById('profilePostsTab').style.display = tab === 'posts' ? 'block' : 'none';
            document.getElementById('profileSavedTab').style.display = tab === 'saved' ? 'block' : 'none';
            
            if (tab === 'posts') {
                loadUserPosts();
            } else if (tab === 'saved') {
                loadSavedPosts();
            }
        }

        async function loadProfile() {
            if (!currentUser) return;
            
            document.getElementById('profileAvatarLarge').textContent = currentUser.avatar;
            document.getElementById('profileName').textContent = currentUser.nombre + ' ' + (currentUser.apellido || '');
            document.getElementById('profileHandle').textContent = '@' + currentUser.email.split('@')[0];
            
            loadUserPosts();
        }

        async function loadUserPosts() {
            if (!currentUser) return;
            
            const grid = document.getElementById('profilePostsGrid');
            grid.innerHTML = '<div class="loading">Cargando...</div>';
            
            try {
                const response = await fetch(`api_posts.php?action=user&user_id=${currentUser.id}`);
                const posts = await response.json();
                
                grid.innerHTML = '';
                
                if (posts.length === 0) {
                    grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-secondary);">Aún no tienes publicaciones. ¡Crea tu primera outfit!</div>';
                    document.getElementById('profilePosts').textContent = '0';
                    return;
                }
                
                document.getElementById('profilePosts').textContent = posts.length;
                
                posts.forEach(post => {
                    const postElement = createPostCard(post);
                    grid.appendChild(postElement);
                });
                
            } catch (error) {
                console.error('Error cargando posts del usuario:', error);
                grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-secondary);">Error al cargar tus publicaciones</div>';
            }
        }

        async function loadSavedPosts() {
            const grid = document.getElementById('profileSavedGrid');
            grid.innerHTML = '<div class="loading">Cargando...</div>';
            
            try {
                const response = await fetch('api_posts.php?action=saved');
                const posts = await response.json();
                
                grid.innerHTML = '';
                
                if (posts.length === 0) {
                    grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-secondary);">No tienes publicaciones guardadas</div>';
                    return;
                }
                
                posts.forEach(post => {
                    const postElement = createPostCard(post);
                    grid.appendChild(postElement);
                });
                
            } catch (error) {
                console.error('Error cargando posts guardados:', error);
                grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-secondary);">Error al cargar guardados</div>';
            }
        }

        function showEditProfile() {
            alert('Función de editar perfil en desarrollo.\nPronto podrás cambiar tu foto, bio y más información.');
        }

        function changePassword() {
            alert('Función de cambiar contraseña en desarrollo.\nRecibirás un email para restablecer tu contraseña.');
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
            
            errorDiv.style.display = 'none';
            successDiv.style.display = 'none';
            
            if (type === 'error') {
                errorDiv.textContent = message;
                errorDiv.style.display = 'block';
            } else {
                successDiv.textContent = message;
                successDiv.style.display = 'block';
            }
            
            setTimeout(() => {
                errorDiv.style.display = 'none';
                successDiv.style.display = 'none';
            }, 5000);
        }

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
                    showToast('¡Bienvenido de vuelta!', 'success');
                    loadFeedPosts();
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
                    showToast('¡Cuenta creada exitosamente!', 'success');
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
            } else {
                document.getElementById('userInfo').style.display = 'none';
                document.getElementById('guestInfo').style.display = 'flex';
                document.getElementById('logoutBtn').style.display = 'none';
            }
        }

        async function loadFeedPosts() {
            const feedGrid = document.getElementById('feedGrid');
            feedGrid.innerHTML = '<div class="loading">Cargando...</div>';
            
            try {
                const response = await fetch('api_posts.php?action=feed');
                const posts = await response.json();
                
                if (posts.error) {
                    throw new Error(posts.error);
                }
                
                feedGrid.innerHTML = '';
                
                if (posts.length === 0) {
                    feedGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-secondary);">No hay publicaciones disponibles.</div>';
                    return;
                }
                
                posts.forEach(post => {
                    const postElement = createPostCard(post);
                    feedGrid.appendChild(postElement);
                });
                
            } catch (error) {
                console.error('Error cargando feed:', error);
                feedGrid.innerHTML = `
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-secondary);">
                        Error al cargar las publicaciones<br>
                        <button onclick="loadFeedPosts()" style="margin-top: 10px; padding: 8px 16px; background: #111; color: white; border: none; border-radius: 8px; cursor: pointer;">Reintentar</button>
                    </div>
                `;
            }
        }

        async function loadExplorePosts() {
            const exploreGrid = document.getElementById('exploreGrid');
            exploreGrid.innerHTML = '<div class="loading">Cargando...</div>';
            
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
                exploreGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-secondary);">Error al cargar contenido</div>';
            }
        }

        async function loadTrendingPosts() {
            const trendingGrid = document.getElementById('trendingGrid');
            trendingGrid.innerHTML = '<div class="loading">Cargando...</div>';
            
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
                trendingGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-secondary);">Error al cargar tendencias</div>';
            }
        }

        function createPostCard(post, isTrending = false) {
            const card = document.createElement('div');
            card.className = 'post-card';
            
            const trendingBadge = isTrending ? 
                '<div style="background: linear-gradient(45deg, #ff6b6b, #feca57); color: white; padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: bold; margin-bottom: 8px; text-align: center;">🔥 Trending</div>' : '';
            
            const tags = Array.isArray(post.tags) ? post.tags : 
                         (post.tags ? String(post.tags).split(',').map(tag => tag.trim()) : []);
            
            const likeClass = post.liked_by_user ? 'liked' : '';
            const saveClass = post.saved_by_user ? 'saved' : '';
            const likeIcon = post.liked_by_user ? '❤️' : '🤍';
            const saveIcon = post.saved_by_user ? '🔖' : '📑';
            
            card.innerHTML = `
                ${trendingBadge}
                <img src="${post.image}" alt="${post.title}" class="post-image" 
                     onerror="this.src='https://via.placeholder.com/300x400/f1f3f4/767676?text=Imagen+no+disponible'">
                <div class="post-content">
                    <h3 class="post-title">${post.title}</h3>
                    <div class="post-user">
                        <div class="post-user-avatar">${post.user_avatar}</div>
                        <span class="post-user-name">${post.user_name}</span>
                    </div>
                    ${post.description ? `<p class="post-description">${post.description.substring(0, 100)}${post.description.length > 100 ? '...' : ''}</p>` : ''}
                    <div class="post-tags">
                        ${tags.map(tag => `<span class="tag">#${tag}</span>`).join('')}
                    </div>
                    <div class="post-stats">
                        <button class="stat-button ${likeClass}" onclick="likePost(${post.id}, event)">
                            <span class="icon">${likeIcon}</span>
                            <span class="count">${post.likes}</span>
                        </button>
                        <button class="stat-button" onclick="openCommentsModal(${post.id})">
                            <span class="icon">💬</span>
                            <span class="count">${post.comments}</span>
                        </button>
                        <button class="stat-button ${saveClass}" onclick="savePost(${post.id}, event)">
                            <span class="icon">${saveIcon}</span>
                        </button>
                    </div>
                </div>
            `;
            
            return card;
        }

        // FUNCIONES DE INTERACCIÓN (LIKES, COMENTARIOS, GUARDAR)
        async function likePost(postId, event) {
            if (!showLoginIfNeeded()) return;
            
            event.stopPropagation();
            const button = event.currentTarget;
            
            try {
                const formData = new FormData();
                formData.append('action', 'like');
                formData.append('post_id', postId);
                
                const response = await fetch('api_interacciones.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const icon = button.querySelector('.icon');
                    const count = button.querySelector('.count');
                    
                    if (data.action === 'liked') {
                        button.classList.add('liked');
                        icon.textContent = '❤️';
                    } else {
                        button.classList.remove('liked');
                        icon.textContent = '🤍';
                    }
                    
                    count.textContent = data.total_likes;
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error al procesar like', 'error');
            }
        }

        async function savePost(postId, event) {
            if (!showLoginIfNeeded()) return;
            
            event.stopPropagation();
            const button = event.currentTarget;
            
            try {
                const formData = new FormData();
                formData.append('action', 'save');
                formData.append('post_id', postId);
                
                const response = await fetch('api_interacciones.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const icon = button.querySelector('.icon');
                    
                    if (data.action === 'saved') {
                        button.classList.add('saved');
                        icon.textContent = '🔖';
                    } else {
                        button.classList.remove('saved');
                        icon.textContent = '📑';
                    }
                    
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error al guardar publicación', 'error');
            }
        }

        async function openCommentsModal(postId) {
            if (!showLoginIfNeeded()) return;
            
            currentPostId = postId;
            const modal = document.getElementById('commentsModal');
            modal.classList.add('active');
            
            await loadComments(postId);
        }

        function closeCommentsModal() {
            const modal = document.getElementById('commentsModal');
            modal.classList.remove('active');
            document.getElementById('commentInput').value = '';
            currentPostId = null;
        }

        async function loadComments(postId) {
            const commentsList = document.getElementById('commentsList');
            commentsList.innerHTML = '<div class="no-comments">Cargando comentarios...</div>';
            
            try {
                const response = await fetch(`api_interacciones.php?action=get_comments&post_id=${postId}`);
                const comments = await response.json();
                
                if (comments.length === 0) {
                    commentsList.innerHTML = '<div class="no-comments">No hay comentarios aún. ¡Sé el primero en comentar!</div>';
                    return;
                }
                
                commentsList.innerHTML = '';
                comments.forEach(comment => {
                    commentsList.appendChild(createCommentElement(comment));
                });
                
            } catch (error) {
                console.error('Error:', error);
                commentsList.innerHTML = '<div class="no-comments">Error al cargar comentarios</div>';
            }
        }

        function createCommentElement(comment) {
            const div = document.createElement('div');
            div.className = 'comment-item';
            div.id = `comment-${comment.id}`;
            
            const timeAgo = formatTimeAgo(comment.fecha);
            
            div.innerHTML = `
                <div class="comment-avatar">${comment.user_avatar}</div>
                <div class="comment-content">
                    <div class="comment-header">
                        <span class="comment-author">${comment.user_name}</span>
                        <span class="comment-time">${timeAgo}</span>
                    </div>
                    <p class="comment-text">${comment.comentario}</p>
                    ${comment.is_owner ? `<button class="comment-delete" onclick="deleteComment(${comment.id})">Eliminar</button>` : ''}
                </div>
            `;
            
            return div;
        }

        async function submitComment() {
            const input = document.getElementById('commentInput');
            const comentario = input.value.trim();
            
            if (!comentario) {
                showToast('Escribe un comentario', 'error');
                return;
            }
            
            try {
                const formData = new FormData();
                formData.append('action', 'comment');
                formData.append('post_id', currentPostId);
                formData.append('comentario', comentario);
                
                const response = await fetch('api_interacciones.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    input.value = '';
                    const commentsList = document.getElementById('commentsList');
                    
                    if (commentsList.querySelector('.no-comments')) {
                        commentsList.innerHTML = '';
                    }
                    
                    commentsList.insertBefore(createCommentElement(data.comment), commentsList.firstChild);
                    
                    // Actualizar contador en la tarjeta
                    updateCommentCount(currentPostId, 1);
                    
                    showToast('Comentario agregado', 'success');
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error al agregar comentario', 'error');
            }
        }

        async function deleteComment(commentId) {
            if (!confirm('¿Eliminar este comentario?')) return;
            
            try {
                const formData = new FormData();
                formData.append('action', 'delete_comment');
                formData.append('comment_id', commentId);
                
                const response = await fetch('api_interacciones.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const commentElement = document.getElementById(`comment-${commentId}`);
                    if (commentElement) {
                        commentElement.remove();
                    }
                    
                    const commentsList = document.getElementById('commentsList');
                    if (commentsList.children.length === 0) {
                        commentsList.innerHTML = '<div class="no-comments">No hay comentarios aún.</div>';
                    }
                    
                    // Actualizar contador en la tarjeta
                    updateCommentCount(currentPostId, -1);
                    
                    showToast('Comentario eliminado', 'success');
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error al eliminar comentario', 'error');
            }
        }

        function updateCommentCount(postId, increment) {
            const allCards = document.querySelectorAll('.post-card');
            allCards.forEach(card => {
                const commentButton = card.querySelector('.stat-button:nth-child(2)');
                if (commentButton) {
                    const countSpan = commentButton.querySelector('.count');
                    if (countSpan) {
                        let currentCount = parseInt(countSpan.textContent) || 0;
                        countSpan.textContent = Math.max(0, currentCount + increment);
                    }
                }
            });
        }

        function formatTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);
            
            if (seconds < 60) return 'Ahora';
            if (seconds < 3600) return `${Math.floor(seconds / 60)}m`;
            if (seconds < 86400) return `${Math.floor(seconds / 3600)}h`;
            if (seconds < 604800) return `${Math.floor(seconds / 86400)}d`;
            return date.toLocaleDateString();
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `
                <span>${type === 'success' ? '✓' : '✕'}</span>
                <span>${message}</span>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideUp 0.3s ease reverse';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // FORMULARIO DE CREAR PUBLICACIÓN
        function setupCreateForm() {
            const uploadArea = document.querySelector('.upload-area');
            const fileInput = document.getElementById('fotoInput');
            const createForm = document.getElementById('createOutfitForm');
            
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
                    this.style.backgroundColor = 'rgba(25, 118, 210, 0.05)';
                });
                
                uploadArea.addEventListener('dragleave', function() {
                    this.style.borderColor = 'var(--border-color)';
                    this.style.backgroundColor = 'var(--bg-secondary)';
                });
                
                uploadArea.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.style.borderColor = 'var(--border-color)';
                    this.style.backgroundColor = 'var(--bg-secondary)';
                    
                    const files = e.dataTransfer.files;
                    if (files.length > 0 && fileInput) {
                        fileInput.files = files;
                        handleFileSelect(files[0]);
                    }
                });
            }
            
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    const foto = document.getElementById('fotoInput');
                    const titulo = document.getElementById('tituloInput');
                    
                    if (!foto.files || foto.files.length === 0) {
                        e.preventDefault();
                        alert('Por favor selecciona una imagen para tu outfit');
                        return false;
                    }
                    
                    if (!titulo.value.trim()) {
                        e.preventDefault();
                        alert('Por favor agrega un título a tu outfit');
                        return false;
                    }
                    
                    const submitBtn = createForm.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Publicando...';
                    }
                });
            }
        }

        function handleFileSelect(file) {
            const uploadArea = document.querySelector('.upload-area');
            if (!uploadArea) return;
            
            if (!file.type.startsWith('image/')) {
                alert('Por favor selecciona una imagen válida');
                document.getElementById('fotoInput').value = '';
                return;
            }
            
            if (file.size > 5000000) {
                alert('La imagen es demasiado grande (máximo 5MB)');
                document.getElementById('fotoInput').value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadArea.innerHTML = `
                    <div style="position: relative; max-width: 100%; max-height: 300px;">
                        <img src="${e.target.result}" alt="Preview" 
                             style="max-width: 100%; max-height: 300px; border-radius: 8px; object-fit: contain; display: block; margin: 0 auto;">
                        <div style="margin-top: 16px; text-align: center;">
                            <p style="font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">✓ Imagen seleccionada</p>
                            <p style="font-size: 14px; color: var(--text-secondary);">${file.name} (${(file.size / 1024).toFixed(2)} KB)</p>
                            <p class="upload-hint" style="margin-top: 8px;">Haz clic para cambiar la imagen</p>
                        </div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }

        function resetForm() {
            document.getElementById('createOutfitForm').reset();
            const uploadArea = document.querySelector('.upload-area');
            if (uploadArea) {
                uploadArea.innerHTML = `
                    <div class="upload-placeholder">
                        <div class="upload-icon">📸</div>
                        <p style="font-weight: 600; margin-bottom: 8px;">Sube tu foto de outfit</p>
                        <p class="upload-hint">Haz clic aquí para seleccionar una imagen (JPG, PNG, GIF - máx 5MB)</p>
                    </div>
                `;
            }
        }

        // BÚSQUEDA
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

        
        document.getElementById('commentsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCommentsModal();
            }
        });

        document.getElementById('loginOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogin();
            }
        });

        
        document.getElementById('commentInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                submitComment();
            }
        });

        
        window.showLogin = showLogin;
        window.closeLogin = closeLogin;
        window.toggleForm = toggleForm;
        window.logout = logout;
        window.showLoginIfNeeded = showLoginIfNeeded;
        window.likePost = likePost;
        window.savePost = savePost;
        window.openCommentsModal = openCommentsModal;
        window.closeCommentsModal = closeCommentsModal;
        window.submitComment = submitComment;
        window.deleteComment = deleteComment;
        window.loadFeedPosts = loadFeedPosts;
        window.showProfile = showProfile;
        window.switchProfileTab = switchProfileTab;
        window.toggleDarkMode = toggleDarkMode;
        window.toggleSetting = toggleSetting;
        window.showEditProfile = showEditProfile;
        window.changePassword = changePassword;
        window.resetForm = resetForm;
    </script>
 


<div class="config-modal" id="editProfileModal">
    <div class="config-modal-content">
        <div class="config-modal-header">
            <h3>Editar Perfil</h3>
            <button class="close-modal" onclick="closeEditProfile()">&times;</button>
        </div>
        <div class="config-modal-body">
            <form id="editProfileForm">
                <div class="form-group">
                    <label for="editNombre">Nombre *</label>
                    <input type="text" id="editNombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="editApellido">Apellido *</label>
                    <input type="text" id="editApellido" name="apellido" required>
                </div>
                <div class="form-group">
                    <label for="editBio">Biografía</label>
                    <textarea id="editBio" name="bio" rows="4" placeholder="Cuéntanos sobre ti..."></textarea>
                </div>
                <div class="config-modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeEditProfile()">Cancelar</button>
                    <button type="submit" class="btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Cambiar Contraseña -->
<div class="config-modal" id="changePasswordModal">
    <div class="config-modal-content">
        <div class="config-modal-header">
            <h3>Cambiar Contraseña</h3>
            <button class="close-modal" onclick="closeChangePassword()">&times;</button>
        </div>
        <div class="config-modal-body">
            <form id="changePasswordForm">
                <div class="form-group">
                    <label for="passwordActual">Contraseña Actual *</label>
                    <input type="password" id="passwordActual" name="password_actual" required>
                </div>
                <div class="form-group">
                    <label for="passwordNueva">Contraseña Nueva *</label>
                    <input type="password" id="passwordNueva" name="password_nueva" required minlength="6">
                </div>
                <div class="form-group">
                    <label for="passwordConfirmar">Confirmar Contraseña Nueva *</label>
                    <input type="password" id="passwordConfirmar" name="password_confirmar" required minlength="6">
                </div>
                <div class="config-modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeChangePassword()">Cancelar</button>
                    <button type="submit" class="btn-primary">Cambiar Contraseña</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* ESTILOS PARA MODALES DE CONFIGURACIÓN */
.config-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    padding: 20px;
}

.config-modal.active {
    display: flex;
}

.config-modal-content {
    background: var(--card-bg);
    border-radius: 16px;
    max-width: 500px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
}

.config-modal-header {
    padding: 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.config-modal-header h3 {
    font-size: 20px;
    font-weight: 600;
    margin: 0;
}

.close-modal {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: var(--text-secondary);
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background-color 0.2s;
}

.close-modal:hover {
    background-color: var(--hover-bg);
}

.config-modal-body {
    padding: 20px;
}

.config-modal-footer {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 20px;
}
</style>

<script>

async function loadUserConfig() {
    if (!currentUser) return;
    
    try {
        const response = await fetch('api_configuraciones.php?action=get_config');
        const data = await response.json();
        
        if (data.success) {
            const config = data.config;
            
            
            document.getElementById('publicProfileToggle').classList.toggle('active', config.perfil_publico);
            document.getElementById('commentsToggle').classList.toggle('active', config.permitir_comentarios);
            document.getElementById('emailNotificationsToggle').classList.toggle('active', config.notificaciones_email);
            document.getElementById('pushNotificationsToggle').classList.toggle('active', config.notificaciones_push);
            
            
            const commentsStatus = document.getElementById('commentsStatus');
            if (commentsStatus) {
                commentsStatus.textContent = config.permitir_comentarios ? ' (Activado)' : ' (Desactivado)';
                commentsStatus.style.color = config.permitir_comentarios ? '#38a169' : '#e53e3e';
            }
        }
    } catch (error) {
        console.error('Error cargando configuraciones:', error);
    }
}

async function toggleSettingAndSave(element, settingName) {
    element.classList.toggle('active');
    
    if (!currentUser) return;
    
    try {
        const formData = new FormData();
        formData.append('action', 'update_config');
        formData.append('perfil_publico', document.getElementById('publicProfileToggle').classList.contains('active') ? 1 : 0);
        formData.append('permitir_comentarios', document.getElementById('commentsToggle').classList.contains('active') ? 1 : 0);
        formData.append('notificaciones_email', document.getElementById('emailNotificationsToggle').classList.contains('active') ? 1 : 0);
        formData.append('notificaciones_push', document.getElementById('pushNotificationsToggle').classList.contains('active') ? 1 : 0);
        
        const response = await fetch('api_configuraciones.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showToast(data.message, 'success');
        } else {
            
            element.classList.toggle('active');
            showToast(data.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        element.classList.toggle('active');
        showToast('Error al actualizar configuración', 'error');
    }
}


function showEditProfile() {
    if (!showLoginIfNeeded()) return;
    
    
    document.getElementById('editNombre').value = currentUser.nombre || '';
    document.getElementById('editApellido').value = currentUser.apellido || '';
    document.getElementById('editBio').value = ''; 
    
    document.getElementById('editProfileModal').classList.add('active');
}


function closeEditProfile() {
    document.getElementById('editProfileModal').classList.remove('active');
    document.getElementById('editProfileForm').reset();
}


document.getElementById('editProfileForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Guardando...';
    
    try {
        const formData = new FormData(this);
        formData.append('action', 'update_profile');
        
        const response = await fetch('api_configuraciones.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            
            currentUser.nombre = data.user.nombre;
            currentUser.apellido = data.user.apellido;
            currentUser.avatar = data.user.avatar;
            
            
            updateUserInterface();
            
            
            if (document.getElementById('profile').classList.contains('active')) {
                loadProfile();
            }
            
            closeEditProfile();
            showToast(data.message, 'success');
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error al actualizar perfil', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Guardar Cambios';
    }
});


function changePassword() {
    if (!showLoginIfNeeded()) return;
    document.getElementById('changePasswordModal').classList.add('active');
}


function closeChangePassword() {
    document.getElementById('changePasswordModal').classList.remove('active');
    document.getElementById('changePasswordForm').reset();
}


document.getElementById('changePasswordForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const passwordNueva = document.getElementById('passwordNueva').value;
    const passwordConfirmar = document.getElementById('passwordConfirmar').value;
    
    if (passwordNueva !== passwordConfirmar) {
        showToast('Las contraseñas no coinciden', 'error');
        return;
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Cambiando...';
    
    try {
        const formData = new FormData(this);
        formData.append('action', 'change_password');
        
        const response = await fetch('api_configuraciones.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            closeChangePassword();
            showToast(data.message, 'success');
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error al cambiar contraseña', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Cambiar Contraseña';
    }
});


document.getElementById('editProfileModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditProfile();
    }
});

document.getElementById('changePasswordModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeChangePassword();
    }
});


const originalShowSection = showSection;
showSection = function(sectionName) {
    originalShowSection(sectionName);
    
    if (sectionName === 'config' && currentUser) {
        loadUserConfig();
    }
};


window.showEditProfile = showEditProfile;
window.closeEditProfile = closeEditProfile;
window.changePassword = changePassword;
window.closeChangePassword = closeChangePassword;
window.loadUserConfig = loadUserConfig;
window.toggleSettingAndSave = toggleSettingAndSave;


async function openCommentsModal(postId) {
    if (!showLoginIfNeeded()) return;
    

    try {
        const response = await fetch(`api_interacciones.php?action=check_comments_allowed&post_id=${postId}`);
        const data = await response.json();
        
        if (!data.allowed) {
            showToast('El autor ha deshabilitado los comentarios en esta publicación', 'error');
            return;
        }
    } catch (error) {
        console.error('Error:', error);
    }
    
    currentPostId = postId;
    const modal = document.getElementById('commentsModal');
    modal.classList.add('active');
    
    await loadComments(postId);
}
</script>
</body>
</html>