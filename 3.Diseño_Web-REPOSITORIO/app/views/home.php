<!DOCTYPE html>
<html lang="es">

<body>
  <?php include_once "layouts/headers/headerHome.php";?>
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
        <source src="<?php echo \Config\APP_URL; ?>public/videos/home_background.mp4" type="video/mp4">
      </video>
      <div class="texto-video">
        <h1>PANADERIA Y CAFETERIA WYK</h1>
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
            <img src="<?php echo \Config\APP_URL; ?>public/images/imgHome/carruselPanaderia.jpg" alt="Panaderia">
            <div class="texto-carrusel">Panaderia</div>
          </div>
          <div class="slide">
            <img src="<?php echo \Config\APP_URL; ?>public/images/imgHome/carruselDesayuno.jpg" alt="Desayunos">
            <div class="texto-carrusel">Desayunos</div>
          </div>
          <div class="slide">
            <img src="<?php echo \Config\APP_URL; ?>public/images/imgHome/carruselReposteria.jpg" alt="Reposteria">
            <div class="texto-carrusel">Reposteria</div>
          </div>
          <div class="slide">
            <img src="<?php echo \Config\APP_URL; ?>public/images/imgHome/carruselBebidas.jpg" alt="Bebidas">
            <div class="texto-carrusel">Bebidas</div>
          </div>
          <div class="slide">
            <img src="<?php echo \Config\APP_URL; ?>public/images/imgHome/carruselOnces.jpg" alt="Onces">
            <div class="texto-carrusel">Onces</div>
          </div>
          <div class="slide">
            <img src="<?php echo \Config\APP_URL; ?>public/images/imgHome/carruselViveres.jpg" alt="Viveres">
            <div class="texto-carrusel">Viveres</div>
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
          <source src="../../public/videos/home_background.mp4" type="video/mp4">
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
        <iframe title="Ubicación de Panadería WYK" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d497.10564540214904!2d-74.1437241!3d4.621699!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9ea3ba1f15e1%3A0x723822705661cdae!2sPanaderia%20Cafeter%C3%ADa%20WYK!5e0!3m2!1ses-419!2sco!4v1756089950478!5m2!1ses-419!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
    <?php include_once "layouts/footers/footerHome.php"; ?>
  </main>
  <script src="<?php echo \Config\APP_URL; ?>/public/js/home.js"></script>

</body>
</html>
