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
    $action = $_POST['action'];
    
    switch ($action) {
        case 'selectService':
            if (isset($_POST['service'])) {
                $serviceId = $_POST['service'];
                $_SESSION['service'] = $serviceId; // Guardar el ID del servicio en la sesión
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Servicio seleccionado correctamente', 
                    'serviceId' => $serviceId 
                ]);
            } else {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'ID de servicio no proporcionado'
                ]);
            }
            break;
        default:
            throw new Exception("Acción no válida");
    }
}

?>