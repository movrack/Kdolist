'use strict';
    //var angular = require('angular');
   // var services = require('./services/services');
   // var controllers = require('./controllers/controllers');
   // var directives = require('./directives/directives');

var app = angular.module('app', ['ngRoute']);

var rootUrl = 'http://k.loc/app_dev.php';
app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/about', {
            templateUrl: rootUrl+'/gui/template/about',
            controller: 'AboutController' } )
        .when('/features', {
            templateUrl: rootUrl+'/gui/template/features',
            controller: 'FeaturesController' } )
        .when('/terms', {
            templateUrl: rootUrl+'/gui/template/terms',
            controller: 'TermsController' } )
        .when('/price', {
            templateUrl: rootUrl+'/gui/template/price',
            controller: 'PriceController' } )
        .when('/signin', {
            templateUrl: rootUrl+'/gui/template/signin',
            controller: 'SigninController' } )
        .when('/signup', {
            templateUrl: rootUrl+'/gui/template/signup',
            controller: 'SignupController' } )
        .when('/list/:id/:slug', {
            templateUrl: rootUrl+'/gui/template/list',
            controller: 'ListController' } )
        .when('/contact', {
            templateUrl: rootUrl+'/gui/template/contact',
            controller: 'ContactController' } )
        .when('/403', {
            templateUrl: rootUrl+'/gui/template/403',
            controller: 'Error403Controller' } )
        .when('/', {
            templateUrl: rootUrl+'/gui/template/home',
            controller: 'HomeController' } )
        .otherwise({ redirectTo: '/' });
    }
]);

app.controller('ContactController', function() {
    this.name = 'contact';
});
app.controller('Error403Controller', function() {
    this.name = '403';
});
app.controller('FooterController', function() {
    this.date = new Date();
});

app.controller('MainController', function() {
    this.product = gem;
});

app.controller('PriceController', function() {
    console.log('price controller')
    this.name = "Prix"
});

app.controller('FeaturesController', function() {
    console.log('features controller')
    this.name = "Fonctionnalités"
});

app.controller('TermsController', function() {
    console.log('terms controller')
    this.name = "CGU"
});

app.controller('AboutController', function() {
    console.log('about controller')
    this.name = "A propos"
});
app.controller('HomeController', function() {
    console.log('home controller')
    this.name = "home"
});
app.controller('SigninController', function() {
    console.log('signin controller')
    this.name = "signin"
});
app.controller('SignupController', function() {
    console.log('signup controller')
    this.name = "signup"
});


app.controller('ListController', ['$scope', '$routeParams', function($route, $routeParams) {
    this.name = 'list';
    this.id = $routeParams.id;
    this.slug = $routeParams.slug;
}]);

var gem = {
    name: 'Dodecahedron',
    price: 2.95,
    description: '. . .'
}
