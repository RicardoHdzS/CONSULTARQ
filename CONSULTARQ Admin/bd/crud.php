<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el JS   
//------------------------------------------------------------------SERVICIO------------------------------------------------------------------//  

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_servicio = (isset($_POST['id_servicio'])) ? $_POST['id_servicio'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$imagen = (isset($_POST['imagen'])) ? $_POST['imagen'] : '';
$status = (isset($_POST['status'])) ? $_POST['status'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO service (nombre, descripcion, imagen, status) VALUES('$nombre', '$descripcion', '$imagen', '$status');";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 2: //modificación
        $consulta = "UPDATE service SET nombre='$nombre', descripcion='$descripcion', imagen='$imagen', status='$status' WHERE id_servicio='$id_servicio';";    
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 3://baja
        $consulta = "DELETE FROM service WHERE id_servicio='$id_servicio';";        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                  
        break;

    case 4:
        $consulta = "SELECT servicio, SUM(numero) as num_solicitud FROM servicios INNER JOIN solicitud ON servicios.id_servicio = solicitud.id_servicio GROUP BY servicio;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)){
            array_push($result, array($fila["servicio"], $fila["num_solicitud"] ));
        }

        //print json_encode($result, JSON_NUMERIC_CHECK);
    break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS

