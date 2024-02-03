<?php
        header("Content-Type: application/json");
        include_once("../class/class-participante.php");
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                
                $_POST = json_decode(file_get_contents('php://input'),true);
                $participante = new Participante($_POST["nombre"], $_POST["imagen"], $_POST["clases"]);
                echo json_encode($participante->guardarEstudiante());
                
                break;
            case 'GET':
                if(isset($_GET['idParticipante'])){
                    echo json_encode(Participante::obtenerParticipante($_GET['idParticipante']));
                }else{
                    echo json_encode(Participante::obtenerParticipantes());
                }
                break;
            case 'PUT':
                
            
                break;
        }

?>