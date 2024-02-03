<?php
    header("Content-Type: application/json");
    include_once("../class/class-instructor.php");
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $_POST = json_decode(file_get_contents('php://input'),true);
            $instructor = new Instructor($_POST["usuario"], $_POST["password"], $_POST["nombre"], $_POST["imagen"], $_POST["clases"]);
            echo json_encode($instructor->guardarInstructor());
            break;
        case 'GET':
            if(isset($_GET['idInstructor'])){
                echo json_encode(Instructor::obtenerInstructor($_GET['idInstructor']));
            }else{
                echo json_encode(Instructor::obtenerInstructores());
            }
            break;
        case 'PUT':
            $_PUT = json_decode(file_get_contents('php://input'),true);
            echo json_encode(Instructor::guardarClaseInstructor($_PUT["idClase"], $_PUT["nombreClase"], $_PUT["idInstructor"]));
            break;
    }

?>