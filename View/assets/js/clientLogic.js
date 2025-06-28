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

                data.forEach(client => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'form-group';

                    const label = document.createElement('label');
                    label.textContent = client.name;
                    label.setAttribute('for', 'client_' + client.client_id);
                    wrapper.appendChild(label);

                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = 'client_' + client.client_id;
                    input.id = 'client_' + client.client_id;
                    input.required = true;
                    wrapper.appendChild(input);

                    container.appendChild(wrapper);
                });

                const submitBtn = document.createElement('button');
                submitBtn.type = 'submit';
                submitBtn.className = 'btn btn-primary';
                submitBtn.textContent = 'Enviar';
                container.appendChild(submitBtn);
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

        fetch(`../Controller/servicesController.php?action=addClient`, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notyf.success('Cliente agregado exitosamente');
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

});