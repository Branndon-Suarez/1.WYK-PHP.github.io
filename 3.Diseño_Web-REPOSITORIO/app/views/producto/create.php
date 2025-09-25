<!DOCTYPE html>
<html lang="es">
<title>Crear Producto</title>

<body>
  <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

  <main class="principal">
    <button type="button" class="volver" onclick="history.back()">
      <i data-feather="arrow-left"></i> Volver
    </button>

    <form id="create-producto-form" class="formulario" action="<?php echo \config\APP_URL; ?>productos/create" method="POST">
      <h1>Crear Producto</h1>

      <div class="grupo-formulario">
        <div class="campo">
          <label for="id_prod">Identificación (Único)</label>
          <div class="contenedor-input">
            <input type="number" id="id_prod" name="id_prod" placeholder="Ingresa la identificacion" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="name_prod">Nombre (Único)</label>
          <div class="contenedor-input">
            <input type="text" id="name_prod" name="name_prod" placeholder="Ingresa el nombre" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="valor_unit_prod">Valor unitario</label>
          <div class="contenedor-input">
            <input type="number" id="valor_unit_prod" name="valor_unit_prod" placeholder="Ingresa el valor unitario" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="cant_exist_prod">Cantidad existente</label>
          <div class="contenedor-input">
            <input type="number" id="cant_exist_prod" name="cant_exist_prod" placeholder="Ingresa la cantidad existente" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="fech_venc_prod">Fecha Vencimiento</label>
          <div class="contenedor-input">
            <input type="datetime-local" id="fech_venc_prod" name="fech_venc_prod" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="tipo_prod">Tipo</label>
          <div class="contenedor-input">
            <select id="tipo_prod" name="tipo_prod" required>
              <option value="">Seleccione un tipo</option>
              <option value="PANADERIA">PANADERIA</option>
              <option value="PASTELERIA">PASTELERIA</option>
              <option value="ASEO">ASEO</option>
            </select>
            <div class="resalte-input"></div>
          </div>
        </div>
      </div>

      <button type="submit">
        <i data-feather="plus-circle" style="margin-right: 8px; width: 20px; height: 20px;"></i>
        Crear producto
      </button>
    </form>
  </main>

  <script>
    const APP_URL = '<?php echo \config\APP_URL; ?>';
  </script>
  <script src="https://cdn.lordicon.com/lordicon.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/producto/producto.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/producto/confirmCreate.js"></script>
</body>

</html>