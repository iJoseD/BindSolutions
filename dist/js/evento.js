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

// Agregar Punto de Venta
var agregarPuntoVenta = document.getElementById('agregarPuntoVenta')
agregarPuntoVenta.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id     = button.getAttribute('data-bs-id')
    var nombre = button.getAttribute('data-bs-nombre')

    var inputID     = agregarPuntoVenta.querySelector('#agregarPuntoVenta-idEvento')
    var inputNombre = agregarPuntoVenta.querySelector('#agregarPuntoVenta-nombreEvento')

    inputID.value     = id
    inputNombre.value = nombre
})
$('#addPuntos').click(function() {
    var idEvento  = $('#agregarPuntoVenta-idEvento').val();
    var lote      = $('#agregarPuntoVenta-Lote').val();
    var nombrePV  = $('#agregarPuntoVenta-Nombre').val();
    var cantMesas = $('#agregarPuntoVenta-cantMesas').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso      : 'addPuntos',
            idEvento  : idEvento,
            lote      : lote,
            nombre    : nombrePV,
            cantMesas : cantMesas
        },
        success: function(response) {
            console.log( response );

            if ( response == 'puntoVenta_not_created' ) {
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
            } else {
                $('.zonasVenta').html( response );
                $('#agregarPuntoVenta-Nombre').val('');
                $('#agregarPuntoVenta-cantMesas').val('');
            }
        },
        error: function() {
            console.log( 'ajax_crearProducto_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});
$('#btn-agregarPuntoVenta').click(function() {
    var lote = $('#agregarPuntoVenta-Lote').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso : 'agregarPuntoVenta',
            lote : lote
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
var editarPuntoV = document.getElementById('editarPuntoV')
editarPuntoV.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id       = button.getAttribute('data-bs-id')
    var nombre   = button.getAttribute('data-bs-nombre')
    var cantidad = button.getAttribute('data-bs-cantMesas')

    var inputID       = editarPuntoV.querySelector('#editarPuntoV-ID')
    var inputNombre   = editarPuntoV.querySelector('#editarPuntoV-Nombre')
    var inputCantidad = editarPuntoV.querySelector('#editarPuntoV-cantMesas')

    inputID.value = id
    inputNombre.value = nombre
    inputCantidad.value = cantidad
})
$('#btn-editarPuntoV').click(function() {
    var id        = $('#editarPuntoV-ID').val();
    var nombre    = $('#editarPuntoV-Nombre').val();
    var cantMesas = $('#editarPuntoV-cantMesas').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso         : 'editarPuntoV',
            idPuntoVenta : id,
            nombre       : nombre,
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
var eliminarPuntoV = document.getElementById('eliminarPuntoV')
eliminarPuntoV.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget
    
    var id     = button.getAttribute('data-bs-id');
    var nombre = button.getAttribute('data-bs-nombre');
    
    var inputID     = eliminarPuntoV.querySelector('#eliminarPuntoV-ID')
    var inputNombre = eliminarPuntoV.querySelector('#eliminarPuntoV .name')
    
    inputNombre.textContent = nombre
    inputID.value = id
})
$('#btn-eliminarPuntoV').click(function() {
    var idPuntoVenta = $('#eliminarPuntoV-ID').val();

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

// Mostrar cantidades disponibles
$('#agregarSubInventario-Producto').change(function() {
	var idEvento = $('#agregarSubInventario-IDevento').val();
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
        },
        error: function() {
            console.log( 'ajax_SubInventario-idProducto.change_error' );
        }
    });
});

// Agregar inventario a punto de venta
$('#agregarSubInventario-Producto').change(function() {
	$('#agregarSubInventario .alertaCantidad').addClass('hide');
});

var agregarSubInventario = document.getElementById('agregarSubInventario')
agregarSubInventario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var idEvento     = button.getAttribute('data-bs-idEvento')
    var idPuntoVenta = button.getAttribute('data-bs-idPuntoVenta')

    var inputIDEvento     = agregarSubInventario.querySelector('#agregarSubInventario-IDevento')
    var inputIDPuntoVenta = agregarSubInventario.querySelector('#agregarSubInventario-IDpuntoVenta')

    inputIDEvento.value     = idEvento
    inputIDPuntoVenta.value = idPuntoVenta
})
$('#addSubBodega').click(function() {
    var idPuntoVenta  = $('#agregarSubInventario-IDpuntoVenta').val();
    var idEvento      = $('#agregarSubInventario-IDevento').val();
    var lote          = $('#agregarSubInventario-Lote').val();
    var idProducto    = $('#agregarSubInventario-Producto').val();
    var cantidad      = $('#agregarSubInventario-Cantidad').val();
    var cantidadTotal = $('#agregarSubInventario .infoCantidades > div > p > span').html();

    if ( parseInt( cantidadTotal ) > parseInt( cantidad ) ) {
        $('#agregarSubInventario .alertaCantidad').addClass('hide');

        $.ajax({
            url: '/controller/eventos.php',
            type: 'POST',
            data: {
                caso         : 'addSubBodega',
                idPuntoVenta : idPuntoVenta,
                idEvento     : idEvento,
                lote         : lote,
                idProducto   : idProducto,
                cantidad     : cantidad
            },
            success: function(response) {
                console.log( response );
    
                if ( response == 'SubInventario_not_created' ) {
                    alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
                
                } else {
                    $('.addSubBodega').html( response );
                    $('#agregarSubInventario-Cantidad').val('');
                }
            },
            error: function() {
                console.log( 'ajax_crearProducto_error' );
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
            }
        });
    } else {
        $('#agregarSubInventario .alertaCantidad').removeClass('hide');
    }
});
$('#btn-agregarSubInventario').click(function() {
    var lote = $('#agregarSubInventario-Lote').val();

    $.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso : 'agregarSubInventario',
            lote : lote
        },
        success: function(response) {
            console.log( response );

            if ( response == 'agregarSubInventario_not_Update' ) {
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
var editarSubInventario = document.getElementById('editarSubInventario')
editarSubInventario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var idEvento   = button.getAttribute('data-bs-idEvento')
    var idProducto = button.getAttribute('data-bs-idProducto')
    var id         = button.getAttribute('data-bs-id')
    var nombre     = button.getAttribute('data-bs-nombre')
    var cantidad   = button.getAttribute('data-bs-cantidad')

    var inputID       = editarSubInventario.querySelector('#editarSubInventario-IDItem')
    var inputNombre   = editarSubInventario.querySelector('#editarSubInventario-Nombre')
    var inputCantidad = editarSubInventario.querySelector('#editarSubInventario-Cantidad')

    inputID.value       = id
    inputNombre.value   = nombre
    inputCantidad.value = cantidad

	$.ajax({
        url: '/controller/eventos.php',
        type: 'POST',
        data: {
            caso       : 'infoCantidades',
            idProducto : idProducto,
            idEvento   : idEvento
        },
        success: function(response) {
            $('#editarSubInventario .infoCantidades').html( response );
        },
        error: function() {
            console.log( 'ajax_SubInventario-idProducto.change_error' );
        }
    });
})
$('#btn-editarSubInventario').click(function() {
    var id            = $('#editarSubInventario-IDItem').val();
    var cantidad      = $('#editarSubInventario-Cantidad').val();
    var cantidadTotal = $('#editarSubInventario .infoCantidades > div > p > span').html();

    if ( parseInt( cantidadTotal ) > parseInt( cantidad ) ) {
        $('#editarSubInventario .alertaCantidad').addClass('hide');
        
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
    } else {
        $('#editarSubInventario .alertaCantidad').removeClass('hide');
    }
});

// Eliminar inventario
var eliminarSubInventario = document.getElementById('eliminarSubInventario')
eliminarSubInventario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget
    
    var id       = button.getAttribute('data-bs-id');
    var nombre   = button.getAttribute('data-bs-nombre');
    var nombrePV = button.getAttribute('data-bs-nombrePV');
    
    var inputID       = eliminarSubInventario.querySelector('#eliminarSubInventario-IDItem')
    var inputNombre   = eliminarSubInventario.querySelector('#eliminarSubInventario .product')
    var inputNombrePV = eliminarSubInventario.querySelector('#eliminarSubInventario .zona')
    
    inputNombrePV.textContent = nombrePV
    inputNombre.textContent = nombre
    inputID.value = id
})
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