<?php
include('../../control/conex.php');

if(isset($_POST['habil'])){
    $ida= $_POST['ida'];
    #Habilitamos Estudiante
    $udt="Update student set Estado='Habilitado' where idEstudiante='".$ida."'";
    $res=$con->query($udt);    
    #Preparamos para segunda oportunidad:
    $sql="delete from detaquiz where idEstudiante='".$ida."';";
    $eje=$con->query($sql);
    $msj='<script>alert("Usuario Habilitado para Repetir la Prueba");</script>';
    $_SESSION['mensaje']=$msj;
    header('location:../admin/panel.php');
}

?>