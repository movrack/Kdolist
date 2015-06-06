define(['app', 'utils'], function (app, utils) {
    app.controller('AboutController', function ($scope) {
        utils.fn.globalProgressBar($scope);
        utils.fn.loadStatsTime();
    });
});