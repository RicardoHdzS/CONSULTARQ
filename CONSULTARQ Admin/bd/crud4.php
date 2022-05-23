<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el JS   

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

        $consulta = "DELETE FROM imagephp WHERE id='$id';";        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                  

//print json_encode($result, JSON_NUMERIC_CHECK);
           
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
