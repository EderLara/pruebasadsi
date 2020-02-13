<?php
include('heada.php');
include('../../control/conex.php');
error_reporting(0);
header("content-Type: text/html; charset=UTF-8");
if(isset($_SESSION['mensaje'])){
    echo $_SESSION['mensaje'];
}
?>
<script src="fichas.js"></script>
<script src="result.js"></script>
<script src="../quiz/impresion.js"></script>
<section class="container">
<!--Cabezera y titulos-->
<div class="card" id="resultado">
  <h4 class="card-header text-center text-light bg-success">Configuración</h4>
  <div class="card-body">
    <h4 class="card-title text-center">Panel de Control e Informes</h4>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-expanded="true"><span class="oi oi-people"></span> Gestión Aprendices</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="oi oi-document"></span> Informes</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" id="pills-dropdown1-tab" href="#pills-dropdown1" role="tab" data-toggle="pill" aria-controls="pills-dropdown1"><span class="oi oi-clipboard"></span> Por Ficha</a>
          <a class="dropdown-item" id="pills-dropdown2-tab" href="#pills-dropdown2" role="tab" data-toggle="pill" aria-controls="pills-dropdown2"><span class="oi oi-layers"></span> Completo</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-expanded="true"><span class="oi oi-folder"></span>  Respaldos</a>
      </li>
      
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
          <!--Formulario de registro de Aprendiz:-->
          <form class="form-inline" method="post">
              <div class="form-group col-auto">
                <label for="staticEmail2" class="sr-only">Identificación</label>
                <input type="text" name="id" class="form-control" id="staticEmail2" required placeholder="Identificación">
              </div>
              <div class="form-group col-auto">
                <label for="inputPassword2" class="sr-only">Ficha</label>
                <input type="text" name="fi" class="form-control" id="inputPassword2" required placeholder="Número de Ficha">
              </div>
              <div class="form-group col-auto">
                <label for="inputPassword2" class="sr-only">Nombres</label>
                <input type="text" name="no" class="form-control" id="inputPassword2" required placeholder="Nombres ">
              </div>
              <div class="form-group col-auto">
                <label for="inputPassword2" class="sr-only">Apellidos</label>
                <input type="text" name="ap" class="form-control" id="inputPassword2" required placeholder="Apellidos ">
              </div>
              <div class="col-auto">
              <button name="btnadd" formaction="savestu.php" class="btn btn-success">Guardar</button>
              </div>
            </form>
      </div>
      
      
      <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
          
          <center><div class="btn-group btn-group-lg text-center" role="group" aria-label="...">
              <a class="btn btn-success" href="../copy/examples/export/index.php" role="button">Descargar</a>
          </div>
         <div class="btn-group btn-group-lg text-center" role="group" aria-label="...">
          <a class="btn btn-secondary" href="../copy/examples/import/index.php" role="button">Cargar</a>
          </div></center>
      </div>
      
      
      <div class="tab-pane fade" id="pills-dropdown1" role="tabpanel" aria-labelledby="pills-dropdown1-tab">
          <p class="text-dark">Puedes filtrar por número de ficha para ver el resultado de las pruebas. :</p>
          <form class="form-inline">
              <div class="form-group col-auto">
                <label for="staticEmail2" class="">Número de ficha: </label>
                <input type="text" class="form-control" id="fichab" placeholder="EJ: 1100000">
              </div>
              <div class="btn-group text-center">
                <button onclick="imprSelec()" class="btn btn-info"><span class="oi oi-print"></span> Imprimir Resultado</button>
                </div>
          </form>
          
          <section id="tblficha">
              <!--Impresión de datos del estudiante por ficha-->
          </section>
          
          
      </div>
      <div class="tab-pane fade" id="pills-dropdown2" role="tabpanel" aria-labelledby="pills-dropdown2-tab">
          <p class="text-dark">Puedes filtrar Por número de ficha para ver el Estado de las pruebas de cada uno de los aprendices matriculados en esta. :</p>
        <form class="form-inline">
              <div class="form-group col-auto">
                <label for="" class="">Número de Ficha : </label>
                <input type="text" class="form-control" id="busca" placeholder="Criterio de Busqueda">
              </div>
                <div class="btn-group text-center">
                <button onclick="imprSelec('resultado')" class="btn btn-info"><span class="oi oi-print"></span> Imprimir Resultado</button>
                </div>
        </form>
          
          <section id="tblfull">
              <!--Impresión de Resultados por ficha o por estudiante-->
          </section>  
      
      </div>
    </div>
<hr>
        <!--Opciones e Información-->
            <div class="text-left">
                <a href="../index.php" class="btn btn-primary"><span class="oi oi-home"></span></a>
                <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary"><span class="oi oi-info"></span></a>
            </div>

      <div class="card-footer text-light text-right bg-secondary">
        Sena Regional Antioquia Programa de Articulación con la Media Técnica. @2017.
      </div>
    </div>
    <input type="hidden" value="Software desarrollado por: Juan Porras y Eder Lara Instructores de programación de la media Técnica en programación de software">
</div>
</section>


<!-- Modal Información -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Acerca de este software:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-3">
               <h4 class="text-info">Diseño y pruebas:</h4>
               <hr>
                <p class="text-center"><strong>Yadeline Alejandra González Zuluaga</strong><br>Publicista</p>
                <p class="text-center"><strong>Eder Lara Trujillo</strong><br>Ingeniero de Sistemas</p>
            </div>
            <div class="col-3">
               <h4 class="text-info">Desarrollo y Programación:</h4>
               <hr>
                <p class="text-center"><strong>Juan Diego Porras Vanegas</strong><br>Ingeniero Informático</p>
                <p class="text-center"><strong>Eder Lara Trujillo</strong><br>Ingeniero de Sistemas</p>
            </div>
            <div class="col-3">
               <h4 class="text-info">Implementación y Soporte:</h4>
               <hr>
                <p class="text-center"><strong>Andrés Felipe Mejia</strong><br>Administrador de Sistemas</p>
                <p class="text-center"><strong>Juan Diego Porras Vanegas</strong><br>Ingeniero Informático</p>
                <p class="text-center"><strong>Eder Lara Trujillo</strong><br>Ingeniero de Sistemas</p>
            </div>
            <div class="col-3">
               <h4 class="text-info">Con la Colaboración:</h4>
               <hr>
                <p class="text-center"><strong>Paula Andrea Cuervo Pareja</strong><br>Ingeniero Informático</p>
                <p class="text-center"><strong>Alexander Villa</strong><br>Ingeniero Electronico</p>
                <p class="text-center"><strong>Edward Luna</strong><br>Lider de la Articulación con la Media Técnica</p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>