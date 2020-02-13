<?php 
include('../../control/conex.php');
error_reporting(0);
header("content-Type: text/html; charset=UTF-8");

$dato=$_POST['dato'];

$cnt="select (select count(*) from resultado where final <70) as perdiendo, (select count(*) from resultado where final >69) as ganando";
$sql="SELECT * FROM resultado";

if(isset($dato)){
    $s=$con->real_escape_string($dato);    
    $sql="CALL result(".$s.")";
    
}


$eje=$con->query($sql);
if($eje->num_rows> 0){
    echo '';
    echo '        
            <table class="table">
              <thead class="thead-inverse">
                <tr>
                  <th>Fecha de Presentación</th>
                  <th>Identificación </th>
                  <th>Nombre de Aprendiz</th>
                  <th>Ficha</th>
                  <th>Resultado</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
    ';


while($row=$eje->fetch_row()){
    if($row[4]>69){
        echo '
             <tr>
                  <th scope="row">'.$row[0].'</th>
                  <td>'.$row[1].'</td>
                  <td>'.$row[2].'</td>
                  <td>'.$row[3].'</td>
                  <td>'.rtrim($row[4],'0').'%</td>
                  <td class="text-center"><strong>A</strong></td>
                </tr>
             ';
    }else {
        echo '
                <tr class="bg-warning text-danger">
                  <th scope="row">'.$row[0].'</th>
                  <td>'.$row[1].'</td>
                  <td>'.$row[2].'</td>
                  <td>'.$row[3].'</td>
                  <td>'.rtrim($row[4],'0').'%</td>
                  <td class="text-center">
                  <form action="habil.php" method="post">
                    <input type="hidden" name="ida" value="'.$row[1].'">
                        <button name="habil" class="btn btn-success" title="Habilitar de Nuevo"><span class="oi oi-reload"></span></button>
                  </form>
                  </td>
                </tr>
            ';
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

            