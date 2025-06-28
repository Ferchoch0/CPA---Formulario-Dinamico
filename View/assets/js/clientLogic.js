document.addEventListener('DOMContentLoaded', () => {

    getClientsData();


    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'right',
            y: 'top',
        },
        dismissible: false,
    });

    function getClientsData() {
        fetch(`../Controller/clientController.php?action=getClients`)
            .then(response => response.json())
            .then(data => {
                const container = document.querySelector('.clients-items');
                container.innerHTML = '';

                if (data.length === 0) {
                    container.innerHTML = "<p>No hay clientes registrados</p>";
                    return;
                }

                const wrapper = document.createElement('div');
                wrapper.className = 'container-radio';

                const radioGroup = document.createElement('div');
                radioGroup.className = 'radio-tile-group';

                data.forEach(client => {
                    const inputContainer = document.createElement('div');
                    inputContainer.className = 'input-container';

                    const input = document.createElement('input');
                    input.type = 'radio';
                    input.className = 'radio-button';
                    input.name = 'client_id';
                    input.id = `client_${client.client_id}`;
                    input.value = client.client_id;

                    const tile = document.createElement('div');
                    tile.className = 'radio-tile';

                    const iconDiv = document.createElement('div');
                    iconDiv.className = 'icon client-icon';

                    const label = document.createElement('label');
                    label.htmlFor = `client_${client.client_id}`;
                    label.className = 'radio-tile-label';
                    label.textContent = client.name;

                    tile.appendChild(iconDiv);
                    tile.appendChild(label);

                    inputContainer.appendChild(input);
                    inputContainer.appendChild(tile);

                    radioGroup.appendChild(inputContainer);
                });

                wrapper.appendChild(radioGroup);
                container.appendChild(wrapper);

                const btnContainer = document.createElement('div');
                btnContainer.className = 'btn-primary-container';

                const submitBtn = document.createElement('button');
                submitBtn.type = 'submit';
                submitBtn.className = 'btn btn-primary';
                submitBtn.textContent = 'Seleccionar Cliente';

                btnContainer.appendChild(submitBtn);
                container.appendChild(btnContainer);
            })
            .catch(error => {
                console.error('Error fetching clients:', error);
            });
    }

    const modal = document.getElementById("addModal");
    const openModalBtn = document.querySelector(".menu--button");
    const closeModalBtn = document.querySelector(".close");

    if (openModalBtn) {
        openModalBtn.addEventListener("click", () => {
            modal.style.display = "flex";
            setTimeout(() => {
                modal.style.opacity = "1";
            }, 10); // Pequeño retraso para permitir que la transición ocurra
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", () => {
            modal.style.opacity = "0";
            setTimeout(() => {
                modal.style.display = "none";
            }, 300); // Tiempo de la transición
        });
    }

    window.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.opacity = "0";
            setTimeout(() => {
                modal.style.display = "none";
            }, 300); // Tiempo de la transición
        }
    });

    function addClient(form) {
        const formData = new FormData(form);
        formData.append('action', 'addClient');

        fetch(`../Controller/clientController.php`, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    notyf.success(data.message);
                    getClientsData();
                } else {
                    notyf.error('Error al agregar cliente: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error adding client:', error);
                notyf.error('Error al agregar cliente');
            });
    }

    document.getElementById('addClientForm').addEventListener('submit', function (e) {
        e.preventDefault();
        addClient(this);
    });

    function selectClient(form) {
        const formData = new FormData(form);
        formData.append('action', 'selectClient');

        fetch(`../Controller/clientController.php`, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    notyf.success(data.message);
                    setTimeout(() => {
                        window.location.href = '../View/services.php';
                    }, 2000);
                } else {
                    notyf.error('Error al seleccionar cliente: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error selecting client:', error);
                notyf.error('Error al seleccionar cliente');
            });
    }

    document.getElementById("selectClients").addEventListener("submit", function (e) {
        e.preventDefault();
        selectClient(this);
    });


});