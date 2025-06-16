<?php

require_once 'head.php'

    ?>

<link rel="stylesheet" href="assets/css/form.css">

</head>

<body>

    <?php require_once 'navbar.php' ?>

    <main>
        <div class="container">
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="">Seleccionar:</label>
                    <div class="radio">
                        <input type="radio" id="control_plagas" name="servicio" value="control_plagas">
                        <label for="control_plagas">opcion 1</label>
                        <input type="radio" id="aire_acondicionado" name="servicio" value="aire_acondicionado">
                        <label for="aire_acondicionado">opcion 2</label>
                    </div>

                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje:</label>
                    <textarea type="text" id="mensaje" name="mensaje"></textarea>
                </div>
                <div class="form-boton">
                    <button type="submit" class="button">Enviar</button>
                </div>
            </form>

        </div>
    </main>

</body>

</html>