<?php
// Protege la vista (ajusta la condición según tu login)
if (!isset($_SESSION['userId'])) {
    header("Location: " . \config\APP_URL . "login");
    exit();
}
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

            <main class="pedido-container">
                <h2 class="titulo-pedido">🧾 Nuevo Pedido</h2>
                <!-- Datos de la venta -->
                <section class="form-grid">
                    <div class="form-group">
                        <label for="fechaVenta">Fecha y Hora</label>
                        <input type="datetime-local" id="fechaVenta" name="fechaVenta"
                            value="<?= date('Y-m-d\TH:i') ?>">
                    </div>

                    <div class="form-group">
                        <label for="numeroMesa">Número de Mesa</label>
                        <input type="number" id="numeroMesa" name="numeroMesa" placeholder="Ej: 5">
                    </div>

                    <div class="form-group">
                        <label for="estadoVenta">Estado del Pedido</label>
                        <select id="estadoVenta" name="estadoVenta">
                            <option value="PENDIENTE" selected>PENDIENTE</option>
                            <option value="ENTREGADA">ENTREGADA</option>
                            <option value="PAGADA">PAGADA</option>
                            <option value="CANCELADA">CANCELADA</option>
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label for="descripcion">Descripción (opcional)</label>
                        <input id="descripcion" name="descripcion" type="text" placeholder="Notas del pedido">
                    </div>
                </section>

                <!-- Productos -->
                <section class="productos-card">
                    <div class="productos-header">
                        <h3>Productos del Pedido</h3>
                        <div>
                            <button type="button" id="btnAddProducto" class="btn-azul" style="display: flex; align-items: center;">
                                <lord-icon
                                    src="https://cdn.lordicon.com/ueoydrft.json"
                                    trigger="hover"
                                    stroke="light"
                                    style="width:30px;height:30px">
                                </lord-icon>
                                Añadir Producto</button>
                        </div>
                    </div>

                    <div class="table-wrap">
                        <table class="tabla-productos">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th style="width:120px">Cantidad</th>
                                    <th style="width:140px">Precio Unitario</th>
                                    <th style="width:140px">Subtotal</th>
                                    <th style="width:90px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaProductos">
                                <!-- filas dinámicas -->
                            </tbody>
                        </table>
                    </div>

                    <div class="total-container">
                        <span class="total-label">TOTAL:</span>
                        <span id="totalGeneral" class="total-valor">0</span>
                    </div>
                </section>

                <!-- Botón aceptar -->
                <div class="btn-guardar-container">
                    <button id="btnGuardarPedido" class="btn-verde">✅ Aceptar Pedido</button>
                </div>
            </main>

            <!-- Modal productos (inicialmente hidden) -->
            <div id="modalProductos" class="modal hidden" aria-hidden="true">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Seleccionar Producto</h3>
                        <button id="btnCerrarModal" class="btn-cerrar" aria-label="Cerrar">
                            <lord-icon
                                src="https://cdn.lordicon.com/ebyacdql.json"
                                trigger="hover"
                                state="hover-cross-3"
                                colors="primary:#ffffff"
                                style="width:40px;height:40px">
                            </lord-icon>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="text" id="buscarProducto" placeholder="Buscar producto..." class="input-busqueda">

                        <div class="table-wrap">
                            <table class="tabla-productos">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th style="width:120px">Precio</th>
                                        <th style="width:120px">Quedan</th>
                                        <th style="width:90px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listaProductos">
                                    <!-- se llenará con JS al abrir modal -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS para CRUD -->
        <script src="<?= \config\APP_URL ?>public/js/pedido/pedidosMesero.js" defer></script>
        <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
        <script src="<?php echo \config\APP_URL; ?>public/js/dashboard.js"></script>

        <!-- LIBRERIAS -->
        <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
        <!-- <script src="https://unpkg.com/feather-icons"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"
            integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA="
            crossorigin="anonymous">
        </script>

</body>

</html>