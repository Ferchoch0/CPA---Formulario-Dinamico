<?php

require_once 'connection.php';

class ClientsModel{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllClients() {
        $sql = "SELECT * FROM clients";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function addClient($name, $description, $address) {
        $sql = "INSERT INTO clients (name, description, address) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $name, $description, $address);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

?>