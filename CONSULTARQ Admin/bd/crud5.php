<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el JS   
//--------------------------------------SOLICITUDES------------------------------------------------------------------//  

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_servicio = (isset($_POST['id_servicio'])) ? $_POST['id_servicio'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$numero = (isset($_POST['numero'])) ? $_POST['numero'] : '';
$id_servicioA = (isset($_POST['id_servicioA'])) ? $_POST['id_servicioA'] : '';
$fechaA = (isset($_POST['fechaA'])) ? $_POST['fechaA'] : '';

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';

switch($opcion){
    case 1: //alta

        $consulta = "INSERT INTO solicitud (id_servicio, fecha, numero) VALUES($id_servicio, '$fecha', '$numero');";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta2 = "SELECT service.nombre, solicitud.fecha, solicitud.numero FROM solicitud INNER JOIN service ON solicitud.id_servicio = service.id_servicio WHERE solicitud.id_servicio = $id_servicio AND solicitud.fecha = '$fecha';";         
        $resultado2 = $conexion->prepare($consulta2);
        $resultado2->execute();

        $data=$resultado2->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 2: //modificación
        $consulta = "UPDATE solicitud SET id_servicio=$id_servicio, fecha='$fecha', numero='$numero' WHERE id_servicio=(SELECT id_servicio FROM service WHERE nombre='$nombre') AND fecha='$fechaA';";    
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta2 = "SELECT service.nombre, solicitud.fecha, solicitud.numero FROM solicitud INNER JOIN service ON solicitud.id_servicio = service.id_servicio WHERE solicitud.id_servicio = (SELECT id_servicio FROM service WHERE nombre='$nombre') AND solicitud.fecha = '$fecha';";         
        $resultado2 = $conexion->prepare($consulta2);
        $resultado2->execute();

        $data=$resultado2->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 3://baja
        $consulta = "DELETE FROM solicitud WHERE id_servicio=(SELECT id_servicio FROM service WHERE nombre='$nombre') AND fecha='$fecha';";        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                  
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;