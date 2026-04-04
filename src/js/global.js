(() => {
  // Elementos del DOM
  const sidebar      = document.getElementById("sidebar");
  const header       = document.getElementById("header");
  const mainContent  = document.getElementById("mainContent");
  const overlay      = document.getElementById("overlay");

  // Detecta si es pantalla móvil (menor o igual a 768px)
  const esMobile = () => window.innerWidth <= 768;

  // Toggle del sidebar al hacer click en el botón
  document.getElementById("toggleSidebar").addEventListener("click", () => {
    if (esMobile()) {
      // En móvil: muestra sidebar con overlay
      sidebar.classList.toggle("show");
      overlay.classList.toggle("show");
    } else {
      // En escritorio: colapsa sidebar y expande header y contenido
      sidebar.classList.toggle("hidden");
      header.classList.toggle("expanded");
      mainContent.classList.toggle("expanded");
    }
  });

  // Cierra el sidebar en móvil
  const cerrarSidebarMobile = () => {
    if (esMobile()) {
      sidebar.classList.remove("show");
      overlay.classList.remove("show");
    }
  };

  // Cierra el sidebar al hacer click en el overlay
  overlay.addEventListener("click", cerrarSidebarMobile);

  // Cierra el sidebar móvil si se redimensiona a escritorio
  window.addEventListener("resize", () => {
    if (!esMobile()) {
      sidebar.classList.remove("show");
      overlay.classList.remove("show");
    }
  });

  // Maneja las alertas flash con animación
  document.addEventListener("DOMContentLoaded", () => {
    const alertaContainer = document.getElementById("alerta-flash-container");

    if (alertaContainer) {
      setTimeout(() => alertaContainer.classList.add("slide-fade"), 100);      // inicia animación
      setTimeout(() => alertaContainer.classList.remove("slide-fade"), 8000);  // termina animación
      setTimeout(() => alertaContainer.remove(), 9000);                        // elimina del DOM
    }
  });

  // Función global para hacer peticiones REST con fetch
  window.restFetch = async (url, method = "GET", body = null) => {
    const opciones = { method };

    if (body) {
      opciones.headers = { "Content-Type": "application/json" };
      opciones.body = JSON.stringify(body);
    }

    const response = await fetch(url, opciones);
    return await response.json();
  };

  // Formatea un número como moneda con puntos (ej: 1.000.000)
  window.formatearMoneda = (valor) => {
    return valor
      .replace(/\D/g, "")                          // elimina todo lo que no sea dígito
      .replace(/\B(?=(\d{3})+(?!\d))/g, ".");      // agrega puntos cada 3 dígitos
  };

  // Formatea un input de moneda manteniendo la posición del cursor
  window.formatearMonedaInput = (input) => {
    const posicionCursor  = input.selectionStart;
    const valorAnterior   = input.value;

    input.value = formatearMoneda(input.value);

    const diferencia = input.value.length - valorAnterior.length;
    input.setSelectionRange(posicionCursor + diferencia, posicionCursor + diferencia);
  };

  // Convierte fecha de YYYY-MM-DD a DD-MM-YYYY
  window.formatearFecha = (fecha) => {
    const [anio, mes, dia] = fecha.split("-");
    return `${dia}-${mes}-${anio}`;
  };

})();