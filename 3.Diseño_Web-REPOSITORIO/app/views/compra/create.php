<?php
// Protege la vista (ajusta la condición según tu login)
if (!isset($_SESSION['userId'])) {
    header("Location: " . \config\APP_URL . "login");
    exit();
}
// Asegúrate de definir la constante APP_URL en tu config
$appUrl = \config\APP_URL; 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Incluye aquí tus enlaces CSS, feather-icons y scripts de Lord Icon -->
    <!-- Por ejemplo: -->
    <!-- <script src="https://cdn.lordicon.com/lordicon.js"></script> -->
</head>

<body data-theme="light">
    <div class="app">
        <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
        <?php
        if (isset($_SESSION['rolClasificacion']) && $_SESSION['rolClasificacion'] === 'EMPLEADO') {
            require_once __DIR__ . '/../layouts/floatingIcon.php';
        }
        ?>
        <div class="tasks-panel" id="tasksPanel">
            <!-- Contenido del panel de tareas -->
        </div>

        <div class="main-content">
            <button type="button" class="volver" onclick="history.back()">
                <i data-feather="arrow-left"></i> Volver
            </button>

            <!-- ============================================== -->
            <!-- COMIENZO DEL FORMULARIO DE COMPRA (Basado en Pedido) -->
            <!-- ============================================== -->
            <main class="pedido-container">
                <h2 class="titulo-pedido">🛒 Nueva Compra</h2>
                
                <form id="formNuevaCompra" method="POST">
                    <!-- DATOS GENERALES Y PROVEEDOR (Form Grid) -->
                    <section class="form-grid">
                        
                        <!-- FECHA_HORA_COMPRA -->
                        <div class="form-group">
                            <label for="fechaCompra">Fecha y Hora</label>
                            <input type="datetime-local" id="fechaCompra" name="fecha"
                                value="<?= date('Y-m-d\TH:i') ?>" required>
                        </div>
                        
                        <!-- TIPO ENUM('MATERIA PRIMA', 'PRODUCTO TERMINADO') -->
                        <div class="form-group">
                            <label for="tipoCompra">Tipo de Compra</label>
                            <select id="tipoCompra" name="tipo" required>
                                <option value="" disabled selected>Seleccione el tipo</option>
                                <option value="MATERIA PRIMA">Materia Prima</option>
                                <option value="PRODUCTO TERMINADO">Producto Terminado</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nombreProveedor">Nombre del Proveedor</label>
                            <input type="text" id="nombreProveedor" name="nombreProveedor" placeholder="Nombre del proveedor required maxlength="50">
                        </div>
                        
                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <input type="text" id="marca" name="marca" placeholder="Marca del producto/materia prima" required maxlength="50">
                        </div>

                        <div class="form-group">
                            <label for="telProveedor">Teléfono</label>
                            <input type="number" id="telProveedor" name="telProveedor" placeholder="Teléfono del proveedor" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="emailProveedor">Email</label>
                            <input type="email" id="emailProveedor" name="emailProveedor" placeholder="Email del proveedor" required maxlength="50">
                        </div>
                        
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="descripcionCompra">Descripción (opcional)</label>
                            <input id="descripcionCompra" name="descripcion" type="text" placeholder="Detalles o notas importantes" maxlength="200">
                        </div>

                        <!-- ID_USUARIO_FK_COMPRA (Oculto) -->
                        <input type="hidden" name="usuarioId" value="<?= $_SESSION['ID_USUARIO'] ?? '' ?>"> 

                        <div class="form-group">
                            <label for="estadoFactura">Estado de Factura</label>
                            <select id="estadoFactura" name="estadoCompra" required>
                                <option value="PENDIENTE" selected>PENDIENTE</option>
                                <?php if (isset($_SESSION['rolClasificacion']) && $_SESSION['rolClasificacion'] == 'ADMINISTRADOR') { ?>
                                    <option value="PAGADA">PAGADA</option>
                                    <option value="CANCELADA">CANCELADA</option>
                                <?php } ?>
                            </select>
                        </div>
                    </section>

                    <!-- SECCIÓN DETALLES DE COMPRA (ITEMS) -->
                    <section class="productos-card">
                        <div class="productos-header">
                            <h3>Ítems de la Compra (<span id="tipoItemDisplay">No Seleccionado</span>)</h3>
                            <div>
                                <!-- Botón que ABRIRÁ el modal de selección, el modal correcto se abrirá vía JS -->
                                <button type="button" id="btnAddItem" class="btn-azul" style="display: flex; align-items: center;" disabled>
                                    <lord-icon
                                        src="https://cdn.lordicon.com/ueoydrft.json"
                                        trigger="hover"
                                        stroke="light"
                                        style="width:30px;height:30px">
                                    </lord-icon>
                                    Añadir Ítem
                                </button>
                            </div>
                        </div>

                        <div class="table-wrap">
                            <table class="tabla-productos">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th style="width:120px">Cantidad</th>
                                        <th style="width:140px">Precio Unitario</th>
                                        <th style="width:140px">Subtotal</th>
                                        <th style="width:90px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaItemsCompra">
                                    <!-- Los ítems se agregarán aquí dinámicamente -->
                                </tbody>
                            </table>
                        </div>

                        <div class="total-container">
                            <span class="total-label">TOTAL:</span>
                            <span id="totalGeneral" class="total-valor">0.00</span>
                            <input type="hidden" id="totalCompraHidden" name="totalCompra">
                        </div>
                    </section>
                    
                    <div class="btn-guardar-container">
                        <button type="submit" id="btnGuardarCompra" class="btn-verde">✅ Guardar Compra</button>
                    </div>
                </form>
                
            </main>

            <div id="modalMateriaPrima" class="modal hidden" aria-hidden="true">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Seleccionar Materia Prima</h3>
                        <button id="btnCerrarModalMP" class="btn-cerrar" aria-label="Cerrar">
                            <lord-icon
                                src="https://cdn.lordicon.com/ebyacdql.json"
                                trigger="hover"
                                state="hover-cross-3"
                                colors="primary:#808080" 
                                style="width:40px;height:40px">
                            </lord-icon>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="text" id="buscarMateriaPrima" placeholder="Buscar materia prima..." class="input-busqueda">

                        <div class="table-wrap">
                            <table class="tabla-productos">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Unidad</th>
                                        <th style="width:120px">Precio Unitario</th>
                                        <th style="width:120px">Stock Actual</th>
                                        <th style="width:90px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listaMateriaPrima">
                                    <!-- Las materias primas se cargan con JS/AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="modalProductos" class="modal hidden" aria-hidden="true">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Seleccionar Producto Terminado</h3>
                        <button id="btnCerrarModalProd" class="btn-cerrar" aria-label="Cerrar">
                            <lord-icon
                                src="https://cdn.lordicon.com/ebyacdql.json"
                                trigger="hover"
                                state="hover-cross-3"
                                colors="primary:#808080" 
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
                                        <th>Precio unitario</th>
                                        <th style="width:120px">Stock Actual</th>
                                        <th style="width:90px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listaProductos">
                                    <!-- Los productos se cargan con JS/AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
        <script src="<?= $appUrl ?>public/js/sidebar.js" defer></script>
        <script src="<?= $appUrl ?>public/js/dashboard.js" defer></script>
        <script src="<?= $appUrl ?>public/js/sweetalert2.all.min.js" defer></script>
        
        <script src="<?= $appUrl ?>public/js/compra/createCompra.js" defer></script> 
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"
            integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA="
            crossorigin="anonymous" defer>
        </script>

</body>

</html>
