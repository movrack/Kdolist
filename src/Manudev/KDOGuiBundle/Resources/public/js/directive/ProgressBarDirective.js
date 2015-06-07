define(['app', 'utils'], function (app, utils) {

    app.directive('ProgressBar', function () {
        return {
            restrict: 'E',
            templateUrl: rootUrl + '/directive/progressBar',
            scope: {
                gift: '='
            },
            link: function ($scope, $elem, attrs) {
                loadProgressBar($elem, $scope);
                $scope.$watch('gift', function (newValue, oldValue) {
                    if (newValue !== oldValue) {
                        loadFixedProgressBar($elem, $scope);
                    }
                }, true);
            }
        };
    });
});