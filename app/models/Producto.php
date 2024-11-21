<?php
require_once "../core/database.php";

class Producto {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT p.producto_id, p.nombre_producto, p.categoria, p.descripcion, hp.precio 
                                      FROM Productos p
                                      LEFT JOIN Historial_Precios hp 
                                      ON p.producto_id = hp.producto_id 
                                      WHERE hp.fecha_fin IS NULL OR hp.fecha_fin > NOW()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategoria($categoria) {
        $stmt = $this->conn->prepare("SELECT p.producto_id, p.nombre_producto, p.categoria, p.descripcion, hp.precio 
                                      FROM Productos p
                                      LEFT JOIN Historial_Precios hp 
                                      ON p.producto_id = hp.producto_id 
                                      WHERE p.categoria = :categoria 
                                      AND (hp.fecha_fin IS NULL OR hp.fecha_fin > NOW())");
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>