define(['app'], function (app) {
    var defaultHeadParameters = {
        siteDescription: "Kdolist, gérer facilement votre liste de cadeau et partagé " +
        "la à vos amis et votre famille.",
        siteTitle: "Kdolist"
    };


    app.controller('HtmlController', function ($scope) {
        var self = this;
        self.head = defaultHeadParameters;
        $scope.$on('$routeChangeStart', function () {
            self.head.siteDescription = defaultHeadParameters.siteDescription;
            self.head.siteTitle = defaultHeadParameters.siteTitle;
        });

        $scope.$on('siteDescriptionUpdate', function (event, args) {
            self.head.siteDescription = args + "\n-------\n" + defaultHeadParameters.siteDescription;
        });

        $scope.$on('siteTitleUpdate', function (event, args) {
            self.head.siteTitle = defaultHeadParameters.siteTitle + " - " + args;
        });

    });
});