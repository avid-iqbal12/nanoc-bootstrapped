// "Carousel-Jumbotron" Bootstrap template default script:

!function ($) {
    $(function(){
        // carousel demo
        $('#myCarousel').carousel()
    })
}(window.jQuery)

// Script for sending form via email without refreshing the page

// binduje event wysłania formularza
$('#contactForm').on('submit', function(e) {

    // e to obiekt event, blokuję normalną akcję - tzn żeby strona nie została przeładowana
    e.preventDefault();

    // blokuję button do wysyłania - żeby ktoś nie wysłał kilka razy tej samej wiadmośc
    $('#submitButton').attr('disabled', true);

    // tworzę request
    $.ajax({
        type: "POST",                               // typy POST, bo przesyłamy dane ukryte
        url: 'send_form_email.php',           // url jak w linku
        data: $('#contactForm').serialize(),        // dane przesyłane w tym requeście (czytaj poniżej)
        success: function(data) {                   // funkcja wyoływana jak wróci odpowiedź
            $('#responseTextWrapper')
                .slideUp('fast', function() {
                    $('#responseText').html(data.message); // ustawiam tekst
                    if(data.status == 1) { // jeśli status 1 (sukces) to dodaję klasę żeby napis był zielony ;)
                        $('#responseTextWrapper')
                            .removeClass('alert alert-error')
                            .addClass('alert alert-success');
                        $('#telephone').attr('disabled', true);
                        $('#email').attr('disabled', true);
                        $('#message').attr('disabled', true);
                        $('#submitButton').html('Wiadomość wysłana!');
                    } else {
                        $('#responseTextWrapper')
                            .removeClass('alert alert-success')
                            .addClass('alert alert-error');
                        $('#submitButton').removeAttr('disabled'); // usuwam blokadę przycisku wysyłania
                    }
                })
                .slideDown('fast'); // wyświetlam wiadomość
        },
        dataType: 'json'
        // jak ustawię sobie typ danych to automatycznie
        // jquery zrobi mi obiekt z tego co zwrócił php
        // nie trzeba operować na tekście czystym
    });
});

// $('#contactForm').serialize() koduje wszystkie pola formularza, tak że są gotowe do wysyłki
// http://cl.ly/image/2p0Z1l0M2K1X
// email=karolszafranski%40gmail.com&phone=234+432+234&message=oto+moja+kr%C3%B3tka+wiadomo%C5%9B%C4%87

$('#responseTextWrapper').click(function () {
    $(this).slideUp('fast');
});
