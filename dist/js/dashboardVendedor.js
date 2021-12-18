$('#nuevaVenta-idProducto').change(function() {
	$('.alertaCantidad').addClass('hide');
});
// Crear pre-orden
$('.nuevaVenta').click(function() {
    var idUser       = $(this).attr('data-idUser');
    var idEvento     = $(this).attr('data-idEvento');
    var idPuntoVenta = $(this).attr('data-idPuntoVenta');
    
    $('#nuevaVenta-idUser').val(idUser);
    $('#nuevaVenta-idEvento').val(idEvento);
    $('#nuevaVenta-idPuntoVenta').val(idPuntoVenta);
});
$('#addCart').click(function() {
    var idUser        = $('#nuevaVenta-idUser').val();
    var idEvento      = $('#nuevaVenta-idEvento').val();
    var idPuntoVenta  = $('#nuevaVenta-idPuntoVenta').val();
    var codeFac       = $('#nuevaVenta-codeFac').val();
    var idProducto    = $('#nuevaVenta-idProducto').val();
    var cantidad      = $('#nuevaVenta-cantidad').val();
    var cantidadTotal = $('#nuevaVenta-idProducto option:selected').attr('data-cantidad');

    if ( parseInt( cantidadTotal ) > parseInt( cantidad ) ) {
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
                }
            },
            error: function() {
                console.log( 'ajax_crearProducto_error' );
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
            }
        });
    } else {
        $('.alertaCantidad').removeClass('hide');
    }
});
// Confirmar la venta
$('#btn-nuevaVenta').click(function() {
    var codeFac = $('#nuevaVenta-codeFac').val();

    $.ajax({
        url: '/controller/ventas.php',
        type: 'POST',
        data: {
            caso    : 'finalizarPedido',
            codeFac : codeFac,
            status  : 'approved'
        },
        success: function(response) {
            console.log( response );

            var totalFactura = $('.totalFactura').attr('data-totalFactura');
            $.ajax({
                url: '/controller/ventas.php',
                type: 'POST',
                data: {
                    caso         : 'totalFactura',
                    codeFac      : codeFac,
                    totalFactura : totalFactura
                },
                success: function(response) {
                    console.log( response );
        
                    if ( response == 'totalFactura_not_Update' ) {
                        alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
                    
                    } else {
                        $('.formulario').addClass('hide');
                        $('.successful-message').removeClass('hide');
        
                        window.setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                },
                error: function() {
                    console.log( 'ajax_crearProducto_error' );
                    alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
                }
            });
        },
        error: function() {
            console.log( 'ajax_crearProducto_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});

// Ver la factura
$('.verFactura').click(function() {
    var codeFac = $(this).attr('data-codeFac');
    
    $('#verFactura .codeFac').html(codeFac);

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
});