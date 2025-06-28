<?php
session_start();
require_once '../Model/clientModel.php';

$clientsModel = new ClientsModel($conn);

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];

    switch ($action) {
        case 'getClients':
            $clients = $clientsModel->getAllClients();
            if ($clients) {
                echo json_encode($clients); // Solo devolver datos
            } else {
                echo json_encode([]); // array vacío si no hay clientes
            }
            break;

        default:
            throw new Exception("Acción no válida");
    }
} elseif(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'addClient':
            if (isset($_POST['name']) && isset($_POST['contact']) && isset($_POST['address'])) {
                $name = $_POST['name'];
                $contact = $_POST['contact'];
                $address = $_POST['address'];
                $fech = date('Y-m-d H:i:s');

                $result = $clientsModel->addClient($name, $contact, $address, $fech);
                if ($result) {
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Cliente agregado correctamente'
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error', 
                        'message' => 'Error al agregar el cliente'
                    ]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
            }
            break;

        case 'selectClient':
            if (isset($_POST['client_id'])) {
                $clientId = $_POST['client_id'];
                $_SESSION['client_id'] = $clientId;
                echo json_encode(['status' => 'success', 'message' => 'Cliente seleccionado correctamente']);
                
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de cliente no proporcionado']);
            }
            break;

        default:
            throw new Exception("Acción no válida");
    }

}else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}


?>