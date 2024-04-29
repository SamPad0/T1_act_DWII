<?php

require_once 'database.php';

// Funciones CRUD para la tabla Estudiantes
function consultaEstudiantes($conexion, $id) {
    $sql = ($id == null) ? "SELECT * FROM Estudiantes" : "SELECT * FROM Estudiantes WHERE id=$id";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('mensaje' => 'Error al realizar la consulta de Estudiantes'));
    }
}

function insertarEstudiante($conexion) {
    $dato = json_decode(file_get_contents("php://input"), true);
    $nombre = $dato["nombre"];
    $correo = $dato["correo_electronico"];
    $telefono = $dato["telefono"];
    $carrera = $dato["carrera"];

    $sql = "INSERT INTO Estudiantes (nombre, correo_electronico, telefono, carrera) VALUES ('$nombre', '$correo', '$telefono', '$carrera')";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $id_insertado = $conexion->insert_id;
        $dato['id'] = $id_insertado;
        echo json_encode($dato);
    } else {
        echo json_encode(array('mensaje' => 'Error al crear estudiante'));
    }
}

function actualizarEstudiante($conexion, $id) {
    $dato = json_decode(file_get_contents('php://input'), true);
    $nombre = $dato['nombre'];
    $id_actualizar = $dato['id'];

    $sql = "UPDATE Estudiantes SET nombre = '$nombre' WHERE id = $id_actualizar";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo json_encode(array('mensaje' => 'Estudiante actualizado'));
    } else {
        echo json_encode(array('mensaje' => 'Error al actualizar estudiante'));
    }
}

function borrarEstudiante($conexion, $id) {
    $dato = json_decode(file_get_contents('php://input'), true);
    $id_borrar = $dato['id'];

    $sql = "DELETE FROM Estudiantes WHERE id = $id_borrar";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo json_encode(array('mensaje' => 'Estudiante eliminado'));
    } else {
        echo json_encode(array('mensaje' => 'Error al eliminar estudiante'));
    }
}

?>
