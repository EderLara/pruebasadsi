<?php 
error_reporting(0);
session_start();
if(!isset($_SESSION['student'])){
    echo 'alert("Debes Iniciar Sesion para poder presentar la Prueba.")';
    header('location:../index.php');
}   
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>English Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../public/media/img/logo.png">
    <link rel="stylesheet" href="../public/css/app.css">
    <link rel="stylesheet" href="../public/css/bootstrap.css">
    <link href="../public/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Architects+Daughter|Sedgwick+Ave" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Architects+Daughter|Sedgwick+Ave" rel="stylesheet">
    <script src="../public/js/jquery.js"></script>
    <script src="../public/js/app.js"></script>
    <script src="../public/js/popper.js"></script>
    
  </head>
  <body class="inicio">
    <!-- Optional JavaScript -->
    <script src="public/js/jquery.js"></script>
    <script src="../public/js/app.js"></script>
    <script src="../public/js/popper.js"></script>
    <script src="../public/js/bootstrap.js"></script>
  
