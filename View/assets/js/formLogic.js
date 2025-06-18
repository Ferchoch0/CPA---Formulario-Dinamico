document.addEventListener('DOMContentLoaded', function () {

    getOptionsData();

    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'right',
            y: 'top',
        },
        dismissible: false,
    });

    function getOptionsData() {
        fetch(`../Controller/servicesController.php?action=getOptions`)
            .then(response => response.json())
            .then(data => {
                const container = document.querySelector('.form-options');
                container.innerHTML = '';

                if (data.length === 0) {
                    container.innerHTML = "<p>No hay productos registrados</p>";
                    return;
                }

                data.forEach(option => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'form-item';

                    const label = document.createElement('label');
                    label.textContent = option.name;
                    label.setAttribute('for', option.name);

                    const input = document.createElement('input');
                    input.type = option.type;
                    input.name = option.name;
                    input.id = option.name;
                    input.required = true;

                    wrapper.appendChild(label);
                    wrapper.appendChild(input);
                    container.appendChild(wrapper);
                });
            })
            .catch(error => {
                console.error('Error cargando las opciones del formulario:', error);
            });
    }

})