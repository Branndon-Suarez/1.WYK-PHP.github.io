let menuToggle = document.querySelector('.menuToggle');
let sidebar = document.querySelector('.sidebar');
let imagen_logo = document.querySelector('.imagen_logo');
menuToggle.onclick =function(){
    menuToggle.classList.toggle('active');
    sidebar.classList.toggle('active');
    imagen_logo.classList.toggle('active');
}

let Menulist = document.querySelectorAll('.Menulis li');
function activeLink(){
    Menulist.forEach((item) => 
    item.classList.remove('Color_Desplazar'));
    this.classList.add('Color_Desplazar')
}

Menulist.forEach((item) =>
item.addEventListener('click',activeLink));

let mainContent = document.querySelector('main');
menuToggle.onclick = function(){
    menuToggle.classList.toggle('active');
    sidebar.classList.toggle('active');
    imagen_logo.classList.toggle('active');

    if (sidebar.classList.contains('active')) {
        mainContent.style.marginLeft = '250px'; /* Ajusta este valor al ancho de tu menú */
        menuToggle.style.marginLeft = '250px'; /* Boton de desplazar se acomoda*/
        imagen_logo.style.marginLeft = '70px'; /*Imagen se acomoda */
    } else {
        mainContent.style.marginLeft = '80px';
        menuToggle.style.marginLeft = '100px';
        imagen_logo.style.marginLeft = '0px';
    }
}