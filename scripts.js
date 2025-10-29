document.addEventListener('DOMContentLoaded', function() {

    // Elementos del DOM
    const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
    const totalPriceElement = document.getElementById('total-price');
    const turnosLinks = document.querySelectorAll('.list-group-item-action');
    const formularioSection = document.getElementById('formulario-modificacion');
    const bookingForm = document.getElementById('booking-form');

    // Elementos del formulario
    const turnoIdSpan = document.getElementById('turno-id');
    const idReservaInput = document.getElementById('id_reserva');
    const nombreInput = document.getElementById('nombre');
    const fechaInput = document.getElementById('fecha');

    /**
     * Función para calcular y actualizar el precio total de los servicios seleccionados.
     */
    function updateTotalPrice() {
        let total = 0;
        serviceCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                total += parseInt(checkbox.value, 10);
            }
        });
        totalPriceElement.textContent = total;
    }

    // Añadir listener a cada checkbox de servicio
    serviceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotalPrice);
    });

    /**
     * Función para rellenar el formulario cuando se selecciona un turno.
     */
    turnosLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            // Obtener datos del turno desde los atributos data-*
            const turnoId = this.getAttribute('data-id');
            const nombreCliente = this.getAttribute('data-nombre');
            const fechaTurno = this.getAttribute('data-fecha');

            // Rellenar los campos del formulario
            turnoIdSpan.textContent = `#${turnoId}`;
            idReservaInput.value = turnoId;
            nombreInput.value = nombreCliente;
            fechaInput.value = fechaTurno;

            // Limpiar checkboxes y recalcular el total
            serviceCheckboxes.forEach(cb => cb.checked = false);
            updateTotalPrice();

            // Mostrar el formulario
            formularioSection.style.display = 'block';

            // Scroll suave hacia el formulario
            formularioSection.scrollIntoView({ behavior: 'smooth' });
        });
    });

    /**
     * Validación del formulario antes del envío.
     */
    bookingForm.addEventListener('submit', function(event) {
        // Validación de campos básicos
        if (nombreInput.value.trim() === '' || fechaInput.value.trim() === '') {
            alert('Por favor, completa el nombre y la fecha del turno.');
            event.preventDefault(); // Evita el envío
            return;
        }

        // Validación de que al menos un servicio esté seleccionado
        const isServiceSelected = Array.from(serviceCheckboxes).some(cb => cb.checked);
        if (!isServiceSelected) {
            alert('Debes seleccionar al menos un servicio.');
            event.preventDefault(); // Evita el envío
        }
    });

});
