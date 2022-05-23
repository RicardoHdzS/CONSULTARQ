<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el JS 
//------------------------------------------------------------------FAQ------------------------------------------------------------------//  

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_faq = (isset($_POST['id_faq'])) ? $_POST['id_faq'] : '';
$question = (isset($_POST['question'])) ? $_POST['question'] : '';
$answer = (isset($_POST['answer'])) ? $_POST['answer'] : '';
$status2 = (isset($_POST['status2'])) ? $_POST['status2'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO faq (question, answer, status) VALUES('$question', '$answer', '$status2');";           
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 2: //modificación
        $consulta = "UPDATE faq SET question='$question', answer='$answer',  status='$status2' WHERE id_faq='$id_faq';";    
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 3: //baja
        $consulta = "DELETE FROM faq WHERE id_faq='$id_faq';";        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                  
        break;
    }
  
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS

