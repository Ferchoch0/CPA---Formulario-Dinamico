<?php

session_start();
require_once '../Model/servicesModel.php';

$servicesModel = new ServicesModel($conn);
$servicesId = $_SESSION['services_id'] ?? 1; // Obtener el ID del servicio de la sesión, si está establecido

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
                echo json_encode($form); // Devolver el formulario en formato JSON
            } else {
                echo json_encode([]); // array vacío si no hay formulario
            }
            break;

        case 'getQuestions':
            $optionId = $_GET['optionId'] ?? null;
            $questions = $servicesModel->getQuestions($optionId);
            if ($questions) {
                echo json_encode($questions); // Devolver las preguntas en formato JSON
            } else {
                echo json_encode([]); // array vacío si no hay preguntas
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

        case 'submitForm':
            if (isset($_POST['formData'])) {

                $clientId = $_POST['clientId'] ?? null;
                $fechVisit = $_POST['fechVisit'] ?? null;
                $pdfFile = $_POST['pdfFile'] ?? null;

                if ($serviceId) {
                    $result = $servicesModel->historyService($servicesId, $clientId, $fechVisit, $pdfFile);
                    if ($result) {
                        echo json_encode([
                            'status' => 'success', 
                            'message' => 'Formulario enviado correctamente'
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error', 
                            'message' => 'Error al enviar el formulario'
                        ]);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'ID de servicio no encontrado en la sesión']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Datos del formulario no proporcionados']);
            }
        default:
            throw new Exception("Acción no válida");
    }
}

?>