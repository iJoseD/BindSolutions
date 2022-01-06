$('#nuevaVenta-idProducto').change(function() {
	$('.alertaCantidad').addClass('hide');
});

// Mostrar cantidades disponibles
$('#nuevaVenta-idProducto').change(function() {
	var idEvento     = $('#nuevaVenta-idEvento').val();
    var idPuntoVenta = $('#nuevaVenta-idPuntoVenta').val();
    var idProducto   = $(this).val();

	$.ajax({
        url: '/controller/ventas.php',
        type: 'POST',
        data: {
            caso         : 'infoCantidades',
            idProducto   : idProducto,
            idPuntoVenta : idPuntoVenta,
            idEvento     : idEvento
        },
        success: function(response) {
            $('#nuevaVenta .infoCantidades').html( response );
        },
        error: function() {
            console.log( 'ajax_SubInventario-idProducto.change_error' );
        }
    });
});

// Venta de cortesia
$('.ventaCortesia').click(function() {
    var ventaCortesia = $(this).attr('data-cortesia');

    if ( ventaCortesia == 'Si' ) {
        $('#nuevaVenta-ventaCortesia').val('Cortesia');
    } else {
        $('#nuevaVenta-ventaCortesia').val('Legal');
    }

    $('.cortesia').addClass('hide');
    $('.formulario').removeClass('hide');
});

// Crear pre-orden
var nuevaVenta = document.getElementById('nuevaVenta')
nuevaVenta.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var idUser       = button.getAttribute('data-bs-idUser')
    var idEvento     = button.getAttribute('data-bs-idEvento')
    var idPuntoVenta = button.getAttribute('data-bs-idPuntoVenta')

    var inputidUser       = nuevaVenta.querySelector('#nuevaVenta-idUser')
    var inputidEvento     = nuevaVenta.querySelector('#nuevaVenta-idEvento')
    var inputidPuntoVenta = nuevaVenta.querySelector('#nuevaVenta-idPuntoVenta')

    inputidUser.value       = idUser
    inputidEvento.value     = idEvento
    inputidPuntoVenta.value = idPuntoVenta
})
$('#addCart').click(function() {
    var idUser        = $('#nuevaVenta-idUser').val();
    var idEvento      = $('#nuevaVenta-idEvento').val();
    var idPuntoVenta  = $('#nuevaVenta-idPuntoVenta').val();
    var codeFac       = $('#nuevaVenta-codeFac').val();
    var tipoVenta     = $('#nuevaVenta-ventaCortesia').val();
    var mesa          = $('#nuevaVenta-Mesa').val();
    var mesero        = $('#nuevaVenta-Mesero').val();
    var idProducto    = $('#nuevaVenta-idProducto').val();
    var cantidad      = $('#nuevaVenta-cantidad').val();
    var cantidadTotal = $('#nuevaVenta-idProducto option:selected').attr('data-cantidad');

    if ( parseInt( cantidadTotal ) >= parseInt( cantidad ) ) {
        $('.alertaCantidad').addClass('hide');

        $.ajax({
            url: '/controller/ventas.php',
            type: 'POST',
            data: {
                caso         : 'nuevaVenta',
                idUser       : idUser,
                idEvento     : idEvento,
                idPuntoVenta : idPuntoVenta,
                codeFac      : codeFac,
                tipoVenta    : tipoVenta,
                mesa         : mesa,
                mesero       : mesero,
                idProducto   : idProducto,
                cantidad     : cantidad,
                status       : 'pending'
            },
            success: function(response) {
                console.log( response );

                if ( response == 'nuevaVenta_not_created' ) {
                    alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );

                } else {
                    $('.preOrden').html( response );
                    $('#nuevaVenta-cantidad').val('');

                    $('#btn-nuevaVenta').removeAttr('disabled');
                    $('#nuevaVenta .cerrarModal').addClass('hide');
                }
            },
            error: function() {
                console.log( 'ajax_nuevaVenta_error' );
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
            }
        });
    } else {
        $('.alertaCantidad').removeClass('hide');
    }
});
$('#btn-nuevaVenta').click(function() {
    var totalFactura = $('.totalFactura').attr('data-totalFactura');
    var idEvento     = $('#nuevaVenta-idEvento').val();
    var idPuntoVenta = $('#nuevaVenta-idPuntoVenta').val();
    var codeFac      = $('#nuevaVenta-codeFac').val();
    var tipoVenta    = $('#nuevaVenta-ventaCortesia').val();
    var mesa         = $('#nuevaVenta-Mesa').val();
    var mesero       = $('#nuevaVenta-Mesero').val();

    // finalizarPedido
    $.ajax({
        url: '/controller/ventas.php',
        type: 'POST',
        data: {
            caso    : 'finalizarPedido',
            codeFac : codeFac,
            status  : 'approved'
        },
        success: function(response) {
            
            // totalFactura
            $.ajax({
                url: '/controller/ventas.php',
                type: 'POST',
                data: {
                    caso         : 'totalFactura',
                    codeFac      : codeFac,
                    tipoVenta    : tipoVenta,
                    totalFactura : totalFactura
                },
                success: function(response) {
                    if ( response == 'totalFactura_not_created' ) {
                        alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
                    } else {

                        // totalFacturaPV
                        $.ajax({
                            url: '/controller/ventas.php',
                            type: 'POST',
                            data: {
                                caso         : 'totalFacturaPV',
                                idEvento     : idEvento,
                                idPuntoVenta : idPuntoVenta,
                                tipoVenta    : tipoVenta,
                                totalFactura : totalFactura
                            },
                            success: function(response) {
                                if ( response == 'totalFacturaPV_not_created' || response == 'totalFacturaPV_not_Update' ) {
                                    alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
                                } else {

                                    // totalFacturaUsers
                                    $.ajax({
                                        url: '/controller/ventas.php',
                                        type: 'POST',
                                        data: {
                                            caso         : 'totalFacturaUsers',
                                            idEvento     : idEvento,
                                            idPuntoVenta : idPuntoVenta,
                                            mesero       : mesero,
                                            tipoVenta    : tipoVenta,
                                            totalFactura : totalFactura
                                        },
                                        success: function(response) {
                                            console.log( response );
                        
                                            if ( response == 'totalFacturaUsers_not_created' || response == 'totalFacturaUsers_not_Update' ) {
                                                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
                                            } else {

                                                // totalFacturaMesa
                                                $.ajax({
                                                    url: '/controller/ventas.php',
                                                    type: 'POST',
                                                    data: {
                                                        caso         : 'totalFacturaMesa',
                                                        idEvento     : idEvento,
                                                        idPuntoVenta : idPuntoVenta,
                                                        mesa         : mesa,
                                                        tipoVenta    : tipoVenta,
                                                        totalFactura : totalFactura,
                                                        codeFac      : codeFac,
                                                        mesero       : mesero
                                                    },
                                                    success: function(response) {
                                                        console.log( response );
                                    
                                                        if ( response == 'totalFacturaMesa_not_created' || response == 'totalFacturaMesa_not_Update' ) {
                                                            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
                                                        } else {
                                                            $('.formulario').addClass('hide');
                                                            $('.successful-message').removeClass('hide');

                                                            $('#DivIdToPrint').html( response );
                                    
                                                            window.setTimeout(function() {
                                                                var contents = $("#DivIdToPrint").html();
                                                                var frame1 = $('<iframe />');
                                                                frame1[0].name = "frame1";
                                                                frame1.css({
                                                                    "position": "absolute",
                                                                    "top": "-1000000px"
                                                                });
                                                                $("body").append(frame1);
                                                                var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
                                                                frameDoc.document.open();
                                                                frameDoc.document.write('<html><head><title>DIV Contents</title>');
                                                                frameDoc.document.write('</head><body>');
                                                                frameDoc.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">');
                                                                frameDoc.document.write(contents);
                                                                frameDoc.document.write('</body></html>');
                                                                frameDoc.document.close();
                                                                setTimeout(function() {
                                                                    window.frames["frame1"].focus();
                                                                    window.frames["frame1"].print();
                                                                    frame1.remove();
                                                                }, 500);
                                                            }, 1000);

                                                            $(this).hide();
                                                            $('.reloadPage').removeClass('hide');
                                                        }
                                                    },
                                                    error: function() {
                                                        console.log( 'ajax_totalFacturaMesa_error' );
                                                        alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
                                                    }
                                                });
                                            }
                                        },
                                        error: function() {
                                            console.log( 'ajax_totalFacturaUsers_error' );
                                            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
                                        }
                                    });
                                }
                            },
                            error: function() {
                                console.log( 'ajax_totalFacturaPV_error' );
                                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
                            }
                        });
                    }
                },
                error: function() {
                    console.log( 'ajax_totalFactura_error' );
                    alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
                }
            });
        },
        error: function() {
            console.log( 'ajax_finalizarPedido_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});
$('.reloadPage').click(function() {
    location.reload();
});

// Ver la factura
var verFactura = document.getElementById('verFactura')
verFactura.addEventListener('show.bs.modal', function (event) {
    var button       = event.relatedTarget
    var codeFac      = button.getAttribute('data-bs-codeFac')
    var inputCodeFac = verFactura.querySelector('#verFactura .codeFac')

    inputCodeFac.textContent = codeFac

    $.ajax({
        url: '/controller/ventas.php',
        type: 'POST',
        data: {
            caso    : 'verFactura',
            codeFac : codeFac
        },
        success: function(response) {
            console.log( response );

            if ( response == 'verFactura_not_Select' ) {
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );

            } else {
                $('.detalleFactura').html( response );
            }
        },
        error: function() {
            console.log( 'ajax_verFactura_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
})

// Ver la factura
var editarFactura = document.getElementById('editarFactura')
editarFactura.addEventListener('show.bs.modal', function (event) {
    var button       = event.relatedTarget
    var codeFac      = button.getAttribute('data-bs-codeFac')
    var inputCodeFac = editarFactura.querySelector('#editarFactura .codeFac')

    inputCodeFac.textContent = codeFac
})
$('#validarPin').click(function() {
    var pin = $('#editarFactura-Pin').val();
    var codeFac = $('#editarFactura .codeFac').html();

    if ( pin == '5673' ) {
        $.ajax({
            url: '/controller/ventas.php',
            type: 'POST',
            data: {
                caso    : 'editarFactura',
                pin     : pin,
                codeFac : codeFac
            },
            success: function(response) {
                console.log( response );

                if ( response == 'editarFactura_not_Select' ) {
                    alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );

                } else {
                    $('#editarFactura .data').html( response );

                    $('.pin').addClass('hide');
                    $('.detalleFactura').removeClass('hide');

                    // eliminar Item Factura
                    $('.eliminarItemFactura').click(function () {
                        var id     = $(this).attr('data-id');
                        var nombre = $(this).attr('data-nombre');

                        $('#editarFactura .producto').html( nombre );
                        $('.eliminarItem-Continuar').attr('data-id', id);

                        $('.eliminarItem').removeClass('hide');
                    });
                }
            },
            error: function() {
                console.log( 'ajax_editarFactura_error' );
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
            }
        });
    } else {
        alert( 'Pin incorrecto. Intente de nuevo.' );
    }
});
$('.eliminarItem-Continuar').click(function() {
    var id = $(this).attr('data-id');

    $.ajax({
        url: '/controller/ventas.php',
        type: 'POST',
        data: {
            caso        : 'eliminarItem',
            idItemVenta : id
        },
        success: function(response) {
            console.log( response );

            if ( response == 'eliminarItem_not_Delete' ) {
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );

            } else {
                $('.alerta').removeClass('hide');
            }
        },
        error: function() {
            console.log( 'ajax_eliminarItem_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});

function printDiv() {
    var contents = $("#DivIdToPrint").html();
    var frame1 = $('<iframe />');
    frame1[0].name = "frame1";
    frame1.css({
        "position": "absolute",
        "top": "-1000000px"
    });
    $("body").append(frame1);
    var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
    frameDoc.document.open();
    frameDoc.document.write('<html><head><title>DIV Contents</title>');
    frameDoc.document.write('</head><body>');
    frameDoc.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">');
    frameDoc.document.write(contents);
    frameDoc.document.write('</body></html>');
    frameDoc.document.close();
    setTimeout(function() {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        frame1.remove();
    }, 500);
}