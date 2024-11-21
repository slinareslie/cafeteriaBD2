<?php
class Producto {
    public static function obtenerCategorias() {
        $db = getConnection();
        $query = "SELECT DISTINCT categoria FROM Productos";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerProductosConFiltroYOrden($buscar, $ordenar, $categoria = null) {
        try {
            $db = getConnection();

            $ordenamientosPermitidos = ['p.nombre_producto', 'hp.precio ASC', 'hp.precio DESC'];
            if (!in_array($ordenar, $ordenamientosPermitidos)) {
                $ordenar = 'p.nombre_producto';
            }

            $query = "SELECT p.producto_id, p.nombre_producto, p.descripcion, p.categoria, hp.precio
                      FROM Productos p
                      JOIN Historial_Precios hp ON p.producto_id = hp.producto_id
                      WHERE p.nombre_producto LIKE :buscar
                      AND (hp.fecha_fin IS NULL OR hp.fecha_fin > CURDATE())";

            if ($categoria) {
                $query .= " AND p.categoria = :categoria";
            }

            $query .= " ORDER BY $ordenar";

            $stmt = $db->prepare($query);

            // Asociar parámetros
            $params = [':buscar' => "%$buscar%"];
            if ($categoria) {
                $params[':categoria'] = $categoria;
            }

            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log('Error en la consulta: ' . $e->getMessage());
            return [];
        }
    }
}

?>