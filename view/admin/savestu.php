<?php 
include('../../control/conex.php');
include('heada.php');
session_start();
error_reporting(0);
header("content-Type: text/html; charset=UTF-8");
#date_default_timezone_set("America/Bogota"); 

if (isset($_POST['btnadd'])){
    
    $id=$_POST['id'];
    $fi=$_POST['fi'];
    $no=$_POST['no'];
    $ap=$_POST['ap'];

    $sql="CALL AddStudent('".$id."','".$fi."','".$no."','".$ap."')";
    $eje=$con->query($sql);

    echo "
        <script>
            alert('Usuario ".$no." ".$ap." Creado Correctamente');
        </script>
        ";
    header("location:panel.php");
}
?>

