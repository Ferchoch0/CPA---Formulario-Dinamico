<?php
session_start();

require_once '../Model/servicesModel.php';
require_once '../Services/PDFServices.php';
require_once '../Services/ExcelServices.php';

$servicesModel = new ServicesModel($conn);
$servicesId = $_SESSION['services_id'] ?? 1; // Obtener el ID del servicio de la sesión, si está establecido 

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    switch ($action) {
        case 'submitForm':
            $questions = $servicesModel->getForm($servicesId);
            $data = $servicesModel->getClient($_SESSION['client_id'] ?? null); // Obtener los datos del cliente de la sesión, si está establecido

            try {
                $pdfFile = PDFService::generatePDF($questions, $_POST, $data);
                $excelFile = ExcelService::generateExcel($questions, $_POST);
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error inesperado al generar el PDF: ' . $e->getMessage()
                ]);
                exit;
            }
            if ($pdfFile) {
                $pdfName = basename($pdfFile);
                $excelName = basename($excelFile);
                $clientId = $_SESSION['client_id'] ?? null; // Obtener el ID del cliente de la sesión, si está establecido
                $fechVisit = date('Y-m-d H:i:s'); // Fecha y hora actual
                $nameClient = $data['name'] ?? 'Cliente Desconocido'; // Nombre del cliente, si está disponible

                $result = $servicesModel->historyService($servicesId, $clientId, $fechVisit, $pdfName);

                if ($result) {

                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Formulario enviado y PDF generado correctamente',
                        'pdfFile' => $pdfFile,
                        'excelFile' => $excelFile,
                        'pdfName' => $pdfName,
                        'excelName' => $excelName,
                        'clientName' => $nameClient,

                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Error al guardar el historial del servicio'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al generar el PDF'
                ]);
            }

            break;

        default:
            echo json_encode([
                'status' => 'error',
                'message' => 'Acción no válida'
            ]);
            break;
    }
}

?>