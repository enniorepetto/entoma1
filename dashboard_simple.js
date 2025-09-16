// Dashboard JavaScript - Versión simplificada
console.log('Dashboard JS cargado');

let currentSection = 'feed';

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM listo, inicializando...');
    initializeDashboard();
});

function initializeDashboard() {
    setupNavigation();
    setupCreateForm();
    loadInitialContent();
}

// Configurar navegación
function setupNavigation() {
    const menuItems = document.querySelectorAll('.menu-item');
    console.log('Menu items encontrados:', menuItems.length);
    
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const section = this.getAttribute('data-section');
            console.log('Navegando a:', section);
            
            // Actualizar menu activo
            menuItems.forEach(mi => mi.classList.remove('active'));
            this.classList.add('active');
            
            // Mostrar sección
            showSection(section);
        });
    });
}

function showSection(sectionName) {
    console.log('Mostrando sección:', sectionName);
    
    // Ocultar todas las secciones
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => section.classList.remove('active'));
    
    // Mostrar sección objetivo
    const targetSection = document.getElementById(sectionName);
    if (targetSection) {
        targetSection.classList.add('active');
        currentSection = sectionName;
        
        // Cargar contenido según sección
        loadSectionContent(sectionName);
    } else {
        console.error('Sección no encontrada:', sectionName);
    }
}

function loadSectionContent(sectionName) {
    switch(sectionName) {
        case 'feed':
            loadFeedPosts();
            break;
        case 'explore':
            loadExplorePosts();
            break;
        case 'trending':
            loadTrendingPosts();
            break;
        case 'notifications':
            loadNotifications();
            break;
        // Las otras secciones no necesitan carga especial por ahora
    }
}

function loadInitialContent() {
    console.log('Cargando contenido inicial...');
    loadFeedPosts();
    loadNotifications();
}

// Funciones para cargar contenido
async function loadFeedPosts() {
    console.log('Cargando feed...');
    const feedGrid = document.getElementById('feedGrid');
    if (!feedGrid) {
        console.error('Feed grid no encontrado');
        return;
    }
    
    // Mostrar loading
    feedGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #767676;">Cargando posts...</div>';
    
    try {
        const response = await fetch('api_posts.php?action=feed');
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.text();
        console.log('Raw response:', data);
        
        let posts;
        try {
            posts = JSON.parse(data);
        } catch (jsonError) {
            console.error('Error parsing JSON:', jsonError);
            console.log('Response data:', data);
            throw new Error('Invalid JSON response');
        }
        
        console.log('Posts cargados:', posts.length);
        
        feedGrid.innerHTML = '';
        
        if (!posts || posts.length === 0) {
            feedGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #767676;">No hay publicaciones disponibles.<br><button onclick="loadFeedPosts()" style="margin-top: 10px; padding: 8px 16px; background: #111; color: white; border: none; border-radius: 8px; cursor: pointer;">Recargar</button></div>';
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
                Error al cargar las publicaciones: ${error.message}<br>
                <button onclick="loadFeedPosts()" style="margin-top: 10px; padding: 8px 16px; background: #111; color: white; border: none; border-radius: 8px; cursor: pointer;">Reintentar</button>
            </div>
        `;
    }
}

async function loadExplorePosts() {
    console.log('Cargando explore...');
    const exploreGrid = document.getElementById('exploreGrid');
    if (!exploreGrid) return;
    
    exploreGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #767676;">Cargando contenido para explorar...</div>';
    
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
    console.log('Cargando trending...');
    const trendingGrid = document.getElementById('trendingGrid');
    if (!trendingGrid) return;
    
    trendingGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #767676;">Cargando tendencias...</div>';
    
    try {
        const response = await fetch('api_posts.php?action=trending');
        const posts = await response.json();
        
        trendingGrid.innerHTML = '';
        
        posts.forEach(post => {
            const postElement = createPostCard(post, true);
            trendingGrid.appendChild(postElement);
        });
        
    } catch (error) {
        console.error('Error cargando trending:', error);
        trendingGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #767676;">Error al cargar tendencias</div>';
    }
}

function loadNotifications() {
    console.log('Cargando notificaciones...');
    const notificationsList = document.getElementById('notificationsList');
    if (!notificationsList) return;
    
    // Datos de ejemplo para notificaciones
    const sampleNotifications = [
        {
            user: '@maria_style',
            userAvatar: 'M',
            action: 'le gustó tu outfit "Look casual viernes"',
            time: 'hace 2 minutos',
            unread: true
        },
        {
            user: '@fashionlover', 
            userAvatar: 'F',
            action: 'comentó: "¡Me encanta este estilo!"',
            time: 'hace 1 hora',
            unread: true
        },
        {
            user: '@style_guru',
            userAvatar: 'S', 
            action: 'comenzó a seguirte',
            time: 'hace 3 horas',
            unread: false
        }
    ];
    
    notificationsList.innerHTML = '';
    
    sampleNotifications.forEach(notification => {
        const item = document.createElement('div');
        item.className = `notification-item ${notification.unread ? 'unread' : ''}`;
        
        item.innerHTML = `
            <div class="notification-avatar">${notification.userAvatar}</div>
            <div class="notification-content">
                <div class="notification-text">
                    <strong>${notification.user}</strong> ${notification.action}
                </div>
                <div class="notification-time">${notification.time}</div>
            </div>
        `;
        
        notificationsList.appendChild(item);
    });
}

function createPostCard(post, isTrending = false) {
    const card = document.createElement('div');
    card.className = 'post-card';
    
    const trendingBadge = isTrending ? '<div class="trending-badge">🏆 Outfit más votado del día</div>' : '';
    
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
                <span>💬 ${post.comments}</span>
                <span onclick="savePost(${post.id})" style="cursor: pointer;">🔖</span>
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
    console.log('Like post:', postId);
    alert('Función de likes en desarrollo');
}

function savePost(postId) {
    console.log('Save post:', postId);
    alert('Función de guardar en desarrollo');
}

// Funciones globales para el modal de perfil
window.openProfileModal = function() {
    console.log('Abriendo modal de perfil...');
    const modal = document.getElementById('profileModal');
    if (modal) {
        modal.classList.add('active');
        loadUserProfile();
    }
};

window.closeProfileModal = function() {
    const modal = document.getElementById('profileModal');
    if (modal) {
        modal.classList.remove('active');
    }
};

async function loadUserProfile() {
    console.log('Cargando perfil de usuario...');
    // Implementar carga de perfil más tarde
}

// Event listeners globales
document.addEventListener('click', function(e) {
    // Marcar notificaciones como leídas
    if (e.target.classList.contains('mark-read-btn')) {
        const unreadNotifications = document.querySelectorAll('.notification-item.unread');
        unreadNotifications.forEach(item => item.classList.remove('unread'));
    }
    
    // Filtros de explorar
    if (e.target.classList.contains('filter-btn')) {
        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => btn.classList.remove('active'));
        e.target.classList.add('active');
        loadExplorePosts();
    }
    
    // Cerrar modal al hacer click fuera
    if (e.target.id === 'profileModal') {
        window.closeProfileModal();
    }
});

// Exponer funciones necesarias globalmente
window.loadFeedPosts = loadFeedPosts;
window.likePost = likePost;
window.savePost = savePost;