document.addEventListener('DOMContentLoaded', function() {
    // ---- Variables y elementos del DOM ----
    const openTasksBtn = document.getElementById('openTasksBtn');
    const tasksPanel = document.getElementById('tasksPanel');
    const closeTasksBtn = document.getElementById('closeTasksBtn');

    // ---- Funciones para el panel de tareas ----
    function openTasksPanel() {
        if (tasksPanel) {
            tasksPanel.classList.add('open');
        }
    }

    function closeTasksPanel() {
        if (tasksPanel) {
            tasksPanel.classList.remove('open');
        }
    }

    // ---- Funciones para la barra de progreso ----
    function updateProgressBar() {
        const totalTasks = document.querySelectorAll('.task-item').length;
        // Cuenta tanto las tareas completadas como las canceladas
        const completedTasks = document.querySelectorAll('.task-item.completada, .task-item.cancelada').length;
        const progressFill = document.getElementById('progressFill');
        const progressText = document.getElementById('progressText');

        if (totalTasks > 0) {
            const percentage = Math.round((completedTasks / totalTasks) * 100);
            if (progressFill) {
                progressFill.style.width = `${percentage}%`;
            }
            if (progressText) {
                progressText.textContent = `${percentage}%`;
            }
        } else {
            if (progressFill) {
                progressFill.style.width = `0%`;
            }
            if (progressText) {
                progressText.textContent = `0%`;
            }
        }
    }

    // ---- Funciones para manejar las peticiones a la base de datos ----
    window.undoTask = async function(taskId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción marcará la tarea como pendiente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, revertir',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`${APP_URL}api/tareas?action=reset&id=${taskId}`, {
                    method: 'POST'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            '¡Revertida!',
                            'La tarea ha sido marcada como pendiente.',
                            'success'
                        ).then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al revertir la tarea.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error',
                        'Hubo un problema de conexión. Verifica la URL y la respuesta del servidor.',
                        'error'
                    );
                });
            }
        });
    };
    
    window.completeTask = async function(taskId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción marcará la tarea como completada.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4CAF50',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, completar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`${APP_URL}api/tareas?action=complete&id=${taskId}`, {
                    method: 'POST'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                         Swal.fire(
                            '¡Completada!',
                            'La tarea ha sido marcada como completada.',
                            'success'
                        ).then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al completar la tarea.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error',
                        'Hubo un problema de conexión. Verifica la URL y la respuesta del servidor.',
                        'error'
                    );
                });
            }
        });
    };
    
    // ---- Eventos para el panel y la barra de progreso ----
    if (openTasksBtn) {
        openTasksBtn.addEventListener('click', openTasksPanel);
    }
    if (closeTasksBtn) {
        closeTasksBtn.addEventListener('click', closeTasksPanel);
    }
    document.addEventListener('click', function(event) {
        if (tasksPanel && openTasksBtn) {
            const isClickInsidePanel = tasksPanel.contains(event.target);
            const isClickOnOpenBtn = openTasksBtn.contains(event.target);
            if (!isClickInsidePanel && !isClickOnOpenBtn && tasksPanel.classList.contains('open')) {
                closeTasksPanel();
            }
        }
    });

    // Actualiza la barra de progreso al cargar la página
    updateProgressBar();
});
