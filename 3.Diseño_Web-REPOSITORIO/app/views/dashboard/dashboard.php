<?php
$success_message = '';
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

$error_message = '';
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

$active_page = 'dashboard';
?>

<!DOCTYPE html>
<html lang="es">

<body data-theme="light">
    <div class="app">
        <!-- Sidebar -->
        <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
        <!-- Icono de tareas de empleados -->
        <?php
        if (isset($_SESSION['rolClasificacion']) && $_SESSION['rolClasificacion'] === 'EMPLEADO') {
            require_once __DIR__ . '/../layouts/floatingIcon.php';
        }
        ?>
        <!-- Lista de tareas para empleados -->
        <div class="tasks-panel" id="tasksPanel">
            <div class="tasks-header">
                <h2 class="tasks-title">Mis Tareas</h2>
                <button class="close-tasks-btn" id="closeTasksBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="tareas-content" class="tasks-content-wrapper">
                <?php include 'app/views/tarea/viewTareaEmpleado.php'; ?>
            </div>
        </div>

        <div class="main-content">
            <div class="header">
                <div>
                    <div class="s">Buenos días,
                        <span class="n"><?php echo $_SESSION['userName']; ?></span>
                    </div>
                    <div class="subtitle">Ten un buen día en el trabajo</div>
                </div>
                <div class="header-actions">
                    <button class="action-btn" id="themeToggle" title="Cambiar tema">
                        <i class="fas fa-moon"></i>
                    </button>
                    <button class="action-btn" id="notificationsBtn" title="Notificaciones">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="user-info">
                        <div class="user-avatar" id="userAvatar">JD</div>
                        <span><?php echo $_SESSION['userName']; ?></span>
                    </div>
                </div>
            </div>

            <div class="content-grid">
                <div class="profile-card">
                    <div class="profile-image-container">
                        <div class="profile-image" id="profileImage">
                            JD
                            <div class="online-indicator"></div>
                        </div>
                        <button class="change-photo-btn" id="changePhotoBtn" title="Cambiar foto">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <div class="profile-name"><?php echo $_SESSION['userName']; ?></div>
                    <div class="profile-company"><?php echo $_SESSION['rol']; ?></div>

                    <div class="contact-buttons">
                        <button class="contact-btn phone" onclick="makeCall()" title="Llamar">
                            <i class="fas fa-phone"></i>
                        </button>
                        <button class="contact-btn message" onclick="sendMessage()" title="Mensaje">
                            <i class="fas fa-comment"></i>
                        </button>
                        <button class="contact-btn email" onclick="sendEmail()" title="Email">
                            <i class="fas fa-envelope"></i>
                        </button>
                        <button class="contact-btn location" onclick="showLocation()" title="Ubicación">
                            <i class="fas fa-map-marker-alt"></i>
                        </button>
                    </div>

                    <div class="contact-info">
                        <div class="contact-item">
                            <span class="contact-label">
                                <i class="fas fa-phone"></i> Teléfono
                            </span>
                            <span class="contact-value">+57 <?php echo $_SESSION['userTel']; ?></span>
                        </div>
                        <div class="contact-item">
                            <span class="contact-label">
                                <i class="fas fa-envelope"></i> Email
                            </span>
                            <span class="contact-value"><?php echo $_SESSION['userEmail']; ?></span>
                        </div>
                    </div>
                </div>

                <div class="main-content">
                    <div id="tarea-empleado-container" class="hidden-panel">
                        <?php require_once __DIR__ . '/../tarea/viewTareaEmpleado.php'; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications Panel -->
        <div class="notifications-panel" id="notificationsPanel">
            <div class="notification-header">
                <h3>Notificaciones</h3>
                <button class="modal-close" id="closeNotifications">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="notificationsList">
                <div class="notification-item unread">
                    <strong>Nueva tarea asignada</strong>
                    <p>Se te ha asignado "Recibir Pedido de cocacola"</p>
                    <small>Hace 2 horas</small>
                </div>
                <div class="notification-item unread">
                    <strong>Agendar nuevo pedido</strong>
                    <p>Agendar pedido mayorista mañana a las 10:00 AM </p>
                    <small>Hace 4 horas</small>
                </div>
                <div class="notification-item unread">
                    <strong>Tarea completada</strong>
                    <p>Has completado exitosamente la tarea "Nuevo menu del fin de semana"</p>
                    <small>Ayer</small>
                </div>
            </div>
        </div>

        <!-- Add Task Modal -->
        <div class="modal" id="addTaskModal">
            <div class="modal-content">
                <button class="modal-close" id="closeTaskModal">
                    <i class="fas fa-times"></i>
                </button>
                <h2>Agregar Nueva Tarea</h2>
                <form id="addTaskForm">
                    <div class="form-group">
                        <label class="form-label">Nombre de la tarea</label>
                        <input type="text" class="form-input" id="taskName"
                            placeholder="Ej. Desarrollar componente React" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-textarea" id="taskDescription"
                            placeholder="Describe los detalles de la tarea..." rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Categoría</label>
                        <select class="form-select" id="taskCategory">
                            <option value="desarrollo">Pedidos mayoristas</option>
                            <option value="diseño">Pedidos de preparacion</option>
                            <option value="testing">Organizacion de productos</option>
                            <option value="documentacion">Registrar Compras</option>
                            <option value="reunion">Limpieza y organizacion de herramientas de trabajo</option>
                            <option value="investigacion">Registrar y Actualizar ventas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tiempo estimado (horas)</label>
                        <input type="number" class="form-input" id="taskHours" min="1" max="40" value="4">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prioridad</label>
                        <select class="form-select" id="taskPriority">
                            <option value="baja">Baja</option>
                            <option value="media">Media</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-button">
                            <i class="fas fa-plus"></i> Crear Tarea
                        </button>
                        <button type="button" class="form-button secondary" id="cancelTask">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Photo Modal -->
        <div class="modal" id="changePhotoModal">
            <div class="modal-content">
                <button class="modal-close" id="closePhotoModal">
                    <i class="fas fa-times"></i>
                </button>
                <h2>Cambiar Foto de Perfil</h2>
                <div class="form-group">
                    <label class="form-label">Seleccionar foto</label>
                    <input type="file" class="form-input" id="photoInput" accept="image/*">
                </div>
                <div class="form-group">
                    <label class="form-label">O elegir un avatar predefinido</label>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 15px;">
                        <div class="avatar-option" data-avatar="NP"
                            style="background: linear-gradient(45deg, #3498db, #2c3e50);">JD</div>
                        <div class="avatar-option" data-avatar="👨‍💼"
                            style="background: linear-gradient(45deg, #e74c3c, #c0392b);">👨‍💼</div>
                        <div class="avatar-option" data-avatar="👩‍💻"
                            style="background: linear-gradient(45deg, #27ae60, #229954);">👩‍💻</div>
                        <div class="avatar-option" data-avatar="👨‍🎨"
                            style="background: linear-gradient(45deg, #f39c12, #d68910);">👨‍🎨</div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="form-button" id="savePhoto">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <button type="button" class="form-button secondary" id="cancelPhoto">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Toads y var global -->
    <script>
        const APP_URL = "<?php echo \config\APP_URL; ?>";

        const successMessage = "<?php echo $success_message; ?>";
        const errorMessage = "<?php echo $error_message; ?>";
    </script>
    <script src="<?php echo \config\APP_URL; ?>public/js/toads-sweetalert2.js"></script>

    <!-- JS para CRUD -->
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/dashboard.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/cargo/confirmState.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/cargo/confirmDelete.js"></script>

    <!-- LIBRERIAS -->
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <!-- <script src="https://unpkg.com/feather-icons"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"
        integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA="
        crossorigin="anonymous">
    </script>
</body>

</html>