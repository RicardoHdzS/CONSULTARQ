<?php
	

$server ="localhost";
$user="funda154_Rich";
$pass="Rich.2020"; // $passFun="" ---- $pass=FrAnk180;
$bd="funda154_consultarq";

$mysql= new mysqli($server, $user, $pass, $bd);

if ($mysql->connect_error) {
    die('Error de conexi�n: ' . $mysqli->connect_error);
}
	
	
?>

