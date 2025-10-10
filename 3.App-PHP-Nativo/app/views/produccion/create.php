<?php
// Protege la vista (ajusta la condición según tu login)
if (!isset($_SESSION['userId'])) {
    header("Location: " . \config\APP_URL . "login");
    exit();
}
$appUrl = \config\APP_URL;
?>
<!DOCTYPE html>
<html lang="es">

<body data-theme="light">
    <div class="app">
        <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
        <div class="tasks-panel" id="tasksPanel">
        </div>

        <div class="main-content">
            <button type="button" class="volver" onclick="history.back()">
                <i data-feather="arrow-left"></i> Volver
            </button>

            <main class="pedido-container">
                <h2 class="titulo-pedido">🏭 Nueva Producción</h2>

                <form id="formNuevaProduccion" method="POST">

                    <section class="form-grid">

                        <div class="form-group">
                            <label for="nombreProduccion">Nombre de Producción</label>
                            <input type="text" id="nombreProduccion" name="nombreProduccion" placeholder="Ej: Lote Pan Integral 2025-09-28" maxlength="50" required>
                        </div>

                        <div class="form-group">
                            <label for="inputProductoProducir">Producto a Producir</label>
                            <div class="input-group">
                                <input type="text" id="inputProductoProducir" class="form-control"
                                    placeholder="Seleccione el producto..." readonly required
                                    data-bs-toggle="modal" data-bs-target="#modalSelectProducto">

                                <input type="hidden" id="idProductoProducir" name="idProducto">

                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalSelectProducto">
                                    <lord-icon
                                        src="https://cdn.lordicon.com/vhdgmtyj.json"
                                        trigger="hover"
                                        stroke="bold"
                                        colors="primary:#933e0d"
                                        style="width:30px;height:30px">
                                    </lord-icon>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cantidadProducida">Cantidad a Producir</label>
                            <input type="number" id="cantidadProducida" name="cantidadProducida" placeholder="Ej: 100 unidades" min="1" required>
                        </div>

                        <div class="form-group">
                            <label for="estadoProduccion">Estado Inicial</label>
                            <select id="estadoProduccion" name="estadoProduccion" disabled title="El estado inicial siempre es PENDIENTE">
                                <option value="PENDIENTE" selected>PENDIENTE</option>
                            </select>
                            <input type="hidden" name="estadoProduccionHidden" value="PENDIENTE">
                        </div>

                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="descripcionProduccion">Descripción (opcional)</label>
                            <input id="descripcionProduccion" name="descripcion" type="text" placeholder="Notas sobre la producción" maxlength="200">
                        </div>

                        <input type="hidden" name="usuarioId" value="<?= $_SESSION['ID_USUARIO'] ?? '' ?>">

                    </section>

                    <section class="productos-card">
                        <div class="productos-header">
                            <h3>Materia Prima Utilizada</h3>
                            <div>
                                <button type="button" id="btnAddItem" class="btn-azul" data-bs-toggle="modal" data-bs-target="#modalAddMateriaPrima" title="Añadir la Materia Prima que se usó en esta producción.">
                                    <i data-feather="plus"></i> Añadir Ítem
                                </button>
                            </div>
                        </div>

                        <div class="table-wrap">
                            <table class="tabla-productos">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre (MP)</th>
                                        <th style="width:120px">Cantidad Utilizada</th>
                                        <th style="width:120px">Unidad</th>
                                        <th style="width:120px">Stock Actual</th>
                                        <th style="width:80px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaItemsProduccion">
                                    <tr>
                                        <td colspan="6" class="text-center">Use el botón "Añadir Ítem" para agregar la Materia Prima utilizada.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </section>

                    <div class="btn-guardar-container">
                        <button type="submit" id="btnGuardarProduccion" class="btn-verde" disabled>✅ Guardar Producción</button>
                    </div>
                </form>

            </main>

        </div>

        <div class="modal fade" id="modalSelectProducto" tabindex="-1" aria-labelledby="modalSelectProductoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSelectProductoLabel">Seleccionar Producto a Producir</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="searchProducto" class="form-control mb-3" placeholder="Buscar producto por nombre o ID...">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Existencia</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="productosTableBody">
                                    <tr>
                                        <td colspan="5" class="text-center">Cargando productos...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalAddMateriaPrima" tabindex="-1" aria-labelledby="modalAddMateriaPrimaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddMateriaPrimaLabel">Seleccionar Materia Prima</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="searchMateriaPrima" class="form-control mb-3" placeholder="Buscar Materia Prima...">

                        <div class="form-group">
                            <label for="selectMateriaPrima">Materia Prima</label>
                            <select id="selectMateriaPrima" class="form-control">
                                <option value="" disabled selected>Seleccione la Materia Prima</option>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="cantidadMateriaPrima">Cantidad Utilizada</label>
                            <input type="number" step="0.01" id="cantidadMateriaPrima" class="form-control" min="0.01" placeholder="Cantidad (Ej: 2.5)">
                            <small id="unidadPresentacion" class="text-muted"></small>
                        </div>
                        <div class="form-group mt-3">
                            <p class="mb-1">Stock Disponible: <strong id="stockDisponibleMP">N/A</strong></p>
                            <p class="mb-0 text-danger" id="alertaStock"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnAgregarMPModal" disabled>Agregar a Producción</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= $appUrl ?>public/js/sidebar.js" defer></script>
    <script src="<?= $appUrl ?>public/js/dashboard.js" defer></script>
    <script src="<?= $appUrl ?>public/js/sweetalert2.all.min.js" defer></script>
    <script src="<?= $appUrl ?>public/js/produccion/createProduccion.js" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"
        integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA="
        crossorigin="anonymous" defer>
    </script>
</body>

</html>