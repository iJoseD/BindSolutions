if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    if ( window.location.pathname == '/device-info/' ) {
        window.location.replace('https://myapp.thankyoutipper.com/');
    }
} else {
    if ( window.location.pathname == '/device-info/' ) { } else {
        window.location.replace('https://thankyoutipper.com/device-info/');
    }
}

// Menu
$('#icoMenu').click(function() {
    $('#menu').addClass('active');
});

$('#menu > div.content > ul > li.item--menu').click(function() {
    $('#menu').removeClass('active');
});

// Generar código activación
$('#btn--generateCode').click(function() {
    var dialCode = $('.iti__selected-dial-code').html();
    var phone = dialCode + $('#tel--login').val();

    $.ajax({
        url: '/controller/sendSms.php',
        type: 'POST',
        data: {
            caso    : 'codeActivation',
            phone   : phone
        },
        success: function(response) {
            console.log( response );

            if ( response == 'error_send_sms' ) {
                alert( response );
            } else if ( response == 'error_update_db' ) {
                alert( response );
            } else if ( response == 'error_insert_db' ) {
                alert( response );
            } else {
                $('.number').html(phone);
                $('.code').html('The code is: <b>' + response + '</b>');
                $('.login').addClass('hide');
                $('.check-code').removeClass('hide');
            }
        },
        error: function() {
            console.log( 'ajax_generateCode_error' );
        }
    });
});

$('#btn--checkCode').click(function() {
    var code = $('#check--code').val();
    var dialCode = $('.iti__selected-dial-code').html();
    var phone = dialCode + $('#tel--login').val();

    $.ajax({
        url: '/controller/checkCode.php',
        type: 'POST',
        data: {
            caso    : 'checkCode',
            code    : code,
            phone   : phone
        },
        success: function(data) {
            console.log( data );

            if ( data == 'update_success' ) {
                window.location.href = '/profile/';

            } else if ( data == 'login_successful' ) {
                window.location.href = '/';
            }
        },
        error: function() {
            console.log( 'ajax_generateCode_error' );
        }
    });
});

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

$('.super-power').click(function() {
    var superPower = $(this).attr('data-superPower');

    $('.super-power').removeClass('active');
    $(this).addClass('active');

    $('#superPower').val(superPower);
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

$('.card-custom .overlay').click(function() {
    var amount = $(this).attr('data-amount');
    
    // Transaction cost
    var creditCard      = (amount * 2.9) / 100;
    var tyt             = (amount * 5) / 100;
    var stripeConnect   = (amount * 0.25) / 100;
    var tCost           = parseFloat(creditCard.toFixed(2)) + parseFloat(0.30) + parseFloat(tyt.toFixed(2)) + parseFloat(stripeConnect.toFixed(2));
    var totalPayment    = parseFloat( amount ) + parseFloat( tCost.toFixed(2) );

    $('.card-custom').removeClass('active');
    $('#amount-' + amount).addClass('active');

    $('.d-table').removeClass('hide');
    $('.t-amount').html('$' + amount + '.00');
    $('.tCost').html('$' + tCost.toFixed(2));
    $('.total-amount').html('$' + totalPayment.toFixed(2));

    $('#amount').val(amount);
    $('#t--amount').val(totalPayment.toFixed(2));
    $('.payment .amount span').html(totalPayment.toFixed(2));
});

$('.sendMoney').click(function() {
    $('.transaction').addClass('hide');
    $('.payment').removeClass('hide');
});

$('.proceedPay').click(function() {
    $('.payment').addClass('hide');
    $('.processing-payment').removeClass('hide');

    var ccnum    = $('#ccnum').val();
    var expMonth = $('#exp-month').val();
    var expYear  = $('#exp-year').val();
    var cvv      = $('#cvv').val();
    var amount   = $('#amount').val() * 100;
    var tAmount  = $('#t--amount').val() * 100;

    $.ajax({
        url: '/controller/payment.php',
        type: 'POST',
        data: {
            caso     : 'payment',
            ccnum    : ccnum,
            expMonth : expMonth,
            expYear  : expYear,
            cvv      : cvv,
            amount   : amount,
            tAmount  : tAmount
        },
        success: function(data) {
            if ( data == 'error_payment_methods' ) {
                console.log( data );
            } else if ( data == 'error_payment_intents' ) {
                console.log( data );
            } else if ( data == 'error_transfers' ) {
                console.log( data );
            } if ( data == 'successful_payment' ) {
                console.log( data );
                $('.processing-payment').addClass('hide');
                $('.successful-payment').removeClass('hide');
            }
        },
        error: function() {
            console.log( 'ajax_generateCode_error' );
        }
    });
});

// VALIDADOR DE TARJETA DE CREDITO
if ( window.location.pathname == '/payments/' ) {
    payform.cardNumberInput(document.getElementById('ccnum'));
}

// SELECTOR DE PAÍS EN EL LOGIN
var phoneLogin = document.querySelector("#tel--login");
window.intlTelInput(phoneLogin, {
    // allowDropdown: false,
    // autoHideDialCode: false,
    // autoPlaceholder: "off",
    // dropdownContainer: document.body,
    // excludeCountries: ["us"],
    // formatOnDisplay: false,
    // geoIpLookup: function(callback) {
    //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
    //     var countryCode = (resp && resp.country) ? resp.country : "";
    //     callback(countryCode);
    //   });
    // },
    // hiddenInput: "full_number",
    // initialCountry: "auto",
    // localizedCountries: { 'de': 'Deutschland' },
    // nationalMode: false,
    // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
    // placeholderNumberType: "MOBILE",
    // preferredCountries: ['cn', 'jp'],
    separateDialCode: true,
    utilsScript: "../dist/js/utils.js",
});