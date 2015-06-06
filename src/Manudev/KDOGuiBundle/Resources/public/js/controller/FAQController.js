define(['app'], function (app) {

    app.controller('FaqController', function ($scope) {
        console.log('faq controller')

        this.tabs = {'active': 1}
        this.name = "faq"
        $scope.oneAtATime = true;

    });
});