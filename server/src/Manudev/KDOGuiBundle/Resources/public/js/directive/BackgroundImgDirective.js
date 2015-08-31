define(['app', 'utils'], function (app, utils) {


    app.directive('backroundImg', function () {
        return function (scope, element, attrs) {
            var url = attrs.backImg
            scope.$on('setBg', function (event, args) {
                element.css({
                    'background-image': 'url(' + args + ')',
                    'background-size': 'cover',
                    'background-repeat': 'no-repeat'
                });
            });
        };
    });
});