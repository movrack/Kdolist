define(['jquery'], function($){

    function setCookie(key, value) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }

    function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    }

    function isInt(n) {
        return ((n % 1) === 0);
    }

    function formIsValid() {
        var success = true;
        if (($('#formFirstName > input').val()).trim() == "") {
            success = false;
            $('#formFirstName').addClass('has-error');
            $('#formFirstName').popover({
                'title' : '<strong style="color: red;">Erreur</strong>',
                'content' : 'Veuillez écrire votre prénom.',
                'html' : true,
                'placement' : 'left'
            }).popover('show');
            $('#formFirstName').click(function(){
                $('#formFirstName').popover('hide');
                $('#formFirstName').removeClass('has-error');
            });
        }

        if (($('#formLastName > input').val()).trim() == "") {
            success = false;
            $('#formLastName').addClass('has-error');

            $('#formLastName').popover({
                'title' : '<strong style="color: red;">Erreur</strong>',
                'content' : 'Veuillez écrire votre nom.',
                'html' : true,
                'placement' : 'top'
            }).popover('show');
            $('#formLastName').click(function(){
                $('#formLastName').popover('hide');
                $('#formLastName').removeClass('has-error');
            });
        }

        if (!isValidEmailAddress($('#formEmail > input').val())) {
            success = false;
            $('#formEmail').addClass('has-error');
            $('#formEmail input').popover({
                'title' : '<strong style="color: red;">Erreur</strong>',
                'content' : 'L\'adresse email n\'est pas valide.',
                'html' : true,
                'placement' : 'right'
            }).popover('show');
            $('#formEmail').click(function(){
                $('#formEmail').popover('hide');
                $('#formEmail').removeClass('has-error');
            });
        }

        var nbParts = $('#formNumberOfParts > input').val();
        if (typeof(nbParts) != "undefined") {
            nbParts = parseInt((nbParts).trim());
            var min = parseInt($('#formNumberOfParts > input').attr('min'));
            var max = parseInt($('#formNumberOfParts > input').attr('max'));

            if (!isInt(nbParts) || nbParts < min || nbParts > max) {
                success = false;
                $('#formNumberOfParts').addClass('has-error');
                $('#formNumberOfParts').popover({
                    'title': '<strong style="color: red;">Erreur</strong>',
                    'content': 'Le nombre de parts doit être un nombre entier entre ' + min + ' et ' + max + ' compris.',
                    'html': true,
                    'placement': 'bottom'
                }).popover('show');
                $('#formNumberOfParts').click(function () {
                    $('#formNumberOfParts').popover('hide');
                    $('#formNumberOfParts').removeClass('has-error');
                });
            }
        }
        return success;
    }

    $(document).ready(function() {

        // Offer gift
        $('.offer').on('click', function() {
            //event.preventDefault();
            var link = $(this).data('link');
            $.ajax({
                url: link,
                dataType: 'html',
                method: 'GET',
                success: function (data) {
                    $('#showOfferForm').html(data);
                    $("#submitFormOffer").on('click', function () {
                        var button = $('#submitFormOffer');
                        button.attr("disabled", "disabled")
                            .html("<i class=\"fa fa-spinner fa-spin\"></i> Offrir");

                        window.setTimeout(function() {
                            button.html("<i class=\"fa fa-gift\"></i> Offrir")
                                .removeAttr("disabled");
                        }, 5000);

                        if(formIsValid()) {
                            $('#formOffer > form').submit();
                        }
                    });
                    $('#modalOffer').modal('show');
                }
            });
        });

        $('#showOfferForm').on('keyup', '#formNumberOfParts input', function() {
            var value = $(this).val();
            var partValue = $('#counter').data('counter');
            $('#counter').text(value);
            var res = value * partValue;
            $('#counter-value').text(res);
        });

        // Click on row
        $(".clickable-row").click(function() {
            window.document.location = $(this).data("href");
        });

        // Show list / grid
        $('#showInGrid').addClass("btn-info");

        $('#showInList').on('click', function() {
            setCookie('listView', 'showInList');
            $(this).addClass("btn-info");
            $(this).removeClass("btn-default");
            $('#showInGrid').removeClass("btn-info");
            $('#showInGrid').addClass("btn-default");
            $('.showGrid').hide('slow');
            $('.showList').show('slow');
        });
        $('#showInGrid').on('click', function() {
            setCookie('listView', 'showInGrid');
            $(this).addClass("btn-info");
            $(this).removeClass("btn-default");
            $('#showInList').removeClass("btn-info");
            $('#showInList').addClass("btn-default");

            $('.showList').hide('slow');
            $('.showGrid').show('slow');
        });

        var viewToShow = getCookie('listView');
        if (viewToShow != null) {
            $('#'+viewToShow).click();
        } else {
            $('#showInGrid').click();
        }

    });
});