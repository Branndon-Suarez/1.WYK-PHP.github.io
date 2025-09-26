<!DOCTYPE html>
<html lang="es">
<title>Crear Ajuste</title>

<body>
  <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

  <main class="principal">
    <button type="button" class="volver" onclick="history.back()">
      <i data-feather="arrow-left"></i> Volver
    </button>

    <form id="create-ajusteInventario-form" class="formulario" action="<?php echo \config\APP_URL; ?>ajusteInventario/create" method="POST">
      <h1>Crear reporte ajuste</h1>

      <div class="grupo-formulario">
        <div class="campo">
          <label for="fecha">Fecha</label>
          <div class="contenedor-input">
            <input type="datetime-local" id="fecha" name="fecha" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="tipo">Tipo Novedad</label>
          <div class="contenedor-input">
            <select id="tipo" name="tipo" required>
              <option value="">Seleccione un tipo</option>
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
            <input type="number" id="cantAjustada" name="cantAjustada" placeholder="La cantidad RESTARÁ la existente" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="descripcion">Descripción</label>
          <div class="contenedor-input">
            <input type="number" id="descripcion" name="descripcion" placeholder="Ingrese la descripción" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="productoFK">Producto afectado</label>
          <div class="input-group">
            <button type="button" class="btn btn-outline-secondary input-group-text boton-busqueda-cafe" id="select-rol-btn" data-bs-toggle="modal" data-bs-target="#modalProductos">
              <i data-feather="search"></i>
            </button>
            <input type="text" id="producto_display" class="form-control" placeholder="Selecciona el producto afectado" readonly required>
            <input type="hidden" id="productoFK" name="productoFK">
          </div>
        </div>
      </div>

      <button type="submit">
        <i data-feather="plus-circle" style="margin-right: 8px; width: 20px; height: 20px;"></i>
        Crear ajuste
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
  <script src="<?php echo \config\APP_URL; ?>public/js/ajusteInventario/ajusteInventario.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/ajusteInventario/confirmCreate.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/ajusteInventario/selectProdModal.js"></script>
</body>

</html>