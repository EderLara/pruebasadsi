<?php include 'core.php'; include ROOT . 'view\\copy\\src\\php\\conexion.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Exportar Base de datos [<?php echo $database; ?>]</title>
    <link rel="stylesheet" href="<?php echo FOLDER_ROOT . 'view\\copy\\src\\css\\bootstrap-spacelab.css' ?>">
    <script src="<?php echo FOLDER_ROOT . 'view\\copy\\src\\javascript\\jquery.min.js' ?>"></script>
    <script src="<?php echo FOLDER_ROOT . 'view\\copy\\src\\javascript\\bootstrap.min.js' ?>"></script>
    <script src="<?php echo FOLDER_ROOT . 'view\\copy\\src\\javascript\\bootstrap-filestyle.js' ?>"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
          <div class="space-container">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Importar base de datos</h3>
              </div>
              <div class="panel-body">
                <form method="post" action="" enctype="multipart/form-data">
                  <!--Input file-->
                  <div class="form-group">
                    <input type="file" name="fichero" id="fichero" accept=".txt, .sql" class="filestyle" data-buttonText="Buscar archivo" data-icon="false">
                    <span class="label label-warning">10Mb maximo.</span>
                    <!--Peso maximo en Kb del archivo-->
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                    <hr>
                    <div class="text-center">
                      <button type="submit" name="button" id="button" class="btn btn-primary">Importar</button>
                      <a href="../../../admin/panel.php" class="btn btn-susses"> Volver</a>
                    </div>
                    <hr>
                    <div class="form-group" id="respuesta">
                      <?php include ROOT . 'view\\copy\\src\\php\\upload.php'; ?>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
