document.addEventListener("DOMContentLoaded", () => {
  if (window.feather) feather.replace();

  const buttons = document.querySelectorAll(".has-submenu > .nav-btn");

  buttons.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault(); // Prevenir comportamiento por defecto como boton 'submit' y recargando la página.

      const parent = btn.closest(".has-submenu"); // 'closest' llama al ascendente más cercano (padre, abuelo, bisabuelo...) que contiene el submenu, osea el <li class="has-submenu" title="...">
      const submenu = parent.querySelector(".submenu");// Ya especificado el padre, osea el <li>, buscamos su submenu correspondiente al boton que se le hizo click.

      /*--- Alternar submenu actual con toggle ---*/
      //Agregar o quitar la clase 'open' al <li class="has-submenu">
      const isOpen = parent.classList.toggle("open");
      //Actualizar atributos aria
      btn.setAttribute("aria-expanded", isOpen ? "true" : "false");
      submenu.setAttribute("aria-hidden", isOpen ? "false" : "true");

      /*--- Cerrar otros submenus ---*/
      //Seleccionar todos los <li class="has-submenu .open"> mediante un ciclo 'forEach' y cada elemento lo llamamos 'openItem'
      document.querySelectorAll(".has-submenu.open").forEach((openItem) => {
        if (openItem !== parent) {
          openItem.classList.remove("open");//Cerrar el otro submenu
          //Actualizar atributos aria del otro submenu
          const otherBtn = openItem.querySelector(".nav-btn");
          if (otherBtn) otherBtn.setAttribute("aria-expanded", "false");
          const otherSub = openItem.querySelector(".submenu");
          if (otherSub) otherSub.setAttribute("aria-hidden", "true");
        }
      });
    });
  });

  /*--- Cerrar si hago click fuera del sidebar ---*/
  document.addEventListener("click", (e) => {
    
    // 'target' llama el elemento donde se hizo click, si no es un elemento dentro del sidebar
    if (!e.target.closest(".sidebar")) {
      document.querySelectorAll(".has-submenu.open").forEach((item) => {
        item.classList.remove("open");//Cerrar el submenu actual
        //Actualizar atributos aria del submenu actual
        const btn = item.querySelector(".nav-btn");
        if (btn) btn.setAttribute("aria-expanded", "false");
        const sub = item.querySelector(".submenu");
        if (sub) sub.setAttribute("aria-hidden", "true");
      });
    }
  });
});