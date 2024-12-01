<?php
require_once "../app/models/Producto.php";

class ProductoController {
    public function listar() {
        $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
        $ordenar = isset($_GET['ordenar']) ? $_GET['ordenar'] : 'p.nombre_producto';
        $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;

        $categorias = Producto::obtenerCategorias();
        $productos = Producto::obtenerProductosConFiltroYOrden($buscar, $ordenar, $categoria);

        require_once "../app/views/producto/list.php";
    }
    

    public function agregarCarrito() {
        session_start();
        $producto_id = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];

        if (!is_numeric($cantidad) || $cantidad <= 0) {
            $_SESSION['error'] = "Cantidad inválida";
            header("Location: /public/index.php?controller=producto&action=listar");
            exit;
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id] += $cantidad;
        } else {
            $_SESSION['carrito'][$producto_id] = $cantidad;
        }

        header("Location: /public/index.php?controller=producto&action=listar");
        exit;
    }
}