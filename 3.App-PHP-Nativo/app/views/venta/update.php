<!DOCTYPE html>
<html lang="es">
<title>Actualizar Venta</title>

<body>
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="principal">

        <?php
            $rol = $_SESSION['rol'] ?? '';

        if ($rol === 'MESERO' || $rol === 'CAJERO') {
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

        <button type="button" class="volver" onclick="history.back()">
            <i data-feather="arrow-left"></i> Volver
        </button>

        <form id="update-venta-form" class="formulario" action="<?php echo \config\APP_URL; ?>ventas/update" method="POST">
            <h1>Actualizar Venta</h1>

            <div class="grupo-formulario">
                <input type="hidden" id="idVenta" name="idVenta" value="<?php echo $venta['ID_VENTA']; ?>" required>
                
                <div class="campo">
                    <label for="fecha">Fecha</label>
                    <div class="contenedor-input">
                        <input type="datetime-local" id="fecha" name="fecha" value="<?php echo $venta['FECHA_HORA_VENTA']; ?>" readonly>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="total">Total</label>
                    <div class="contenedor-input">
                        <input type="number" id="total" name="total" value="<?php echo $venta['TOTAL_VENTA']; ?>" readonly>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="numMesa">N° Mesa</label>
                    <div class="contenedor-input">
                        <input type="number" id="numMesa" name="numMesa" <?php echo ($venta['NUMERO_MESA'] === null) ? 'placeholder="No se usó"' : ''; ?> value="<?php echo $venta['NUMERO_MESA']; ?>" readonly>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="descripcion">Descripción</label>
                    <div class="contenedor-input">
                        <input type="text" id="descripcion" name="descripcion" value="<?php echo $venta['DESCRIPCION']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <?php if ($rol == 'ADMINISTRADOR' || $rol == 'MESERO') {
                ?>
                    <div class="campo">
                        <label for="estadoPedido">Estado del pedido</label>
                        <div class="contenedor-input">
                            <select id="estadoPedido" name="estadoPedido" required>
                                <option value="<?php echo $venta['ESTADO_PEDIDO']; ?>"><?php echo $venta['ESTADO_PEDIDO']; ?></option>
                                <?php if ($rol == 'ADMINISTRADOR') {
                                ?>
                                    <option value="PENDIENTE">PENDIENTE</option>
                                    <option value="PREPARANDO">PREPARANDO</option>
                                    <option value="ENTREGADO">ENTREGADO</option>
                                    <option value="CANCELADO">CANCELADO</option>
                                <?php
                                }
                                if ($rol == 'MESERO' && $venta['ESTADO_PEDIDO'] !== 'PREPARANDO') {
                                ?>
                                    <option value="PREPARANDO">PREPARANDO</option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="resalte-input"></div>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="campo">
                        <label for="estadoPedido_display">Estado del pedido</label>
                        <div class="contenedor-input">
                            <input type="text" id="estadoPedido_display" value="<?php echo $venta['ESTADO_PEDIDO']; ?>" readonly>
                            <input type="hidden" id="estadoPedido" name="estadoPedido" value="<?php echo $venta['ESTADO_PEDIDO']; ?>">
                            <div class="resalte-input"></div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <?php if ($rol == 'ADMINISTRADOR' || $rol == 'CAJERO') {
                ?>
                    <div class="campo">
                        <label for="estadoVenta">Estado del pago</label>
                        <div class="contenedor-input">
                            <select id="estadoVenta" name="estadoVenta" required>
                                <option value="<?php echo $venta['ESTADO_PAGO']; ?>"><?php echo $venta['ESTADO_PAGO']; ?></option>
                                <?php if ($rol == 'ADMINISTRADOR') {
                                ?>
                                    <option value="PENDIENTE">PENDIENTE</option>
                                    <option value="PAGADA">PAGADA</option>
                                    <option value="CANCELADA">CANCELADA</option>
                                <?php
                                }
                                ?>
                                <?php if ($rol == 'CAJERO') {
                                ?>
                                    <option value="PENDIENTE">PENDIENTE</option>
                                    <option value="PAGADA">PAGADA</option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="resalte-input"></div>
                        </div>
                    </div>
                <?php
                } else { 
                ?>
                    <div class="campo">
                        <label for="estadoVenta_display">Estado del pago</label>
                        <div class="contenedor-input">
                            <!-- Campo de solo lectura para mostrar el valor al MESERO -->
                            <input type="text" id="estadoVenta_display" value="<?php echo $venta['ESTADO_PAGO']; ?>" readonly>
                            <!-- Campo oculto para asegurar que el valor se envía al controlador -->
                            <input type="hidden" id="estadoVenta" name="estadoVenta" value="<?php echo $venta['ESTADO_PAGO']; ?>">
                            <div class="resalte-input"></div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <button type="submit">
                <i data-feather="refresh-cw" style="margin-right: 8px; width: 20px; height: 20px;"></i>
                Actualizar Venta
            </button>
        </form>

    </main>

    <div class="modal fade" id="modalUsuarios" tabindex="-1" aria-labelledby="modalUsuariosLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsuariosLabel">Seleccionar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tablaUsuariosModal">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const APP_URL = '<?php echo \config\APP_URL; ?>';
    </script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/venta/venta.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/venta/confirmUpdate.js"></script>
</body>

</html>
