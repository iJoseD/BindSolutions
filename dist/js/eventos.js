// Crear eventos
$('#btn-crearEvento').click(function() {
    var nombre       = $('#crearEvento-Nombre').val();
    var fecha        = $('#crearEvento-Fecha').val();
    var lugar        = $('#crearEvento-Lugar').val();
    var codigoEvento = $('#crearEvento-CodigoEvento').val();

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