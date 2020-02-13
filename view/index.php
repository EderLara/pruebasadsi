<?php 
include('head.php'); 
include('../control/conex.php');
?>
   <script src="log.js"></script>
    <section class="jumbotron bg-primary">
        <div class="row">
            <div class="col-8">
                <h3 class="display-3 text-light"><strong>English Test</strong></h3></div>
            <div class="col-4"><img class="img-fluid" src="public/media/img/logoSena.png" alt="Logo del Sena" width="180"></div>
        </div>
    </section>
    <br>
    <section class="container">
        <div class="row">
            <section class="bg-success text-light col-6">
                <h3 class="text-center">Indicaciones</h3>
                <hr>
                <p class="text-justify">Apreciado aprendiz, para presentar la prueba de ingles siga las recomendaciones del instructor. </p>
            </section>
            <article class="col-6">
                <h3 class="text-center">Ingresar a Prueba</h3>
                <hr>
                <br>
                <form action="" method="post">
                    <br>
                    <div class="form-group row">
                        <label for="inputap" class="col-sm-4 col-form-label">Aprendiz:</label>
                        <div class="col-sm-8">
                            <input type="text" name="txtapz" class="form-control" id="aprendiz" placeholder="Documento de identidad del Aprendiz"> 
                        </div>
                    </div>
                   
                    <div class="form-group row" id="acceso">
                       <!--Control de Acceso-->
                    </div>
                </form>
            </article>
        </div>
    </section>
    
    <?php include('footer.php'); ?>