function loguin(apz) {
    $.ajax({
            url: '../control/validate.php',
            type: 'POST',
            /*dataType : 'php',*/
            data: {
                apz: apz
            },
        })

        .done(function (resultado) {
            $("#acceso").html(resultado);
        })
}

$(document).on('keyup', '#aprendiz', function () {
    var valorBusqueda = $(this).val();
    if (valorBusqueda != "") {
        loguin(valorBusqueda);
    }
});

