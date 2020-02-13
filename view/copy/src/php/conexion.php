<?php

/*Conexion MySQLi*/

$hostname = 'localhost'; // Your host name
$database = 'quiz'; // Your database name here
$username = 'root'; // Your mysql username here
$password = ''; // Your mysql password here

if ($database == '') {
  ?>
  <div class="alert alert-dismissible alert-danger">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    Debes configurar el archivo de conexion con MySQL ubicado en src/php/conexion.php
    <br> <small>Error: El nombre de la base de datos no ha sido definido.</small>
  </div>
  <?php
}
# De lo contrario hace la conexion
else{
  # conexion MySQLi
  $sql = new mysqli($hostname, $username, $password, $database);
  if ($sql->connect_errno) {
    echo "Error de conexión MySQLi" . '<br>';
    echo "Conexión Error: " . $sql->error;
  }
  else{
    date_default_timezone_set('America/Bogota');
    $sql->query("SET NAMES UTF8");
  }
}
?>
