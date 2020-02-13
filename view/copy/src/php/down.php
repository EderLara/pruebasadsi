<?php
include 'core.php';
if ($_REQUEST) {
  date_default_timezone_set("America/Bogota");
  if (isset($_REQUEST['download']) && !empty($_REQUEST['download'])) {
    # Base de datos que sera descargada
    $respaldo = $_REQUEST['download'];
    # Compresion del fiecho final
    $formato  = $_REQUEST['formato'];
    # Fichero en el servidor
    $nombre = getcwd() . '\\exports\\' . $respaldo;
    if ($formato != '0') {
      if (file_exists($nombre)) {
        $zip = new ZipArchive();
        $filename = $respaldo . $formato;
        if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {
          copy($nombre, $respaldo);
          $zip->addFile($respaldo);
          $zip->close();
          unlink($respaldo);
          # Descargar el archivo
          header("Content-Type: application/zip");
          header("Content-Transfer-Encoding: Binary");
          header("Content-Length: ".filesize($filename));
          header("Content-Disposition: attachment; filename=\"".basename($filename)."\"");
          readfile($filename);
          unlink($respaldo.$formato);
          exit;
      }
    }
  }else{
    header("Content-disposition:attachment; filename=" . $respaldo);
    header("Content-type: text/sql");
    move_uploaded_file();
    readfile($nombre);
    unlink($nombre);
    }
  }
}
?>
