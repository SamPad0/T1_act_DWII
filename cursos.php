<?php

require_once 'database.php';

// Funciones CRUD para la tabla Cursos
function consultaCursos($conexion, $id) {
    $sql = ($id == null) ? "SELECT * FROM Cursos" : "SELECT * FROM Cursos WHERE id=$id";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('mensaje' => 'Error al realizar la consulta de Cursos'));
    }
}

function insertarCurso($conexion) {
    $dato = json_decode(file_get_contents("php://input"), true);
    $nombre_curso = $dato["nombre_curso"];
    $departamento = $dato["departamento"];
    $instructor_id = $dato["instructor_id"];

    $sql = "INSERT INTO Cursos (nombre_curso, departamento, instructor_id) VALUES ('$nombre_curso', '$departamento', $instructor_id)";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $id_insertado = $conexion->insert_id;
        $dato['id'] = $id_insertado;
        echo json_encode($dato);
    } else {
        echo json_encode(array('mensaje' => 'Error al crear curso'));
    }
}

function actualizarCurso($conexion, $id) {
    $dato = json_decode(file_get_contents('php://input'), true);
    $nombre_curso = $dato['nombre_curso'];

    $sql = "UPDATE Cursos SET nombre_curso = '$nombre_curso' WHERE id = $id";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo json_encode(array('mensaje' => 'Curso actualizado'));
    } else {
        echo json_encode(array('mensaje' => 'Error al actualizar curso'));
    }
}

function borrarCurso($conexion, $id) {
    if ($id !== null) {
        $sql = "DELETE FROM Cursos WHERE id = $id";
        $resultado = $conexion->query($sql);

        if ($resultado) {
            echo json_encode(array('mensaje' => 'Curso eliminado'));
        } else {
            echo json_encode(array('mensaje' => 'Error al eliminar curso'));
        }
    } else {
        echo json_encode(array('mensaje' => 'Debe especificar un ID para borrar'));
    }
}

?>
