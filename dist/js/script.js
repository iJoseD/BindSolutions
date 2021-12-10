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
    $('#tableusuarios').DataTable();
    $('#tableProductos').DataTable();
    $('#tableEventos').DataTable();
    $('#tablePuntosVenta').DataTable();

    $( ".datepicker" ).datepicker();
});

// |==============================|
// |========== USUARIOS ==========|
// |==============================|
// Crear usuario
$('#btn-crearUsuario').click(function() {
    var fullName    = $('#fullName').val();
    var user        = $('#user').val();
    var password    = $('#password').val();
    var rol         = $('#rol').val();

    $.ajax({
        url: '/controller/crearUsuario.php',
        type: 'POST',
        data: {
            caso     : 'crearUsuario',
            fullName : fullName,
            user     : user,
            password : password,
            rol      : rol
        },
        success: function(response) {
            console.log( response );

            if ( response == 'user_not_created' ) {
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
            console.log( 'ajax_crearUsuario_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});

// Editar usuario
$('.editarUsuario').click(function() {
    var fullName    = $(this).attr('data-fullName');
    var user        = $(this).attr('data-user');
    var password    = $(this).attr('data-password');
    var rol         = $(this).attr('data-rol');

    $('#edit-fullName').val(fullName);
    $('#edit-user').val(user);
    $('#edit-password').val(password);
    $('#edit-rol option[value="' + rol + '"]').attr("selected", "selected");
});
$('#btn-editarUsuario').click(function() {
    var fullName    = $('#edit-fullName').val();
    var user        = $('#edit-user').val();
    var password    = $('#edit-password').val();
    var rol         = $('#edit-rol').val();

    $.ajax({
        url: '/controller/crearUsuario.php',
        type: 'POST',
        data: {
            caso     : 'editarUsuario',
            fullName : fullName,
            user     : user,
            password : password,
            rol      : rol
        },
        success: function(response) {
            console.log( response );

            if ( response == 'user_not_created' ) {
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
            console.log( 'ajax_crearUsuario_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});

// Eliminar usuario
$('.eliminarUsuario').click(function() {
    var user = $(this).attr('data-user');
    
    $('#eliminarUsuario .user').html(user);
});
$('#btn-eliminarUsuario').click(function() {
    var user = $('#eliminarUsuario .user').html();

    $.ajax({
        url: '/controller/crearUsuario.php',
        type: 'POST',
        data: {
            caso     : 'eliminarUsuario',
            user     : user
        },
        success: function(response) {
            console.log( response );

            if ( response == 'user_not_created' ) {
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
            console.log( 'ajax_crearUsuario_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});

// |==============================|
// |========== PRODUCTOS =========|
// |==============================|
// Crear productos
$('#btn-crearProducto').click(function() {
    var nombre        = $('#nombre').val();
    var costo         = $('#costo').val();
    var precioPublico = $('#precioPublico').val();

    $.ajax({
        url: '/controller/crearProductos.php',
        type: 'POST',
        data: {
            caso          : 'crearProductos',
            nombre        : nombre,
            costo         : costo,
            precioPublico : precioPublico
        },
        success: function(response) {
            console.log( response );

            if ( response == 'product_not_created' ) {
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
            
            } else {
                // Agregar imagen a los productos

                var formData = new FormData();
                var files = $('#img--profile')[0].files[0];
                formData.append('file', files);
                $.ajax({
                    url: '/controller/uploadImgProfile.php',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if ( response == 'error_al_mover_archivo' ) {
                            console.log( response );
                        } else if ( response == 'error_formato_imagen' ) {
                            console.log( response );
                        } else if ( response == 'error_array_files' ) {
                            console.log( response );
                        } else {
                            $('.formulario').addClass('hide');
                            $('.successful-message').removeClass('hide');

                            window.setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    }
                });
                return false;
            }
        },
        error: function() {
            console.log( 'ajax_crearProducto_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});

// Editar producto
$('.editarProducto').click(function() {
    var id              = $(this).attr('data-id');
    var imagen          = $(this).attr('data-imagen');
    var nombre          = $(this).attr('data-nombre');
    var costo           = $(this).attr('data-costo');
    var precioPublico   = $(this).attr('data-precioPublico');

    $('#edit-id').val(id);
    $('.edit-card-img-top').attr('src', imagen);
    $('#edit-nombre').val(nombre);
    $('#edit-costo').val(costo);
    $('#edit-precioPublico').val(precioPublico);
});
$('#btn-editarProducto').click(function() {
    var id            = $('#edit-id').val();
    var nombre        = $('#edit-nombre').val();
    var nombre        = $('#edit-nombre').val();
    var costo         = $('#edit-costo').val();
    var precioPublico = $('#edit-precioPublico').val();

    $.ajax({
        url: '/controller/crearProductos.php',
        type: 'POST',
        data: {
            caso          : 'editarProducto',
            id            : id,
            nombre        : nombre,
            costo         : costo,
            precioPublico : precioPublico
        },
        success: function(response) {
            console.log( response );

            if ( response == 'product_not_edit' ) {
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

// Eliminar producto
$('.eliminarProducto').click(function() {
    var id      = $(this).attr('data-id');
    var nombre  = $(this).attr('data-nombre');
    
    $('#eliminarProducto .product').html(nombre);
    $('#delete-id').val(id);
});
$('#btn-eliminarProducto').click(function() {
    var id = $('#delete-id').val();

    $.ajax({
        url: '/controller/crearProductos.php',
        type: 'POST',
        data: {
            caso : 'eliminarProducto',
            id   : id
        },
        success: function(response) {
            console.log( response );

            if ( response == 'product_not_deleted' ) {
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

// |==============================|
// |========== EVENTOS ===========|
// |==============================|
// Crear eventos
$('#btn-crearEvento').click(function() {
    var nombre       = $('#nombre').val();
    var fecha        = $('#fecha').val();
    var lugar        = $('#lugar').val();
    var codigoEvento = $('#codigoEvento').val();

    $.ajax({
        url: '/controller/crearEvento.php',
        type: 'POST',
        data: {
            caso         : 'crearEvento',
            nombre       : nombre,
            fecha        : fecha,
            lugar        : lugar,
            codigoEvento : codigoEvento
        },
        success: function(response) {
            console.log( response );

            if ( response == 'event_not_created' ) {
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

// Editar evento
$('.editarEvento').click(function() {
    var id           = $(this).attr('data-id');
    var nombre       = $(this).attr('data-nombre');
    var fecha        = $(this).attr('data-fecha');
    var lugar        = $(this).attr('data-lugar');
    var codigoEvento = $(this).attr('data-codigoEvento');

    $('#edit-id').val(id);
    $('#edit-nombre').val(nombre);
    $('#edit-fecha').val(fecha);
    $('#edit-lugar').val(lugar);
    $('#edit-codigoEvento').val(codigoEvento);
});
$('#btn-editarEvento').click(function() {
    var id           = $('#edit-id').val();
    var nombre       = $('#edit-nombre').val();
    var fecha        = $('#edit-fecha').val();
    var lugar        = $('#edit-lugar').val();
    var codigoEvento = $('#edit-codigoEvento').val();

    $.ajax({
        url: '/controller/crearEvento.php',
        type: 'POST',
        data: {
            caso         : 'editarEvento',
            id           : id,
            nombre       : nombre,
            fecha        : fecha,
            lugar        : lugar,
            codigoEvento : codigoEvento
        },
        success: function(response) {
            console.log( response );

            if ( response == 'event_not_edit' ) {
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

// Eliminar producto
$('.eliminarEvento').click(function() {
    var id     = $(this).attr('data-id');
    var nombre = $(this).attr('data-nombre');
    
    $('#eliminarEvento .event').html(nombre);
    $('#delete-id').val(id);
});
$('#btn-eliminarEvento').click(function() {
    var id = $('#delete-id').val();

    $.ajax({
        url: '/controller/crearEvento.php',
        type: 'POST',
        data: {
            caso : 'eliminarEvento',
            id   : id
        },
        success: function(response) {
            console.log( response );

            if ( response == 'event_not_deleted' ) {
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
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
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
                $('.successful-message').removeClass('hide');
                $('#cantidad').val('');

                window.setTimeout(function() {
                    $('.successful-message').addClass('hide');
                }, 5000);
            }
        },
        error: function() {
            console.log( 'ajax_crearProducto_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
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
    var nombrePV = $('#nombrePV').val();
    var idEvento = $('#idEvento').val();

    $.ajax({
        url: '/controller/crearEvento.php',
        type: 'POST',
        data: {
            caso     : 'agregarPuntoVenta',
            nombrePV : nombrePV,
            idEvento : idEvento
        },
        success: function(response) {
            console.log( response );

            if ( response == 'puntoVenta_not_created' ) {
                alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
            
            } else {
                $('.formulario').addClass('hide');
                $('.successful-message').removeClass('hide');

                window.setTimeout(function() {
                    $('.successful-message').addClass('hide');
                    $('.sub-inventario').removeClass('hide');
                }, 3000);
            }
        },
        error: function() {
            console.log( 'ajax_crearProducto_error' );
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