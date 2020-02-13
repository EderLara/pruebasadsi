<?php
if ($_FILES) {
  # El fichero temporal almacenado en el navegador
  $tmp  = $_FILES['fichero']['tmp_name'];
  # El tipo de fichero aceptado (sql/txt) Proximamente ZIP O RAR
  $tipo = $_FILES['fichero']['type'];
  # El peso del fichero, lo vamos a limitar mas adelante a 10Mb (10000000Kb)
  $size = $_FILES['fichero']['size'];
  # Este filtro permite evaluar si el fichero es aceptado por el peso
  if ($size > '10000000'){
    echo '<div class="alert alert-dismissible alert-danger">';
    echo '<button type="button" class="close" data-dismiss="alert">X</button>';
    echo '<strong>¡Error!</strong> Este fichero sobrepasa el tamaño maximo (10Mb).</div>';
    return 0;
  }
  # Este filtro permite evaluar si el fichero es aceptado por el tipo
  if($tipo == 'text/plain' OR $tipo == 'application/octet-stream'){
    # Archivo de conexion MySQL
    include 'conexion.php';
    # Abriendo en buffer el archivo subido
    $handle = fopen($tmp, 'rb');
    # Archivo temporal en la carpeta de la aplicacion
    $excecute = fopen('tmp_file.txt', 'w');
    # Miestras encuentre lineas
    while (!feof($handle)) {
    # Buffer de datos
    $buffer = fgets($handle);
    if (substr_count($buffer, '--'))
      $buffer = '';
    if (substr_count($buffer, '/*'))
      $buffer = '';

    $buffer = str_replace(PHP_EOL, '', $buffer);
    /*Eliminar saltos de linea*/
    $buffer = trim($buffer, "\n");
    /*Hacer saltos de linea en los punto y coma*/
    $buffer = str_replace(';', ';'.PHP_EOL, $buffer);
    $buffer = str_replace('AUTO_INCREMENT', ' AUTO_INCREMENT', $buffer);
    $buffer = str_replace('DEFAULT', ' DEFAULT', $buffer);
    fwrite($excecute, $buffer);
    }
    # Cerramos el archivo temporal del navegador
    fclose($handle);
    # Abrir el archivo temporal de la aplicacion
    $excecute = fopen('tmp_file.txt', 'rb');
    # Almacenar todas las consultas en un array para verificar que todas se
    # ejecuten correctamente, de igual manera para las que no
    $query_ok = array();
    $query_no = array();
    # Ejecutar las lineas del fichero
    while (!feof($excecute)) {
      # El buffer de datos, linea por linea
      $buffer = fgets($excecute);
      # Cuando la cadena recibida tenga una longitud de mas de 2
      if (strlen($buffer) > 2) {
        # Ejecuta la consulta
        $rs = $sql->query($buffer);
        # Cuando encuentre algun tipo de error
        if ($rs)
          $query_ok[] = $buffer;
        else
          $query_no[] = $buffer;
      }
    }
    # Cerrando el archivo subido en el navegador
    fclose($excecute);
    # Eliminar el fichero temporal
    unlink('tmp_file.txt');
    # Retornando una respuesta al navegador
    echo '<div class="alert alert-dismissible alert-success">';
    echo '<button type="button" class="close" data-dismiss="alert">X</button>';
    echo '<strong>¡Correcto!</strong> El archivo fue procesado con exito.';
    echo '<br>Consultas con exito: '.count($query_ok).'<br>Consultas fallidas: '.count($query_no);'</div>';
    unset($_POST);
    unset($_FILES);
    return 0;
  }
  else{
    echo '<div class="alert alert-dismissible alert-danger">';
    echo '<button type="button" class="close" data-dismiss="alert">X</button>';
    echo '<strong>¡Error!</strong> Este tipo de archivo no es aceptado por el sistema.';
    echo 'Seleccione un fichero con extensiones .txt o .sql</div>';
    return 0;
  }
}
?>
