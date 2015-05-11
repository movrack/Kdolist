'use strict';
    //var angular = require('angular');
   // var services = require('./services/services');
   // var controllers = require('./controllers/controllers');
   // var directives = require('./directives/directives');

var app = angular.module('app', ['ngRoute']);

var aProduct;
app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/demo1', {
            templateUrl: 'http://k.loc/app_dev.php/gui/demo1',
            controller: 'Demo1Controller' } )
        .when('/demo2', {
            templateUrl: 'http://k.loc/app_dev.php/gui/demo2',
            controller: 'Demo2Controller' } )
        .otherwise({ redirectTo: '/' });
    }
]);

app.controller('FooterController', function() {
    this.date = new Date();
});

app.controller('MainController', function() {
    this.product = gem;
});

app.controller('Demo1Controller', function() {
    console.log('demo controller')
    this.name = "Demo 1"
});

app.controller('Demo2Controller', function() {
    console.log('demo2 controller')
    this.name = "Demo 2"
});

var gem = {
    name: 'Dodecahedron',
    price: 2.95,
    description: '. . .'
}
