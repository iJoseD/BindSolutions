// Crear usuario
$('#btn-crearUsuario').click(function() {
    var fullName     = $('#crearUsuario-Nombre').val();
    var user         = $('#crearUsuario-Usuario').val();
    var password     = $('#crearUsuario-Contrasena').val();
    var rol          = $('#crearUsuario-Rol').val();
    var idEvento     = $('#crearUsuario-SelectEvento').val();
    var idPuntoVenta = $('#crearUsuario-SelectPV').val();

    $.ajax({
        url: '/controller/usuarios.php',
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
$('#crearUsuario-Rol').change(function() {
	var rol = $(this).val();

	if ( rol == 2 || rol == 4 ) {
        $('.asignarEvento').removeClass('hide');
    } else {
        $('.asignarEvento').addClass('hide');
    }
});
// Mostrar puntos de venta
$('#crearUsuario-SelectEvento').change(function() {
	var evento = $(this).val();

	$.ajax({
        url: '/controller/usuarios.php',
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
var editarUsuario = document.getElementById('editarUsuario')
editarUsuario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var fullName     = button.getAttribute('data-bs-fullName');
    var user         = button.getAttribute('data-bs-user');
    var password     = button.getAttribute('data-bs-password');
    var rol          = button.getAttribute('data-bs-rol');
    var idEvento     = button.getAttribute('data-bs-idEvento');
    var idPuntoVenta = button.getAttribute('data-bs-idPuntoVenta');

    var inputFullName     = editarUsuario.querySelector('#editarUsuario-Nombre')
    var inputUser         = editarUsuario.querySelector('#editarUsuario-Usuario')
    var inputPassword     = editarUsuario.querySelector('#editarUsuario-Contrasena')
    var inputRol          = editarUsuario.querySelector('#editarUsuario-Rol')
    var inputIDEvento     = editarUsuario.querySelector('#editarUsuario-SelectEvento')
    var inputIDPuntoVenta = editarUsuario.querySelector('#editarUsuario-SelectPV')

    inputFullName.value     = fullName
    inputUser.value         = user
    inputPassword.value     = password
    inputRol.value          = rol
    inputIDEvento.value     = idEvento
    inputIDPuntoVenta.value = idPuntoVenta

    if ( rol == 2 || rol == 4 ) {
        var evento = $('#editarUsuario-SelectEvento').val();

        $.ajax({
            url: '/controller/usuarios.php',
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
})
$('#btn-editarUsuario').click(function() {
    var fullName     = $('#editarUsuario-Nombre').val();
    var user         = $('#editarUsuario-Usuario').val();
    var password     = $('#editarUsuario-Contrasena').val();
    var rol          = $('#editarUsuario-Rol').val();
    var idEvento     = $('#editarUsuario-SelectEvento').val();
    var idPuntoVenta = $('#editarUsuario-SelectPV').val();

    $.ajax({
        url: '/controller/usuarios.php',
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
$('#editarUsuario-Rol').change(function() {
	var rol = $(this).val();

	if ( rol == 2 || rol == 4 ) {
        $('#editarUsuario .asignarEvento').removeClass('hide');
    } else {
        $('#editarUsuario .asignarEvento').addClass('hide');
    }
});
// Mostrar puntos de venta
$('#editarUsuario-SelectEvento').change(function() {
	var evento = $(this).val();

	$.ajax({
        url: '/controller/usuarios.php',
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
var eliminarUsuario = document.getElementById('eliminarUsuario')
eliminarUsuario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget
    var user = button.getAttribute('data-bs-user');
    var inputUser = eliminarUsuario.querySelector('#eliminarUsuario .user')

    inputUser.textContent = user
})
$('#btn-eliminarUsuario').click(function() {
    var user = $('#eliminarUsuario .user').html();

    $.ajax({
        url: '/controller/usuarios.php',
        type: 'POST',
        data: {
            caso : 'eliminarUsuario',
            user : user
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

// Activar usuario
var activarUsuario = document.getElementById('activarUsuario')
activarUsuario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var fullName     = button.getAttribute('data-bs-fullName');
    var user         = button.getAttribute('data-bs-user');
    var password     = button.getAttribute('data-bs-password');
    var rol          = button.getAttribute('data-bs-rol');
    var idEvento     = button.getAttribute('data-bs-idEvento');
    var idPuntoVenta = button.getAttribute('data-bs-idPuntoVenta');

    var inputFullName     = activarUsuario.querySelector('#activarUsuario-Nombre')
    var inputUser         = activarUsuario.querySelector('#activarUsuario-Usuario')
    var inputPassword     = activarUsuario.querySelector('#activarUsuario-Contrasena')
    var inputRol          = activarUsuario.querySelector('#activarUsuario-Rol')
    var inputIDEvento     = activarUsuario.querySelector('#activarUsuario-SelectEvento')
    var inputIDPuntoVenta = activarUsuario.querySelector('#activarUsuario-SelectPV')

    inputFullName.value     = fullName
    inputUser.value         = user
    inputPassword.value     = password
    inputRol.value          = rol
    inputIDEvento.value     = idEvento
    inputIDPuntoVenta.value = idPuntoVenta

    if ( rol == 2 || rol == 4 ) {
        var evento = $('#activarUsuario-SelectEvento').val();

        $.ajax({
            url: '/controller/usuarios.php',
            type: 'POST',
            data: {
                caso     : 'SelectPuntoVenta',
                idEvento : evento
            },
            success: function(response) {
                $('#activarUsuario-SelectPV').html( response );
                $('#activarUsuario-SelectPV option[value="' + idPuntoVenta + '"]').attr("selected", "selected");
                $('#activarUsuario .asignarEvento').removeClass('hide');
            },
            error: function() {
                console.log( 'ajax_SelectPuntoVenta.change_error' );
            }
        });
    } else {
        $('#activarUsuario .asignarEvento').addClass('hide');
    }
})
$('#btn-activarUsuario').click(function() {
    var fullName     = $('#activarUsuario-Nombre').val();
    var user         = $('#activarUsuario-Usuario').val();
    var password     = $('#activarUsuario-Contrasena').val();
    var rol          = $('#activarUsuario-Rol').val();
    var idEvento     = $('#activarUsuario-SelectEvento').val();
    var idPuntoVenta = $('#activarUsuario-SelectPV').val();

    $.ajax({
        url: '/controller/usuarios.php',
        type: 'POST',
        data: {
            caso         : 'activarUsuario',
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
$('#activarUsuario-Rol').change(function() {
	var rol = $(this).val();

	if ( rol == 2 || rol == 4 ) {
        $('#activarUsuario .asignarEvento').removeClass('hide');
    } else {
        $('#activarUsuario .asignarEvento').addClass('hide');
    }
});
// Mostrar puntos de venta
$('#activarUsuario-SelectEvento').change(function() {
	var evento = $(this).val();

	$.ajax({
        url: '/controller/usuarios.php',
        type: 'POST',
        data: {
            caso     : 'SelectPuntoVenta',
            idEvento : evento
        },
        success: function(response) {
            $('#activarUsuario-SelectPV').html( response );
        },
        error: function() {
            console.log( 'ajax_SelectPuntoVenta.change_error' );
        }
    });
});