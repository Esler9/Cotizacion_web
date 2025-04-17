// public/js/options.js

document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tabs button');
    const contents = document.querySelectorAll('.tab-content');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let current = 0;
  
    function activateTab(index) {
      // Desactivar pestaña y contenido actual
      tabs[current].classList.remove('active');
      contents[current].classList.remove('active');
      // Activar nueva
      current = index;
      tabs[current].classList.add('active');
      contents[current].classList.add('active');
      // Actualizar estado de botones
      prevBtn.disabled = current === 0;
      if (current === tabs.length - 1) {
        nextBtn.textContent = 'Generar Cotización';
        nextBtn.type = 'submit';
      } else {
        nextBtn.textContent = 'Siguiente';
        nextBtn.type = 'button';
      }
    }
  
    // Click en pestañas
    tabs.forEach((tab, i) => {
      tab.addEventListener('click', () => activateTab(i));
    });
  
    // Botón Anterior
    prevBtn.addEventListener('click', () => {
      if (current > 0) activateTab(current - 1);
    });
  
    // Botón Siguiente / Submit
    nextBtn.addEventListener('click', (e) => {
      // Si no es la última pestaña, navegar
      if (current < tabs.length - 1) {
        e.preventDefault();
        activateTab(current + 1);
      }
      // Si es la última, dejamos que el formulario se envíe
    });
  
    // Inicializar en la primera pestaña
    activateTab(0);
  });
  