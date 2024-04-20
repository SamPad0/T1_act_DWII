<?php

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
    case 'GET':
        consultaProfesores($conexion, $id);
        break;
    case 'POST':
        insertarProfesor($conexion);
        break;
    case 'PUT':
        actualizarProfesor($conexion, $id);
        break;
    case 'DELETE':
        borrarProfesor($conexion, $id);
        break;

    // Acciones CRUD para la tabla Cursos
    case 'GET':
        consultaCursos($conexion, $id);
        break;
    case 'POST':
        insertarCurso($conexion);
        break;
    case 'PUT':
        actualizarCurso($conexion, $id);
        break;
    case 'DELETE':
        borrarCurso($conexion, $id);
        break;

    // Acciones CRUD para la tabla Matriculas
    case 'GET':
        consultaMatriculas($conexion, $id);
        break;
    case 'POST':
        insertarMatricula($conexion);
        break;
    case 'PUT':
        actualizarMatricula($conexion, $id);
        break;
    case 'DELETE':
        borrarMatricula($conexion, $id);
        break;

    default:
        echo json_encode(array('mensaje' => 'Método no permitido'));
        break;
}

// Funciones CRUD para la tabla Estudiantes
function consultaEstudiantes($conexion, $id)
{
    $sql = ($id==null)?"SELECT * FROM Estudiantes": "SELECT * FROM Estudiantes WHERE id=$id";
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

    $sql = "UPDATE Estudiantes SET nombre = '$nombre' WHERE id = $id";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo json_encode(array('mensaje' => 'Estudiante actualizado'));
    } else {
        echo json_encode(array('mensaje' => 'Error al actualizar estudiante'));
    }
}

function borrarEstudiante($conexion, $id)
{
    if ($id !== null) {
        $sql = "DELETE FROM Estudiantes WHERE id = $id";
        $resultado = $conexion->query($sql);

        if ($resultado) {
            echo json_encode(array('mensaje' => 'Estudiante eliminado'));
        } else {
            echo json_encode(array('mensaje' => 'Error al eliminar estudiante'));
        }
    } else {
        echo json_encode(array('mensaje' => 'Debe especificar un ID para borrar'));
    }
}

// Agrega las funciones CRUD para las demás tablas (Profesores, Cursos y Matriculas) aquí

?>
