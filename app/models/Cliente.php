<?php
class Cliente {
    public static function agregarCliente($nombre, $telefono, $direccion) {
        $db = getConnection();
        $query = $db->prepare("INSERT INTO Clientes (nombre, telefono, direccion) 
                               VALUES (:nombre, :telefono, :direccion)");
        $query->execute([
            ':nombre' => $nombre,
            ':telefono' => $telefono,
            ':direccion' => $direccion
        ]);
        return $db->lastInsertId();
    }
}
?>