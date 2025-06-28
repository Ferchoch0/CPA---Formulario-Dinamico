<?php

require_once 'head.php'

    ?>

<link rel="stylesheet" href="assets/css/home.css">
<link rel="stylesheet" href="assets/css/modal.css">


</head>

<body>

    <?php require_once 'navbar.php' ?>

    <main class="container">
        <form id="selectClients" class="clients-items">
            <div class="container-radio">
                <div class="radio-tile-group">
                    <div class="input-container">
                        <input id="walk" class="radio-button" type="radio" name="radio">
                        <div class="radio-tile">
                            <div class="icon walk-icon">

                            </div>
                            <label for="walk" class="radio-tile-label">Walk</label>
                        </div>
                    </div>

                    <div class="input-container">
                        <input id="bike" class="radio-button" type="radio" name="radio">
                        <div class="radio-tile">
                            <div class="icon bike-icon">

                            </div>
                            <label for="bike" class="radio-tile-label">Bike</label>
                        </div>
                    </div>

                    <div class="input-container">
                        <input id="drive" class="radio-button" type="radio" name="radio">
                        <div class="radio-tile">
                            <div class="icon car-icon">

                            </div>
                            <label for="drive" class="radio-tile-label">Drive</label>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        <div class="menu--button-container">
            <button class="menu--button">Crear Nuevo cliente</button>
        </div>

        <div id="addModal" class="modal">
            <div class="modal-content little">
                <span class="close close-cash">&times;</span>
                <p class="modal-title">Agregar Cliente</p>
                <form id="addClientForm" method="POST">
                    <label class="label-sub-title">
                        <span class="modal-sub-title">Nombre</span>
                        <div class="modal-field-container">
                            <input type="text" class="modal-field" name="name" id="name"
                                placeholder="Ingresar un Nombre" autocomplete="off" required>
                        </div>
                    </label>

                    <label class="label-sub-title">
                        <span class="modal-sub-title">Contacto</span>
                        <div class="modal-field-container">
                            <input type="text" class="modal-field" name="contact" id="contact"
                                placeholder="Ingresar un Contacto" autocomplete="off" required>
                        </div>
                    </label>

                    <label class="label-sub-title">
                        <span class="modal-sub-title">Direccion</span>
                        <div class="modal-field-container">
                            <input type="text" class="modal-field" name="address" id="address"
                                placeholder="Ingresar una Direccion" autocomplete="off" required>
                        </div>
                    </label>
                </form>
            </div>
        </div>
    </main>

</body>


</html>