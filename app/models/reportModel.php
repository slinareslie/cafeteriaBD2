<?php
require_once "../core/database.php";

class ReportModel {
    public function getSedes() {
        $query = "SELECT sede_id, nombre_sede FROM Sedes";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDeliveryClients($sede, $startDate, $endDate) {
        $query = "SELECT * FROM clients WHERE sede = :sede AND order_type = 'delivery' AND order_date BETWEEN :startDate AND :endDate";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->bindParam(':sede', $sede);
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductRanking($sede, $startDate, $endDate) {
        $query = "SELECT product_name, SUM(quantity) as total_sales
                  FROM orders
                  WHERE sede = :sede AND order_type = 'delivery'
                  AND order_date BETWEEN :startDate AND :endDate
                  GROUP BY product_name
                  ORDER BY total_sales DESC";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->bindParam(':sede', $sede);
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHourlyOrders($sede, $date) {
        $query = "SELECT HOUR(order_time) as hour, COUNT(*) as total_orders
                  FROM orders
                  WHERE sede = :sede AND DATE(order_date) = :date
                  GROUP BY HOUR(order_time)
                  ORDER BY hour";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->bindParam(':sede', $sede);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPresencialOrders($sede, $date) {
        $query = "SELECT * FROM clients
                  WHERE sede = :sede AND order_type = 'presencial'
                  AND order_date = :date AND total_amount > 50";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->bindParam(':sede', $sede);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalSales($sede, $startDate, $endDate) {
        $query = "SELECT SUM(total_amount) as total_sales
                  FROM orders
                  WHERE sede = :sede AND order_date BETWEEN :startDate AND :endDate";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->bindParam(':sede', $sede);
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>