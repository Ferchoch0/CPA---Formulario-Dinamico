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

    public function getForm($service_id) {
        $sql = "SELECT * FROM service_options WHERE services_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getQuestions($option_id) {
        $sql = "SELECT * FROM questions WHERE option_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $option_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


}

?>