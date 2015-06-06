define(['app', 'jquery.owlcarousel'], function (app) {
    app.controller('HomeController', function () {
        if (($().owlCarousel) && ($(".owl-carousel").length)) {
            $(".owl-columns3").owlCarousel({
                 itemsCustom: [[0,1],[767,2],[991,3]],
                 navigation:false,
                 pagination:false,
                 autoplay:false
            });
        }

    });
});