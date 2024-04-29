<?php

require_once 'functions.php';

header("Content-type: application/json");

$conexion = connect_to_database();

$metodo = $_SERVER['REQUEST_METHOD'] ?? '';

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

$buscarId = explode('/', $path);

$id = ($path !== '/' ? end($buscarId) : null);

switch ($metodo) {
    case 'GET':
        if (strpos($path, '/estudiantes') === 0) {
            consultaEstudiantes($conexion, $id);
        } elseif (strpos($path, '/profesores') === 0) {
            consultaProfesores($conexion, $id);
        } elseif (strpos($path, '/cursos') === 0) {
            consultaCursos($conexion, $id);
        } elseif (strpos($path, '/matriculas') === 0) {
            consultaMatriculas($conexion, $id);
        } else {
            echo json_encode(array('mensaje' => 'Ruta no válida'));
        }
        break;
    case 'POST':
        if (strpos($path, '/estudiantes') === 0) {
            insertarEstudiante($conexion);
        } elseif (strpos($path, '/profesores') === 0) {
            insertarProfesor($conexion);
        } elseif (strpos($path, '/cursos') === 0) {
            insertarCurso($conexion);
        } elseif (strpos($path, '/matriculas') === 0) {
            insertarMatricula($conexion);
        } else {
            echo json_encode(array('mensaje' => 'Ruta no válida'));
        }
        break;
    case 'PUT':
        if (strpos($path, '/estudiantes') === 0) {
            actualizarEstudiante($conexion, $id);
        } elseif (strpos($path, '/profesores') === 0) {
            actualizarProfesor($conexion, $id);
        } elseif (strpos($path, '/cursos') === 0) {
            actualizarCurso($conexion, $id);
        } elseif (strpos($path, '/matriculas') === 0) {
            actualizarMatricula($conexion, $id);
        } else {
            echo json_encode(array('mensaje' => 'Ruta no válida'));
        }
        break;
    case 'DELETE':
        if (strpos($path, '/estudiantes') === 0) {
            borrarEstudiante($conexion, $id);
        } elseif (strpos($path, '/profesores') === 0) {
            borrarProfesor($conexion, $id);
        } elseif (strpos($path, '/cursos') === 0) {
            borrarCurso($conexion, $id);
        } elseif (strpos($path, '/matriculas') === 0) {
            borrarMatricula($conexion, $id);
        } else {
            echo json_encode(array('mensaje' => 'Ruta no válida'));
        }
        break;
    default:
        echo json_encode(array('mensaje' => 'Método no permitido'));
        break;
}

?>
