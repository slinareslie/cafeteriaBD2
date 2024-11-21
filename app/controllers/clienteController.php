<?php
require_once "../app/models/Producto.php";
require_once "../app/models/Sede.php";

class ClienteController {
    public function seleccionarSede() {
        $sedeModel = new Sede();
        $sedes = $sedeModel->getAll();
        require_once "../app/views/cliente/seleccionarSede.php";
    }

    public function seleccionarProductos() {
        $productoModel = new Producto();
        $productos = $productoModel->getAll();
        require_once "../app/views/cliente/seleccionarProductos.php";
    }

    public function confirmarCompra() {
        $productosSeleccionados = $_POST['productos'];
        require_once "../app/views/cliente/facturacion.php";
    }
}
?>