var Vng = "1.3.15";
var V$ = "2.1.4";
var V_ = "1.8.3";
var VModernizr = "2.8.3;";

require.config({
    baseUrl: "/assets/js",
    paths: {
        /* Angular */
        angular: [
            "https://ajax.googleapis.com/ajax/libs/angularjs/"+Vng+"/angular.min",
            "https://cdnjs.cloudflare.com/ajax/libs/angular.js/"+Vng+"/angular.min",
            "libs/angular/angular"
        ],
        'angularAMD': 'libs/angular/angularAMD',
        'angular-animate' : 'libs/angular/angular-animate',
        'angular-route': 'libs/angular/angular-route',
        'loading-bar' : 'libs/angular/loading-bar',
        'ui-bootstrap' : 'libs/angular/ui-bootstrap',

        /* Modernizr */
        modernizr: [
            "https://cdnjs.cloudflare.com/ajax/libs/modernizr/"+VModernizr+"/modernizr.min",
            "libs/modernizr"
        ],

        /* JQuery */
        jquery: [
            "https://cdnjs.cloudflare.com/ajax/libs/jquery/"+V$+"/jquery.min",
            "http://ajax.googleapis.com/ajax/libs/jquery/"+V$+"/jquery.min",
            "libs/jquery/jquery"
        ],
        'jquery.owlcarousel' : ["libs/jquery/owl.carousel"],
        'jquery.appear' : ["libs/jquery/jquery.appear"],

        /* Palas */
        'palas-bootstrap' : ["libs/palas/bootstrap.min"],

        /* Underscore */
        underscore: [
            "http://cdnjs.cloudflare.com/ajax/libs/underscore.js/"+V_+"/underscore-min",
            "libs/underscore"
        ],

        /* App */
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
        'TermsCtrl': 'controller/TermsController',

        BackgroundImgDirective: "directive/BackgroundImgDirective",
        GiftPanelDirective: "directive/GiftPanelDirective",
        ProgressBarDirective: "directive/ProgressBarDirective"
    },
    shim: {
        /* Angular */
        'angularAMD': ['angular'],
        'angular-animate': ['angular'],
        'angular-route': ['angular'],
        'loading-bar': ['angular'],
        'ui-bootstrap': ['angular'],


        /* Jquery */
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
        },

        /* Modernizr */
        modernizr: ['Modernizr'],
        'underscore': {
            exports: "_" ,
            deps: ['jquery']
        },

        /* Palas */
        'palas-bootstrap' : {
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
        "BackgroundImgDirective", "GiftPanelDirective", "ProgressBarDirective",
        'palas-bootstrap',
        'app']
});
