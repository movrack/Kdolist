define(['app'], function (app) {

    app.controller('MainController', function ($scope) {
        this.product = {
            name: 'Dodecahedron',
            price: 2.95,
            description: '. . .'
        };
    });
});