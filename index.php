<?php

// Integrantes: Samuel, MaríaCamila, Ever, Elkin, Andrés


$host = "localhost";
$usuario = "root";
$password = "";
$basededatos = "api";

$conexion = new mysqli($host, $usuario, $password, $basededatos);

if ($conexion->connect_error) {
    die("Conexión no establecida: " . $conexion->connect_error);
}

header("Content-type: application/json");

// Verificar si la solicitud es POST, GET, PUT o DELETE
$metodo = $_SERVER['REQUEST_METHOD'] ?? '';

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

$buscarId = explode('/', $path);

$id = ($path !== '/' ? end($buscarId) : null);

switch ($metodo) {
    // Acciones CRUD para la tabla Estudiantes
    case 'GET':
        consultaEstudiantes($conexion, $id);
        break;
    case 'POST':
        insertarEstudiante($conexion);
        break;
    case 'PUT':
        actualizarEstudiante($conexion, $id);
        break;
    case 'DELETE':
        borrarEstudiante($conexion, $id);
        break;

    // Acciones CRUD para la tabla Profesores
    case 'GET_PROFESORES':
        consultaProfesores($conexion, $id);
        break;
    case 'POST_PROFESORES':
        insertarProfesor($conexion);
        break;
    case 'PUT_PROFESORES':
        actualizarProfesor($conexion, $id);
        break;
    case 'DELETE_PROFESORES':
        borrarProfesor($conexion, $id);
        break;

    // Acciones CRUD para la tabla Cursos
    case 'GET_CURSOS':
        consultaCursos($conexion, $id);
        break;
    case 'POST_CURSOS':
        insertarCurso($conexion);
        break;
    case 'PUT_CURSOS':
        actualizarCurso($conexion, $id);
        break;
    case 'DELETE_CURSOS':
        borrarCurso($conexion, $id);
        break;

    // Acciones CRUD para la tabla Matriculas
    case 'GET_MATRICULAS':
        consultaMatriculas($conexion, $id);
        break;
    case 'POST_MATRICULAS':
        insertarMatricula($conexion);
        break;
    case 'PUT_MATRICULAS':
        actualizarMatricula($conexion, $id);
        break;
    case 'DELETE_MATRICULAS':
        borrarMatricula($conexion, $id);
        break;

    default:
        echo json_encode(array('mensaje' => 'Método no permitido'));
        break;
}

// Funciones CRUD para la tabla Estudiantes
function consultaEstudiantes($conexion, $id)
{
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

function insertarEstudiante($conexion)
{
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

function actualizarEstudiante($conexion, $id)
{
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

function borrarEstudiante($conexion, $id)
{
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

// Funciones CRUD para la tabla Profesores
function consultaProfesores($conexion, $id)
{
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

function insertarProfesor($conexion)
{
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

function actualizarProfesor($conexion, $id)
{
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

function borrarProfesor($conexion, $id)
{
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

// Funciones CRUD para la tabla Cursos
function consultaCursos($conexion, $id)
{
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

function insertarCurso($conexion)
{
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

function actualizarCurso($conexion, $id)
{
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

function borrarCurso($conexion, $id)
{
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

// Funciones CRUD para la tabla Matriculas
function consultaMatriculas($conexion, $id)
{
    $sql = ($id == null) ? "SELECT * FROM Matriculas" : "SELECT * FROM Matriculas WHERE id=$id";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    } else {
        echo json_encode(array('mensaje' => 'Error al realizar la consulta de Matriculas'));
    }
}

function insertarMatricula($conexion)
{
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

function actualizarMatricula($conexion, $id)
{
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

function borrarMatricula($conexion, $id)
{
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
