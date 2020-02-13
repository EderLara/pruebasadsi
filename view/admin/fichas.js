function fichaimp(ficha)
{
	$.ajax({
		url : 'fichas.php',
		type : 'POST',
		data : { ficha: ficha },
		})

	.done(function(resultado){
		$("#tblficha").html(resultado);
		console.log(resultado);
	})
}
$(document).on('keyup', '#fichab', function()
{
	var valorBusqueda=$(this).val();
	if (valorBusqueda!="")
	{
		fichaimp(valorBusqueda);
	}
});
