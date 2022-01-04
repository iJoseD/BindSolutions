// Crear eventos
$('#btn-crearEvento').click(function() {
    var nombre       = $('#crearEvento-Nombre').val();
    var fecha        = $('#crearEvento-Fecha').val();
    var lugar        = $('#crearEvento-Lugar').val();
    var codigoEvento = $('#crearEvento-CodigoEvento').val();

    // $.ajax({
    //     type: 'POST',
    //     url: '/controller/crearEvento.php',
    //     data: {
    //         caso         : 'crearEvento',
    //         nombre       : nombre,
    //         fecha        : fecha,
    //         lugar        : lugar,
    //         codigoEvento : codigoEvento
    //     },
    //     success: function(response) {
    //         console.log( response );

    //         if ( response == 'event_not_created' ) {
    //             alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );

    //         } else {
    //             $('.formulario').addClass('hide');
    //             $('.successful-message').removeClass('hide');

    //             window.setTimeout(function() {
    //                 location.reload();
    //             }, 2000);
    //         }
    //     },
    //     error: function() {
    //         console.log( 'ajax_crearEvento_error' );
    //         alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
    //     }
    // });

    $.ajax({
        type: 'POST',
        url: '/controller/crearEvento.php',
        data: {
            caso: 'crearEvento',
            nombre: nombre,
            fecha: fecha,
            lugar: lugar,
            codigoEvento: codigoEvento
        }
    }).done(function( msg ) {
        console.log( msg );
    
        if ( msg == 'event_not_created' ) {
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        } else {
            $('.formulario').addClass('hide');
            $('.successful-message').removeClass('hide');
    
            window.setTimeout(function() {
                location.reload();
            }, 2000);
        }
    }).fail(function (jqXHR, textStatus, errorThrown){
        alert( "The following error occured: "+ textStatus +" "+ errorThrown );
    });
});

// Editar evento
var editarEvento = document.getElementById('editarEvento')
editarEvento.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id           = button.getAttribute('data-bs-id')
    var nombre       = button.getAttribute('data-bs-nombre')
    var fecha        = button.getAttribute('data-bs-fecha')
    var lugar        = button.getAttribute('data-bs-lugar')
    var codigoEvento = button.getAttribute('data-bs-codigoEvento')

    var inputID           = editarEvento.querySelector('#editarEvento-ID')
    var inputNombre       = editarEvento.querySelector('#editarEvento-Nombre')
    var inputFecha        = editarEvento.querySelector('#editarEvento-Fecha')
    var inputLugar        = editarEvento.querySelector('#editarEvento-Lugar')
    var inputCodigoEvento = editarEvento.querySelector('#editarEvento-CodigoEvento')

    inputID.value           = id
    inputNombre.value       = nombre
    inputFecha.value        = fecha
    inputLugar.value        = lugar
    inputCodigoEvento.value = codigoEvento
})
$('#btn-editarEvento').click(function() {
    var id           = $('#editarEvento-ID').val();
    var nombre       = $('#editarEvento-Nombre').val();
    var fecha        = $('#editarEvento-Fecha').val();
    var lugar        = $('#editarEvento-Lugar').val();
    var codigoEvento = $('#editarEvento-CodigoEvento').val();

    $.ajax({
        url: '/controller/eventos.php',
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
            console.log( 'ajax_editarEvento_error' );
            alert( 'Ocurrio un error inesperado, por favor intente de nuevo.' );
        }
    });
});

// Eliminar producto
var eliminarEvento = document.getElementById('eliminarEvento')
eliminarEvento.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id     = button.getAttribute('data-bs-id')
    var nombre = button.getAttribute('data-bs-nombre')

    var inputID     = eliminarEvento.querySelector('#eliminarEvento-ID')
    var inputNombre = eliminarEvento.querySelector('#eliminarEvento .event')

    inputID.value           = id
    inputNombre.textContent = nombre
})
$('#btn-eliminarEvento').click(function() {
    var id = $('#eliminarEvento-ID').val();

    $.ajax({
        url: '/controller/eventos.php',
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