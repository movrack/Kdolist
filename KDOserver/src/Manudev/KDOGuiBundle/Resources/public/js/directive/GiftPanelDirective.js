define(['app', 'utils'], function (app, utils) {

    app.directive('giftPanel', function () {
        return {
            templateUrl: utils.const.rootUrl + '/directive/gift',
            scope: {
                gift: '='
            },
            controller: function ($scope, $elem, attrs) {
                $scope.setModal = function () {
                    $scope.$emit('modalGift', $scope.gift);
                };
            },
            controllerAs: 'giftDirective'
        };
    });
});