<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el JS   
//---------------------------------------------------------------PERSONAL------------------------------------------------------------//  

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_user = (isset($_POST['id_user'])) ? $_POST['id_user'] : '';
$nombreUser = (isset($_POST['nombreUser'])) ? $_POST['nombreUser'] : '';
$apellidosUser = (isset($_POST['apellidosUser'])) ? $_POST['apellidosUser'] : '';
$correoUser = (isset($_POST['correoUser'])) ? $_POST['correoUser'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$telefonoUser = (isset($_POST['telefonoUser'])) ? $_POST['telefonoUser'] : '';
$tipoUser = (isset($_POST['tipoUser'])) ? $_POST['tipoUser'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO user (correoUser, password, nombreUser, apellidosUser, telefonoUser, tipoUser) VALUES (:correoUser, :password, :nombreUser, :apellidosUser, :telefonoUser, :tipoUser)";            
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':correoUser', $_POST['correoUser']);
        $resultado->bindParam(':nombreUser', $_POST['nombreUser']);
        $resultado->bindParam(':apellidosUser', $_POST['apellidosUser']);
        $resultado->bindParam(':telefonoUser', $_POST['telefonoUser']);
        $resultado->bindParam(':tipoUser', $_POST['tipoUser']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $resultado->bindParam(':password', $password);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

        case 2: //modificación
        $consulta = "UPDATE user SET nombreUser='$nombreUser', apellidosUser='$apellidosUser', correoUser='$correoUser', password='$password', telefonoUser='$telefonoUser', tipoUser='$tipoUser' WHERE id_user='$id_user';";    
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':correoUser', $_POST['correoUser']);
        $resultado->bindParam(':nombreUser', $_POST['nombreUser']);
        $resultado->bindParam(':apellidosUser', $_POST['apellidosUser']);
        $resultado->bindParam(':telefonoUser', $_POST['telefonoUser']);
        $resultado->bindParam(':tipoUser', $_POST['tipoUser']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $resultado->bindParam(':password', $password);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break; 

  /*      case 2: //modificación
        $consulta = "UPDATE user SET (correoUser, password, nombreUser, apellidosUser, telefonoUser, tipoUser) VALUES (:correoUser, :password, :nombreUser, :apellidosUser, :telefonoUser, :tipoUser) WHERE id_user='$id_user';";    
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':correoUser', $_POST['correoUser']);
        $resultado->bindParam(':nombreUser', $_POST['nombreUser']);
        $resultado->bindParam(':apellidosUser', $_POST['apellidosUser']);
        $resultado->bindParam(':telefonoUser', $_POST['telefonoUser']);
        $resultado->bindParam(':tipoUser', $_POST['tipoUser']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $resultado->bindParam(':password', $password);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break; */

     /*  case 2: //modificación
        $consulta = "UPDATE user SET (correoUser:correoUser, password:password, nombreUser:nombreUser, apellidosUser:apellidosUser, telefonoUser:telefonoUser, tipoUser:tipoUser) WHERE id_user='$id_user';";    
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':correoUser', $_POST['correoUser']);
        $resultado->bindParam(':nombreUser', $_POST['nombreUser']);
        $resultado->bindParam(':apellidosUser', $_POST['apellidosUser']);
        $resultado->bindParam(':telefonoUser', $_POST['telefonoUser']);
        $resultado->bindParam(':tipoUser', $_POST['tipoUser']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $resultado->bindParam(':password', $password);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break; */

     

    case 3://baja
        $consulta = "DELETE FROM user WHERE id_user='$id_user';";        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                  
        break;      
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS