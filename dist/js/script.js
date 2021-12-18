// Iniciar sesión
$('#btn-iniciarSesion').click(function() {
    var user = $('#user').val();
    var password = $('#password').val();

    $.ajax({
        url: '/controller/iniciarSesion.php',
        type: 'POST',
        data: {
            caso     : 'iniciarSesion',
            user     : user,
            password : password
        },
        success: function(response) {
            console.log( response );

            if ( response == 'user_not_exist' ) {
                alert( 'El usuario ' + user + ' no existe en la base de datos.' );
            
            } else if ( response == 'password_incorrect' ) {
                alert( 'Contraseña incorrecta, intente de nuevo.' );
            
            } else if ( response == 'login_failed' ) {
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
            
            } else {
                window.location.href = '/';
            }
        },
        error: function() {
            console.log( 'ajax_iniciarSesion_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});

// Cargar tablas
$(document).ready(function () {
    $('.DataTable').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json" },
        responsive: true
    });
    $('#evento-table3').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json" },
        responsive: true,
        searchPanes: {
            layout: 'columns-2',
            cascadePanes: true,
            viewTotal: false
        },
        dom: 'PBfrtip',
        columnDefs: [
            {
                searchPanes: {
                    show: true
                },
                targets: [0, 2]
            },
            {
                searchPanes: {
                    show: false
                },
                targets: [1, 3, 4]
            }
        ],
    });

    $( ".datepicker" ).datepicker();
});

// |==============================|
// |========== EVENTO ============|
// |==============================|
// Mostrar precios
$('#idProducto').change(function() {
	var idProducto = $(this).val();

	$.ajax({
        url: '/controller/crearEvento.php',
        type: 'POST',
        data: {
            caso       : 'mostrarPrecios',
            idProducto : idProducto
        },
        success: function(response) {
            $('.tablePrecios').html( response );
            $('.tablePrecios').removeClass('hide');
        },
        error: function() {
            console.log( 'ajax_idProducto.change_error' );
        }
    });
});

// Agregar inventario
$('.agregarInventario').click(function() {
    var id     = $(this).attr('data-id');
    var nombre = $(this).attr('data-nombre');
    
    $('#nombreEvento').val(nombre);
    $('#idEvento').val(id);
});
$('#btn-agregarInventario').click(function() {
    var idEvento   = $('#idEvento').val();
    var idProducto = $('#idProducto').val();
    var cantidad   = $('#cantidad').val();

    $.ajax({
        url: '/controller/crearEvento.php',
        type: 'POST',
        data: {
            caso       : 'agregarInventario',
            idEvento   : idEvento,
            idProducto : idProducto,
            cantidad   : cantidad,
        },
        success: function(response) {
            console.log( response );

            if ( response == 'inventario_not_created' ) {
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

    var inputID = editarInventario.querySelector('#idInventario')
    var inputNombre = editarInventario.querySelector('#ei-nombre')
    var inputCantidad = editarInventario.querySelector('#ei-cantidad')

    inputID.value = id
    inputNombre.value = nombre
    inputCantidad.value = cantidad
})
$('#btn-editarInventario').click(function() {
    var idInventario = $('#idInventario').val();
    var cantidad     = $('#ei-cantidad').val();

    $.ajax({
        url: '/controller/crearEvento.php',
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
$('.eliminarInventario').click(function() {
    var id     = $(this).attr('data-id');
    var nombre = $(this).attr('data-nombre');
    
    $('#eliminarInventario .product').html(nombre);
    $('#delete-idInventario').val(id);
});
$('#btn-eliminarInventario').click(function() {
    var idInventario = $('#delete-idInventario').val();

    $.ajax({
        url: '/controller/crearEvento.php',
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
        url: '/controller/crearEvento.php',
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
        url: '/controller/crearEvento.php',
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
        url: '/controller/crearEvento.php',
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
        url: '/controller/crearEvento.php',
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
                    url: '/controller/crearEvento.php',
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
        url: '/controller/crearEvento.php',
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
        url: '/controller/crearEvento.php',
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
        url: '/controller/crearEvento.php',
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

// Separador de miles
function separadorMiles(donde, caracter) {
    pat = /[\*,\+,\(,\),\?,\\,\$,\[,\],\^]/
    valor = donde.value
    largo = valor.length
    crtr = true
    if (isNaN(caracter) || pat.test(caracter) == true) {
        if (pat.test(caracter) == true) {
            caracter = "\\" + caracter
        }
        carcter = new RegExp(caracter, "g")
        valor = valor.replace(carcter, "")
        donde.value = valor
        crtr = false
    } else {
        var nums = new Array()
        cont = 0
        for (m = 0; m < largo; m++) {
            if (valor.charAt(m) == "." || valor.charAt(m) == " ") {
                continue;
            } else {
                nums[cont] = valor.charAt(m)
                cont++
            }

        }
    }

	var cad1 = "", cad2 = "", tres = 0
    if (largo > 3 && crtr == true) {
        for (k = nums.length - 1; k >= 0; k--) {
            cad1 = nums[k]
            cad2 = cad1 + cad2
            tres++
            if ((tres % 3) == 0) {
                if (k != 0) {
                    cad2 = "." + cad2
                }
            }
        }
        donde.value = cad2
    }
}

// Solo números
$('#cantidad, #agregarPuntoVenta-cantMesas, #ei-cantidad, #editarPuntoV-cantMesas, #SubInventario-Cantidad, #editarSubInventario-Cantidad').bind('keypress', function(event) {
    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});