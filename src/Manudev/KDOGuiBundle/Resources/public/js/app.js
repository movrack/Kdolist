'use strict';
    //var angular = require('angular');
   // var services = require('./services/services');
   // var controllers = require('./controllers/controllers');
   // var directives = require('./directives/directives');
// Media Query fix (outerWidth -- scrollbar)
// Media queries width include the scrollbar
var $win = $(window)
var $body = $('body')
var mqWidth = $win.outerWidth(true,true)
var isMobileDevice = (( navigator.userAgent.match(/Android|webOS|iPhone|iPad|iPod|BlackBerry|Windows Phone|IEMobile|Opera Mini|Mobi/i) || (mqWidth < 767) ) ? true : false );

// detect IE browsers
var ie = (function(){
    var rv = 0,
        ua = window.navigator.userAgent,
        msie = ua.indexOf('MSIE '),
        trident = ua.indexOf('Trident/');

    if (msie > 0) {
        // IE 10 or older => return version number
        rv = parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    } else if (trident > 0) {
        // IE 11 (or newer) => return version number
        var rvNum = ua.indexOf('rv:');
        rv = parseInt(ua.substring(rvNum + 3, ua.indexOf('.', rvNum)), 10);
    }

    return ((rv > 0) ? rv : 0);
}());


var app = angular.module('app', ['ngRoute', 'ui.bootstrap']);

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
        .when('/list/:id', {
            templateUrl: rootUrl+'/gui/template/list',
            controller: 'ListController' } )
        .when('/list/:id/:slug', {
            templateUrl: rootUrl+'/gui/template/list',
            controller: 'ListController' } )
        .when('/faq', {
            templateUrl: rootUrl+'/gui/template/faq',
            controller: 'FaqController' } )
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

app.controller('FaqController', function($scope) {
    console.log('faq controller')

    this.tabs = { 'active' : 1 }
    this.name = "faq"
    $scope.oneAtATime = true;

});

app.controller('FeaturesController', function() {
    console.log('features controller')
    this.name = "Fonctionnalités"
});

app.controller('TermsController', function() {
    console.log('terms controller')
    this.name = "CGU"
});

app.controller('AboutController', function($scope) {
    console.log('about controller')
    loadProgressBar($scope);
    loadStatsTime();

    this.name = "A propos"
});
app.controller('HomeController', function() {
    console.log('home controller')
    this.name = "home"

    if (($().owlCarousel) && ($(".owl-carousel").length)) {
        $(".owl-columns3").owlCarousel({
            itemsCustom: [[0,1],[767,2],[991,3]],
            navigation:false,
            pagination:false,
            autoplay:false
        });
    }

});
app.controller('SigninController', function() {
    console.log('signin controller')
    this.name = "signin"
});
app.controller('SignupController', function() {
    console.log('signup controller')
    this.name = "signup"
});


app.controller('ListController', ['$routeParams', '$http', function($routeParams, $http) {
    var self = this;
    self.id = $routeParams.id;
    self.slug = $routeParams.slug;

    self.lists = [];
    $http.get(rootUrl + '/api/lists/lists/' + self.id + '.json').success(function(data){
        self.lists = data[0];
    });
    loadStellar();
    giftGridMasonry();
    /*
    this.lists = [{
            'name' : 'Cheminée',
            'description' : 'Il nous faudra une cheminée, sans quoi, Père Noël ne pourra pas venir chez nous !',
            'price' : 500,
            'nbOfParts' : 10,
            'offeredParts' : 2,
            'reservedParts' : 1,
            'picture' : 'http://baconmockup.com/300/200'
        },
        {
            'name' : 'Plancher',
            'description' : 'Ce serait dommage de marcher dans de la boue ou sur un béton pas joli et tout poussiéreux...',
            'price' : 2000,
            'nbOfParts' : 50,
            'offeredParts' : 10,
            'reservedParts' : 5,
            'picture' : 'http://baconmockup.com/400/350'
        },
        {
            'name' : 'Cheminée',
            'description' : 'Il nous faudra une cheminée, sans quoi, Père Noël ne pourra pas venir chez nous !',
            'price' : 500,
            'nbOfParts' : 10,
            'offeredParts' : 2,
            'reservedParts' : 1,
            'picture' : 'http://baconmockup.com/300/200'
        },
        {
            'name' : 'Plancher',
            'description' : 'Ce serait dommage de marcher dans de la boue ou sur un béton pas joli et tout poussiéreux...',
            'price' : 2000,
            'nbOfParts' : 50,
            'offeredParts' : 10,
            'reservedParts' : 5,
            'picture' : 'http://baconmockup.com/400/350'
        },
        {
            'name' : 'Cheminée',
            'description' : 'Il nous faudra une cheminée, sans quoi, Père Noël ne pourra pas venir chez nous !',
            'price' : 500,
            'nbOfParts' : 10,
            'offeredParts' : 2,
            'reservedParts' : 1,
            'picture' : 'http://baconmockup.com/300/200'
        },
        {
            'name' : 'Plancher',
            'description' : 'Ce serait dommage de marcher dans de la boue ou sur un béton pas joli et tout poussiéreux...',
            'price' : 2000,
            'nbOfParts' : 50,
            'offeredParts' : 10,
            'reservedParts' : 5,
            'picture' : 'http://baconmockup.com/400/350'
        },
        {
            'name' : 'Cheminée',
            'description' : 'Il nous faudra une cheminée, sans quoi, Père Noël ne pourra pas venir chez nous !',
            'price' : 500,
            'nbOfParts' : 10,
            'offeredParts' : 2,
            'reservedParts' : 1,
            'picture' : 'http://baconmockup.com/300/200'
        },
        {
            'name' : 'Plancher',
            'description' : 'Ce serait dommage de marcher dans de la boue ou sur un béton pas joli et tout poussiéreux...',
            'price' : 2000,
            'nbOfParts' : 50,
            'offeredParts' : 10,
            'reservedParts' : 5,
            'picture' : 'http://baconmockup.com/400/350'
        },
        {
            'name' : 'Cheminée',
            'description' : 'Il nous faudra une cheminée, sans quoi, Père Noël ne pourra pas venir chez nous !',
            'price' : 500,
            'nbOfParts' : 10,
            'offeredParts' : 2,
            'reservedParts' : 1,
            'picture' : 'http://baconmockup.com/300/200'
        },
        {
            'name' : 'Plancher',
            'description' : 'Ce serait dommage de marcher dans de la boue ou sur un béton pas joli et tout poussiéreux...',
            'price' : 2000,
            'nbOfParts' : 50,
            'offeredParts' : 10,
            'reservedParts' : 5,
            'picture' : 'http://baconmockup.com/400/350'
        },
        {
            'name' : 'Cheminée',
            'description' : 'Il nous faudra une cheminée, sans quoi, Père Noël ne pourra pas venir chez nous !',
            'price' : 500,
            'nbOfParts' : 10,
            'offeredParts' : 2,
            'reservedParts' : 1,
            'picture' : 'http://baconmockup.com/300/200'
        },
        {
            'name' : 'Plancher',
            'description' : 'Ce serait dommage de marcher dans de la boue ou sur un béton pas joli et tout poussiéreux...',
            'price' : 2000,
            'nbOfParts' : 50,
            'offeredParts' : 10,
            'reservedParts' : 5,
            'picture' : 'http://baconmockup.com/400/350'
        }];
    */
}]);

app.directive('giftPanel', function(){
    return {
        restrict: 'E',
        templateUrl: rootUrl+'/gui/directive/gift',

        scope: { gift: '=' },
        controller: function($scope){
            $(".progress").each(function() {

                var $this = $(this);
                if (($().appear) && isMobileDevice === false && ($this.hasClass("no-anim") === false) ) {
                    $this.appear(function () {
                        var $bar = $this.find(".progress-bar");
                        $bar.addClass("progress-bar-animate").css("width", $bar.attr("data-percentage") + "%");
                    }, {accY: -150} );
                } else {
                    var $bar = $this.find(".progress-bar");
                    $bar.css("width", $bar.attr("data-percentage") + "%");
                }
            });
           //giftGridMasonry();
        },
        controllerAs: 'giftDirective'
    };
});

var gem = {
    name: 'Dodecahedron',
    price: 2.95,
    description: '. . .'
}

var loadStellar = function() {

    if ( ($(".stellar").length) && $(window).width() > 767 ) {

        $body.stellar({
            horizontalScrolling: false,
            verticalOffset: 0,
            horizontalOffset: 0,
            responsive: true,
            scrollProperty: 'scroll',
            parallaxElements: false
        });
    }
}

var giftGridMasonry = function() {


    if ( $().isotope && $('#portfolio-isotope').length) {

        var $portfolio = $('.masonery');
        if (ie) {

            var portfolioRow = $("#masonery-isotope").find(".row");
            var $gutter = 30;

            if (portfolioRow.hasClass("col-p5")) {
                $gutter = 10;
            } else if (portfolioRow.hasClass("col-p10")) {
                $gutter = 20;
            } else if (portfolioRow.hasClass("col-p20")) {
                $gutter = 40;
            } else if (portfolioRow.hasClass("col-p30")) {
                $gutter = 60;
            } else if (portfolioRow.hasClass("col-p0")) {
                $gutter = 0;
            }



            var $item = $portfolio.find('.el'),
                itemWidth = $item.outerWidth(true) - $gutter;

            portfolioRow.css({"margin-left":0});

            (function() {

                function fixGrid() {
                    $item.each(function() {
                        $item.css({
                            'width': itemWidth + 'px',
                            'padding-left':0,
                            'padding-right':0
                        });
                    });
                }
                fixGrid();

                $win.resize(function() {
                    fixGrid();
                });

            })();

            $portfolio.isotope({
                itemSelector:'.el',
                filter: '*',
                layoutMode: "masonry",
                transitionDuration:'0.6s',
                masonry: {
                    columnWidth:'.el',
                    gutter:$gutter
                }
            });

        } else {

            $portfolio.imagesLoaded(function() {
                $portfolio.isotope({
                    itemSelector:'.el',
                    filter: '*',
                    layoutMode: 'masonry',
                    transitionDuration:'0.6s',
                    masonry: {
                        columnWidth:'.el'
                    }
                });
            });
        }



    } // END if
}

var loadProgressBar = function($scope) {
    $scope.$on('$viewContentLoaded', function(){
        $(".progress").each(function() {

            var $this = $(this);

            if (($().appear) && isMobileDevice === false && ($this.hasClass("no-anim") === false) ) {
                $this.appear(function () {
                    var $bar = $this.find(".progress-bar");
                    $bar.addClass("progress-bar-animate").css("width", $bar.attr("data-percentage") + "%");
                }, {accY: -150} );
            } else {
                var $bar = $this.find(".progress-bar");
                $bar.css("width", $bar.attr("data-percentage") + "%");
            }
        });
    });
}
var loadStatsTime = function() {
    // Include CountTo
    if ($('.stats-timer').length) {
        (function(e){function t(e,t){return e.toFixed(t.decimals)}e.fn.countTo=function(t){t=t||{};return e(this).each(function(){function l(){a+=i;u++;c(a);if(typeof n.onUpdate=="function"){n.onUpdate.call(s,a)}if(u>=r){o.removeData("countTo");clearInterval(f.interval);a=n.to;if(typeof n.onComplete=="function"){n.onComplete.call(s,a)}}}function c(e){var t=n.formatter.call(s,e,n);o.text(t)}var n=e.extend({},e.fn.countTo.defaults,{from:e(this).data("from"),to:e(this).data("to"),speed:e(this).data("speed"),refreshInterval:e(this).data("refresh-interval"),decimals:e(this).data("decimals")},t);var r=Math.ceil(n.speed/n.refreshInterval),i=(n.to-n.from)/r;var s=this,o=e(this),u=0,a=n.from,f=o.data("countTo")||{};o.data("countTo",f);if(f.interval){clearInterval(f.interval)}f.interval=setInterval(l,n.refreshInterval);c(a)})};e.fn.countTo.defaults={from:0,to:0,speed:1e3,refreshInterval:100,decimals:0,formatter:t,onUpdate:null,onComplete:null}})(jQuery);
    }

    // countTo plugin configarations
    if( ($().countTo) && ($('.stats-timer').length) ) {

        if (isMobileDevice) {
            $('.stats-content').find(".stats-timer").countTo();
        } else {
            // appear init and then countTo
            $(".stats-content").appear(function() {
                $(this).find(".stats-timer").countTo();
            });
        }

    } // END if
}
