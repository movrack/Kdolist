define(['app', 'utils', 'jquery'], function (app, utils, $) {
    app.controller('BodyController', ['$rootScope', function ($rootScope) {
        $rootScope.$on('cfpLoadingBar:started', function () {
            if ($("#preloader").length) {
                $('#giftLoader').fadeIn();
                $('#preloader').addClass('op8').fadeIn();
            }
        });
        $rootScope.$on('cfpLoadingBar:completed', function () {
            if ($("#preloader").length) {
                $('#giftLoader').fadeOut();
                $('#preloader').delay(300).fadeOut('slow').removeClass('op8');
            }
        });

        angular.element(utils.const.$body).ready(function () {
            $('#giftLoader').fadeOut();
            $('#preloader').fadeOut('slow').removeClass('op8');
            utils.const.$body.css({'overflow': 'visible'});
        });

    }]);
});