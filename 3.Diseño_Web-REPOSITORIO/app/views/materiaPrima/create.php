<!DOCTYPE html>
<html lang="es">
<title>Crear Materia Prima</title>

<body>
  <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

  <main class="principal">
    <button type="button" class="volver" onclick="history.back()">
      <i data-feather="arrow-left"></i> Volver
    </button>

    <form id="create-materiaPrima-form" class="formulario" action="<?php echo \config\APP_URL; ?>materiasPrimas/create" method="POST">
      <h1>Crear Materia Prima</h1>

      <div class="grupo-formulario">
        <div class="campo">
          <label for="nombre">Nombre (Único)</label>
          <div class="contenedor-input">
            <input type="text" id="nombre" name="nombre" placeholder="Ingresa el nombre" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="valor_unit">Valor unitario</label>
          <div class="contenedor-input">
            <input type="number" id="valor_unit" name="valor_unit" placeholder="Ingresa el valor unitario" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="fech_venc">Fecha Vencimiento</label>
          <div class="contenedor-input">
            <input type="datetime-local" id="fech_venc" name="fech_venc" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="cant_exist">Cantidad existente</label>
          <div class="contenedor-input">
            <input type="number" id="cant_exist" name="cant_exist" placeholder="Ingresa la cantidad existente" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="presentacion">Presentación</label>
          <div class="contenedor-input">
            <input type="text" id="presentacion" name="presentacion" placeholder="Ingresa la presentación" required>
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="descripcion">Descripción</label>
          <div class="contenedor-input">
            <input type="text" id="descripcion" name="descripcion" placeholder="Ingresa la descripción" required>
            <div class="resalte-input"></div>
          </div>
        </div>
      </div>

      <button type="submit">
        <i data-feather="plus-circle" style="margin-right: 8px; width: 20px; height: 20px;"></i>
        Crear Materia Prima
      </button>
    </form>
  </main>

  <script>
    const APP_URL = '<?php echo \config\APP_URL; ?>';
  </script>
  <script src="https://cdn.lordicon.com/lordicon.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/materiaPrima/materiaPrima.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/materiaPrima/confirmCreate.js"></script>
</body>

</html>