<?php
require_once "../app/models/Empleado.php";

class EmpleadoController {
    public function verPedidoMesa($numero_mesa) {
        $pedido = Empleado::obtenerPedidoMesa($numero_mesa);
        require_once "../app/views/empleado/pedido_mesa.php";
    }

    public function procesarPago($pedido_id) {
        $pago = Empleado::obtenerPago($pedido_id);
        require_once "../app/views/empleado/factura.php";
    }
}
?>