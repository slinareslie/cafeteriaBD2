<?php
function getConnection() {
    $host = 'localhost';
    $dbname = 'CafeteriaDB';
    $username = 'root';
    $password = '';

    try {
        return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
?>