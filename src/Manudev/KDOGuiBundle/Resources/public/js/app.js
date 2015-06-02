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




var gem = {
    name: 'Dodecahedron',
    price: 2.95,
    description: '. . .'
}



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


var app = angular.module('app', ['ngRoute', 'ui.bootstrap', 'angular-loading-bar', 'ngAnimate']);

var rootUrl = '/app_dev.php';
app.config(['$routeProvider', 'cfpLoadingBarProvider', function($routeProvider, cfpLoadingBarProvider) {

    //cfpLoadingBarProvider.includeSpinner = false;

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
    }
]);
app.controller('BodyController',['$rootScope', function($rootScope) {
    $rootScope.$on('cfpLoadingBar:started', function() {
        if ($("#preloader").length) {
            $('#giftLoader').fadeIn();
            $('#preloader').addClass('op8').fadeIn();
        }
    });
    $rootScope.$on('cfpLoadingBar:completed', function() {
        if ($("#preloader").length) {
            $('#giftLoader').fadeOut();
            $('#preloader').delay(300).fadeOut('slow').removeClass('op8');
        }
    });

    $win.load(function(){
        if ($("#preloader").length) {
            $('#giftLoader').fadeOut();
            $('#preloader').delay(300).fadeOut('slow').removeClass('op8');
            $body.delay(300).css({'overflow':'visible'});
        }
    });

}]);
app.controller('ContactController', function() {
    this.name = 'contact';
});
app.controller('Error403Controller', function() {
    this.name = '403';
});
app.controller('FooterController', function() {
    this.date = new Date();
});

app.controller('MainController', function($scope) {
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
    globalProgressBar($scope);
    loadStatsTime();

    this.name = "A propos"
});

app.controller('HomeController', function() {
    console.log('home controller');

    //if (($().owlCarousel) && ($(".owl-carousel").length)) {
        $(".owl-columns3").owlCarousel({
            /*itemsCustom: [[0,1],[767,2],[991,3]],
            navigation:false,
            pagination:false,
            autoplay:false*/
        });
    //}

});
app.controller('SigninController', function() {
    console.log('signin controller')
    this.name = "signin";
});
app.controller('SignupController', function() {
    console.log('signup controller')
    this.name = "signup";
});


var defaultHeadParameters = {
    siteDescription :   "Kdolist, gérer facilement votre liste de cadeau et partagé " +
                        "la à vos amis et votre famille.",
    siteTitle : "Kdolist"
};

app.controller('HtmlController', function($scope) {
    var self = this;
    self.head = defaultHeadParameters;

    $scope.$on('$routeChangeStart',  function() {
        self.head.siteDescription = defaultHeadParameters.siteDescription;
        self.head.siteTitle = defaultHeadParameters.siteTitle;
    });

    $scope.$on('siteDescriptionUpdate', function (event, args) {
        self.head.siteDescription = args + "\n-------\n" + defaultHeadParameters.siteDescription;
    });

    $scope.$on('siteTitleUpdate', function (event, args) {
        self.head.siteTitle = defaultHeadParameters.siteTitle + " - " + args;
    });

});


app.controller('ListController', ['$rootScope', '$scope', '$routeParams', '$http',
    function($rootScope, $scope, $routeParams, $http ) {

        var self = this;
        self.id = $routeParams.id;
        self.slug = $routeParams.slug;
        self.lists = [];
        self.currentGift = {
            total_gived: 500,
            total_reserved: 0,
            available_parts: 30,
            percent_done: 25,
            percent_reserved: 0
        };

        self.setData = function(newData) {
            self.lists = newData;
            $rootScope.$broadcast('siteDescriptionUpdate', newData.description);
            $rootScope.$broadcast('siteTitleUpdate', newData.title);
            $rootScope.$broadcast('setBg', newData.picture.web_path);
        };

        $http.get(rootUrl + '/api/lists/lists/' + self.id + '.json').success(function(data){
            self.setData(data[0]);
        });

        $scope.$on('modalGift', function(event, args) {
            self.currentGift = args;
        });
        loadStellar();
        loadTooltip();
        loadPopover();
    }
]);

app.directive('backroundImg', function() {
    return function(scope, element, attrs) {
        var url = attrs.backImg
        scope.$on('setBg', function(event, args){
            element.css({
                'background-image': 'url(' + args + ')',
                'background-size': 'cover',
                'background-repeat': 'no-repeat'
            });
        });
    };
});

app.directive('giftPanel', function() {
    return {
        templateUrl: rootUrl+'/directive/gift',
        scope: {
            gift: '='
        },
        controller: function($scope, $elem, attrs) {
            $scope.setModal = function() {
                $scope.$emit('modalGift', $scope.gift);
            };
        },
        controllerAs: 'giftDirective'
    };
});

app.directive('dProgressBar', function() {
    return {
        restrict: 'E',
        templateUrl: rootUrl + '/directive/progressBar',
        scope: {
            gift: '='
        },
        link: function ($scope, $elem, attrs) {
            loadProgressBar($elem, $scope);
            $scope.$watch('gift', function(newValue, oldValue) {
                if (newValue !== oldValue) {
                    loadFixedProgressBar($elem, $scope);
                }
            }, true);
        }
    };
});

var loadFixedProgressBar = function($elem, $scope) {
    var bars = $elem.find(".progress-bar");

    bars.each(function() {
        var bar = $(this);
        var percent = (bar.context.dataset.bartype === "gived")
            ? $scope.gift.percent_done
            : $scope.gift.percent_reserved;
        var computedPercent = percent / 100 * 80; // 20 removed for label.

        bar.css("width", computedPercent + "%");
    });
};

var loadProgressBar = function($elem, $scope) {
    var bars = $elem.find(".progress-bar");
    bars.each(function() {
        var bar = $(this);
        var percent = (bar.context.dataset.bartype === "gived")
            ? $scope.gift.percent_done
            : $scope.gift.percent_reserved;
        var computedPercent = percent / 100 * 80; // 20 removed for label.

        if (($().appear) && isMobileDevice === false && (bars.hasClass("no-anim") === false) ) {
            bar.appear(function () {
                bar.addClass("progress-bar-animate").css("width", computedPercent + "%");
            }, {accY: -150} );
        } else {
            bar.css("width", computedPercent + "%");
        }
    });
};


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

var loadPopover = function() {
    if ( $().popover ) {
        $("[data-toggle='popover']").popover();
    }
};

var loadTooltip = function() {
    if ( $().tooltip ) {
        $("[data-toggle='tooltip']").tooltip();
    }
};


var globalProgressBar = function($scope) {
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
};

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
