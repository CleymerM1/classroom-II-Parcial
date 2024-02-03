<?php
    class Clase{
        private $id;
        private $seccion;
        private $nombreClase;
        private $banner;
        private $descripcion;
        private $aula;
        private $asignaciones;
        private $anuncios;

        public function __construct($seccion, $nombreClase, $banner, $descripcion, $aula, $asignaciones, $anuncios){
            $this->id = $this->generarId();
            $this->seccion = $seccion;
            $this->nombreClase = $nombreClase;
            $this->banner = $banner;
            $this->descripcion = $descripcion;
            $this->aula = $aula;
            $this->asignaciones = $asignaciones;
            $this->anuncios = $anuncios;
        }

        public function guardarClase(){
                $clase = array(
                        "id" => $this->id,
                        "seccion" => $this->seccion,
                        "nombreClase" => $this->nombreClase,
                        "banner" => $this->banner,
                        "descripcion" => $this->descripcion,
                        "aula" => $this->aula,
                        "asignaciones" => $this->asignaciones,
                        "anuncios" => $this->anuncios
                );
                $clases = json_decode(file_get_contents("../data/clases.json"),true); 
                $clases[] = $clase;
                $archivo = fopen("../data/clases.json","w");
                fwrite($archivo, json_encode($clases));
                fclose($archivo);
                return $this->id;
        }

        public function registrarAsignacion($idClase, $titulo, $fecha, $hora, $puntos){
                $id = self::asignarIdAsignacion($idClase);
                $asignacion = array(
                        "id" => $id,
                        "titulo" => $titulo,
                        "fecha" => $fecha,
                        "hora" => $hora,
                        "puntos" => $puntos
                );
                $clases = json_decode(file_get_contents("../data/clases.json"),true); 
                for ($i=0; $i < sizeof($clases) ; $i++) { 
                        if($clases[$i]["id"] == $idClase){
                                $clases[$i]["asignaciones"][] = $asignacion;
                                $archivo = fopen("../data/clases.json","w");
                                fwrite($archivo, json_encode($clases));
                                fclose($archivo);
                                return true;

                        }
                }
                return false;

                
        }
        public function asignarIdAsignacion($idClase){
                $clases = json_decode(file_get_contents("../data/clases.json"),true); 
                for ($i=0; $i < sizeof($clases) ; $i++) { 
                        if($clases[$i]["id"] == $idClase){
                                $asignaciones = $clases[$i]["asignaciones"];
                                if(sizeof($asignaciones) == 0){
                                        return 1;
                                }else{
                                        return $asignaciones[sizeof($asignaciones)-1]["id"] + 1;
                                }
                        }
                }
                return 1;
        }

        public function generarId(){
            $clases = json_decode(file_get_contents("../data/clases.json"),true);
            if(sizeof($clases) == 0){
                    return 1;
            }else{
                    $id = $clases[sizeof($clases)-1]["id"] + 1;
                    return $id;
            }
        }

        public function obtenerClases(){
            $clases = json_decode(file_get_contents("../data/clases.json"),true);
            return $clases;
        }

        public function obtenerClase($idClase){
            $clases = json_decode(file_get_contents("../data/clases.json"),true);
            for ($i=0; $i < sizeof($clases) ; $i++) { 
                if($clases[$i]["id"] == $idClase){
                    return $clases[$i];
                }
            }
            return null;
        }

        public function publicarAnuncio($idClase, $mensaje, $fecha, $hora, $comentarios){
                $clases = json_decode(file_get_contents("../data/clases.json"),true);
                for ($i=0; $i < sizeof($clases) ; $i++) { 
                        if($clases[$i]["id"] == $idClase){
                               
                                $id = self::generarIdAnuncio($clases[$i]["anuncios"]);

                                $anuncio = array (
                                        "id" =>$id,
                                        "mensaje" => $mensaje,
                                        "fecha" => $fecha,
                                        "hora" => $hora,
                                        "comentarios" => $comentarios
                                );
                                $clases[$i]["anuncios"][]= $anuncio;
                                $archivo = fopen("../data/clases.json","w");
                                fwrite($archivo, json_encode($clases));
                                fclose($archivo);
                                return true;
                        }
                }
                return false;
        }

        public function publicarComentario($idClase, $idAnuncio, $usuario, $mensaje, $fecha, $hora){
                $clases = json_decode(file_get_contents("../data/clases.json"),true);
                for ($i=0; $i < sizeof($clases) ; $i++) { 
                        if($clases[$i]["id"] == $idClase){

                                for ($j=0; $j < sizeof($clases[$i]["anuncios"]) ; $j++) { 
                                        if($clases[$i]["anuncios"][$j]["id"] == $idAnuncio){
                                                $comentario = array (
                                                        "usuario" => $usuario,
                                                        "mensaje" => $mensaje,
                                                        "fecha" => $fecha,
                                                        "hora" => $hora
                                                );
                                                $clases[$i]["anuncios"][$j]["comentarios"][]= $comentario;
                                                $archivo = fopen("../data/clases.json","w");
                                                fwrite($archivo, json_encode($clases));
                                                fclose($archivo);
                                                return true;
                                        }
                                }
                                return false;
                        }
                }
                return false;        
        }



        public function generarIdAnuncio($anuncios){

                if(sizeof($anuncios) == 0){
                        return 1;
                }else{
                        $id = $anuncios[sizeof($anuncios)-1]["id"] + 1;
                        return $id;
                }
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of seccion
         */ 
        public function getSeccion()
        {
                return $this->seccion;
        }

        /**
         * Set the value of seccion
         *
         * @return  self
         */ 
        public function setSeccion($seccion)
        {
                $this->seccion = $seccion;

                return $this;
        }

        /**
         * Get the value of nombreClase
         */ 
        public function getNombreClase()
        {
                return $this->nombreClase;
        }

        /**
         * Set the value of nombreClase
         *
         * @return  self
         */ 
        public function setNombreClase($nombreClase)
        {
                $this->nombreClase = $nombreClase;

                return $this;
        }

        /**
         * Get the value of banner
         */ 
        public function getBanner()
        {
                return $this->banner;
        }

        /**
         * Set the value of banner
         *
         * @return  self
         */ 
        public function setBanner($banner)
        {
                $this->banner = $banner;

                return $this;
        }

        /**
         * Get the value of descripcion
         */ 
        public function getDescripcion()
        {
                return $this->descripcion;
        }

        /**
         * Set the value of descripcion
         *
         * @return  self
         */ 
        public function setDescripcion($descripcion)
        {
                $this->descripcion = $descripcion;

                return $this;
        }

        /**
         * Get the value of aula
         */ 
        public function getAula()
        {
                return $this->aula;
        }

        /**
         * Set the value of aula
         *
         * @return  self
         */ 
        public function setAula($aula)
        {
                $this->aula = $aula;

                return $this;
        }

        /**
         * Get the value of asignaciones
         */ 
        public function getAsignaciones()
        {
                return $this->asignaciones;
        }

        /**
         * Set the value of asignaciones
         *
         * @return  self
         */ 
        public function setAsignaciones($asignaciones)
        {
                $this->asignaciones = $asignaciones;

                return $this;
        }

        /**
         * Get the value of anuncios
         */ 
        public function getAnuncios()
        {
                return $this->anuncios;
        }

        /**
         * Set the value of anuncios
         *
         * @return  self
         */ 
        public function setAnuncios($anuncios)
        {
                $this->anuncios = $anuncios;

                return $this;
        }
    }

?>