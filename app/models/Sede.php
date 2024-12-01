<?php
require_once "../core/database.php";

class Sede {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function obtenerMesasPorSede($sede_id) {
        $stmt = $this->conn->prepare("SELECT * FROM Mesas WHERE sede_id = :sede_id");
        $stmt->bindParam(':sede_id', $sede_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEmpleadosPorSede($sede_id) {
        $stmt = $this->conn->prepare("SELECT * FROM Empleados WHERE sede_id = :sede_id");
        $stmt->bindParam(':sede_id', $sede_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAll() {
        $db = new Database();
        $stmt = $db->connect()->prepare("SELECT * FROM Sedes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>