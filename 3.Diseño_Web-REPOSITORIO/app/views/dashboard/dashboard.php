<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Panadería</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../../../public/css/dashboard.css"/>
</head>
<body>
  <header class="encabezado-panel">
    <div class="icono-menu" id="btnMenu"><i class="fas fa-bars"></i></div>
    <div class="buscador">
      <input type="text" placeholder="Buscar productos, pedidos...">
      <i class="fas fa-search"></i>
    </div>
    <div class="iconos-derecha">
      <i class="fas fa-bell"></i>
      <i class="fas fa-shopping-cart"></i>
      <i class="fas fa-user"></i>
      <i class="fas fa-cog"></i>
    </div>
  </header>

  <aside class="menu_lateral" id="menuLateral">
    <nav class="opciones_menu">
      <div class="opcion activa"><i class="fas fa-home"></i><span class="texto">Inicio</span></div>
      <div class="opcion"><i class="fas fa-user"></i><span class="texto">Usuarios</span></div>
      <div class="opcion"><i class="fas fa-comment-alt"></i><span class="texto">Mensajes</span></div>
      <div class="opcion"><i class="fas fa-question"></i><span class="texto">Ayuda</span><a href="FORMULARIOS.html"></a></div>
      <div class="opcion"><i class="fas fa-cog"></i><span class="texto">Configuración</span></div>
      <div class="opcion"><i class="fas fa-lock"></i><span class="texto">Seguridad</span></div>
      <div class="opcion"><i class="fas fa-sign-out-alt"></i><span class="texto">Salir</span></div>
    </nav>
  </aside>

  <main class="contenido_panel">
    <section class="tarjetas_resumen">
      <div class="tarjeta">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h4>Total Ventas</h4>
            <p>$5,200.000</p>
          </div>
          <i class="fas fa-dollar-sign" style="font-size: 40px; color: #2563eb;"></i>
        </div>
      </div>
      <div class="tarjeta">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h4>Pedidos Postres personalizados (Hoy)</h4>
            <p>132</p>
          </div>
          <i class="fas fa-receipt" style="font-size: 40px; color: #059669;"></i>
        </div>
      </div>
      <div class="tarjeta">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h4>Clientes</h4>
            <p>54</p>
          </div>
          <i class="fas fa-users" style="font-size: 40px; color: #d97706;"></i>
        </div>
      </div>
      <div class="tarjeta">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h4>Productos en stock</h4>
            <p>328</p>
          </div>
          <i class="fas fa-boxes" style="font-size: 40px; color: #6b21a8;"></i>
        </div>
      </div>
    </section>

    <section class="graficas_panel">
      <div class="grafico" id="grafico_ventas">
        <h3>Ventas Semanales</h3>
        <canvas id="ventasChart"></canvas>
      </div>
      <div class="grafico" id="grafico_productos">
        <h3>Productos Más Vendidos</h3>
        <canvas id="productosChart"></canvas>
      </div>
    </section>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="../../../public/js/dashboard.js"></script>
</body>
</html>
