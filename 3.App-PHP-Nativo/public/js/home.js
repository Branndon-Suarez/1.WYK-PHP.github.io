/*EFECTO DEL ENCABEZADO AL BAJAR*/
const header = document.getElementById('ENCABEZADO');
let lastScroll = 0;

window.addEventListener('scroll', () => {
    const currentScroll = window.scrollY;
    
    if (currentScroll <= 0) {
        header.classList.add('none-scrolled');
        header.classList.remove('active-scrolled');
    }else if (currentScroll > lastScroll) {
        if (currentScroll > 50) {
            header.classList.remove('none-scrolled');
            header.classList.add('active-scrolled');
        }
    }
    
    lastScroll = currentScroll;
});

/*EFECTO DE DESPLEGAR BARRA DE BÚSQUEDA*/
let botonBusqueda = document.getElementById('boton-busqueda');
let inputBusqueda = document.getElementById('busqueda');

botonBusqueda.onclick = function() {
    inputBusqueda.classList.toggle('activo');
    if (inputBusqueda.classList.contains('activo')) {
        inputBusqueda.focus();
    }
};

document.addEventListener('click', function(event) {
    const isClickInsideSearchContainer = botonBusqueda.contains(event.target) || inputBusqueda.contains(event.target);
    if (!isClickInsideSearchContainer && inputBusqueda.classList.contains('activo')) {
        inputBusqueda.classList.remove('activo');
    }
});


/* FUNCIÓN DEL MENÚ DESPLEGABLE */
let menuToggle = document.getElementById('boton-menu');
let ENCABEZADO = document.getElementById('ENCABEZADO');
let sidebar = document.getElementById('menu-pagina-inicio');
let mainContent = document.getElementById('MAIN');

let Menulist = document.querySelectorAll('.Menulist li');
function activeLink(){
    Menulist.forEach((item) => 
    item.classList.remove('Color_Desplazar'));
    this.classList.add('Color_Desplazar')
}
Menulist.forEach((item) =>
item.addEventListener('click',activeLink));

menuToggle.onclick = function(){
    ENCABEZADO.classList.toggle('active');
    sidebar.classList.toggle('active');

    if (sidebar.classList.contains('active')) {
        mainContent.style.marginLeft = '200px';
    } else {
        ENCABEZADO.style.marginLeft = '0px';
        mainContent.style.marginLeft = 'auto';
    }
}


const seccionNosotros = document.querySelector('.seccion-nosotros');
const letras = seccionNosotros.querySelectorAll('.letra');

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            letras.forEach(letra => {
                letra.classList.add('animada');
            });
        } else {
            letras.forEach(letra => {
                letra.classList.remove('animada');
            });
        }
    });
}, {
    threshold: 0.5 // cuando el 50% de la seccion esta visible
});

const slides = document.querySelectorAll('.slide');
let indiceActual = 0;

function mostrarSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove('activo');
        if (i === index) slide.classList.add('activo');
    });
}

function moverSlide(direccion) {
    indiceActual += direccion;
    if (indiceActual < 0) indiceActual = slides.length - 1;
    if (indiceActual >= slides.length) indiceActual = 0;
    mostrarSlide(indiceActual);
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') moverSlide(-1);
    if (e.key === 'ArrowRight') moverSlide(1);
});
observer.observe(seccionNosotros);
