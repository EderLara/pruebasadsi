<?php

$host="127.0.0.1";
$port=3306;
$socket="";
$user="root";
$password="";
$dbname="quiz";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('No se puede ingresar; error de parametros de conexión' . mysqli_connect_error());
$acentos = $con->query("SET NAMES 'utf8'");
//$con->close();
?>
