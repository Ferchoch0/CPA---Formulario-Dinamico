document.addEventListener('DOMContentLoaded', function() {

    getServicesData();

    function getServicesData() {
        fetch('../Controller/buyController.php?action=getOptions')
            .then(response => response.text())
            .then(html => {
                document.querySelector('.options-table').innerHTML = html;
            })
            .catch(error => {
                console.error('Error recargando las preguntas:', error);
            });
    }

})