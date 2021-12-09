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
        }
    });
});

// Cargar tablas
$(document).ready(function () {
    $('#tableusuarios').DataTable();
});

// Agregar imagen a los productos
$(".upload").on('click', function() {
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
                $(".card-img-top").attr("src", response);
            }
        }
    });
    return false;
});

$('#btn--updateProfile').click(function() {
    var dni = $('#dni').val();
    var firstName = $('#fitst--name').val();
    var lastName = $('#last--name').val();
    var email = $('#email').val();
    var phone = $('#phone').val();
    var address = $('#address').val();
    var superPower = $('#superPower').val();

    $.ajax({
        url: '/controller/updateProfile.php',
        type: 'POST',
        data: {
            caso        : 'updateProfile',
            dni         : dni,
            firstName   : firstName,
            lastName    : lastName,
            email       : email,
            phone       : phone,
            address     : address,
            superPower  : superPower
        },
        success: function(data) {
            console.log( data );

            if ( data == 'update_success' ) {
                $('#alert').removeClass('hide');
                window.setTimeout(function() {
                    window.location.href = '/';
                }, 2000);
            }
        },
        error: function() {
            console.log( 'ajax_generateCode_error' );
        }
    });
});