'use strict';
    //var angular = require('angular');
   // var services = require('./services/services');
   // var controllers = require('./controllers/controllers');
   // var directives = require('./directives/directives');

var app = angular.module('app', ['ngRoute']);

var aProduct;
app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/about', {
            templateUrl: '/gui/template/about',
            controller: 'AboutController' } )
        .when('/features', {
            templateUrl: '/gui/template/features',
            controller: 'FeaturesController' } )
        .when('/terms', {
            templateUrl: '/gui/template/terms',
            controller: 'TermsController' } )
        .when('/price', {
            templateUrl: '/gui/template/price',
            controller: 'PriceController' } )
        .when('/signin', {
            templateUrl: '/gui/template/signin',
            controller: 'SigninController' } )
        .when('/', {
            templateUrl: '/gui/template/home',
            controller: 'HomeController' } )
        .otherwise({ redirectTo: '/' });
    }
]);

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
var gem = {
    name: 'Dodecahedron',
    price: 2.95,
    description: '. . .'
}
