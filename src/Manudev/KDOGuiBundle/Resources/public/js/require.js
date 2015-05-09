requirejs.config({
    baseUrl : '/assets/gui/js',
    enforceDefine: true,
    paths: {
        angular: [
            "https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min",
            "https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular.min",
            "/assets/gui/libs/js/angular"
        ],
        jquery: [
            "http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min",
            "https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min",
            "/assets/gui/libs/js/jquery"
        ],
        underscore: [
            "http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min",
            "/assets/gui/libs/js/underscore"
        ],
        modernizr: [
            "https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min",
            "/assets/gui/libs/js/modernizr"
        ],
        palas: ["/assets/gui/libs/palas/palas"],
        sticky : ["/assets/gui/libs/palas/plugins/sticky.min"]
    },
    shim: {
        'sticky' : {
            export: 'jQuery.sticky',
            deps: ['jquery']
        },
        'palas' : {
            exports: 'palas',
            deps: ['jquery', 'sticky']
        },
        'angular': {
          exports: 'angular'
        },
        'underscore': {
            exports: "_" ,
            deps: ['jquery']
        },
        'jquery': {
            exports: '$'
        },
        'jqueryui': {
            deps: ['jquery']
        },
        modernizr: {
            exports: 'Modernizr'
        },
        'app': {
            deps: ['modernizr', 'jquery', 'underscore', 'angular']
        }
    }
});


//require(['palas']);
require(['app']);
