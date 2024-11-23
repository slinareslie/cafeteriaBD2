<?php
require_once "../app/models/Pedido.php";
require_once "../app/models/Producto.php";
require_once "../app/models/Sede.php";

class EmpleadoController {
    public function seleccionarSede() {
        $sedeModel = new Sede();
        $sedes = $sedeModel->getAll();
        require_once "../app/views/empleado/seleccionarSede.php";
    }

    public function seleccionarProductos() {
        $productoModel = new Producto();
        $productos = $productoModel->getAll();
        require_once "../app/views/empleado/seleccionarProductos.php";
    }

    public function verPedido() {
        $pedidoModel = new Pedido();
        $pedidos = $pedidoModel->obtenerPedidosPendientes();
        require_once "../app/views/empleado/verPedido.php";
    }

    public function confirmarCompra() {
        $productosSeleccionados = $_POST['productos'];
        require_once "../app/views/empleado/factura.php";
    }

    public function facturacion() {
        $pedidoId = $_GET['pedido_id'];
        require_once "../app/views/empleado/facturacion.php";
    }
}
?>