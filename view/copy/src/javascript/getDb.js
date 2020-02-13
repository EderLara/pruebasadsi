var ROOT = document.getElementById('ROOT').value;
var FOLDER_ROOT = document.getElementById('FOLDER_ROOT').value;
/*Funcion para exportar la base de datos*/
document.getElementById('button').onclick = function(){
  /*Variables del formulario*/
  var extencion = document.getElementById('extencion').value;
  var formato   = document.getElementById('formato').value;
  var descargar = $("#down");
  if (descargar.prop('checked')) {
    var descargar = 'on';
  }else{
    var descargar = 'off';
  }
  /*Variable que sera enviada via POST*/
  var datos = 'extencion='+extencion+'&formato='+formato+'&down='+descargar;
  /*Donde se pondran los mensajes del sistema*/
  var destino = document.getElementById('respuesta');
  var retorno = '';
  /*Validar si el valor de extencion viene vacio*/
  if (extencion == 0) {
    retorno = '<div class="alert alert-dismissible alert-danger">';
    retorno += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    retorno += '<strong>¡Error!</strong> Por favor seleccione una extención para la exportación.</div>';
    destino.innerHTML = retorno;
    $(destino).show('fast');
  }else{
    var retorno = '<div class="progress progress-striped active">';
        retorno += '<div class="progress-bar" style="width: 100%"></div>';
        retorno += '</div>';
    /*Objeto XMLHTTP*/
    var connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

    connect.onreadystatechange = function(){
      destino.innerHTML = retorno;
      $(destino).show('fast');
      if (connect.readyState == 4 && connect.status == 200) {
        datos = connect.responseText;
        datos = JSON.parse(datos);
        var down = false;
        /*Si a elejido descargar una copia de la exportacion*/
        if (datos[2] == 'on') {
          window.location = FOLDER_ROOT + 'view/copy/src/php/down.php?download='+datos[0]+'&formato='+datos[1];
        }
        retorno = '<div class="alert alert-dismissible alert-success">';
        retorno += '<button type="button" class="close" data-dismiss="alert">x</button>';
        retorno += '<strong>¡Correcto!</strong> Se ha completado la exportación.</div>';
        destino.innerHTML = retorno;
      }
    }

    /*Enviar los datos*/
    connect.open('POST', FOLDER_ROOT + 'view/copy/src/php/getDb.php', true);
    connect.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    connect.send(datos);
  }
}
