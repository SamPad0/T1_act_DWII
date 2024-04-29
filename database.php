<?php

$host = "localhost";
$usuario = "root";
$password = "";
$basededatos = "api";

function connect_to_database() {
    global $host, $usuario, $password, $basededatos;
    $conexion = new mysqli($host, $usuario, $password, $basededatos);
    if ($conexion->connect_error) {
        die("Conexión no establecida: " . $conexion->connect_error);
    }
    return $conexion;
}

?>