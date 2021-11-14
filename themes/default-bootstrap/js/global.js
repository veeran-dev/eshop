/**
 * BxSlider v4.1.2 - Fully loaded, responsive content slider
 * http://bxslider.com
 *
 * Copyright 2014, Steven Wanderski - http://stevenwanderski.com - http://bxcreative.com
 * Written while drinking Belgian ales and listening to jazz
 *
 * Released under the MIT license - http://opensource.org/licenses/MIT
 */
!function(t){var e={},s={mode:"horizontal",slideSelector:"",infiniteLoop:!0,hideControlOnEnd:!1,speed:500,easing:null,slideMargin:0,startSlide:0,randomStart:!1,captions:!1,ticker:!1,tickerHover:!1,adaptiveHeight:!1,adaptiveHeightSpeed:500,video:!1,useCSS:!0,preloadImages:"visible",responsive:!0,slideZIndex:50,touchEnabled:!0,swipeThreshold:50,oneToOneTouch:!0,preventDefaultSwipeX:!0,preventDefaultSwipeY:!1,pager:!0,pagerType:"full",pagerShortSeparator:" / ",pagerSelector:null,buildPager:null,pagerCustom:null,controls:!0,nextText:"Next",prevText:"Prev",nextSelector:null,prevSelector:null,autoControls:!1,startText:"Start",stopText:"Stop",autoControlsCombine:!1,autoControlsSelector:null,auto:!1,pause:4e3,autoStart:!0,autoDirection:"next",autoHover:!1,autoDelay:0,minSlides:1,maxSlides:1,moveSlides:0,slideWidth:0,onSliderLoad:function(){},onSlideBefore:function(){},onSlideAfter:function(){},onSlideNext:function(){},onSlidePrev:function(){},onSliderResize:function(){}};t.fn.bxSlider=function(n){if(0==this.length)return this;if(this.length>1)return this.each(function(){t(this).bxSlider(n)}),this;var o={},r=this;e.el=this;var a=t(window).width(),l=t(window).height(),d=function(){o.settings=t.extend({},s,n),o.settings.slideWidth=parseInt(o.settings.slideWidth),o.children=r.children(o.settings.slideSelector),o.children.length<o.settings.minSlides&&(o.settings.minSlides=o.children.length),o.children.length<o.settings.maxSlides&&(o.settings.maxSlides=o.children.length),o.settings.randomStart&&(o.settings.startSlide=Math.floor(Math.random()*o.children.length)),o.active={index:o.settings.startSlide},o.carousel=o.settings.minSlides>1||o.settings.maxSlides>1,o.carousel&&(o.settings.preloadImages="all"),o.minThreshold=o.settings.minSlides*o.settings.slideWidth+(o.settings.minSlides-1)*o.settings.slideMargin,o.maxThreshold=o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin,o.working=!1,o.controls={},o.interval=null,o.animProp="vertical"==o.settings.mode?"top":"left",o.usingCSS=o.settings.useCSS&&"fade"!=o.settings.mode&&function(){var t=document.createElement("div"),e=["WebkitPerspective","MozPerspective","OPerspective","msPerspective"];for(var i in e)if(void 0!==t.style[e[i]])return o.cssPrefix=e[i].replace("Perspective","").toLowerCase(),o.animProp="-"+o.cssPrefix+"-transform",!0;return!1}(),"vertical"==o.settings.mode&&(o.settings.maxSlides=o.settings.minSlides),r.data("origStyle",r.attr("style")),r.children(o.settings.slideSelector).each(function(){t(this).data("origStyle",t(this).attr("style"))}),c()},c=function(){r.wrap('<div class="bx-wrapper"><div class="bx-viewport"></div></div>'),o.viewport=r.parent(),o.loader=t('<div class="bx-loading" />'),o.viewport.prepend(o.loader),r.css({width:"horizontal"==o.settings.mode?100*o.children.length+215+"%":"auto",position:"relative"}),o.usingCSS&&o.settings.easing?r.css("-"+o.cssPrefix+"-transition-timing-function",o.settings.easing):o.settings.easing||(o.settings.easing="swing"),f(),o.viewport.css({width:"100%",overflow:"hidden",position:"relative"}),o.viewport.parent().css({maxWidth:p()}),o.settings.pager||o.viewport.parent().css({margin:"0 auto 0px"}),o.children.css({"float":"horizontal"==o.settings.mode?"left":"none",listStyle:"none",position:"relative"}),o.children.css("width",u()),"horizontal"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginRight",o.settings.slideMargin),"vertical"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginBottom",o.settings.slideMargin),"fade"==o.settings.mode&&(o.children.css({position:"absolute",zIndex:0,display:"none"}),o.children.eq(o.settings.startSlide).css({zIndex:o.settings.slideZIndex,display:"block"})),o.controls.el=t('<div class="bx-controls" />'),o.settings.captions&&P(),o.active.last=o.settings.startSlide==x()-1,o.settings.video&&r.fitVids();var e=o.children.eq(o.settings.startSlide);"all"==o.settings.preloadImages&&(e=o.children),o.settings.ticker?o.settings.pager=!1:(o.settings.pager&&T(),o.settings.controls&&C(),o.settings.auto&&o.settings.autoControls&&E(),(o.settings.controls||o.settings.autoControls||o.settings.pager)&&o.viewport.after(o.controls.el)),g(e,h)},g=function(e,i){var s=e.find("img, iframe").length;if(0==s)return i(),void 0;var n=0;e.find("img, iframe").each(function(){t(this).one("load",function(){++n==s&&i()}).each(function(){this.complete&&t(this).load()})})},h=function(){if(o.settings.infiniteLoop&&"fade"!=o.settings.mode&&!o.settings.ticker){var e="vertical"==o.settings.mode?o.settings.minSlides:o.settings.maxSlides,i=o.children.slice(0,e).clone().addClass("bx-clone"),s=o.children.slice(-e).clone().addClass("bx-clone");r.append(i).prepend(s)}o.loader.remove(),S(),"vertical"==o.settings.mode&&(o.settings.adaptiveHeight=!0),o.viewport.height(v()),r.redrawSlider(),o.settings.onSliderLoad(o.active.index),o.initialized=!0,o.settings.responsive&&t(window).bind("resize",Z),o.settings.auto&&o.settings.autoStart&&H(),o.settings.ticker&&L(),o.settings.pager&&q(o.settings.startSlide),o.settings.controls&&W(),o.settings.touchEnabled&&!o.settings.ticker&&O()},v=function(){var e=0,s=t();if("vertical"==o.settings.mode||o.settings.adaptiveHeight)if(o.carousel){var n=1==o.settings.moveSlides?o.active.index:o.active.index*m();for(s=o.children.eq(n),i=1;i<=o.settings.maxSlides-1;i++)s=n+i>=o.children.length?s.add(o.children.eq(i-1)):s.add(o.children.eq(n+i))}else s=o.children.eq(o.active.index);else s=o.children;return"vertical"==o.settings.mode?(s.each(function(){e+=t(this).outerHeight()}),o.settings.slideMargin>0&&(e+=o.settings.slideMargin*(o.settings.minSlides-1))):e=Math.max.apply(Math,s.map(function(){return t(this).outerHeight(!1)}).get()),e},p=function(){var t="100%";return o.settings.slideWidth>0&&(t="horizontal"==o.settings.mode?o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin:o.settings.slideWidth),t},u=function(){var t=o.settings.slideWidth,e=o.viewport.width();return 0==o.settings.slideWidth||o.settings.slideWidth>e&&!o.carousel||"vertical"==o.settings.mode?t=e:o.settings.maxSlides>1&&"horizontal"==o.settings.mode&&(e>o.maxThreshold||e<o.minThreshold&&(t=(e-o.settings.slideMargin*(o.settings.minSlides-1))/o.settings.minSlides)),t},f=function(){var t=1;if("horizontal"==o.settings.mode&&o.settings.slideWidth>0)if(o.viewport.width()<o.minThreshold)t=o.settings.minSlides;else if(o.viewport.width()>o.maxThreshold)t=o.settings.maxSlides;else{var e=o.children.first().width();t=Math.floor(o.viewport.width()/e)}else"vertical"==o.settings.mode&&(t=o.settings.minSlides);return t},x=function(){var t=0;if(o.settings.moveSlides>0)if(o.settings.infiniteLoop)t=o.children.length/m();else for(var e=0,i=0;e<o.children.length;)++t,e=i+f(),i+=o.settings.moveSlides<=f()?o.settings.moveSlides:f();else t=Math.ceil(o.children.length/f());return t},m=function(){return o.settings.moveSlides>0&&o.settings.moveSlides<=f()?o.settings.moveSlides:f()},S=function(){if(o.children.length>o.settings.maxSlides&&o.active.last&&!o.settings.infiniteLoop){if("horizontal"==o.settings.mode){var t=o.children.last(),e=t.position();b(-(e.left-(o.viewport.width()-t.width())),"reset",0)}else if("vertical"==o.settings.mode){var i=o.children.length-o.settings.minSlides,e=o.children.eq(i).position();b(-e.top,"reset",0)}}else{var e=o.children.eq(o.active.index*m()).position();o.active.index==x()-1&&(o.active.last=!0),void 0!=e&&("horizontal"==o.settings.mode?b(-e.left,"reset",0):"vertical"==o.settings.mode&&b(-e.top,"reset",0))}},b=function(t,e,i,s){if(o.usingCSS){var n="vertical"==o.settings.mode?"translate3d(0, "+t+"px, 0)":"translate3d("+t+"px, 0, 0)";r.css("-"+o.cssPrefix+"-transition-duration",i/1e3+"s"),"slide"==e?(r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),D()})):"reset"==e?r.css(o.animProp,n):"ticker"==e&&(r.css("-"+o.cssPrefix+"-transition-timing-function","linear"),r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),b(s.resetValue,"reset",0),N()}))}else{var a={};a[o.animProp]=t,"slide"==e?r.animate(a,i,o.settings.easing,function(){D()}):"reset"==e?r.css(o.animProp,t):"ticker"==e&&r.animate(a,speed,"linear",function(){b(s.resetValue,"reset",0),N()})}},w=function(){for(var e="",i=x(),s=0;i>s;s++){var n="";o.settings.buildPager&&t.isFunction(o.settings.buildPager)?(n=o.settings.buildPager(s),o.pagerEl.addClass("bx-custom-pager")):(n=s+1,o.pagerEl.addClass("bx-default-pager")),e+='<div class="bx-pager-item"><a href="" data-slide-index="'+s+'" class="bx-pager-link">'+n+"</a></div>"}o.pagerEl.html(e)},T=function(){o.settings.pagerCustom?o.pagerEl=t(o.settings.pagerCustom):(o.pagerEl=t('<div class="bx-pager" />'),o.settings.pagerSelector?t(o.settings.pagerSelector).html(o.pagerEl):o.controls.el.addClass("bx-has-pager").append(o.pagerEl),w()),o.pagerEl.on("click","a",I)},C=function(){o.controls.next=t('<a class="bx-next" href="">'+o.settings.nextText+"</a>"),o.controls.prev=t('<a class="bx-prev" href="">'+o.settings.prevText+"</a>"),o.controls.next.bind("click",y),o.controls.prev.bind("click",z),o.settings.nextSelector&&t(o.settings.nextSelector).append(o.controls.next),o.settings.prevSelector&&t(o.settings.prevSelector).append(o.controls.prev),o.settings.nextSelector||o.settings.prevSelector||(o.controls.directionEl=t('<div class="bx-controls-direction" />'),o.controls.directionEl.append(o.controls.prev).append(o.controls.next),o.controls.el.addClass("bx-has-controls-direction").append(o.controls.directionEl))},E=function(){o.controls.start=t('<div class="bx-controls-auto-item"><a class="bx-start" href="">'+o.settings.startText+"</a></div>"),o.controls.stop=t('<div class="bx-controls-auto-item"><a class="bx-stop" href="">'+o.settings.stopText+"</a></div>"),o.controls.autoEl=t('<div class="bx-controls-auto" />'),o.controls.autoEl.on("click",".bx-start",k),o.controls.autoEl.on("click",".bx-stop",M),o.settings.autoControlsCombine?o.controls.autoEl.append(o.controls.start):o.controls.autoEl.append(o.controls.start).append(o.controls.stop),o.settings.autoControlsSelector?t(o.settings.autoControlsSelector).html(o.controls.autoEl):o.controls.el.addClass("bx-has-controls-auto").append(o.controls.autoEl),A(o.settings.autoStart?"stop":"start")},P=function(){o.children.each(function(){var e=t(this).find("img:first").attr("title");void 0!=e&&(""+e).length&&t(this).append('<div class="bx-caption"><span>'+e+"</span></div>")})},y=function(t){o.settings.auto&&r.stopAuto(),r.goToNextSlide(),t.preventDefault()},z=function(t){o.settings.auto&&r.stopAuto(),r.goToPrevSlide(),t.preventDefault()},k=function(t){r.startAuto(),t.preventDefault()},M=function(t){r.stopAuto(),t.preventDefault()},I=function(e){o.settings.auto&&r.stopAuto();var i=t(e.currentTarget),s=parseInt(i.attr("data-slide-index"));s!=o.active.index&&r.goToSlide(s),e.preventDefault()},q=function(e){var i=o.children.length;return"short"==o.settings.pagerType?(o.settings.maxSlides>1&&(i=Math.ceil(o.children.length/o.settings.maxSlides)),o.pagerEl.html(e+1+o.settings.pagerShortSeparator+i),void 0):(o.pagerEl.find("a").removeClass("active"),o.pagerEl.each(function(i,s){t(s).find("a").eq(e).addClass("active")}),void 0)},D=function(){if(o.settings.infiniteLoop){var t="";0==o.active.index?t=o.children.eq(0).position():o.active.index==x()-1&&o.carousel?t=o.children.eq((x()-1)*m()).position():o.active.index==o.children.length-1&&(t=o.children.eq(o.children.length-1).position()),t&&("horizontal"==o.settings.mode?b(-t.left,"reset",0):"vertical"==o.settings.mode&&b(-t.top,"reset",0))}o.working=!1,o.settings.onSlideAfter(o.children.eq(o.active.index),o.oldIndex,o.active.index)},A=function(t){o.settings.autoControlsCombine?o.controls.autoEl.html(o.controls[t]):(o.controls.autoEl.find("a").removeClass("active"),o.controls.autoEl.find("a:not(.bx-"+t+")").addClass("active"))},W=function(){1==x()?(o.controls.prev.addClass("disabled"),o.controls.next.addClass("disabled")):!o.settings.infiniteLoop&&o.settings.hideControlOnEnd&&(0==o.active.index?(o.controls.prev.addClass("disabled"),o.controls.next.removeClass("disabled")):o.active.index==x()-1?(o.controls.next.addClass("disabled"),o.controls.prev.removeClass("disabled")):(o.controls.prev.removeClass("disabled"),o.controls.next.removeClass("disabled")))},H=function(){o.settings.autoDelay>0?setTimeout(r.startAuto,o.settings.autoDelay):r.startAuto(),o.settings.autoHover&&r.hover(function(){o.interval&&(r.stopAuto(!0),o.autoPaused=!0)},function(){o.autoPaused&&(r.startAuto(!0),o.autoPaused=null)})},L=function(){var e=0;if("next"==o.settings.autoDirection)r.append(o.children.clone().addClass("bx-clone"));else{r.prepend(o.children.clone().addClass("bx-clone"));var i=o.children.first().position();e="horizontal"==o.settings.mode?-i.left:-i.top}b(e,"reset",0),o.settings.pager=!1,o.settings.controls=!1,o.settings.autoControls=!1,o.settings.tickerHover&&!o.usingCSS&&o.viewport.hover(function(){r.stop()},function(){var e=0;o.children.each(function(){e+="horizontal"==o.settings.mode?t(this).outerWidth(!0):t(this).outerHeight(!0)});var i=o.settings.speed/e,s="horizontal"==o.settings.mode?"left":"top",n=i*(e-Math.abs(parseInt(r.css(s))));N(n)}),N()},N=function(t){speed=t?t:o.settings.speed;var e={left:0,top:0},i={left:0,top:0};"next"==o.settings.autoDirection?e=r.find(".bx-clone").first().position():i=o.children.first().position();var s="horizontal"==o.settings.mode?-e.left:-e.top,n="horizontal"==o.settings.mode?-i.left:-i.top,a={resetValue:n};b(s,"ticker",speed,a)},O=function(){o.touch={start:{x:0,y:0},end:{x:0,y:0}},o.viewport.bind("touchstart",X)},X=function(t){if(o.working)t.preventDefault();else{o.touch.originalPos=r.position();var e=t.originalEvent;o.touch.start.x=e.changedTouches[0].pageX,o.touch.start.y=e.changedTouches[0].pageY,o.viewport.bind("touchmove",Y),o.viewport.bind("touchend",V)}},Y=function(t){var e=t.originalEvent,i=Math.abs(e.changedTouches[0].pageX-o.touch.start.x),s=Math.abs(e.changedTouches[0].pageY-o.touch.start.y);if(3*i>s&&o.settings.preventDefaultSwipeX?t.preventDefault():3*s>i&&o.settings.preventDefaultSwipeY&&t.preventDefault(),"fade"!=o.settings.mode&&o.settings.oneToOneTouch){var n=0;if("horizontal"==o.settings.mode){var r=e.changedTouches[0].pageX-o.touch.start.x;n=o.touch.originalPos.left+r}else{var r=e.changedTouches[0].pageY-o.touch.start.y;n=o.touch.originalPos.top+r}b(n,"reset",0)}},V=function(t){o.viewport.unbind("touchmove",Y);var e=t.originalEvent,i=0;if(o.touch.end.x=e.changedTouches[0].pageX,o.touch.end.y=e.changedTouches[0].pageY,"fade"==o.settings.mode){var s=Math.abs(o.touch.start.x-o.touch.end.x);s>=o.settings.swipeThreshold&&(o.touch.start.x>o.touch.end.x?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto())}else{var s=0;"horizontal"==o.settings.mode?(s=o.touch.end.x-o.touch.start.x,i=o.touch.originalPos.left):(s=o.touch.end.y-o.touch.start.y,i=o.touch.originalPos.top),!o.settings.infiniteLoop&&(0==o.active.index&&s>0||o.active.last&&0>s)?b(i,"reset",200):Math.abs(s)>=o.settings.swipeThreshold?(0>s?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto()):b(i,"reset",200)}o.viewport.unbind("touchend",V)},Z=function(){var e=t(window).width(),i=t(window).height();(a!=e||l!=i)&&(a=e,l=i,r.redrawSlider(),o.settings.onSliderResize.call(r,o.active.index))};return r.goToSlide=function(e,i){if(!o.working&&o.active.index!=e)if(o.working=!0,o.oldIndex=o.active.index,o.active.index=0>e?x()-1:e>=x()?0:e,o.settings.onSlideBefore(o.children.eq(o.active.index),o.oldIndex,o.active.index),"next"==i?o.settings.onSlideNext(o.children.eq(o.active.index),o.oldIndex,o.active.index):"prev"==i&&o.settings.onSlidePrev(o.children.eq(o.active.index),o.oldIndex,o.active.index),o.active.last=o.active.index>=x()-1,o.settings.pager&&q(o.active.index),o.settings.controls&&W(),"fade"==o.settings.mode)o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed),o.children.filter(":visible").fadeOut(o.settings.speed).css({zIndex:0}),o.children.eq(o.active.index).css("zIndex",o.settings.slideZIndex+1).fadeIn(o.settings.speed,function(){t(this).css("zIndex",o.settings.slideZIndex),D()});else{o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed);var s=0,n={left:0,top:0};if(!o.settings.infiniteLoop&&o.carousel&&o.active.last)if("horizontal"==o.settings.mode){var a=o.children.eq(o.children.length-1);n=a.position(),s=o.viewport.width()-a.outerWidth()}else{var l=o.children.length-o.settings.minSlides;n=o.children.eq(l).position()}else if(o.carousel&&o.active.last&&"prev"==i){var d=1==o.settings.moveSlides?o.settings.maxSlides-m():(x()-1)*m()-(o.children.length-o.settings.maxSlides),a=r.children(".bx-clone").eq(d);n=a.position()}else if("next"==i&&0==o.active.index)n=r.find("> .bx-clone").eq(o.settings.maxSlides).position(),o.active.last=!1;else if(e>=0){var c=e*m();n=o.children.eq(c).position()}if("undefined"!=typeof n){var g="horizontal"==o.settings.mode?-(n.left-s):-n.top;b(g,"slide",o.settings.speed)}}},r.goToNextSlide=function(){if(o.settings.infiniteLoop||!o.active.last){var t=parseInt(o.active.index)+1;r.goToSlide(t,"next")}},r.goToPrevSlide=function(){if(o.settings.infiniteLoop||0!=o.active.index){var t=parseInt(o.active.index)-1;r.goToSlide(t,"prev")}},r.startAuto=function(t){o.interval||(o.interval=setInterval(function(){"next"==o.settings.autoDirection?r.goToNextSlide():r.goToPrevSlide()},o.settings.pause),o.settings.autoControls&&1!=t&&A("stop"))},r.stopAuto=function(t){o.interval&&(clearInterval(o.interval),o.interval=null,o.settings.autoControls&&1!=t&&A("start"))},r.getCurrentSlide=function(){return o.active.index},r.getCurrentSlideElement=function(){return o.children.eq(o.active.index)},r.getSlideCount=function(){return o.children.length},r.redrawSlider=function(){o.children.add(r.find(".bx-clone")).outerWidth(u()),o.viewport.css("height",v()),o.settings.ticker||S(),o.active.last&&(o.active.index=x()-1),o.active.index>=x()&&(o.active.last=!0),o.settings.pager&&!o.settings.pagerCustom&&(w(),q(o.active.index))},r.destroySlider=function(){o.initialized&&(o.initialized=!1,t(".bx-clone",this).remove(),o.children.each(function(){void 0!=t(this).data("origStyle")?t(this).attr("style",t(this).data("origStyle")):t(this).removeAttr("style")}),void 0!=t(this).data("origStyle")?this.attr("style",t(this).data("origStyle")):t(this).removeAttr("style"),t(this).unwrap().unwrap(),o.controls.el&&o.controls.el.remove(),o.controls.next&&o.controls.next.remove(),o.controls.prev&&o.controls.prev.remove(),o.pagerEl&&o.settings.controls&&o.pagerEl.remove(),t(".bx-caption",this).remove(),o.controls.autoEl&&o.controls.autoEl.remove(),clearInterval(o.interval),o.settings.responsive&&t(window).unbind("resize",Z))},r.reloadSlider=function(t){void 0!=t&&(n=t),r.destroySlider(),d()},d(),this}}(jQuery);

/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * jQuery Unveil
 * A very lightweight jQuery plugin to lazy load images
 * http://luis-almeida.github.com/unveil
 *
 * Licensed under the MIT license.
 * Copyright 2013 Luís Almeida
 * https://github.com/luis-almeida
 */

;(function($) {

  $.fn.unveil = function(threshold, callback) {

    var $w = $(window),
        th = threshold || 0,
        retina = window.devicePixelRatio > 1,
        attrib = retina? "data-src-retina" : "data-src",
        images = this,
        loaded;

    this.one("unveil", function() {
      var source = this.getAttribute(attrib);
      source = source || this.getAttribute("data-src");
      if (source) {
        this.setAttribute("src", source);
        if (typeof callback === "function") callback.call(this);
      }
    });

    function unveil() {
      var inview = images.filter(function() {
        var $e = $(this);
        if ($e.is(":hidden")) return;

        var wt = $w.scrollTop(),
            wb = wt + $w.height(),
            et = $e.offset().top,
            eb = et + $e.height();

        return eb >= wt - th && et <= wb + th;
      });

      loaded = inview.trigger("unveil");
      images = images.not(loaded);
    }

    $w.on("scroll.unveil resize.unveil lookup.unveil", unveil);

    unveil();

    return this;

  };


})(window.jQuery || window.Zepto);

$.extend($.expr[':'], {
    inview: function ( el ) {
        var $e = $( el ),
            $w = $( window ),
            wt = $w.scrollTop(),
            wb = wt + $w.height(),
            et = $e.offset().top,
            eb = et + $e.height();

        return eb >= wt && et <= wb;
    }
});

//Preloader Animation
$(document).ajaxStart(function() {
  $( ".preloader" ).show();
});
$(document).ajaxStop(function() {
  $( ".preloader" ).hide();
});

$(document).ready(function() {
	//Dropdown Selector
	$(".category-dropdown").change(function(){
		var category_id=$(".category-dropdown:last option:selected").val();
		$(".search_category_id").val(category_id);
	});
	//Pincode Selection Enter Button Interaction
	$('#pincode_select').bind('keyup', function(e) {
	    if ( e.keyCode === 13 ) { 
	    	// 13 is enter key
	    	$("#kob_state_select_btn").click();
	    }
	});
	
	
	
	//Company Offers Slider
	$('#offers-slider').bxSlider({
		slideWidth: 230,
		pager: false,
		auto:true
	});

	// Slider in  Home page
	$('#home_slider').bxSlider({
		pager:false
	});	
	

});

//Show or Hide Navbar onScroll
$(window).scroll(function(){
    if ($(window).scrollTop() >= 1) {
        $('#header').addClass('fixed-header');
        $('.searchbar').not('.search-block').addClass('unvisible');
        $(".ac_results").addClass('unvisible');
    }
    else {
        $('#header').removeClass('fixed-header');
        $('.searchbar, .ac_results').removeClass('unvisible');
    }
});

//Fixing Search Auto Suggest Overlapping with Menu
$(document).ready(function() {
    var menuActive = 'ul.sf-menu > li';
    var searchSuggest = '.ac_results';
    $(menuActive).hover(function(){
        $(searchSuggest).addClass("hidden");
        }, function(){
        $(searchSuggest).removeClass("hidden");
    });
});

//Trader and Company Usermode Select
$(document).ready(function(){
    var $retailerButton = $('a.retailer'), 
	    $companyButton = $('a.company'),
	    $companySwitch =$('.switch-container .company'),
	    $retailerSwitch =$('.switch-container .retailer')
	    $retailerContents = $('[data-user-type="retailer"]'),
	    $companyContents = $('[data-user-type="company"]'),
	    $customerType = $('.customer-type');

	$retailerButton.click(function(event){
		$retailerSwitch.addClass("switch-mode-selected");
		$companySwitch.removeClass("switch-mode-selected").addClass("switch-mode");
		$companyContents.addClass('hidden');
    	$retailerContents.removeClass('hidden');
    	$customerType.html("RETAILER");
    	event.preventDefault();
	});
	$companyButton.click(function(event){
		$companySwitch.addClass("switch-mode-selected");
		$retailerSwitch.removeClass("switch-mode-selected").addClass("switch-mode");
		$retailerContents.addClass('hidden');
    	$companyContents.removeClass('hidden');
    	$customerType.html("COMPANY");
    	event.preventDefault();
	});
	$('[data-user-type="retailer"]').addClass('hidden');
});

$(document).ready(function() {
	// $("img").unveil(200);
	$("img").unveil(600, function() {
		$(this).load(function() {
			this.style.opacity = 1;
		});
	});
	$('.category').on('click', function() {
		$('img.lazyload-onclick').trigger("unveil");
	});
	$("img.lazyload-onclick:inview").trigger("unveil");
});

//Initializing Tooltip
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip()
});

//global variables
var responsiveflag = false;

$(document).ready(function(){
	highdpiInit();
	responsiveResize();
	$(window).resize(responsiveResize);
	if (navigator.userAgent.match(/Android/i))
	{
		var viewport = document.querySelector('meta[name="viewport"]');
		viewport.setAttribute('content', 'initial-scale=1.0,maximum-scale=1.0,user-scalable=0,width=device-width,height=device-height');
		window.scrollTo(0, 1);
	}
	if (typeof quickView !== 'undefined' && quickView)
		quick_view();
	dropDown();

	if (typeof page_name != 'undefined' && !in_array(page_name, ['index', 'product']))
	{
		bindGrid();

		$(document).on('change', '.selectProductSort', function(e){
			if (typeof request != 'undefined' && request)
				var requestSortProducts = request;
			var splitData = $(this).val().split(':');
			var url = '';
			if (typeof requestSortProducts != 'undefined' && requestSortProducts)
			{
				url += requestSortProducts ;
				if (typeof splitData[0] !== 'undefined' && splitData[0])
				{
					url += ( requestSortProducts.indexOf('?') < 0 ? '?' : '&') + 'orderby=' + splitData[0] + (splitData[1] ? '&orderway=' + splitData[1] : '');
					if (typeof splitData[1] !== 'undefined' && splitData[1])
						url += '&orderway=' + splitData[1];
				}
				document.location.href = url;
			}
		});

		$(document).on('change', 'select[name="n"]', function(){
			$(this.form).submit();
		});

		$(document).on('change', 'select[name="currency_payment"]', function(){
			setCurrency($(this).val());
		});
	}

	$(document).on('change', 'select[name="manufacturer_list"], select[name="supplier_list"]', function(){
		if (this.value != '')
			location.href = this.value;
	});

	$(document).on('click', '.back', function(e){
		e.preventDefault();
		history.back();
	});

	jQuery.curCSS = jQuery.css;
	if (!!$.prototype.cluetip)
		$('a.cluetip').cluetip({
			local:true,
			cursor: 'pointer',
			dropShadow: false,
			dropShadowSteps: 0,
			showTitle: false,
			tracking: true,
			sticky: false,
			mouseOutClose: true,
			fx: {
				open:       'fadeIn',
				openSpeed:  'fast'
			}
		}).css('opacity', 0.8);

	if (typeof(FancyboxI18nClose) !== 'undefined' && typeof(FancyboxI18nNext) !== 'undefined' && typeof(FancyboxI18nPrev) !== 'undefined' && !!$.prototype.fancybox)
		$.extend($.fancybox.defaults.tpl, {
			closeBtn : '<a title="' + FancyboxI18nClose + '" class="fancybox-item fancybox-close" href="javascript:;"></a>',
			next     : '<a title="' + FancyboxI18nNext + '" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
			prev     : '<a title="' + FancyboxI18nPrev + '" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
		});

	// Close Alert messages
	$(".alert.alert-danger").on('click', this, function(e){
		//if (e.offsetX >= 16 && e.offsetX <= 39 && e.offsetY >= 16 && e.offsetY <= 34)
			$(this).fadeOut();
	});
});

function highdpiInit()
{
	if (typeof highDPI === 'undefined')
		return;
	if(highDPI && $('.replace-2x').css('font-size') == "1px")
	{
		var els = $("img.replace-2x").get();
		for(var i = 0; i < els.length; i++)
		{
			src = els[i].src;
			extension = src.substr( (src.lastIndexOf('.') +1) );
			src = src.replace("." + extension, "2x." + extension);

			var img = new Image();
			img.src = src;
			img.height != 0 ? els[i].src = src : els[i].src = els[i].src;
		}
	}
}


// Used to compensante Chrome/Safari bug (they don't care about scroll bar for width)
function scrollCompensate()
{
	var inner = document.createElement('p');
	inner.style.width = "100%";
	inner.style.height = "200px";

	var outer = document.createElement('div');
	outer.style.position = "absolute";
	outer.style.top = "0px";
	outer.style.left = "0px";
	outer.style.visibility = "hidden";
	outer.style.width = "200px";
	outer.style.height = "150px";
	outer.style.overflow = "hidden";
	outer.appendChild(inner);

	document.body.appendChild(outer);
	var w1 = inner.offsetWidth;
	outer.style.overflow = 'scroll';
	var w2 = inner.offsetWidth;
	if (w1 == w2) w2 = outer.clientWidth;

	document.body.removeChild(outer);

	return (w1 - w2);
}

function responsiveResize()
{
	compensante = scrollCompensate();
	if (($(window).width()+scrollCompensate()) <= 768 && responsiveflag == false)
	{
		accordion('enable');
		accordionFooter('enable');
		responsiveflag = true;
	}
	else if (($(window).width()+scrollCompensate()) >= 769)
	{
		accordion('disable');
		accordionFooter('disable');
		responsiveflag = false;
		if (typeof bindUniform !=='undefined')
			bindUniform();
	}
	blockHover();
}

function blockHover(status)
{
	var screenLg = $('body').find('.container').width() == 1170;

	if ($('.product_list').is('.grid'))
		if (screenLg)
			$('.product_list .button-container').hide();
		else
			$('.product_list .button-container').show();

	$(document).off('mouseenter').on('mouseenter', '.product_list.grid li.ajax_block_product .product-container', function(e){
		if (screenLg)
		{
			var pcHeight = $(this).parent().outerHeight();
			var pcPHeight = $(this).parent().find('.button-container').outerHeight() + $(this).parent().find('.comments_note').outerHeight() + $(this).parent().find('.functional-buttons').outerHeight();
			$(this).parent().addClass('hovered').css({'height':pcHeight + pcPHeight, 'margin-bottom':pcPHeight * (-1)});
			$(this).find('.button-container').show();
		}
	});

	$(document).off('mouseleave').on('mouseleave', '.product_list.grid li.ajax_block_product .product-container', function(e){
		if (screenLg)
		{
			$(this).parent().removeClass('hovered').css({'height':'auto', 'margin-bottom':'0'});
			$(this).find('.button-container').hide();
		}
	});
}

function quick_view()
{
	$(document).on('click', '.quick-view:visible, .quick-view-mobile:visible', function(e){
		e.preventDefault();
		var url = this.rel;
		var anchor = '';

		if (url.indexOf('#') != -1)
		{
			anchor = url.substring(url.indexOf('#'), url.length);
			url = url.substring(0, url.indexOf('#'));
		}

		if (url.indexOf('?') != -1)
			url += '&';
		else
			url += '?';

		if (!!$.prototype.fancybox)
			$.fancybox({
				'padding':  30,
				'width':    800,
				'height':   610,
				'type':     'iframe',
				'href':     url + 'content_only=1' + anchor,
			});
	});
}

function bindGrid()
{
	var storage = false;
	if (typeof(getStorageAvailable) !== 'undefined') {
		storage = getStorageAvailable();
	}
	if (!storage) {
		return;
	}

	var view = $.totalStorage('display');

	if (!view && (typeof displayList != 'undefined') && displayList)
		view = 'list';

	if (view && view != 'grid')
		display(view);
	else
		$('.display').find('li#grid').addClass('selected');

	$(document).on('click', '#grid', function(e){
		e.preventDefault();
		display('grid');
	});

	$(document).on('click', '#list', function(e){
		e.preventDefault();
		display('list');
	});
}

function display(view)
{
	/*if (view == 'list')
	{
		$('ul.product_list').removeClass('grid').addClass('list row');
		$('.product_list > li').removeClass('col-xs-12 col-sm-6 col-md-4').addClass('col-xs-12');
		$('.product_list > li').each(function(index, element) {
			var html = '';
			html = '<div class="product-container"><div class="row">';
			html += '<div class="left-block col-xs-4 col-sm-5 col-md-4">' + $(element).find('.left-block').html() + '</div>';
			html += '<div class="center-block col-xs-4 col-sm-7 col-md-4">';
			html += '<div class="product-flags">'+ $(element).find('.product-flags').html() + '</div>';
			html += '<h5 itemprop="name">'+ $(element).find('h5').html() + '</h5>';
			var hookReviews = $(element).find('.hook-reviews');
			if (hookReviews.length) {
				html += hookReviews.clone().wrap('<div>').parent().html();
			}
			html += '<p class="product-desc">'+ $(element).find('.product-desc').html() + '</p>';
			var colorList = $(element).find('.color-list-container').html();
			if (colorList != null) {
				html += '<div class="color-list-container">'+ colorList +'</div>';
			}
			var availability = $(element).find('.availability').html();	// check : catalog mode is enabled
			if (availability != null) {
				html += '<span class="availability">'+ availability +'</span>';
			}
			html += '</div>';
			html += '<div class="right-block col-xs-4 col-sm-12 col-md-4"><div class="right-block-content row">';
			var price = $(element).find('.content_price').html();       // check : catalog mode is enabled
			if (price != null) {
				html += '<div class="content_price col-xs-5 col-md-12">'+ price + '</div>';
			}
			html += '<div class="button-container col-xs-7 col-md-12">'+ $(element).find('.button-container').html() +'</div>';
			html += '<div class="functional-buttons clearfix col-sm-12">' + $(element).find('.functional-buttons').html() + '</div>';
			html += '</div>';
			html += '</div></div>';
			$(element).html(html);
		});
		$('.display').find('li#list').addClass('selected');
		$('.display').find('li#grid').removeAttr('class');
		$.totalStorage('display', 'list');
	}
	else
	{
		$('ul.product_list').removeClass('list').addClass('grid row');
		$('.product_list > li').removeClass('col-xs-12').addClass('col-xs-12 col-sm-6 col-md-4');
		$('.product_list > li').each(function(index, element) {
			var html = '';
			html += '<div class="product-container">';
			html += '<div class="left-block">' + $(element).find('.left-block').html() + '</div>';
			html += '<div class="right-block">';
			html += '<div class="product-flags">'+ $(element).find('.product-flags').html() + '</div>';
			html += '<h5 itemprop="name">'+ $(element).find('h5').html() + '</h5>';
			var hookReviews = $(element).find('.hook-reviews');
			if (hookReviews.length) {
				html += hookReviews.clone().wrap('<div>').parent().html();
			}
			html += '<p itemprop="description" class="product-desc">'+ $(element).find('.product-desc').html() + '</p>';
			var price = $(element).find('.content_price').html(); // check : catalog mode is enabled
			if (price != null) {
				html += '<div class="content_price">'+ price + '</div>';
			}
			html += '<div itemprop="offers" itemscope itemtype="https://schema.org/Offer" class="button-container">'+ $(element).find('.button-container').html() +'</div>';
			var colorList = $(element).find('.color-list-container').html();
			if (colorList != null) {
				html += '<div class="color-list-container">'+ colorList +'</div>';
			}
			var availability = $(element).find('.availability').html(); // check : catalog mode is enabled
			if (availability != null) {
				html += '<span class="availability">'+ availability +'</span>';
			}
			html += '</div>';
			html += '<div class="functional-buttons clearfix">' + $(element).find('.functional-buttons').html() + '</div>';
			html += '</div>';
			$(element).html(html);
		});
		$('.display').find('li#grid').addClass('selected');
		$('.display').find('li#list').removeAttr('class');
		$.totalStorage('display', 'grid');
	}*/
}

function dropDown()
{
	elementClick = '#header .current';
	elementSlide =  'ul.toogle_content';
	activeClass = 'active';

	$(elementClick).on('click', function(e){
		e.stopPropagation();
		var subUl = $(this).next(elementSlide);
		if(subUl.is(':hidden'))
		{
			subUl.slideDown();
			$(this).addClass(activeClass);
		}
		else
		{
			subUl.slideUp();
			$(this).removeClass(activeClass);
		}
		$(elementClick).not(this).next(elementSlide).slideUp();
		$(elementClick).not(this).removeClass(activeClass);
		e.preventDefault();
	});

	$(elementSlide).on('click', function(e){
		e.stopPropagation();
	});

	$(document).on('click', function(e){
		e.stopPropagation();
		var elementHide = $(elementClick).next(elementSlide);
		$(elementHide).slideUp();
		$(elementClick).removeClass('active');
	});
}

function accordionFooter(status)
{
	if(status == 'enable')
	{
		$('#footer .footer-block h4').on('click', function(e){
			$(this).toggleClass('active').parent().find('.toggle-footer').stop().slideToggle('medium');
			e.preventDefault();
		})
		$('#footer').addClass('accordion').find('.toggle-footer').slideUp('fast');
	}
	else
	{
		$('.footer-block h4').removeClass('active').off().parent().find('.toggle-footer').removeAttr('style').slideDown('fast');
		$('#footer').removeClass('accordion');
	}
}

function accordion(status)
{
	/*removed all right column accordions as they are not needed*/
	if(status == 'enable')
	{
		var accordion_selector = '#left_column .block .title_block, #left_column #newsletter_block_left h4,' +
								'#left_column .shopping_cart > a:first-child';

		$(accordion_selector).on('click', function(e){
			$(this).toggleClass('active').parent().find('.block_content').stop().slideToggle('medium');
		});
		$('#left_column').addClass('accordion').find('.block .block_content').slideUp('fast');
		/*if (typeof(ajaxCart) !== 'undefined')
			ajaxCart.collapse();*/
	}
	else
	{
		$('#left_column .block .title_block, #left_column #newsletter_block_left h4').removeClass('active').off().parent().find('.block_content').removeAttr('style').slideDown('fast');
		$('#left_column').removeClass('accordion');
	}
}

function bindUniform()
{
	if (!!$.prototype.uniform)
		$("select.form-control,input[type='radio'],input[type='checkbox']").not(".not_uniform").uniform();
}
/* Order payment step 3*/
$(document).ready(function()
{
	$('.payment_module').addClass('unvisible');
});
function paymentType(type)
{
	if(type == 1 || type == 2 || type == 3)
	{
		$("#payment_head").html("");
		$("#payment_bankwire, #payment_cheque, #payment_cod,#payment_approval,#pay_credit,#payment_epaylater").addClass("unvisible");
		$("#payment_credit_debit").removeClass("unvisible");
		if(type==1)
		{
			
			$("#payment_head").html("Pay by Credit Card");
			$("#pay_credit").addClass("selected");
			$("#pay_debit, #pay_net, #pay_neft, #pay_cheque, #pay_cash,#pay_send_for_approval,#pay_epaylater").removeClass("selected");
		}
		else if(type==2)
		{
			$("#payment_head").html("Pay by Debit Card");
			$("#pay_debit").addClass("selected");
			$("#pay_credit, #pay_net, #pay_neft, #pay_cheque, #pay_cash,#pay_send_for_approval,#pay_epaylater").removeClass("selected");
		}
		else if(type==3)
		{
			$("#payment_head").html("Pay by net bank");
			$("#pay_net").addClass("selected");
			$("#pay_debit, #pay_credit, #pay_debit, #pay_neft, #pay_cheque, #pay_cash,#pay_send_for_approval,#pay_epaylater").removeClass("selected");
		}
		
	}
	else if(type == 4)
	{
		$("#payment_credit_debit, #payment_cheque, #payment_cod,#payment_approval,#pay_option_credit,#payment_epaylater").addClass("unvisible");
		$("#payment_bankwire").removeClass("unvisible");
		
		$("#pay_neft").addClass("selected");
		$("#pay_debit, #pay_debit, #pay_net, #pay_cheque, #pay_cash,#pay_send_for_approval,#pay_credit,#pay_epaylater").removeClass("selected");
	}
	else if(type == 5)
	{
		$("#payment_credit_debit, #payment_bankwire, #payment_cod,#payment_approval,#pay_option_credit,#payment_epaylater").addClass("unvisible");
		$("#payment_cheque").removeClass("unvisible");
		
		$("#pay_cheque").addClass("selected");
		$("#pay_debit, #pay_debit, #pay_net, #pay_neft, #pay_cash,#pay_send_for_approval,#pay_credit,#pay_epaylater").removeClass("selected");
	}
	else if(type == 6)
	{
		$("#payment_credit_debit, #payment_bankwire, #payment_cheque,#payment_approval,#pay_option_credit, #payment_epaylater").addClass("unvisible");
		$("#payment_cod").toggleClass("unvisible");
		
		$("#pay_cash").addClass("selected");
		$("#pay_debit, #pay_debit, #pay_net, #pay_neft, #pay_cheque,#pay_send_for_approval,#pay_credit,#pay_epaylater").removeClass("selected");
	}
	else if(type == 7)
	{
		$("#payment_credit_debit, #payment_bankwire, #payment_cheque,#payment_cod,#pay_option_credit,#payment_epaylater").addClass("unvisible");
		$("#payment_approval").removeClass("unvisible");
		
		$("#pay_send_for_approval").addClass("selected");
		$("#pay_debit, #pay_net, #pay_neft, #pay_cheque,#pay_cash,#pay_credit,#pay_epaylater").removeClass("selected");
	}
	else if(type == 8)
	{
		$("#payment_credit_debit, #payment_bankwire, #payment_cheque,#payment_cod,#payment_approval,#payment_epaylater").addClass("unvisible");
		$("#pay_option_credit").removeClass("unvisible");
		
		$("#pay_credit").addClass("selected");
		$("#pay_debit, #pay_net, #pay_neft, #pay_cheque,#pay_cash,#pay_send_for_approval,#pay_epaylater").removeClass("selected");
	}
	else if(type == 9) {
		$("#payment_credit_debit, #payment_bankwire, #payment_cheque,#payment_cod,#payment_approval,#pay_option_credit").addClass("unvisible");
		$("#payment_epaylater").removeClass("unvisible");
		
		$("#pay_epaylater").addClass("selected");
		$("#pay_debit, #pay_net, #pay_neft, #pay_cheque,#pay_cash,#pay_send_for_approval,#pay_credit").removeClass("selected");

		var dataparam = '&type=1&dotcom=true';
		$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'epaylater.php',
				data: dataparam,
				cache: true,
	 			success: function(data)
				{
	  				if(data != undefined) {
				      if(data.paylater == true) {
				        $("#epaylater_payment_hint,#epaylater_payment_btn").show();
				        $("#epaylater_not_eligible,#epaylater_error").hide();
				        $("#pay_later_id").val(data.id);
				      }
				      else {
				        $("#epaylater_payment_hint,#epaylater_payment_btn,#epaylater_error").hide();
				      }
				    }
				    else {
				      $("#epaylater_payment_hint,#epaylater_payment_btn,#epaylater_error").hide();
				    }
				}
		});
	}
}

function sendForApproval()
{
	var type= 6;
	 
	var dataparam = '&type=' + type+'&dotcom=true';
	$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'dashpaymentoption.php',
			data: dataparam,
			cache: true,
 			success: function(data)
			{
  				window.location.href ="index.php?controller=order-confirmation&key="+data.secure_key+"&id_cart="+data.id_cart+"&id_module=125&id_order="+data.id_order+"";
 				
			}
	});
}

function confirmEpaylaterPayment() {
	var epayLaterOrderId = $('#pay_later_id').val();
	if(epayLaterOrderId != "") {
		var dataparam = '&type=8&dotcom=true&id_pay_later='+epayLaterOrderId;
		$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'dashpaymentoption.php',
				data: dataparam,
				cache: true,
	 			success: function(data)
				{
	  				window.location.href ="index.php?controller=order-confirmation&key="+data.secure_key+"&id_cart="+data.id_cart+"&id_module=125&id_order="+data.id_order+"";
				}
		});
	}
	else {
		$("#epaylater_payment_hint,#epaylater_payment_btn,#epaylater_not_eligible").hide();
		$("#epaylater_error").show();
	}
}

function payCredit()
{
	var type= 7;
	var dataparam = '&type=' + type;
	$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'dashpaymentoption.php',
			data: dataparam,
			cache: true,
 			success: function(data)
			{
				window.location.href ="index.php?controller=order-confirmation&key="+data.secure_key+"&id_cart="+data.id_cart+"&id_module=125&id_order="+data.id_order+"";
			}
	});
}

function goToEBS()
{
 	$('#EBS_form').submit();
}

function callEBS(url)
{
	$('#payment_block_text').hide();
	$("#payment_cod").addClass("unvisible");
 	$('#payment_block_all').load(url + " #ebs_block");
}

function processEBS()
{
	$('#checkout_confirmation').serialize();
	$('#checkout_confirmation').submit();
}

/*Block cart qty changes function */
 
function decreaseQty(id_product,id_customized,id_delivery_address,id_product_attribute)
{
 	var temp_qty = $('#quantity_'+id_product+'_'+id_customized+'_0_'+id_delivery_address).val();
	//var product =id_product+'_'+id_product_attribute+'_'+id_customized+'_'+id_delivery_address;
	var product =id_product+'_'+id_customized+'_'+id_product_attribute+'_'+id_delivery_address;
  	var qty = -1;
 	if(temp_qty == 1)
	{
 		$("#quantity_"+product).val(0);
	}
 	downQuantity(product,qty);
	
}
function increaseQty(id_product,id_customized,id_delivery_address,id_product_attribute)
{
 	//var product =id_product+'_'+id_customized+'_'+id_delivery_address+'_'+id_product_attribute;
 	var product =id_product+'_'+id_customized+'_'+id_product_attribute+'_'+id_delivery_address;
 	//var product =id_product+'_'+id_product_attribute+'_'+customizedQty+'_'+id_delivery_address;
	//var qty = $('#quantity_'+id_product+'_'+id_product_attribute+'_'+id_delivery_address+'_0').val();
	var qty = 1;
  	upQuantity(product,qty);
}

/****type watch plugin****/
/*
*	TypeWatch 2.2.2
*
*	Examples/Docs: github.com/dennyferra/TypeWatch
*	
*  Copyright(c) 2014
*	Denny Ferrassoli - dennyferra.com
*   Charles Christolini
*  
*  Dual licensed under the MIT and GPL licenses:
*  http://www.opensource.org/licenses/mit-license.php
*  http://www.gnu.org/licenses/gpl.html
*/

!function(root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        factory(require('jquery'));
    } else {
        factory(root.jQuery);
    }
}(this, function($) {
    'use strict';
	$.fn.typeWatch = function(o) {
		// The default input types that are supported
		var _supportedInputTypes =
			['TEXT', 'TEXTAREA', 'PASSWORD', 'TEL', 'SEARCH', 'URL', 'EMAIL', 'DATETIME', 'DATE', 'MONTH', 'WEEK', 'TIME', 'DATETIME-LOCAL', 'NUMBER', 'RANGE'];

		// Options
		var options = $.extend({
			wait: 750,
			callback: function() { },
			highlight: true,
			captureLength: 2,
			inputTypes: _supportedInputTypes
		}, o);

		function checkElement(timer, override) {
			var value = $(timer.el).val();

			// Fire if text >= options.captureLength AND text != saved text OR if override AND text >= options.captureLength
			if ( ( value.length >= options.captureLength && value.toUpperCase() != timer.text )  
				|| ( override && value.length >= options.captureLength ) 
				|| ( value.length == 0 && timer.text ) )
			{
				timer.text = value.toUpperCase();
				timer.cb.call(timer.el, value);
			}
		};

		function watchElement(elem) {
			var elementType = elem.type.toUpperCase();
			if ($.inArray(elementType, options.inputTypes) >= 0) {

				// Allocate timer element
				var timer = {
					timer: null,
					text: $(elem).val().toUpperCase(),
					cb: options.callback,
					el: elem,
					wait: options.wait
				};

				// Set focus action (highlight)
				if (options.highlight) {
					$(elem).click(
						function() {
							this.select();
						});
				}

				// Key watcher / clear and reset the timer
				var startWatch = function(evt) {
					var timerWait = timer.wait;
					var overrideBool = false;
					var evtElementType = this.type.toUpperCase();

					// If enter key is pressed and not a TEXTAREA and matched inputTypes
					if (typeof evt.keyCode != 'undefined' && evt.keyCode == 13 && evtElementType != 'TEXTAREA' && $.inArray(evtElementType, options.inputTypes) >= 0) {
						timerWait = 1;
						overrideBool = true;
					}

					var timerCallbackFx = function() {
						checkElement(timer, overrideBool)
					}

					// Clear timer					
					clearTimeout(timer.timer);
					timer.timer = setTimeout(timerCallbackFx, timerWait);
				};

				$(elem).on('keydown paste cut input change', startWatch);
			}
		};

		// Watch Each Element
		return this.each(function() {
			watchElement(this);
		});

	};
});

/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
$(document).ready(function() {
    $('#newsletter-input').on({
        focus: function() {
            if ($(this).val() == placeholder_blocknewsletter)
                $(this).val('');
        },
        blur: function() {
            if ($(this).val() == '')
                $(this).val(placeholder_blocknewsletter);
        }
    });
    $("button[name='submitNewsletter']").click(function(e){
        var email=$("#newsletter-input").val();
        //e.preventDefault();
        if(!validate_isEmail(email)){
            $(".newsletter-form alert").html("Invalid Email");
            //e.preventDefault();
        }
    });
	/*var cssClass = 'alert alert-danger';
    if (typeof nw_error != 'undefined' && !nw_error)
		cssClass = 'alert alert-success';

    if (typeof msg_newsl != 'undefined' && msg_newsl)
	{
        $('#columns').prepend('<div class="clearfix"></div><p class="' + cssClass + '"> ' + alert_blocknewsletter + '</p>');
		$('html, body').animate({scrollTop: $('#columns').offset().top}, 'slow');
	}*/

});

/* unicode_hack.js
*    Copyright (C) 2010-2012  Marcelo Gibson de Castro GonÃ§alves. All rights reserved.
*
*    Copying and distribution of this file, with or without modification,
*    are permitted in any medium without royalty provided the copyright
*    notice and this notice are preserved.  This file is offered as-is,
*    without any warranty.
*/
var unicode_hack = (function() {
    /* Regexps to match characters in the BMP according to their Unicode category.
       Extracted from Unicode specification, version 5.0.0, source:
       http://unicode.org/versions/Unicode5.0.0/
    */
	var unicodeCategories = {
		Pi:'[\u00ab\u2018\u201b\u201c\u201f\u2039\u2e02\u2e04\u2e09\u2e0c\u2e1c]',
		Sk:'[\u005e\u0060\u00a8\u00af\u00b4\u00b8\u02c2-\u02c5\u02d2-\u02df\u02e5-\u02ed\u02ef-\u02ff\u0374\u0375\u0384\u0385\u1fbd\u1fbf-\u1fc1\u1fcd-\u1fcf\u1fdd-\u1fdf\u1fed-\u1fef\u1ffd\u1ffe\u309b\u309c\ua700-\ua716\ua720\ua721\uff3e\uff40\uffe3]',
		Sm:'[\u002b\u003c-\u003e\u007c\u007e\u00ac\u00b1\u00d7\u00f7\u03f6\u2044\u2052\u207a-\u207c\u208a-\u208c\u2140-\u2144\u214b\u2190-\u2194\u219a\u219b\u21a0\u21a3\u21a6\u21ae\u21ce\u21cf\u21d2\u21d4\u21f4-\u22ff\u2308-\u230b\u2320\u2321\u237c\u239b-\u23b3\u23dc-\u23e1\u25b7\u25c1\u25f8-\u25ff\u266f\u27c0-\u27c4\u27c7-\u27ca\u27d0-\u27e5\u27f0-\u27ff\u2900-\u2982\u2999-\u29d7\u29dc-\u29fb\u29fe-\u2aff\ufb29\ufe62\ufe64-\ufe66\uff0b\uff1c-\uff1e\uff5c\uff5e\uffe2\uffe9-\uffec]',
		So:'[\u00a6\u00a7\u00a9\u00ae\u00b0\u00b6\u0482\u060e\u060f\u06e9\u06fd\u06fe\u07f6\u09fa\u0b70\u0bf3-\u0bf8\u0bfa\u0cf1\u0cf2\u0f01-\u0f03\u0f13-\u0f17\u0f1a-\u0f1f\u0f34\u0f36\u0f38\u0fbe-\u0fc5\u0fc7-\u0fcc\u0fcf\u1360\u1390-\u1399\u1940\u19e0-\u19ff\u1b61-\u1b6a\u1b74-\u1b7c\u2100\u2101\u2103-\u2106\u2108\u2109\u2114\u2116-\u2118\u211e-\u2123\u2125\u2127\u2129\u212e\u213a\u213b\u214a\u214c\u214d\u2195-\u2199\u219c-\u219f\u21a1\u21a2\u21a4\u21a5\u21a7-\u21ad\u21af-\u21cd\u21d0\u21d1\u21d3\u21d5-\u21f3\u2300-\u2307\u230c-\u231f\u2322-\u2328\u232b-\u237b\u237d-\u239a\u23b4-\u23db\u23e2-\u23e7\u2400-\u2426\u2440-\u244a\u249c-\u24e9\u2500-\u25b6\u25b8-\u25c0\u25c2-\u25f7\u2600-\u266e\u2670-\u269c\u26a0-\u26b2\u2701-\u2704\u2706-\u2709\u270c-\u2727\u2729-\u274b\u274d\u274f-\u2752\u2756\u2758-\u275e\u2761-\u2767\u2794\u2798-\u27af\u27b1-\u27be\u2800-\u28ff\u2b00-\u2b1a\u2b20-\u2b23\u2ce5-\u2cea\u2e80-\u2e99\u2e9b-\u2ef3\u2f00-\u2fd5\u2ff0-\u2ffb\u3004\u3012\u3013\u3020\u3036\u3037\u303e\u303f\u3190\u3191\u3196-\u319f\u31c0-\u31cf\u3200-\u321e\u322a-\u3243\u3250\u3260-\u327f\u328a-\u32b0\u32c0-\u32fe\u3300-\u33ff\u4dc0-\u4dff\ua490-\ua4c6\ua828-\ua82b\ufdfd\uffe4\uffe8\uffed\uffee\ufffc\ufffd]',
		Po:'[\u0021-\u0023\u0025-\u0027\u002a\u002c\u002e\u002f\u003a\u003b\u003f\u0040\u005c\u00a1\u00b7\u00bf\u037e\u0387\u055a-\u055f\u0589\u05be\u05c0\u05c3\u05c6\u05f3\u05f4\u060c\u060d\u061b\u061e\u061f\u066a-\u066d\u06d4\u0700-\u070d\u07f7-\u07f9\u0964\u0965\u0970\u0df4\u0e4f\u0e5a\u0e5b\u0f04-\u0f12\u0f85\u0fd0\u0fd1\u104a-\u104f\u10fb\u1361-\u1368\u166d\u166e\u16eb-\u16ed\u1735\u1736\u17d4-\u17d6\u17d8-\u17da\u1800-\u1805\u1807-\u180a\u1944\u1945\u19de\u19df\u1a1e\u1a1f\u1b5a-\u1b60\u2016\u2017\u2020-\u2027\u2030-\u2038\u203b-\u203e\u2041-\u2043\u2047-\u2051\u2053\u2055-\u205e\u2cf9-\u2cfc\u2cfe\u2cff\u2e00\u2e01\u2e06-\u2e08\u2e0b\u2e0e-\u2e16\u3001-\u3003\u303d\u30fb\ua874-\ua877\ufe10-\ufe16\ufe19\ufe30\ufe45\ufe46\ufe49-\ufe4c\ufe50-\ufe52\ufe54-\ufe57\ufe5f-\ufe61\ufe68\ufe6a\ufe6b\uff01-\uff03\uff05-\uff07\uff0a\uff0c\uff0e\uff0f\uff1a\uff1b\uff1f\uff20\uff3c\uff61\uff64\uff65]',
		Mn:'[\u0300-\u036f\u0483-\u0486\u0591-\u05bd\u05bf\u05c1\u05c2\u05c4\u05c5\u05c7\u0610-\u0615\u064b-\u065e\u0670\u06d6-\u06dc\u06df-\u06e4\u06e7\u06e8\u06ea-\u06ed\u0711\u0730-\u074a\u07a6-\u07b0\u07eb-\u07f3\u0901\u0902\u093c\u0941-\u0948\u094d\u0951-\u0954\u0962\u0963\u0981\u09bc\u09c1-\u09c4\u09cd\u09e2\u09e3\u0a01\u0a02\u0a3c\u0a41\u0a42\u0a47\u0a48\u0a4b-\u0a4d\u0a70\u0a71\u0a81\u0a82\u0abc\u0ac1-\u0ac5\u0ac7\u0ac8\u0acd\u0ae2\u0ae3\u0b01\u0b3c\u0b3f\u0b41-\u0b43\u0b4d\u0b56\u0b82\u0bc0\u0bcd\u0c3e-\u0c40\u0c46-\u0c48\u0c4a-\u0c4d\u0c55\u0c56\u0cbc\u0cbf\u0cc6\u0ccc\u0ccd\u0ce2\u0ce3\u0d41-\u0d43\u0d4d\u0dca\u0dd2-\u0dd4\u0dd6\u0e31\u0e34-\u0e3a\u0e47-\u0e4e\u0eb1\u0eb4-\u0eb9\u0ebb\u0ebc\u0ec8-\u0ecd\u0f18\u0f19\u0f35\u0f37\u0f39\u0f71-\u0f7e\u0f80-\u0f84\u0f86\u0f87\u0f90-\u0f97\u0f99-\u0fbc\u0fc6\u102d-\u1030\u1032\u1036\u1037\u1039\u1058\u1059\u135f\u1712-\u1714\u1732-\u1734\u1752\u1753\u1772\u1773\u17b7-\u17bd\u17c6\u17c9-\u17d3\u17dd\u180b-\u180d\u18a9\u1920-\u1922\u1927\u1928\u1932\u1939-\u193b\u1a17\u1a18\u1b00-\u1b03\u1b34\u1b36-\u1b3a\u1b3c\u1b42\u1b6b-\u1b73\u1dc0-\u1dca\u1dfe\u1dff\u20d0-\u20dc\u20e1\u20e5-\u20ef\u302a-\u302f\u3099\u309a\ua806\ua80b\ua825\ua826\ufb1e\ufe00-\ufe0f\ufe20-\ufe23]',
		Ps:'[\u0028\u005b\u007b\u0f3a\u0f3c\u169b\u201a\u201e\u2045\u207d\u208d\u2329\u2768\u276a\u276c\u276e\u2770\u2772\u2774\u27c5\u27e6\u27e8\u27ea\u2983\u2985\u2987\u2989\u298b\u298d\u298f\u2991\u2993\u2995\u2997\u29d8\u29da\u29fc\u3008\u300a\u300c\u300e\u3010\u3014\u3016\u3018\u301a\u301d\ufd3e\ufe17\ufe35\ufe37\ufe39\ufe3b\ufe3d\ufe3f\ufe41\ufe43\ufe47\ufe59\ufe5b\ufe5d\uff08\uff3b\uff5b\uff5f\uff62]',
		Cc:'[\u0000-\u001f\u007f-\u009f]',
		Cf:'[\u00ad\u0600-\u0603\u06dd\u070f\u17b4\u17b5\u200b-\u200f\u202a-\u202e\u2060-\u2063\u206a-\u206f\ufeff\ufff9-\ufffb]',
		Ll:'[\u0061-\u007a\u00aa\u00b5\u00ba\u00df-\u00f6\u00f8-\u00ff\u0101\u0103\u0105\u0107\u0109\u010b\u010d\u010f\u0111\u0113\u0115\u0117\u0119\u011b\u011d\u011f\u0121\u0123\u0125\u0127\u0129\u012b\u012d\u012f\u0131\u0133\u0135\u0137\u0138\u013a\u013c\u013e\u0140\u0142\u0144\u0146\u0148\u0149\u014b\u014d\u014f\u0151\u0153\u0155\u0157\u0159\u015b\u015d\u015f\u0161\u0163\u0165\u0167\u0169\u016b\u016d\u016f\u0171\u0173\u0175\u0177\u017a\u017c\u017e-\u0180\u0183\u0185\u0188\u018c\u018d\u0192\u0195\u0199-\u019b\u019e\u01a1\u01a3\u01a5\u01a8\u01aa\u01ab\u01ad\u01b0\u01b4\u01b6\u01b9\u01ba\u01bd-\u01bf\u01c6\u01c9\u01cc\u01ce\u01d0\u01d2\u01d4\u01d6\u01d8\u01da\u01dc\u01dd\u01df\u01e1\u01e3\u01e5\u01e7\u01e9\u01eb\u01ed\u01ef\u01f0\u01f3\u01f5\u01f9\u01fb\u01fd\u01ff\u0201\u0203\u0205\u0207\u0209\u020b\u020d\u020f\u0211\u0213\u0215\u0217\u0219\u021b\u021d\u021f\u0221\u0223\u0225\u0227\u0229\u022b\u022d\u022f\u0231\u0233-\u0239\u023c\u023f\u0240\u0242\u0247\u0249\u024b\u024d\u024f-\u0293\u0295-\u02af\u037b-\u037d\u0390\u03ac-\u03ce\u03d0\u03d1\u03d5-\u03d7\u03d9\u03db\u03dd\u03df\u03e1\u03e3\u03e5\u03e7\u03e9\u03eb\u03ed\u03ef-\u03f3\u03f5\u03f8\u03fb\u03fc\u0430-\u045f\u0461\u0463\u0465\u0467\u0469\u046b\u046d\u046f\u0471\u0473\u0475\u0477\u0479\u047b\u047d\u047f\u0481\u048b\u048d\u048f\u0491\u0493\u0495\u0497\u0499\u049b\u049d\u049f\u04a1\u04a3\u04a5\u04a7\u04a9\u04ab\u04ad\u04af\u04b1\u04b3\u04b5\u04b7\u04b9\u04bb\u04bd\u04bf\u04c2\u04c4\u04c6\u04c8\u04ca\u04cc\u04ce\u04cf\u04d1\u04d3\u04d5\u04d7\u04d9\u04db\u04dd\u04df\u04e1\u04e3\u04e5\u04e7\u04e9\u04eb\u04ed\u04ef\u04f1\u04f3\u04f5\u04f7\u04f9\u04fb\u04fd\u04ff\u0501\u0503\u0505\u0507\u0509\u050b\u050d\u050f\u0511\u0513\u0561-\u0587\u1d00-\u1d2b\u1d62-\u1d77\u1d79-\u1d9a\u1e01\u1e03\u1e05\u1e07\u1e09\u1e0b\u1e0d\u1e0f\u1e11\u1e13\u1e15\u1e17\u1e19\u1e1b\u1e1d\u1e1f\u1e21\u1e23\u1e25\u1e27\u1e29\u1e2b\u1e2d\u1e2f\u1e31\u1e33\u1e35\u1e37\u1e39\u1e3b\u1e3d\u1e3f\u1e41\u1e43\u1e45\u1e47\u1e49\u1e4b\u1e4d\u1e4f\u1e51\u1e53\u1e55\u1e57\u1e59\u1e5b\u1e5d\u1e5f\u1e61\u1e63\u1e65\u1e67\u1e69\u1e6b\u1e6d\u1e6f\u1e71\u1e73\u1e75\u1e77\u1e79\u1e7b\u1e7d\u1e7f\u1e81\u1e83\u1e85\u1e87\u1e89\u1e8b\u1e8d\u1e8f\u1e91\u1e93\u1e95-\u1e9b\u1ea1\u1ea3\u1ea5\u1ea7\u1ea9\u1eab\u1ead\u1eaf\u1eb1\u1eb3\u1eb5\u1eb7\u1eb9\u1ebb\u1ebd\u1ebf\u1ec1\u1ec3\u1ec5\u1ec7\u1ec9\u1ecb\u1ecd\u1ecf\u1ed1\u1ed3\u1ed5\u1ed7\u1ed9\u1edb\u1edd\u1edf\u1ee1\u1ee3\u1ee5\u1ee7\u1ee9\u1eeb\u1eed\u1eef\u1ef1\u1ef3\u1ef5\u1ef7\u1ef9\u1f00-\u1f07\u1f10-\u1f15\u1f20-\u1f27\u1f30-\u1f37\u1f40-\u1f45\u1f50-\u1f57\u1f60-\u1f67\u1f70-\u1f7d\u1f80-\u1f87\u1f90-\u1f97\u1fa0-\u1fa7\u1fb0-\u1fb4\u1fb6\u1fb7\u1fbe\u1fc2-\u1fc4\u1fc6\u1fc7\u1fd0-\u1fd3\u1fd6\u1fd7\u1fe0-\u1fe7\u1ff2-\u1ff4\u1ff6\u1ff7\u2071\u207f\u210a\u210e\u210f\u2113\u212f\u2134\u2139\u213c\u213d\u2146-\u2149\u214e\u2184\u2c30-\u2c5e\u2c61\u2c65\u2c66\u2c68\u2c6a\u2c6c\u2c74\u2c76\u2c77\u2c81\u2c83\u2c85\u2c87\u2c89\u2c8b\u2c8d\u2c8f\u2c91\u2c93\u2c95\u2c97\u2c99\u2c9b\u2c9d\u2c9f\u2ca1\u2ca3\u2ca5\u2ca7\u2ca9\u2cab\u2cad\u2caf\u2cb1\u2cb3\u2cb5\u2cb7\u2cb9\u2cbb\u2cbd\u2cbf\u2cc1\u2cc3\u2cc5\u2cc7\u2cc9\u2ccb\u2ccd\u2ccf\u2cd1\u2cd3\u2cd5\u2cd7\u2cd9\u2cdb\u2cdd\u2cdf\u2ce1\u2ce3\u2ce4\u2d00-\u2d25\ufb00-\ufb06\ufb13-\ufb17\uff41-\uff5a]',
		Lm:'[\u02b0-\u02c1\u02c6-\u02d1\u02e0-\u02e4\u02ee\u037a\u0559\u0640\u06e5\u06e6\u07f4\u07f5\u07fa\u0e46\u0ec6\u10fc\u17d7\u1843\u1d2c-\u1d61\u1d78\u1d9b-\u1dbf\u2090-\u2094\u2d6f\u3005\u3031-\u3035\u303b\u309d\u309e\u30fc-\u30fe\ua015\ua717-\ua71a\uff70\uff9e\uff9f]',
		Lo:'[\u01bb\u01c0-\u01c3\u0294\u05d0-\u05ea\u05f0-\u05f2\u0621-\u063a\u0641-\u064a\u066e\u066f\u0671-\u06d3\u06d5\u06ee\u06ef\u06fa-\u06fc\u06ff\u0710\u0712-\u072f\u074d-\u076d\u0780-\u07a5\u07b1\u07ca-\u07ea\u0904-\u0939\u093d\u0950\u0958-\u0961\u097b-\u097f\u0985-\u098c\u098f\u0990\u0993-\u09a8\u09aa-\u09b0\u09b2\u09b6-\u09b9\u09bd\u09ce\u09dc\u09dd\u09df-\u09e1\u09f0\u09f1\u0a05-\u0a0a\u0a0f\u0a10\u0a13-\u0a28\u0a2a-\u0a30\u0a32\u0a33\u0a35\u0a36\u0a38\u0a39\u0a59-\u0a5c\u0a5e\u0a72-\u0a74\u0a85-\u0a8d\u0a8f-\u0a91\u0a93-\u0aa8\u0aaa-\u0ab0\u0ab2\u0ab3\u0ab5-\u0ab9\u0abd\u0ad0\u0ae0\u0ae1\u0b05-\u0b0c\u0b0f\u0b10\u0b13-\u0b28\u0b2a-\u0b30\u0b32\u0b33\u0b35-\u0b39\u0b3d\u0b5c\u0b5d\u0b5f-\u0b61\u0b71\u0b83\u0b85-\u0b8a\u0b8e-\u0b90\u0b92-\u0b95\u0b99\u0b9a\u0b9c\u0b9e\u0b9f\u0ba3\u0ba4\u0ba8-\u0baa\u0bae-\u0bb9\u0c05-\u0c0c\u0c0e-\u0c10\u0c12-\u0c28\u0c2a-\u0c33\u0c35-\u0c39\u0c60\u0c61\u0c85-\u0c8c\u0c8e-\u0c90\u0c92-\u0ca8\u0caa-\u0cb3\u0cb5-\u0cb9\u0cbd\u0cde\u0ce0\u0ce1\u0d05-\u0d0c\u0d0e-\u0d10\u0d12-\u0d28\u0d2a-\u0d39\u0d60\u0d61\u0d85-\u0d96\u0d9a-\u0db1\u0db3-\u0dbb\u0dbd\u0dc0-\u0dc6\u0e01-\u0e30\u0e32\u0e33\u0e40-\u0e45\u0e81\u0e82\u0e84\u0e87\u0e88\u0e8a\u0e8d\u0e94-\u0e97\u0e99-\u0e9f\u0ea1-\u0ea3\u0ea5\u0ea7\u0eaa\u0eab\u0ead-\u0eb0\u0eb2\u0eb3\u0ebd\u0ec0-\u0ec4\u0edc\u0edd\u0f00\u0f40-\u0f47\u0f49-\u0f6a\u0f88-\u0f8b\u1000-\u1021\u1023-\u1027\u1029\u102a\u1050-\u1055\u10d0-\u10fa\u1100-\u1159\u115f-\u11a2\u11a8-\u11f9\u1200-\u1248\u124a-\u124d\u1250-\u1256\u1258\u125a-\u125d\u1260-\u1288\u128a-\u128d\u1290-\u12b0\u12b2-\u12b5\u12b8-\u12be\u12c0\u12c2-\u12c5\u12c8-\u12d6\u12d8-\u1310\u1312-\u1315\u1318-\u135a\u1380-\u138f\u13a0-\u13f4\u1401-\u166c\u166f-\u1676\u1681-\u169a\u16a0-\u16ea\u1700-\u170c\u170e-\u1711\u1720-\u1731\u1740-\u1751\u1760-\u176c\u176e-\u1770\u1780-\u17b3\u17dc\u1820-\u1842\u1844-\u1877\u1880-\u18a8\u1900-\u191c\u1950-\u196d\u1970-\u1974\u1980-\u19a9\u19c1-\u19c7\u1a00-\u1a16\u1b05-\u1b33\u1b45-\u1b4b\u2135-\u2138\u2d30-\u2d65\u2d80-\u2d96\u2da0-\u2da6\u2da8-\u2dae\u2db0-\u2db6\u2db8-\u2dbe\u2dc0-\u2dc6\u2dc8-\u2dce\u2dd0-\u2dd6\u2dd8-\u2dde\u3006\u303c\u3041-\u3096\u309f\u30a1-\u30fa\u30ff\u3105-\u312c\u3131-\u318e\u31a0-\u31b7\u31f0-\u31ff\u3400\u4db5\u4e00\u9fbb\ua000-\ua014\ua016-\ua48c\ua800\ua801\ua803-\ua805\ua807-\ua80a\ua80c-\ua822\ua840-\ua873\uac00\ud7a3\uf900-\ufa2d\ufa30-\ufa6a\ufa70-\ufad9\ufb1d\ufb1f-\ufb28\ufb2a-\ufb36\ufb38-\ufb3c\ufb3e\ufb40\ufb41\ufb43\ufb44\ufb46-\ufbb1\ufbd3-\ufd3d\ufd50-\ufd8f\ufd92-\ufdc7\ufdf0-\ufdfb\ufe70-\ufe74\ufe76-\ufefc\uff66-\uff6f\uff71-\uff9d\uffa0-\uffbe\uffc2-\uffc7\uffca-\uffcf\uffd2-\uffd7\uffda-\uffdc]',
		Co:'[\ue000\uf8ff]',
		Nd:'[\u0030-\u0039\u0660-\u0669\u06f0-\u06f9\u07c0-\u07c9\u0966-\u096f\u09e6-\u09ef\u0a66-\u0a6f\u0ae6-\u0aef\u0b66-\u0b6f\u0be6-\u0bef\u0c66-\u0c6f\u0ce6-\u0cef\u0d66-\u0d6f\u0e50-\u0e59\u0ed0-\u0ed9\u0f20-\u0f29\u1040-\u1049\u17e0-\u17e9\u1810-\u1819\u1946-\u194f\u19d0-\u19d9\u1b50-\u1b59\uff10-\uff19]',
		Lt:'[\u01c5\u01c8\u01cb\u01f2\u1f88-\u1f8f\u1f98-\u1f9f\u1fa8-\u1faf\u1fbc\u1fcc\u1ffc]',
		Lu:'[\u0041-\u005a\u00c0-\u00d6\u00d8-\u00de\u0100\u0102\u0104\u0106\u0108\u010a\u010c\u010e\u0110\u0112\u0114\u0116\u0118\u011a\u011c\u011e\u0120\u0122\u0124\u0126\u0128\u012a\u012c\u012e\u0130\u0132\u0134\u0136\u0139\u013b\u013d\u013f\u0141\u0143\u0145\u0147\u014a\u014c\u014e\u0150\u0152\u0154\u0156\u0158\u015a\u015c\u015e\u0160\u0162\u0164\u0166\u0168\u016a\u016c\u016e\u0170\u0172\u0174\u0176\u0178\u0179\u017b\u017d\u0181\u0182\u0184\u0186\u0187\u0189-\u018b\u018e-\u0191\u0193\u0194\u0196-\u0198\u019c\u019d\u019f\u01a0\u01a2\u01a4\u01a6\u01a7\u01a9\u01ac\u01ae\u01af\u01b1-\u01b3\u01b5\u01b7\u01b8\u01bc\u01c4\u01c7\u01ca\u01cd\u01cf\u01d1\u01d3\u01d5\u01d7\u01d9\u01db\u01de\u01e0\u01e2\u01e4\u01e6\u01e8\u01ea\u01ec\u01ee\u01f1\u01f4\u01f6-\u01f8\u01fa\u01fc\u01fe\u0200\u0202\u0204\u0206\u0208\u020a\u020c\u020e\u0210\u0212\u0214\u0216\u0218\u021a\u021c\u021e\u0220\u0222\u0224\u0226\u0228\u022a\u022c\u022e\u0230\u0232\u023a\u023b\u023d\u023e\u0241\u0243-\u0246\u0248\u024a\u024c\u024e\u0386\u0388-\u038a\u038c\u038e\u038f\u0391-\u03a1\u03a3-\u03ab\u03d2-\u03d4\u03d8\u03da\u03dc\u03de\u03e0\u03e2\u03e4\u03e6\u03e8\u03ea\u03ec\u03ee\u03f4\u03f7\u03f9\u03fa\u03fd-\u042f\u0460\u0462\u0464\u0466\u0468\u046a\u046c\u046e\u0470\u0472\u0474\u0476\u0478\u047a\u047c\u047e\u0480\u048a\u048c\u048e\u0490\u0492\u0494\u0496\u0498\u049a\u049c\u049e\u04a0\u04a2\u04a4\u04a6\u04a8\u04aa\u04ac\u04ae\u04b0\u04b2\u04b4\u04b6\u04b8\u04ba\u04bc\u04be\u04c0\u04c1\u04c3\u04c5\u04c7\u04c9\u04cb\u04cd\u04d0\u04d2\u04d4\u04d6\u04d8\u04da\u04dc\u04de\u04e0\u04e2\u04e4\u04e6\u04e8\u04ea\u04ec\u04ee\u04f0\u04f2\u04f4\u04f6\u04f8\u04fa\u04fc\u04fe\u0500\u0502\u0504\u0506\u0508\u050a\u050c\u050e\u0510\u0512\u0531-\u0556\u10a0-\u10c5\u1e00\u1e02\u1e04\u1e06\u1e08\u1e0a\u1e0c\u1e0e\u1e10\u1e12\u1e14\u1e16\u1e18\u1e1a\u1e1c\u1e1e\u1e20\u1e22\u1e24\u1e26\u1e28\u1e2a\u1e2c\u1e2e\u1e30\u1e32\u1e34\u1e36\u1e38\u1e3a\u1e3c\u1e3e\u1e40\u1e42\u1e44\u1e46\u1e48\u1e4a\u1e4c\u1e4e\u1e50\u1e52\u1e54\u1e56\u1e58\u1e5a\u1e5c\u1e5e\u1e60\u1e62\u1e64\u1e66\u1e68\u1e6a\u1e6c\u1e6e\u1e70\u1e72\u1e74\u1e76\u1e78\u1e7a\u1e7c\u1e7e\u1e80\u1e82\u1e84\u1e86\u1e88\u1e8a\u1e8c\u1e8e\u1e90\u1e92\u1e94\u1ea0\u1ea2\u1ea4\u1ea6\u1ea8\u1eaa\u1eac\u1eae\u1eb0\u1eb2\u1eb4\u1eb6\u1eb8\u1eba\u1ebc\u1ebe\u1ec0\u1ec2\u1ec4\u1ec6\u1ec8\u1eca\u1ecc\u1ece\u1ed0\u1ed2\u1ed4\u1ed6\u1ed8\u1eda\u1edc\u1ede\u1ee0\u1ee2\u1ee4\u1ee6\u1ee8\u1eea\u1eec\u1eee\u1ef0\u1ef2\u1ef4\u1ef6\u1ef8\u1f08-\u1f0f\u1f18-\u1f1d\u1f28-\u1f2f\u1f38-\u1f3f\u1f48-\u1f4d\u1f59\u1f5b\u1f5d\u1f5f\u1f68-\u1f6f\u1fb8-\u1fbb\u1fc8-\u1fcb\u1fd8-\u1fdb\u1fe8-\u1fec\u1ff8-\u1ffb\u2102\u2107\u210b-\u210d\u2110-\u2112\u2115\u2119-\u211d\u2124\u2126\u2128\u212a-\u212d\u2130-\u2133\u213e\u213f\u2145\u2183\u2c00-\u2c2e\u2c60\u2c62-\u2c64\u2c67\u2c69\u2c6b\u2c75\u2c80\u2c82\u2c84\u2c86\u2c88\u2c8a\u2c8c\u2c8e\u2c90\u2c92\u2c94\u2c96\u2c98\u2c9a\u2c9c\u2c9e\u2ca0\u2ca2\u2ca4\u2ca6\u2ca8\u2caa\u2cac\u2cae\u2cb0\u2cb2\u2cb4\u2cb6\u2cb8\u2cba\u2cbc\u2cbe\u2cc0\u2cc2\u2cc4\u2cc6\u2cc8\u2cca\u2ccc\u2cce\u2cd0\u2cd2\u2cd4\u2cd6\u2cd8\u2cda\u2cdc\u2cde\u2ce0\u2ce2\uff21-\uff3a]',
		Cs:'[\ud800\udb7f\udb80\udbff\udc00\udfff]',
		Zl:'[\u2028]',
		Nl:'[\u16ee-\u16f0\u2160-\u2182\u3007\u3021-\u3029\u3038-\u303a]',
		Zp:'[\u2029]',
		No:'[\u00b2\u00b3\u00b9\u00bc-\u00be\u09f4-\u09f9\u0bf0-\u0bf2\u0f2a-\u0f33\u1369-\u137c\u17f0-\u17f9\u2070\u2074-\u2079\u2080-\u2089\u2153-\u215f\u2460-\u249b\u24ea-\u24ff\u2776-\u2793\u2cfd\u3192-\u3195\u3220-\u3229\u3251-\u325f\u3280-\u3289\u32b1-\u32bf]',
		Zs:'[\u0020\u00a0\u1680\u180e\u2000-\u200a\u202f\u205f\u3000]',
		Sc:'[\u0024\u00a2-\u00a5\u060b\u09f2\u09f3\u0af1\u0bf9\u0e3f\u17db\u20a0-\u20b5\ufdfc\ufe69\uff04\uffe0\uffe1\uffe5\uffe6]',
		Pc:'[\u005f\u203f\u2040\u2054\ufe33\ufe34\ufe4d-\ufe4f\uff3f]',
		Pd:'[\u002d\u058a\u1806\u2010-\u2015\u2e17\u301c\u3030\u30a0\ufe31\ufe32\ufe58\ufe63\uff0d]',
		Pe:'[\u0029\u005d\u007d\u0f3b\u0f3d\u169c\u2046\u207e\u208e\u232a\u2769\u276b\u276d\u276f\u2771\u2773\u2775\u27c6\u27e7\u27e9\u27eb\u2984\u2986\u2988\u298a\u298c\u298e\u2990\u2992\u2994\u2996\u2998\u29d9\u29db\u29fd\u3009\u300b\u300d\u300f\u3011\u3015\u3017\u3019\u301b\u301e\u301f\ufd3f\ufe18\ufe36\ufe38\ufe3a\ufe3c\ufe3e\ufe40\ufe42\ufe44\ufe48\ufe5a\ufe5c\ufe5e\uff09\uff3d\uff5d\uff60\uff63]',
		Pf:'[\u00bb\u2019\u201d\u203a\u2e03\u2e05\u2e0a\u2e0d\u2e1d]',
		Me:'[\u0488\u0489\u06de\u20dd-\u20e0\u20e2-\u20e4]',
		Mc:'[\u0903\u093e-\u0940\u0949-\u094c\u0982\u0983\u09be-\u09c0\u09c7\u09c8\u09cb\u09cc\u09d7\u0a03\u0a3e-\u0a40\u0a83\u0abe-\u0ac0\u0ac9\u0acb\u0acc\u0b02\u0b03\u0b3e\u0b40\u0b47\u0b48\u0b4b\u0b4c\u0b57\u0bbe\u0bbf\u0bc1\u0bc2\u0bc6-\u0bc8\u0bca-\u0bcc\u0bd7\u0c01-\u0c03\u0c41-\u0c44\u0c82\u0c83\u0cbe\u0cc0-\u0cc4\u0cc7\u0cc8\u0cca\u0ccb\u0cd5\u0cd6\u0d02\u0d03\u0d3e-\u0d40\u0d46-\u0d48\u0d4a-\u0d4c\u0d57\u0d82\u0d83\u0dcf-\u0dd1\u0dd8-\u0ddf\u0df2\u0df3\u0f3e\u0f3f\u0f7f\u102c\u1031\u1038\u1056\u1057\u17b6\u17be-\u17c5\u17c7\u17c8\u1923-\u1926\u1929-\u192b\u1930\u1931\u1933-\u1938\u19b0-\u19c0\u19c8\u19c9\u1a19-\u1a1b\u1b04\u1b35\u1b3b\u1b3d-\u1b41\u1b43\u1b44\ua802\ua823\ua824\ua827]'
	};
	/* Also supports the general category (only the first letter) */
	var firstLetters = {};
	for (var p in unicodeCategories)
	{
		if (firstLetters[p[0]])
			firstLetters[p[0]] = unicodeCategories[p].substring(0,unicodeCategories[p].length-1) + firstLetters[p[0]].substring(1);
		else
			firstLetters[p[0]] = unicodeCategories[p];
	}
	for (var p in firstLetters)
		unicodeCategories[p] = firstLetters[p];

	/* Gets a regex written in a dialect that supports unicode categories and
	   translates it to a dialect supported by JavaScript. */
	return function(regexpString, classes)
	{
		var modifiers = "";
		if ( regexpString instanceof RegExp ) {
			modifiers = (regexpString.global ? "g" : "") +
						(regexpString.ignoreCase ? "i" : "") +
						(regexpString.multiline ? "m" : "");
			regexpString = regexpString.source;
		}
		regexpString = regexpString.replace(/\\p\{(..?)\}/g, function(match,group) {
		var unicode_categorie = unicodeCategories[group];
		if (!classes)
			unicode_category = unicode_categorie.replace(/\[(.*?)\]/g,"$1")
			return unicode_category || match;
		});
		return new RegExp(regexpString,modifiers);
	};

})();
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
function validate_isName(s)
{
	var reg = /^[^0-9!<>,;?=+()@#"°{}_$%:]+$/;
	return reg.test(s);
}

function validate_isGenericName(s)
{
	var reg = /^[^<>={}]+$/;
	return reg.test(s);
}

function validate_isAddress(s)
{
	var reg = /^[^!<>?=+@{}_$%]+$/;
	return reg.test(s);
}

function validate_isPostCode(s, pattern, iso_code)
{
	if (typeof iso_code === 'undefined' || iso_code == '')
		iso_code = '[A-Z]{2}';
	if (typeof(pattern) == 'undefined' || pattern.length == 0)
		pattern = '[a-zA-Z 0-9-]+';
	else
	{
		var replacements = {
			' ': '(?:\ |)',
			'-': '(?:-|)',
			'N': '[0-9]',
			'L': '[a-zA-Z]',
			'C': iso_code
		};

		for (var new_value in replacements)
			pattern = pattern.split(new_value).join(replacements[new_value]);
	}
	var reg = new RegExp('^' + pattern + '$');
	return reg.test(s);
}

function validate_isCityName(s)
{
	var reg = /^[^!<>;?=+@#"°{}_$%]+$/;
	return reg.test(s);
}

function validate_isMessage(s)
{
	var reg = /^[^<>{}]+$/;
	return reg.test(s);
}

function validate_isPhoneNumber(s)
{
	var reg = /^[+0-9. ()-]+$/;
	return reg.test(s);
	//return (s.length >= 10 && s.length < 11);
}

function validate_isDniLite(s)
{
	var reg = /^[0-9a-z-.]{1,16}$/i;
	return reg.test(s);
}

function validate_isEmail(s)
{
	var reg = unicode_hack(/^[a-z\p{L}0-9!#$%&'*+\/=?^`{}|~_-]+[.a-z\p{L}0-9!#$%&'*+\/=?^`{}|~_-]*@[a-z\p{L}0-9]+[._a-z\p{L}0-9-]*\.[a-z\p{L}0-9]+$/i, false);
	return reg.test(s);
}

function validate_isPasswd(s)
{
	return (s.length >= 5 && s.length < 255);
}

function validate_field(that)
{
	if ($(that).hasClass('is_required') || $(that).val().length)
	{
		if ($(that).attr('data-validate') == 'isPostCode')
		{
			var selector = '#id_country';
			if ($(that).attr('name') == 'postcode_invoice')
				selector += '_invoice';

			var id_country = $(selector + ' option:selected').val();

			if (typeof(countriesNeedZipCode[id_country]) != 'undefined' && typeof(countries[id_country]) != 'undefined')
				var result = window['validate_'+$(that).attr('data-validate')]($(that).val(), countriesNeedZipCode[id_country], countries[id_country]['iso_code']);
		}
		else if($(that).attr('data-validate'))
			var result = window['validate_' + $(that).attr('data-validate')]($(that).val());

		if (result)
			$(that).parent().removeClass('form-error').addClass('form-ok');
		else
			$(that).parent().addClass('form-error').removeClass('form-ok');
	}
}

$(document).on('focusout', 'input.validate, textarea.validate', function() {
	validate_field(this);
});

/*Created By Sreeni on 23-DEC-2015
Created this file for upgrade the prestashop version 1.4.8.1->1.6.1.3
This file contains all additional feature's JS functions  which the prestashop dosen't have.
This is the only file we need to write the aditional features codes.
*/

//Picode Code Feature for Product.tpl
$("#pincode").keypress(function (e) {
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		return false;
	}
});
		
function fn_remove()
{
 	$('#pincode').attr('placeholder','');
  	$('#pincode').focusout(function(){
	$(this).attr('placeholder',"Pincode");
	});
}

//This is to check whether the Pincode is avialiable or not
function locationcheck(){
 var dataparam = "productid=" + id_product;
 	$.ajax(
		{
			type: 'POST',
			url: baseDir + 'location-check.php',
			dataType: 'json',
			cache: false,
			data: dataparam,
			success: function(result)
			{
				if(result.status == 1){
					
					 $('#pin_check').show();
					 //$('.ajax_add_to_cart_button').addClass('disabled');
					 $('#hiddenpincode').val(0);
				}
				else{
					 $('#pin_check').show();
					 
					 $('#hiddenpincode').val(1);
				}
			}
		});
		
}

function showpincode(){
	var pincode = $("#pincode").val();
	var id_product = $("#product_page_product_id").val();
	
	$('#pincode_add2cart_alert').hide();
	
	if(pincode.length != 6){
		$('#pin_notavailable, #pin_available').hide();		 
		$('#valid_pincode').show();
		return false;
	}
	
	var pincodelength=pincode.length;
	var dataparam = "pincode="+pincode+"&id_product="+id_product;
	$.ajax({
			type: 'POST',
			url: baseDir + 'pincode-ajax.php',
			async: true,
			cache: false,
			dataType: 'json',
			data: dataparam,						
			success: function (jsonData) {
				if(pincodelength == 6){
						if(jsonData.status == 1)
						{
							
							$('#pin_available').show();
							$('#valid_pincode, #pin_notavailable').hide();
							//$('.ajax_add_to_cart_button').removeClass('disabled');
							//$('#hiddenpincode').val(1);
							$('#hiddenpincode').val(1);
						}
						else if(jsonData.status == 0)
						{ 		
							
							$('#pin_available, #pin_notavailable').hide();
							$('#pin_notavailable').show();
							//$('#valid_pincode').show();
							//$('.ajax_add_to_cart_button').addClass('disabled');
							$('#hiddenpincode').val(0);
						}
						else
						{
							$('#pin_available, #pin_notavailable').hide();
							$('#valid_pincode').show();
							//$('.ajax_add_to_cart_button').addClass('disabled');
							//$('#hiddenpincode').val(2);
							$('#hiddenpincode').val(0);
						}
				}
			}
		});
}
function checkPinCode()
{
  	if($('#hiddenpincode').val() == 0)
	{
 		$('.ajax_add_to_cart_button').unbind('click');
		return false;
	}
	else if($('#hiddenpincode').val() == 1)
	{
 		$('.ajax_add_to_cart_button').bind('click');
		return false;
	}
}

//End of Pincode Function in product.tpl


//Verify-documentation for customer
function documentVerification()
{
 	$.ajax({
	       type: 'GET',
	       url: baseDir + 'buyer-verify.php',
	       /*async: false,*/
	       cache: false,
	       dataType: 'json',
	       data: 'ajax=true&id_customer='+id_customer+'',
	       success: function(jsonData)
	       {
 	       		$('.verified').html("");
	       		if(jsonData == 0)
	       		{
 	       			/*$('.verified').append('<div class="verification-pending">\
	       								   <span><i class="fa fa-exclamation-triangle"></i></span>\
	       								   <span>Verification Pending. In Order to verify that you are a business customer, You will have to upload a document. You can upload it now by</span>\
	       								   <a href="#"  onclick="openNewPop();">clicking here</a>\
	       								   <span>or you can upload it later.</span></div>');*/
	       		}
	       		else
	       		{
	       			$('.verified').html("");
					if(window.opener)
					{
 						window.opener.location.reload(); // or opener.location.href = opener.location.href;
						window.close(); // or self.close();
						//open.location.href = open.location.href;
						//self.close();
					}
	       		}
	       }
	});
}

function openNewPop()
{
	window.open("verify-document.php", "newwindow", "width=1100, height=650, left=125"); 
	return false;
}

// Start of Primary Document Ready
$(document).ready(function(){

	//Check state selection on selecting address step
	// $("#processAddress").click(function( event ) {
	//   event.preventDefault();
	//   var selected = $("#id_address_delivery").find('option:selected');
	//   var state_selected = selected.data('state');
	//   if(id_state_vat!=state_selected)
	//   {
	//   	$('#error_modal .modal-body').html("Pincode selected and address chosen are mismatching");
	//   	$('#error_modal').modal('show');
	//   }
	//   else
	//   {
	//   	$("#processAddressForm").submit();
	//   }

	// });

	// });
	
	/*$('.bxslider').bxSlider({
		pager: false,
		auto:true,
		minSlides: 1,
		maxSlides: 4,
		slideWidth: 240,
		moveSlides: 1,
		infiniteLoop:false
	});*/
	
	//Product Slider in Homepage
	var containerDivWidth=parseInt($(".bxslider").parents("#center_column").css("width"));
	
	// alert(containerDivWidth);

	//var productPageSelector= "body#product";
	var bodySelector = $("body").attr("id");

	if(isNaN(containerDivWidth)){
		return ;
	}
	else if(bodySelector=="product"){
	    if(containerDivWidth<=480){
	        $('.bxslider').bxSlider({			
	            minSlides: 1,
	            maxSlides: 1,
	            slideWidth: 240,
	            moveSlides: 1,
	            pager: false,
	            nextText: '',
	            prevText: '',
	            moveSlides:1,
	            infiniteLoop:true,
	            hideControlOnEnd: false
	        });
	    }
	    else if(containerDivWidth<=768){
	        $('.bxslider').bxSlider({			
	            minSlides: 1,
	            maxSlides: 2,
	            slideWidth: 240,
	            moveSlides: 1,
	            pager: false,
	            nextText: '',
	            prevText: '',
	            moveSlides:1,
	            infiniteLoop:true,
	            hideControlOnEnd: false

	        });
	    }
	    else{
	        $('.bxslider').bxSlider({			
	            minSlides: 1,
	            maxSlides: 4,
	            slideWidth: 240,
	            moveSlides: 1,
	            pager: false,
	            nextText: '',
	            prevText: '',
	            moveSlides:1,
	            infiniteLoop:true,
	            hideControlOnEnd: false

	            
	        });
	    }
	}
	else if(containerDivWidth){
	   if(containerDivWidth<=480){
		$('.bxslider').bxSlider({			
				minSlides: 1,
				maxSlides: 1,
				slideWidth: 243,
				moveSlides: 1,
				pager: false,
				nextText: '',
				prevText: '',
				moveSlides:1,
				infiniteLoop:true,
				hideControlOnEnd: false			
			});
		}
		else if(containerDivWidth<=768){
			$('.bxslider').bxSlider({			
				minSlides: 1,
				maxSlides: 3,
				slideWidth: 232,
				moveSlides: 1,
				pager: false,
				nextText: '',
				prevText: '',
				moveSlides:1,
				infiniteLoop:true,
				hideControlOnEnd: false			
			});
		}
		else{
			$('.bxslider').bxSlider({			
				minSlides: 1,
				maxSlides: 4,
				slideWidth: 240,
				moveSlides: 1,
				pager: false,
				nextText: '',
				prevText: '',
				moveSlides:1,
				infiniteLoop:true,
				hideControlOnEnd: false
			});
		}
	}

	//category on home page right column
	var idCategory2=$("#home-company .category-product .category:first").attr("id");
	$("#home-company .category-product .category:not(:first)").removeClass("arrow category-bg");		
	$("#home-company #view_all_category").attr("href","index.php?id_category="+idCategory2+"&controller=category&id_lang=1");
	$("#home-company .category_"+idCategory2).removeClass("hidden");	

	$("#home-company .category").click(function(){
		$("#home-company .category").removeClass("arrow category-bg");
		$(this).addClass("arrow category-bg");
		$("#home-company .category-product-col").addClass("hidden");
		$("#home-company .category_"+this.id).removeClass("hidden");
		$("#home-company #view_all_category").attr("href","index.php?id_category="+this.id+"&controller=category&id_lang=1");
	});

	var idCategory=$("#home-retailer .category-product .category:first").attr("id");
	$("#home-retailer .category-product .category:not(:first)").removeClass("arrow category-bg");		
	$("#home-retailer #view_all_category").attr("href","index.php?id_category="+idCategory+"&controller=category&id_lang=1");
	$("#home-retailer .category_"+idCategory).removeClass("hidden");

	$("#home-retailer .category").click(function(){
		$("#home-retailer .category").removeClass("arrow category-bg");
		$(this).addClass("arrow category-bg");
		$("#home-retailer .category-product-col").addClass("hidden");
		$("#home-retailer .category_"+this.id).removeClass("hidden");
		$("#home-retailer #view_all_category").attr("href","index.php?id_category="+this.id+"&controller=category&id_lang=1");
	});

});
// End of Primary Document Ready

function numbersOnly(e)
{
	var key=e.keyCode;
	if(!((key==8)||(key==46)||(key==190)||(key==110)||(key==9)||(key==110)||(key==109)||(key==173)||(key==107)||(key>=35&&key<=40)||(key>=48&&key<=57)||(key>=96&&key<=105)))
	{
		e.preventDefault();
	}
}
$(document).ready(function(){
	$("#star_rating").click(function(){
		$("#rating_product_li").click();
		if ($("#rating_product_tab").is(':visible')) {
		     $("html, body").animate({scrollTop: $("#rating_product_tab").offset().top});
		  }
	});
});

//The button to increament the product value
$(document).on('click', '.product_quantity_up', function(e){
	e.preventDefault();
	//fieldName = $(this).data('field-qty');
	fieldId = $(this).data('field-id');
	//var currentVal = parseInt($('input[name='+fieldName+']').val());
	var currentVal = parseInt($('#quantity_wanted_'+fieldId).val());
	var quantityAvailable=$('#quantity_wanted_'+fieldId).data('field-qtyAvailable');
	if (quantityAvailable > 0)
		quantityAvailableT = quantityAvailable;
	else
		quantityAvailableT = 100000000;
	if (!isNaN(currentVal) && currentVal < quantityAvailableT)
		$('#quantity_wanted_'+fieldId).val(currentVal + 1).trigger('keyup');
	else
		$('#quantity_wanted_'+fieldId).val(quantityAvailableT);
});

//The button to decrement the product value
$(document).on('click', '.product_quantity_down', function(e){
	e.preventDefault();
	fieldId = $(this).data('field-id');
	var currentVal = parseInt($('#quantity_wanted_'+fieldId).val());
	if (!isNaN(currentVal) && currentVal > 1)
		$('#quantity_wanted_'+fieldId).val(currentVal - 1).trigger('keyup');
	else
		$('#quantity_wanted_'+fieldId).val(1);
});

/* Deals copy of MOQ button, to avoid repeated id */
//The button to increament the product value
$(document).on('click', '.product_quantity_up_deals', function(e){
		e.preventDefault();
	//fieldName = $(this).data('field-qty');
	fieldId = $(this).data('field-id');
	//var currentVal = parseInt($('input[name='+fieldName+']').val());
	var currentVal = parseInt($('.quantity_wanted_'+fieldId).val());
	var quantityAvailable=$('.quantity_wanted_'+fieldId).data('field-qtyAvailable');
	if (quantityAvailable > 0)
		quantityAvailableT = quantityAvailable;
	else
		quantityAvailableT = 100000000;
	if (!isNaN(currentVal) && currentVal < quantityAvailableT)
		$('.quantity_wanted_'+fieldId).val(currentVal + 1).trigger('keyup');
	else
		$('.quantity_wanted_'+fieldId).val(quantityAvailableT);
});

//The button to decrement the product value
$(document).on('click', '.product_quantity_down_deals', function(e){
	e.preventDefault();
	fieldId = $(this).data('field-id');
	var currentVal = parseInt($('.quantity_wanted_'+fieldId).val());
	if (!isNaN(currentVal) && currentVal > 1)
		$('.quantity_wanted_'+fieldId).val(currentVal - 1).trigger('keyup');
	else
		$('.quantity_wanted_'+fieldId).val(1);
});




//Create Customer with Verification Document
function showUploadDocument()
{
	$(".upload").addClass("unvisible");
 /*$('.doc input').on('change', function() {
   var show_doc = $('input[name="upload_document"]:checked', '.doc').val(); 
     if(show_doc == 2)
    {
 	   $(".upload").addClass("unvisible");
	}
	else
	{
 		$(".upload").removeClass("unvisible");
	}
});*/
}

// Scroll to top
$(document).ready(function(){
	var $scrollToTop = $('.scroll-to-top');
	//Check to see if the window is top if not then display button
	$(window).scroll(function(){
		if ($(this).scrollTop() > 900) {
			$scrollToTop.fadeIn();
		} else {
			$scrollToTop.fadeOut();
		}
	});
	
	//Click event to scroll to top
	$scrollToTop.click(function(){
		$('html, body').animate({scrollTop : 0},1200,'swing');
		return false;
	});
	
});

//Animation for Scrolling
// $(document).ready(function(){
// 	$('a.smooth-scroll').on('click',function(e) {
// 	    e.preventDefault();

// 	    var target = this.hash;
// 	    var $target = $(target);

// 	    $('html, body').stop().animate({
// 	        'scrollTop': $target.offset().top
// 	    }, 1200, 'swing', function () {
// 	        window.location.hash = target;
// 	    });
// 	});
// });

//Scroll to Bottom for Newsletter Alert
$(document).ready(function() {
if($(".newsletter-form").hasClass("form-ok") || $(".newsletter-form").hasClass("form-error"))
    {
        $('html, body').animate({scrollTop: $('.subscribe-section').offset().top}, 'slow');
    }
});

//Zoho Chat Plugin
$(document).ready(function(){var $zoho=$zoho||{livedesk:{values:{},ready:function(){}}};var d=document;s=d.createElement("script");s.type="text/javascript";s.defer=true;s.src="https://salesiq.zoho.com/support.kobstereshoppvtltd/float.ls?embedname=kobstereshoppvtltd";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);});function online_chat()
{$("#zls_ctn_wrap").click();}



// Slider in All category page
$(document).ready(function(){
  $('#allCategory_slider').bxSlider({
	pager:true,
	auto: true 
  });
});

//Vertical carousel in All category page
$(document).ready(function(){
  $('.brand_carousel').bxSlider({
    mode: 'vertical',
    minSlides: 3,
    maxSlides: 5,
	pager:false,
	auto: true
  });
});

//Deals page Tab navigation
$(document).ready(function(){
	
	// Tab Navigation on page loading
	//  var target = window.location.hash;
	//  var $target = $(target);
	//  if (target){
	//  	$(".deals_content").addClass("hidden");

	//  	$(target).closest('.deals_content').removeClass("hidden");
		
	//      $('html, body').stop().animate({
	//          scrollTop: $target.offset().top
	//      }, 1200, 'swing', function () {
	//          window.location.hash = target;
	//      });
	//  }
	//  else{
	//  	$(".deals_content").addClass("hidden");
	//  	$(".deals_content:first").removeClass("hidden");
	//  }
	
	// Tab Navigation on clicking
	 $('a.deals-smooth-scroll').on('click',function (e) {
	     e.preventDefault();
	     var target = this.hash;
	     var $target = $(target);
		
	 	//$(".deals_content").addClass("hidden");

	 	//$(target).closest('.deals_content').removeClass("hidden");
		console.log("hi");
	     $('html, body').stop().animate({
	         scrollTop: $target.offset().top - 120
	     }, 1200, 'swing')
	 });
});

//Scroll Triggers
$(document).ready(function() {
	$('[data-toggle="popover"]').popover();

	/*$(".voucher-popup-trigger").click(function(){
		$('#voucher-signup').modal('show');
	});*/

	$("a.descriptionTab").on('click',function() {
	    $('html, body').animate({
	        'scrollTop' : $("div[name=description-tab]").position().top
	    });
	});

	$("a.featuresTab").on('click',function() {
	    $('html, body').animate({
	        'scrollTop' : $("div[name=features-tab]").position().top
	    });
	});

	$("a.brandTab").on('click',function() {
	    $('html, body').animate({
	        'scrollTop' : $("div[name=brand-tab]").position().top
	    });
	});

	$(".ratingTab").on('click',function() {
	    $('html, body').animate({
	        'scrollTop' : $("div[name=rating-tab]").position().top
	    });
	});
});

function brand_page_brand_filter(){
	var brand_filter = $("#brand_filter").val();
	
	if (brand_filter == 'all'){
		window.location.href = baseDir+'brands';
	}
	else {
		window.location.href = baseDir+brand_filter;
		
		//$("#brand_filter_form").submit();
		//window.location.href = brand_filter;
	}
}

$(document).ready(function() {
	$("#category_filter, #brand_filter, #selectProductSort, #nb_item").change(function(){
		$(".preloader").show();
	});
	$(".pagination ul li a, .showall button").click(function(){
		$(".preloader").show();
	});
	

	
	
});


function mobile_number(){
	var phone = $("#phone").val();
	var len = phone.length;
	if (len > 11 || len < 10){
		$( "#phone" ).parent().removeClass( "form-ok" );
		$( "#phone" ).parent().addClass( "form-error" );
	}
	else {
		if(isNaN(phone)){
			$( "#phone" ).parent().removeClass( "form-ok" );
			$( "#phone" ).parent().addClass( "form-error" );
		}
		else{
			$( "#phone" ).parent().addClass( "form-ok" );
			$( "#phone" ).parent().removeClass( "form-error" );	
		}
	}
}

// Perks Interactions
$(document).ready(function() {
	//Perks Main Banner
	$('.perksMainBanner').bxSlider({
		//pager: false,
		controls: true,
		nextSelector: '#nextBigBanner',
		prevSelector: '#prevBigBanner',
		nextText: ' ',
		prevText: ' ',
		onSliderLoad: function(){
			$(".perks-main-banner").css("visibility", "visible");
		}
	});
	//Share Button
	var $shareButton = $("a.social-share");
	$shareButton.click(function(e){
		e.preventDefault();
		if ($shareButton.hasClass("active")) {
			$shareButton.not(this).removeClass("active");
		}
		$(this).toggleClass("active");
	});

	// Login Interation
	var $registerButton = $("#gotoRegister");
	var $loginButton = $("#gotoLogin");
	var $loginWindow = $(".login-window");
	var $registerWindow = $(".register-window");
	$registerButton.click(function(e){
		e.preventDefault();
		$loginWindow.hide();
		$registerWindow.show(200);
	});
	$loginButton.click(function(e){
		e.preventDefault();
		$registerWindow.hide(0);
		$loginWindow.show(200);
	});

	//Feddback Form
	$('#feebackForm').validate({
        rules: {
            message: {
                required: true,
            }
        },
        errorElement: "span" ,                              
        messages: {
            message: "Sorry, message field can't be empty!",
        },
        submitHandler: function(form) {
            var dataparam = $('#feebackForm').serialize();
            $.ajax({
                type: 'POST',
                async: true,
                url: 'perks-feedback.php',
                data: dataparam,
                datatype: 'json',
                cache: true,
                global: false,
                beforeSend: function() { 
                    $('.inline-loading.register').show();
                },
                success: function(data) 
                {
                    var result = JSON.parse(data);
                    if(result.error){
                        $('#feedbackErr').html(result.error).show();
                        $(function() {
                            setTimeout(function() {
                                $("#registerErr").hide()
                            }, 8000);
                        });
                    }
                    else{
                        $('#feedbackOk').html(result.success).show();
                    }
                },
                complete: function() { 
                    $('.inline-loading.register').hide();
                }
            });
        }                
    });

	// IP Proof Upload
	$("#upload-proof").change(function(e){
        var selectedFile = e.target.files[0].name;
		$(".upload-proof-label").html(selectedFile);
    });

	// Smooth Scroll
	// $('.category-link-item').click(function() {
	// 	$('body').animate({
	// 		scrollTop: eval($('#' + $(this).attr('target')).offset().top + 150)
	// 	}, 1000);
	// });

	$('.product-value')
	.mouseenter(
		function(){
			$(this).siblings('.product-visual').addClass('hover');
		}
	)
	.mouseleave(
		function(){
			$(this).siblings('.product-visual').removeClass('hover');
		}
	);
	// Show EMI Details on click
	$('.emi').on( "click", function(e) {
		e.stopPropagation();
		var activeDiv = $(this).parent().parent();
		 $(this).parent().parent().addClass('hover-emi');
		$(document).on('click', function(event) {
			if (!$(event.target).closest(".emi-details").length) {
				activeDiv.removeClass('hover-emi');
				event.stopPropagation();
			} else{
				return false;
			}			
		});
	});

	// Show Offer Details
	$('.offers').on( "click", function(e) {
		e.stopPropagation();
		var activeDiv = $(this).parent().parent();
		 $(this).parent().parent().addClass('hover-offers');
		$(document).on('click', function(event) {
			if (!$(event.target).closest(".offer-details").length) {
				activeDiv.removeClass('hover-offers');
				event.stopPropagation();
			} else{
				//return false;
			}			
		});
	});
});