<?php
class Pedido {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function crearPedido($sede_id, $mesa_id, $empleado_id, $detallePedido) {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("INSERT INTO Pedidos (sede_id, mesa_id, empleado_id, fecha_pedido) VALUES (:sede_id, :mesa_id, :empleado_id, NOW())");
            $stmt->bindParam(':sede_id', $sede_id);
            $stmt->bindParam(':mesa_id', $mesa_id);
            $stmt->bindParam(':empleado_id', $empleado_id);
            $stmt->execute();
            $pedidoId = $this->conn->lastInsertId();

            foreach ($detallePedido as $detalle) {
                $stmt = $this->conn->prepare("INSERT INTO Detalles_Pedido (pedido_id, producto_id, cantidad, precio, total) VALUES (:pedido_id, :producto_id, :cantidad, :precio, :total)");
                $stmt->bindParam(':pedido_id', $pedidoId);
                $stmt->bindParam(':producto_id', $detalle['producto_id']);
                $stmt->bindParam(':cantidad', $detalle['cantidad']);
                $stmt->bindParam(':precio', $detalle['precio']);
                $stmt->bindParam(':total', $detalle['total']);
                $stmt->execute();
            }

            $this->conn->commit();
            return $pedidoId;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

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