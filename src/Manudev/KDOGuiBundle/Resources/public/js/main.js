require.config({
    baseUrl: "/assets/js",
    paths: {

        angular: [
        //    "https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min",
        //    "https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular.min",
            "libs/angular/angular"
        ],
        'angularAMD': 'libs/angular/angularAMD',
        'angular-animate' : 'libs/angular/angular-animate',
        'angular-route': 'libs/angular/angular-route',
        'loading-bar' : 'libs/angular/loading-bar',
        'ui-bootstrap' : 'libs/angular/ui-bootstrap',

        jquery: [
         //   "http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min",
         //   "https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min",
            "libs/jquery/jquery"
        ],
        'jquery.owlcarousel' : ["libs/jquery/owl.carousel"],
        'jquery.appear' : ["libs/jquery/jquery.appear"],


        underscore: [
         //   "http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min",
            "libs/underscore"
        ],
        modernizr: [
         //   "https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min",
            "libs/modernizr"
        ],

        'bodyHtmlCtrl': 'controller/html/BodyController',
        'htmlHtmlCtrl': 'controller/html/HtmlController',
        'mainHtmlCtrl': 'controller/html/MainController',
        'footerHtmlCtrl': 'controller/html/FooterController',

        'AboutCtrl': 'controller/AboutController',
        'ContactCtrl': 'controller/ContactController',
        'Error403Ctrl': 'controller/Error403Controller',
        'FAQCtrl': 'controller/FAQController',
        'FeaturesCtrl': 'controller/FeaturesController',
        'HomeCtrl': 'controller/HomeController',
        'ListCtrl': 'controller/ListController',
        'PriceCtrl': 'controller/PriceController',
        'SigninCtrl': 'controller/SigninController',
        'SignupCtrl': 'controller/SignupController',
        'TermsCtrl': 'controller/TermsController'
    },
    shim: {
        'angularAMD': ['angular'],
        'angular-animate': ['angular'],
        'angular-route': ['angular'],
        'loading-bar': ['angular'],
        'ui-bootstrap': ['angular'],


        modernizr: ['Modernizr'],
        'underscore': {
            exports: "_" ,
            deps: ['jquery']
        },

        // Jquery
        'jquery':  {
            exports: "$"
        },
        'jquery.owlcarousel' : {
            exports: '$',
            deps: ['jquery']
        },
        'jquery.appear' : {
            exports: '$',
            deps: ['jquery']
        }

    },
    deps: ['htmlHtmlCtrl', 'bodyHtmlCtrl', 'mainHtmlCtrl', 'footerHtmlCtrl',
        'AboutCtrl',
        'ContactCtrl',
        'Error403Ctrl',
        'FAQCtrl',
        'FeaturesCtrl',
        'HomeCtrl',
        'ListCtrl',
        'PriceCtrl',
        'SigninCtrl',
        'SignupCtrl',
        'TermsCtrl',
        'app']
});
