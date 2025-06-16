document.addEventListener('DOMContentLoaded', function () {
    getServicesData();

 function getServicesData() {
        fetch('../Controller/servicesController.php?action=getServices')
            .then(response => response.json())
            .then(data => {
                const container = document.querySelector('.services-items');
                container.innerHTML = '';
                if (data.length === 0) {
                    container.innerHTML = "<p>No hay servicios registrados</p>";
                    return;
                }

                data.forEach((service, index) => {
                    const label = document.createElement('label');
                    label.className = 'service-item';

                    const input = document.createElement('input');
                    input.type = 'radio';
                    input.className = 'radio-input';
                    input.name = 'service';
                    input.value = service.service_id;
                    if (index === 0) input.checked = true;

                    input.addEventListener('change', () => {
                        // Podés guardar en sesión o manejar la lógica de selección acá
                        selectService(service.service_id);
                    });

                    const iconSpan = document.createElement('span');
                    iconSpan.className = 'radio-tile';
                    iconSpan.innerHTML = `<iconify-icon icon="${service.icon}" width="24" height="24"></iconify-icon>`;

                    const name = document.createElement('h2');
                    name.textContent = service.name;

                    label.appendChild(input);
                    label.appendChild(iconSpan);
                    label.appendChild(name);

                    container.appendChild(label);
                });

                 const submitBtn = document.createElement('button');
                submitBtn.type = 'submit';
                submitBtn.className = 'submit-btn'; // Por si querés darle estilos
                submitBtn.textContent = 'Continuar';
                container.appendChild(submitBtn);
            })
            .catch(error => {
                console.error('Error cargando los servicios:', error);
            });
    }
});