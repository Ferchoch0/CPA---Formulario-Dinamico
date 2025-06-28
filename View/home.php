<?php

require_once 'head.php'

    ?>

<link rel="stylesheet" href="assets/css/home.css">
<link rel="stylesheet" href="assets/css/modal.css">


</head>

<body>

    <?php require_once 'navbar.php' ?>

    <main class="container">
        <div class="menu--button-container">
            <button class="menu--button">Crear Nuevo cliente</button>
        </div>

        <form id="selectClients" class="clients-items">
            

        </form>
        

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

                    <button type="submit" class="submit-button">Agregar</button>
                </form>
            </div>
        </div>
    </main>

</body>

<script src="assets/js/clientLogic.js"></script>


</html>