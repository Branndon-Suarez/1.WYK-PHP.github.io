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
        <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
        <?php
        if (isset($_SESSION['rolClasificacion']) && $_SESSION['rolClasificacion'] === 'EMPLEADO') {
            require_once __DIR__ . '/../layouts/floatingIcon.php';
        }
        ?>
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
            <button type="button" class="volver" onclick="history.back()">
            <i data-feather="arrow-left"></i> Volver
            </button>

            <main class="pedido-container">
                <h2 class="titulo-pedido">🧾 Nuevo Pedido</h2>
                <section class="form-grid">
                    <div class="form-group">
                        <label for="fechaVenta">Fecha y Hora</label>
                        <input type="datetime-local" id="fechaVenta" name="fechaVenta"
                            value="">
                    </div>

                    <div class="form-group">
                        <label for="numeroMesa">Número de Mesa</label>
                        <input type="number" id="numeroMesa" name="numeroMesa" placeholder="Ej: 5">
                    </div>

                    <div class="form-group">
                        <label for="estadoPedido">Estado del Pedido</label>
                        <select id="estadoPedido" name="estadoPedido">
                            <option select value="PENDIENTE" selected>PENDIENTE</option>
                        <?php if ($_SESSION['rol'] == 'ADMINISTRADOR') {
                        ?>
                            <option value="PREPARANDO">PREPARANDO</option>
                            <option value="ENTREGADO">ENTREGADO</option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estadoPago">Estado del Pago</label>
                        <select id="estadoPago" name="estadoPago">
                            <option seelct value="PENDIENTE" selected>PENDIENTE</option>
                        <?php if ($_SESSION['rol'] == 'ADMINISTRADOR') {
                        ?>
                            <option value="PAGADA">PAGADA</option>
                            <option value="CANCELADA">CANCELADA</option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label for="descripcion">Descripción (opcional)</label>
                        <input id="descripcion" name="descripcion" type="text" placeholder="Notas del pedido">
                    </div>
                </section>

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
                            </tbody>
                        </table>
                    </div>

                    <div class="total-container">
                        <span class="total-label">TOTAL:</span>
                        <span id="totalGeneral" class="total-valor">0</span>
                    </div>
                </section>

                <div class="btn-guardar-container">
                    <button id="btnGuardarPedido" class="btn-verde">✅ Aceptar Pedido</button>
                </div>
            </main>

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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?= \config\APP_URL ?>public/js/pedido/pedidosMesero.js" defer></script>
        <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
        <script src="<?php echo \config\APP_URL; ?>public/js/dashboard.js"></script>

        <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"
            integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA="
            crossorigin="anonymous">
        </script>

</body>

</html>