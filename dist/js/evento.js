// Agregar inventario
var agregarInventario = document.getElementById('agregarInventario')
agregarInventario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id     = button.getAttribute('data-bs-id')
    var nombre = button.getAttribute('data-bs-nombre')

    var inputID     = agregarInventario.querySelector('#agregarInventario-idEvento')
    var inputNombre = agregarInventario.querySelector('#agregarInventario-nombreEvento')

    inputID.value     = id
    inputNombre.value = nombre
})
$('#addBodega').click(function() {
    var idEvento   = $('#agregarInventario-idEvento').val();
    var lote       = $('#agregarInventario-Lote').val();
    var idProducto = $('#agregarInventario-Producto').val();
    var cantidad   = $('#agregarInventario-Cantidad').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso       : 'addBodega',
            idEvento   : idEvento,
            lote       : lote,
            idProducto : idProducto,
            cantidad   : cantidad,
        },
        success: function(response) {
            console.log( response );

            if ( response == 'inventario_not_created' ) {
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
            } else {
                $('.productosAgregados').html( response );
                $('#agregarInventario-Cantidad').val('');
            }
        },
        error: function() {
            console.log( 'ajax_addBodega_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});
$('#btn-agregarInventario').click(function() {
    var lote = $('#agregarInventario-Lote').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso : 'agregarInventario',
            lote : lote
        },
        success: function(response) {
            console.log( response );

            if ( response == 'agregarInventario_not_Update' ) {
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
});

// Editar inventario
var editarInventario = document.getElementById('editarInventario')
editarInventario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id = button.getAttribute('data-bs-id')
    var nombre = button.getAttribute('data-bs-nombre')
    var cantidad = button.getAttribute('data-bs-cantidad')

    var inputID = editarInventario.querySelector('#editarInventario-idInventario')
    var inputNombre = editarInventario.querySelector('#editarInventario-Nombre')
    var inputCantidad = editarInventario.querySelector('#editarInventario-Cantidad')

    inputID.value = id
    inputNombre.value = nombre
    inputCantidad.value = cantidad
})
$('#btn-editarInventario').click(function() {
    var idInventario = $('#editarInventario-idInventario').val();
    var cantidad     = $('#editarInventario-Cantidad').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso         : 'editarInventario',
            idInventario : idInventario,
            cantidad     : cantidad
        },
        success: function(response) {
            console.log( response );

            if ( response == 'editarInventario_not_UPDATE' ) {
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
});

// Eliminar inventario
var eliminarInventario = document.getElementById('eliminarInventario')
eliminarInventario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget
    
    var id     = button.getAttribute('data-bs-id');
    var nombre = button.getAttribute('data-bs-nombre');
    
    var inputID     = eliminarInventario.querySelector('#eliminarInventario-idInventario')
    var inputNombre = eliminarInventario.querySelector('#eliminarInventario .product')
    
    inputNombre.textContent = nombre
    inputID.value = id
})
$('#btn-eliminarInventario').click(function() {
    var idInventario = $('#eliminarInventario-idInventario').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso         : 'eliminarInventario',
            idInventario : idInventario
        },
        success: function(response) {
            console.log( response );

            if ( response == 'eliminarInventario_not_DELETE' ) {
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
            console.log( 'ajax_eliminarProducto_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});

// Mostrar cantidades disponibles
$('#SubInventario-idProducto').change(function() {
	var idEvento = $('#pv-IDEvento-Sub').val();
    var idProducto = $(this).val();

	$.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso       : 'infoCantidades',
            idProducto : idProducto,
            idEvento   : idEvento
        },
        success: function(response) {
            $('.infoCantidades').html( response );
            $('.infoCantidades').removeClass('hide');
        },
        error: function() {
            console.log( 'ajax_SubInventario-idProducto.change_error' );
        }
    });
});

// Agregar Punto de Venta
$('.agregarPuntoVenta').click(function() {
    var id     = $(this).attr('data-id');
    var nombre = $(this).attr('data-nombre');
    
    $('#pv-nombreEvento').val(nombre);
    $('#pv-idEvento').val(id);
});
$('#btn-agregarPuntoVenta').click(function() {
    var nombrePV  = $('#nombrePV').val();
    var cantMesas = $('#agregarPuntoVenta-cantMesas').val();
    var idEvento  = $('#pv-idEvento').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso      : 'agregarPuntoVenta',
            nombrePV  : nombrePV,
            cantMesas : cantMesas,
            idEvento  : idEvento
        },
        success: function(response) {
            console.log( response );

            if ( response == 'puntoVenta_not_created' ) {
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
});
// Editar punto de venta
$('.editarPuntoV').click(function() {
    var id        = $(this).attr('data-id');
    var nombre    = $(this).attr('data-nombre');
    var cantMesas = $(this).attr('data-cantMesas');
    
    $('#editarPuntoV-IDPuntoV').val(id);
    $('#editarPuntoV-nombrePV').val(nombre);
    $('#editarPuntoV-cantMesas').val(cantMesas);
});
$('#btn-editarPuntoV').click(function() {
    var idPuntoVenta  = $('#editarPuntoV-IDPuntoV').val();
    var nombrePV      = $('#editarPuntoV-nombrePV').val();
    var cantMesas     = $('#editarPuntoV-cantMesas').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso         : 'editarPuntoV',
            idPuntoVenta : idPuntoVenta,
            nombrePV     : nombrePV,
            cantMesas    : cantMesas
        },
        success: function(response) {
            console.log( response );

            if ( response == 'editarPuntoV_not_UPDATE' ) {
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
});
// Eliminar punto de venta
$('.eliminarPuntoV').click(function() {
    var id     = $(this).attr('data-id');
    var nombre = $(this).attr('data-nombre');
    
    $('#eliminarPuntoV-IDPuntoV').val(id);
    $('#eliminarPuntoV .name').html(nombre);
});
$('#btn-eliminarPuntoV').click(function() {
    var idPuntoVenta = $('#eliminarPuntoV-IDPuntoV').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso         : 'eliminarPuntoV',
            idPuntoVenta : idPuntoVenta
        },
        success: function(response) {
            console.log( response );

            if ( response == 'eliminarPuntoV_not_UPDATE' ) {
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
            
            } else {
                $.ajax({
                    url: '/controller/eventos.php',
                    type: 'POST',
                    data: {
                        caso         : 'eliminarPuntoV2',
                        idPuntoVenta : idPuntoVenta
                    },
                    success: function(response) {
                        console.log( response );
            
                        if ( response == 'eliminarPuntoV_not_UPDATE' ) {
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
            }
        },
        error: function() {
            console.log( 'ajax_crearProducto_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});

// Agregar Sub-inventario punto de venta
$('.agregarSubInventario').click(function() {
    var idEvento = $(this).attr('data-idEvento');
    var idPV     = $(this).attr('data-idPV');
    
    $('#pv-IDEvento-Sub').val(idEvento);
    $('#pv-IDPV').val(idPV);
});
$('#btn-agregarSubInventario').click(function() {
    var idPuntoVenta = $('#pv-IDPV').val();
    var idEvento = $('#pv-IDEvento-Sub').val();
    var idProducto = $('#SubInventario-idProducto').val();
    var cantidad = $('#SubInventario-Cantidad').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso         : 'agregarSubInventario',
            idPuntoVenta : idPuntoVenta,
            idEvento     : idEvento,
            idProducto   : idProducto,
            cantidad     : cantidad
        },
        success: function(response) {
            console.log( response );

            if ( response == 'SubInventario_not_created' ) {
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
});
// Editar inventario
$('.editarSubInventario').click(function() {
    var id       = $(this).attr('data-id');
    var nombre   = $(this).attr('data-nombre');
    var cantidad = $(this).attr('data-cantidad');
    
    $('#editarSubInventario-IDItem').val(id);
    $('#editarSubInventario-Nombre').val(nombre);
    $('#editarSubInventario-Cantidad').val(cantidad);
});
$('#btn-editarSubInventario').click(function() {
    var id = $('#editarSubInventario-IDItem').val();
    var cantidad = $('#editarSubInventario-Cantidad').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso         : 'editarSubInventario',
            idInventario : id,
            cantidad     : cantidad
        },
        success: function(response) {
            console.log( response );

            if ( response == 'editarSubInventario_not_UPDATE' ) {
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
});
// Eliminar inventario
$('.eliminarSubInventario').click(function() {
    var id     = $(this).attr('data-id');
    var nombre = $(this).attr('data-nombre');
    
    $('#eliminarSubInventario .product').html(nombre);
    $('#eliminarSubInventario-IDItem').val(id);
});
$('#btn-eliminarSubInventario').click(function() {
    var idInventario = $('#eliminarSubInventario-IDItem').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso         : 'eliminarSubInventario',
            idInventario : idInventario
        },
        success: function(response) {
            console.log( response );

            if ( response == 'eliminarSubInventario_not_DELETE' ) {
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
            console.log( 'ajax_eliminarProducto_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});