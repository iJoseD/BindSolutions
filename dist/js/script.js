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
        searchPanes: {
            layout: 'columns-4',
            cascadePanes: true,
            viewTotal: false
        },
        dom: 'PBfrtip',
        columnDefs: [
            {
                searchPanes: {
                    show: true
                },
                targets: [0, 1, 2, 3]
            },
            {
                searchPanes: {
                    show: false
                },
                targets: [4, 5, 6, 7]
            }
        ],
    });

    $( ".datepicker" ).datepicker();
});

// |==============================|
// |========== USUARIOS ==========|
// |==============================|
// Crear usuario
$('#btn-crearUsuario').click(function() {
    var fullName     = $('#fullName').val();
    var user         = $('#user').val();
    var password     = $('#password').val();
    var rol          = $('#rol').val();
    var idEvento     = $('#crearUsuario-SelectEvento').val();
    var idPuntoVenta = $('#crearUsuario-SelectPV').val();

    $.ajax({
        url: '/controller/crearUsuario.php',
        type: 'POST',
        data: {
            caso         : 'crearUsuario',
            fullName     : fullName,
            user         : user,
            password     : password,
            rol          : rol,
            idEvento     : idEvento,
            idPuntoVenta : idPuntoVenta
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
// Mostrar eventos
$('#rol').change(function() {
	var rol = $(this).val();

	if ( rol == 2 ) {
        $('.asignarEvento').removeClass('hide');
    } else {
        $('.asignarEvento').addClass('hide');
    }
});
// Mostrar puntos de venta
$('#crearUsuario-SelectEvento').change(function() {
	var evento = $(this).val();

	$.ajax({
        url: '/controller/crearUsuario.php',
        type: 'POST',
        data: {
            caso     : 'SelectPuntoVenta',
            idEvento : evento
        },
        success: function(response) {
            $('#crearUsuario-SelectPV').html( response );
        },
        error: function() {
            console.log( 'ajax_SelectPuntoVenta.change_error' );
        }
    });
});

// Editar usuario
$('.editarUsuario').click(function() {
    var fullName     = $(this).attr('data-fullName');
    var user         = $(this).attr('data-user');
    var password     = $(this).attr('data-password');
    var rol          = $(this).attr('data-rol');
    var idEvento     = $(this).attr('data-idEvento');
    var idPuntoVenta = $(this).attr('data-idPuntoVenta');

    $('#edit-fullName').val(fullName);
    $('#edit-user').val(user);
    $('#edit-password').val(password);
    $('#edit-rol option[value="' + rol + '"]').attr("selected", "selected");
    $('#editarUsuario-SelectEvento option[value="' + idEvento + '"]').attr("selected", "selected");

    if ( rol == 2 ) {
        var evento = $('#editarUsuario-SelectEvento').val();

        $.ajax({
            url: '/controller/crearUsuario.php',
            type: 'POST',
            data: {
                caso     : 'SelectPuntoVenta',
                idEvento : evento
            },
            success: function(response) {
                $('#editarUsuario-SelectPV').html( response );
                $('#editarUsuario-SelectPV option[value="' + idPuntoVenta + '"]').attr("selected", "selected");
                $('#editarUsuario .asignarEvento').removeClass('hide');
            },
            error: function() {
                console.log( 'ajax_SelectPuntoVenta.change_error' );
            }
        });
    } else {
        $('#editarUsuario .asignarEvento').addClass('hide');
    }
});
$('#btn-editarUsuario').click(function() {
    var fullName     = $('#edit-fullName').val();
    var user         = $('#edit-user').val();
    var password     = $('#edit-password').val();
    var rol          = $('#edit-rol').val();
    var idEvento     = $('#editarUsuario-SelectEvento').val();
    var idPuntoVenta = $('#editarUsuario-SelectPV').val();

    $.ajax({
        url: '/controller/crearUsuario.php',
        type: 'POST',
        data: {
            caso         : 'editarUsuario',
            fullName     : fullName,
            user         : user,
            password     : password,
            rol          : rol,
            idEvento     : idEvento,
            idPuntoVenta : idPuntoVenta
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
// Mostrar eventos
$('#edit-rol').change(function() {
	var rol = $(this).val();

	if ( rol == 2 ) {
        $('#editarUsuario .asignarEvento').removeClass('hide');
    } else {
        $('#editarUsuario .asignarEvento').addClass('hide');
    }
});
// Mostrar puntos de venta
$('#editarUsuario-SelectEvento').change(function() {
	var evento = $(this).val();

	$.ajax({
        url: '/controller/crearUsuario.php',
        type: 'POST',
        data: {
            caso     : 'SelectPuntoVenta',
            idEvento : evento
        },
        success: function(response) {
            $('#editarUsuario-SelectPV').html( response );
        },
        error: function() {
            console.log( 'ajax_SelectPuntoVenta.change_error' );
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
$('.editarInventario').click(function() {
    var id       = $(this).attr('data-id');
    var nombre   = $(this).attr('data-nombre');
    var cantidad = $(this).attr('data-cantidad');
    
    $('#ei-nombre').val(nombre);
    $('#ei-cantidad').val(cantidad);
    $('#idInventario').val(id);
});
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
    var nombrePV = $('#nombrePV').val();
    var idEvento = $('#pv-idEvento').val();

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
    var id     = $(this).attr('data-id');
    var nombre = $(this).attr('data-nombre');
    
    $('#editarPuntoV-IDPuntoV').val(id);
    $('#editarPuntoV-nombrePV').val(nombre);
});
$('#btn-editarPuntoV').click(function() {
    var idPuntoVenta = $('#editarPuntoV-IDPuntoV').val();
    var nombrePV     = $('#editarPuntoV-nombrePV').val();

    $.ajax({
        url: '/controller/crearEvento.php',
        type: 'POST',
        data: {
            caso         : 'editarPuntoV',
            idPuntoVenta : idPuntoVenta,
            nombrePV     : nombrePV
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

// |==============================|
// |========== VENTAS ============|
// |==============================|
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