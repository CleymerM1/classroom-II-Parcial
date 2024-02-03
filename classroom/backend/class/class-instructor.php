<?php
    class Instructor{
        private $id;
        private $usuario;
        private $password;
        private $nombre;
        private $imagen;
        private $clases;

        public function __construct($usuario, $password, $nombre, $imagen, $clases){
            $this->id = $this->generarId();
            $this->usuario =$usuario;
            $this->password =$password;
            $this->nombre =$nombre;
            $this->imagen =$imagen;
            $this->clases =$clases; 
        }

        public function guardarInstructor(){
                $instructor = array (
                        "id" => $this->id,
                        "usuario" => $this->usuario,
                        "password" => $this->password,
                        "nombre" => $this->nombre,
                        "imagen" => $this->imagen,
                        "clases" => $this->clases 
                );
                $instructores = json_decode(file_get_contents("../data/instructores.json"),true);
                $archivo = fopen("../data/instructores.json","w");
                $instructores[] = $instructor;
                fwrite($archivo, json_encode($instructores));
                fclose($archivo);
                return true;


        }

        public function generarId(){
            $instructores = json_decode(file_get_contents("../data/instructores.json"),true);
            if(sizeof($instructores) == 0){
                    return 1;
            }else{
                    $id = $instructores[sizeof($instructores)-1]["id"] + 1;
                    return $id;
            }
        }

        public function obtenerInstructores(){
            $instructores = json_decode(file_get_contents("../data/instructores.json"),true);
            return $instructores;
        }

        function guardarClaseInstructor($idClase, $nombreClase, $idInstructor){
                $instructores = json_decode(file_get_contents("../data/instructores.json"),true);
                $clase = array (
                        "id" => $idClase,
                        "nombreClase" => $nombreClase,
                        "banner" => ""
                );

                for ($i=0; $i < sizeof($instructores) ;  $i++) { 
                        if($instructores[$i]["id"] == $idInstructor){
                                $instructores[$i]["clases"][] = $clase;
                                $archivo = fopen("../data/instructores.json","w");
                                fwrite($archivo, json_encode($instructores));
                                fclose($archivo);
                                return true;
                        }
                }
        }

        public function obtenerInstructor($idInstructor){
            $instructores = json_decode(file_get_contents("../data/instructores.json"),true);
            for ($i=0; $i < $instructores ; $i++) { 
                if($instructores[$i]["id"] == $idInstructor){
                    return $instructores[$i];
                }
            }
            return null;
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
         * Get the value of usuario
         */ 
        public function getUsuario()
        {
                return $this->usuario;
        }

        /**
         * Set the value of usuario
         *
         * @return  self
         */ 
        public function setUsuario($usuario)
        {
                $this->usuario = $usuario;

                return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

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