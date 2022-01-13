/**
 * @preserve
 * Project: Bootstrap Hover Dropdown
 * Author: Cameron Spear
 * Version: v2.1.3
 * Contributors: Mattia Larentis
 * Dependencies: Bootstrap's Dropdown plugin, jQuery
 * Description: A simple plugin to enable Bootstrap dropdowns to active on hover and provide a nice user experience.
 * License: MIT
 * Homepage: http://cameronspear.com/blog/bootstrap-dropdown-on-hover-plugin/
 */
! function($, e, t) {
    var n = $();
    $.fn.dropdownHover = function(t) {
        return "ontouchstart" in document ? this : (n = n.add(this.parent()), this.each(function() {
            function a() {
                e.clearTimeout(u), e.clearTimeout(h), h = e.setTimeout(function() {
                    n.find(":focus").blur(), d.instantlyCloseOthers === !0 && n.removeClass("open"), e.clearTimeout(h), o.attr("aria-expanded", "true"), i.addClass("open"), o.trigger(c)
                }, d.hoverDelay)
            }
            var o = $(this),
                i = o.parent(),
                r = {
                    delay: 500,
                    hoverDelay: 0,
                    instantlyCloseOthers: !0
                },
                l = {
                    delay: $(this).data("delay"),
                    hoverDelay: $(this).data("hover-delay"),
                    instantlyCloseOthers: $(this).data("close-others")
                },
                c = "show.bs.dropdown",
                s = "hide.bs.dropdown",
                d = $.extend(!0, {}, r, t, l),
                u, h;
            i.hover(function(e) {
                return i.hasClass("open") || o.is(e.target) ? void a() : !0
            }, function() {
                e.clearTimeout(h), u = e.setTimeout(function() {
                    o.attr("aria-expanded", "false"), i.removeClass("open"), o.trigger(s)
                }, d.delay)
            }), o.hover(function(e) {
                return i.hasClass("open") || i.is(e.target) ? void a() : !0
            }), i.find(".dropdown-submenu").each(function() {
                var t = $(this),
                    n;
                t.hover(function() {
                    e.clearTimeout(n), t.children(".dropdown-menu").show(), t.siblings().children(".dropdown-menu").hide()
                }, function() {
                    var a = t.children(".dropdown-menu");
                    n = e.setTimeout(function() {
                        a.hide()
                    }, d.delay)
                })
            })
        }))
    }
}(jQuery, window),
function($) {
    $.fn.appear = function(e, t) {
        var n = $.extend({
            data: void 0,
            one: !0,
            accX: 0,
            accY: 0
        }, t);
        return this.each(function() {
            var t = $(this);
            if (t.appeared = !1, !e) return void t.trigger("appear", n.data);
            var a = $(window),
                o = function() {
                    if (!t.is(":visible")) return void(t.appeared = !1);
                    var e = a.scrollLeft(),
                        o = a.scrollTop(),
                        i = t.offset(),
                        r = i.left,
                        l = i.top,
                        c = n.accX,
                        s = n.accY,
                        d = t.height(),
                        u = a.height(),
                        h = t.width(),
                        f = a.width();
                    l + d + s >= o && o + u + s >= l && r + h + c >= e && e + f + c >= r ? t.appeared || t.trigger("appear", n.data) : t.appeared = !1
                },
                i = function() {
                    if (t.appeared = !0, n.one) {
                        a.unbind("scroll", o);
                        var i = $.inArray(o, $.fn.appear.checks);
                        i >= 0 && $.fn.appear.checks.splice(i, 1)
                    }
                    e.apply(this, arguments)
                };
            n.one ? t.one("appear", n.data, i) : t.bind("appear", n.data, i), a.scroll(o), $.fn.appear.checks.push(o), o()
        })
    }, $.extend($.fn.appear, {
        checks: [],
        timeout: null,
        checkAll: function() {
            var e = $.fn.appear.checks.length;
            if (e > 0)
                for (; e--;) $.fn.appear.checks[e]()
        },
        run: function() {
            $.fn.appear.timeout && clearTimeout($.fn.appear.timeout), $.fn.appear.timeout = setTimeout($.fn.appear.checkAll, 20)
        }
    }), $.each(["append", "prepend", "after", "before", "attr", "removeAttr", "addClass", "removeClass", "toggleClass", "remove", "css", "show", "hide"], function(e, t) {
        var n = $.fn[t];
        n && ($.fn[t] = function() {
            var e = n.apply(this, arguments);
            return $.fn.appear.run(), e
        })
    })
}(jQuery),
function($, e, t, n) {
    function a(e, t) {
        this.element = e, this.options = $.extend({}, i, t), this._defaults = i, this._name = o, this.init()
    }
    var o = "smartEmbed",
        i = {
            autoplay: !0,
            width: "auto",
            playIcon: "fa fa-play-circle-o",
            onComplete: function() {},
            onError: function() {}
        };
    a.prototype = {
        init: function() {
            var e = this.options;
            $(this.element).each(function(t, n) {
                var a = $(n),
                    o = a.data("vimeo-id"),
                    i = a.data("youtube-id"),
                    r = e.playIcon,
                    l = "https://player.vimeo.com/video/";
                "undefined" != typeof o ? l = "https://player.vimeo.com/video/" + o : "undefined" != typeof i && (l = "https://www.youtube.com/embed/" + i);
                var c = l + "?autoplay=" + e.autoplay,
                    s = $('<iframe src="' + c + '" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
                e.width === parseInt(e.width, 10) && (c += "&width=" + e.width), a.parent().prepend('<i class="play-icon ' + r + '"/>').on("click", function() {
                    var t = $(this);
                    t.find("iframe").length || t.append(s).find("img, .play-icon").hide(), e.onComplete && "function" == typeof e.onComplete && e.onComplete.call(this)
                })
            })
        }
    }, $.fn[o] = function(e) {
        return this.each(function() {
            $.data(this, "plugin_" + o) || $.data(this, "plugin_" + o, new a(this, e))
        })
    }
}(jQuery, window, document), jQuery(document).ready(function($) {
    $('[data-toggle="animation-appear"]').each(function() {
        var e = $(this),
            t = e.data("animation-class"),
            n = e.data("element-offset");
        e.appear(function() {
            e.removeClass("invisible").addClass(t)
        }, {
            accY: n
        })
    })
}), jQuery(document).ready(function($) {
    $(".sidebar-sticky").length > 0 && $("body").scrollspy({
        target: ".sidebar-sticky",
        offset: $(".header-main").height()
    }), $(".sidebar-sticky").affix({
        offset: {
            top: function() {
                var e = 0,
                    t = 0;
                if ($(".site-section-top").length > 0) e = $(".site-section-top").height();
                else {
                    if (!($(".breadcrumb-wrapper").length > 0)) return 105;
                    t = $(".breadcrumb-wrapper").height()
                }
                return e + t
            },
            bottom: $("footer").outerHeight() + 50
        }
    }), $(".menu-secondary-sticky").length > 0 && $("body").scrollspy({
        target: ".menu-secondary-sticky",
        offset: $(".header-main").height() + $(".menu-secondary").height()
    })
}), jQuery(document).ready(function($) {
    $(".menu-secondary-sticky").affix({
        offset: {
            top: function() {
                return $(".site-section-top").height()
            }
        }
    })
}), jQuery(document).ready(function($) {
    var e = $("body");
    $(".nav-toggle").on("click", function(t) {
        t.preventDefault(), e.toggleClass("nav-visible")
    }), $(".touch-overlay").on("touchstart click", function(t) {
        t.preventDefault(), e.toggleClass("nav-visible")
    })
}), jQuery(document).ready(function($) {
    function e() {
        $(window).width() >= 975 ? ($('.navbar:not(.disable-hover) [data-toggle="dropdown"]').dropdownHover({
            delay: 200
        }), $('.mega-menu-full [data-toggle="dropdown"]').removeClass("disabled")) : $('.navbar:not(.disable-hover) [data-toggle="dropdown"]').length && $('.mega-menu-full [data-toggle="dropdown"]').addClass("disabled")
    }
    e(), $(window).resize(e()), $('.navbar:not(.disable-hover) [data-toggle="dropdown"]').click(function() {
        location.href = this.href
    })
}), jQuery(document).ready(function($) {
    $(".top-search > a").click(function(e) {
        e.preventDefault(), $(".top-tools-container").slideUp(250, "linear"), $(".top-search-container").slideToggle(250, "linear")
    }), $(".carousel-search-box input").focus(function() {
        var e = $("#home-carousel");
        e.carousel("pause")
    })
}), jQuery(document).ready(function($) {
    $(".top-tools > a").click(function(e) {
        e.preventDefault(), $(".top-search-container").slideUp(250, "linear"), $(".top-tools-container").slideToggle(250, "linear")
    })
}), jQuery(document).ready(function($) {
    function e(e) {
        if (e = e.length ? e : $("[name=" + this.hash.slice(1) + "]"), e.length) {
            var t = $(".header-main"),
                n = $(".menu-secondary"),
                a = 0;
            t.length > 0 && (a += t.height()), n.length > 0 && (a += n.height()), $("html,body").animate({
                scrollTop: e.offset().top - a
            }, 500)
        }
    }
    setTimeout(function() {
        if (location.hash) {
            window.scrollTo(0, 0);
            var t = location.hash.split("#");
            e($("#" + t[1]))
        }
    }, 1), $('.scroll-to a[href*="#"]:not([href="#"])').click(function() {
        return location.pathname.replace(/^\//, "") === this.pathname.replace(/^\//, "") && location.hostname === this.hostname ? (e($(this.hash)), !1) : void 0
    })
}), jQuery(document).ready(function($) {
    $(window).scroll(function() {
        $(this).scrollTop() > 100 ? $(".scroll-to-top").fadeIn() : $(".scroll-to-top").fadeOut()
    }), $(".scroll-to-top").click(function() {
        $("body").animate({
            scrollTop: 0
        }, 800)
    })
}), jQuery(document).ready(function($) {
    $.fn.smartEmbed && $(".embed-smart").smartEmbed()
}), jQuery(document).ready(function($) {
    if ($(".bg-video").click(function() {
            if ($("html#ie8").length) return void $(".ie8-html5-video-modal").modal();
            var e = $("#home-carousel"),
                t = $(this).find(".caption"),
                n = $(this).find("video")[0];
            n.paused === !0 ? (e.carousel("pause"), n.play(), $(t).fadeOut()) : (n.pause(), $(t).show()), n.addEventListener("ended", function() {
                e.carousel("next"), e.carousel("cycle")
            })
        }), $("#home-carousel").on("slide.bs.carousel", function() {
            if (!$("html#ie8").length) {
                var e = $(this).find(".active .bg-video"),
                    t = $(this).find(".caption"),
                    n = $(this).find("video")[0];
                e.length && (n.paused || (n.pause(), $(t).fadeIn(), $(this).carousel("cycle")))
            }
        }), $(".vimeo-video").click(function() {
            var e = $("#home-carousel"),
                t = $(this).data("target"),
                n = $(t).find("iframe"),
                a = n.attr("src"),
                o = window.JSON.stringify({
                    method: "play"
                });
            n[0].contentWindow.postMessage(o, a), e.carousel("pause")
        }), $("#home-carousel .modal").on("hide.bs.modal", function() {
            var e = $("#home-carousel"),
                t = $(this).find("iframe"),
                n = t.attr("src"),
                a = window.JSON.stringify({
                    method: "pause"
                });
            t[0].contentWindow.postMessage(a, n), e.carousel("next"), e.carousel("cycle")
        }), $(window).width() <= 320 && $(".bg-video").length) {
        var e = $(".bg-video").find("video");
        e.attr("poster", "img/quadaerial01_800.jpg"), e.css({
            "min-width": "initial",
            "min-height": 100,
            "max-height": 100
        })
    }
}), jQuery(document).ready(function($) {
    $(".box-clickable").click(function() {
        $(this).find("a").length > 0 && (window.location.href = $(this).find("a:first").attr("href"))
    }).hover(function() {
        $(this).find("a").length > 0 && (window.status = $(this).find("a:first").attr("href"))
    }, function() {
        window.status = ""
    })
}), jQuery(document).ready(function($) {
    if ($("#az-index").length) {
        var e = {
                valueNames: ["title", "category"],
                page: [1e3]
            },
            t = new List("az-index", e);
        $(".filter").click(function(e) {
            e.preventDefault();
            var n = $(this).data("filter"),
                a = $(this).text(),
                o = String(a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
            "none" === n ? t.filter() : t.filter(function(e) {
                return e.values().category === o
            })
        })
    }
}), jQuery(document).ready(function($) {
    ($("html#ie8").length > 0 || $("html#ie9").length > 0) && $("[placeholder]").focus(function() {
        var e = $(this);
        e.val() === e.attr("placeholder") && (e.val(""), e.removeClass("placeholder"))
    }).blur(function() {
        var e = $(this);
        "" !== e.val() && e.val() !== e.attr("placeholder") || (e.addClass("placeholder"), e.val(e.attr("placeholder")))
    }).blur().parents("form").submit(function() {
        $(this).find("[placeholder]").each(function() {
            var e = $(this);
            e.val() === e.attr("placeholder") && e.val("")
        })
    })
});