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

    $(document).ready(function() {
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


        // Details gift
        $('.details').on('click', function() {
            event.preventDefault();
            var gift = {
                id:             $(this).parent().parent().find('.gift-id').html(),
                name:           $(this).parent().parent().find('.gift-name').html(),
                description:    $(this).parent().parent().find('.gift-description').html(),
                link:           $(this).parent().parent().find('.gift-link').html(),
                price:          $(this).parent().parent().find('.gift-price').html(),
                img:            $(this).parent().parent().find('.gift-img').html(),
                offerLink:      $(this).parent().parent().find('.gift-offer').html()
            };

            $('#modalDetails .modal-title').text(gift.name);
            $('#modalDetails #detailGiftId').text(gift.id);
            $('#modalDetails #detailGiftName').text(gift.name);
            $('#modalDetails #detailGiftDescription').html(gift.description);
            $('#modalDetails #detailGiftLink').attr('href', gift.link);
            $('#modalDetails #detailGiftPrice').text(gift.price);
            $('#modalDetails #detailGiftImg').attr('src', gift.img);
            $('#modalDetails #detailGiftForm').attr('action', gift.offerLink);

            if (!gift.img)   { $('#offerShowImg').hide();   } else { $('#offerShowImg').show(); }
            if (!gift.price) { $('#offerShowPrice').hide(); } else { $('#offerShowPrice').show(); }
            if (!gift.link)  { $('#offerShowLink').hide(); }  else { $('#offerShowLink').show(); }

            $('#modalDetails').modal('show');
        });
    });



    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&appId=104528756291510&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


});