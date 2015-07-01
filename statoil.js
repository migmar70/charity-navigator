(function (d, e) {
    var f = !1;
    d(document).mouseup(function (b) {
        f = !1
    }), d.widget("ui.mouse", {
        options: {
            cancel: ":input,option",
            distance: 1,
            delay: 0
        },
        _mouseInit: function () {
            var a = this;
            this.element.bind("mousedown." + this.widgetName, function (b) {
                return a._mouseDown(b)
            }).bind("click." + this.widgetName, function (b) {
                if (!0 === d.data(b.target, a.widgetName + ".preventClickEvent")) {
                    d.removeData(b.target, a.widgetName + ".preventClickEvent"), b.stopImmediatePropagation();
                    return !1
                }
            }), this.started = !1
        },
        _mouseDestroy: function () {
            this.element.unbind("." + this.widgetName)
        },
        _mouseDown: function (a) {
            if (!f) {
                this._mouseStarted && this._mouseUp(a), this._mouseDownEvent = a;
                var c = this,
                    g = a.which == 1,
                    h = typeof this.options.cancel == "string" && a.target.nodeName ? d(a.target).closest(this.options.cancel).length : !1;
                if (!g || h || !this._mouseCapture(a)) {
                    return !0
                }
                this.mouseDelayMet = !this.options.delay, this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function () {
                    c.mouseDelayMet = !0
                }, this.options.delay));
                if (this._mouseDistanceMet(a) && this._mouseDelayMet(a)) {
                    this._mouseStarted = this._mouseStart(a) !== !1;
                    if (!this._mouseStarted) {
                        a.preventDefault();
                        return !0
                    }
                }!0 === d.data(a.target, this.widgetName + ".preventClickEvent") && d.removeData(a.target, this.widgetName + ".preventClickEvent"), this._mouseMoveDelegate = function (b) {
                    return c._mouseMove(b)
                }, this._mouseUpDelegate = function (b) {
                    return c._mouseUp(b)
                }, d(document).bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate), a.preventDefault(), f = !0;
                return !0
            }
        },
        _mouseMove: function (a) {
            if (d.browser.msie && !(document.documentMode >= 9) && !a.button) {
                return this._mouseUp(a)
            }
            if (this._mouseStarted) {
                this._mouseDrag(a);
                return a.preventDefault()
            }
            this._mouseDistanceMet(a) && this._mouseDelayMet(a) && (this._mouseStarted = this._mouseStart(this._mouseDownEvent, a) !== !1, this._mouseStarted ? this._mouseDrag(a) : this._mouseUp(a));
            return !this._mouseStarted
        },
        _mouseUp: function (a) {
            d(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate), this._mouseStarted && (this._mouseStarted = !1, a.target == this._mouseDownEvent.target && d.data(a.target, this.widgetName + ".preventClickEvent", !0), this._mouseStop(a));
            return !1
        },
        _mouseDistanceMet: function (b) {
            return Math.max(Math.abs(this._mouseDownEvent.pageX - b.pageX), Math.abs(this._mouseDownEvent.pageY - b.pageY)) >= this.options.distance
        },
        _mouseDelayMet: function (b) {
            return this.mouseDelayMet
        },
        _mouseStart: function (b) {},
        _mouseDrag: function (b) {},
        _mouseStop: function (b) {},
        _mouseCapture: function (b) {
            return !0
        }
    })
})(jQuery);
(function (j, k) {
    j.ui = j.ui || {};
    var l = /left|center|right/,
        m = /top|center|bottom/,
        n = "center",
        o = {}, p = j.fn.position,
        q = j.fn.offset;
    j.fn.position = function (a) {
        if (!a || !a.of) {
            return p.apply(this, arguments)
        }
        a = j.extend({}, a);
        var c = j(a.of),
            d = c[0],
            e = (a.collision || "flip").split(" "),
            f = a.offset ? a.offset.split(" ") : [0, 0],
            g, r, s;
        d.nodeType === 9 ? (g = c.width(), r = c.height(), s = {
            top: 0,
            left: 0
        }) : d.setTimeout ? (g = c.width(), r = c.height(), s = {
            top: c.scrollTop(),
            left: c.scrollLeft()
        }) : d.preventDefault ? (a.at = "left top", g = r = 0, s = {
            top: a.of.pageY,
            left: a.of.pageX
        }) : (g = c.outerWidth(), r = c.outerHeight(), s = c.offset()), j.each(["my", "at"], function () {
            var b = (a[this] || "").split(" ");
            b.length === 1 && (b = l.test(b[0]) ? b.concat([n]) : m.test(b[0]) ? [n].concat(b) : [n, n]), b[0] = l.test(b[0]) ? b[0] : n, b[1] = m.test(b[1]) ? b[1] : n, a[this] = b
        }), e.length === 1 && (e[1] = e[0]), f[0] = parseInt(f[0], 10) || 0, f.length === 1 && (f[1] = f[0]), f[1] = parseInt(f[1], 10) || 0, a.at[0] === "right" ? s.left += g : a.at[0] === n && (s.left += g / 2), a.at[1] === "bottom" ? s.top += r : a.at[1] === n && (s.top += r / 2), s.left += f[0], s.top += f[1];
        return this.each(function () {
            var b = j(this),
                t = b.outerWidth(),
                u = b.outerHeight(),
                v = parseInt(j.curCSS(this, "marginLeft", !0)) || 0,
                w = parseInt(j.curCSS(this, "marginTop", !0)) || 0,
                x = t + v + (parseInt(j.curCSS(this, "marginRight", !0)) || 0),
                y = u + w + (parseInt(j.curCSS(this, "marginBottom", !0)) || 0),
                z = j.extend({}, s),
                A;
            a.my[0] === "right" ? z.left -= t : a.my[0] === n && (z.left -= t / 2), a.my[1] === "bottom" ? z.top -= u : a.my[1] === n && (z.top -= u / 2), o.fractions || (z.left = Math.round(z.left), z.top = Math.round(z.top)), A = {
                left: z.left - v,
                top: z.top - w
            }, j.each(["left", "top"], function (h, B) {
                j.ui.position[e[h]] && j.ui.position[e[h]][B](z, {
                    targetWidth: g,
                    targetHeight: r,
                    elemWidth: t,
                    elemHeight: u,
                    collisionPosition: A,
                    collisionWidth: x,
                    collisionHeight: y,
                    offset: f,
                    my: a.my,
                    at: a.at
                })
            }), j.fn.bgiframe && b.bgiframe(), b.offset(j.extend(z, {
                using: a.using
            }))
        })
    }, j.ui.position = {
        fit: {
            left: function (a, f) {
                var g = j(window),
                    h = f.collisionPosition.left + f.collisionWidth - g.width() - g.scrollLeft();
                a.left = h > 0 ? a.left - h : Math.max(a.left - f.collisionPosition.left, a.left)
            },
            top: function (a, f) {
                var g = j(window),
                    h = f.collisionPosition.top + f.collisionHeight - g.height() - g.scrollTop();
                a.top = h > 0 ? a.top - h : Math.max(a.top - f.collisionPosition.top, a.top)
            }
        },
        flip: {
            left: function (a, e) {
                if (e.at[0] !== n) {
                    var r = j(window),
                        s = e.collisionPosition.left + e.collisionWidth - r.width() - r.scrollLeft(),
                        t = e.my[0] === "left" ? -e.elemWidth : e.my[0] === "right" ? e.elemWidth : 0,
                        u = e.at[0] === "left" ? e.targetWidth : -e.targetWidth,
                        v = -2 * e.offset[0];
                    a.left += e.collisionPosition.left < 0 ? t + u + v..."+g.options.totalTime,g.controlsRootDomNode),muteBtn:a("."+g.options.muteBtn,g.controlsRootDomNode),volumeBar:a("."+g.options.volumeBar,g.controlsRootDomNode),fullscreenBtn:a("."+g.options.fullscreenBtn,g.controlsRootDomNode),bigPlayBtn:a("."+g.options.bigPlayBtn,g.rootDomNode),bigPauseBtn:a("."+g.options.bigPauseBtn,g.rootDomNode),closeBtn:a("."+g.options.closeBtn,g.rootDomNode),loaderContainer:a("."+g.options.loaderContainer,g.rootDomNode),playBtnContainer:a("."+g.options.playBtn+" - container ",g.controlsRootDomNode),seekBarContainer:a("."+g.options.seekBar+" - container ",g.controlsRootDomNode),timesContainer:a("."+g.options.currentTime+" - container ",g.controlsRootDomNode),volumeContainer:a("."+g.options.muteBtn+" - container ",g.controlsRootDomNode),fullscreenBtnContainer:a("."+g.options.fullscreenBtn+" - container ",g.controlsRootDomNode)}},resetPlayer:function(g){g.rootDomNode.removeClass(g.options.stateClasses.paused).removeClass(g.options.stateClasses.playing).removeClass(g.options.stateClasses.muted);if(g.options.bigPlayBtnVisible){g.controlDoms.bigPlayBtn.show()}if(g.options.bigPauseBtnVisible){g.controlDoms.bigPauseBtn.hide()}d.utils.resizeControls(g);g.videoDomNode.jPlayer("
                    destroy ");d.utils.initializeJPlayer(g);g.controlDoms.seekBar.slider("
                    value ",0);g.controlDoms.volumeBar.slider("
                    value ",g.options.jPlayer.volume*100);g.state={muted:false,seeking:false,volumeSeeking:false,volume:g.options.jPlayer.volume*100}},getSizeComponents:function(g){return{margin:d.utils.getMargins(g),padding:d.utils.getPaddings(g),width:a(g).width(),height:a(g).height()}},getMargins:function(g){g=a(g);return{top:parseInt(g.css("
                    margin - top ")),bottom:parseInt(g.css("
                    margin - bottom ")),left:parseInt(g.css("
                    margin - left ")),right:parseInt(g.css("
                    margin - right "))}},getPaddings:function(g){g=a(g);return{top:parseInt(g.css("
                    padding - top ")),bottom:parseInt(g.css("
                    padding - bottom ")),left:parseInt(g.css("
                    padding - left ")),right:parseInt(g.css("
                    padding - right "))}},hasSpiffyPlayer:function(g){return typeof a(g).data(b)!==typeof f},getAPI:function(g){if(!d.utils.hasSpiffyPlayer(g)){throw"
                    The node does not contain a YouVideo controller "}else{return a(g).data(b).api}},isString:function(h){try{if(h.charAt){return true}}catch(g){}return false},sumSizes:function(h,g){var j={width:0,height:0};if(typeof g===typeof f){g=false}a(h).each(function(){j.width+=a(this).outerWidth(g);j.height+=a(this).outerHeight(g)});return j},secondsToStr:function(k){var g=d.utils.addLeadingZero(Math.floor(k/3600)),h=d.utils.addLeadingZero(Math.floor(k/60)),j=d.utils.addLeadingZero(Math.floor(k%60));return(g!=="
                    00 ")?g+" : "+h+": "+j:h+": "+j},addLeadingZero:function(g){if(g<10){return"
                    0 "+g}return"
                    "+g},getPixelValueAsNum:function(g){return parseInt(g+"
                    ".replace(/[^0-9]/g,"
                    "))}}};a.fn.SpiffyPlayer=function(g){var j={},h;if((typeof g!==typeof f)&&d.utils.isString(g)){if(g==="
                    api "){if(d.utils.hasSpiffyPlayer(this)){return d.utils.getAPI(this)}}else{if(g==="
                    hasPlayer "){return d.utils.hasSpiffyPlayer(this)}}return this}if(d.utils.hasSpiffyPlayer(this)){return this}a.extend(true,j,c,g);return this.each(function(){var k;if(d.utils.hasSpiffyPlayer(this)){return true}k={jPlayer:null,size:{width:d.utils.getPixelValueAsNum(j.jPlayer.size.width),height:d.utils.getPixelValueAsNum(j.jPlayer.size.height)},options:j,jPlayerOptions:j.jPlayer,rootDomNode:a(this),videoDomNode:null,controlsRootDomNode:null,controlDoms:{},api:null,internalData:{ignoreNextPausedEvent:false,flashUsed:false,hasFlashLoaded:false,preLoadTimeUpdates:0,endTimer:null},state:{muted:false,seeking:false,volumeSeeking:false,volume:j.jPlayer.volume*100,looping:j.loop,hasLoaded:false}};k.rootDomNode.data(b,k);d.utils.renderDomNodes(k);d.utils.getControlDoms(k);d.utils.initializeSliders(k);d.utils.resizeControls(k);d.utils.makeApi(k);d.utils.initializeJPlayer(k);d.utils.bindEvents(k);k.internalData.flashUsed=k.api.jPlayer().flash.used;k.internalData.hasFlashLoaded=!k.internalData.flashUsed;if(j.onSetupComplete!==null){j.onSetupComplete.call(k.api)}})}})(jQuery);(function(a){a.fn.hoverIntent=function(j,k){var b={sensitivity:7,interval:100,timeout:0};b=a.extend(b,k?{over:j,out:k}:j);var d,e,m,n;var o=function(f){d=f.pageX;e=f.pageY};var c=function(f,g){g.hoverIntent_t=clearTimeout(g.hoverIntent_t);if((Math.abs(m-d)+Math.abs(n-e))<b.sensitivity){a(g).unbind("
                    mousemove ",o);g.hoverIntent_s=1;return b.over.apply(g,[f])}else{m=d;n=e;g.hoverIntent_t=setTimeout(function(){c(f,g)},b.interval)}};var h=function(f,g){g.hoverIntent_t=clearTimeout(g.hoverIntent_t);g.hoverIntent_s=0;return b.out.apply(g,[f])};var l=function(f){var g=jQuery.extend({},f);var p=this;if(p.hoverIntent_t){p.hoverIntent_t=clearTimeout(p.hoverIntent_t)}if(f.type=="
                    mouseenter "){m=g.pageX;n=g.pageY;a(p).bind("
                    mousemove ",o);if(p.hoverIntent_s!=1){p.hoverIntent_t=setTimeout(function(){c(g,p)},b.interval)}}else{a(p).unbind("
                    mousemove ",o);if(p.hoverIntent_s==1){p.hoverIntent_t=setTimeout(function(){h(g,p)},b.timeout)}}};return this.bind("
                    mouseenter ",l).bind("
                    mouseleave ",l)}})(jQuery);