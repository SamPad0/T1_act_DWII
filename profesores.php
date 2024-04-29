<?php

require_once 'database.php';

// Funciones CRUD para la tabla Profesores
function consultaProfesores($conexion, $id) {
    $sql = ($id == null) ? "SELECT * FROM Profesores" : "SELECT * FROM Profesores WHERE id=$id";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('mensaje' => 'Error al realizar la consulta de Profesores'));
    }
}

function insertarProfesor($conexion) {
    $dato = json_decode(file_get_contents("php://input"), true);
    $nombre = $dato["nombre"];
    $correo = $dato["correo_electronico"];
    $numero_oficina = $dato["numero_oficina"];

    $sql = "INSERT INTO Profesores (nombre, correo_electronico, numero_oficina) VALUES ('$nombre', '$correo', '$numero_oficina')";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $id_insertado = $conexion->insert_id;
        $dato['id'] = $id_insertado;
        echo json_encode($dato);
    } else {
        echo json_encode(array('mensaje' => 'Error al crear profesor'));
    }
}

function actualizarProfesor($conexion, $id) {
    $dato = json_decode(file_get_contents('php://input'), true);
    $nombre = $dato['nombre'];

    $sql = "UPDATE Profesores SET nombre = '$nombre' WHERE id = $id";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo json_encode(array('mensaje' => 'Profesor actualizado'));
    } else {
        echo json_encode(array('mensaje' => 'Error al actualizar profesor'));
    }
}

function borrarProfesor($conexion, $id) {
    if ($id !== null) {
        $sql = "DELETE FROM Profesores WHERE id = $id";
        $resultado = $conexion->query($sql);

        if ($resultado) {
            echo json_encode(array('mensaje' => 'Profesor eliminado'));
        } else {
            echo json_encode(array('mensaje' => 'Error al eliminar profesor'));
        }
    } else {
        echo json_encode(array('mensaje' => 'Debe especificar un ID para borrar'));
    }
}

?>
