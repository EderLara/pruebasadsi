$(result());

function result(dato)
{
	$.ajax({
		url : 'result.php',
		type : 'POST',
		data : { dato: dato},
		})

	.done(function(resultado){
		$("#tblfull").html(resultado);
		console.log(resultado);
	})
}
$(document).on('keyup', '#busca', function()
{
	var valorBusqueda=$(this).val();
	if (valorBusqueda!="")
	{
		result(valorBusqueda);
	}else{
        result();
    }
});
