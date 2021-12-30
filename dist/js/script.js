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
    
    // Evento
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

    // Usuarios
    $('#usuarios-table1, #usuarios-table2').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json" },
        responsive: true,
        searchPanes: {
            layout: 'columns-3',
            cascadePanes: true,
            viewTotal: false
        },
        dom: 'PBfrtip',
        columnDefs: [
            {
                searchPanes: {
                    show: true
                },
                targets: [1, 2, 3]
            },
            {
                searchPanes: {
                    show: false
                },
                targets: [0, 4, 5]
            }
        ],
    });

    // Eventos - Informes
    $('#informes-table1').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json" },
        responsive: true,
        searchPanes: {
            layout: 'columns-5',
            cascadePanes: true,
            viewTotal: false
        },
        dom: 'PBfrtip',
        columnDefs: [
            {
                searchPanes: {
                    show: true
                },
                targets: [0, 1, 2, 3, 4]
            },
            {
                searchPanes: {
                    show: false
                },
                targets: [5, 6]
            }
        ],
    });

    $( ".datepicker" ).datepicker();
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
$('#crearProducto-Costo, #crearProducto-PrecioPublico, #editarProducto-Costo, #editarProducto-PrecioPublico, #agregarInventario-Cantidad, #agregarPuntoVenta-cantMesas, #editarInventario-Cantidad, #editarPuntoV-cantMesas, #agregarSubInventario-Cantidad, #editarSubInventario-Cantidad').bind('keypress', function(event) {
    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});