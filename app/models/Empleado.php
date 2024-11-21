<?php
class Empleado {
    public static function obtenerPedidoMesa($numero_mesa) {
        $db = getConnection();
        $query = $db->prepare("SELECT p.pedido_id, p.total
                               FROM Pedidos p
                               JOIN Mesas m ON p.mesa_numero = m.numero_mesa
                               WHERE m.numero_mesa = :numero_mesa AND p.estado = 'pendiente'");
        $query->execute([':numero_mesa' => $numero_mesa]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function obtenerPago($pedido_id) {
        $db = getConnection();
        $query = $db->prepare("SELECT c.tipo_comprobante, c.total, p.metodo_pago
                               FROM Comprobante_Pago c
                               JOIN Pagos p ON c.pedido_id = p.pedido_id
                               WHERE c.pedido_id = :pedido_id");
        $query->execute([':pedido_id' => $pedido_id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
?>