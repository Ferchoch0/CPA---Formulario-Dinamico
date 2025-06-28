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
            if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['address'])) {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $address = $_POST['address'];

                $result = $clientsModel->addClient($name, $description, $address);
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

        default:
            throw new Exception("Acción no válida");
    }

}else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}


?>