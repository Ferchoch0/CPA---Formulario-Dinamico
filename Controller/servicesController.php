<?php

session_start();
require_once '../Model/servicesModel.php';

$servicesModel = new ServicesModel($conn);
$servicesId = $_SESSION['services_id'] ?? null;

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $action = $_GET['action'];

    switch ($action) {
        case 'getServices':
             $services = $servicesModel->getAllServices();
            if ($services) {
                echo json_encode($services); // Solo devolver datos
            } else {
                echo json_encode([]); // array vacío si no hay servicios
            }
            break;
            
        case 'getOptions':
            $form = $servicesModel->getForm($servicesId);
             if ($form) {
                foreach ($form as $formItem) {
                    echo "
                        <div>
                            <h2>{$formItem['name']}</h2>
                            <input type='{$formItem['type']}' name='{$formItem['name']}' required>
                        </div>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay productos registrados</td></tr>";
            }
            break;
        default:
            throw new Exception("Acción no válida");
    }
} else if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

}

?>