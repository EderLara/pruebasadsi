<script src="impresion.js"></script>
<div class="container-fluid">
<?php 
include('../../control/conex.php');
include('headq.php');
session_start();
error_reporting(0);
header("content-Type: text/html; charset=UTF-8");
#date_default_timezone_set("America/Bogota"); 
$aprendiz=$_SESSION['student'];
$idaprend=$_SESSION['id'];
$fichapre=$_SESSION['ficha'];
?>

<script>
document.onkeydown = desabilitar; // Teclas Precionada 
document.onselectstart = selecionar; //Anular la Selecion de Texto 
document.oncontextmenu = selecionar; //Anular el Boton Der del Mouse 

function selecionar() { 
return false; 
} 

function desabilitar() { 
// Combinacion de Teclas con el Control 
    if (event.ctrlKey) { 
            switch(window.event.keyCode) { 
                case 67: //Ctrl-C -- Copiar --- 
                case 86: //Ctrl-V -- Pegar --- 
        event.keyCode = 0; 
        return false;

        default: 
        break; 
            } 
    } 
} 
    
</script>
<?php ?>

<style>
    #fondocat{
        border-radius: 0px 100px 200px 10px !important;
        -moz-border-radius: 0px 100px 200px 10px !important;
        -webkit-border-radius: 0px 100px 200px 10px !important;
        border: 0px solid #000000;
    } 
    #pie{
        bottom: 0 !important;
    }
</style>
<nav class="col bg-primary">
			<h4 class="text-light text-right">English Test</h4>
		</nav>
<section class="row">
	<aside class="col-2 bg-success">
		<h3 class="text-light text-center"><?php echo $aprendiz;?></h3>
		<h4 class="text-light text-center">Id : <?php echo $idaprend;?></h4>
		<h3 class="text-light text-center"><?php echo $fichapre;?></h3>
		<hr>
		<h5 class="text-light">Instrucciones:</h5>
		<ol class="text-light text-justify">
		    <li>Leer detenidamente cada enunciado</li>
		    <li>Marcar Una Sola Opción.</li>
		    <li>No se Puede Volver atras, asi que asegurate de marcar la opcion correcta.</li>
		</ol>
		<hr>
		<center><span class="oi oi-laptop display-2 text-primary"></span></center>
		<p class="text-light text-center"><?php echo date('d-m-Y');?></p>
		<cite class="text-light text-left">Take it easy, this test is designed to test your knowledge in English. Enjoy it!.</cite>
	</aside>
	<div class="col-10">
       <!--Impresión de las preguntas a contestar...-->
        <?php 
        $sql="select * from preguntas where idquestion not in(select idquestion from detaquiz where idEstudiante='".$idaprend."') order by rand() limit 1";
        $res=$con->query($sql);
        if($res->num_rows >0){
        if($row=$res->fetch_row()){
            include('../../control/conex.php');
                $qst=$row[3];   
                echo '
        <div class="col-12">
            <form action="ansheet.php" method="post" class="row">
            
            
            <!--Entradas Ocultas para la Insersion de la respuesta-->
            <input type="hidden" name="idaprend" value="'.$idaprend.'">
            <input type="hidden" name="idpregun" value="'.$qst.'">
            
               <div class="col-7">
                   <div class="col-12 bg-success" id="fondocat">
                   <strong>
                   <h3 class="text-light">Categoria : '.$row[0].' </h3>
                   <h3 class="text-light">'.$row[1].'</h3>
                   <span class="text-light">____________________________________________________________________________________</span>
                   <h5 class="text-light">'.$row[2].'</h5>
                   </strong>
                  </div>
                <hr>';
            if($row[0]=='B'){
            echo '
                <div class="row">
                <div class="col-5">
                    <h3 class="text-dark text-center"><strong>'.$row[1].'</strong></h3  
                    <h5 class="text-dark text-justify"><strong>'.$row[5].'</strong></h5>
                    <center><img class="img-fluid" src="'.$row[4].'" alt="Imagen de la categoria"></center>               
               </div>
               <div class="col-7">
                    <br><br><br><br>
                    <h4 class="text-success"><strong>Opciones de Respuesta:</strong></h4>';            

                       $sqls="CALL opciones('".$qst."')";
                       $eje=$con->query($sqls);
                echo '<ol id="opciones" type="a">';
                    if($eje->num_rows>0){
                        while($fila=$eje->fetch_row()){
                       echo '
                                    <li>
                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input class="form-check-input" type="radio" required name="responde" id="exampleRadios1" value="'.$fila[1].'">
                                            '.$fila[0].'
                                          </label>
                                        </div>
                                    </li>';
                           
                            }
                        }
                echo '</ol>
               </div>
               </div>
               </div>
               <div class="col-5 center-align">
                 <img class="img-fluid" src="'.$row[6].'" alt="Imagen de la categoria">               
               </div>
               <div class="col-9"></div>
               <div class="col-3">
                    <button name="btnsave" class="btn btn-secondary btn-lg">Next Question <span class="oi oi-chevron-right"></span><span class="oi oi-chevron-right"></span></button>
               </div>
               </form>
            </div>  
        </div>
               ';
            }else{
                
                echo '
                <h5 class="text-dark text-justify"><strong>'.$row[5].'</strong></h5>
                <br>
                <h6 class="text-success"><strong>Pregunta:</strong></h6>
                    <h4 class="text-justify text-uppercase font-italic">
                        <strong>';
                
                    echo '#'.$row[3].' : '.$row[4].'</strong>
                    </h4>';
                if($row[0]=='E'){
                    echo '<a class="btn btn-outline-success" data-toggle="modal" data-target=".bd-example-modal-lg" data-whatever="@mdo"><strong></strong>Completar texto</a>';               
                }
                if($row[0]=='F'){
                    echo '<a type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModalLong">
                          Documento de Lectura:</a>';
                }
                echo '
                    <h6 class="text-success"><strong>Opciones de Respuesta:</strong></h6>';            

                       $sqls="CALL opciones('".$qst."')";
                       $eje=$con->query($sqls);
                echo '<ol id="opciones" type="a">';
                    if($eje->num_rows>0){
                        while($fila=$eje->fetch_row()){
                       echo '
                                    <li>
                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input class="form-check-input" type="radio" required name="responde" id="exampleRadios1" value="'.$fila[1].'">
                                            '.$fila[0].'
                                          </label>
                                        </div>
                                    </li>';
                           
                            }
                        }
                echo '</ol>
               </div>
               <div class="col-5 center-align">
                 <img class="img-fluid" src="'.$row[6].'" alt="Imagen de la categoria">               
               </div>
               <div class="col-9"></div>
               <div class="col-3">
                    <button name="btnsave" class="btn btn-secondary btn-lg">Next Question <span class="oi oi-chevron-right"></span><span class="oi oi-chevron-right"></span></button>
               </div>
            </form>
            <br><br>
        </div>  
	</div>';
        }
    }
}else{
                $msj= '<div class="alert alert-warning" role="alert">
                              No hay Resultados para mostrar!
                          </div> ';
            
                $udt="Call finish('".$idaprend."')";
                $res=$con->query($udt);
                $usr="udate Student set Estado='Pendiente' where idestudiante='1111'";
                $adm=$con->query($usr);
        
                $sql="SELECT min(audit), max(audit) from detaquiz where idestudiante='".$idaprend."' ";
                $eje=$con->query($sql);
                if($row=$eje->fetch_row()){
                    $ini=$row[0];
                    $fin=$row[1]; 
               
                }else{
                    echo $msj;
                }
                
                
                $end="CALL AnSheet('".$idaprend."')";
                $cll=$con->query($end);
                if($row=$cll->fetch_row()){
                    $score=$row[0];
                }else{
                     echo $msj;
                }
                ?>
               
                <div class="col-12" id="resultado">
                    <div class="card text-center">
                      <div class="card-header bg-secondary text-light">
                          <h3><strong><?php echo $aprendiz; ?> Your Score:</strong></h3>
                      </div>
                      <div class="card-body">
                       <?php 
                        if($score<70){
                            echo '
                            <h4 class="card-title">Awww You lose!!</h4>
                            <p class="card-text">You have reached a total score of:</p>
                            <h1 class="display-2"><strong>'.rtrim($score,'0').' %</strong></h1>
                            <form method="post"
                             <input type="hidden" value="<?php echo $idaprend; ?>">
                            <button onclick="imprSelec()" class="btn btn-info"><span class="oi oi-print"></span> Result Paper</button>
                            <a href="../../control/finish.php" class="btn btn-primary">Good bye</a>
                            </form>
                            ';
                        }else{
                            echo '
                            <h4 class="card-title">Congratulations !!</h4>
                            <p class="card-text">You have reached a total score of:</p>
                            <h1 class="display-2"><strong>'.rtrim($score,'0').' %</strong></h1>
                            <form method="post">
                            <input type="hidden" value="<?php echo $idaprend; ?>">
                            <button onclick="imprSelec()" class="btn btn-info"><span class="oi oi-print"></span> Result Paper</button>
                            <a href="../../control/finish.php" class="btn btn-primary">Good bye</a>
                            </form>
                            ';
                        }
                        ?>
                        
                        
                      </div>
                      <div class="card-footer text-muted">
                        <?php echo 'Start Time: '.$ini.'    Finish Time: '.$fin; ?>
                      </div>
                    </div>
                </div>
<?php            
        }
# Terminacion de la primera condicion
 ?>
<!--Final de cuestionario -->
</div>
</section>

<!--Contenido del Modal a partir de la Categoria E-->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content text-justify">
     <section class="container">
      <h4 class="text-center">DANIELA AND MARK DOBSON</h4>
<cite>By www.ingles-practico.com</cite>
        <p>Mark and Daniela Dobson <cite class="text-info font-weight-bold">___27</cite>   a young couple who live in Miami. Miami is a big city located in South Florida. Mark works as a manager <cite class="text-info font-weight-bold">___28</cite>   a large bank in downtown Miami. Daniela works as a web designer. She receives contracts from various companies to build and maintain their websites.</p>

        <p>Mark was born and grew up in the United States. His parents and grandparents moved to the United States from Europe in the 1940s during and after the Second World War. <cite class="text-info font-weight-bold">___29</cite>   family settled in New York where he grew up and completed his education. Shortly after graduating from college with   <cite class="text-info font-weight-bold">___30</cite> Degree in Business Administration, he moved to Miami where he got a job at a pharmaceutical company.</p>

        <p><cite class="text-info font-weight-bold">___31</cite> 1995 Mark met Daniela at work. She was assigned to improve   <cite class="text-info font-weight-bold">___32</cite> company website. One day when Mark <cite class="text-info font-weight-bold">___33</cite>   paying for his lunch at the company cafeteria, he noticed Daniela sitting alone at a table. He walked over, introduced himself and asked if he could sit with her. They began to have lunch together every day. As they got to know more <cite class="text-info font-weight-bold">___34</cite>   each other, they fell in love.</p>
     </section>
    </div>
  </div>
</div>


<!--Contenido del modal de la categoria F-->

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLongTitle">A DAY TO REMEMBER</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-justify">
            <p>Serena and Juan walk through the terminal in Logan airport in Boston without saying a word to each other. Juan has checked in his suitcases and has one carry on with him. He is getting ready to board a flight to California for a short term project he is working on.</p>
            
            <p>"Well, I guess this is where we say goodbye" says Serena with a sigh. "Have a good flight."
            "Thanks", replies Juan quietly. He gives her a hug. "Really, I don't know what I would do without you. Thanks for coming to the airport with me. You know how nervous I get before a flight."
            Serena forces a smile and hands him his coat "Here, don't forget this." She turns and starts to walk away.
            "Serena, can you hold on a few minutes? My flight isn't leaving just yet."
            Serena looks back. "I gotta go. I'm gonna be late for work." That wasn't quite true but she couldn't think of any other excuse to leave at that moment.
            "Please, I have something I have to say to you and it can't wait till I get back from my trip. Please!"
            "Ok, what is it? You've got two minutes" she says looking at her watch impatiently.</p>
            
            <p>"I wanted to wait until I got back but something tells me I have to do this now. I don't want to get back from California and realize that I'm too late and that I missed my chance." He reaches into his pocket and pulls out a ring. "I bought this for you 2 weeks ago. I've been carrying it around in my pocket waiting for the right time. This may not be the right time but I have to say it. I love you Serena and I want to marry you."
            "Will you marry me?" Juan continues "I understand if you need to think about it. And if the answer is no, I’ll understand that too. I know this is sudden and as I mentioned before, I had planned to tell you when I got back but all of a sudden I feel like... I just can't get on that plane without telling you how I feel."</p>
            
            <p>"YES!!" Serena screams in her head. "WHAT DO YOU THINK? I'VE BEEN IN LOVE WITH YOU SINCE I WAS 16!!"
            "Don't be silly!" says Serena shaking her head and smiling. "I'm not going to give you an answer here at the airport anyway. Just get on that plane and we'll talk when you get back, ok?"</p>
            
            <p>They give each other a long, tight hug. "I'm gonna fly back every weekend so we can hang out", Juan promises.
            "You better" Serena looks at him and laughs. "GO!! Or, you're gonna miss your flight."
            She laughs and wipes her tears with a tissue from her handbag. "I couldn't be better. I woke up this morning and had no idea that today, the man I have loved and pined for, for over 10 years would propose to me. I don’t think my life will ever be the same again."</p>
            
            <p>The cab driver smiles and nods. "That’s wonderful, Miss! We all have days that change our lives forever. For you, September 11, 2001 will be one of those days. So... where can I take you on this fine morning?"
            For those of you who are not aware of this, on the morning of September 11, 2001, at around 8am, two passenger planes took off from Logan Airport in Boston bound for Los Angeles. They were hijacked by terrorists and crashed into the World Trade Center in New York City. We don’t know if Juan was in one of those planes but either way, it will be a day to remember for Serena.</p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php 
include('foot.php');
?>
</div>

