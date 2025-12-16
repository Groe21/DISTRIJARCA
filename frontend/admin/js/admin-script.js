/**
 * DISTRI-JARCA - Admin Dashboard JavaScript
 */

// ========== SIDEBAR TOGGLE ==========
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Para desktop: colapsar/expandir
            if (window.innerWidth > 991) {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('sidebar-collapsed');
                sidebarToggle.classList.toggle('active');
                
                // Guardar estado en localStorage
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            } 
            // Para móvil: mostrar/ocultar
            else {
                sidebar.classList.toggle('active');
            }
        });

        // Cerrar sidebar al hacer click fuera en móvil
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 991) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Restaurar estado del sidebar desde localStorage
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true' && window.innerWidth > 991) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('sidebar-collapsed');
            sidebarToggle.classList.add('active');
        }

        // Ajustar comportamiento al cambiar tamaño de ventana
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                sidebar.classList.remove('active');
                // Restaurar estado colapsado si estaba guardado
                const savedState = localStorage.getItem('sidebarCollapsed');
                if (savedState === 'true') {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('sidebar-collapsed');
                    sidebarToggle.classList.add('active');
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('sidebar-collapsed');
                    sidebarToggle.classList.remove('active');
                }
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('sidebar-collapsed');
            }
        });
    }
});

// ========== ACTIVE MENU ITEM ==========
const currentPage = window.location.pathname.split('/').pop();
const menuItems = document.querySelectorAll('.menu-item');

menuItems.forEach(item => {
    const href = item.getAttribute('href');
    if (href && href.includes(currentPage)) {
        // Remover active de todos
        menuItems.forEach(mi => mi.classList.remove('active'));
        // Agregar active al actual
        item.classList.add('active');
    }
});

// ========== NOTIFICACIONES ==========
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 90px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 16px rgba(0,0,0,0.2);';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// ========== STATS COUNTER ANIMATION ==========
function animateCounters() {
    const counters = document.querySelectorAll('.stat-info h3');
    
    counters.forEach(counter => {
        const target = parseInt(counter.innerText.replace(/\+/g, ''));
        if (isNaN(target)) return;
        
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                counter.innerText = target + (counter.innerText.includes('+') ? '+' : '');
                clearInterval(timer);
            } else {
                counter.innerText = Math.floor(current) + (counter.innerText.includes('+') ? '+' : '');
            }
        }, 16);
    });
}

// Ejecutar animación al cargar
window.addEventListener('load', animateCounters);

// ========== CONFIRMACIÓN DE ACCIONES ==========
function confirmAction(message) {
    return confirm(message);
}

// ========== FORMATO DE FECHA ==========
function formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(date).toLocaleDateString('es-ES', options);
}

// ========== BÚSQUEDA EN TIEMPO REAL ==========
function setupSearch(inputId, targetClass) {
    const searchInput = document.getElementById(inputId);
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const items = document.querySelectorAll(targetClass);
        
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
}

// ========== ORDENAR TABLAS ==========
function sortTable(table, column, asc = true) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aText = a.children[column].textContent.trim();
        const bText = b.children[column].textContent.trim();
        
        return asc ? aText.localeCompare(bText) : bText.localeCompare(aText);
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

// ========== VALIDACIÓN DE FORMULARIOS ==========
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('is-invalid');
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    return isValid;
}

// ========== AUTO-SAVE DRAFT ==========
let autoSaveTimer;

function enableAutoSave(formId, interval = 30000) {
    const form = document.getElementById(formId);
    if (!form) return;
    
    clearInterval(autoSaveTimer);
    
    autoSaveTimer = setInterval(() => {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        localStorage.setItem(`draft_${formId}`, JSON.stringify(data));
        console.log('Borrador guardado automáticamente');
        showNotification('Borrador guardado', 'info');
    }, interval);
}

// ========== RESTAURAR DRAFT ==========
function restoreDraft(formId) {
    const draft = localStorage.getItem(`draft_${formId}`);
    if (!draft) return false;
    
    const data = JSON.parse(draft);
    const form = document.getElementById(formId);
    if (!form) return false;
    
    Object.keys(data).forEach(key => {
        const field = form.querySelector(`[name="${key}"]`);
        if (field) field.value = data[key];
    });
    
    return true;
}

// ========== COPIAR AL PORTAPAPELES ==========
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showNotification('Copiado al portapapeles', 'success');
    }).catch(() => {
        showNotification('Error al copiar', 'danger');
    });
}

// ========== LOADING OVERLAY ==========
function showLoading(message = 'Cargando...') {
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
    overlay.style.cssText = 'background: rgba(0,0,0,0.7); z-index: 9999;';
    overlay.innerHTML = `
        <div class="text-center text-white">
            <div class="spinner-border mb-3" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <div>${message}</div>
        </div>
    `;
    
    document.body.appendChild(overlay);
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.remove();
}

// ========== EXPORTAR DATOS ==========
function exportToCSV(data, filename) {
    const csv = data.map(row => row.join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}

// ========== CONSOLE LOG ==========
console.log('%c🧀 DISTRI-JARCA Admin Panel 🥓', 'font-size: 20px; font-weight: bold; color: #DA251D;');
console.log('%cPanel de Administración v1.0', 'font-size: 12px; color: #102542;');
