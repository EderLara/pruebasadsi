<?php include 'core.php'; include ROOT . 'view\\copy\\src\\php\\conexion.php'; ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Exportar Base de datos [<?php echo $database; ?>]</title>
    <link rel="stylesheet" href="<?php echo FOLDER_ROOT . 'view\\copy\\src\\css\\bootstrap-spacelab.css' ?>">
    <script src="<?php echo FOLDER_ROOT . 'view\\copy\\src\\javascript\\jquery.min.js' ?>"></script>
    <script src="<?php echo FOLDER_ROOT . 'view\\copy\\src\\javascript\\bootstrap.min.js' ?>"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
          <div class="space-container">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Exportar base de datos: [<?php echo $database; ?>]</h3>
              </div>
              <div class="panel-body">
                <form method="post">
                  <!--Extencion del fichero-->
                  <div class="form-group">
                    <label for="extencion"><strong>Extención</strong> (*)</label>
                    <select class="form-control" name="extencion" id="extencion">
                      <option value="0">Seleccione una opción</option>
                      <option value=".sql">SQL - Fichero de base de datos</option>
                      <option value=".txt">TXT - Fichero de blog de notas</option>
                    </select>
                  </div>
                  <!--Formato de salida-->
                  <div class="form-group">
                    <label for="extencion"><strong>Comprimir</strong></label>
                    <select class="form-control" name="formato" id="formato">
                      <option value="0">No comprimir</option>
                      <option value=".zip">ZIP - fichero zip</option>
                      <option value=".rar">RAR - fichero rar</option>
                    </select>
                  </div>
                  <!--Descargar-->
                  <div class="form-group texphp ?>-left">
                    <label for="down">Descargar</label>
                    <input type="checkbox" name="down" id="down" checked>
                  </div>
                  <!--Boton para enviar-->
                  <div class="form-group">
                    <input type="hidden" id="ROOT" name="ROOT" value="<?php echo ROOT; ?>">
                    <input type="hidden" id="FOLDER_ROOT" name="FOLDER_ROOT" value="<?php echo FOLDER_ROOT; ?>">
                    <button type="button" name="button" id="button" class="btn btn-primary">Exportar</button>
                    <a href="../../../admin/panel.php" class="btn btn-susses"> Volver</a>
                  </div>
                  <!--Respuesta ajax y javascript-->
                  <div class="form-group" id="respuesta" style="display:none;">
                    <!--Respuesta-->
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Javascript-->
    <script src="<?php echo FOLDER_ROOT . 'view\\copy\\src\\javascript\\getDb.js' ?>"></script>
  </body>
</html>
