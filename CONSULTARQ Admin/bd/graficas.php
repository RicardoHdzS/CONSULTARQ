<?php
header('Content-type: application/json');
include_once 'conexion.php';

$objeto = new Conexion();
$conexion = $objeto->Conectar();

$result = array();

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$inicial = (isset($_POST['inicial'])) ? $_POST['inicial'] : '';
$final = (isset($_POST['final'])) ? $_POST['final'] : '';
$id_servicio = (isset($_POST['id_servicio'])) ? $_POST['id_servicio'] : '';

switch($opcion){
  //pastel (anual)
  case 1:
    $consulta = "SELECT nombre, sum(numero) AS solicitudes FROM solicitud INNER JOIN service ON solicitud.id_servicio = service.id_servicio WHERE fecha BETWEEN '$inicial' AND '$final' GROUP BY solicitud.id_servicio ORDER BY sum(numero) DESC";
	$resultado = $conexion->prepare($consulta);
	$resultado->execute();

	while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)){
	   array_push($result, array($fila["nombre"], $fila["solicitudes"] ));
	}
  break;

  //barras (mensual)
  case 2:
    $consulta = "SELECT fecha, MONTH(fecha) as mes, YEAR(fecha) as anio, sum(numero) as solicitudes FROM solicitud WHERE fecha BETWEEN '$inicial' AND '$final' GROUP BY mes, anio ORDER BY anio ASC";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    $mes;
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)){
        $anio = $fila["anio"];
        switch ($fila["mes"]) {
        	case 1:
        		$mes = "Enero, ".$anio;
        		break;
        	case 2:
        		$mes = "Febrero, ".$anio;
        		break;
        	case 3:
        		$mes = "Marzo, ".$anio;
        		break;
        	case 4:
        		$mes = "Abril, ".$anio;
        		break;
        	case 5:
        		$mes = "Mayo, ".$anio;
        		break;
        	case 6:
        		$mes = "Junio, ".$anio;
        		break;
        	case 7:
        		$mes = "Julio, ".$anio;
        		break;
        	case 8:
        		$mes = "Agosto, ".$anio;
        		break;
        	case 9:
        		$mes = "Septiembre, ".$anio;
        		break;
        	case 10:
        		$mes = "Octubre, ".$anio;
        		break;
        	case 11:
        		$mes = "Noviembre, ".$anio;
        		break;
        	case 12:
        		$mes = "Diciembre, ".$anio;
        		break;
        }
        //$mes=$mes+", "+$fila["anio"];
        array_push($result, array($mes, $fila["solicitudes"]));
    }
  break;

  //lineas (diaria)
  case 3:
    $consulta = "SELECT * FROM solicitud WHERE fecha BETWEEN '$inicial' AND '$final' AND id_servicio='$id_servicio'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)){
           array_push($result, array($fila["fecha"], $fila["numero"]));
    }

  break;
}

print json_encode($result, JSON_NUMERIC_CHECK);
$conexion=null;



