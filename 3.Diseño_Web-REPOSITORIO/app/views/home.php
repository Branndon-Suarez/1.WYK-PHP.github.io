<?php
include_once "layouts/headers/headerHome.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Principal</title>
  <link rel="stylesheet" href="../../public/css/home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <nav id="menu-pagina-inicio" class="menu-pagina-inicio">
    <ul>
      <li style="--bg:#ffa117;" class="Color_Desplazar">
        <!--La clase "Color_Desplazar" Rodea al icono con un circulo para indicar selecionado-->
        <div class="icono-circulo">
          <a href="TARJETA.html" class="item"><i class="fas fa-home"></i>
        </div><span>Inicio</span></a>
      </li>

      <li style="--bg:#ffa117;" class="Color_Desplazar">
        <div class="icono-circulo">
          <a href="TARJETA.html" class="item"><i class="fas fa-pump-soap"></i>
        </div><span>Aseo</span></a>
      </li>

      <li style="--bg:#ffa117;" class="Color_Desplazar">
        <div class="icono-circulo">
          <a href="Seccion-Desayunos.html" class="item"><i class="fas fa-box-open"></i>
        </div><span>Combos</span></a>
      </li>

      <li style="--bg:#ffa117;" class="Color_Desplazar">
        <div class="icono-circulo">
          <a href="TARJETA.html" class="item"><i class="fas fa-carrot"></i>
        </div><span>Víveres</span></a>
      </li>

      <li style="--bg:#ffa117;" class="Color_Desplazar">
        <div class="icono-circulo">
          <a href="Seccion-Bebidas.html" class="item"><i class="fas fa-mug-hot"></i>
        </div><span>Bebidas</span></a>
      </li>

      <li style="--bg:#ffa117;" class="Color_Desplazar">
        <div class="icono-circulo">
          <a href="Seccion-Postres.html" class="item"><i class="fas fa-birthday-cake"></i>
        </div><span>Repostería</span></a>
      </li>
    </ul>
  </nav>

  <main id="MAIN">
    <!-- Inicio-PANADERIA Y CAFETERIA WYK -->
    <section id="INICIO-PAGINA" class="carrusel-videos">
      <video autoplay muted loop class="video-fondo">
        <source src="mi-video.mp4" type="video/mp4">
      </video>
      <div class="texto-video">
        <h1>PANADERIA Y CAFETERIA WYK</h1>
        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p> -->
        <!-- <button class="boton-leer">Leer más</button> -->
      </div>
      <aside class="redes-sociales">
        <a href="roto.html"><i class="fab fa-facebook"></i></a>
        <a href="roto.html"><i class="fab fa-instagram"></i></a>
        <a href="roto.html"><i class="fab fa-twitter"></i></a>
      </aside>
    </section>


    <!-- Quienes somos -->
    <section class="seccion-nosotros">
      <h1>
        <span class="letra">¿</span>
        <span class="letra">Q</span>
        <span class="letra">u</span>
        <span class="letra">i</span>
        <span class="letra">é</span>
        <span class="letra">n</span>
        <span class="letra">e</span>
        <span class="letra">s</span>
        <span class="letra"> </span>
        <span class="letra">s</span>
        <span class="letra">o</span>
        <span class="letra">m</span>
        <span class="letra">o</span>
        <span class="letra">s</span>
        <span class="letra">?</span>
      </h1>
      <p>Somos una panadería artesanal que mezcla tradición, <br>
        sabor y amor en cada preparación.</p>
      <button class="btn-3">Quiénes Somos</button>
    </section>

    <section class="seccion-carrusel">
      <div class="carrusel-container">
        <div class="carrusel" id="carrusel">
          <div class="slide activo">
            <img src="IMAGENES/panaderia.jpg" alt="Imagen 1">
            <div class="texto-carrusel">Panaderia</div>
          </div>
          <div class="slide">
            <img src="IMAGENES/desayunos.jpg" alt="Imagen 2">
            <div class="texto-carrusel">Desayunos</div>
          </div>
          <div class="slide">
            <img src="IMAGENES/reposteria.jpg" alt="Imagen 3">
            <div class="texto-carrusel">Reposteria</div>
          </div>
          <div class="slide">
            <img src="IMAGENES/bebidas.jpg" alt="Imagen 4">
            <div class="texto-carrusel">Bebidas</div>
          </div>
          <div class="slide">
            <img src="IMAGENES/onces.jpg" alt="Imagen 5">
            <div class="texto-carrusel">Onces</div>
          </div>
          <div class="slide">
            <img src="IMAGENES/viveres.jpeg" alt="Imagen 6">
            <div class="texto-carrusel">viveres</div>
          </div>
        </div>
        <button class="prev" onclick="moverSlide(-1)">❮</button>
        <button class="next" onclick="moverSlide(1)">❯</button>
      </div>
    </section>


    <!-- Categorías tipo tarjetas -->
    <section class="seccion-categorias">
      <h1 class="titulo-seccion">Categorías principales</h1>
      <p class="subtitulo-seccion">Descubre nuestros productos más populares</p>
      <div class="contenedor-tarjetas">
        <div class="tarjeta-categoria"><img src="IMAGENES/mocachino.jpg">
          <div class="info-tarjeta">
            <h3>Mocachino</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/espresso_doble.jpg">
          <div class="info-tarjeta">
            <h3>Americano</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/capuchino.jpg">
          <div class="info-tarjeta">
            <h3>Capuchino</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/café_frío.jpg">
          <div class="info-tarjeta">
            <h3>Café Frio</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/latte.jpg">
          <div class="info-tarjeta">
            <h3>Latte</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/CALDO_COSTILLA.jpg">
          <div class="info-tarjeta">
            <h3>Caldo Costilla</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/CALDO_PAJARILLA.jpg">
          <div class="info-tarjeta">
            <h3>Caldo Pajarilla</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/CALENTADO_PAISA.jpg">
          <div class="info-tarjeta">
            <h3>Calentado Paisa</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/MOÑONA.jpg">
          <div class="info-tarjeta">
            <h3>Moñona</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/MUTE_MAIZ.jpg">
          <div class="info-tarjeta">
            <h3>Mute de Maiz</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/jugo_maracuya.png">
          <div class="info-tarjeta">
            <h3>Jugo de Maracuyá</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/jugo_guanabana.png">
          <div class="info-tarjeta">
            <h3>Jugo de Guanabana</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/jugo_mora.jpg">
          <div class="info-tarjeta">
            <h3>Jugo de Mora</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/jugo_naranja.png">
          <div class="info-tarjeta">
            <h3>Jugo de Naranja</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/jugo_lulo.png">
          <div class="info-tarjeta">
            <h3>Jugo de Lulo</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/POSTRE6.jpg">
          <div class="info-tarjeta">
            <h3>Postre de Cereza</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/POSTRE7.jpg">
          <div class="info-tarjeta">
            <h3>Postre de Oreo</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/POSTRE3.jpg">
          <div class="info-tarjeta">
            <h3>Postre de Maracuyá</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/POSTRE4.jpg">
          <div class="info-tarjeta">
            <h3>Postre de Limon</h3>
            <p>Ver más</p>
          </div>
        </div>
        <div class="tarjeta-categoria"><img src="IMAGENES/POSTRE8.jpg">
          <div class="info-tarjeta">
            <h3>Postre de Tres Leches</h3>
            <p>Ver más</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Seccion de contacto  -->
    <section class="seccion-contacto">
      <div class="animacion-contacto">
        <h2>¡Contáctanos!</h2>
        <p>Estamos para ayudarte en todo momento.</p>
      </div>
    </section>

    <section class="seccion-video-logo">
      <div class="columna-video">
        <video autoplay muted loop>
          <source src="mi-video.mp4" type="video/mp4">
          Tu navegador no soporta el video.
        </video>
      </div>
      <div class="columna-logo">
        <img src="IMAGENES/LOGO.png" alt="Logo">
        <h2>Pasión por el sabor y la tradición</h2>
      </div>
    </section>

    <!-- Formulario y mapa -->
    <section class="seccion-formulario">
      <div class="lado-mapa">
        <iframe
          src="https://www.google.com/maps/place/Panaderia+Cafeter%C3%ADa+WYK/@4.621699,-74.1437241,20z/data=!4m15!1m8!3m7!1s0x8e3f9ea3b98eab0d:0x154d1d17d94d7254!2zQ2wuIDI2IFN1ciAjIDczLTc4LCBLZW5uZWR5LCBCb2dvdMOhLCBELkMuLCBCb2dvdMOhLCBCb2dvdMOhLCBELkMu!3b1!8m2!3d4.621838!4d-74.143699!16s%2Fg%2F11x05l_n45!3m5!1s0x8e3f9ea3ba1f15e1:0x723822705661cdae!8m2!3d4.621774!4d-74.1436537!16s%2Fg%2F1pv09bc0n?entry=ttu&g_ep=EgoyMDI1MDYyMy4wIKXMDSoASAFQAw%3D%3D"
          frameborder="0" allowfullscreen></iframe>
      </div>
      <div class="lado-formulario">
        <form>
          <label for="nombre">Nombre:</label>
          <input type="text" id="nombre" placeholder="Tu nombre" required>
          <label for="correo">Correo:</label>
          <input type="email" id="correo" placeholder="tu@correo.com" required>
          <label for="mensaje">Mensaje:</label>
          <textarea id="mensaje" rows="5" placeholder="Escribe tu mensaje..."></textarea>
          <button type="submit">Enviar</button>
        </form>
      </div>
    </section>
  </main>

  <!-- Pie de página -->
  <footer id="FOOTER" class="footer">
    <div class="footer-container">
      <div class="footer-col">
        <a href="#INICIO-PAGINA"><img src="IMAGENES/LOGO.png" alt="Logo WYK" class="footer-logo"></a>
        <h1 class="brand-name">WYK</h1>
        <p class="tagline">
        <h1>"Un pan para cada mesa, un momento para cada familia."</h1>
        </p>
      </div>


      <div class="footer-col">
        <h3>Más sobre WYK</h3>
        <ul>
          <li><a href="#">Nosotros</a></li>
          <li><a href="#">Servicios</a></li>
          <li><a href="#">Contáctanos</a></li>
          <li><a href="#">WYK</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h3>Síguenos</h3>
        <ul class="social-links">
          <li><a href="#"><i class="fab fa-facebook-f"></i> Facebook</a></li>
          <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
          <li><a href="#"><i class="fab fa-tiktok"></i> Tiktok</a></li>
        </ul>
        <div class="search-box">
          <input type="text" placeholder="Buscar..." id="search-input">
          <button id="search-btn"><i class="fas fa-search"></i></button>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>
      <h2>@ 2025 WYK proyecto SENA</h2>
      </p>
    </div>
  </footer>

  <script src="Pagina_Inicio.js"></script>

</body>
</html>
