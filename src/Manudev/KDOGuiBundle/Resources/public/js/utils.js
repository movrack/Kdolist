define("utils", ['jquery', 'underscore'], function ($, _) {
    var self = {const:{}, fn:{}};

    self.const.rootUrl = '/app_dev.php';
    self.const.$win = $(window);
    self.const.$body = $('body');

        // Media Query fix (outerWidth -- scrollbar)
        // Media queries width include the scrollbar
    self.const.mqWidth = self.const.$win.outerWidth(true, true);
    self.const.isMobileDevice = (( navigator.userAgent.match(/Android|webOS|iPhone|iPad|iPod|BlackBerry|Windows Phone|IEMobile|Opera Mini|Mobi/i) || (self.const.mqWidth < 767) ) ? true : false );

        // detect IE browsers
    self.const.ie = function() {
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
    }();

    self.fn.loadFixedProgressBar = function ($elem, $scope) {
        var bars = $elem.find(".progress-bar");

        bars.each(function () {
            var bar = $(this);
            var percent = (bar.context.dataset.bartype === "gived")
                ? $scope.gift.percent_done
                : $scope.gift.percent_reserved;
            var computedPercent = percent / 100 * 80; // 20 removed for label.

            bar.css("width", computedPercent + "%");
        });
    };

    self.fn.loadProgressBar = function ($elem, $scope) {
        var bars = $elem.find(".progress-bar");
        bars.each(function () {
            var bar = $(this);
            var percent = (bar.context.dataset.bartype === "gived")
                ? $scope.gift.percent_done
                : $scope.gift.percent_reserved;
            var computedPercent = percent / 100 * 80; // 20 removed for label.

            if (($().appear) && self.const.isMobileDevice === false && (bars.hasClass("no-anim") === false)) {
                bar.appear(function () {
                    bar.addClass("progress-bar-animate").css("width", computedPercent + "%");
                }, {accY: -150});
            } else {
                bar.css("width", computedPercent + "%");
            }
        });
    };

    self.fn.loadStellar = function () {
        if (($(".stellar").length) && self.const.$win.width() > 767) {

            $body.stellar({
                horizontalScrolling: false,
                verticalOffset: 0,
                horizontalOffset: 0,
                responsive: true,
                scrollProperty: 'scroll',
                parallaxElements: false
            });
        }
    };

    self.fn.loadPopover = function () {
        if ($().popover) {
            $("[data-toggle='popover']").popover();
        }
    };

    self.fn.loadTooltip = function () {
        if ($().tooltip) {
            $("[data-toggle='tooltip']").tooltip();
        }
    };
    self.fn.globalProgressBar = function ($scope) {
        $scope.$on('$viewContentLoaded', function () {
            $(".progress").each(function () {

                var $this = $(this);

                if (($().appear) && self.const.isMobileDevice === false && ($this.hasClass("no-anim") === false)) {
                    $this.appear(function () {
                        var $bar = $this.find(".progress-bar");
                        $bar.addClass("progress-bar-animate").css("width", $bar.attr("data-percentage") + "%");
                    }, {accY: -150});
                } else {
                    var $bar = $this.find(".progress-bar");
                    $bar.css("width", $bar.attr("data-percentage") + "%");
                }
            });
        });
    };

    self.fn.loadStatsTime = function () {
        // Include CountTo
        if ($('.stats-timer').length) {
            (function (e) {
                function t(e, t) {
                    return e.toFixed(t.decimals)
                }

                e.fn.countTo = function (t) {
                    t = t || {};
                    return e(this).each(function () {
                        function l() {
                            a += i;
                            u++;
                            c(a);
                            if (typeof n.onUpdate == "function") {
                                n.onUpdate.call(s, a)
                            }
                            if (u >= r) {
                                o.removeData("countTo");
                                clearInterval(f.interval);
                                a = n.to;
                                if (typeof n.onComplete == "function") {
                                    n.onComplete.call(s, a)
                                }
                            }
                        }

                        function c(e) {
                            var t = n.formatter.call(s, e, n);
                            o.text(t)
                        }

                        var n = e.extend({}, e.fn.countTo.defaults, {
                            from: e(this).data("from"),
                            to: e(this).data("to"),
                            speed: e(this).data("speed"),
                            refreshInterval: e(this).data("refresh-interval"),
                            decimals: e(this).data("decimals")
                        }, t);
                        var r = Math.ceil(n.speed / n.refreshInterval), i = (n.to - n.from) / r;
                        var s = this, o = e(this), u = 0, a = n.from, f = o.data("countTo") || {};
                        o.data("countTo", f);
                        if (f.interval) {
                            clearInterval(f.interval)
                        }
                        f.interval = setInterval(l, n.refreshInterval);
                        c(a)
                    })
                };
                e.fn.countTo.defaults = {
                    from: 0,
                    to: 0,
                    speed: 1e3,
                    refreshInterval: 100,
                    decimals: 0,
                    formatter: t,
                    onUpdate: null,
                    onComplete: null
                }
            })(jQuery);
        }

        // countTo plugin configarations
        if (($().countTo) && ($('.stats-timer').length)) {

            if (self.const.isMobileDevice) {
                $('.stats-content').find(".stats-timer").countTo();
            } else {
                // appear init and then countTo
                if ($().appear) {
                    $(".stats-content").appear(function () {
                        $(this).find(".stats-timer").countTo();
                    });
                }
            }

        } // END if
    };
    return self;
});