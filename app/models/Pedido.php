<?php
class Pedido {
    public static function obtenerDetalles($pedido_id) {
        $db = (new Database())->connect();
        $query = $db->prepare("SELECT p.nombre_producto, dp.cantidad, dp.precio_unitario
                               FROM Detalle_Pedido dp
                               JOIN Productos p ON dp.producto_id = p.producto_id
                               WHERE dp.pedido_id = :pedido_id");
        $query->execute([':pedido_id' => $pedido_id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPedidosPendientes() {
        $db = (new Database())->connect();
        $query = $db->prepare("SELECT p.pedido_id, p.fecha_pedido, p.total, p.estado
                               FROM Pedidos p
                               WHERE p.estado = 'pendiente'");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>