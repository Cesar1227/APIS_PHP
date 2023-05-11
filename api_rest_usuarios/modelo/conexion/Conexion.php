<?php

require_once "modelo/respuestas.class.php";

class Conexion{

    /**
     * Variables para la conexion a la base de datos
     */
    private $server;
    private $user;
    private $password;
    private $db;
    private $port;
    private $conexion;
    private $respuestaErr;

    function __construct(){
        $dataConexion = $this->dataConexion();
        foreach($dataConexion as $key => $value){
            $this->server =$value['server'];
            $this->user =$value['user'];
            $this->password = $value['password'];
            $this->db = $value['dbname'];
            $this->port = $value['port'];
        }
        $this->conectaraBD();
        $this->respuestaErr = new respuestas();
    }

    /**
     * Realiza la conexión a la base de datos
     */
    private function conectaraBD(){
        try{
            $this->conexion = new PDO("mysql:host=$this->server;dbname=$this->db", $this->user, $this->password);      
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Conexión realizada Satisfactoriamente";
        }catch(PDOException $e){
          echo "La conexión ha fallado: " . $e->getMessage();
        }

        /*$this->conexion = new mysqli($this->server,$this->user,$this->password,$this->db,$this->port);
        if($this->conexion->connect_errno){
            echo "Error al conectar con la base de datos";
            die();
        }*/
    }

    /**
     * Devuelve los datos configurados para conectarse a la base de datos
     * 
     */
    private function dataConexion(){
        $dir = dirname(__FILE__);
        $jsondata = file_get_contents($dir . "/" . "config");
        return json_decode($jsondata,true);
    }

    /**
     * Devuelve el arreglo en formato UTF-8 en caso de no estarlos
     */
    private function parserUTF8($str){
        array_walk_recursive($str,function(&$item,$key){
            $item = mb_convert_encoding($item, "UTF-8", mb_detect_encoding($item));
        });
        return $str;
    }

    /**
     * Realiza una consulta a la base de datos y devuelve el resultado
     * $consulta -> Query de consulta
     * 
     */
    public function obtenerDatos($consulta){
        $query = $this->conexion->prepare($consulta);

        if($query === false){
            
            return $this->respuestaErr->error_400();
        }else{
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $this->parserUTF8($result);
        }
    }


    /**
     * Petición a la base de datos
     */
    public function peticion($sql){
        $result = $this->conexion->query($sql);
        return $result;
    }

    /**
     * Realiza una inserción a la base de datos
     * $sql -> Query de inserción
     * $array -> Parámetros
     * Retorna el id autogenerado en la inserción
     */
    public function insercion($sql,$array){
        $query = $this->conexion->prepare($sql);
        if ($query === false) {
            return $this->respuestaErr->error_400();
        }else{
            $query->bindParam(':nombre',$array['nombre']);
            $query->bindParam(':apellido',$array['apellido']);
            $query->bindParam(':edad',$array['edad']);
            $query->bindParam(':tipoDoc',$array['tipoDoc']);
            $query->bindParam(':foto',$array['foto']);
            $query->bindParam(':rol',$array['rol']);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $this->conexion->lastInsertId();
        }
    }

    /**
     * Modifica datos de los usuarios en la base de datos
     * $sql -> Query de inserción
     * $array -> Parámetros
     * Retorna el ID del usuario modificado
     */
    public function modificar($sql,$array){
        $query = $this->conexion->prepare($sql);
        if ($query === false) {
            print_r("ERROR EN LA CONSULTA".$this->conexion->errorInfo());
            return $this->respuestaErr->error_400();
        }else{
            $query->bindParam(':nombre',$array['nombre']);
            $query->bindParam(':apellido',$array['apellido']);
            $query->bindParam(':edad',$array['edad']);
            $query->bindParam(':tipoDocumento',$array['tipoDocumento']);
            $query->bindParam(':foto',$array['foto']);
            $query->bindParam(':rol',$array['rol']);
            $query->bindParam(':id',$array['id'],PDO::PARAM_INT);
            $query->execute();
            if($query->rowCount()>0){
                return $this->respuestaErr->respuesta_200("ID USUARIOS MODIFICADO: ".$array['id']);
            }else{
                return $this->respuestaErr->respuesta_200("ID USUARIO MODIFICADO: NONE");
            }
        }
    }

    /**
     * Eliminar usuarios en la base de datos
     * $sql -> Query de inserción
     * $array -> Parámetros
     * Retorna el ID del usuario eliminado
     */
    public function eliminar($sql,$array){
        $query = $this->conexion->prepare($sql);
        if ($query === false) {
            print_r("ERROR EN LA CONSULTA".$this->conexion->errorInfo());
            return $this->respuestaErr->error_400();
        }else{
            $query->bindParam(':id',$array['id'],PDO::PARAM_INT);
            $query->execute();
            if($query->rowCount()>0){
                return $this->respuestaErr->respuesta_200("USUARIO ELIMINADO: ".$array['id']);
            }else{
                return $this->respuestaErr->respuesta_200("ID USUARIO ELIMINADO: NONE");
            }
            
        }
    }
}

?>