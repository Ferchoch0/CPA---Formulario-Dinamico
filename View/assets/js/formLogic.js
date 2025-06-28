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
            const container = document.querySelector('.questions-items');
            container.innerHTML = '';

            if (data.length === 0) {
                container.innerHTML = "<p>No hay productos registrados</p>";
                return;
            }

            data.forEach(option => {
                const wrapper = document.createElement('div');
                wrapper.className = 'form-group';

                const label = document.createElement('label');
                label.textContent = option.name;
                label.setAttribute('for', 'question_' + option.option_id);
                wrapper.appendChild(label);

                if (option.type === 'textarea') {
                    const textarea = document.createElement('textarea');
                    textarea.name = 'question_' + option.option_id;
                    textarea.id = 'question_' + option.option_id;
                    textarea.required = true;
                    wrapper.appendChild(textarea);
                } else if (option.type === 'radio') {
                    const radioContainer = document.createElement('div');
                    radioContainer.className = 'radio';

                    getQuestionData(option.option_id, 'question_' + option.option_id, radioContainer);

                    wrapper.appendChild(radioContainer);
                } else {
                    const input = document.createElement('input');
                    input.type = option.type;
                    input.name = 'question_' + option.option_id;
                    input.id = 'question_' + option.option_id;
                    input.required = true;
                    wrapper.appendChild(input);
                }

                container.appendChild(wrapper);
            });

             const submitBtn = document.createElement('button');
                submitBtn.type = 'submit';
                submitBtn.className = 'submit-btn';
                submitBtn.textContent = 'Continuar';
                container.appendChild(submitBtn);
        })
        .catch(error => {
            console.error('Error cargando las opciones del formulario:', error);
        });
}

function getQuestionData(optionId, inputName, container) {
    console.log(`Cargando preguntas para la opción: ${optionId} con nombre: ${inputName} en el contenedor`, container);
    fetch(`../Controller/servicesController.php?action=getQuestions&optionId=${optionId}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(question => {
                const input = document.createElement('input');
                input.type = 'radio';
                input.id = `${inputName}_${question.question_id}`;
                input.name = inputName;
                input.value = question.value;

                const label = document.createElement('label');
                label.setAttribute('for', input.id);
                label.textContent = question.label;

                container.appendChild(input);
                container.appendChild(label);
            });
        })
        .catch(error => {
            console.error('Error cargando las preguntas:', error);
        });
}

function submitForm(form) {
    const formData = new FormData(form);
    formData.append('action', 'submitForm');

    fetch('../Controller/generatorController.php', {
        method: "POST",
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                notyf.success(data.message);
                setTimeout(() => {
                    console.log('Redirigiendo a la página de inicio...');
                }, 2000);
            } else {
                notyf.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error al enviar el formulario:', error);
        });
    }

    document.getElementById('selectQuestions').addEventListener('submit', function (e) {
        e.preventDefault();
        submitForm(this);
    });

})