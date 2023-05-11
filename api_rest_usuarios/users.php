<?php
    require_once "modelo/conexion/conexion.php";
    require_once "modelo/Usuarios.class.php";
    $conexion = new Conexion();
    $user;

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $user = new Usuarios();
        header("Content-Type: application/json");
        $respuesta = $user->listarUsuarios();
        if(isset($respuesta["result"]["error_id"])){
            echo json_encode($respuesta);
            http_response_code($respuesta["result"]["error_id"]);
        }else if(isset($respuesta["result"]["response_id"])){
            echo json_encode($respuesta);
            http_response_code($respuesta["result"]["response_id"]);
        }else{
            http_response_code(200);
            echo json_encode($respuesta);
        }

    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        $postBody = file_get_contents("php://input");
        $user = new Usuarios();
        header("Content-Type: application/json");
        $respuesta = $user->guardarUsuario($postBody);
        if(isset($respuesta["result"]["error_id"])){
            http_response_code($respuesta["result"]["error_id"]);
            echo json_encode($respuesta);
        }else if(isset($respuesta["result"]["response_id"])){
            http_response_code($respuesta["result"]["response_id"]);
            echo json_encode($respuesta);
        }else{
            http_response_code(201);
            echo json_encode($respuesta);
        }

    }else if($_SERVER['REQUEST_METHOD'] == "PUT"){
        $postBody = file_get_contents("php://input");
        $user = new Usuarios();
        header("Content-Type: application/json");
        $respuesta = ($user->modificarUsuario($postBody));
        if(isset($respuesta["result"]["error_id"])){
            http_response_code($respuesta["result"]["error_id"]);
            echo json_encode($respuesta);
        }else if(isset($respuesta["result"]["response_id"])){
            http_response_code($respuesta["result"]["response_id"]);
            echo json_encode($respuesta);
        }else{
            http_response_code(200);
            echo json_encode($respuesta);
        }

    }else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
        $uri=$_SERVER["REQUEST_URI"];
        $separada = explode("/", $uri);
        $userId = $separada[sizeof($separada)-1];
        $user = new Usuarios();
        header("Content-Type: application/json");
        $respuesta = $user->eliminarUsuario(intVal($userId));
        if(isset($respuesta["result"]["error_id"])){
            http_response_code($respuesta["result"]["error_id"]);
            echo json_encode($respuesta);
        }else if(isset($respuesta["result"]["response_id"])){
            http_response_code($respuesta["result"]["response_id"]);
            echo json_encode($respuesta);
        }else{
            http_response_code(200);
            echo json_encode($respuesta);
        }
    }
?>
