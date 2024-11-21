<?php
require_once "../app/models/Cliente.php";

class ClienteController {
    public function registrar() {
        $clienteId = Cliente::agregarCliente($nombre, $telefono, $direccion);
        redirect("/public/cliente/confirmacion.php");
    }
}
?>