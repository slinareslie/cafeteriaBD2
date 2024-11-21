<?php
require_once "../app/models/Pedido.php";

class PedidoController {
    public function verCarro($pedido_id) {
        $detalles = Pedido::obtenerDetalles($pedido_id);
        require_once "../app/views/pedido/carro.php";
    }

    public function verPedidosPendientes() {
        $pedidos = Pedido::obtenerPedidosPendientes();
        require_once "../app/views/pedido/list.php";
    }
}
?>