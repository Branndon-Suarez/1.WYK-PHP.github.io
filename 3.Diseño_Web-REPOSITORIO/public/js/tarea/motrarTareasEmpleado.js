document.addEventListener('DOMContentLoaded', function() {
    // ---- Variables y elementos del DOM ----
    const openTasksBtn = document.getElementById('openTasksBtn');
    const tasksPanel = document.getElementById('tasksPanel');
    const closeTasksBtn = document.getElementById('closeTasksBtn');
    const timeline = document.getElementById('taskTimeline');

    // Función para abrir el panel de tareas
    function openTasksPanel() {
        tasksPanel.classList.add('open');
    }

    // Función para cerrar el panel de tareas
    function closeTasksPanel() {
        tasksPanel.classList.remove('open');
    }

    // ---- Funciones para manejar las peticiones a la base de datos ----
    
    // Función para revertir el estado de una tarea
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
                // Lógica para revertir la tarea
                fetch(`${APP_URL}api/tareas?action=undo&id=${taskId}`, {
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
    
    // Función para completar una tarea con confirmación de SweetAlert
    window.completeTask = async function(taskId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción marcará la tarea como completada.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4CAF50', // Color verde
            cancelButtonColor: '#d33', // Color rojo
            confirmButtonText: 'Sí, completar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false // Evita cerrar el modal al hacer clic afuera
        }).then((result) => {
            if (result.isConfirmed) {
                // Lógica para completar la tarea
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
    
    // ---- Eventos para el panel ----
    if (openTasksBtn) {
        openTasksBtn.addEventListener('click', openTasksPanel);
    }
    if (closeTasksBtn) {
        closeTasksBtn.addEventListener('click', closeTasksPanel);
    }
    document.addEventListener('click', function(event) {
        const isClickInsidePanel = tasksPanel.contains(event.target);
        const isClickOnOpenBtn = openTasksBtn.contains(event.target);
        if (!isClickInsidePanel && !isClickOnOpenBtn && tasksPanel.classList.contains('open')) {
            closeTasksPanel();
        }
    });

    // Agregar event listeners a los botones de la línea de tiempo
    if (timeline) {
        timeline.addEventListener('click', function(event) {
            const completeBtn = event.target.closest('.complete-btn');
            const undoBtn = event.target.closest('.undo-btn');

            if (completeBtn) {
                const taskId = completeBtn.closest('.task-item').dataset.taskId;
                window.completeTask(taskId);
            } else if (undoBtn) {
                const taskId = undoBtn.closest('.task-item').dataset.taskId;
                window.undoTask(taskId);
            }
        });
    }
});
