<?php
	

$server ="localhost";
$user="root";
$pass=""; // $passFun="" ---- $pass=FrAnk180;
$bd="consultarq";

$mysql= new mysqli($server, $user, $pass, $bd);

if ($mysql->connect_error) {
    die('Error de conexi�n: ' . $mysqli->connect_error);
}
	
	
?>

