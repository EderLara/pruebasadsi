<?php
include('../../control/conex.php');
//error_reporting(0);
header("content-Type: text/html; charset=UTF-8");

$salvar=$_POST['btnsave'];

if(isset($salvar)){
 # Variables del formulario para la insercion en la base de datos:
    $idaprend=$_POST['idaprend'];
    $pregunta=$_POST['idpregun'];
    $responde=$_POST['responde'];
    
    # echo $idaprend.' '.$pregunta.' '.$responde; Vallidado OK!
    
    $sql="Call SaveAnswer('".$idaprend."','".$pregunta."','".$responde."')";
    $eje=$con->query($sql);
    header('location:quiz.php');
}

?>