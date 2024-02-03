<?php
        header("Content-Type: application/json");
        include_once("../class/class-clase.php");
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $_POST = json_decode(file_get_contents('php://input'),true);
                $clase = new Clase($_POST["seccion"], $_POST["nombreClase"], $_POST["banner"], $_POST["descripcion"], $_POST["aula"], $_POST["asignaciones"], $_POST["anuncios"]);
                echo json_encode($clase->guardarClase());
                break;
            case 'GET':
                if(isset($_GET['idClase'])){
                    echo json_encode(Clase::obtenerClase($_GET['idClase']));
                }else{
                    echo json_encode(Clase::obtenerClases());
                }
                break;
            case 'PUT':
                $_PUT = json_decode(file_get_contents('php://input'),true);
                if(isset($_PUT["idClaseAnunciar"])){
                    echo json_encode(Clase::publicarAnuncio($_PUT["idClaseAnunciar"],$_PUT["mensaje"], $_PUT["fecha"],$_PUT["hora"], $_PUT["comentarios"]));
                }elseif(isset($_PUT["idClaseComentar"])){
                    echo json_encode(Clase::publicarComentario($_PUT["idClaseComentar"], $_PUT["idAnuncio"], $_PUT["usuario"], $_PUT["mensaje"], $_PUT["fecha"], $_PUT["hora"]));
                }elseif(isset($_PUT["idClaseAsignar"])){
                    echo json_encode(Clase::registrarAsignacion($_PUT["idClaseAsignar"], $_PUT["titulo"], $_PUT["fecha"], $_PUT["hora"], $_PUT["puntos"]));
                }
                break;
        }

?>