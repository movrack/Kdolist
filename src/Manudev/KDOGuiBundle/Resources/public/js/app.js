define(function () {
    console.log("app loaded");
    var app = angular.module('kdoapp', [ ]);

    app.controller('MainController', function() {
        this.product = gem;
    });

    var gem = {
        name: 'Dodecahedron',
        price: 2.95,
        description: '. . .'
    }

    console.log('jQuery version:', $.fn.jquery);
    console.log("Modernizer loaded: " +Modernizr.svg);
});