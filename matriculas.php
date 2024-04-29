<?php

require_once 'database.php';

// Funciones CRUD para la tabla Matrículas
function consultaMatriculas($conexion, $id) {
    $sql = ($id == null) ? "SELECT * FROM Matriculas" : "SELECT * FROM Matriculas WHERE id=$id";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('mensaje' => 'Error al realizar la consulta de Matrículas'));
    }
}

function insertarMatricula($conexion) {
    $dato = json_decode(file_get_contents("php://input"), true);
    $estudiante_id = $dato["estudiante_id"];
    $curso_id = $dato["curso_id"];
    $calificacion = $dato["calificacion"];

    $sql = "INSERT INTO Matriculas (estudiante_id, curso_id, calificacion) VALUES ($estudiante_id, $curso_id, '$calificacion')";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $id_insertado = $conexion->insert_id;
        $dato['id'] = $id_insertado;
        echo json_encode($dato);
    } else {
        echo json_encode(array('mensaje' => 'Error al crear matrícula'));
    }
}

function actualizarMatricula($conexion, $id) {
    $dato = json_decode(file_get_contents('php://input'), true);
    $calificacion = $dato['calificacion'];

    $sql = "UPDATE Matriculas SET calificacion = '$calificacion' WHERE id = $id";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo json_encode(array('mensaje' => 'Matrícula actualizada'));
    } else {
        echo json_encode(array('mensaje' => 'Error al actualizar matrícula'));
    }
}

function borrarMatricula($conexion, $id) {
    if ($id !== null) {
        $sql = "DELETE FROM Matriculas WHERE id = $id";
        $resultado = $conexion->query($sql);

        if ($resultado) {
            echo json_encode(array('mensaje' => 'Matrícula eliminada'));
        } else {
            echo json_encode(array('mensaje' => 'Error al eliminar matrícula'));
        }
    } else {
        echo json_encode(array('mensaje' => 'Debe especificar un ID para borrar'));
    }
}

?>
