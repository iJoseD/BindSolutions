// Crear productos
$('#btn-crearProducto').click(function() {
    var nombre        = $('#crearProducto-Nombre').val();
    var costo         = $('#crearProducto-Costo').val();
    var precioPublico = $('#crearProducto-PrecioPublico').val();

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
                var files = $('#crearProducto-Imagen')[0].files[0];
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
var editarProducto = document.getElementById('editarProducto')
editarProducto.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id              = button.getAttribute('data-bs-id')
    var imagen          = button.getAttribute('data-bs-imagen')
    var nombre          = button.getAttribute('data-bs-nombre')
    var costo           = button.getAttribute('data-bs-costo')
    var precioPublico   = button.getAttribute('data-bs-precioPublico')

    var inputID              = editarProducto.querySelector('#editarProducto-ID')
    var inputImagen          = editarProducto.querySelector('#editarProducto-Imagen')
    var inputNombre          = editarProducto.querySelector('#editarProducto-Nombre')
    var inputCosto           = editarProducto.querySelector('#editarProducto-Costo')
    var inputPrecioPublico   = editarProducto.querySelector('#editarProducto-PrecioPublico')

    inputID.value            = id
    inputImagen.src          = imagen
    inputNombre.value        = nombre
    inputCosto.value         = costo
    inputPrecioPublico.value = precioPublico
})
$('#btn-editarProducto').click(function() {
    var id            = $('#editarProducto-ID').val();
    var nombre        = $('#editarProducto-Nombre').val();
    var costo         = $('#editarProducto-Costo').val();
    var precioPublico = $('#editarProducto-PrecioPublico').val();

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
var eliminarProducto = document.getElementById('eliminarProducto')
eliminarProducto.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id     = button.getAttribute('data-bs-id')
    var nombre = button.getAttribute('data-bs-nombre')

    var inputID     = editarProducto.querySelector('#eliminarProducto-ID')
    var inputNombre = editarProducto.querySelector('#eliminarProducto .product')

    inputID.value           = id
    inputNombre.textContent = nombre
})
$('#btn-eliminarProducto').click(function() {
    var id = $('#eliminarProducto-ID').val();

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