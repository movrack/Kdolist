(function(){
    var app = angular.module('kdoapp', [ ]);
    app.constant("Modernizr", Modernizr);

    app.controller('BrowserController', function($scope, Modernizr) {
        // check if browser supports HTML5 features
        $scope.browser = {
            supportNumberInput: Modernizr.inputtypes.number,
            supportsDateimeLocalInput: Modernizr.inputtypes.datetimeLocal,
            supportsEmailInput: Modernizr.inputtypes.email
        };
    });

    app.controller('MainController', function() {
        this.product = gem;
    });

    var gem = {
        name: 'Dodecahedron',
        price: 2.95,
        description: '. . .'
    }
})();