<?php       
    require_once "modelo/respuestas.class.php";
    class Usuarios{

        private int $id;
        private string $nombre;
        private string $apellido;
        private int $edad;
        private $foto;
        private string $tipoDoc;
        private string $rol;
        private $roles = array();
        private Conexion $bd;

        function __construct(){
            $this->bd = new Conexion();
            $this->roles = $this->obtenerRoles();
        }

        public function listarUsuarios(){
            $sql = "SELECT * FROM usuarios";
            $result = $this->bd->obtenerDatos($sql);
            foreach ($result as $key => $value) {
                $this->setId($value['Id']);
                $this->setNombre($value['Nombre']);
                $this->setApellido($value['Apellido']);
                $this->setEdad($value['Edad']);
                $this->setTipoDoc($value['TipoDocumento']);
                $this->setFoto($value['Foto']);
                $this->setRol($value['Rol']);
            }
            return $result;
        }

        public function guardarUsuario($json){
            $respuesta = new respuestas();
            $datos = json_decode($json,true);
            if(!isset($datos['Nombre']) || !isset($datos['Apellido'])  || !isset($datos['Edad'])  || 
            !isset($datos['TipoDocumento']) || !isset($datos['Rol'])){
                return $respuesta->error_400();
            }else{
                $this->setNombre($datos['Nombre']);
                $this->setApellido($datos['Apellido']);
                $this->setEdad($datos['Edad']);
                $this->setTipoDoc($datos['TipoDocumento']);
                if(isset($datos['Foto'])){
                    $this->setFoto($datos['Foto']);
                }else{
                    $this->setFoto("");
                }
                $this->setRol($datos['Rol']);
                $sql = "INSERT INTO usuarios (nombre,apellido,edad,tipoDocumento,foto,rol) VALUES (:nombre,:apellido,:edad,:tipoDoc,:foto,:rol)";
                $resp = $this->bd->insercion($sql,array('nombre'=>$this->getNombre(),'apellido'=>$this->getApellido(),'edad'=>$this->getEdad(),'tipoDoc'=>$this->getTipoDoc(),'foto'=>$this->getFoto(),'rol'=>$this->getRol()));
                if(isset($resp['result']['error_msg'])){
                    return $resp;
                }else{
                    return array("id"=>$resp);
                }

            }
        }

        public function modificarUsuario($json){
            $respuesta = new respuestas();
            $datos = json_decode($json,true);
            if(!isset($datos['Id'])){
                return $respuesta->error_400(" -> FALTAN PARÁMETROS");
            }else{
                $this->setId($datos['Id']);
                if(isset($datos['Nombre'])){$this->setNombre($datos['Nombre']);}
                if(isset($datos['Apellido'])){$this->setApellido($datos['Apellido']);}
                if(isset($datos['Edad'])){$this->setEdad($datos['Edad']);}
                if(isset($datos['TipoDocumento'])){$this->setTipoDoc($datos['TipoDocumento']);};               
                if(isset($datos['Foto'])){
                    $this->setFoto($datos['Foto']);
                }else{
                    $this->setFoto("");
                }
                $this->setRol($datos['Rol']);
                $sql = "UPDATE `usuarios` SET `nombre` = :nombre , `apellido` = :apellido ,`edad` = :edad , `tipoDocumento` = :tipoDocumento,
                        `foto` = :foto , `rol` = :rol WHERE `usuarios`.`id` = :id ";

                $resp = $this->bd->modificar($sql,array('nombre'=>$this->getNombre(),'apellido'=>$this->getApellido(),'edad'=>$this->getEdad(),
                        'tipoDocumento'=>$this->getTipoDoc(),'foto'=>$this->getFoto(),'rol'=>$this->getRol(), 'id'=>$this->getId()));
                if(isset($resp['result']['error_msg'])){
                    return $resp;
                }else{
                    return $resp;
                }

            }
        }

        public function eliminarUsuario($user){
            $respuesta = new respuestas();
            if(is_integer($user)){
                $this->setId($user);
                $sql = "DELETE FROM `usuarios` WHERE `usuarios`.`id` = :id ";
                $resp = $this->bd->eliminar($sql,array('id'=>$this->getId()));
                if(isset($resp['result']['error_msg'])){
                    return $resp;
                }else{
                    return $resp;
                }
            }else{
                return $respuesta->error_400(" -> FALTAN PARÁMETROS");
            }
        }

        private function obtenerRoles(){
            $sql = "SELECT * FROM rol";
            return $this->bd->obtenerDatos($sql);;
        }

        //SETTER
        public function setId(int $id){
            $this->id= $id;
        }
        public function setNombre(string $nombre){
            $this->nombre= $nombre;
        }
        public function setApellido(string $apellido){
            $this->apellido= $apellido;
        }
        public function setEdad(int $edad){
            $this->edad= $edad;
        }
        public function setFoto($foto){
            $this->foto= $foto;
        }
        public function setTipoDoc(string $tipoDoc){
            $this->tipoDoc= $tipoDoc;
        }
        public function setRol(string $rol){
            $this->rol= $rol;
        }

        //GETTERS
        public function getId(): int{
            return $this->id;
        }
        public function getNombre(): string{
            return $this->nombre;
        }
        public function getApellido(): string{
            return $this->apellido;
        }
        public function getEdad(): int{
            return $this->edad;
        }
        public function getFoto(){
            return $this->foto;
        }
        public function getTipoDoc(): string{
            return $this->tipoDoc;
        }
        public function getRol(): string{
            return $this->rol;
        }
    }
?>
