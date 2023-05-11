<?php
    class respuestas{
        private $response = [
            "status" => "ok",
            "result" => array()
        ];

        public function error_405(){
            $this->response["status"] = "error";
            $this->response["result"] = array(
                "error_id" => "405",
                "error_msg" => "Método no permitido"
            );
            return $this->response;
        }

        public function respuesta_200($msg=""){
            $this->response["status"] = "ok";
            $this->response["result"] = array(
                "response_id" => "200",
                "response_msg" => $msg
            );
            return $this->response;
        }

        public function respuesta_201($msg=""){
            $this->response["status"] = "creado";
            $this->response["result"] = array(
                "response_id" => "201",
                "response_msg" => $msg
            );
            return $this->response;
        }

        public function error_400($msg=""){
            $this->response["status"] = "error";
            $this->response["result"] = array(
                "error_id" => "400",
                "error_msg" => "Petición erronea".$msg
            );
            return $this->response;
        }

        public function error_404(){
            $this->response["status"] = "error";
            $this->response["result"] = array(
                "error_id" => "404",
                "error_msg" => "Recurso no encontrado"
            );
            return $this->response;
        }
    }
?>
