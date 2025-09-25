<!DOCTYPE html>
<html lang="es">

<body>
  <div class="app">
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <?php require_once __DIR__ . '/modalConsultas.php';
    ?>
    <main class="main">
      <!-- Topbar -->
      <header>
        <strong>PANADERIA WYK— Panel Control</strong>
        <div class="search">
          <lord-icon
              src="https://cdn.lordicon.com/vhdgmtyj.json"
              trigger="hover"
              stroke="bold"
              colors="primary:#933e0d"
              style="width:50px;height:50px">
          </lord-icon>
          <input id="buscarRapido" placeholder="Buscar…" />
          <button type="button" class="btn btn-ghost" data-bs-toggle="modal" data-bs-target="#filtroAvanzadoModal">
            <i data-feather="sliders" style="width:18px;height:18px;color:#94a3b8;"></i>
          </button>
        </div>
        <a href="<?php echo \config\APP_URL; ?>productos/create" rel="noopener noreferrer"><button type="button" class="btn btn-primary">+ Nuevo producto</button></a>
      </header>

      <div class="layout">
        <section class="left">
          <!-- Hero -->
          <div class="hero">
            <div>
              <div class="hero-note">¡Buen día!</div>
              <h2>Bienvenido, <span style="color:var(--primary)"><?php echo $_SESSION['userName']; ?></span></h2>
              <div class="hero-note" style="font-style: 30px;">Que el aroma del pan recién horneado te acompañe hoy 🍞</div>
              <div style="margin-top:12px; display:flex; gap:10px;">
                <button class="btn btn-ghost">Ver agenda</button>
              </div>
            </div>
            <div class="illus">
              <div class="floaty"></div>
              <div class="bread">🥖</div>
              <div class="croissant">🥐</div>
            </div>
          </div>

          <!-- KPIs -->
          <section class="stats">
            <div class="stat">
              <div>
                <div class="muted">Productos existentes</div>
                <div class="kpi"><?php echo $dashboardDataProductos['productosExistentes']; ?></div>
              </div>
              <div class="icon">
                <lord-icon
                  src="https://cdn.lordicon.com/oqhqyeud.json"
                  trigger="hover"
                  stroke="bold"
                  colors="primary:#933e0d,secondary:#933e0d"
                  style="width:40px;height:40px">
                </lord-icon>
              </div>
            </div>
            <div class="stat">
              <div>
                <div class="muted">Productos activos</div>
                <div class="kpi"><?php echo $dashboardDataProductos['productosActivos']; ?></div>
              </div>
              <div class="icon">
                <lord-icon
                  src="https://cdn.lordicon.com/oqhqyeud.json"
                  trigger="hover"
                  stroke="bold"
                  colors="primary:#933e0d,secondary:#933e0d"
                  style="width:40px;height:40px">
                </lord-icon>
              </div>
            </div>
            <div class="stat">
              <div>
                <div class="muted">Productos inactivos</div>
                <div class="kpi"><?php echo $dashboardDataProductos['productosInactivos']; ?></div>
              </div>
              <div class="icon">
                <lord-icon
                  src="https://cdn.lordicon.com/oqhqyeud.json"
                  trigger="hover"
                  stroke="bold"
                  colors="primary:#933e0d,secondary:#933e0d"
                  style="width:40px;height:40px">
                </lord-icon>
              </div>
            </div>
          </section><br><br>

          <!-- Tabla de productos -->
          <div class="section-reportes">
            <table id="tablaProductos" class="tabla-consultas">
              <tbody>
                <div class="table-header">
                  <strong>Tabla de productos</strong>
                  <div style="display:flex; gap:8px;">
                    <button id="generatePdfBtn" style="display:flex; align-items:center;" class="btn btn-ghost btp-personalizado">
                      <span>Generar PDF</span>
                      <lord-icon
                          src="https://cdn.lordicon.com/gyyhoycg.json"
                          trigger="hover"
                          stroke="bold"
                          colors="primary:#fff"
                          style="width:50px;height:50px">
                      </lord-icon>
                    </button>
                  </div>
                </div>
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Valor unitario</th>
                    <th>Cantidad Existente</th>
                    <th>Fecha Vencimiento</th>
                    <th>Tipo</th>
                    <th>Registrado por</th>
                    <th>Estado</th>
                    <th colspan="3" style="text-align:center">Acciones</th>
                  </tr>
                </thead>
                <?php

                if ($dashboardDataProductos['productos']) {
                  foreach ($dashboardDataProductos['productos'] as $producto) {
                    $switchIdRol = "switch_" . $producto['ID_PRODUCTO'];
                    $estado = $producto['ESTADO_PRODUCTO'] == 1 ? true : false;
                ?>
                    <tr>
                      <td> <?php echo htmlspecialchars($producto['NOMBRE_PRODUCTO']); ?></td>
                      <td> <?php echo htmlspecialchars($producto['VALOR_UNITARIO_PRODUCTO']); ?></td>
                      <td> <?php echo htmlspecialchars($producto['CANT_EXIST_PRODUCTO']); ?></td>
                      <td> <?php echo htmlspecialchars($producto['FECHA_VENCIMIENTO_PRODUCTO']); ?></td>
                      <td> <?php echo htmlspecialchars($producto['TIPO_PRODUCTO']); ?></td>
                      <td> <?php echo htmlspecialchars($producto['USUARIO_REGISTRO']); ?></td>
                      <td>
                        <input id="<?php echo $switchIdRol; ?>" type="checkbox" <?php echo $estado ? 'checked' : ''; ?>
                          data-id="<?php echo htmlspecialchars($producto['ID_PRODUCTO']); ?>" ;>
                        <label for="<?php echo $switchIdRol; ?>" class="check-trail">
                          <span class="check-handler"></span>
                        </label>
                      </td>
                      <td>
                        <a href="<?php echo \config\APP_URL . 'productos/viewEdit/' . htmlspecialchars($producto['ID_PRODUCTO']); ?>" class='btn btn-sm btn-primary btn-actualizar'>
                          <lord-icon
                            src="https://cdn.lordicon.com/ibckyoan.json"
                            trigger="hover"
                            colors="primary:#ffffff"
                            style="width:30px;height:30px">
                          </lord-icon>
                        </a>
                      </td>
                      <td><button data-id="<?= $producto['ID_PRODUCTO'] ?>" class='btn btn-sm btn-danger delete-producto'>
                          <lord-icon
                            src="https://cdn.lordicon.com/oqeixref.json"
                            trigger="morph"
                            state="morph-trash-full"
                            colors="primary:#ffffff"
                            style="width:30px;height:30px">
                          </lord-icon>
                        </button></td>
                    </tr>
                  <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan='5' style="text-align:center;">No hay productos disponibles.</td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
      </div>
      <?php require_once __DIR__ . '/../layouts/footers/footerDashboard.php'; ?>
    </main>

    <!-- LIBRERIAS -->
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"
      integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA="
      crossorigin="anonymous">
    </script>

    <!-- JS Toads y var global -->
    <script>
      const APP_URL = "<?php echo \config\APP_URL; ?>";

      const successMessage = "<?php echo $success_message; ?>";
      const errorMessage = "<?php echo $error_message; ?>";
    </script>
    <script src="<?php echo \config\APP_URL; ?>public/js/toads-sweetalert2.js"></script>

    <!-- JS para CRUD -->
    <script src="<?php echo \config\APP_URL; ?>public/js/dashboard.js"></script><!-- GRAFICAS -->
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/producto/selectRolModal.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/producto/confirmState.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/producto/confirmDelete.js"></script>

    <!-- JS para busquedas personalizadas (y PDF) -->
    <script src="<?php echo \config\APP_URL; ?>public/js/producto/busquedaFiltro.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/producto/PDFgenerateFilter.js"></script>
</body>

</html>
