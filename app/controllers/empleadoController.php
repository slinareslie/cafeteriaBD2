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

    $sede_id = $_POST['sede_id'];
    $sedeModel = new Sede();
    $mesas = $sedeModel->obtenerMesasPorSede($sede_id);
    $empleados = $sedeModel->obtenerEmpleadosPorSede($sede_id);

    require_once "../app/views/empleado/seleccionarProductos.php";
}

    public function verPedido() {
        $pedidoModel = new Pedido();
        $pedidos = $pedidoModel->obtenerPedidosPendientes();
        require_once "../app/views/empleado/verPedido.php";
    }

    public function confirmarCompra() {
        $sede_id = $_POST['sede_id'];
        $mesa_id = $_POST['mesa'];
        $empleado_id = $_POST['empleado'];
        $productosSeleccionados = $_POST['productos'];
        $cantidad = $_POST['cantidad'];
        if (empty($sede_id) || empty($mesa_id) || empty($empleado_id) || empty($productosSeleccionados)) {
            $_SESSION['error'] = "Debe seleccionar una mesa, un empleado y al menos un producto.";
            header("Location: index.php?controller=empleado&action=seleccionarProductos");
            exit;
        }

        $detallePedido = [];
        foreach ($productosSeleccionados as $producto_id) {
            $productoModel = new Producto();
            $producto = $productoModel->getById($producto_id);

            $detallePedido[] = [
                'producto_id' => $producto['producto_id'],
                'nombre_producto' => $producto['nombre_producto'],
                'cantidad' => $cantidad[$producto_id],
                'precio' => $producto['precio'],
                'total' => $cantidad[$producto_id] * $producto['precio']
            ];
        }

        $pedidoModel = new Pedido();
        $pedidoId = $pedidoModel->crearPedido($sede_id, $mesa_id, $empleado_id, $detallePedido);

        if ($pedidoId) {
            $_SESSION['success'] = "Pedido confirmado correctamente. ID de pedido: " . $pedidoId;
            header("Location: index.php?controller=empleado&action=verPedido");
            exit;
        } else {
            $_SESSION['error'] = "Hubo un error al confirmar el pedido.";
            header("Location: index.php?controller=empleado&action=seleccionarProductos");
            exit;
        }
    }

    public function factura() {
        require_once "../app/views/empleado/factura.php";
    }

    public function verReporte() {
        require_once "../app/views/empleado/reporte.php";
    }
    public function pedidoRealizado(){
        require_once "../app/views/empleado/pedidoRealizado.php";
    }
}
?>