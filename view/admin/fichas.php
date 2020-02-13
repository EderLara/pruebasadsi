<?php 
include('../../control/conex.php');
error_reporting(0);
header("content-Type: text/html; charset=UTF-8");

$sficha=$_POST['ficha'];
$total="SELECT count(*) from student where ficha like '".$sficha."'";

$res=$con->query($total);
$tot=$res->fetch_row();

$sql="CALL list('".$sficha."')";
$eje=$con->query($sql);

if($eje->num_rows> 0){
    
    echo '
            <h4 class="text-right text-danger"><small><small>Registros encontrados para '.$sficha.': </small></small><strong> '.$tot[0].'</strong></h4>
            
            <table class="table">
              <thead class="thead-inverse">
                <tr>
                  <th>Identificación</th>
                  <th>Nombres </th>
                  <th>Apellidos</th>
                  <th>Ficha</th>
                  <th>Estado de Prueba</th>
                </tr>
              </thead>
              <tbody>
    ';


while($row=$eje->fetch_row()){
    if($row[4]<>'Habilitado'){
    echo '
                <tr>
                  <th scope="row">'.$row[0].'</th>
                  <td>'.$row[1].'</td>
                  <td>'.$row[2].'</td>
                  <td>'.$row[3].'</td>
                  <td>'.$row[4].'</td>
                </tr>
                ';
    }else{
        echo'
            <tr class="bg-info text-light">
                  <th scope="row">'.$row[0].'</th>
                  <td>'.$row[1].'</td>
                  <td>'.$row[2].'</td>
                  <td>'.$row[3].'</td>
                  <td>'.$row[4].'</td>
                </tr>';
        }
}
echo    '   </tbody>
        </table>
        ';
}else{
    echo'<div class="alert alert-warning" role="alert">
            No se Encontraron Resultados para el criterio de busqueda
        </div>';
}
?>

               
               
                
                
              