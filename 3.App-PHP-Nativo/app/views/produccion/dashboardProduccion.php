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
        <a href="<?php echo \config\APP_URL; ?>produccion/create" rel="noopener noreferrer"><button type="button" class="btn btn-primary">+ Nueva produccion</button></a>
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

          <?php if ($_SESSION['rol'] == 'ADMINISTRADOR') {
          ?>
            <!-- KPIs -->
            <section class="stats">
              <div class="stat">
                <div>
                  <div class="muted">Registros existentes</div>
                  <div class="kpi"><?php echo $dashboardDataProduccion['produccionesExistentes']; ?></div>
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
                  <div class="muted">Producciones pendientes</div>
                  <div class="kpi"><?php echo $dashboardDataProduccion['produccionesPendientes']; ?></div>
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
                  <div class="muted">Producciones en Proceso</div>
                  <div class="kpi"><?php echo $dashboardDataProduccion['produccionesProceso']; ?></div>
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
                  <div class="muted">Producciones Finalizadas</div>
                  <div class="kpi"><?php echo $dashboardDataProduccion['produccionesFinalizadas']; ?></div>
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
                  <div class="muted">Producciones Canceladas</div>
                  <div class="kpi"><?php echo $dashboardDataProduccion['produccionesCanceladas']; ?></div>
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
          <?php
          }
          ?>

          <!-- Tabla de compras -->
          <div class="section-reportes">
            <table id="tablaProducciones" class="tabla-consultas">
              <tbody>
                <div class="table-header">
                  <strong>Tabla de producciones</strong>
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
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Producto</th>
                    <th>Registrado por</th>
                    <th>Estado</th>
                    <th colspan="2" style="text-align:center">Acciones</th>
                  </tr>
                </thead>
                <?php

                if ($dashboardDataProduccion['producciones']) {
                  foreach ($dashboardDataProduccion['producciones'] as $produccion) {
                ?>
                    <tr>
                      <td> <?php echo htmlspecialchars($produccion['NOMBRE_PRODUCCION']); ?></td>
                      <td> <?php echo htmlspecialchars($produccion['CANT_PRODUCCION']); ?></td>
                      <td> <?php echo htmlspecialchars($produccion['DESCRIPCION_PRODUCCION']); ?></td>
                      <td> <?php echo htmlspecialchars($produccion['NOMBRE_PRODUCTO']); ?></td>
                      <td> <?php echo htmlspecialchars($produccion['USUARIO_REGISTRO']); ?></td>
                      <td> <?php echo htmlspecialchars($produccion['ESTADO_PRODUCCION']); ?></td>
                      <td>
                        <a href="<?php echo \config\APP_URL . 'produccion/viewEdit/' . htmlspecialchars($produccion['ID_PRODUCCION']); ?>" class='btn btn-sm btn-primary btn-actualizar'>
                          <lord-icon
                            src="https://cdn.lordicon.com/ibckyoan.json"
                            trigger="hover"
                            colors="primary:#ffffff"
                            style="width:30px;height:30px">
                          </lord-icon>
                        </a>
                      </td>
                      <td>
                        <button
                          type="button"
                          class='btn btn-sm btn-primary btn-detalle-produccion'
                          data-bs-toggle="modal"
                          data-bs-target="#detalleProduccionModal"
                          data-id-produccion="<?= htmlspecialchars($produccion['ID_PRODUCCION']); ?>">
                          Detalle
                        </button>
                      </td>
                    </tr>
                  <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan='8' style="text-align:center;">No hay registros de producciones disponibles.</td>
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

    <div class="modal fade" id="detalleProduccionModal" tabindex="-1" aria-labelledby="detalleProduccionModal" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detalleProduccionModalLabel">Detalle de Producción</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Materia Prima</th>
                  <th>Cantidad Requerida</th>
                  <th>Tipo Item</th>
                </tr>
              </thead>
              <tbody id="cuerpoTablaDetalleProduccion">
              </tbody>
            </table>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

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
    <script src="<?php echo \config\APP_URL; ?>public/js/dashboard.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/produccion/selectDetalleProduccionModal.js"></script>

    <!-- JS para busquedas personalizadas (y PDF) -->
    <script src="<?php echo \config\APP_URL; ?>public/js/produccion/busquedaFiltro.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/produccion/PDFgenerateFilter.js"></script>
</body>

</html>