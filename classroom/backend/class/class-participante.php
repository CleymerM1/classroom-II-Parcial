<?php
    class Participante{
        private $id;
        private $nombre;
        private $imagen;
        private $clases;
        
        public function __construct($nombre, $imagen, $clases){
            $this->id = $this->generarId();
            $this->nombre = $nombre;
            $this->imagen = $imagen;
            $this->clases = $clases;
        }

        public function guardarEstudiante(){
                $participante = array (
                        "id" => $this->id,
                        "nombre" => $this->nombre,
                        "imagen" => $this->imagen,
                        "clases" => $this->clases
                );
                
                $participantes = json_decode(file_get_contents("../data/participantes.json"),true);
                if($this->existeEstudiante() and $this->estaMAtriculado($this->clases[0]["id"]) ){
                        return false;
                }
                if($this->existeEstudiante() and !$this->estaMAtriculado($this->clases[0]["id"])){
                        for ($j=0; $j < sizeof($participantes) ; $j++) { 
                                if($participantes[$j]["nombre"] == $this->nombre){
                                        $participante[$j]["nombre"]["clases"][] = $this->clases[0];
                                        $archivo = fopen("../data/participantes.json","w");
                                        fwrite($archivo, json_encode($participantes));
                                        fclose($archivo);
                                        return true;
                                }
                        }
                        
                }

                
                if(!$this->existeEstudiante()){
                        // validar que el estudiante no existe
                        $participantes[] = $participante;
                        $archivo = fopen("../data/participantes.json","w");
                        fwrite($archivo, json_encode($participantes));
                        fclose($archivo);
                        return true;
                        // Validar que el estudiante no este matriculad
                }

                return false;
                       
        }

        public function obtenerIndice($idParticipante){
                $participantes = json_decode(file_get_contents("../data/participantes.json"),true);
                for ($i=0; $i < $participantes; $i++) { 
                        if($participantes[$i]["id"] == $idParticipante){
                                return $i;
                        }
                }
                return -1;
        }

        public function estaMAtriculado($idClase){
                $participantes = json_decode(file_get_contents("../data/participantes.json"),true);
                $indice = $this->obtenerParticipante($this->id);
                if($indice == -1){
                        return false;
                }
                for ($i=0; $i <  sizeof($participantes[$indice]["clases"]); $i++) { 
                        if($participantes[$indice]["clases"][$i]["id"] == $idClase){
                                return true;
                        }
                }
                return false;  
        }
        public function existeEstudiante(){
                $participantes = json_decode(file_get_contents("../data/participantes.json"),true);
                for ($i=0; $i <  sizeof($participantes); $i++) { 
                        if($participantes[$i]["nombre"] == $this->nombre){
                                return true;
                        }
                }
                return false;
        }

        public function generarId(){
            $participante = json_decode(file_get_contents("../data/participantes.json"),true);
            if(sizeof($participante) == 0){
                    return 1;
            }else{
                    $id = $participante[sizeof($participante)-1]["id"] + 1;
                    return $id;
            }
        }

        public function obtenerParticipante($idParticipante){
            $participante = json_decode(file_get_contents("../data/participantes.json"),true);
            for ($i=0; $i < $participante ; $i++) { 
                if($participante[$i]["id"] == $idParticipante){
                    return $participante[$i];
                }
            }
            return null;
        }

        public function obtenerParticipantes(){
            $participante = json_decode(file_get_contents("../data/participantes.json"),true);
            return $participante;
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
         * Get the value of nombre
         */ 
        public function getNombre()
        {
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Get the value of imagen
         */ 
        public function getImagen()
        {
                return $this->imagen;
        }

        /**
         * Set the value of imagen
         *
         * @return  self
         */ 
        public function setImagen($imagen)
        {
                $this->imagen = $imagen;

                return $this;
        }

        /**
         * Get the value of clases
         */ 
        public function getClases()
        {
                return $this->clases;
        }

        /**
         * Set the value of clases
         *
         * @return  self
         */ 
        public function setClases($clases)
        {
                $this->clases = $clases;

                return $this;
        }
    }


?>