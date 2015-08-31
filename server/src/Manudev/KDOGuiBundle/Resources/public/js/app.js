define(['angularAMD', 'utils' , 'angular-route', 'loading-bar', 'ui-bootstrap',
        'angular-animate', 'jquery', 'underscore'],
        function (angularAMD, utils) {

    var rootUrl = utils.const.rootUrl;

    var app = angular.module('app', ['ngRoute', 'ui.bootstrap', 'angular-loading-bar', 'ngAnimate'],
        function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        }
    );


    app.config(['$routeProvider', 'cfpLoadingBarProvider', function($routeProvider) {
        $routeProvider
            .when('/about', {
                templateUrl: rootUrl+'/template/about',
                controller: 'AboutController',
                controllerAs: 'aboutCtrl' } )
            .when('/features', {
                templateUrl: rootUrl+'/template/features',
                controller: 'FeaturesController',
                controllerAs: 'featuresCtrl' } )
            .when('/terms', {
                templateUrl: rootUrl+'/template/terms',
                controller: 'TermsController',
                controllerAs: 'termsCtrl' } )
            .when('/price', {
                templateUrl: rootUrl+'/template/price',
                controller: 'PriceController',
                controllerAs: 'priceCtrl' } )
            .when('/signin', {
                templateUrl: rootUrl+'/template/signin',
                controller: 'SigninController',
                controllerAs: 'signinCtrl' } )
            .when('/signup', {
                templateUrl: rootUrl+'/template/signup',
                controller: 'SignupController',
                controllerAs: 'signupCtrl' } )
            .when('/list/:id', {
                templateUrl: rootUrl+'/template/list',
                controller: 'ListController',
                controllerAs: 'listCtrl' } )
            .when('/list/:id/:slug', {
                templateUrl: rootUrl+'/template/list',
                controller: 'ListController',
                controllerAs: 'listCtrl' } )
            .when('/faq', {
                templateUrl: rootUrl+'/template/faq',
                controller: 'FaqController',
                controllerAs: 'faqCtrl' } )
            .when('/contact', {
                templateUrl: rootUrl+'/template/contact',
                controller: 'ContactController',
                controllerAs: 'contactCtrl' } )
            .when('/403', {
                templateUrl: rootUrl+'/template/403',
                controller: 'Error403Controller',
                controllerAs: 'e403Ctrl' } )

            .when('/', {
                templateUrl: rootUrl+'/template/home',
                controller: 'HomeController',
                controllerAs: 'homeCtrl' } )
            .otherwise({ redirectTo: '/' });
    }]);
    return angularAMD.bootstrap(app);
});