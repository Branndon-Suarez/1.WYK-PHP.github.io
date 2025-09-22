// Variables globales
let currentTheme = 'light';
let taskCounter = 4;
let tasks = [
    {
        id: 1,
        name: 'Compras y Ventas',
        description: 'Recibir Pedido de cocacola',
        category: 'desarrollo',
        hours: 1,
        priority: 'alta',
        status: 'completed',
        icon: 'fas fa-truck'
    },
    {
        id: 2,
        name: 'Agendar pedido mayorista',
        description: 'pedido mayorista lunes 21',
        category: 'diseño',
        hours: 0.5,
        priority: 'media',
        status: 'in-progress',
        icon: 'fas fa-calendar-week'
    },
    {
        id: 3,
        name: 'Actualizar Menú',
        description: 'Nuevo menu del fin de semana',
        category: 'desarrollo',
        hours: 1,
        priority: 'baja',
        status: 'pending',
        icon: 'fas fa-utensils'
    }
];

// Gestión de tareas
function completeTask(taskId) {
    const task = tasks.find(t => t.id === taskId);
    if (task) {
        task.status = 'completed';
        updateTaskDisplay();
        updateProgress();
        showNotification(`✅ Tarea "${task.name}" completada exitosamente`, 'success');
        addNotification(`Tarea completada: ${task.name}`, 'Has completado exitosamente esta tarea');
    }
}

function deleteTask(taskId) {
    if (confirm('¿Estás seguro de que deseas eliminar esta tarea?')) {
        tasks = tasks.filter(t => t.id !== taskId);
        updateTaskDisplay();
        updateProgress();
        showNotification('🗑️ Tarea eliminada correctamente', 'info');
    }
}

function updateTaskDisplay() {
    const timeline = document.getElementById('taskTimeline');
    timeline.innerHTML = '';

    tasks.forEach((task, index) => {
        const timelineItem = document.createElement('div');
        timelineItem.className = 'timeline-item';
        timelineItem.style.animationDelay = `${index * 0.1}s`;

        const dotClass = task.status === 'completed' ? 'dot-completed' :
            task.status === 'in-progress' ? 'dot-in-progress' : 'dot-pending';

        const statusText = task.status === 'completed' ? 'Completado' :
            task.status === 'in-progress' ? 'En progreso' : 'Pendiente';

        const priorityColor = {
            'baja': '#95a5a6',
            'media': '#f39c12',
            'alta': '#e67e22',
            'urgente': '#e74c3c'
        }[task.priority];

        timelineItem.innerHTML = `
                    <div class="timeline-dot ${dotClass}"></div>
                    <div class="task-item ${task.status}" data-task-id="${task.id}">
                        <div class="task-icon">
                            <i class="${task.icon}"></i>
                        </div>
                        <div class="task-info">
                            <div class="task-name">${task.name}</div>
                            <div class="task-description">${task.description}</div>
                            <div class="task-meta">
                                <span><i class="fas fa-clock"></i> ${task.hours} hora${task.hours !== 1 ? 's' : ''}</span>
                                <span><i class="fas fa-calendar"></i> ${statusText}</span>
                                <span style="color: ${priorityColor}"><i class="fas fa-exclamation-circle"></i> ${task.priority.toUpperCase()}</span>
                            </div>
                        </div>
                        <div class="task-actions">
                            ${task.status !== 'completed' ?
                `<button class="task-action-btn complete-btn" onclick="completeTask(${task.id})">
                                    <i class="fas fa-${task.status === 'pending' ? 'play' : 'check'}"></i>
                                </button>` : ''}
                            <button class="task-action-btn delete-btn" onclick="deleteTask(${task.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;

        timeline.appendChild(timelineItem);
    });
}

function updateProgress() {
    const completedTasks = tasks.filter(t => t.status === 'completed').length;
    const totalTasks = tasks.length;
    const progress = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;

    document.getElementById('progressFill').style.width = progress + '%';
    document.getElementById('progressText').textContent = progress + '%';
}

// Gestión de tema
function toggleTheme() {
    try {
        currentTheme = currentTheme === 'light' ? 'dark' : 'light';
        document.body.setAttribute('data-theme', currentTheme);

        const themeIcon = document.querySelector('#themeToggle i');
        if (themeIcon) {
            themeIcon.className = currentTheme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
        }

        // Guardar en variable en lugar de localStorage
        showNotification(`Tema cambiado a ${currentTheme === 'light' ? 'claro' : 'oscuro'}`, 'info');
    } catch (error) {
        console.error('Error al cambiar tema:', error);
    }
}

// Gestión de notificaciones
function addNotification(title, message, type = 'info') {
    const notificationsList = document.getElementById('notificationsList');
    const notification = document.createElement('div');
    notification.className = 'notification-item unread';

    const now = new Date();
    const timeStr = now.getHours().toString().padStart(2, '0') + ':' +
        now.getMinutes().toString().padStart(2, '0');

    notification.innerHTML = `
                <strong>${title}</strong>
                <p>${message}</p>
                <small>Ahora (${timeStr})</small>
            `;

    notificationsList.insertBefore(notification, notificationsList.firstChild);

    // Actualizar contador
    const badge = document.querySelector('.notification-badge');
    const currentCount = parseInt(badge.textContent) || 0;
    badge.textContent = currentCount + 1;
}

function showNotification(message, type = 'info') {
    try {
        // Crear notificación temporal en pantalla
        const notification = document.createElement('div');
        const colors = {
            'success': '#27ae60',
            'error': '#e74c3c',
            'info': '#3498db',
            'warning': '#f39c12'
        };

        notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: ${colors[type] || colors.info};
                    color: white;
                    padding: 15px 20px;
                    border-radius: 10px;
                    box-shadow: 0 10px 30px rgba(44, 62, 80, 0.2);
                    z-index: 3000;
                    max-width: 300px;
                    font-weight: 500;
                    font-family: 'Segoe UI', sans-serif;
                    transform: translateX(100%);
                    opacity: 0;
                    transition: all 0.3s ease;
                `;

        notification.textContent = message;
        document.body.appendChild(notification);

        // Animar entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
            notification.style.opacity = '1';
        }, 100);

        // Animar salida y remover
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => {
                if (notification.parentNode) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    } catch (error) {
        console.error('Error al mostrar notificación:', error);
    }
}

// Gestión de foto de perfil
function setupPhotoChange() {
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    const changePhotoModal = document.getElementById('changePhotoModal');
    const closePhotoModal = document.getElementById('closePhotoModal');
    const cancelPhoto = document.getElementById('cancelPhoto');
    const savePhoto = document.getElementById('savePhoto');
    const photoInput = document.getElementById('photoInput');
    const profileImage = document.getElementById('profileImage');
    const userAvatar = document.getElementById('userAvatar');

    if (!changePhotoBtn || !changePhotoModal || !closePhotoModal || !cancelPhoto || !savePhoto || !photoInput || !profileImage || !userAvatar) {
        console.error('Algunos elementos del modal de foto no se encontraron');
        return;
    }

    let selectedAvatar = null;
    let selectedFile = null;

    changePhotoBtn.addEventListener('click', (e) => {
        e.preventDefault();
        changePhotoModal.style.display = 'flex';
    });

    [closePhotoModal, cancelPhoto].forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            changePhotoModal.style.display = 'none';
            selectedAvatar = null;
            selectedFile = null;
        });
    });

    // Manejo de avatares predefinidos
    setTimeout(() => {
        document.querySelectorAll('.avatar-option').forEach(option => {
            option.style.cssText = `
                        width: 60px;
                        height: 60px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: white;
                        font-size: 20px;
                        font-weight: bold;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        border: 3px solid transparent;
                    `;

            option.addEventListener('click', (e) => {
                e.preventDefault();
                document.querySelectorAll('.avatar-option').forEach(opt => {
                    opt.style.border = '3px solid transparent';
                    opt.style.transform = 'scale(1)';
                });
                option.style.border = '3px solid #3498db';
                option.style.transform = 'scale(1.1)';
                selectedAvatar = option.dataset.avatar;
                selectedFile = null;
                if (photoInput) photoInput.value = '';
            });
        });
    }, 100);

    photoInput.addEventListener('change', (e) => {
        if (e.target.files && e.target.files[0]) {
            selectedFile = e.target.files[0];
            selectedAvatar = null;
            document.querySelectorAll('.avatar-option').forEach(opt => {
                opt.style.border = '3px solid transparent';
                opt.style.transform = 'scale(1)';
            });
        }
    });

    savePhoto.addEventListener('click', (e) => {
        e.preventDefault();
        try {
            if (selectedFile) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    if (profileImage) profileImage.innerHTML = `<img src="${e.target.result}" alt="Profile" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;
                    if (userAvatar) userAvatar.innerHTML = `<img src="${e.target.result}" alt="Profile" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;
                    showNotification('Foto de perfil actualizada', 'success');
                };
                reader.readAsDataURL(selectedFile);
            } else if (selectedAvatar) {
                if (profileImage) profileImage.innerHTML = selectedAvatar;
                if (userAvatar) userAvatar.innerHTML = selectedAvatar;
                showNotification('Avatar actualizado', 'success');
            }
            changePhotoModal.style.display = 'none';
            selectedAvatar = null;
            selectedFile = null;
        } catch (error) {
            console.error('Error al guardar foto:', error);
            showNotification('Error al actualizar foto', 'error');
        }
    });
}

// Gestión de modal de tareas
function setupTaskModal() {
    const addTaskBtn = document.getElementById('addTaskBtn');
    const addTaskModal = document.getElementById('addTaskModal');
    const closeTaskModal = document.getElementById('closeTaskModal');
    const cancelTask = document.getElementById('cancelTask');
    const addTaskForm = document.getElementById('addTaskForm');

    const categoryIcons = {
        'desarrollo': 'fas fa-shopping-cart',
        'diseño': 'fas fa-cookie-bite',
        'testing': 'fas fa-box',
        'documentacion': 'fas fa-receipt',
        'reunion': 'fas fa-broom',
        'investigacion': 'fas fa-chart-line'
    };

    addTaskBtn.addEventListener('click', () => {
        addTaskModal.style.display = 'flex';
    });

    [closeTaskModal, cancelTask].forEach(btn => {
        btn.addEventListener('click', () => {
            addTaskModal.style.display = 'none';
            addTaskForm.reset();
        });
    });

    addTaskForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const newTask = {
            id: taskCounter++,
            name: document.getElementById('taskName').value,
            description: document.getElementById('taskDescription').value,
            category: document.getElementById('taskCategory').value,
            hours: parseInt(document.getElementById('taskHours').value),
            priority: document.getElementById('taskPriority').value,
            status: 'pending',
            icon: categoryIcons[document.getElementById('taskCategory').value] || 'fas fa-tasks'
        };

        tasks.push(newTask);
        updateTaskDisplay();
        updateProgress();
        addTaskModal.style.display = 'none';
        addTaskForm.reset();

        showNotification(`✅ Tarea "${newTask.name}" creada exitosamente`, 'success');
        addNotification('Nueva tarea creada', `Se ha creado la tarea: ${newTask.name}`);
    });
}

// Inicialización
document.addEventListener('DOMContentLoaded', () => {
    try {
        // Configurar tema inicial
        currentTheme = 'light';
        document.body.setAttribute('data-theme', currentTheme);

        // Event listeners principales
        const themeToggle = document.getElementById('themeToggle');
        const notificationsBtn = document.getElementById('notificationsBtn');
        const notificationsPanel = document.getElementById('notificationsPanel');
        const closeNotifications = document.getElementById('closeNotifications');

        if (themeToggle) {
            themeToggle.addEventListener('click', (e) => {
                e.preventDefault();
                toggleTheme();
            });
        }

        if (notificationsBtn && notificationsPanel) {
            notificationsBtn.addEventListener('click', (e) => {
                e.preventDefault();
                notificationsPanel.classList.toggle('open');
            });
        }

        if (closeNotifications && notificationsPanel) {
            closeNotifications.addEventListener('click', (e) => {
                e.preventDefault();
                notificationsPanel.classList.remove('open');
            });
        }

        // Cerrar notificaciones al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (notificationsPanel && notificationsBtn) {
                if (!notificationsPanel.contains(e.target) && !notificationsBtn.contains(e.target)) {
                    notificationsPanel.classList.remove('open');
                }
            }
        });

        // Cerrar modales al hacer clic fuera
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });

        // Inicializar funcionalidades
        setupPhotoChange();
        setupTaskModal();
        updateProgress();

        // Animación de carga
        setTimeout(() => {
            const elements = document.querySelectorAll('.profile-card, .tasks-card, .header');
            elements.forEach((element, index) => {
                if (element) {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(30px)';

                    setTimeout(() => {
                        element.style.transition = 'all 0.6s ease';
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }, index * 200);
                }
            });
        }, 100);

        // Saludo dinámico
        updateGreeting();
        setInterval(updateGreeting, 60000);

        // Mostrar notificación de bienvenida
        setTimeout(() => {
            showNotification('¡Bienvenido a tu dashboard de la Panaderia WYK!', 'success');
        }, 1000);

    } catch (error) {
        console.error('Error en inicialización:', error);
    }
});

function updateGreeting() {
    try {
        const now = new Date();
        const hour = now.getHours();
        let greeting = 'Buenos días';

        if (hour >= 12 && hour < 18) {
            greeting = 'Buenas tardes';
        } else if (hour >= 18) {
            greeting = 'Buenas noches';
        }

        const greetingElement = document.querySelector('.greeting');
        if (greetingElement) {
            greetingElement.innerHTML = `${greeting}, <span class="name">Juan David</span>`;
        }
    } catch (error) {
        console.error('Error al actualizar saludo:', error);
    }
}

window.addEventListener('load', () => {
    console.log('Dashboard de Panadería WYK cargado correctamente');
});