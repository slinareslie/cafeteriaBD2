<?php
require_once '../models/reportModel.php';

class ReportController {
    private $reportModel;

    public function __construct() {
        $this->reportModel = new ReportModel();
    }

    // Método para obtener todas las sedes
    public function showSedes() {
        return $this->reportModel->getSedes();
    }

    // Método para obtener los clientes con pedidos de entrega en un rango de fechas
    public function getDeliveryClients($sede, $startDate, $endDate) {
        return $this->reportModel->getDeliveryClients($sede, $startDate, $endDate);
    }

    // Método para obtener el ranking de productos vendidos
    public function getProductRanking($sede, $startDate, $endDate) {
        return $this->reportModel->getProductRanking($sede, $startDate, $endDate);
    }

    // Método para obtener los pedidos por hora
    public function getHourlyOrders($sede, $date) {
        return $this->reportModel->getHourlyOrders($sede, $date);
    }
}

$controller = new ReportController();
$action = isset($_GET['action']) ? $_GET['action'] : 'showReport';

if ($action === 'getSedes') {
    $sedes = $controller->showSedes();
    echo json_encode($sedes);
    exit;
}

if ($action === 'getDeliveryClients') {
    $sede = $_POST['sede'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $clients = $controller->getDeliveryClients($sede, $startDate, $endDate);
    echo json_encode($clients);
    exit;
}

if ($action === 'getProductRanking') {
    $sede = $_POST['sede'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $ranking = $controller->getProductRanking($sede, $startDate, $endDate);
    echo json_encode($ranking);
    exit;
}

if ($action === 'getHourlyOrders') {
    $sede = $_POST['sede'];
    $date = $_POST['date'];
    $orders = $controller->getHourlyOrders($sede, $date);
    echo json_encode($orders);
    exit;
}