define(['app', 'utils'], function (app, utils) {
    var rootUrl = utils.const.rootUrl;
    app.controller('ListController', ['$rootScope', '$scope', '$routeParams', '$http', '$timeout',
        function ($rootScope, $scope, $routeParams, $http, $timeout) {

            var self = this;
            self.id = $routeParams.id;
            self.slug = $routeParams.slug;
            self.lists = [];
            self.currentGift = {
                total_gived: 500,
                total_reserved: 0,
                available_parts: 30,
                percent_done: 25,
                percent_reserved: 0
            };
            self.givedGift = {'number': 1};
            self.avoidDoubleClick = false;
            self.formSend = false;
            self.setData = function (newData) {
                self.lists = newData;
                $rootScope.$broadcast('siteDescriptionUpdate', newData.description);
                $rootScope.$broadcast('siteTitleUpdate', newData.title);
                $rootScope.$broadcast('setBg', newData.picture.web_path);
            };

            self.sendGift = function () {
                self.avoidDoubleClick = true;
                self.formSend = true;
                $timeout(function () {
                    self.avoidDoubleClick = false;
                }, 3000);
                self.emailLink = self.givedGift.email.substr(self.givedGift.email.indexOf("@") + 1);
            };

            $http.get(rootUrl + '/api/lists/lists/' + self.id + '.json').success(function (data) {
                self.setData(data[0]);
            });

            $scope.$on('modalGift', function (event, args) {
                self.currentGift = args;
            });
            loadStellar();
            loadTooltip();
            loadPopover();
        }
    ]);
});