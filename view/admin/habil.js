function habilitar(id){
	$.ajax({
		url : 'habil.php',
		type : 'POST',
		data : { id: id},
		})

	.done(function(resultado){
		$("#tblfull").html(resultado);
		console.log(resultado);
	})
}
$(document).on('clic', '#reha', function()
{
	var valorBusqueda=document.getElementById(idaprendiz).value;
	if (valorBusqueda!="")
	{
		habilitar(valorBusqueda);
	}
});
