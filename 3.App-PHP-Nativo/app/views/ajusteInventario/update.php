<!DOCTYPE html>
<html lang="es">
<title>Actualizar Ajuste Inventario</title>

<body>
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="principal">
        <button type="button" class="volver" onclick="history.back()">
            <i data-feather="arrow-left"></i> Volver
        </button>

        <form id="update-ajusteInventario-form" class="formulario" action="<?php echo \config\APP_URL; ?>ajusteInventario/update" method="POST">
            <h1>Actualizar Ajuste Inventario</h1>

            <div class="grupo-formulario">
                <input type="hidden" id="Id" name="Id" value="<?php echo $ajusteInv['ID_AJUSTE']; ?>" required>

                <div class="campo">
                    <label for="fecha">Fecha</label>
                    <div class="contenedor-input">
                        <input type="datetime-local" id="fecha" name="fecha" value="<?php echo $ajusteInv['FECHA_AJUSTE']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="tipo">Tipo Novedad</label>
                    <div class="contenedor-input">
                        <select id="tipo" name="tipo" required>
                            <option value="<?php echo $ajusteInv['TIPO_AJUSTE']; ?>"><?php echo $ajusteInv['TIPO_AJUSTE']; ?></option>
                            <option value="DAÑADO">DAÑADO</option>
                            <option value="ROBO">ROBO</option>
                            <option value="PERDIDA">PERDIDA</option>
                            <option value="CADUCADO">CADUCADO</option>
                            <option value="MUESTRA">MUESTRA</option>
                        </select>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="cantAjustada">Cantidad ajustada</label>
                    <div class="contenedor-input">
                        <input type="number" id="cantAjustada" name="cantAjustada" value="<?php echo $ajusteInv['CANTIDAD_AJUSTADA']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="descripcion">Descripción</label>
                    <div class="contenedor-input">
                        <input type="text" id="descripcion" name="descripcion" value="<?php echo $ajusteInv['DESCRIPCION']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="productoFK">Producto afectado</label>
                    <div class="input-group">
                        <button type="button" class="btn btn-outline-secondary input-group-text boton-busqueda-cafe" id="select-rol-btn" data-bs-toggle="modal" data-bs-target="#modalProductos">
                            <i data-feather="search"></i>
                        </button>
                        <input type="text" id="producto_display" class="form-control" value="<?php echo $ajusteInv['NOMBRE_PRODUCTO']; ?>" readonly required>
                        <input type="hidden" id="productoFK" name="productoFK" value="<?php echo $ajusteInv['ID_PROD_FK_AJUSTE_INVENTARIO']; ?>">
                    </div>
                </div>
            </div>

            <button type="submit">
                <i data-feather="refresh-cw" style="margin-right: 8px; width: 20px; height: 20px;"></i>
                Actualizar Ajuste Inventario
            </button>
        </form>

    </main>

    <div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="modalProductosLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProductosLabel">Seleccionar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tablaProductosModal">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Cantidad actual</th>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/ajusteInventario/confirmUpdate.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/ajusteInventario/selectProdModal.js"></script>
</body>

</html>