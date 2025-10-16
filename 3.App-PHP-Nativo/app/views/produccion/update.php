<!DOCTYPE html>
<html lang="es">
<title>Actualizar Producción</title>

<body>
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="principal">

        <button type="button" class="volver" onclick="history.back()">
            <i data-feather="arrow-left"></i> Volver
        </button>

        <form id="update-produccion-form" class="formulario" action="<?php echo \config\APP_URL; ?>produccion/update" method="POST">
            <h1>Actualizar Producción</h1>

            <div class="grupo-formulario">
                <input type="hidden" id="idProduccion" name="idProduccion" value="<?php echo $produccion['ID_PRODUCCION']; ?>" required>

                <div class="campo">
                    <label for="nombre">Nombre de Producción</label>
                    <div class="contenedor-input">
                        <input type="text" id="nombre" name="nombre" value="<?php echo $produccion['NOMBRE_PRODUCCION']; ?>" readonly>
                        <div class="resalte-input"></div>
                    </div>
                </div>
                
                <div class="campo">
                    <label for="producto">Producto Terminado</label>
                    <div class="contenedor-input">
                        <input type="hidden" id="prodFK" name="prodFK" value="<?php echo $produccion['ID_PRODUCTO_FK_PRODUCCION']; ?>">
                        <input type="text" value="<?php echo $produccion['NOMBRE_PRODUCTO']; ?>" readonly>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="cantidad">Cantidad Producida</label>
                    <div class="contenedor-input">
                        <input type="number" id="cantidad" name="cantidad" value="<?php echo $produccion['CANT_PRODUCCION']; ?>" readonly>
                        <div class="resalte-input"></div>
                    </div>
                </div>
                
                <div class="campo">
                    <label for="usuario">Usuario Registro</label>
                    <div class="contenedor-input">
                        <input type="hidden" id="usuarioFK" name="usuarioFK" value="<?php echo $produccion['ID_USUARIO_FK_PRODUCCION']; ?>">
                        <input type="text" value="<?php echo $produccion['USUARIO_REGISTRO']; ?>" readonly>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="descripcion">Descripción</label>
                    <div class="contenedor-input">
                        <input type="text" id="descripcion" name="descripcion" value="<?php echo $produccion['DESCRIPCION_PRODUCCION']; ?>" required>
                        <div class="resalte-input"></div>
                    </div>
                </div>

                <div class="campo">
                    <label for="estado">Estado de Producción</label>
                    <div class="contenedor-input">
                        <select id="estado" name="estado" required>
                            <option value="<?php echo $produccion['ESTADO_PRODUCCION']; ?>"><?php echo $produccion['ESTADO_PRODUCCION']; ?></option>
                            <?php if ($produccion['ESTADO_PRODUCCION'] !== 'PENDIENTE'): ?>
                                <option value="PENDIENTE">PENDIENTE</option>
                            <?php endif; ?>
                            <?php if ($produccion['ESTADO_PRODUCCION'] !== 'FINALIZADA'): ?>
                                <option value="FINALIZADA">FINALIZADA</option>
                            <?php endif; ?>
                            <?php if ($produccion['ESTADO_PRODUCCION'] !== 'CANCELADA'): ?>
                                <option value="CANCELADA">CANCELADA</option>
                            <?php endif; ?>
                        </select>
                        <div class="resalte-input"></div>
                    </div>
                </div>
                
                </div>

            <button type="submit">
                <i data-feather="refresh-cw" style="margin-right: 8px; width: 20px; height: 20px;"></i>
                Actualizar Producción
            </button>
        </form>

    </main>
    
    <script>
        const APP_URL = '<?php echo \config\APP_URL; ?>';
    </script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/produccion/confirmUpdate.js"></script>
</body>

</html>