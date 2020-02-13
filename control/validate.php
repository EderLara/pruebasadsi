<?php
include('conex.php');
session_start();

$aprendiz=$_POST['apz'];

$sql="SELECT idEstudiante, concat(Nombres,' ',Apellidos) as student, Estado, Ficha from student where idEstudiante = '".$aprendiz."'";

$eje=$con->query($sql);


if($eje->num_rows> 0){

    $row=$eje->fetch_row();
    
    $_SESSION['student']=$row[1];
    $_SESSION['id']=$row[0];
    $_SESSION['ficha']=$row[3];
    
    /*if($_SESSION['id']==1111){
        header('location:../view/admin/panel.php');
    }*/
    
        if($row[0]==$aprendiz){
            echo '<div class="col-sm-9 alert alert-success"><strong>Bienvenido '.$row[1].'</strong></div> <div class="col-sm-3">
                                <button name="btniniciar" class=" btn btn-success" formaction="../view/quiz/quiz.php">Start Quiz</button>
                            </div>';
            if($_SESSION['id']==1111){
                        echo'<div class="col-sm-9 alert alert-success"><strong>'.$row[1].'</strong></div> <div class="col-sm-3">
                                <button name="btniniciar" class=" btn btn-success" formaction="../view/admin/panel.php">Start Admin</button>
                            </div>';
            }
        }    
    }
    else{
            echo '<div class="col-sm-12 alert alert-danger" role="alert""><strong class="text-center font-weight-bold">El Usuario no se encuentra habilitado para presentar el test</strong></div>';
        }

?>