<?php

require_once 'connection.php';

class ServicesModel{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllServices() {
        $sql = "SELECT * FROM services";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function getForm($serviceId) {
        $sql = "SELECT * FROM service_options WHERE services_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $serviceId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getQuestions($optionId) {
        $sql = "SELECT * FROM questions WHERE option_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $optionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function historyService($serviceId, $clientId, $fechVisit, $pdfFile) {
        $sql = "INSERT INTO services_history (services_id, client_id, fech_visit, pdf_file) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiss", $serviceId, $clientId, $fechVisit, $pdfFile);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        
    }


}

?>