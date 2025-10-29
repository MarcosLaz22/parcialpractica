document.addEventListener('DOMContentLoaded', () => {
    // Lógica para el carrusel de imágenes
    const carousel = document.querySelector('.carousel');
    if (carousel) {
        // Aquí irá la lógica del carrusel
    }

    // Lógica para la calculadora de precios
    const servicios = document.querySelectorAll('#servicios input[type="checkbox"]');
    const totalElement = document.getElementById('total');

    if (servicios.length > 0 && totalElement) {
        servicios.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                let total = 0;
                servicios.forEach(cb => {
                    if (cb.checked) {
                        total += parseInt(cb.dataset.price);
                    }
                });
                totalElement.textContent = total;
            });
        });
    }

    // Lógica para la validación del formulario
    const form = document.getElementById('reserva-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            const nombre = document.getElementById('nombre').value;
            const telefono = document.getElementById('telefono').value;
            const fecha = document.getElementById('fecha').value;
            const hora = document.getElementById('hora').value;
            const barbero = document.getElementById('barbero').value;
            const serviciosSeleccionados = document.querySelectorAll('#servicios input[type="checkbox"]:checked');

            if (nombre === '' || telefono === '' || fecha === '' || hora === '' || barbero === '') {
                alert('Por favor, complete todos los campos obligatorios.');
                e.preventDefault();
                return;
            }

            if (serviciosSeleccionados.length === 0) {
                alert('Por favor, seleccione al menos un servicio.');
                e.preventDefault();
                return;
            }
        });
    }
});