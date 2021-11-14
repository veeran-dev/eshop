//plugin.js
/*!
 * jQuery UI 1.9.2
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI
 */
(function(e, t) {
    function i(t, i) {
        var r, n, s, o = t.nodeName.toLowerCase();
        return "area" === o ? (r = t.parentNode, n = r.name, t.href && n && "map" === r.nodeName.toLowerCase() ? (s = e("img[usemap=#" + n + "]")[0], !!s && a(s)) : !1) : (/input|select|textarea|button|object/.test(o) ? !t.disabled : "a" === o ? t.href || i : i) && a(t)
    }

    function a(t) {
        return e.expr.filters.visible(t) && !e(t).parents().andSelf().filter(function() {
            return "hidden" === e.css(this, "visibility")
        }).length
    }
    var r = 0,
        n = /^ui-id-\d+$/;
    e.ui = e.ui || {}, e.ui.version || (e.extend(e.ui, {
        version: "1.9.2",
        keyCode: {
            BACKSPACE: 8,
            COMMA: 188,
            DELETE: 46,
            DOWN: 40,
            END: 35,
            ENTER: 13,
            ESCAPE: 27,
            HOME: 36,
            LEFT: 37,
            NUMPAD_ADD: 107,
            NUMPAD_DECIMAL: 110,
            NUMPAD_DIVIDE: 111,
            NUMPAD_ENTER: 108,
            NUMPAD_MULTIPLY: 106,
            NUMPAD_SUBTRACT: 109,
            PAGE_DOWN: 34,
            PAGE_UP: 33,
            PERIOD: 190,
            RIGHT: 39,
            SPACE: 32,
            TAB: 9,
            UP: 38
        }
    }), e.fn.extend({
        _focus: e.fn.focus,
        focus: function(t, i) {
            return "number" == typeof t ? this.each(function() {
                var a = this;
                setTimeout(function() {
                    e(a).focus(), i && i.call(a)
                }, t)
            }) : this._focus.apply(this, arguments)
        },
        scrollParent: function() {
            var t;
            return t = e.ui.ie && /(static|relative)/.test(this.css("position")) || /absolute/.test(this.css("position")) ? this.parents().filter(function() {
                return /(relative|absolute|fixed)/.test(e.css(this, "position")) && /(auto|scroll)/.test(e.css(this, "overflow") + e.css(this, "overflow-y") + e.css(this, "overflow-x"))
            }).eq(0) : this.parents().filter(function() {
                return /(auto|scroll)/.test(e.css(this, "overflow") + e.css(this, "overflow-y") + e.css(this, "overflow-x"))
            }).eq(0), /fixed/.test(this.css("position")) || !t.length ? e(document) : t
        },
        zIndex: function(i) {
            if (i !== t) return this.css("zIndex", i);
            if (this.length)
                for (var a, r, n = e(this[0]); n.length && n[0] !== document;) {
                    if (a = n.css("position"), ("absolute" === a || "relative" === a || "fixed" === a) && (r = parseInt(n.css("zIndex"), 10), !isNaN(r) && 0 !== r)) return r;
                    n = n.parent()
                }
            return 0
        },
        uniqueId: function() {
            return this.each(function() {
                this.id || (this.id = "ui-id-" + ++r)
            })
        },
        removeUniqueId: function() {
            return this.each(function() {
                n.test(this.id) && e(this).removeAttr("id")
            })
        }
    }), e.extend(e.expr[":"], {
        data: e.expr.createPseudo ? e.expr.createPseudo(function(t) {
            return function(i) {
                return !!e.data(i, t)
            }
        }) : function(t, i, a) {
            return !!e.data(t, a[3])
        },
        focusable: function(t) {
            return i(t, !isNaN(e.attr(t, "tabindex")))
        },
        tabbable: function(t) {
            var a = e.attr(t, "tabindex"),
                r = isNaN(a);
            return (r || a >= 0) && i(t, !r)
        }
    }), e(function() {
        var t = document.body,
            i = t.appendChild(i = document.createElement("div"));
        i.offsetHeight, e.extend(i.style, {
            minHeight: "100px",
            height: "auto",
            padding: 0,
            borderWidth: 0
        }), e.support.minHeight = 100 === i.offsetHeight, e.support.selectstart = "onselectstart" in i, t.removeChild(i).style.display = "none"
    }), e("<a>").outerWidth(1).jquery || e.each(["Width", "Height"], function(i, a) {
        function r(t, i, a, r) {
            return e.each(n, function() {
                i -= parseFloat(e.css(t, "padding" + this)) || 0, a && (i -= parseFloat(e.css(t, "border" + this + "Width")) || 0), r && (i -= parseFloat(e.css(t, "margin" + this)) || 0)
            }), i
        }
        var n = "Width" === a ? ["Left", "Right"] : ["Top", "Bottom"],
            s = a.toLowerCase(),
            o = {
                innerWidth: e.fn.innerWidth,
                innerHeight: e.fn.innerHeight,
                outerWidth: e.fn.outerWidth,
                outerHeight: e.fn.outerHeight
            };
        e.fn["inner" + a] = function(i) {
            return i === t ? o["inner" + a].call(this) : this.each(function() {
                e(this).css(s, r(this, i) + "px")
            })
        }, e.fn["outer" + a] = function(t, i) {
            return "number" != typeof t ? o["outer" + a].call(this, t) : this.each(function() {
                e(this).css(s, r(this, t, !0, i) + "px")
            })
        }
    }), e("<a>").data("a-b", "a").removeData("a-b").data("a-b") && (e.fn.removeData = function(t) {
        return function(i) {
            return arguments.length ? t.call(this, e.camelCase(i)) : t.call(this)
        }
    }(e.fn.removeData)), function() {
        var t = /msie ([\w.]+)/.exec(navigator.userAgent.toLowerCase()) || [];
        e.ui.ie = t.length ? !0 : !1, e.ui.ie6 = 6 === parseFloat(t[1], 10)
    }(), e.fn.extend({
        disableSelection: function() {
            return this.bind((e.support.selectstart ? "selectstart" : "mousedown") + ".ui-disableSelection", function(e) {
                e.preventDefault()
            })
        },
        enableSelection: function() {
            return this.unbind(".ui-disableSelection")
        }
    }), e.extend(e.ui, {
        plugin: {
            add: function(t, i, a) {
                var r, n = e.ui[t].prototype;
                for (r in a) n.plugins[r] = n.plugins[r] || [], n.plugins[r].push([i, a[r]])
            },
            call: function(e, t, i) {
                var a, r = e.plugins[t];
                if (r && e.element[0].parentNode && 11 !== e.element[0].parentNode.nodeType)
                    for (a = 0; r.length > a; a++) e.options[r[a][0]] && r[a][1].apply(e.element, i)
            }
        },
        contains: e.contains,
        hasScroll: function(t, i) {
            if ("hidden" === e(t).css("overflow")) return !1;
            var a = i && "left" === i ? "scrollLeft" : "scrollTop",
                r = !1;
            return t[a] > 0 ? !0 : (t[a] = 1, r = t[a] > 0, t[a] = 0, r)
        },
        isOverAxis: function(e, t, i) {
            return e > t && t + i > e
        },
        isOver: function(t, i, a, r, n, s) {
            return e.ui.isOverAxis(t, a, n) && e.ui.isOverAxis(i, r, s)
        }
    }))
})(jQuery);
(function(e, t) {
    var i = 0,
        a = Array.prototype.slice,
        s = e.cleanData;
    e.cleanData = function(t) {
        for (var i, a = 0; null != (i = t[a]); a++) try {
            e(i).triggerHandler("remove")
        } catch (n) {}
        s(t)
    }, e.widget = function(i, a, s) {
        var n, r, o, h, l = i.split(".")[0];
        i = i.split(".")[1], n = l + "-" + i, s || (s = a, a = e.Widget), e.expr[":"][n.toLowerCase()] = function(t) {
            return !!e.data(t, n)
        }, e[l] = e[l] || {}, r = e[l][i], o = e[l][i] = function(e, i) {
            return this._createWidget ? (arguments.length && this._createWidget(e, i), t) : new o(e, i)
        }, e.extend(o, r, {
            version: s.version,
            _proto: e.extend({}, s),
            _childConstructors: []
        }), h = new a, h.options = e.widget.extend({}, h.options), e.each(s, function(t, i) {
            e.isFunction(i) && (s[t] = function() {
                var e = function() {
                        return a.prototype[t].apply(this, arguments)
                    },
                    s = function(e) {
                        return a.prototype[t].apply(this, e)
                    };
                return function() {
                    var t, a = this._super,
                        n = this._superApply;
                    return this._super = e, this._superApply = s, t = i.apply(this, arguments), this._super = a, this._superApply = n, t
                }
            }())
        }), o.prototype = e.widget.extend(h, {
            widgetEventPrefix: r ? h.widgetEventPrefix : i
        }, s, {
            constructor: o,
            namespace: l,
            widgetName: i,
            widgetBaseClass: n,
            widgetFullName: n
        }), r ? (e.each(r._childConstructors, function(t, i) {
            var a = i.prototype;
            e.widget(a.namespace + "." + a.widgetName, o, i._proto)
        }), delete r._childConstructors) : a._childConstructors.push(o), e.widget.bridge(i, o)
    }, e.widget.extend = function(i) {
        for (var s, n, r = a.call(arguments, 1), o = 0, h = r.length; h > o; o++)
            for (s in r[o]) n = r[o][s], r[o].hasOwnProperty(s) && n !== t && (i[s] = e.isPlainObject(n) ? e.isPlainObject(i[s]) ? e.widget.extend({}, i[s], n) : e.widget.extend({}, n) : n);
        return i
    }, e.widget.bridge = function(i, s) {
        var n = s.prototype.widgetFullName || i;
        e.fn[i] = function(r) {
            var o = "string" == typeof r,
                h = a.call(arguments, 1),
                l = this;
            return r = !o && h.length ? e.widget.extend.apply(null, [r].concat(h)) : r, o ? this.each(function() {
                var a, s = e.data(this, n);
                return s ? e.isFunction(s[r]) && "_" !== r.charAt(0) ? (a = s[r].apply(s, h), a !== s && a !== t ? (l = a && a.jquery ? l.pushStack(a.get()) : a, !1) : t) : e.error("no such method '" + r + "' for " + i + " widget instance") : e.error("cannot call methods on " + i + " prior to initialization; " + "attempted to call method '" + r + "'")
            }) : this.each(function() {
                var t = e.data(this, n);
                t ? t.option(r || {})._init() : e.data(this, n, new s(r, this))
            }), l
        }
    }, e.Widget = function() {}, e.Widget._childConstructors = [], e.Widget.prototype = {
        widgetName: "widget",
        widgetEventPrefix: "",
        defaultElement: "<div>",
        options: {
            disabled: !1,
            create: null
        },
        _createWidget: function(t, a) {
            a = e(a || this.defaultElement || this)[0], this.element = e(a), this.uuid = i++, this.eventNamespace = "." + this.widgetName + this.uuid, this.options = e.widget.extend({}, this.options, this._getCreateOptions(), t), this.bindings = e(), this.hoverable = e(), this.focusable = e(), a !== this && (e.data(a, this.widgetName, this), e.data(a, this.widgetFullName, this), this._on(!0, this.element, {
                remove: function(e) {
                    e.target === a && this.destroy()
                }
            }), this.document = e(a.style ? a.ownerDocument : a.document || a), this.window = e(this.document[0].defaultView || this.document[0].parentWindow)), this._create(), this._trigger("create", null, this._getCreateEventData()), this._init()
        },
        _getCreateOptions: e.noop,
        _getCreateEventData: e.noop,
        _create: e.noop,
        _init: e.noop,
        destroy: function() {
            this._destroy(), this.element.unbind(this.eventNamespace).removeData(this.widgetName).removeData(this.widgetFullName).removeData(e.camelCase(this.widgetFullName)), this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName + "-disabled " + "ui-state-disabled"), this.bindings.unbind(this.eventNamespace), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus")
        },
        _destroy: e.noop,
        widget: function() {
            return this.element
        },
        option: function(i, a) {
            var s, n, r, o = i;
            if (0 === arguments.length) return e.widget.extend({}, this.options);
            if ("string" == typeof i)
                if (o = {}, s = i.split("."), i = s.shift(), s.length) {
                    for (n = o[i] = e.widget.extend({}, this.options[i]), r = 0; s.length - 1 > r; r++) n[s[r]] = n[s[r]] || {}, n = n[s[r]];
                    if (i = s.pop(), a === t) return n[i] === t ? null : n[i];
                    n[i] = a
                } else {
                    if (a === t) return this.options[i] === t ? null : this.options[i];
                    o[i] = a
                }
            return this._setOptions(o), this
        },
        _setOptions: function(e) {
            var t;
            for (t in e) this._setOption(t, e[t]);
            return this
        },
        _setOption: function(e, t) {
            return this.options[e] = t, "disabled" === e && (this.widget().toggleClass(this.widgetFullName + "-disabled ui-state-disabled", !!t).attr("aria-disabled", t), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus")), this
        },
        enable: function() {
            return this._setOption("disabled", !1)
        },
        disable: function() {
            return this._setOption("disabled", !0)
        },
        _on: function(i, a, s) {
            var n, r = this;
            "boolean" != typeof i && (s = a, a = i, i = !1), s ? (a = n = e(a), this.bindings = this.bindings.add(a)) : (s = a, a = this.element, n = this.widget()), e.each(s, function(s, o) {
                function h() {
                    return i || r.options.disabled !== !0 && !e(this).hasClass("ui-state-disabled") ? ("string" == typeof o ? r[o] : o).apply(r, arguments) : t
                }
                "string" != typeof o && (h.guid = o.guid = o.guid || h.guid || e.guid++);
                var l = s.match(/^(\w+)\s*(.*)$/),
                    u = l[1] + r.eventNamespace,
                    d = l[2];
                d ? n.delegate(d, u, h) : a.bind(u, h)
            })
        },
        _off: function(e, t) {
            t = (t || "").split(" ").join(this.eventNamespace + " ") + this.eventNamespace, e.unbind(t).undelegate(t)
        },
        _delay: function(e, t) {
            function i() {
                return ("string" == typeof e ? a[e] : e).apply(a, arguments)
            }
            var a = this;
            return setTimeout(i, t || 0)
        },
        _hoverable: function(t) {
            this.hoverable = this.hoverable.add(t), this._on(t, {
                mouseenter: function(t) {
                    e(t.currentTarget).addClass("ui-state-hover")
                },
                mouseleave: function(t) {
                    e(t.currentTarget).removeClass("ui-state-hover")
                }
            })
        },
        _focusable: function(t) {
            this.focusable = this.focusable.add(t), this._on(t, {
                focusin: function(t) {
                    e(t.currentTarget).addClass("ui-state-focus")
                },
                focusout: function(t) {
                    e(t.currentTarget).removeClass("ui-state-focus")
                }
            })
        },
        _trigger: function(t, i, a) {
            var s, n, r = this.options[t];
            if (a = a || {}, i = e.Event(i), i.type = (t === this.widgetEventPrefix ? t : this.widgetEventPrefix + t).toLowerCase(), i.target = this.element[0], n = i.originalEvent)
                for (s in n) s in i || (i[s] = n[s]);
            return this.element.trigger(i, a), !(e.isFunction(r) && r.apply(this.element[0], [i].concat(a)) === !1 || i.isDefaultPrevented())
        }
    }, e.each({
        show: "fadeIn",
        hide: "fadeOut"
    }, function(t, i) {
        e.Widget.prototype["_" + t] = function(a, s, n) {
            "string" == typeof s && (s = {
                effect: s
            });
            var r, o = s ? s === !0 || "number" == typeof s ? i : s.effect || i : t;
            s = s || {}, "number" == typeof s && (s = {
                duration: s
            }), r = !e.isEmptyObject(s), s.complete = n, s.delay && a.delay(s.delay), r && e.effects && (e.effects.effect[o] || e.uiBackCompat !== !1 && e.effects[o]) ? a[t](s) : o !== t && a[o] ? a[o](s.duration, s.easing, n) : a.queue(function(i) {
                e(this)[t](), n && n.call(a[0]), i()
            })
        }
    }), e.uiBackCompat !== !1 && (e.Widget.prototype._getCreateOptions = function() {
        return e.metadata && e.metadata.get(this.element[0])[this.widgetName]
    })
})(jQuery);
(function(e) {
    var t = !1;
    e(document).mouseup(function() {
        t = !1
    }), e.widget("ui.mouse", {
        version: "1.9.2",
        options: {
            cancel: "input,textarea,button,select,option",
            distance: 1,
            delay: 0
        },
        _mouseInit: function() {
            var t = this;
            this.element.bind("mousedown." + this.widgetName, function(e) {
                return t._mouseDown(e)
            }).bind("click." + this.widgetName, function(i) {
                return !0 === e.data(i.target, t.widgetName + ".preventClickEvent") ? (e.removeData(i.target, t.widgetName + ".preventClickEvent"), i.stopImmediatePropagation(), !1) : undefined
            }), this.started = !1
        },
        _mouseDestroy: function() {
            this.element.unbind("." + this.widgetName), this._mouseMoveDelegate && e(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate)
        },
        _mouseDown: function(i) {
            if (!t) {
                this._mouseStarted && this._mouseUp(i), this._mouseDownEvent = i;
                var a = this,
                    s = 1 === i.which,
                    n = "string" == typeof this.options.cancel && i.target.nodeName ? e(i.target).closest(this.options.cancel).length : !1;
                return s && !n && this._mouseCapture(i) ? (this.mouseDelayMet = !this.options.delay, this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function() {
                    a.mouseDelayMet = !0
                }, this.options.delay)), this._mouseDistanceMet(i) && this._mouseDelayMet(i) && (this._mouseStarted = this._mouseStart(i) !== !1, !this._mouseStarted) ? (i.preventDefault(), !0) : (!0 === e.data(i.target, this.widgetName + ".preventClickEvent") && e.removeData(i.target, this.widgetName + ".preventClickEvent"), this._mouseMoveDelegate = function(e) {
                    return a._mouseMove(e)
                }, this._mouseUpDelegate = function(e) {
                    return a._mouseUp(e)
                }, e(document).bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate), i.preventDefault(), t = !0, !0)) : !0
            }
        },
        _mouseMove: function(t) {
            return !e.ui.ie || document.documentMode >= 9 || t.button ? this._mouseStarted ? (this._mouseDrag(t), t.preventDefault()) : (this._mouseDistanceMet(t) && this._mouseDelayMet(t) && (this._mouseStarted = this._mouseStart(this._mouseDownEvent, t) !== !1, this._mouseStarted ? this._mouseDrag(t) : this._mouseUp(t)), !this._mouseStarted) : this._mouseUp(t)
        },
        _mouseUp: function(t) {
            return e(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate), this._mouseStarted && (this._mouseStarted = !1, t.target === this._mouseDownEvent.target && e.data(t.target, this.widgetName + ".preventClickEvent", !0), this._mouseStop(t)), !1
        },
        _mouseDistanceMet: function(e) {
            return Math.max(Math.abs(this._mouseDownEvent.pageX - e.pageX), Math.abs(this._mouseDownEvent.pageY - e.pageY)) >= this.options.distance
        },
        _mouseDelayMet: function() {
            return this.mouseDelayMet
        },
        _mouseStart: function() {},
        _mouseDrag: function() {},
        _mouseStop: function() {},
        _mouseCapture: function() {
            return !0
        }
    })
})(jQuery);
(function(e, t) {
    function i(e, t, i) {
        return [parseInt(e[0], 10) * (c.test(e[0]) ? t / 100 : 1), parseInt(e[1], 10) * (c.test(e[1]) ? i / 100 : 1)]
    }

    function a(t, i) {
        return parseInt(e.css(t, i), 10) || 0
    }
    e.ui = e.ui || {};
    var n, s = Math.max,
        r = Math.abs,
        o = Math.round,
        l = /left|center|right/,
        u = /top|center|bottom/,
        h = /[\+\-]\d+%?/,
        d = /^\w+/,
        c = /%$/,
        p = e.fn.position;
    e.position = {
            scrollbarWidth: function() {
                if (n !== t) return n;
                var i, a, s = e("<div style='display:block;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>"),
                    r = s.children()[0];
                return e("body").append(s), i = r.offsetWidth, s.css("overflow", "scroll"), a = r.offsetWidth, i === a && (a = s[0].clientWidth), s.remove(), n = i - a
            },
            getScrollInfo: function(t) {
                var i = t.isWindow ? "" : t.element.css("overflow-x"),
                    a = t.isWindow ? "" : t.element.css("overflow-y"),
                    n = "scroll" === i || "auto" === i && t.width < t.element[0].scrollWidth,
                    s = "scroll" === a || "auto" === a && t.height < t.element[0].scrollHeight;
                return {
                    width: n ? e.position.scrollbarWidth() : 0,
                    height: s ? e.position.scrollbarWidth() : 0
                }
            },
            getWithinInfo: function(t) {
                var i = e(t || window),
                    a = e.isWindow(i[0]);
                return {
                    element: i,
                    isWindow: a,
                    offset: i.offset() || {
                        left: 0,
                        top: 0
                    },
                    scrollLeft: i.scrollLeft(),
                    scrollTop: i.scrollTop(),
                    width: a ? i.width() : i.outerWidth(),
                    height: a ? i.height() : i.outerHeight()
                }
            }
        }, e.fn.position = function(t) {
            if (!t || !t.of) return p.apply(this, arguments);
            t = e.extend({}, t);
            var n, c, m, f, g, y = e(t.of),
                v = e.position.getWithinInfo(t.within),
                b = e.position.getScrollInfo(v),
                x = y[0],
                _ = (t.collision || "flip").split(" "),
                k = {};
            return 9 === x.nodeType ? (c = y.width(), m = y.height(), f = {
                top: 0,
                left: 0
            }) : e.isWindow(x) ? (c = y.width(), m = y.height(), f = {
                top: y.scrollTop(),
                left: y.scrollLeft()
            }) : x.preventDefault ? (t.at = "left top", c = m = 0, f = {
                top: x.pageY,
                left: x.pageX
            }) : (c = y.outerWidth(), m = y.outerHeight(), f = y.offset()), g = e.extend({}, f), e.each(["my", "at"], function() {
                var e, i, a = (t[this] || "").split(" ");
                1 === a.length && (a = l.test(a[0]) ? a.concat(["center"]) : u.test(a[0]) ? ["center"].concat(a) : ["center", "center"]), a[0] = l.test(a[0]) ? a[0] : "center", a[1] = u.test(a[1]) ? a[1] : "center", e = h.exec(a[0]), i = h.exec(a[1]), k[this] = [e ? e[0] : 0, i ? i[0] : 0], t[this] = [d.exec(a[0])[0], d.exec(a[1])[0]]
            }), 1 === _.length && (_[1] = _[0]), "right" === t.at[0] ? g.left += c : "center" === t.at[0] && (g.left += c / 2), "bottom" === t.at[1] ? g.top += m : "center" === t.at[1] && (g.top += m / 2), n = i(k.at, c, m), g.left += n[0], g.top += n[1], this.each(function() {
                var l, u, h = e(this),
                    d = h.outerWidth(),
                    p = h.outerHeight(),
                    x = a(this, "marginLeft"),
                    D = a(this, "marginTop"),
                    T = d + x + a(this, "marginRight") + b.width,
                    w = p + D + a(this, "marginBottom") + b.height,
                    M = e.extend({}, g),
                    S = i(k.my, h.outerWidth(), h.outerHeight());
                "right" === t.my[0] ? M.left -= d : "center" === t.my[0] && (M.left -= d / 2), "bottom" === t.my[1] ? M.top -= p : "center" === t.my[1] && (M.top -= p / 2), M.left += S[0], M.top += S[1], e.support.offsetFractions || (M.left = o(M.left), M.top = o(M.top)), l = {
                    marginLeft: x,
                    marginTop: D
                }, e.each(["left", "top"], function(i, a) {
                    e.ui.position[_[i]] && e.ui.position[_[i]][a](M, {
                        targetWidth: c,
                        targetHeight: m,
                        elemWidth: d,
                        elemHeight: p,
                        collisionPosition: l,
                        collisionWidth: T,
                        collisionHeight: w,
                        offset: [n[0] + S[0], n[1] + S[1]],
                        my: t.my,
                        at: t.at,
                        within: v,
                        elem: h
                    })
                }), e.fn.bgiframe && h.bgiframe(), t.using && (u = function(e) {
                    var i = f.left - M.left,
                        a = i + c - d,
                        n = f.top - M.top,
                        o = n + m - p,
                        l = {
                            target: {
                                element: y,
                                left: f.left,
                                top: f.top,
                                width: c,
                                height: m
                            },
                            element: {
                                element: h,
                                left: M.left,
                                top: M.top,
                                width: d,
                                height: p
                            },
                            horizontal: 0 > a ? "left" : i > 0 ? "right" : "center",
                            vertical: 0 > o ? "top" : n > 0 ? "bottom" : "middle"
                        };
                    d > c && c > r(i + a) && (l.horizontal = "center"), p > m && m > r(n + o) && (l.vertical = "middle"), l.important = s(r(i), r(a)) > s(r(n), r(o)) ? "horizontal" : "vertical", t.using.call(this, e, l)
                }), h.offset(e.extend(M, {
                    using: u
                }))
            })
        }, e.ui.position = {
            fit: {
                left: function(e, t) {
                    var i, a = t.within,
                        n = a.isWindow ? a.scrollLeft : a.offset.left,
                        r = a.width,
                        o = e.left - t.collisionPosition.marginLeft,
                        l = n - o,
                        u = o + t.collisionWidth - r - n;
                    t.collisionWidth > r ? l > 0 && 0 >= u ? (i = e.left + l + t.collisionWidth - r - n, e.left += l - i) : e.left = u > 0 && 0 >= l ? n : l > u ? n + r - t.collisionWidth : n : l > 0 ? e.left += l : u > 0 ? e.left -= u : e.left = s(e.left - o, e.left)
                },
                top: function(e, t) {
                    var i, a = t.within,
                        n = a.isWindow ? a.scrollTop : a.offset.top,
                        r = t.within.height,
                        o = e.top - t.collisionPosition.marginTop,
                        l = n - o,
                        u = o + t.collisionHeight - r - n;
                    t.collisionHeight > r ? l > 0 && 0 >= u ? (i = e.top + l + t.collisionHeight - r - n, e.top += l - i) : e.top = u > 0 && 0 >= l ? n : l > u ? n + r - t.collisionHeight : n : l > 0 ? e.top += l : u > 0 ? e.top -= u : e.top = s(e.top - o, e.top)
                }
            },
            flip: {
                left: function(e, t) {
                    var i, a, n = t.within,
                        s = n.offset.left + n.scrollLeft,
                        o = n.width,
                        l = n.isWindow ? n.scrollLeft : n.offset.left,
                        u = e.left - t.collisionPosition.marginLeft,
                        h = u - l,
                        d = u + t.collisionWidth - o - l,
                        c = "left" === t.my[0] ? -t.elemWidth : "right" === t.my[0] ? t.elemWidth : 0,
                        p = "left" === t.at[0] ? t.targetWidth : "right" === t.at[0] ? -t.targetWidth : 0,
                        m = -2 * t.offset[0];
                    0 > h ? (i = e.left + c + p + m + t.collisionWidth - o - s, (0 > i || r(h) > i) && (e.left += c + p + m)) : d > 0 && (a = e.left - t.collisionPosition.marginLeft + c + p + m - l, (a > 0 || d > r(a)) && (e.left += c + p + m))
                },
                top: function(e, t) {
                    var i, a, n = t.within,
                        s = n.offset.top + n.scrollTop,
                        o = n.height,
                        l = n.isWindow ? n.scrollTop : n.offset.top,
                        u = e.top - t.collisionPosition.marginTop,
                        h = u - l,
                        d = u + t.collisionHeight - o - l,
                        c = "top" === t.my[1],
                        p = c ? -t.elemHeight : "bottom" === t.my[1] ? t.elemHeight : 0,
                        m = "top" === t.at[1] ? t.targetHeight : "bottom" === t.at[1] ? -t.targetHeight : 0,
                        f = -2 * t.offset[1];
                    0 > h ? (a = e.top + p + m + f + t.collisionHeight - o - s, e.top + p + m + f > h && (0 > a || r(h) > a) && (e.top += p + m + f)) : d > 0 && (i = e.top - t.collisionPosition.marginTop + p + m + f - l, e.top + p + m + f > d && (i > 0 || d > r(i)) && (e.top += p + m + f))
                }
            },
            flipfit: {
                left: function() {
                    e.ui.position.flip.left.apply(this, arguments), e.ui.position.fit.left.apply(this, arguments)
                },
                top: function() {
                    e.ui.position.flip.top.apply(this, arguments), e.ui.position.fit.top.apply(this, arguments)
                }
            }
        },
        function() {
            var t, i, a, n, s, r = document.getElementsByTagName("body")[0],
                o = document.createElement("div");
            t = document.createElement(r ? "div" : "body"), a = {
                visibility: "hidden",
                width: 0,
                height: 0,
                border: 0,
                margin: 0,
                background: "none"
            }, r && e.extend(a, {
                position: "absolute",
                left: "-1000px",
                top: "-1000px"
            });
            for (s in a) t.style[s] = a[s];
            t.appendChild(o), i = r || document.documentElement, i.insertBefore(t, i.firstChild), o.style.cssText = "position: absolute; left: 10.7432222px;", n = e(o).offset().left, e.support.offsetFractions = n > 10 && 11 > n, t.innerHTML = "", i.removeChild(t)
        }(), e.uiBackCompat !== !1 && function(e) {
            var i = e.fn.position;
            e.fn.position = function(a) {
                if (!a || !a.offset) return i.call(this, a);
                var n = a.offset.split(" "),
                    s = a.at.split(" ");
                return 1 === n.length && (n[1] = n[0]), /^\d/.test(n[0]) && (n[0] = "+" + n[0]), /^\d/.test(n[1]) && (n[1] = "+" + n[1]), 1 === s.length && (/left|center|right/.test(s[0]) ? s[1] = "center" : (s[1] = s[0], s[0] = "center")), i.call(this, e.extend(a, {
                    at: s[0] + n[0] + " " + s[1] + n[1],
                    offset: t
                }))
            }
        }(jQuery)
})(jQuery);
(function(e) {
    e.widget("ui.draggable", e.ui.mouse, {
        version: "1.9.2",
        widgetEventPrefix: "drag",
        options: {
            addClasses: !0,
            appendTo: "parent",
            axis: !1,
            connectToSortable: !1,
            containment: !1,
            cursor: "auto",
            cursorAt: !1,
            grid: !1,
            handle: !1,
            helper: "original",
            iframeFix: !1,
            opacity: !1,
            refreshPositions: !1,
            revert: !1,
            revertDuration: 500,
            scope: "default",
            scroll: !0,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            snap: !1,
            snapMode: "both",
            snapTolerance: 20,
            stack: !1,
            zIndex: !1
        },
        _create: function() {
            "original" != this.options.helper || /^(?:r|a|f)/.test(this.element.css("position")) || (this.element[0].style.position = "relative"), this.options.addClasses && this.element.addClass("ui-draggable"), this.options.disabled && this.element.addClass("ui-draggable-disabled"), this._mouseInit()
        },
        _destroy: function() {
            this.element.removeClass("ui-draggable ui-draggable-dragging ui-draggable-disabled"), this._mouseDestroy()
        },
        _mouseCapture: function(t) {
            var i = this.options;
            return this.helper || i.disabled || e(t.target).is(".ui-resizable-handle") ? !1 : (this.handle = this._getHandle(t), this.handle ? (e(i.iframeFix === !0 ? "iframe" : i.iframeFix).each(function() {
                e('<div class="ui-draggable-iframeFix" style="background: #fff;"></div>').css({
                    width: this.offsetWidth + "px",
                    height: this.offsetHeight + "px",
                    position: "absolute",
                    opacity: "0.001",
                    zIndex: 1e3
                }).css(e(this).offset()).appendTo("body")
            }), !0) : !1)
        },
        _mouseStart: function(t) {
            var i = this.options;
            return this.helper = this._createHelper(t), this.helper.addClass("ui-draggable-dragging"), this._cacheHelperProportions(), e.ui.ddmanager && (e.ui.ddmanager.current = this), this._cacheMargins(), this.cssPosition = this.helper.css("position"), this.scrollParent = this.helper.scrollParent(), this.offset = this.positionAbs = this.element.offset(), this.offset = {
                top: this.offset.top - this.margins.top,
                left: this.offset.left - this.margins.left
            }, e.extend(this.offset, {
                click: {
                    left: t.pageX - this.offset.left,
                    top: t.pageY - this.offset.top
                },
                parent: this._getParentOffset(),
                relative: this._getRelativeOffset()
            }), this.originalPosition = this.position = this._generatePosition(t), this.originalPageX = t.pageX, this.originalPageY = t.pageY, i.cursorAt && this._adjustOffsetFromHelper(i.cursorAt), i.containment && this._setContainment(), this._trigger("start", t) === !1 ? (this._clear(), !1) : (this._cacheHelperProportions(), e.ui.ddmanager && !i.dropBehaviour && e.ui.ddmanager.prepareOffsets(this, t), this._mouseDrag(t, !0), e.ui.ddmanager && e.ui.ddmanager.dragStart(this, t), !0)
        },
        _mouseDrag: function(t, i) {
            if (this.position = this._generatePosition(t), this.positionAbs = this._convertPositionTo("absolute"), !i) {
                var a = this._uiHash();
                if (this._trigger("drag", t, a) === !1) return this._mouseUp({}), !1;
                this.position = a.position
            }
            return this.options.axis && "y" == this.options.axis || (this.helper[0].style.left = this.position.left + "px"), this.options.axis && "x" == this.options.axis || (this.helper[0].style.top = this.position.top + "px"), e.ui.ddmanager && e.ui.ddmanager.drag(this, t), !1
        },
        _mouseStop: function(t) {
            var i = !1;
            e.ui.ddmanager && !this.options.dropBehaviour && (i = e.ui.ddmanager.drop(this, t)), this.dropped && (i = this.dropped, this.dropped = !1);
            for (var a = this.element[0], n = !1; a && (a = a.parentNode);) a == document && (n = !0);
            if (!n && "original" === this.options.helper) return !1;
            if ("invalid" == this.options.revert && !i || "valid" == this.options.revert && i || this.options.revert === !0 || e.isFunction(this.options.revert) && this.options.revert.call(this.element, i)) {
                var s = this;
                e(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10), function() {
                    s._trigger("stop", t) !== !1 && s._clear()
                })
            } else this._trigger("stop", t) !== !1 && this._clear();
            return !1
        },
        _mouseUp: function(t) {
            return e("div.ui-draggable-iframeFix").each(function() {
                this.parentNode.removeChild(this)
            }), e.ui.ddmanager && e.ui.ddmanager.dragStop(this, t), e.ui.mouse.prototype._mouseUp.call(this, t)
        },
        cancel: function() {
            return this.helper.is(".ui-draggable-dragging") ? this._mouseUp({}) : this._clear(), this
        },
        _getHandle: function(t) {
            var i = this.options.handle && e(this.options.handle, this.element).length ? !1 : !0;
            return e(this.options.handle, this.element).find("*").andSelf().each(function() {
                this == t.target && (i = !0)
            }), i
        },
        _createHelper: function(t) {
            var i = this.options,
                a = e.isFunction(i.helper) ? e(i.helper.apply(this.element[0], [t])) : "clone" == i.helper ? this.element.clone().removeAttr("id") : this.element;
            return a.parents("body").length || a.appendTo("parent" == i.appendTo ? this.element[0].parentNode : i.appendTo), a[0] == this.element[0] || /(fixed|absolute)/.test(a.css("position")) || a.css("position", "absolute"), a
        },
        _adjustOffsetFromHelper: function(t) {
            "string" == typeof t && (t = t.split(" ")), e.isArray(t) && (t = {
                left: +t[0],
                top: +t[1] || 0
            }), "left" in t && (this.offset.click.left = t.left + this.margins.left), "right" in t && (this.offset.click.left = this.helperProportions.width - t.right + this.margins.left), "top" in t && (this.offset.click.top = t.top + this.margins.top), "bottom" in t && (this.offset.click.top = this.helperProportions.height - t.bottom + this.margins.top)
        },
        _getParentOffset: function() {
            this.offsetParent = this.helper.offsetParent();
            var t = this.offsetParent.offset();
            return "absolute" == this.cssPosition && this.scrollParent[0] != document && e.contains(this.scrollParent[0], this.offsetParent[0]) && (t.left += this.scrollParent.scrollLeft(), t.top += this.scrollParent.scrollTop()), (this.offsetParent[0] == document.body || this.offsetParent[0].tagName && "html" == this.offsetParent[0].tagName.toLowerCase() && e.ui.ie) && (t = {
                top: 0,
                left: 0
            }), {
                top: t.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: t.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            }
        },
        _getRelativeOffset: function() {
            if ("relative" == this.cssPosition) {
                var e = this.element.position();
                return {
                    top: e.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                    left: e.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                }
            }
            return {
                top: 0,
                left: 0
            }
        },
        _cacheMargins: function() {
            this.margins = {
                left: parseInt(this.element.css("marginLeft"), 10) || 0,
                top: parseInt(this.element.css("marginTop"), 10) || 0,
                right: parseInt(this.element.css("marginRight"), 10) || 0,
                bottom: parseInt(this.element.css("marginBottom"), 10) || 0
            }
        },
        _cacheHelperProportions: function() {
            this.helperProportions = {
                width: this.helper.outerWidth(),
                height: this.helper.outerHeight()
            }
        },
        _setContainment: function() {
            var t = this.options;
            if ("parent" == t.containment && (t.containment = this.helper[0].parentNode), ("document" == t.containment || "window" == t.containment) && (this.containment = ["document" == t.containment ? 0 : e(window).scrollLeft() - this.offset.relative.left - this.offset.parent.left, "document" == t.containment ? 0 : e(window).scrollTop() - this.offset.relative.top - this.offset.parent.top, ("document" == t.containment ? 0 : e(window).scrollLeft()) + e("document" == t.containment ? document : window).width() - this.helperProportions.width - this.margins.left, ("document" == t.containment ? 0 : e(window).scrollTop()) + (e("document" == t.containment ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]), /^(document|window|parent)$/.test(t.containment) || t.containment.constructor == Array) t.containment.constructor == Array && (this.containment = t.containment);
            else {
                var i = e(t.containment),
                    a = i[0];
                if (!a) return;
                i.offset();
                var n = "hidden" != e(a).css("overflow");
                this.containment = [(parseInt(e(a).css("borderLeftWidth"), 10) || 0) + (parseInt(e(a).css("paddingLeft"), 10) || 0), (parseInt(e(a).css("borderTopWidth"), 10) || 0) + (parseInt(e(a).css("paddingTop"), 10) || 0), (n ? Math.max(a.scrollWidth, a.offsetWidth) : a.offsetWidth) - (parseInt(e(a).css("borderLeftWidth"), 10) || 0) - (parseInt(e(a).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left - this.margins.right, (n ? Math.max(a.scrollHeight, a.offsetHeight) : a.offsetHeight) - (parseInt(e(a).css("borderTopWidth"), 10) || 0) - (parseInt(e(a).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top - this.margins.bottom], this.relative_container = i
            }
        },
        _convertPositionTo: function(t, i) {
            i || (i = this.position);
            var a = "absolute" == t ? 1 : -1,
                n = (this.options, "absolute" != this.cssPosition || this.scrollParent[0] != document && e.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent),
                s = /(html|body)/i.test(n[0].tagName);
            return {
                top: i.top + this.offset.relative.top * a + this.offset.parent.top * a - ("fixed" == this.cssPosition ? -this.scrollParent.scrollTop() : s ? 0 : n.scrollTop()) * a,
                left: i.left + this.offset.relative.left * a + this.offset.parent.left * a - ("fixed" == this.cssPosition ? -this.scrollParent.scrollLeft() : s ? 0 : n.scrollLeft()) * a
            }
        },
        _generatePosition: function(t) {
            var i = this.options,
                a = "absolute" != this.cssPosition || this.scrollParent[0] != document && e.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent,
                n = /(html|body)/i.test(a[0].tagName),
                s = t.pageX,
                r = t.pageY;
            if (this.originalPosition) {
                var o;
                if (this.containment) {
                    if (this.relative_container) {
                        var l = this.relative_container.offset();
                        o = [this.containment[0] + l.left, this.containment[1] + l.top, this.containment[2] + l.left, this.containment[3] + l.top]
                    } else o = this.containment;
                    t.pageX - this.offset.click.left < o[0] && (s = o[0] + this.offset.click.left), t.pageY - this.offset.click.top < o[1] && (r = o[1] + this.offset.click.top), t.pageX - this.offset.click.left > o[2] && (s = o[2] + this.offset.click.left), t.pageY - this.offset.click.top > o[3] && (r = o[3] + this.offset.click.top)
                }
                if (i.grid) {
                    var d = i.grid[1] ? this.originalPageY + Math.round((r - this.originalPageY) / i.grid[1]) * i.grid[1] : this.originalPageY;
                    r = o ? d - this.offset.click.top < o[1] || d - this.offset.click.top > o[3] ? d - this.offset.click.top < o[1] ? d + i.grid[1] : d - i.grid[1] : d : d;
                    var u = i.grid[0] ? this.originalPageX + Math.round((s - this.originalPageX) / i.grid[0]) * i.grid[0] : this.originalPageX;
                    s = o ? u - this.offset.click.left < o[0] || u - this.offset.click.left > o[2] ? u - this.offset.click.left < o[0] ? u + i.grid[0] : u - i.grid[0] : u : u
                }
            }
            return {
                top: r - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" == this.cssPosition ? -this.scrollParent.scrollTop() : n ? 0 : a.scrollTop()),
                left: s - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" == this.cssPosition ? -this.scrollParent.scrollLeft() : n ? 0 : a.scrollLeft())
            }
        },
        _clear: function() {
            this.helper.removeClass("ui-draggable-dragging"), this.helper[0] == this.element[0] || this.cancelHelperRemoval || this.helper.remove(), this.helper = null, this.cancelHelperRemoval = !1
        },
        _trigger: function(t, i, a) {
            return a = a || this._uiHash(), e.ui.plugin.call(this, t, [i, a]), "drag" == t && (this.positionAbs = this._convertPositionTo("absolute")), e.Widget.prototype._trigger.call(this, t, i, a)
        },
        plugins: {},
        _uiHash: function() {
            return {
                helper: this.helper,
                position: this.position,
                originalPosition: this.originalPosition,
                offset: this.positionAbs
            }
        }
    }), e.ui.plugin.add("draggable", "connectToSortable", {
        start: function(t, i) {
            var a = e(this).data("draggable"),
                n = a.options,
                s = e.extend({}, i, {
                    item: a.element
                });
            a.sortables = [], e(n.connectToSortable).each(function() {
                var i = e.data(this, "sortable");
                i && !i.options.disabled && (a.sortables.push({
                    instance: i,
                    shouldRevert: i.options.revert
                }), i.refreshPositions(), i._trigger("activate", t, s))
            })
        },
        stop: function(t, i) {
            var a = e(this).data("draggable"),
                n = e.extend({}, i, {
                    item: a.element
                });
            e.each(a.sortables, function() {
                this.instance.isOver ? (this.instance.isOver = 0, a.cancelHelperRemoval = !0, this.instance.cancelHelperRemoval = !1, this.shouldRevert && (this.instance.options.revert = !0), this.instance._mouseStop(t), this.instance.options.helper = this.instance.options._helper, "original" == a.options.helper && this.instance.currentItem.css({
                    top: "auto",
                    left: "auto"
                })) : (this.instance.cancelHelperRemoval = !1, this.instance._trigger("deactivate", t, n))
            })
        },
        drag: function(t, i) {
            var a = e(this).data("draggable"),
                n = this;
            e.each(a.sortables, function() {
                var s = !1,
                    r = this;
                this.instance.positionAbs = a.positionAbs, this.instance.helperProportions = a.helperProportions, this.instance.offset.click = a.offset.click, this.instance._intersectsWith(this.instance.containerCache) && (s = !0, e.each(a.sortables, function() {
                    return this.instance.positionAbs = a.positionAbs, this.instance.helperProportions = a.helperProportions, this.instance.offset.click = a.offset.click, this != r && this.instance._intersectsWith(this.instance.containerCache) && e.ui.contains(r.instance.element[0], this.instance.element[0]) && (s = !1), s
                })), s ? (this.instance.isOver || (this.instance.isOver = 1, this.instance.currentItem = e(n).clone().removeAttr("id").appendTo(this.instance.element).data("sortable-item", !0), this.instance.options._helper = this.instance.options.helper, this.instance.options.helper = function() {
                    return i.helper[0]
                }, t.target = this.instance.currentItem[0], this.instance._mouseCapture(t, !0), this.instance._mouseStart(t, !0, !0), this.instance.offset.click.top = a.offset.click.top, this.instance.offset.click.left = a.offset.click.left, this.instance.offset.parent.left -= a.offset.parent.left - this.instance.offset.parent.left, this.instance.offset.parent.top -= a.offset.parent.top - this.instance.offset.parent.top, a._trigger("toSortable", t), a.dropped = this.instance.element, a.currentItem = a.element, this.instance.fromOutside = a), this.instance.currentItem && this.instance._mouseDrag(t)) : this.instance.isOver && (this.instance.isOver = 0, this.instance.cancelHelperRemoval = !0, this.instance.options.revert = !1, this.instance._trigger("out", t, this.instance._uiHash(this.instance)), this.instance._mouseStop(t, !0), this.instance.options.helper = this.instance.options._helper, this.instance.currentItem.remove(), this.instance.placeholder && this.instance.placeholder.remove(), a._trigger("fromSortable", t), a.dropped = !1)
            })
        }
    }), e.ui.plugin.add("draggable", "cursor", {
        start: function() {
            var t = e("body"),
                i = e(this).data("draggable").options;
            t.css("cursor") && (i._cursor = t.css("cursor")), t.css("cursor", i.cursor)
        },
        stop: function() {
            var t = e(this).data("draggable").options;
            t._cursor && e("body").css("cursor", t._cursor)
        }
    }), e.ui.plugin.add("draggable", "opacity", {
        start: function(t, i) {
            var a = e(i.helper),
                n = e(this).data("draggable").options;
            a.css("opacity") && (n._opacity = a.css("opacity")), a.css("opacity", n.opacity)
        },
        stop: function(t, i) {
            var a = e(this).data("draggable").options;
            a._opacity && e(i.helper).css("opacity", a._opacity)
        }
    }), e.ui.plugin.add("draggable", "scroll", {
        start: function() {
            var t = e(this).data("draggable");
            t.scrollParent[0] != document && "HTML" != t.scrollParent[0].tagName && (t.overflowOffset = t.scrollParent.offset())
        },
        drag: function(t) {
            var i = e(this).data("draggable"),
                a = i.options,
                n = !1;
            i.scrollParent[0] != document && "HTML" != i.scrollParent[0].tagName ? (a.axis && "x" == a.axis || (i.overflowOffset.top + i.scrollParent[0].offsetHeight - t.pageY < a.scrollSensitivity ? i.scrollParent[0].scrollTop = n = i.scrollParent[0].scrollTop + a.scrollSpeed : t.pageY - i.overflowOffset.top < a.scrollSensitivity && (i.scrollParent[0].scrollTop = n = i.scrollParent[0].scrollTop - a.scrollSpeed)), a.axis && "y" == a.axis || (i.overflowOffset.left + i.scrollParent[0].offsetWidth - t.pageX < a.scrollSensitivity ? i.scrollParent[0].scrollLeft = n = i.scrollParent[0].scrollLeft + a.scrollSpeed : t.pageX - i.overflowOffset.left < a.scrollSensitivity && (i.scrollParent[0].scrollLeft = n = i.scrollParent[0].scrollLeft - a.scrollSpeed))) : (a.axis && "x" == a.axis || (t.pageY - e(document).scrollTop() < a.scrollSensitivity ? n = e(document).scrollTop(e(document).scrollTop() - a.scrollSpeed) : e(window).height() - (t.pageY - e(document).scrollTop()) < a.scrollSensitivity && (n = e(document).scrollTop(e(document).scrollTop() + a.scrollSpeed))), a.axis && "y" == a.axis || (t.pageX - e(document).scrollLeft() < a.scrollSensitivity ? n = e(document).scrollLeft(e(document).scrollLeft() - a.scrollSpeed) : e(window).width() - (t.pageX - e(document).scrollLeft()) < a.scrollSensitivity && (n = e(document).scrollLeft(e(document).scrollLeft() + a.scrollSpeed)))), n !== !1 && e.ui.ddmanager && !a.dropBehaviour && e.ui.ddmanager.prepareOffsets(i, t)
        }
    }), e.ui.plugin.add("draggable", "snap", {
        start: function() {
            var t = e(this).data("draggable"),
                i = t.options;
            t.snapElements = [], e(i.snap.constructor != String ? i.snap.items || ":data(draggable)" : i.snap).each(function() {
                var i = e(this),
                    a = i.offset();
                this != t.element[0] && t.snapElements.push({
                    item: this,
                    width: i.outerWidth(),
                    height: i.outerHeight(),
                    top: a.top,
                    left: a.left
                })
            })
        },
        drag: function(t, i) {
            for (var a = e(this).data("draggable"), n = a.options, s = n.snapTolerance, r = i.offset.left, o = r + a.helperProportions.width, l = i.offset.top, d = l + a.helperProportions.height, u = a.snapElements.length - 1; u >= 0; u--) {
                var h = a.snapElements[u].left,
                    c = h + a.snapElements[u].width,
                    p = a.snapElements[u].top,
                    m = p + a.snapElements[u].height;
                if (r > h - s && c + s > r && l > p - s && m + s > l || r > h - s && c + s > r && d > p - s && m + s > d || o > h - s && c + s > o && l > p - s && m + s > l || o > h - s && c + s > o && d > p - s && m + s > d) {
                    if ("inner" != n.snapMode) {
                        var f = s >= Math.abs(p - d),
                            g = s >= Math.abs(m - l),
                            y = s >= Math.abs(h - o),
                            v = s >= Math.abs(c - r);
                        f && (i.position.top = a._convertPositionTo("relative", {
                            top: p - a.helperProportions.height,
                            left: 0
                        }).top - a.margins.top), g && (i.position.top = a._convertPositionTo("relative", {
                            top: m,
                            left: 0
                        }).top - a.margins.top), y && (i.position.left = a._convertPositionTo("relative", {
                            top: 0,
                            left: h - a.helperProportions.width
                        }).left - a.margins.left), v && (i.position.left = a._convertPositionTo("relative", {
                            top: 0,
                            left: c
                        }).left - a.margins.left)
                    }
                    var b = f || g || y || v;
                    if ("outer" != n.snapMode) {
                        var f = s >= Math.abs(p - l),
                            g = s >= Math.abs(m - d),
                            y = s >= Math.abs(h - r),
                            v = s >= Math.abs(c - o);
                        f && (i.position.top = a._convertPositionTo("relative", {
                            top: p,
                            left: 0
                        }).top - a.margins.top), g && (i.position.top = a._convertPositionTo("relative", {
                            top: m - a.helperProportions.height,
                            left: 0
                        }).top - a.margins.top), y && (i.position.left = a._convertPositionTo("relative", {
                            top: 0,
                            left: h
                        }).left - a.margins.left), v && (i.position.left = a._convertPositionTo("relative", {
                            top: 0,
                            left: c - a.helperProportions.width
                        }).left - a.margins.left)
                    }!a.snapElements[u].snapping && (f || g || y || v || b) && a.options.snap.snap && a.options.snap.snap.call(a.element, t, e.extend(a._uiHash(), {
                        snapItem: a.snapElements[u].item
                    })), a.snapElements[u].snapping = f || g || y || v || b
                } else a.snapElements[u].snapping && a.options.snap.release && a.options.snap.release.call(a.element, t, e.extend(a._uiHash(), {
                    snapItem: a.snapElements[u].item
                })), a.snapElements[u].snapping = !1
            }
        }
    }), e.ui.plugin.add("draggable", "stack", {
        start: function() {
            var t = e(this).data("draggable").options,
                i = e.makeArray(e(t.stack)).sort(function(t, i) {
                    return (parseInt(e(t).css("zIndex"), 10) || 0) - (parseInt(e(i).css("zIndex"), 10) || 0)
                });
            if (i.length) {
                var a = parseInt(i[0].style.zIndex) || 0;
                e(i).each(function(e) {
                    this.style.zIndex = a + e
                }), this[0].style.zIndex = a + i.length
            }
        }
    }), e.ui.plugin.add("draggable", "zIndex", {
        start: function(t, i) {
            var a = e(i.helper),
                n = e(this).data("draggable").options;
            a.css("zIndex") && (n._zIndex = a.css("zIndex")), a.css("zIndex", n.zIndex)
        },
        stop: function(t, i) {
            var a = e(this).data("draggable").options;
            a._zIndex && e(i.helper).css("zIndex", a._zIndex)
        }
    })
})(jQuery);
(function(e) {
    e.widget("ui.droppable", {
        version: "1.9.2",
        widgetEventPrefix: "drop",
        options: {
            accept: "*",
            activeClass: !1,
            addClasses: !0,
            greedy: !1,
            hoverClass: !1,
            scope: "default",
            tolerance: "intersect"
        },
        _create: function() {
            var t = this.options,
                i = t.accept;
            this.isover = 0, this.isout = 1, this.accept = e.isFunction(i) ? i : function(e) {
                return e.is(i)
            }, this.proportions = {
                width: this.element[0].offsetWidth,
                height: this.element[0].offsetHeight
            }, e.ui.ddmanager.droppables[t.scope] = e.ui.ddmanager.droppables[t.scope] || [], e.ui.ddmanager.droppables[t.scope].push(this), t.addClasses && this.element.addClass("ui-droppable")
        },
        _destroy: function() {
            for (var t = e.ui.ddmanager.droppables[this.options.scope], i = 0; t.length > i; i++) t[i] == this && t.splice(i, 1);
            this.element.removeClass("ui-droppable ui-droppable-disabled")
        },
        _setOption: function(t, i) {
            "accept" == t && (this.accept = e.isFunction(i) ? i : function(e) {
                return e.is(i)
            }), e.Widget.prototype._setOption.apply(this, arguments)
        },
        _activate: function(t) {
            var i = e.ui.ddmanager.current;
            this.options.activeClass && this.element.addClass(this.options.activeClass), i && this._trigger("activate", t, this.ui(i))
        },
        _deactivate: function(t) {
            var i = e.ui.ddmanager.current;
            this.options.activeClass && this.element.removeClass(this.options.activeClass), i && this._trigger("deactivate", t, this.ui(i))
        },
        _over: function(t) {
            var i = e.ui.ddmanager.current;
            i && (i.currentItem || i.element)[0] != this.element[0] && this.accept.call(this.element[0], i.currentItem || i.element) && (this.options.hoverClass && this.element.addClass(this.options.hoverClass), this._trigger("over", t, this.ui(i)))
        },
        _out: function(t) {
            var i = e.ui.ddmanager.current;
            i && (i.currentItem || i.element)[0] != this.element[0] && this.accept.call(this.element[0], i.currentItem || i.element) && (this.options.hoverClass && this.element.removeClass(this.options.hoverClass), this._trigger("out", t, this.ui(i)))
        },
        _drop: function(t, i) {
            var a = i || e.ui.ddmanager.current;
            if (!a || (a.currentItem || a.element)[0] == this.element[0]) return !1;
            var s = !1;
            return this.element.find(":data(droppable)").not(".ui-draggable-dragging").each(function() {
                var t = e.data(this, "droppable");
                return t.options.greedy && !t.options.disabled && t.options.scope == a.options.scope && t.accept.call(t.element[0], a.currentItem || a.element) && e.ui.intersect(a, e.extend(t, {
                    offset: t.element.offset()
                }), t.options.tolerance) ? (s = !0, !1) : undefined
            }), s ? !1 : this.accept.call(this.element[0], a.currentItem || a.element) ? (this.options.activeClass && this.element.removeClass(this.options.activeClass), this.options.hoverClass && this.element.removeClass(this.options.hoverClass), this._trigger("drop", t, this.ui(a)), this.element) : !1
        },
        ui: function(e) {
            return {
                draggable: e.currentItem || e.element,
                helper: e.helper,
                position: e.position,
                offset: e.positionAbs
            }
        }
    }), e.ui.intersect = function(t, i, a) {
        if (!i.offset) return !1;
        var s = (t.positionAbs || t.position.absolute).left,
            n = s + t.helperProportions.width,
            r = (t.positionAbs || t.position.absolute).top,
            o = r + t.helperProportions.height,
            l = i.offset.left,
            d = l + i.proportions.width,
            u = i.offset.top,
            h = u + i.proportions.height;
        switch (a) {
            case "fit":
                return s >= l && d >= n && r >= u && h >= o;
            case "intersect":
                return s + t.helperProportions.width / 2 > l && d > n - t.helperProportions.width / 2 && r + t.helperProportions.height / 2 > u && h > o - t.helperProportions.height / 2;
            case "pointer":
                var c = (t.positionAbs || t.position.absolute).left + (t.clickOffset || t.offset.click).left,
                    p = (t.positionAbs || t.position.absolute).top + (t.clickOffset || t.offset.click).top,
                    m = e.ui.isOver(p, c, u, l, i.proportions.height, i.proportions.width);
                return m;
            case "touch":
                return (r >= u && h >= r || o >= u && h >= o || u > r && o > h) && (s >= l && d >= s || n >= l && d >= n || l > s && n > d);
            default:
                return !1
        }
    }, e.ui.ddmanager = {
        current: null,
        droppables: {
            "default": []
        },
        prepareOffsets: function(t, i) {
            var a = e.ui.ddmanager.droppables[t.options.scope] || [],
                s = i ? i.type : null,
                n = (t.currentItem || t.element).find(":data(droppable)").andSelf();
            e: for (var r = 0; a.length > r; r++)
                if (!(a[r].options.disabled || t && !a[r].accept.call(a[r].element[0], t.currentItem || t.element))) {
                    for (var o = 0; n.length > o; o++)
                        if (n[o] == a[r].element[0]) {
                            a[r].proportions.height = 0;
                            continue e
                        }
                    a[r].visible = "none" != a[r].element.css("display"), a[r].visible && ("mousedown" == s && a[r]._activate.call(a[r], i), a[r].offset = a[r].element.offset(), a[r].proportions = {
                        width: a[r].element[0].offsetWidth,
                        height: a[r].element[0].offsetHeight
                    })
                }
        },
        drop: function(t, i) {
            var a = !1;
            return e.each(e.ui.ddmanager.droppables[t.options.scope] || [], function() {
                this.options && (!this.options.disabled && this.visible && e.ui.intersect(t, this, this.options.tolerance) && (a = this._drop.call(this, i) || a), !this.options.disabled && this.visible && this.accept.call(this.element[0], t.currentItem || t.element) && (this.isout = 1, this.isover = 0, this._deactivate.call(this, i)))
            }), a
        },
        dragStart: function(t, i) {
            t.element.parentsUntil("body").bind("scroll.droppable", function() {
                t.options.refreshPositions || e.ui.ddmanager.prepareOffsets(t, i)
            })
        },
        drag: function(t, i) {
            t.options.refreshPositions && e.ui.ddmanager.prepareOffsets(t, i), e.each(e.ui.ddmanager.droppables[t.options.scope] || [], function() {
                if (!this.options.disabled && !this.greedyChild && this.visible) {
                    var a = e.ui.intersect(t, this, this.options.tolerance),
                        s = a || 1 != this.isover ? a && 0 == this.isover ? "isover" : null : "isout";
                    if (s) {
                        var n;
                        if (this.options.greedy) {
                            var r = this.options.scope,
                                o = this.element.parents(":data(droppable)").filter(function() {
                                    return e.data(this, "droppable").options.scope === r
                                });
                            o.length && (n = e.data(o[0], "droppable"), n.greedyChild = "isover" == s ? 1 : 0)
                        }
                        n && "isover" == s && (n.isover = 0, n.isout = 1, n._out.call(n, i)), this[s] = 1, this["isout" == s ? "isover" : "isout"] = 0, this["isover" == s ? "_over" : "_out"].call(this, i), n && "isout" == s && (n.isout = 0, n.isover = 1, n._over.call(n, i))
                    }
                }
            })
        },
        dragStop: function(t, i) {
            t.element.parentsUntil("body").unbind("scroll.droppable"), t.options.refreshPositions || e.ui.ddmanager.prepareOffsets(t, i)
        }
    }
})(jQuery);
(function(e) {
    e.widget("ui.resizable", e.ui.mouse, {
        version: "1.9.2",
        widgetEventPrefix: "resize",
        options: {
            alsoResize: !1,
            animate: !1,
            animateDuration: "slow",
            animateEasing: "swing",
            aspectRatio: !1,
            autoHide: !1,
            containment: !1,
            ghost: !1,
            grid: !1,
            handles: "e,s,se",
            helper: !1,
            maxHeight: null,
            maxWidth: null,
            minHeight: 10,
            minWidth: 10,
            zIndex: 1e3
        },
        _create: function() {
            var t = this,
                i = this.options;
            if (this.element.addClass("ui-resizable"), e.extend(this, {
                    _aspectRatio: !!i.aspectRatio,
                    aspectRatio: i.aspectRatio,
                    originalElement: this.element,
                    _proportionallyResizeElements: [],
                    _helper: i.helper || i.ghost || i.animate ? i.helper || "ui-resizable-helper" : null
                }), this.element[0].nodeName.match(/canvas|textarea|input|select|button|img/i) && (this.element.wrap(e('<div class="ui-wrapper" style="overflow: hidden;"></div>').css({
                    position: this.element.css("position"),
                    width: this.element.outerWidth(),
                    height: this.element.outerHeight(),
                    top: this.element.css("top"),
                    left: this.element.css("left")
                })), this.element = this.element.parent().data("resizable", this.element.data("resizable")), this.elementIsWrapper = !0, this.element.css({
                    marginLeft: this.originalElement.css("marginLeft"),
                    marginTop: this.originalElement.css("marginTop"),
                    marginRight: this.originalElement.css("marginRight"),
                    marginBottom: this.originalElement.css("marginBottom")
                }), this.originalElement.css({
                    marginLeft: 0,
                    marginTop: 0,
                    marginRight: 0,
                    marginBottom: 0
                }), this.originalResizeStyle = this.originalElement.css("resize"), this.originalElement.css("resize", "none"), this._proportionallyResizeElements.push(this.originalElement.css({
                    position: "static",
                    zoom: 1,
                    display: "block"
                })), this.originalElement.css({
                    margin: this.originalElement.css("margin")
                }), this._proportionallyResize()), this.handles = i.handles || (e(".ui-resizable-handle", this.element).length ? {
                    n: ".ui-resizable-n",
                    e: ".ui-resizable-e",
                    s: ".ui-resizable-s",
                    w: ".ui-resizable-w",
                    se: ".ui-resizable-se",
                    sw: ".ui-resizable-sw",
                    ne: ".ui-resizable-ne",
                    nw: ".ui-resizable-nw"
                } : "e,s,se"), this.handles.constructor == String) {
                "all" == this.handles && (this.handles = "n,e,s,w,se,sw,ne,nw");
                var a = this.handles.split(",");
                this.handles = {};
                for (var s = 0; a.length > s; s++) {
                    var n = e.trim(a[s]),
                        r = "ui-resizable-" + n,
                        o = e('<div class="ui-resizable-handle ' + r + '"></div>');
                    o.css({
                        zIndex: i.zIndex
                    }), "se" == n && o.addClass("ui-icon ui-icon-gripsmall-diagonal-se"), this.handles[n] = ".ui-resizable-" + n, this.element.append(o)
                }
            }
            this._renderAxis = function(t) {
                t = t || this.element;
                for (var i in this.handles) {
                    if (this.handles[i].constructor == String && (this.handles[i] = e(this.handles[i], this.element).show()), this.elementIsWrapper && this.originalElement[0].nodeName.match(/textarea|input|select|button/i)) {
                        var a = e(this.handles[i], this.element),
                            s = 0;
                        s = /sw|ne|nw|se|n|s/.test(i) ? a.outerHeight() : a.outerWidth();
                        var n = ["padding", /ne|nw|n/.test(i) ? "Top" : /se|sw|s/.test(i) ? "Bottom" : /^e$/.test(i) ? "Right" : "Left"].join("");
                        t.css(n, s), this._proportionallyResize()
                    }
                    e(this.handles[i]).length
                }
            }, this._renderAxis(this.element), this._handles = e(".ui-resizable-handle", this.element).disableSelection(), this._handles.mouseover(function() {
                if (!t.resizing) {
                    if (this.className) var e = this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i);
                    t.axis = e && e[1] ? e[1] : "se"
                }
            }), i.autoHide && (this._handles.hide(), e(this.element).addClass("ui-resizable-autohide").mouseenter(function() {
                i.disabled || (e(this).removeClass("ui-resizable-autohide"), t._handles.show())
            }).mouseleave(function() {
                i.disabled || t.resizing || (e(this).addClass("ui-resizable-autohide"), t._handles.hide())
            })), this._mouseInit()
        },
        _destroy: function() {
            this._mouseDestroy();
            var t = function(t) {
                e(t).removeClass("ui-resizable ui-resizable-disabled ui-resizable-resizing").removeData("resizable").removeData("ui-resizable").unbind(".resizable").find(".ui-resizable-handle").remove()
            };
            if (this.elementIsWrapper) {
                t(this.element);
                var i = this.element;
                this.originalElement.css({
                    position: i.css("position"),
                    width: i.outerWidth(),
                    height: i.outerHeight(),
                    top: i.css("top"),
                    left: i.css("left")
                }).insertAfter(i), i.remove()
            }
            return this.originalElement.css("resize", this.originalResizeStyle), t(this.originalElement), this
        },
        _mouseCapture: function(t) {
            var i = !1;
            for (var a in this.handles) e(this.handles[a])[0] == t.target && (i = !0);
            return !this.options.disabled && i
        },
        _mouseStart: function(i) {
            var a = this.options,
                s = this.element.position(),
                n = this.element;
            this.resizing = !0, this.documentScroll = {
                top: e(document).scrollTop(),
                left: e(document).scrollLeft()
            }, (n.is(".ui-draggable") || /absolute/.test(n.css("position"))) && n.css({
                position: "absolute",
                top: s.top,
                left: s.left
            }), this._renderProxy();
            var r = t(this.helper.css("left")),
                o = t(this.helper.css("top"));
            a.containment && (r += e(a.containment).scrollLeft() || 0, o += e(a.containment).scrollTop() || 0), this.offset = this.helper.offset(), this.position = {
                left: r,
                top: o
            }, this.size = this._helper ? {
                width: n.outerWidth(),
                height: n.outerHeight()
            } : {
                width: n.width(),
                height: n.height()
            }, this.originalSize = this._helper ? {
                width: n.outerWidth(),
                height: n.outerHeight()
            } : {
                width: n.width(),
                height: n.height()
            }, this.originalPosition = {
                left: r,
                top: o
            }, this.sizeDiff = {
                width: n.outerWidth() - n.width(),
                height: n.outerHeight() - n.height()
            }, this.originalMousePosition = {
                left: i.pageX,
                top: i.pageY
            }, this.aspectRatio = "number" == typeof a.aspectRatio ? a.aspectRatio : this.originalSize.width / this.originalSize.height || 1;
            var l = e(".ui-resizable-" + this.axis).css("cursor");
            return e("body").css("cursor", "auto" == l ? this.axis + "-resize" : l), n.addClass("ui-resizable-resizing"), this._propagate("start", i), !0
        },
        _mouseDrag: function(e) {
            var t = this.helper,
                i = (this.options, this.originalMousePosition),
                a = this.axis,
                s = e.pageX - i.left || 0,
                n = e.pageY - i.top || 0,
                r = this._change[a];
            if (!r) return !1;
            var o = r.apply(this, [e, s, n]);
            return this._updateVirtualBoundaries(e.shiftKey), (this._aspectRatio || e.shiftKey) && (o = this._updateRatio(o, e)), o = this._respectSize(o, e), this._propagate("resize", e), t.css({
                top: this.position.top + "px",
                left: this.position.left + "px",
                width: this.size.width + "px",
                height: this.size.height + "px"
            }), !this._helper && this._proportionallyResizeElements.length && this._proportionallyResize(), this._updateCache(o), this._trigger("resize", e, this.ui()), !1
        },
        _mouseStop: function(t) {
            this.resizing = !1;
            var i = this.options,
                a = this;
            if (this._helper) {
                var s = this._proportionallyResizeElements,
                    n = s.length && /textarea/i.test(s[0].nodeName),
                    r = n && e.ui.hasScroll(s[0], "left") ? 0 : a.sizeDiff.height,
                    o = n ? 0 : a.sizeDiff.width,
                    l = {
                        width: a.helper.width() - o,
                        height: a.helper.height() - r
                    },
                    h = parseInt(a.element.css("left"), 10) + (a.position.left - a.originalPosition.left) || null,
                    u = parseInt(a.element.css("top"), 10) + (a.position.top - a.originalPosition.top) || null;
                i.animate || this.element.css(e.extend(l, {
                    top: u,
                    left: h
                })), a.helper.height(a.size.height), a.helper.width(a.size.width), this._helper && !i.animate && this._proportionallyResize()
            }
            return e("body").css("cursor", "auto"), this.element.removeClass("ui-resizable-resizing"), this._propagate("stop", t), this._helper && this.helper.remove(), !1
        },
        _updateVirtualBoundaries: function(e) {
            var t, a, s, n, r, o = this.options;
            r = {
                minWidth: i(o.minWidth) ? o.minWidth : 0,
                maxWidth: i(o.maxWidth) ? o.maxWidth : 1 / 0,
                minHeight: i(o.minHeight) ? o.minHeight : 0,
                maxHeight: i(o.maxHeight) ? o.maxHeight : 1 / 0
            }, (this._aspectRatio || e) && (t = r.minHeight * this.aspectRatio, s = r.minWidth / this.aspectRatio, a = r.maxHeight * this.aspectRatio, n = r.maxWidth / this.aspectRatio, t > r.minWidth && (r.minWidth = t), s > r.minHeight && (r.minHeight = s), r.maxWidth > a && (r.maxWidth = a), r.maxHeight > n && (r.maxHeight = n)), this._vBoundaries = r
        },
        _updateCache: function(e) {
            this.options, this.offset = this.helper.offset(), i(e.left) && (this.position.left = e.left), i(e.top) && (this.position.top = e.top), i(e.height) && (this.size.height = e.height), i(e.width) && (this.size.width = e.width)
        },
        _updateRatio: function(e) {
            var t = (this.options, this.position),
                a = this.size,
                s = this.axis;
            return i(e.height) ? e.width = e.height * this.aspectRatio : i(e.width) && (e.height = e.width / this.aspectRatio), "sw" == s && (e.left = t.left + (a.width - e.width), e.top = null), "nw" == s && (e.top = t.top + (a.height - e.height), e.left = t.left + (a.width - e.width)), e
        },
        _respectSize: function(e, t) {
            var a = (this.helper, this._vBoundaries),
                s = (this._aspectRatio || t.shiftKey, this.axis),
                n = i(e.width) && a.maxWidth && a.maxWidth < e.width,
                r = i(e.height) && a.maxHeight && a.maxHeight < e.height,
                o = i(e.width) && a.minWidth && a.minWidth > e.width,
                l = i(e.height) && a.minHeight && a.minHeight > e.height;
            o && (e.width = a.minWidth), l && (e.height = a.minHeight), n && (e.width = a.maxWidth), r && (e.height = a.maxHeight);
            var h = this.originalPosition.left + this.originalSize.width,
                u = this.position.top + this.size.height,
                d = /sw|nw|w/.test(s),
                c = /nw|ne|n/.test(s);
            o && d && (e.left = h - a.minWidth), n && d && (e.left = h - a.maxWidth), l && c && (e.top = u - a.minHeight), r && c && (e.top = u - a.maxHeight);
            var p = !e.width && !e.height;
            return p && !e.left && e.top ? e.top = null : p && !e.top && e.left && (e.left = null), e
        },
        _proportionallyResize: function() {
            if (this.options, this._proportionallyResizeElements.length)
                for (var t = this.helper || this.element, i = 0; this._proportionallyResizeElements.length > i; i++) {
                    var a = this._proportionallyResizeElements[i];
                    if (!this.borderDif) {
                        var s = [a.css("borderTopWidth"), a.css("borderRightWidth"), a.css("borderBottomWidth"), a.css("borderLeftWidth")],
                            n = [a.css("paddingTop"), a.css("paddingRight"), a.css("paddingBottom"), a.css("paddingLeft")];
                        this.borderDif = e.map(s, function(e, t) {
                            var i = parseInt(e, 10) || 0,
                                a = parseInt(n[t], 10) || 0;
                            return i + a
                        })
                    }
                    a.css({
                        height: t.height() - this.borderDif[0] - this.borderDif[2] || 0,
                        width: t.width() - this.borderDif[1] - this.borderDif[3] || 0
                    })
                }
        },
        _renderProxy: function() {
            var t = this.element,
                i = this.options;
            if (this.elementOffset = t.offset(), this._helper) {
                this.helper = this.helper || e('<div style="overflow:hidden;"></div>');
                var a = e.ui.ie6 ? 1 : 0,
                    s = e.ui.ie6 ? 2 : -1;
                this.helper.addClass(this._helper).css({
                    width: this.element.outerWidth() + s,
                    height: this.element.outerHeight() + s,
                    position: "absolute",
                    left: this.elementOffset.left - a + "px",
                    top: this.elementOffset.top - a + "px",
                    zIndex: ++i.zIndex
                }), this.helper.appendTo("body").disableSelection()
            } else this.helper = this.element
        },
        _change: {
            e: function(e, t) {
                return {
                    width: this.originalSize.width + t
                }
            },
            w: function(e, t) {
                var i = (this.options, this.originalSize),
                    a = this.originalPosition;
                return {
                    left: a.left + t,
                    width: i.width - t
                }
            },
            n: function(e, t, i) {
                var a = (this.options, this.originalSize),
                    s = this.originalPosition;
                return {
                    top: s.top + i,
                    height: a.height - i
                }
            },
            s: function(e, t, i) {
                return {
                    height: this.originalSize.height + i
                }
            },
            se: function(t, i, a) {
                return e.extend(this._change.s.apply(this, arguments), this._change.e.apply(this, [t, i, a]))
            },
            sw: function(t, i, a) {
                return e.extend(this._change.s.apply(this, arguments), this._change.w.apply(this, [t, i, a]))
            },
            ne: function(t, i, a) {
                return e.extend(this._change.n.apply(this, arguments), this._change.e.apply(this, [t, i, a]))
            },
            nw: function(t, i, a) {
                return e.extend(this._change.n.apply(this, arguments), this._change.w.apply(this, [t, i, a]))
            }
        },
        _propagate: function(t, i) {
            e.ui.plugin.call(this, t, [i, this.ui()]), "resize" != t && this._trigger(t, i, this.ui())
        },
        plugins: {},
        ui: function() {
            return {
                originalElement: this.originalElement,
                element: this.element,
                helper: this.helper,
                position: this.position,
                size: this.size,
                originalSize: this.originalSize,
                originalPosition: this.originalPosition
            }
        }
    }), e.ui.plugin.add("resizable", "alsoResize", {
        start: function() {
            var t = e(this).data("resizable"),
                i = t.options,
                a = function(t) {
                    e(t).each(function() {
                        var t = e(this);
                        t.data("resizable-alsoresize", {
                            width: parseInt(t.width(), 10),
                            height: parseInt(t.height(), 10),
                            left: parseInt(t.css("left"), 10),
                            top: parseInt(t.css("top"), 10)
                        })
                    })
                };
            "object" != typeof i.alsoResize || i.alsoResize.parentNode ? a(i.alsoResize) : i.alsoResize.length ? (i.alsoResize = i.alsoResize[0], a(i.alsoResize)) : e.each(i.alsoResize, function(e) {
                a(e)
            })
        },
        resize: function(t, i) {
            var a = e(this).data("resizable"),
                s = a.options,
                n = a.originalSize,
                r = a.originalPosition,
                o = {
                    height: a.size.height - n.height || 0,
                    width: a.size.width - n.width || 0,
                    top: a.position.top - r.top || 0,
                    left: a.position.left - r.left || 0
                },
                l = function(t, a) {
                    e(t).each(function() {
                        var t = e(this),
                            s = e(this).data("resizable-alsoresize"),
                            n = {},
                            r = a && a.length ? a : t.parents(i.originalElement[0]).length ? ["width", "height"] : ["width", "height", "top", "left"];
                        e.each(r, function(e, t) {
                            var i = (s[t] || 0) + (o[t] || 0);
                            i && i >= 0 && (n[t] = i || null)
                        }), t.css(n)
                    })
                };
            "object" != typeof s.alsoResize || s.alsoResize.nodeType ? l(s.alsoResize) : e.each(s.alsoResize, function(e, t) {
                l(e, t)
            })
        },
        stop: function() {
            e(this).removeData("resizable-alsoresize")
        }
    }), e.ui.plugin.add("resizable", "animate", {
        stop: function(t) {
            var i = e(this).data("resizable"),
                a = i.options,
                s = i._proportionallyResizeElements,
                n = s.length && /textarea/i.test(s[0].nodeName),
                r = n && e.ui.hasScroll(s[0], "left") ? 0 : i.sizeDiff.height,
                o = n ? 0 : i.sizeDiff.width,
                l = {
                    width: i.size.width - o,
                    height: i.size.height - r
                },
                h = parseInt(i.element.css("left"), 10) + (i.position.left - i.originalPosition.left) || null,
                u = parseInt(i.element.css("top"), 10) + (i.position.top - i.originalPosition.top) || null;
            i.element.animate(e.extend(l, u && h ? {
                top: u,
                left: h
            } : {}), {
                duration: a.animateDuration,
                easing: a.animateEasing,
                step: function() {
                    var a = {
                        width: parseInt(i.element.css("width"), 10),
                        height: parseInt(i.element.css("height"), 10),
                        top: parseInt(i.element.css("top"), 10),
                        left: parseInt(i.element.css("left"), 10)
                    };
                    s && s.length && e(s[0]).css({
                        width: a.width,
                        height: a.height
                    }), i._updateCache(a), i._propagate("resize", t)
                }
            })
        }
    }), e.ui.plugin.add("resizable", "containment", {
        start: function() {
            var i = e(this).data("resizable"),
                a = i.options,
                s = i.element,
                n = a.containment,
                r = n instanceof e ? n.get(0) : /parent/.test(n) ? s.parent().get(0) : n;
            if (r)
                if (i.containerElement = e(r), /document/.test(n) || n == document) i.containerOffset = {
                    left: 0,
                    top: 0
                }, i.containerPosition = {
                    left: 0,
                    top: 0
                }, i.parentData = {
                    element: e(document),
                    left: 0,
                    top: 0,
                    width: e(document).width(),
                    height: e(document).height() || document.body.parentNode.scrollHeight
                };
                else {
                    var o = e(r),
                        l = [];
                    e(["Top", "Right", "Left", "Bottom"]).each(function(e, i) {
                        l[e] = t(o.css("padding" + i))
                    }), i.containerOffset = o.offset(), i.containerPosition = o.position(), i.containerSize = {
                        height: o.innerHeight() - l[3],
                        width: o.innerWidth() - l[1]
                    };
                    var h = i.containerOffset,
                        u = i.containerSize.height,
                        d = i.containerSize.width,
                        c = e.ui.hasScroll(r, "left") ? r.scrollWidth : d,
                        p = e.ui.hasScroll(r) ? r.scrollHeight : u;
                    i.parentData = {
                        element: r,
                        left: h.left,
                        top: h.top,
                        width: c,
                        height: p
                    }
                }
        },
        resize: function(t) {
            var i = e(this).data("resizable"),
                a = i.options,
                s = (i.containerSize, i.containerOffset),
                n = (i.size, i.position),
                r = i._aspectRatio || t.shiftKey,
                o = {
                    top: 0,
                    left: 0
                },
                l = i.containerElement;
            l[0] != document && /static/.test(l.css("position")) && (o = s), n.left < (i._helper ? s.left : 0) && (i.size.width = i.size.width + (i._helper ? i.position.left - s.left : i.position.left - o.left), r && (i.size.height = i.size.width / i.aspectRatio), i.position.left = a.helper ? s.left : 0), n.top < (i._helper ? s.top : 0) && (i.size.height = i.size.height + (i._helper ? i.position.top - s.top : i.position.top), r && (i.size.width = i.size.height * i.aspectRatio), i.position.top = i._helper ? s.top : 0), i.offset.left = i.parentData.left + i.position.left, i.offset.top = i.parentData.top + i.position.top;
            var h = Math.abs((i._helper ? i.offset.left - o.left : i.offset.left - o.left) + i.sizeDiff.width),
                u = Math.abs((i._helper ? i.offset.top - o.top : i.offset.top - s.top) + i.sizeDiff.height),
                d = i.containerElement.get(0) == i.element.parent().get(0),
                c = /relative|absolute/.test(i.containerElement.css("position"));
            d && c && (h -= i.parentData.left), h + i.size.width >= i.parentData.width && (i.size.width = i.parentData.width - h, r && (i.size.height = i.size.width / i.aspectRatio)), u + i.size.height >= i.parentData.height && (i.size.height = i.parentData.height - u, r && (i.size.width = i.size.height * i.aspectRatio))
        },
        stop: function() {
            var t = e(this).data("resizable"),
                i = t.options,
                a = (t.position, t.containerOffset),
                s = t.containerPosition,
                n = t.containerElement,
                r = e(t.helper),
                o = r.offset(),
                l = r.outerWidth() - t.sizeDiff.width,
                h = r.outerHeight() - t.sizeDiff.height;
            t._helper && !i.animate && /relative/.test(n.css("position")) && e(this).css({
                left: o.left - s.left - a.left,
                width: l,
                height: h
            }), t._helper && !i.animate && /static/.test(n.css("position")) && e(this).css({
                left: o.left - s.left - a.left,
                width: l,
                height: h
            })
        }
    }), e.ui.plugin.add("resizable", "ghost", {
        start: function() {
            var t = e(this).data("resizable"),
                i = t.options,
                a = t.size;
            t.ghost = t.originalElement.clone(), t.ghost.css({
                opacity: .25,
                display: "block",
                position: "relative",
                height: a.height,
                width: a.width,
                margin: 0,
                left: 0,
                top: 0
            }).addClass("ui-resizable-ghost").addClass("string" == typeof i.ghost ? i.ghost : ""), t.ghost.appendTo(t.helper)
        },
        resize: function() {
            var t = e(this).data("resizable");
            t.options, t.ghost && t.ghost.css({
                position: "relative",
                height: t.size.height,
                width: t.size.width
            })
        },
        stop: function() {
            var t = e(this).data("resizable");
            t.options, t.ghost && t.helper && t.helper.get(0).removeChild(t.ghost.get(0))
        }
    }), e.ui.plugin.add("resizable", "grid", {
        resize: function(t) {
            var i = e(this).data("resizable"),
                a = i.options,
                s = i.size,
                n = i.originalSize,
                r = i.originalPosition,
                o = i.axis;
            a._aspectRatio || t.shiftKey, a.grid = "number" == typeof a.grid ? [a.grid, a.grid] : a.grid;
            var l = Math.round((s.width - n.width) / (a.grid[0] || 1)) * (a.grid[0] || 1),
                h = Math.round((s.height - n.height) / (a.grid[1] || 1)) * (a.grid[1] || 1);
            /^(se|s|e)$/.test(o) ? (i.size.width = n.width + l, i.size.height = n.height + h) : /^(ne)$/.test(o) ? (i.size.width = n.width + l, i.size.height = n.height + h, i.position.top = r.top - h) : /^(sw)$/.test(o) ? (i.size.width = n.width + l, i.size.height = n.height + h, i.position.left = r.left - l) : (i.size.width = n.width + l, i.size.height = n.height + h, i.position.top = r.top - h, i.position.left = r.left - l)
        }
    });
    var t = function(e) {
            return parseInt(e, 10) || 0
        },
        i = function(e) {
            return !isNaN(parseInt(e, 10))
        }
})(jQuery);
(function(e) {
    e.widget("ui.selectable", e.ui.mouse, {
        version: "1.9.2",
        options: {
            appendTo: "body",
            autoRefresh: !0,
            distance: 0,
            filter: "*",
            tolerance: "touch"
        },
        _create: function() {
            var t = this;
            this.element.addClass("ui-selectable"), this.dragged = !1;
            var i;
            this.refresh = function() {
                i = e(t.options.filter, t.element[0]), i.addClass("ui-selectee"), i.each(function() {
                    var t = e(this),
                        i = t.offset();
                    e.data(this, "selectable-item", {
                        element: this,
                        $element: t,
                        left: i.left,
                        top: i.top,
                        right: i.left + t.outerWidth(),
                        bottom: i.top + t.outerHeight(),
                        startselected: !1,
                        selected: t.hasClass("ui-selected"),
                        selecting: t.hasClass("ui-selecting"),
                        unselecting: t.hasClass("ui-unselecting")
                    })
                })
            }, this.refresh(), this.selectees = i.addClass("ui-selectee"), this._mouseInit(), this.helper = e("<div class='ui-selectable-helper'></div>")
        },
        _destroy: function() {
            this.selectees.removeClass("ui-selectee").removeData("selectable-item"), this.element.removeClass("ui-selectable ui-selectable-disabled"), this._mouseDestroy()
        },
        _mouseStart: function(t) {
            var i = this;
            if (this.opos = [t.pageX, t.pageY], !this.options.disabled) {
                var a = this.options;
                this.selectees = e(a.filter, this.element[0]), this._trigger("start", t), e(a.appendTo).append(this.helper), this.helper.css({
                    left: t.clientX,
                    top: t.clientY,
                    width: 0,
                    height: 0
                }), a.autoRefresh && this.refresh(), this.selectees.filter(".ui-selected").each(function() {
                    var a = e.data(this, "selectable-item");
                    a.startselected = !0, t.metaKey || t.ctrlKey || (a.$element.removeClass("ui-selected"), a.selected = !1, a.$element.addClass("ui-unselecting"), a.unselecting = !0, i._trigger("unselecting", t, {
                        unselecting: a.element
                    }))
                }), e(t.target).parents().andSelf().each(function() {
                    var a = e.data(this, "selectable-item");
                    if (a) {
                        var s = !t.metaKey && !t.ctrlKey || !a.$element.hasClass("ui-selected");
                        return a.$element.removeClass(s ? "ui-unselecting" : "ui-selected").addClass(s ? "ui-selecting" : "ui-unselecting"), a.unselecting = !s, a.selecting = s, a.selected = s, s ? i._trigger("selecting", t, {
                            selecting: a.element
                        }) : i._trigger("unselecting", t, {
                            unselecting: a.element
                        }), !1
                    }
                })
            }
        },
        _mouseDrag: function(t) {
            var i = this;
            if (this.dragged = !0, !this.options.disabled) {
                var a = this.options,
                    s = this.opos[0],
                    n = this.opos[1],
                    r = t.pageX,
                    o = t.pageY;
                if (s > r) {
                    var l = r;
                    r = s, s = l
                }
                if (n > o) {
                    var l = o;
                    o = n, n = l
                }
                return this.helper.css({
                    left: s,
                    top: n,
                    width: r - s,
                    height: o - n
                }), this.selectees.each(function() {
                    var l = e.data(this, "selectable-item");
                    if (l && l.element != i.element[0]) {
                        var h = !1;
                        "touch" == a.tolerance ? h = !(l.left > r || s > l.right || l.top > o || n > l.bottom) : "fit" == a.tolerance && (h = l.left > s && r > l.right && l.top > n && o > l.bottom), h ? (l.selected && (l.$element.removeClass("ui-selected"), l.selected = !1), l.unselecting && (l.$element.removeClass("ui-unselecting"), l.unselecting = !1), l.selecting || (l.$element.addClass("ui-selecting"), l.selecting = !0, i._trigger("selecting", t, {
                            selecting: l.element
                        }))) : (l.selecting && ((t.metaKey || t.ctrlKey) && l.startselected ? (l.$element.removeClass("ui-selecting"), l.selecting = !1, l.$element.addClass("ui-selected"), l.selected = !0) : (l.$element.removeClass("ui-selecting"), l.selecting = !1, l.startselected && (l.$element.addClass("ui-unselecting"), l.unselecting = !0), i._trigger("unselecting", t, {
                            unselecting: l.element
                        }))), l.selected && (t.metaKey || t.ctrlKey || l.startselected || (l.$element.removeClass("ui-selected"), l.selected = !1, l.$element.addClass("ui-unselecting"), l.unselecting = !0, i._trigger("unselecting", t, {
                            unselecting: l.element
                        }))))
                    }
                }), !1
            }
        },
        _mouseStop: function(t) {
            var i = this;
            return this.dragged = !1, this.options, e(".ui-unselecting", this.element[0]).each(function() {
                var a = e.data(this, "selectable-item");
                a.$element.removeClass("ui-unselecting"), a.unselecting = !1, a.startselected = !1, i._trigger("unselected", t, {
                    unselected: a.element
                })
            }), e(".ui-selecting", this.element[0]).each(function() {
                var a = e.data(this, "selectable-item");
                a.$element.removeClass("ui-selecting").addClass("ui-selected"), a.selecting = !1, a.selected = !0, a.startselected = !0, i._trigger("selected", t, {
                    selected: a.element
                })
            }), this._trigger("stop", t), this.helper.remove(), !1
        }
    })
})(jQuery);
(function(e) {
    e.widget("ui.sortable", e.ui.mouse, {
        version: "1.9.2",
        widgetEventPrefix: "sort",
        ready: !1,
        options: {
            appendTo: "parent",
            axis: !1,
            connectWith: !1,
            containment: !1,
            cursor: "auto",
            cursorAt: !1,
            dropOnEmpty: !0,
            forcePlaceholderSize: !1,
            forceHelperSize: !1,
            grid: !1,
            handle: !1,
            helper: "original",
            items: "> *",
            opacity: !1,
            placeholder: !1,
            revert: !1,
            scroll: !0,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            scope: "default",
            tolerance: "intersect",
            zIndex: 1e3
        },
        _create: function() {
            var e = this.options;
            this.containerCache = {}, this.element.addClass("ui-sortable"), this.refresh(), this.floating = this.items.length ? "x" === e.axis || /left|right/.test(this.items[0].item.css("float")) || /inline|table-cell/.test(this.items[0].item.css("display")) : !1, this.offset = this.element.offset(), this._mouseInit(), this.ready = !0
        },
        _destroy: function() {
            this.element.removeClass("ui-sortable ui-sortable-disabled"), this._mouseDestroy();
            for (var e = this.items.length - 1; e >= 0; e--) this.items[e].item.removeData(this.widgetName + "-item");
            return this
        },
        _setOption: function(t, i) {
            "disabled" === t ? (this.options[t] = i, this.widget().toggleClass("ui-sortable-disabled", !!i)) : e.Widget.prototype._setOption.apply(this, arguments)
        },
        _mouseCapture: function(t, i) {
            var a = this;
            if (this.reverting) return !1;
            if (this.options.disabled || "static" == this.options.type) return !1;
            this._refreshItems(t);
            var s = null;
            if (e(t.target).parents().each(function() {
                    return e.data(this, a.widgetName + "-item") == a ? (s = e(this), !1) : undefined
                }), e.data(t.target, a.widgetName + "-item") == a && (s = e(t.target)), !s) return !1;
            if (this.options.handle && !i) {
                var n = !1;
                if (e(this.options.handle, s).find("*").andSelf().each(function() {
                        this == t.target && (n = !0)
                    }), !n) return !1
            }
            return this.currentItem = s, this._removeCurrentsFromItems(), !0
        },
        _mouseStart: function(t, i, a) {
            var s = this.options;
            if (this.currentContainer = this, this.refreshPositions(), this.helper = this._createHelper(t), this._cacheHelperProportions(), this._cacheMargins(), this.scrollParent = this.helper.scrollParent(), this.offset = this.currentItem.offset(), this.offset = {
                    top: this.offset.top - this.margins.top,
                    left: this.offset.left - this.margins.left
                }, e.extend(this.offset, {
                    click: {
                        left: t.pageX - this.offset.left,
                        top: t.pageY - this.offset.top
                    },
                    parent: this._getParentOffset(),
                    relative: this._getRelativeOffset()
                }), this.helper.css("position", "absolute"), this.cssPosition = this.helper.css("position"), this.originalPosition = this._generatePosition(t), this.originalPageX = t.pageX, this.originalPageY = t.pageY, s.cursorAt && this._adjustOffsetFromHelper(s.cursorAt), this.domPosition = {
                    prev: this.currentItem.prev()[0],
                    parent: this.currentItem.parent()[0]
                }, this.helper[0] != this.currentItem[0] && this.currentItem.hide(), this._createPlaceholder(), s.containment && this._setContainment(), s.cursor && (e("body").css("cursor") && (this._storedCursor = e("body").css("cursor")), e("body").css("cursor", s.cursor)), s.opacity && (this.helper.css("opacity") && (this._storedOpacity = this.helper.css("opacity")), this.helper.css("opacity", s.opacity)), s.zIndex && (this.helper.css("zIndex") && (this._storedZIndex = this.helper.css("zIndex")), this.helper.css("zIndex", s.zIndex)), this.scrollParent[0] != document && "HTML" != this.scrollParent[0].tagName && (this.overflowOffset = this.scrollParent.offset()), this._trigger("start", t, this._uiHash()), this._preserveHelperProportions || this._cacheHelperProportions(), !a)
                for (var n = this.containers.length - 1; n >= 0; n--) this.containers[n]._trigger("activate", t, this._uiHash(this));
            return e.ui.ddmanager && (e.ui.ddmanager.current = this), e.ui.ddmanager && !s.dropBehaviour && e.ui.ddmanager.prepareOffsets(this, t), this.dragging = !0, this.helper.addClass("ui-sortable-helper"), this._mouseDrag(t), !0
        },
        _mouseDrag: function(t) {
            if (this.position = this._generatePosition(t), this.positionAbs = this._convertPositionTo("absolute"), this.lastPositionAbs || (this.lastPositionAbs = this.positionAbs), this.options.scroll) {
                var i = this.options,
                    a = !1;
                this.scrollParent[0] != document && "HTML" != this.scrollParent[0].tagName ? (this.overflowOffset.top + this.scrollParent[0].offsetHeight - t.pageY < i.scrollSensitivity ? this.scrollParent[0].scrollTop = a = this.scrollParent[0].scrollTop + i.scrollSpeed : t.pageY - this.overflowOffset.top < i.scrollSensitivity && (this.scrollParent[0].scrollTop = a = this.scrollParent[0].scrollTop - i.scrollSpeed), this.overflowOffset.left + this.scrollParent[0].offsetWidth - t.pageX < i.scrollSensitivity ? this.scrollParent[0].scrollLeft = a = this.scrollParent[0].scrollLeft + i.scrollSpeed : t.pageX - this.overflowOffset.left < i.scrollSensitivity && (this.scrollParent[0].scrollLeft = a = this.scrollParent[0].scrollLeft - i.scrollSpeed)) : (t.pageY - e(document).scrollTop() < i.scrollSensitivity ? a = e(document).scrollTop(e(document).scrollTop() - i.scrollSpeed) : e(window).height() - (t.pageY - e(document).scrollTop()) < i.scrollSensitivity && (a = e(document).scrollTop(e(document).scrollTop() + i.scrollSpeed)), t.pageX - e(document).scrollLeft() < i.scrollSensitivity ? a = e(document).scrollLeft(e(document).scrollLeft() - i.scrollSpeed) : e(window).width() - (t.pageX - e(document).scrollLeft()) < i.scrollSensitivity && (a = e(document).scrollLeft(e(document).scrollLeft() + i.scrollSpeed))), a !== !1 && e.ui.ddmanager && !i.dropBehaviour && e.ui.ddmanager.prepareOffsets(this, t)
            }
            this.positionAbs = this._convertPositionTo("absolute"), this.options.axis && "y" == this.options.axis || (this.helper[0].style.left = this.position.left + "px"), this.options.axis && "x" == this.options.axis || (this.helper[0].style.top = this.position.top + "px");
            for (var s = this.items.length - 1; s >= 0; s--) {
                var n = this.items[s],
                    r = n.item[0],
                    o = this._intersectsWithPointer(n);
                if (o && n.instance === this.currentContainer && r != this.currentItem[0] && this.placeholder[1 == o ? "next" : "prev"]()[0] != r && !e.contains(this.placeholder[0], r) && ("semi-dynamic" == this.options.type ? !e.contains(this.element[0], r) : !0)) {
                    if (this.direction = 1 == o ? "down" : "up", "pointer" != this.options.tolerance && !this._intersectsWithSides(n)) break;
                    this._rearrange(t, n), this._trigger("change", t, this._uiHash());
                    break
                }
            }
            return this._contactContainers(t), e.ui.ddmanager && e.ui.ddmanager.drag(this, t), this._trigger("sort", t, this._uiHash()), this.lastPositionAbs = this.positionAbs, !1
        },
        _mouseStop: function(t, i) {
            if (t) {
                if (e.ui.ddmanager && !this.options.dropBehaviour && e.ui.ddmanager.drop(this, t), this.options.revert) {
                    var a = this,
                        s = this.placeholder.offset();
                    this.reverting = !0, e(this.helper).animate({
                        left: s.left - this.offset.parent.left - this.margins.left + (this.offsetParent[0] == document.body ? 0 : this.offsetParent[0].scrollLeft),
                        top: s.top - this.offset.parent.top - this.margins.top + (this.offsetParent[0] == document.body ? 0 : this.offsetParent[0].scrollTop)
                    }, parseInt(this.options.revert, 10) || 500, function() {
                        a._clear(t)
                    })
                } else this._clear(t, i);
                return !1
            }
        },
        cancel: function() {
            if (this.dragging) {
                this._mouseUp({
                    target: null
                }), "original" == this.options.helper ? this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper") : this.currentItem.show();
                for (var t = this.containers.length - 1; t >= 0; t--) this.containers[t]._trigger("deactivate", null, this._uiHash(this)), this.containers[t].containerCache.over && (this.containers[t]._trigger("out", null, this._uiHash(this)), this.containers[t].containerCache.over = 0)
            }
            return this.placeholder && (this.placeholder[0].parentNode && this.placeholder[0].parentNode.removeChild(this.placeholder[0]), "original" != this.options.helper && this.helper && this.helper[0].parentNode && this.helper.remove(), e.extend(this, {
                helper: null,
                dragging: !1,
                reverting: !1,
                _noFinalSort: null
            }), this.domPosition.prev ? e(this.domPosition.prev).after(this.currentItem) : e(this.domPosition.parent).prepend(this.currentItem)), this
        },
        serialize: function(t) {
            var i = this._getItemsAsjQuery(t && t.connected),
                a = [];
            return t = t || {}, e(i).each(function() {
                var i = (e(t.item || this).attr(t.attribute || "id") || "").match(t.expression || /(.+)[-=_](.+)/);
                i && a.push((t.key || i[1] + "[]") + "=" + (t.key && t.expression ? i[1] : i[2]))
            }), !a.length && t.key && a.push(t.key + "="), a.join("&")
        },
        toArray: function(t) {
            var i = this._getItemsAsjQuery(t && t.connected),
                a = [];
            return t = t || {}, i.each(function() {
                a.push(e(t.item || this).attr(t.attribute || "id") || "")
            }), a
        },
        _intersectsWith: function(e) {
            var t = this.positionAbs.left,
                i = t + this.helperProportions.width,
                a = this.positionAbs.top,
                s = a + this.helperProportions.height,
                n = e.left,
                r = n + e.width,
                o = e.top,
                h = o + e.height,
                l = this.offset.click.top,
                u = this.offset.click.left,
                d = a + l > o && h > a + l && t + u > n && r > t + u;
            return "pointer" == this.options.tolerance || this.options.forcePointerForContainers || "pointer" != this.options.tolerance && this.helperProportions[this.floating ? "width" : "height"] > e[this.floating ? "width" : "height"] ? d : t + this.helperProportions.width / 2 > n && r > i - this.helperProportions.width / 2 && a + this.helperProportions.height / 2 > o && h > s - this.helperProportions.height / 2
        },
        _intersectsWithPointer: function(t) {
            var i = "x" === this.options.axis || e.ui.isOverAxis(this.positionAbs.top + this.offset.click.top, t.top, t.height),
                a = "y" === this.options.axis || e.ui.isOverAxis(this.positionAbs.left + this.offset.click.left, t.left, t.width),
                s = i && a,
                n = this._getDragVerticalDirection(),
                r = this._getDragHorizontalDirection();
            return s ? this.floating ? r && "right" == r || "down" == n ? 2 : 1 : n && ("down" == n ? 2 : 1) : !1
        },
        _intersectsWithSides: function(t) {
            var i = e.ui.isOverAxis(this.positionAbs.top + this.offset.click.top, t.top + t.height / 2, t.height),
                a = e.ui.isOverAxis(this.positionAbs.left + this.offset.click.left, t.left + t.width / 2, t.width),
                s = this._getDragVerticalDirection(),
                n = this._getDragHorizontalDirection();
            return this.floating && n ? "right" == n && a || "left" == n && !a : s && ("down" == s && i || "up" == s && !i)
        },
        _getDragVerticalDirection: function() {
            var e = this.positionAbs.top - this.lastPositionAbs.top;
            return 0 != e && (e > 0 ? "down" : "up")
        },
        _getDragHorizontalDirection: function() {
            var e = this.positionAbs.left - this.lastPositionAbs.left;
            return 0 != e && (e > 0 ? "right" : "left")
        },
        refresh: function(e) {
            return this._refreshItems(e), this.refreshPositions(), this
        },
        _connectWith: function() {
            var e = this.options;
            return e.connectWith.constructor == String ? [e.connectWith] : e.connectWith
        },
        _getItemsAsjQuery: function(t) {
            var i = [],
                a = [],
                s = this._connectWith();
            if (s && t)
                for (var n = s.length - 1; n >= 0; n--)
                    for (var r = e(s[n]), o = r.length - 1; o >= 0; o--) {
                        var h = e.data(r[o], this.widgetName);
                        h && h != this && !h.options.disabled && a.push([e.isFunction(h.options.items) ? h.options.items.call(h.element) : e(h.options.items, h.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), h])
                    }
            a.push([e.isFunction(this.options.items) ? this.options.items.call(this.element, null, {
                options: this.options,
                item: this.currentItem
            }) : e(this.options.items, this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), this]);
            for (var n = a.length - 1; n >= 0; n--) a[n][0].each(function() {
                i.push(this)
            });
            return e(i)
        },
        _removeCurrentsFromItems: function() {
            var t = this.currentItem.find(":data(" + this.widgetName + "-item)");
            this.items = e.grep(this.items, function(e) {
                for (var i = 0; t.length > i; i++)
                    if (t[i] == e.item[0]) return !1;
                return !0
            })
        },
        _refreshItems: function(t) {
            this.items = [], this.containers = [this];
            var i = this.items,
                a = [
                    [e.isFunction(this.options.items) ? this.options.items.call(this.element[0], t, {
                        item: this.currentItem
                    }) : e(this.options.items, this.element), this]
                ],
                s = this._connectWith();
            if (s && this.ready)
                for (var n = s.length - 1; n >= 0; n--)
                    for (var r = e(s[n]), o = r.length - 1; o >= 0; o--) {
                        var h = e.data(r[o], this.widgetName);
                        h && h != this && !h.options.disabled && (a.push([e.isFunction(h.options.items) ? h.options.items.call(h.element[0], t, {
                            item: this.currentItem
                        }) : e(h.options.items, h.element), h]), this.containers.push(h))
                    }
            for (var n = a.length - 1; n >= 0; n--)
                for (var l = a[n][1], u = a[n][0], o = 0, d = u.length; d > o; o++) {
                    var c = e(u[o]);
                    c.data(this.widgetName + "-item", l), i.push({
                        item: c,
                        instance: l,
                        width: 0,
                        height: 0,
                        left: 0,
                        top: 0
                    })
                }
        },
        refreshPositions: function(t) {
            this.offsetParent && this.helper && (this.offset.parent = this._getParentOffset());
            for (var i = this.items.length - 1; i >= 0; i--) {
                var a = this.items[i];
                if (a.instance == this.currentContainer || !this.currentContainer || a.item[0] == this.currentItem[0]) {
                    var s = this.options.toleranceElement ? e(this.options.toleranceElement, a.item) : a.item;
                    t || (a.width = s.outerWidth(), a.height = s.outerHeight());
                    var n = s.offset();
                    a.left = n.left, a.top = n.top
                }
            }
            if (this.options.custom && this.options.custom.refreshContainers) this.options.custom.refreshContainers.call(this);
            else
                for (var i = this.containers.length - 1; i >= 0; i--) {
                    var n = this.containers[i].element.offset();
                    this.containers[i].containerCache.left = n.left, this.containers[i].containerCache.top = n.top, this.containers[i].containerCache.width = this.containers[i].element.outerWidth(), this.containers[i].containerCache.height = this.containers[i].element.outerHeight()
                }
            return this
        },
        _createPlaceholder: function(t) {
            t = t || this;
            var i = t.options;
            if (!i.placeholder || i.placeholder.constructor == String) {
                var a = i.placeholder;
                i.placeholder = {
                    element: function() {
                        var i = e(document.createElement(t.currentItem[0].nodeName)).addClass(a || t.currentItem[0].className + " ui-sortable-placeholder").removeClass("ui-sortable-helper")[0];
                        return a || (i.style.visibility = "hidden"), i
                    },
                    update: function(e, s) {
                        (!a || i.forcePlaceholderSize) && (s.height() || s.height(t.currentItem.innerHeight() - parseInt(t.currentItem.css("paddingTop") || 0, 10) - parseInt(t.currentItem.css("paddingBottom") || 0, 10)), s.width() || s.width(t.currentItem.innerWidth() - parseInt(t.currentItem.css("paddingLeft") || 0, 10) - parseInt(t.currentItem.css("paddingRight") || 0, 10)))
                    }
                }
            }
            t.placeholder = e(i.placeholder.element.call(t.element, t.currentItem)), t.currentItem.after(t.placeholder), i.placeholder.update(t, t.placeholder)
        },
        _contactContainers: function(t) {
            for (var i = null, a = null, s = this.containers.length - 1; s >= 0; s--)
                if (!e.contains(this.currentItem[0], this.containers[s].element[0]))
                    if (this._intersectsWith(this.containers[s].containerCache)) {
                        if (i && e.contains(this.containers[s].element[0], i.element[0])) continue;
                        i = this.containers[s], a = s
                    } else this.containers[s].containerCache.over && (this.containers[s]._trigger("out", t, this._uiHash(this)), this.containers[s].containerCache.over = 0);
            if (i)
                if (1 === this.containers.length) this.containers[a]._trigger("over", t, this._uiHash(this)), this.containers[a].containerCache.over = 1;
                else {
                    for (var n = 1e4, r = null, o = this.containers[a].floating ? "left" : "top", h = this.containers[a].floating ? "width" : "height", l = this.positionAbs[o] + this.offset.click[o], u = this.items.length - 1; u >= 0; u--)
                        if (e.contains(this.containers[a].element[0], this.items[u].item[0]) && this.items[u].item[0] != this.currentItem[0]) {
                            var d = this.items[u].item.offset()[o],
                                c = !1;
                            Math.abs(d - l) > Math.abs(d + this.items[u][h] - l) && (c = !0, d += this.items[u][h]), n > Math.abs(d - l) && (n = Math.abs(d - l), r = this.items[u], this.direction = c ? "up" : "down")
                        }
                    if (!r && !this.options.dropOnEmpty) return;
                    this.currentContainer = this.containers[a], r ? this._rearrange(t, r, null, !0) : this._rearrange(t, null, this.containers[a].element, !0), this._trigger("change", t, this._uiHash()), this.containers[a]._trigger("change", t, this._uiHash(this)), this.options.placeholder.update(this.currentContainer, this.placeholder), this.containers[a]._trigger("over", t, this._uiHash(this)), this.containers[a].containerCache.over = 1
                }
        },
        _createHelper: function(t) {
            var i = this.options,
                a = e.isFunction(i.helper) ? e(i.helper.apply(this.element[0], [t, this.currentItem])) : "clone" == i.helper ? this.currentItem.clone() : this.currentItem;
            return a.parents("body").length || e("parent" != i.appendTo ? i.appendTo : this.currentItem[0].parentNode)[0].appendChild(a[0]), a[0] == this.currentItem[0] && (this._storedCSS = {
                width: this.currentItem[0].style.width,
                height: this.currentItem[0].style.height,
                position: this.currentItem.css("position"),
                top: this.currentItem.css("top"),
                left: this.currentItem.css("left")
            }), ("" == a[0].style.width || i.forceHelperSize) && a.width(this.currentItem.width()), ("" == a[0].style.height || i.forceHelperSize) && a.height(this.currentItem.height()), a
        },
        _adjustOffsetFromHelper: function(t) {
            "string" == typeof t && (t = t.split(" ")), e.isArray(t) && (t = {
                left: +t[0],
                top: +t[1] || 0
            }), "left" in t && (this.offset.click.left = t.left + this.margins.left), "right" in t && (this.offset.click.left = this.helperProportions.width - t.right + this.margins.left), "top" in t && (this.offset.click.top = t.top + this.margins.top), "bottom" in t && (this.offset.click.top = this.helperProportions.height - t.bottom + this.margins.top)
        },
        _getParentOffset: function() {
            this.offsetParent = this.helper.offsetParent();
            var t = this.offsetParent.offset();
            return "absolute" == this.cssPosition && this.scrollParent[0] != document && e.contains(this.scrollParent[0], this.offsetParent[0]) && (t.left += this.scrollParent.scrollLeft(), t.top += this.scrollParent.scrollTop()), (this.offsetParent[0] == document.body || this.offsetParent[0].tagName && "html" == this.offsetParent[0].tagName.toLowerCase() && e.ui.ie) && (t = {
                top: 0,
                left: 0
            }), {
                top: t.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: t.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            }
        },
        _getRelativeOffset: function() {
            if ("relative" == this.cssPosition) {
                var e = this.currentItem.position();
                return {
                    top: e.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                    left: e.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                }
            }
            return {
                top: 0,
                left: 0
            }
        },
        _cacheMargins: function() {
            this.margins = {
                left: parseInt(this.currentItem.css("marginLeft"), 10) || 0,
                top: parseInt(this.currentItem.css("marginTop"), 10) || 0
            }
        },
        _cacheHelperProportions: function() {
            this.helperProportions = {
                width: this.helper.outerWidth(),
                height: this.helper.outerHeight()
            }
        },
        _setContainment: function() {
            var t = this.options;
            if ("parent" == t.containment && (t.containment = this.helper[0].parentNode), ("document" == t.containment || "window" == t.containment) && (this.containment = [0 - this.offset.relative.left - this.offset.parent.left, 0 - this.offset.relative.top - this.offset.parent.top, e("document" == t.containment ? document : window).width() - this.helperProportions.width - this.margins.left, (e("document" == t.containment ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]), !/^(document|window|parent)$/.test(t.containment)) {
                var i = e(t.containment)[0],
                    a = e(t.containment).offset(),
                    s = "hidden" != e(i).css("overflow");
                this.containment = [a.left + (parseInt(e(i).css("borderLeftWidth"), 10) || 0) + (parseInt(e(i).css("paddingLeft"), 10) || 0) - this.margins.left, a.top + (parseInt(e(i).css("borderTopWidth"), 10) || 0) + (parseInt(e(i).css("paddingTop"), 10) || 0) - this.margins.top, a.left + (s ? Math.max(i.scrollWidth, i.offsetWidth) : i.offsetWidth) - (parseInt(e(i).css("borderLeftWidth"), 10) || 0) - (parseInt(e(i).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left, a.top + (s ? Math.max(i.scrollHeight, i.offsetHeight) : i.offsetHeight) - (parseInt(e(i).css("borderTopWidth"), 10) || 0) - (parseInt(e(i).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top]
            }
        },
        _convertPositionTo: function(t, i) {
            i || (i = this.position);
            var a = "absolute" == t ? 1 : -1,
                s = (this.options, "absolute" != this.cssPosition || this.scrollParent[0] != document && e.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent),
                n = /(html|body)/i.test(s[0].tagName);
            return {
                top: i.top + this.offset.relative.top * a + this.offset.parent.top * a - ("fixed" == this.cssPosition ? -this.scrollParent.scrollTop() : n ? 0 : s.scrollTop()) * a,
                left: i.left + this.offset.relative.left * a + this.offset.parent.left * a - ("fixed" == this.cssPosition ? -this.scrollParent.scrollLeft() : n ? 0 : s.scrollLeft()) * a
            }
        },
        _generatePosition: function(t) {
            var i = this.options,
                a = "absolute" != this.cssPosition || this.scrollParent[0] != document && e.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent,
                s = /(html|body)/i.test(a[0].tagName);
            "relative" != this.cssPosition || this.scrollParent[0] != document && this.scrollParent[0] != this.offsetParent[0] || (this.offset.relative = this._getRelativeOffset());
            var n = t.pageX,
                r = t.pageY;
            if (this.originalPosition && (this.containment && (t.pageX - this.offset.click.left < this.containment[0] && (n = this.containment[0] + this.offset.click.left), t.pageY - this.offset.click.top < this.containment[1] && (r = this.containment[1] + this.offset.click.top), t.pageX - this.offset.click.left > this.containment[2] && (n = this.containment[2] + this.offset.click.left), t.pageY - this.offset.click.top > this.containment[3] && (r = this.containment[3] + this.offset.click.top)), i.grid)) {
                var o = this.originalPageY + Math.round((r - this.originalPageY) / i.grid[1]) * i.grid[1];
                r = this.containment ? o - this.offset.click.top < this.containment[1] || o - this.offset.click.top > this.containment[3] ? o - this.offset.click.top < this.containment[1] ? o + i.grid[1] : o - i.grid[1] : o : o;
                var h = this.originalPageX + Math.round((n - this.originalPageX) / i.grid[0]) * i.grid[0];
                n = this.containment ? h - this.offset.click.left < this.containment[0] || h - this.offset.click.left > this.containment[2] ? h - this.offset.click.left < this.containment[0] ? h + i.grid[0] : h - i.grid[0] : h : h
            }
            return {
                top: r - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" == this.cssPosition ? -this.scrollParent.scrollTop() : s ? 0 : a.scrollTop()),
                left: n - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" == this.cssPosition ? -this.scrollParent.scrollLeft() : s ? 0 : a.scrollLeft())
            }
        },
        _rearrange: function(e, t, i, a) {
            i ? i[0].appendChild(this.placeholder[0]) : t.item[0].parentNode.insertBefore(this.placeholder[0], "down" == this.direction ? t.item[0] : t.item[0].nextSibling), this.counter = this.counter ? ++this.counter : 1;
            var s = this.counter;
            this._delay(function() {
                s == this.counter && this.refreshPositions(!a)
            })
        },
        _clear: function(t, i) {
            this.reverting = !1;
            var a = [];
            if (!this._noFinalSort && this.currentItem.parent().length && this.placeholder.before(this.currentItem), this._noFinalSort = null, this.helper[0] == this.currentItem[0]) {
                for (var s in this._storedCSS)("auto" == this._storedCSS[s] || "static" == this._storedCSS[s]) && (this._storedCSS[s] = "");
                this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper")
            } else this.currentItem.show();
            this.fromOutside && !i && a.push(function(e) {
                this._trigger("receive", e, this._uiHash(this.fromOutside))
            }), !this.fromOutside && this.domPosition.prev == this.currentItem.prev().not(".ui-sortable-helper")[0] && this.domPosition.parent == this.currentItem.parent()[0] || i || a.push(function(e) {
                this._trigger("update", e, this._uiHash())
            }), this !== this.currentContainer && (i || (a.push(function(e) {
                this._trigger("remove", e, this._uiHash())
            }), a.push(function(e) {
                return function(t) {
                    e._trigger("receive", t, this._uiHash(this))
                }
            }.call(this, this.currentContainer)), a.push(function(e) {
                return function(t) {
                    e._trigger("update", t, this._uiHash(this))
                }
            }.call(this, this.currentContainer))));
            for (var s = this.containers.length - 1; s >= 0; s--) i || a.push(function(e) {
                return function(t) {
                    e._trigger("deactivate", t, this._uiHash(this))
                }
            }.call(this, this.containers[s])), this.containers[s].containerCache.over && (a.push(function(e) {
                return function(t) {
                    e._trigger("out", t, this._uiHash(this))
                }
            }.call(this, this.containers[s])), this.containers[s].containerCache.over = 0);
            if (this._storedCursor && e("body").css("cursor", this._storedCursor), this._storedOpacity && this.helper.css("opacity", this._storedOpacity), this._storedZIndex && this.helper.css("zIndex", "auto" == this._storedZIndex ? "" : this._storedZIndex), this.dragging = !1, this.cancelHelperRemoval) {
                if (!i) {
                    this._trigger("beforeStop", t, this._uiHash());
                    for (var s = 0; a.length > s; s++) a[s].call(this, t);
                    this._trigger("stop", t, this._uiHash())
                }
                return this.fromOutside = !1, !1
            }
            if (i || this._trigger("beforeStop", t, this._uiHash()), this.placeholder[0].parentNode.removeChild(this.placeholder[0]), this.helper[0] != this.currentItem[0] && this.helper.remove(), this.helper = null, !i) {
                for (var s = 0; a.length > s; s++) a[s].call(this, t);
                this._trigger("stop", t, this._uiHash())
            }
            return this.fromOutside = !1, !0
        },
        _trigger: function() {
            e.Widget.prototype._trigger.apply(this, arguments) === !1 && this.cancel()
        },
        _uiHash: function(t) {
            var i = t || this;
            return {
                helper: i.helper,
                placeholder: i.placeholder || e([]),
                position: i.position,
                originalPosition: i.originalPosition,
                offset: i.positionAbs,
                item: i.currentItem,
                sender: t ? t.element : null
            }
        }
    })
})(jQuery);
(function(e) {
    var t = 0,
        i = {},
        a = {};
    i.height = i.paddingTop = i.paddingBottom = i.borderTopWidth = i.borderBottomWidth = "hide", a.height = a.paddingTop = a.paddingBottom = a.borderTopWidth = a.borderBottomWidth = "show", e.widget("ui.accordion", {
        version: "1.9.2",
        options: {
            active: 0,
            animate: {},
            collapsible: !1,
            event: "click",
            header: "> li > :first-child,> :not(li):even",
            heightStyle: "auto",
            icons: {
                activeHeader: "ui-icon-triangle-1-s",
                header: "ui-icon-triangle-1-e"
            },
            activate: null,
            beforeActivate: null
        },
        _create: function() {
            var i = this.accordionId = "ui-accordion-" + (this.element.attr("id") || ++t),
                a = this.options;
            this.prevShow = this.prevHide = e(), this.element.addClass("ui-accordion ui-widget ui-helper-reset"), this.headers = this.element.find(a.header).addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all"), this._hoverable(this.headers), this._focusable(this.headers), this.headers.next().addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom").hide(), a.collapsible || a.active !== !1 && null != a.active || (a.active = 0), 0 > a.active && (a.active += this.headers.length), this.active = this._findActive(a.active).addClass("ui-accordion-header-active ui-state-active").toggleClass("ui-corner-all ui-corner-top"), this.active.next().addClass("ui-accordion-content-active").show(), this._createIcons(), this.refresh(), this.element.attr("role", "tablist"), this.headers.attr("role", "tab").each(function(t) {
                var a = e(this),
                    r = a.attr("id"),
                    n = a.next(),
                    s = n.attr("id");
                r || (r = i + "-header-" + t, a.attr("id", r)), s || (s = i + "-panel-" + t, n.attr("id", s)), a.attr("aria-controls", s), n.attr("aria-labelledby", r)
            }).next().attr("role", "tabpanel"), this.headers.not(this.active).attr({
                "aria-selected": "false",
                tabIndex: -1
            }).next().attr({
                "aria-expanded": "false",
                "aria-hidden": "true"
            }).hide(), this.active.length ? this.active.attr({
                "aria-selected": "true",
                tabIndex: 0
            }).next().attr({
                "aria-expanded": "true",
                "aria-hidden": "false"
            }) : this.headers.eq(0).attr("tabIndex", 0), this._on(this.headers, {
                keydown: "_keydown"
            }), this._on(this.headers.next(), {
                keydown: "_panelKeyDown"
            }), this._setupEvents(a.event)
        },
        _getCreateEventData: function() {
            return {
                header: this.active,
                content: this.active.length ? this.active.next() : e()
            }
        },
        _createIcons: function() {
            var t = this.options.icons;
            t && (e("<span>").addClass("ui-accordion-header-icon ui-icon " + t.header).prependTo(this.headers), this.active.children(".ui-accordion-header-icon").removeClass(t.header).addClass(t.activeHeader), this.headers.addClass("ui-accordion-icons"))
        },
        _destroyIcons: function() {
            this.headers.removeClass("ui-accordion-icons").children(".ui-accordion-header-icon").remove()
        },
        _destroy: function() {
            var e;
            this.element.removeClass("ui-accordion ui-widget ui-helper-reset").removeAttr("role"), this.headers.removeClass("ui-accordion-header ui-accordion-header-active ui-helper-reset ui-state-default ui-corner-all ui-state-active ui-state-disabled ui-corner-top").removeAttr("role").removeAttr("aria-selected").removeAttr("aria-controls").removeAttr("tabIndex").each(function() {
                /^ui-accordion/.test(this.id) && this.removeAttribute("id")
            }), this._destroyIcons(), e = this.headers.next().css("display", "").removeAttr("role").removeAttr("aria-expanded").removeAttr("aria-hidden").removeAttr("aria-labelledby").removeClass("ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content ui-accordion-content-active ui-state-disabled").each(function() {
                /^ui-accordion/.test(this.id) && this.removeAttribute("id")
            }), "content" !== this.options.heightStyle && e.css("height", "")
        },
        _setOption: function(e, t) {
            return "active" === e ? (this._activate(t), undefined) : ("event" === e && (this.options.event && this._off(this.headers, this.options.event), this._setupEvents(t)), this._super(e, t), "collapsible" !== e || t || this.options.active !== !1 || this._activate(0), "icons" === e && (this._destroyIcons(), t && this._createIcons()), "disabled" === e && this.headers.add(this.headers.next()).toggleClass("ui-state-disabled", !!t), undefined)
        },
        _keydown: function(t) {
            if (!t.altKey && !t.ctrlKey) {
                var i = e.ui.keyCode,
                    a = this.headers.length,
                    r = this.headers.index(t.target),
                    n = !1;
                switch (t.keyCode) {
                    case i.RIGHT:
                    case i.DOWN:
                        n = this.headers[(r + 1) % a];
                        break;
                    case i.LEFT:
                    case i.UP:
                        n = this.headers[(r - 1 + a) % a];
                        break;
                    case i.SPACE:
                    case i.ENTER:
                        this._eventHandler(t);
                        break;
                    case i.HOME:
                        n = this.headers[0];
                        break;
                    case i.END:
                        n = this.headers[a - 1]
                }
                n && (e(t.target).attr("tabIndex", -1), e(n).attr("tabIndex", 0), n.focus(), t.preventDefault())
            }
        },
        _panelKeyDown: function(t) {
            t.keyCode === e.ui.keyCode.UP && t.ctrlKey && e(t.currentTarget).prev().focus()
        },
        refresh: function() {
            var t, i, a = this.options.heightStyle,
                r = this.element.parent();
            "fill" === a ? (e.support.minHeight || (i = r.css("overflow"), r.css("overflow", "hidden")), t = r.height(), this.element.siblings(":visible").each(function() {
                var i = e(this),
                    a = i.css("position");
                "absolute" !== a && "fixed" !== a && (t -= i.outerHeight(!0))
            }), i && r.css("overflow", i), this.headers.each(function() {
                t -= e(this).outerHeight(!0)
            }), this.headers.next().each(function() {
                e(this).height(Math.max(0, t - e(this).innerHeight() + e(this).height()))
            }).css("overflow", "auto")) : "auto" === a && (t = 0, this.headers.next().each(function() {
                t = Math.max(t, e(this).css("height", "").height())
            }).height(t))
        },
        _activate: function(t) {
            var i = this._findActive(t)[0];
            i !== this.active[0] && (i = i || this.active[0], this._eventHandler({
                target: i,
                currentTarget: i,
                preventDefault: e.noop
            }))
        },
        _findActive: function(t) {
            return "number" == typeof t ? this.headers.eq(t) : e()
        },
        _setupEvents: function(t) {
            var i = {};
            t && (e.each(t.split(" "), function(e, t) {
                i[t] = "_eventHandler"
            }), this._on(this.headers, i))
        },
        _eventHandler: function(t) {
            var i = this.options,
                a = this.active,
                r = e(t.currentTarget),
                n = r[0] === a[0],
                s = n && i.collapsible,
                o = s ? e() : r.next(),
                d = a.next(),
                u = {
                    oldHeader: a,
                    oldPanel: d,
                    newHeader: s ? e() : r,
                    newPanel: o
                };
            t.preventDefault(), n && !i.collapsible || this._trigger("beforeActivate", t, u) === !1 || (i.active = s ? !1 : this.headers.index(r), this.active = n ? e() : r, this._toggle(u), a.removeClass("ui-accordion-header-active ui-state-active"), i.icons && a.children(".ui-accordion-header-icon").removeClass(i.icons.activeHeader).addClass(i.icons.header), n || (r.removeClass("ui-corner-all").addClass("ui-accordion-header-active ui-state-active ui-corner-top"), i.icons && r.children(".ui-accordion-header-icon").removeClass(i.icons.header).addClass(i.icons.activeHeader), r.next().addClass("ui-accordion-content-active")))
        },
        _toggle: function(t) {
            var i = t.newPanel,
                a = this.prevShow.length ? this.prevShow : t.oldPanel;
            this.prevShow.add(this.prevHide).stop(!0, !0), this.prevShow = i, this.prevHide = a, this.options.animate ? this._animate(i, a, t) : (a.hide(), i.show(), this._toggleComplete(t)), a.attr({
                "aria-expanded": "false",
                "aria-hidden": "true"
            }), a.prev().attr("aria-selected", "false"), i.length && a.length ? a.prev().attr("tabIndex", -1) : i.length && this.headers.filter(function() {
                return 0 === e(this).attr("tabIndex")
            }).attr("tabIndex", -1), i.attr({
                "aria-expanded": "true",
                "aria-hidden": "false"
            }).prev().attr({
                "aria-selected": "true",
                tabIndex: 0
            })
        },
        _animate: function(e, t, r) {
            var n, s, o, d = this,
                u = 0,
                l = e.length && (!t.length || e.index() < t.index()),
                h = this.options.animate || {},
                c = l && h.down || h,
                m = function() {
                    d._toggleComplete(r)
                };
            return "number" == typeof c && (o = c), "string" == typeof c && (s = c), s = s || c.easing || h.easing, o = o || c.duration || h.duration, t.length ? e.length ? (n = e.show().outerHeight(), t.animate(i, {
                duration: o,
                easing: s,
                step: function(e, t) {
                    t.now = Math.round(e)
                }
            }), e.hide().animate(a, {
                duration: o,
                easing: s,
                complete: m,
                step: function(e, i) {
                    i.now = Math.round(e), "height" !== i.prop ? u += i.now : "content" !== d.options.heightStyle && (i.now = Math.round(n - t.outerHeight() - u), u = 0)
                }
            }), undefined) : t.animate(i, o, s, m) : e.animate(a, o, s, m)
        },
        _toggleComplete: function(e) {
            var t = e.oldPanel;
            t.removeClass("ui-accordion-content-active").prev().removeClass("ui-corner-top").addClass("ui-corner-all"), t.length && (t.parent()[0].className = t.parent()[0].className), this._trigger("activate", null, e)
        }
    }), e.uiBackCompat !== !1 && (function(e, t) {
        e.extend(t.options, {
            navigation: !1,
            navigationFilter: function() {
                return this.href.toLowerCase() === location.href.toLowerCase()
            }
        });
        var i = t._create;
        t._create = function() {
            if (this.options.navigation) {
                var t = this,
                    a = this.element.find(this.options.header),
                    r = a.next(),
                    n = a.add(r).find("a").filter(this.options.navigationFilter)[0];
                n && a.add(r).each(function(i) {
                    return e.contains(this, n) ? (t.options.active = Math.floor(i / 2), !1) : undefined
                })
            }
            i.call(this)
        }
    }(jQuery, jQuery.ui.accordion.prototype), function(e, t) {
        e.extend(t.options, {
            heightStyle: null,
            autoHeight: !0,
            clearStyle: !1,
            fillSpace: !1
        });
        var i = t._create,
            a = t._setOption;
        e.extend(t, {
            _create: function() {
                this.options.heightStyle = this.options.heightStyle || this._mergeHeightStyle(), i.call(this)
            },
            _setOption: function(e) {
                ("autoHeight" === e || "clearStyle" === e || "fillSpace" === e) && (this.options.heightStyle = this._mergeHeightStyle()), a.apply(this, arguments)
            },
            _mergeHeightStyle: function() {
                var e = this.options;
                return e.fillSpace ? "fill" : e.clearStyle ? "content" : e.autoHeight ? "auto" : undefined
            }
        })
    }(jQuery, jQuery.ui.accordion.prototype), function(e, t) {
        e.extend(t.options.icons, {
            activeHeader: null,
            headerSelected: "ui-icon-triangle-1-s"
        });
        var i = t._createIcons;
        t._createIcons = function() {
            this.options.icons && (this.options.icons.activeHeader = this.options.icons.activeHeader || this.options.icons.headerSelected), i.call(this)
        }
    }(jQuery, jQuery.ui.accordion.prototype), function(e, t) {
        t.activate = t._activate;
        var i = t._findActive;
        t._findActive = function(e) {
            return -1 === e && (e = !1), e && "number" != typeof e && (e = this.headers.index(this.headers.filter(e)), -1 === e && (e = !1)), i.call(this, e)
        }
    }(jQuery, jQuery.ui.accordion.prototype), jQuery.ui.accordion.prototype.resize = jQuery.ui.accordion.prototype.refresh, function(e, t) {
        e.extend(t.options, {
            change: null,
            changestart: null
        });
        var i = t._trigger;
        t._trigger = function(e, t, a) {
            var r = i.apply(this, arguments);
            return r ? ("beforeActivate" === e ? r = i.call(this, "changestart", t, {
                oldHeader: a.oldHeader,
                oldContent: a.oldPanel,
                newHeader: a.newHeader,
                newContent: a.newPanel
            }) : "activate" === e && (r = i.call(this, "change", t, {
                oldHeader: a.oldHeader,
                oldContent: a.oldPanel,
                newHeader: a.newHeader,
                newContent: a.newPanel
            })), r) : !1
        }
    }(jQuery, jQuery.ui.accordion.prototype), function(e, t) {
        e.extend(t.options, {
            animate: null,
            animated: "slide"
        });
        var i = t._create;
        t._create = function() {
            var e = this.options;
            null === e.animate && (e.animate = e.animated ? "slide" === e.animated ? 300 : "bounceslide" === e.animated ? {
                duration: 200,
                down: {
                    easing: "easeOutBounce",
                    duration: 1e3
                }
            } : e.animated : !1), i.call(this)
        }
    }(jQuery, jQuery.ui.accordion.prototype))
})(jQuery);
(function(e) {
    var t = 0;
    e.widget("ui.autocomplete", {
        version: "1.9.2",
        defaultElement: "<input>",
        options: {
            appendTo: "body",
            autoFocus: !1,
            delay: 300,
            minLength: 1,
            position: {
                my: "left top",
                at: "left bottom",
                collision: "none"
            },
            source: null,
            change: null,
            close: null,
            focus: null,
            open: null,
            response: null,
            search: null,
            select: null
        },
        pending: 0,
        _create: function() {
            var t, i, a;
            this.isMultiLine = this._isMultiLine(), this.valueMethod = this.element[this.element.is("input,textarea") ? "val" : "text"], this.isNewMenu = !0, this.element.addClass("ui-autocomplete-input").attr("autocomplete", "off"), this._on(this.element, {
                keydown: function(r) {
                    if (this.element.prop("readOnly")) return t = !0, a = !0, i = !0, undefined;
                    t = !1, a = !1, i = !1;
                    var n = e.ui.keyCode;
                    switch (r.keyCode) {
                        case n.PAGE_UP:
                            t = !0, this._move("previousPage", r);
                            break;
                        case n.PAGE_DOWN:
                            t = !0, this._move("nextPage", r);
                            break;
                        case n.UP:
                            t = !0, this._keyEvent("previous", r);
                            break;
                        case n.DOWN:
                            t = !0, this._keyEvent("next", r);
                            break;
                        case n.ENTER:
                        case n.NUMPAD_ENTER:
                            this.menu.active && (t = !0, r.preventDefault(), this.menu.select(r));
                            break;
                        case n.TAB:
                            this.menu.active && this.menu.select(r);
                            break;
                        case n.ESCAPE:
                            this.menu.element.is(":visible") && (this._value(this.term), this.close(r), r.preventDefault());
                            break;
                        default:
                            i = !0, this._searchTimeout(r)
                    }
                },
                keypress: function(a) {
                    if (t) return t = !1, a.preventDefault(), undefined;
                    if (!i) {
                        var r = e.ui.keyCode;
                        switch (a.keyCode) {
                            case r.PAGE_UP:
                                this._move("previousPage", a);
                                break;
                            case r.PAGE_DOWN:
                                this._move("nextPage", a);
                                break;
                            case r.UP:
                                this._keyEvent("previous", a);
                                break;
                            case r.DOWN:
                                this._keyEvent("next", a)
                        }
                    }
                },
                input: function(e) {
                    return a ? (a = !1, e.preventDefault(), undefined) : (this._searchTimeout(e), undefined)
                },
                focus: function() {
                    this.selectedItem = null, this.previous = this._value()
                },
                blur: function(e) {
                    return this.cancelBlur ? (delete this.cancelBlur, undefined) : (clearTimeout(this.searching), this.close(e), this._change(e), undefined)
                }
            }), this._initSource(), this.menu = e("<ul>").addClass("ui-autocomplete").appendTo(this.document.find(this.options.appendTo || "body")[0]).menu({
                input: e(),
                role: null
            }).zIndex(this.element.zIndex() + 1).hide().data("menu"), this._on(this.menu.element, {
                mousedown: function(t) {
                    t.preventDefault(), this.cancelBlur = !0, this._delay(function() {
                        delete this.cancelBlur
                    });
                    var i = this.menu.element[0];
                    e(t.target).closest(".ui-menu-item").length || this._delay(function() {
                        var t = this;
                        this.document.one("mousedown", function(a) {
                            a.target === t.element[0] || a.target === i || e.contains(i, a.target) || t.close()
                        })
                    })
                },
                menufocus: function(t, i) {
                    if (this.isNewMenu && (this.isNewMenu = !1, t.originalEvent && /^mouse/.test(t.originalEvent.type))) return this.menu.blur(), this.document.one("mousemove", function() {
                        e(t.target).trigger(t.originalEvent)
                    }), undefined;
                    var a = i.item.data("ui-autocomplete-item") || i.item.data("item.autocomplete");
                    !1 !== this._trigger("focus", t, {
                        item: a
                    }) ? t.originalEvent && /^key/.test(t.originalEvent.type) && this._value(a.value) : this.liveRegion.text(a.value)
                },
                menuselect: function(e, t) {
                    var i = t.item.data("ui-autocomplete-item") || t.item.data("item.autocomplete"),
                        a = this.previous;
                    this.element[0] !== this.document[0].activeElement && (this.element.focus(), this.previous = a, this._delay(function() {
                        this.previous = a, this.selectedItem = i
                    })), !1 !== this._trigger("select", e, {
                        item: i
                    }) && this._value(i.value), this.term = this._value(), this.close(e), this.selectedItem = i
                }
            }), this.liveRegion = e("<span>", {
                role: "status",
                "aria-live": "polite"
            }).addClass("ui-helper-hidden-accessible").insertAfter(this.element), e.fn.bgiframe && this.menu.element.bgiframe(), this._on(this.window, {
                beforeunload: function() {
                    this.element.removeAttr("autocomplete")
                }
            })
        },
        _destroy: function() {
            clearTimeout(this.searching), this.element.removeClass("ui-autocomplete-input").removeAttr("autocomplete"), this.menu.element.remove(), this.liveRegion.remove()
        },
        _setOption: function(e, t) {
            this._super(e, t), "source" === e && this._initSource(), "appendTo" === e && this.menu.element.appendTo(this.document.find(t || "body")[0]), "disabled" === e && t && this.xhr && this.xhr.abort()
        },
        _isMultiLine: function() {
            return this.element.is("textarea") ? !0 : this.element.is("input") ? !1 : this.element.prop("isContentEditable")
        },
        _initSource: function() {
            var t, i, a = this;
            e.isArray(this.options.source) ? (t = this.options.source, this.source = function(i, a) {
                a(e.ui.autocomplete.filter(t, i.term))
            }) : "string" == typeof this.options.source ? (i = this.options.source, this.source = function(t, r) {
                a.xhr && a.xhr.abort(), a.xhr = e.ajax({
                    url: i,
                    data: t,
                    dataType: "json",
                    success: function(e) {
                        r(e)
                    },
                    error: function() {
                        r([])
                    }
                })
            }) : this.source = this.options.source
        },
        _searchTimeout: function(e) {
            clearTimeout(this.searching), this.searching = this._delay(function() {
                this.term !== this._value() && (this.selectedItem = null, this.search(null, e))
            }, this.options.delay)
        },
        search: function(e, t) {
            return e = null != e ? e : this._value(), this.term = this._value(), e.length < this.options.minLength ? this.close(t) : this._trigger("search", t) !== !1 ? this._search(e) : undefined
        },
        _search: function(e) {
            this.pending++, this.element.addClass("ui-autocomplete-loading"), this.cancelSearch = !1, this.source({
                term: e
            }, this._response())
        },
        _response: function() {
            var e = this,
                i = ++t;
            return function(a) {
                i === t && e.__response(a), e.pending--, e.pending || e.element.removeClass("ui-autocomplete-loading")
            }
        },
        __response: function(e) {
            e && (e = this._normalize(e)), this._trigger("response", null, {
                content: e
            }), !this.options.disabled && e && e.length && !this.cancelSearch ? (this._suggest(e), this._trigger("open")) : this._close()
        },
        close: function(e) {
            this.cancelSearch = !0, this._close(e)
        },
        _close: function(e) {
            this.menu.element.is(":visible") && (this.menu.element.hide(), this.menu.blur(), this.isNewMenu = !0, this._trigger("close", e))
        },
        _change: function(e) {
            this.previous !== this._value() && this._trigger("change", e, {
                item: this.selectedItem
            })
        },
        _normalize: function(t) {
            return t.length && t[0].label && t[0].value ? t : e.map(t, function(t) {
                return "string" == typeof t ? {
                    label: t,
                    value: t
                } : e.extend({
                    label: t.label || t.value,
                    value: t.value || t.label
                }, t)
            })
        },
        _suggest: function(t) {
            var i = this.menu.element.empty().zIndex(this.element.zIndex() + 1);
            this._renderMenu(i, t), this.menu.refresh(), i.show(), this._resizeMenu(), i.position(e.extend({
                of: this.element
            }, this.options.position)), this.options.autoFocus && this.menu.next()
        },
        _resizeMenu: function() {
            var e = this.menu.element;
            e.outerWidth(Math.max(e.width("").outerWidth() + 1, this.element.outerWidth()))
        },
        _renderMenu: function(t, i) {
            var a = this;
            e.each(i, function(e, i) {
                a._renderItemData(t, i)
            })
        },
        _renderItemData: function(e, t) {
            return this._renderItem(e, t).data("ui-autocomplete-item", t)
        },
        _renderItem: function(t, i) {
            return e("<li>").append(e("<a>").text(i.label)).appendTo(t)
        },
        _move: function(e, t) {
            return this.menu.element.is(":visible") ? this.menu.isFirstItem() && /^previous/.test(e) || this.menu.isLastItem() && /^next/.test(e) ? (this._value(this.term), this.menu.blur(), undefined) : (this.menu[e](t), undefined) : (this.search(null, t), undefined)
        },
        widget: function() {
            return this.menu.element
        },
        _value: function() {
            return this.valueMethod.apply(this.element, arguments)
        },
        _keyEvent: function(e, t) {
            (!this.isMultiLine || this.menu.element.is(":visible")) && (this._move(e, t), t.preventDefault())
        }
    }), e.extend(e.ui.autocomplete, {
        escapeRegex: function(e) {
            return e.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
        },
        filter: function(t, i) {
            var a = RegExp(e.ui.autocomplete.escapeRegex(i), "i");
            return e.grep(t, function(e) {
                return a.test(e.label || e.value || e)
            })
        }
    }), e.widget("ui.autocomplete", e.ui.autocomplete, {
        options: {
            messages: {
                noResults: "No search results.",
                results: function(e) {
                    return e + (e > 1 ? " results are" : " result is") + " available, use up and down arrow keys to navigate."
                }
            }
        },
        __response: function(e) {
            var t;
            this._superApply(arguments), this.options.disabled || this.cancelSearch || (t = e && e.length ? this.options.messages.results(e.length) : this.options.messages.noResults, this.liveRegion.text(t))
        }
    })
})(jQuery);
(function(e) {
    var t, i, a, r, n = "ui-button ui-widget ui-state-default ui-corner-all",
        s = "ui-state-hover ui-state-active ",
        o = "ui-button-icons-only ui-button-icon-only ui-button-text-icons ui-button-text-icon-primary ui-button-text-icon-secondary ui-button-text-only",
        u = function() {
            var t = e(this).find(":ui-button");
            setTimeout(function() {
                t.button("refresh")
            }, 1)
        },
        d = function(t) {
            var i = t.name,
                a = t.form,
                r = e([]);
            return i && (r = a ? e(a).find("[name='" + i + "']") : e("[name='" + i + "']", t.ownerDocument).filter(function() {
                return !this.form
            })), r
        };
    e.widget("ui.button", {
        version: "1.9.2",
        defaultElement: "<button>",
        options: {
            disabled: null,
            text: !0,
            label: null,
            icons: {
                primary: null,
                secondary: null
            }
        },
        _create: function() {
            this.element.closest("form").unbind("reset" + this.eventNamespace).bind("reset" + this.eventNamespace, u), "boolean" != typeof this.options.disabled ? this.options.disabled = !!this.element.prop("disabled") : this.element.prop("disabled", this.options.disabled), this._determineButtonType(), this.hasTitle = !!this.buttonElement.attr("title");
            var s = this,
                o = this.options,
                l = "checkbox" === this.type || "radio" === this.type,
                h = l ? "" : "ui-state-active",
                c = "ui-state-focus";
            null === o.label && (o.label = "input" === this.type ? this.buttonElement.val() : this.buttonElement.html()), this._hoverable(this.buttonElement), this.buttonElement.addClass(n).attr("role", "button").bind("mouseenter" + this.eventNamespace, function() {
                o.disabled || this === t && e(this).addClass("ui-state-active")
            }).bind("mouseleave" + this.eventNamespace, function() {
                o.disabled || e(this).removeClass(h)
            }).bind("click" + this.eventNamespace, function(e) {
                o.disabled && (e.preventDefault(), e.stopImmediatePropagation())
            }), this.element.bind("focus" + this.eventNamespace, function() {
                s.buttonElement.addClass(c)
            }).bind("blur" + this.eventNamespace, function() {
                s.buttonElement.removeClass(c)
            }), l && (this.element.bind("change" + this.eventNamespace, function() {
                r || s.refresh()
            }), this.buttonElement.bind("mousedown" + this.eventNamespace, function(e) {
                o.disabled || (r = !1, i = e.pageX, a = e.pageY)
            }).bind("mouseup" + this.eventNamespace, function(e) {
                o.disabled || (i !== e.pageX || a !== e.pageY) && (r = !0)
            })), "checkbox" === this.type ? this.buttonElement.bind("click" + this.eventNamespace, function() {
                return o.disabled || r ? !1 : (e(this).toggleClass("ui-state-active"), s.buttonElement.attr("aria-pressed", s.element[0].checked), undefined)
            }) : "radio" === this.type ? this.buttonElement.bind("click" + this.eventNamespace, function() {
                if (o.disabled || r) return !1;
                e(this).addClass("ui-state-active"), s.buttonElement.attr("aria-pressed", "true");
                var t = s.element[0];
                d(t).not(t).map(function() {
                    return e(this).button("widget")[0]
                }).removeClass("ui-state-active").attr("aria-pressed", "false")
            }) : (this.buttonElement.bind("mousedown" + this.eventNamespace, function() {
                return o.disabled ? !1 : (e(this).addClass("ui-state-active"), t = this, s.document.one("mouseup", function() {
                    t = null
                }), undefined)
            }).bind("mouseup" + this.eventNamespace, function() {
                return o.disabled ? !1 : (e(this).removeClass("ui-state-active"), undefined)
            }).bind("keydown" + this.eventNamespace, function(t) {
                return o.disabled ? !1 : ((t.keyCode === e.ui.keyCode.SPACE || t.keyCode === e.ui.keyCode.ENTER) && e(this).addClass("ui-state-active"), undefined)
            }).bind("keyup" + this.eventNamespace, function() {
                e(this).removeClass("ui-state-active")
            }), this.buttonElement.is("a") && this.buttonElement.keyup(function(t) {
                t.keyCode === e.ui.keyCode.SPACE && e(this).click()
            })), this._setOption("disabled", o.disabled), this._resetButton()
        },
        _determineButtonType: function() {
            var e, t, i;
            this.type = this.element.is("[type=checkbox]") ? "checkbox" : this.element.is("[type=radio]") ? "radio" : this.element.is("input") ? "input" : "button", "checkbox" === this.type || "radio" === this.type ? (e = this.element.parents().last(), t = "label[for='" + this.element.attr("id") + "']", this.buttonElement = e.find(t), this.buttonElement.length || (e = e.length ? e.siblings() : this.element.siblings(), this.buttonElement = e.filter(t), this.buttonElement.length || (this.buttonElement = e.find(t))), this.element.addClass("ui-helper-hidden-accessible"), i = this.element.is(":checked"), i && this.buttonElement.addClass("ui-state-active"), this.buttonElement.prop("aria-pressed", i)) : this.buttonElement = this.element
        },
        widget: function() {
            return this.buttonElement
        },
        _destroy: function() {
            this.element.removeClass("ui-helper-hidden-accessible"), this.buttonElement.removeClass(n + " " + s + " " + o).removeAttr("role").removeAttr("aria-pressed").html(this.buttonElement.find(".ui-button-text").html()), this.hasTitle || this.buttonElement.removeAttr("title")
        },
        _setOption: function(e, t) {
            return this._super(e, t), "disabled" === e ? (t ? this.element.prop("disabled", !0) : this.element.prop("disabled", !1), undefined) : (this._resetButton(), undefined)
        },
        refresh: function() {
            var t = this.element.is("input, button") ? this.element.is(":disabled") : this.element.hasClass("ui-button-disabled");
            t !== this.options.disabled && this._setOption("disabled", t), "radio" === this.type ? d(this.element[0]).each(function() {
                e(this).is(":checked") ? e(this).button("widget").addClass("ui-state-active").attr("aria-pressed", "true") : e(this).button("widget").removeClass("ui-state-active").attr("aria-pressed", "false")
            }) : "checkbox" === this.type && (this.element.is(":checked") ? this.buttonElement.addClass("ui-state-active").attr("aria-pressed", "true") : this.buttonElement.removeClass("ui-state-active").attr("aria-pressed", "false"))
        },
        _resetButton: function() {
            if ("input" === this.type) return this.options.label && this.element.val(this.options.label), undefined;
            var t = this.buttonElement.removeClass(o),
                i = e("<span></span>", this.document[0]).addClass("ui-button-text").html(this.options.label).appendTo(t.empty()).text(),
                a = this.options.icons,
                r = a.primary && a.secondary,
                n = [];
            a.primary || a.secondary ? (this.options.text && n.push("ui-button-text-icon" + (r ? "s" : a.primary ? "-primary" : "-secondary")), a.primary && t.prepend("<span class='ui-button-icon-primary ui-icon " + a.primary + "'></span>"), a.secondary && t.append("<span class='ui-button-icon-secondary ui-icon " + a.secondary + "'></span>"), this.options.text || (n.push(r ? "ui-button-icons-only" : "ui-button-icon-only"), this.hasTitle || t.attr("title", e.trim(i)))) : n.push("ui-button-text-only"), t.addClass(n.join(" "))
        }
    }), e.widget("ui.buttonset", {
        version: "1.9.2",
        options: {
            items: "button, input[type=button], input[type=submit], input[type=reset], input[type=checkbox], input[type=radio], a, :data(button)"
        },
        _create: function() {
            this.element.addClass("ui-buttonset")
        },
        _init: function() {
            this.refresh()
        },
        _setOption: function(e, t) {
            "disabled" === e && this.buttons.button("option", e, t), this._super(e, t)
        },
        refresh: function() {
            var t = "rtl" === this.element.css("direction");
            this.buttons = this.element.find(this.options.items).filter(":ui-button").button("refresh").end().not(":ui-button").button().end().map(function() {
                return e(this).button("widget")[0]
            }).removeClass("ui-corner-all ui-corner-left ui-corner-right").filter(":first").addClass(t ? "ui-corner-right" : "ui-corner-left").end().filter(":last").addClass(t ? "ui-corner-left" : "ui-corner-right").end().end()
        },
        _destroy: function() {
            this.element.removeClass("ui-buttonset"), this.buttons.map(function() {
                return e(this).button("widget")[0]
            }).removeClass("ui-corner-left ui-corner-right").end().button("destroy")
        }
    })
})(jQuery);
(function($, undefined) {
    function Datepicker() {
        this.debug = !1, this._curInst = null, this._keyEvent = !1, this._disabledInputs = [], this._datepickerShowing = !1, this._inDialog = !1, this._mainDivId = "ui-datepicker-div", this._inlineClass = "ui-datepicker-inline", this._appendClass = "ui-datepicker-append", this._triggerClass = "ui-datepicker-trigger", this._dialogClass = "ui-datepicker-dialog", this._disableClass = "ui-datepicker-disabled", this._unselectableClass = "ui-datepicker-unselectable", this._currentClass = "ui-datepicker-current-day", this._dayOverClass = "ui-datepicker-days-cell-over", this.regional = [], this.regional[""] = {
            closeText: "Done",
            prevText: "Prev",
            nextText: "Next",
            currentText: "Today",
            monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            dayNamesShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            dayNamesMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
            weekHeader: "Wk",
            dateFormat: "mm/dd/yy",
            firstDay: 0,
            isRTL: !1,
            showMonthAfterYear: !1,
            yearSuffix: ""
        }, this._defaults = {
            showOn: "focus",
            showAnim: "fadeIn",
            showOptions: {},
            defaultDate: null,
            appendText: "",
            buttonText: "...",
            buttonImage: "",
            buttonImageOnly: !1,
            hideIfNoPrevNext: !1,
            navigationAsDateFormat: !1,
            gotoCurrent: !1,
            changeMonth: !1,
            changeYear: !1,
            yearRange: "c-10:c+10",
            showOtherMonths: !1,
            selectOtherMonths: !1,
            showWeek: !1,
            calculateWeek: this.iso8601Week,
            shortYearCutoff: "+10",
            minDate: null,
            maxDate: null,
            duration: "fast",
            beforeShowDay: null,
            beforeShow: null,
            onSelect: null,
            onChangeMonthYear: null,
            onClose: null,
            numberOfMonths: 1,
            showCurrentAtPos: 0,
            stepMonths: 1,
            stepBigMonths: 12,
            altField: "",
            altFormat: "",
            constrainInput: !0,
            showButtonPanel: !1,
            autoSize: !1,
            disabled: !1
        }, $.extend(this._defaults, this.regional[""]), this.dpDiv = bindHover($('<div id="' + this._mainDivId + '" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>'))
    }

    function bindHover(e) {
        var t = "button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a";
        return e.delegate(t, "mouseout", function() {
            $(this).removeClass("ui-state-hover"), -1 != this.className.indexOf("ui-datepicker-prev") && $(this).removeClass("ui-datepicker-prev-hover"), -1 != this.className.indexOf("ui-datepicker-next") && $(this).removeClass("ui-datepicker-next-hover")
        }).delegate(t, "mouseover", function() {
            $.datepicker._isDisabledDatepicker(instActive.inline ? e.parent()[0] : instActive.input[0]) || ($(this).parents(".ui-datepicker-calendar").find("a").removeClass("ui-state-hover"), $(this).addClass("ui-state-hover"), -1 != this.className.indexOf("ui-datepicker-prev") && $(this).addClass("ui-datepicker-prev-hover"), -1 != this.className.indexOf("ui-datepicker-next") && $(this).addClass("ui-datepicker-next-hover"))
        })
    }

    function extendRemove(e, t) {
        $.extend(e, t);
        for (var i in t)(null == t[i] || t[i] == undefined) && (e[i] = t[i]);
        return e
    }
    $.extend($.ui, {
        datepicker: {
            version: "1.9.2"
        }
    });
    var PROP_NAME = "datepicker",
        dpuuid = (new Date).getTime(),
        instActive;
    $.extend(Datepicker.prototype, {
        markerClassName: "hasDatepicker",
        maxRows: 4,
        log: function() {
            this.debug && console.log.apply("", arguments)
        },
        _widgetDatepicker: function() {
            return this.dpDiv
        },
        setDefaults: function(e) {
            return extendRemove(this._defaults, e || {}), this
        },
        _attachDatepicker: function(target, settings) {
            var inlineSettings = null;
            for (var attrName in this._defaults) {
                var attrValue = target.getAttribute("date:" + attrName);
                if (attrValue) {
                    inlineSettings = inlineSettings || {};
                    try {
                        inlineSettings[attrName] = eval(attrValue)
                    } catch (err) {
                        inlineSettings[attrName] = attrValue
                    }
                }
            }
            var nodeName = target.nodeName.toLowerCase(),
                inline = "div" == nodeName || "span" == nodeName;
            target.id || (this.uuid += 1, target.id = "dp" + this.uuid);
            var inst = this._newInst($(target), inline);
            inst.settings = $.extend({}, settings || {}, inlineSettings || {}), "input" == nodeName ? this._connectDatepicker(target, inst) : inline && this._inlineDatepicker(target, inst)
        },
        _newInst: function(e, t) {
            var i = e[0].id.replace(/([^A-Za-z0-9_-])/g, "\\\\$1");
            return {
                id: i,
                input: e,
                selectedDay: 0,
                selectedMonth: 0,
                selectedYear: 0,
                drawMonth: 0,
                drawYear: 0,
                inline: t,
                dpDiv: t ? bindHover($('<div class="' + this._inlineClass + ' ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>')) : this.dpDiv
            }
        },
        _connectDatepicker: function(e, t) {
            var i = $(e);
            t.append = $([]), t.trigger = $([]), i.hasClass(this.markerClassName) || (this._attachments(i, t), i.addClass(this.markerClassName).keydown(this._doKeyDown).keypress(this._doKeyPress).keyup(this._doKeyUp).bind("setData.datepicker", function(e, i, a) {
                t.settings[i] = a
            }).bind("getData.datepicker", function(e, i) {
                return this._get(t, i)
            }), this._autoSize(t), $.data(e, PROP_NAME, t), t.settings.disabled && this._disableDatepicker(e))
        },
        _attachments: function(e, t) {
            var i = this._get(t, "appendText"),
                a = this._get(t, "isRTL");
            t.append && t.append.remove(), i && (t.append = $('<span class="' + this._appendClass + '">' + i + "</span>"), e[a ? "before" : "after"](t.append)), e.unbind("focus", this._showDatepicker), t.trigger && t.trigger.remove();
            var r = this._get(t, "showOn");
            if (("focus" == r || "both" == r) && e.focus(this._showDatepicker), "button" == r || "both" == r) {
                var n = this._get(t, "buttonText"),
                    s = this._get(t, "buttonImage");
                t.trigger = $(this._get(t, "buttonImageOnly") ? $("<img/>").addClass(this._triggerClass).attr({
                    src: s,
                    alt: n,
                    title: n
                }) : $('<button type="button"></button>').addClass(this._triggerClass).html("" == s ? n : $("<img/>").attr({
                    src: s,
                    alt: n,
                    title: n
                }))), e[a ? "before" : "after"](t.trigger), t.trigger.click(function() {
                    return $.datepicker._datepickerShowing && $.datepicker._lastInput == e[0] ? $.datepicker._hideDatepicker() : $.datepicker._datepickerShowing && $.datepicker._lastInput != e[0] ? ($.datepicker._hideDatepicker(), $.datepicker._showDatepicker(e[0])) : $.datepicker._showDatepicker(e[0]), !1
                })
            }
        },
        _autoSize: function(e) {
            if (this._get(e, "autoSize") && !e.inline) {
                var t = new Date(2009, 11, 20),
                    i = this._get(e, "dateFormat");
                if (i.match(/[DM]/)) {
                    var a = function(e) {
                        for (var t = 0, i = 0, a = 0; e.length > a; a++) e[a].length > t && (t = e[a].length, i = a);
                        return i
                    };
                    t.setMonth(a(this._get(e, i.match(/MM/) ? "monthNames" : "monthNamesShort"))), t.setDate(a(this._get(e, i.match(/DD/) ? "dayNames" : "dayNamesShort")) + 20 - t.getDay())
                }
                e.input.attr("size", this._formatDate(e, t).length)
            }
        },
        _inlineDatepicker: function(e, t) {
            var i = $(e);
            i.hasClass(this.markerClassName) || (i.addClass(this.markerClassName).append(t.dpDiv).bind("setData.datepicker", function(e, i, a) {
                t.settings[i] = a
            }).bind("getData.datepicker", function(e, i) {
                return this._get(t, i)
            }), $.data(e, PROP_NAME, t), this._setDate(t, this._getDefaultDate(t), !0), this._updateDatepicker(t), this._updateAlternate(t), t.settings.disabled && this._disableDatepicker(e), t.dpDiv.css("display", "block"))
        },
        _dialogDatepicker: function(e, t, i, a, r) {
            var n = this._dialogInst;
            if (!n) {
                this.uuid += 1;
                var s = "dp" + this.uuid;
                this._dialogInput = $('<input type="text" id="' + s + '" style="position: absolute; top: -100px; width: 0px;"/>'), this._dialogInput.keydown(this._doKeyDown), $("body").append(this._dialogInput), n = this._dialogInst = this._newInst(this._dialogInput, !1), n.settings = {}, $.data(this._dialogInput[0], PROP_NAME, n)
            }
            if (extendRemove(n.settings, a || {}), t = t && t.constructor == Date ? this._formatDate(n, t) : t, this._dialogInput.val(t), this._pos = r ? r.length ? r : [r.pageX, r.pageY] : null, !this._pos) {
                var o = document.documentElement.clientWidth,
                    u = document.documentElement.clientHeight,
                    d = document.documentElement.scrollLeft || document.body.scrollLeft,
                    l = document.documentElement.scrollTop || document.body.scrollTop;
                this._pos = [o / 2 - 100 + d, u / 2 - 150 + l]
            }
            return this._dialogInput.css("left", this._pos[0] + 20 + "px").css("top", this._pos[1] + "px"), n.settings.onSelect = i, this._inDialog = !0, this.dpDiv.addClass(this._dialogClass), this._showDatepicker(this._dialogInput[0]), $.blockUI && $.blockUI(this.dpDiv), $.data(this._dialogInput[0], PROP_NAME, n), this
        },
        _destroyDatepicker: function(e) {
            var t = $(e),
                i = $.data(e, PROP_NAME);
            if (t.hasClass(this.markerClassName)) {
                var a = e.nodeName.toLowerCase();
                $.removeData(e, PROP_NAME), "input" == a ? (i.append.remove(), i.trigger.remove(), t.removeClass(this.markerClassName).unbind("focus", this._showDatepicker).unbind("keydown", this._doKeyDown).unbind("keypress", this._doKeyPress).unbind("keyup", this._doKeyUp)) : ("div" == a || "span" == a) && t.removeClass(this.markerClassName).empty()
            }
        },
        _enableDatepicker: function(e) {
            var t = $(e),
                i = $.data(e, PROP_NAME);
            if (t.hasClass(this.markerClassName)) {
                var a = e.nodeName.toLowerCase();
                if ("input" == a) e.disabled = !1, i.trigger.filter("button").each(function() {
                    this.disabled = !1
                }).end().filter("img").css({
                    opacity: "1.0",
                    cursor: ""
                });
                else if ("div" == a || "span" == a) {
                    var r = t.children("." + this._inlineClass);
                    r.children().removeClass("ui-state-disabled"), r.find("select.ui-datepicker-month, select.ui-datepicker-year").prop("disabled", !1)
                }
                this._disabledInputs = $.map(this._disabledInputs, function(t) {
                    return t == e ? null : t
                })
            }
        },
        _disableDatepicker: function(e) {
            var t = $(e),
                i = $.data(e, PROP_NAME);
            if (t.hasClass(this.markerClassName)) {
                var a = e.nodeName.toLowerCase();
                if ("input" == a) e.disabled = !0, i.trigger.filter("button").each(function() {
                    this.disabled = !0
                }).end().filter("img").css({
                    opacity: "0.5",
                    cursor: "default"
                });
                else if ("div" == a || "span" == a) {
                    var r = t.children("." + this._inlineClass);
                    r.children().addClass("ui-state-disabled"), r.find("select.ui-datepicker-month, select.ui-datepicker-year").prop("disabled", !0)
                }
                this._disabledInputs = $.map(this._disabledInputs, function(t) {
                    return t == e ? null : t
                }), this._disabledInputs[this._disabledInputs.length] = e
            }
        },
        _isDisabledDatepicker: function(e) {
            if (!e) return !1;
            for (var t = 0; this._disabledInputs.length > t; t++)
                if (this._disabledInputs[t] == e) return !0;
            return !1
        },
        _getInst: function(e) {
            try {
                return $.data(e, PROP_NAME)
            } catch (t) {
                throw "Missing instance data for this datepicker"
            }
        },
        _optionDatepicker: function(e, t, i) {
            var a = this._getInst(e);
            if (2 == arguments.length && "string" == typeof t) return "defaults" == t ? $.extend({}, $.datepicker._defaults) : a ? "all" == t ? $.extend({}, a.settings) : this._get(a, t) : null;
            var r = t || {};
            if ("string" == typeof t && (r = {}, r[t] = i), a) {
                this._curInst == a && this._hideDatepicker();
                var n = this._getDateDatepicker(e, !0),
                    s = this._getMinMaxDate(a, "min"),
                    o = this._getMinMaxDate(a, "max");
                extendRemove(a.settings, r), null !== s && r.dateFormat !== undefined && r.minDate === undefined && (a.settings.minDate = this._formatDate(a, s)), null !== o && r.dateFormat !== undefined && r.maxDate === undefined && (a.settings.maxDate = this._formatDate(a, o)), this._attachments($(e), a), this._autoSize(a), this._setDate(a, n), this._updateAlternate(a), this._updateDatepicker(a)
            }
        },
        _changeDatepicker: function(e, t, i) {
            this._optionDatepicker(e, t, i)
        },
        _refreshDatepicker: function(e) {
            var t = this._getInst(e);
            t && this._updateDatepicker(t)
        },
        _setDateDatepicker: function(e, t) {
            var i = this._getInst(e);
            i && (this._setDate(i, t), this._updateDatepicker(i), this._updateAlternate(i))
        },
        _getDateDatepicker: function(e, t) {
            var i = this._getInst(e);
            return i && !i.inline && this._setDateFromField(i, t), i ? this._getDate(i) : null
        },
        _doKeyDown: function(e) {
            var t = $.datepicker._getInst(e.target),
                i = !0,
                a = t.dpDiv.is(".ui-datepicker-rtl");
            if (t._keyEvent = !0, $.datepicker._datepickerShowing) switch (e.keyCode) {
                case 9:
                    $.datepicker._hideDatepicker(), i = !1;
                    break;
                case 13:
                    var r = $("td." + $.datepicker._dayOverClass + ":not(." + $.datepicker._currentClass + ")", t.dpDiv);
                    r[0] && $.datepicker._selectDay(e.target, t.selectedMonth, t.selectedYear, r[0]);
                    var n = $.datepicker._get(t, "onSelect");
                    if (n) {
                        var s = $.datepicker._formatDate(t);
                        n.apply(t.input ? t.input[0] : null, [s, t])
                    } else $.datepicker._hideDatepicker();
                    return !1;
                case 27:
                    $.datepicker._hideDatepicker();
                    break;
                case 33:
                    $.datepicker._adjustDate(e.target, e.ctrlKey ? -$.datepicker._get(t, "stepBigMonths") : -$.datepicker._get(t, "stepMonths"), "M");
                    break;
                case 34:
                    $.datepicker._adjustDate(e.target, e.ctrlKey ? +$.datepicker._get(t, "stepBigMonths") : +$.datepicker._get(t, "stepMonths"), "M");
                    break;
                case 35:
                    (e.ctrlKey || e.metaKey) && $.datepicker._clearDate(e.target), i = e.ctrlKey || e.metaKey;
                    break;
                case 36:
                    (e.ctrlKey || e.metaKey) && $.datepicker._gotoToday(e.target), i = e.ctrlKey || e.metaKey;
                    break;
                case 37:
                    (e.ctrlKey || e.metaKey) && $.datepicker._adjustDate(e.target, a ? 1 : -1, "D"), i = e.ctrlKey || e.metaKey, e.originalEvent.altKey && $.datepicker._adjustDate(e.target, e.ctrlKey ? -$.datepicker._get(t, "stepBigMonths") : -$.datepicker._get(t, "stepMonths"), "M");
                    break;
                case 38:
                    (e.ctrlKey || e.metaKey) && $.datepicker._adjustDate(e.target, -7, "D"), i = e.ctrlKey || e.metaKey;
                    break;
                case 39:
                    (e.ctrlKey || e.metaKey) && $.datepicker._adjustDate(e.target, a ? -1 : 1, "D"), i = e.ctrlKey || e.metaKey, e.originalEvent.altKey && $.datepicker._adjustDate(e.target, e.ctrlKey ? +$.datepicker._get(t, "stepBigMonths") : +$.datepicker._get(t, "stepMonths"), "M");
                    break;
                case 40:
                    (e.ctrlKey || e.metaKey) && $.datepicker._adjustDate(e.target, 7, "D"), i = e.ctrlKey || e.metaKey;
                    break;
                default:
                    i = !1
            } else 36 == e.keyCode && e.ctrlKey ? $.datepicker._showDatepicker(this) : i = !1;
            i && (e.preventDefault(), e.stopPropagation())
        },
        _doKeyPress: function(e) {
            var t = $.datepicker._getInst(e.target);
            if ($.datepicker._get(t, "constrainInput")) {
                var i = $.datepicker._possibleChars($.datepicker._get(t, "dateFormat")),
                    a = String.fromCharCode(e.charCode == undefined ? e.keyCode : e.charCode);
                return e.ctrlKey || e.metaKey || " " > a || !i || i.indexOf(a) > -1
            }
        },
        _doKeyUp: function(e) {
            var t = $.datepicker._getInst(e.target);
            if (t.input.val() != t.lastVal) try {
                var i = $.datepicker.parseDate($.datepicker._get(t, "dateFormat"), t.input ? t.input.val() : null, $.datepicker._getFormatConfig(t));
                i && ($.datepicker._setDateFromField(t), $.datepicker._updateAlternate(t), $.datepicker._updateDatepicker(t))
            } catch (a) {
                $.datepicker.log(a)
            }
            return !0
        },
        _showDatepicker: function(e) {
            if (e = e.target || e, "input" != e.nodeName.toLowerCase() && (e = $("input", e.parentNode)[0]), !$.datepicker._isDisabledDatepicker(e) && $.datepicker._lastInput != e) {
                var t = $.datepicker._getInst(e);
                $.datepicker._curInst && $.datepicker._curInst != t && ($.datepicker._curInst.dpDiv.stop(!0, !0), t && $.datepicker._datepickerShowing && $.datepicker._hideDatepicker($.datepicker._curInst.input[0]));
                var i = $.datepicker._get(t, "beforeShow"),
                    a = i ? i.apply(e, [e, t]) : {};
                if (a !== !1) {
                    extendRemove(t.settings, a), t.lastVal = null, $.datepicker._lastInput = e, $.datepicker._setDateFromField(t), $.datepicker._inDialog && (e.value = ""), $.datepicker._pos || ($.datepicker._pos = $.datepicker._findPos(e), $.datepicker._pos[1] += e.offsetHeight);
                    var r = !1;
                    $(e).parents().each(function() {
                        return r |= "fixed" == $(this).css("position"), !r
                    });
                    var n = {
                        left: $.datepicker._pos[0],
                        top: $.datepicker._pos[1]
                    };
                    if ($.datepicker._pos = null, t.dpDiv.empty(), t.dpDiv.css({
                            position: "absolute",
                            display: "block",
                            top: "-1000px"
                        }), $.datepicker._updateDatepicker(t), n = $.datepicker._checkOffset(t, n, r), t.dpDiv.css({
                            position: $.datepicker._inDialog && $.blockUI ? "static" : r ? "fixed" : "absolute",
                            display: "none",
                            left: n.left + "px",
                            top: n.top + "px"
                        }), !t.inline) {
                        var s = $.datepicker._get(t, "showAnim"),
                            o = $.datepicker._get(t, "duration"),
                            u = function() {
                                var e = t.dpDiv.find("iframe.ui-datepicker-cover");
                                if (e.length) {
                                    var i = $.datepicker._getBorders(t.dpDiv);
                                    e.css({
                                        left: -i[0],
                                        top: -i[1],
                                        width: t.dpDiv.outerWidth(),
                                        height: t.dpDiv.outerHeight()
                                    })
                                }
                            };
                        t.dpDiv.zIndex($(e).zIndex() + 1), $.datepicker._datepickerShowing = !0, $.effects && ($.effects.effect[s] || $.effects[s]) ? t.dpDiv.show(s, $.datepicker._get(t, "showOptions"), o, u) : t.dpDiv[s || "show"](s ? o : null, u), s && o || u(), t.input.is(":visible") && !t.input.is(":disabled") && t.input.focus(), $.datepicker._curInst = t
                    }
                }
            }
        },
        _updateDatepicker: function(e) {
            this.maxRows = 4;
            var t = $.datepicker._getBorders(e.dpDiv);
            instActive = e, e.dpDiv.empty().append(this._generateHTML(e)), this._attachHandlers(e);
            var i = e.dpDiv.find("iframe.ui-datepicker-cover");
            i.length && i.css({
                left: -t[0],
                top: -t[1],
                width: e.dpDiv.outerWidth(),
                height: e.dpDiv.outerHeight()
            }), e.dpDiv.find("." + this._dayOverClass + " a").mouseover();
            var a = this._getNumberOfMonths(e),
                r = a[1],
                n = 17;
            if (e.dpDiv.removeClass("ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4").width(""), r > 1 && e.dpDiv.addClass("ui-datepicker-multi-" + r).css("width", n * r + "em"), e.dpDiv[(1 != a[0] || 1 != a[1] ? "add" : "remove") + "Class"]("ui-datepicker-multi"), e.dpDiv[(this._get(e, "isRTL") ? "add" : "remove") + "Class"]("ui-datepicker-rtl"), e == $.datepicker._curInst && $.datepicker._datepickerShowing && e.input && e.input.is(":visible") && !e.input.is(":disabled") && e.input[0] != document.activeElement && e.input.focus(), e.yearshtml) {
                var s = e.yearshtml;
                setTimeout(function() {
                    s === e.yearshtml && e.yearshtml && e.dpDiv.find("select.ui-datepicker-year:first").replaceWith(e.yearshtml), s = e.yearshtml = null
                }, 0)
            }
        },
        _getBorders: function(e) {
            var t = function(e) {
                return {
                    thin: 1,
                    medium: 2,
                    thick: 3
                }[e] || e
            };
            return [parseFloat(t(e.css("border-left-width"))), parseFloat(t(e.css("border-top-width")))]
        },
        _checkOffset: function(e, t, i) {
            var a = e.dpDiv.outerWidth(),
                r = e.dpDiv.outerHeight(),
                n = e.input ? e.input.outerWidth() : 0,
                s = e.input ? e.input.outerHeight() : 0,
                o = document.documentElement.clientWidth + (i ? 0 : $(document).scrollLeft()),
                u = document.documentElement.clientHeight + (i ? 0 : $(document).scrollTop());
            return t.left -= this._get(e, "isRTL") ? a - n : 0, t.left -= i && t.left == e.input.offset().left ? $(document).scrollLeft() : 0, t.top -= i && t.top == e.input.offset().top + s ? $(document).scrollTop() : 0, t.left -= Math.min(t.left, t.left + a > o && o > a ? Math.abs(t.left + a - o) : 0), t.top -= Math.min(t.top, t.top + r > u && u > r ? Math.abs(r + s) : 0), t
        },
        _findPos: function(e) {
            for (var t = this._getInst(e), i = this._get(t, "isRTL"); e && ("hidden" == e.type || 1 != e.nodeType || $.expr.filters.hidden(e));) e = e[i ? "previousSibling" : "nextSibling"];
            var a = $(e).offset();
            return [a.left, a.top]
        },
        _hideDatepicker: function(e) {
            var t = this._curInst;
            if (t && (!e || t == $.data(e, PROP_NAME)) && this._datepickerShowing) {
                var i = this._get(t, "showAnim"),
                    a = this._get(t, "duration"),
                    r = function() {
                        $.datepicker._tidyDialog(t)
                    };
                $.effects && ($.effects.effect[i] || $.effects[i]) ? t.dpDiv.hide(i, $.datepicker._get(t, "showOptions"), a, r) : t.dpDiv["slideDown" == i ? "slideUp" : "fadeIn" == i ? "fadeOut" : "hide"](i ? a : null, r), i || r(), this._datepickerShowing = !1;
                var n = this._get(t, "onClose");
                n && n.apply(t.input ? t.input[0] : null, [t.input ? t.input.val() : "", t]), this._lastInput = null, this._inDialog && (this._dialogInput.css({
                    position: "absolute",
                    left: "0",
                    top: "-100px"
                }), $.blockUI && ($.unblockUI(), $("body").append(this.dpDiv))), this._inDialog = !1
            }
        },
        _tidyDialog: function(e) {
            e.dpDiv.removeClass(this._dialogClass).unbind(".ui-datepicker-calendar")
        },
        _checkExternalClick: function(e) {
            if ($.datepicker._curInst) {
                var t = $(e.target),
                    i = $.datepicker._getInst(t[0]);
                (t[0].id != $.datepicker._mainDivId && 0 == t.parents("#" + $.datepicker._mainDivId).length && !t.hasClass($.datepicker.markerClassName) && !t.closest("." + $.datepicker._triggerClass).length && $.datepicker._datepickerShowing && (!$.datepicker._inDialog || !$.blockUI) || t.hasClass($.datepicker.markerClassName) && $.datepicker._curInst != i) && $.datepicker._hideDatepicker()
            }
        },
        _adjustDate: function(e, t, i) {
            var a = $(e),
                r = this._getInst(a[0]);
            this._isDisabledDatepicker(a[0]) || (this._adjustInstDate(r, t + ("M" == i ? this._get(r, "showCurrentAtPos") : 0), i), this._updateDatepicker(r))
        },
        _gotoToday: function(e) {
            var t = $(e),
                i = this._getInst(t[0]);
            if (this._get(i, "gotoCurrent") && i.currentDay) i.selectedDay = i.currentDay, i.drawMonth = i.selectedMonth = i.currentMonth, i.drawYear = i.selectedYear = i.currentYear;
            else {
                var a = new Date;
                i.selectedDay = a.getDate(), i.drawMonth = i.selectedMonth = a.getMonth(), i.drawYear = i.selectedYear = a.getFullYear()
            }
            this._notifyChange(i), this._adjustDate(t)
        },
        _selectMonthYear: function(e, t, i) {
            var a = $(e),
                r = this._getInst(a[0]);
            r["selected" + ("M" == i ? "Month" : "Year")] = r["draw" + ("M" == i ? "Month" : "Year")] = parseInt(t.options[t.selectedIndex].value, 10), this._notifyChange(r), this._adjustDate(a)
        },
        _selectDay: function(e, t, i, a) {
            var r = $(e);
            if (!$(a).hasClass(this._unselectableClass) && !this._isDisabledDatepicker(r[0])) {
                var n = this._getInst(r[0]);
                n.selectedDay = n.currentDay = $("a", a).html(), n.selectedMonth = n.currentMonth = t, n.selectedYear = n.currentYear = i, this._selectDate(e, this._formatDate(n, n.currentDay, n.currentMonth, n.currentYear))
            }
        },
        _clearDate: function(e) {
            var t = $(e);
            this._getInst(t[0]), this._selectDate(t, "")
        },
        _selectDate: function(e, t) {
            var i = $(e),
                a = this._getInst(i[0]);
            t = null != t ? t : this._formatDate(a), a.input && a.input.val(t), this._updateAlternate(a);
            var r = this._get(a, "onSelect");
            r ? r.apply(a.input ? a.input[0] : null, [t, a]) : a.input && a.input.trigger("change"), a.inline ? this._updateDatepicker(a) : (this._hideDatepicker(), this._lastInput = a.input[0], "object" != typeof a.input[0] && a.input.focus(), this._lastInput = null)
        },
        _updateAlternate: function(e) {
            var t = this._get(e, "altField");
            if (t) {
                var i = this._get(e, "altFormat") || this._get(e, "dateFormat"),
                    a = this._getDate(e),
                    r = this.formatDate(i, a, this._getFormatConfig(e));
                $(t).each(function() {
                    $(this).val(r)
                })
            }
        },
        noWeekends: function(e) {
            var t = e.getDay();
            return [t > 0 && 6 > t, ""]
        },
        iso8601Week: function(e) {
            var t = new Date(e.getTime());
            t.setDate(t.getDate() + 4 - (t.getDay() || 7));
            var i = t.getTime();
            return t.setMonth(0), t.setDate(1), Math.floor(Math.round((i - t) / 864e5) / 7) + 1
        },
        parseDate: function(e, t, i) {
            if (null == e || null == t) throw "Invalid arguments";
            if (t = "object" == typeof t ? "" + t : t + "", "" == t) return null;
            var a = (i ? i.shortYearCutoff : null) || this._defaults.shortYearCutoff;
            a = "string" != typeof a ? a : (new Date).getFullYear() % 100 + parseInt(a, 10);
            for (var r = (i ? i.dayNamesShort : null) || this._defaults.dayNamesShort, n = (i ? i.dayNames : null) || this._defaults.dayNames, s = (i ? i.monthNamesShort : null) || this._defaults.monthNamesShort, o = (i ? i.monthNames : null) || this._defaults.monthNames, u = -1, d = -1, l = -1, h = -1, c = !1, m = function(t) {
                    var i = e.length > v + 1 && e.charAt(v + 1) == t;
                    return i && v++, i
                }, p = function(e) {
                    var i = m(e),
                        a = "@" == e ? 14 : "!" == e ? 20 : "y" == e && i ? 4 : "o" == e ? 3 : 2,
                        r = RegExp("^\\d{1," + a + "}"),
                        n = t.substring(y).match(r);
                    if (!n) throw "Missing number at position " + y;
                    return y += n[0].length, parseInt(n[0], 10)
                }, f = function(e, i, a) {
                    var r = $.map(m(e) ? a : i, function(e, t) {
                            return [
                                [t, e]
                            ]
                        }).sort(function(e, t) {
                            return -(e[1].length - t[1].length)
                        }),
                        n = -1;
                    if ($.each(r, function(e, i) {
                            var a = i[1];
                            return t.substr(y, a.length).toLowerCase() == a.toLowerCase() ? (n = i[0], y += a.length, !1) : undefined
                        }), -1 != n) return n + 1;
                    throw "Unknown name at position " + y
                }, g = function() {
                    if (t.charAt(y) != e.charAt(v)) throw "Unexpected literal at position " + y;
                    y++
                }, y = 0, v = 0; e.length > v; v++)
                if (c) "'" != e.charAt(v) || m("'") ? g() : c = !1;
                else switch (e.charAt(v)) {
                    case "d":
                        l = p("d");
                        break;
                    case "D":
                        f("D", r, n);
                        break;
                    case "o":
                        h = p("o");
                        break;
                    case "m":
                        d = p("m");
                        break;
                    case "M":
                        d = f("M", s, o);
                        break;
                    case "y":
                        u = p("y");
                        break;
                    case "@":
                        var b = new Date(p("@"));
                        u = b.getFullYear(), d = b.getMonth() + 1, l = b.getDate();
                        break;
                    case "!":
                        var b = new Date((p("!") - this._ticksTo1970) / 1e4);
                        u = b.getFullYear(), d = b.getMonth() + 1, l = b.getDate();
                        break;
                    case "'":
                        m("'") ? g() : c = !0;
                        break;
                    default:
                        g()
                }
                if (t.length > y) {
                    var x = t.substr(y);
                    if (!/^\s+/.test(x)) throw "Extra/unparsed characters found in date: " + x
                }
            if (-1 == u ? u = (new Date).getFullYear() : 100 > u && (u += (new Date).getFullYear() - (new Date).getFullYear() % 100 + (a >= u ? 0 : -100)), h > -1)
                for (d = 1, l = h;;) {
                    var k = this._getDaysInMonth(u, d - 1);
                    if (k >= l) break;
                    d++, l -= k
                }
            var b = this._daylightSavingAdjust(new Date(u, d - 1, l));
            if (b.getFullYear() != u || b.getMonth() + 1 != d || b.getDate() != l) throw "Invalid date";
            return b
        },
        ATOM: "yy-mm-dd",
        COOKIE: "D, dd M yy",
        ISO_8601: "yy-mm-dd",
        RFC_822: "D, d M y",
        RFC_850: "DD, dd-M-y",
        RFC_1036: "D, d M y",
        RFC_1123: "D, d M yy",
        RFC_2822: "D, d M yy",
        RSS: "D, d M y",
        TICKS: "!",
        TIMESTAMP: "@",
        W3C: "yy-mm-dd",
        _ticksTo1970: 1e7 * 60 * 60 * 24 * (718685 + Math.floor(492.5) - Math.floor(19.7) + Math.floor(4.925)),
        formatDate: function(e, t, i) {
            if (!t) return "";
            var a = (i ? i.dayNamesShort : null) || this._defaults.dayNamesShort,
                r = (i ? i.dayNames : null) || this._defaults.dayNames,
                n = (i ? i.monthNamesShort : null) || this._defaults.monthNamesShort,
                s = (i ? i.monthNames : null) || this._defaults.monthNames,
                o = function(t) {
                    var i = e.length > c + 1 && e.charAt(c + 1) == t;
                    return i && c++, i
                },
                u = function(e, t, i) {
                    var a = "" + t;
                    if (o(e))
                        for (; i > a.length;) a = "0" + a;
                    return a
                },
                d = function(e, t, i, a) {
                    return o(e) ? a[t] : i[t]
                },
                l = "",
                h = !1;
            if (t)
                for (var c = 0; e.length > c; c++)
                    if (h) "'" != e.charAt(c) || o("'") ? l += e.charAt(c) : h = !1;
                    else switch (e.charAt(c)) {
                        case "d":
                            l += u("d", t.getDate(), 2);
                            break;
                        case "D":
                            l += d("D", t.getDay(), a, r);
                            break;
                        case "o":
                            l += u("o", Math.round((new Date(t.getFullYear(), t.getMonth(), t.getDate()).getTime() - new Date(t.getFullYear(), 0, 0).getTime()) / 864e5), 3);
                            break;
                        case "m":
                            l += u("m", t.getMonth() + 1, 2);
                            break;
                        case "M":
                            l += d("M", t.getMonth(), n, s);
                            break;
                        case "y":
                            l += o("y") ? t.getFullYear() : (10 > t.getYear() % 100 ? "0" : "") + t.getYear() % 100;
                            break;
                        case "@":
                            l += t.getTime();
                            break;
                        case "!":
                            l += 1e4 * t.getTime() + this._ticksTo1970;
                            break;
                        case "'":
                            o("'") ? l += "'" : h = !0;
                            break;
                        default:
                            l += e.charAt(c)
                    }
                    return l
        },
        _possibleChars: function(e) {
            for (var t = "", i = !1, a = function(t) {
                    var i = e.length > r + 1 && e.charAt(r + 1) == t;
                    return i && r++, i
                }, r = 0; e.length > r; r++)
                if (i) "'" != e.charAt(r) || a("'") ? t += e.charAt(r) : i = !1;
                else switch (e.charAt(r)) {
                    case "d":
                    case "m":
                    case "y":
                    case "@":
                        t += "0123456789";
                        break;
                    case "D":
                    case "M":
                        return null;
                    case "'":
                        a("'") ? t += "'" : i = !0;
                        break;
                    default:
                        t += e.charAt(r)
                }
                return t
        },
        _get: function(e, t) {
            return e.settings[t] !== undefined ? e.settings[t] : this._defaults[t]
        },
        _setDateFromField: function(e, t) {
            if (e.input.val() != e.lastVal) {
                var i, a, r = this._get(e, "dateFormat"),
                    n = e.lastVal = e.input ? e.input.val() : null;
                i = a = this._getDefaultDate(e);
                var s = this._getFormatConfig(e);
                try {
                    i = this.parseDate(r, n, s) || a
                } catch (o) {
                    this.log(o), n = t ? "" : n
                }
                e.selectedDay = i.getDate(), e.drawMonth = e.selectedMonth = i.getMonth(), e.drawYear = e.selectedYear = i.getFullYear(), e.currentDay = n ? i.getDate() : 0, e.currentMonth = n ? i.getMonth() : 0, e.currentYear = n ? i.getFullYear() : 0, this._adjustInstDate(e)
            }
        },
        _getDefaultDate: function(e) {
            return this._restrictMinMax(e, this._determineDate(e, this._get(e, "defaultDate"), new Date))
        },
        _determineDate: function(e, t, i) {
            var a = function(e) {
                    var t = new Date;
                    return t.setDate(t.getDate() + e), t
                },
                r = function(t) {
                    try {
                        return $.datepicker.parseDate($.datepicker._get(e, "dateFormat"), t, $.datepicker._getFormatConfig(e))
                    } catch (i) {}
                    for (var a = (t.toLowerCase().match(/^c/) ? $.datepicker._getDate(e) : null) || new Date, r = a.getFullYear(), n = a.getMonth(), s = a.getDate(), o = /([+-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g, u = o.exec(t); u;) {
                        switch (u[2] || "d") {
                            case "d":
                            case "D":
                                s += parseInt(u[1], 10);
                                break;
                            case "w":
                            case "W":
                                s += 7 * parseInt(u[1], 10);
                                break;
                            case "m":
                            case "M":
                                n += parseInt(u[1], 10), s = Math.min(s, $.datepicker._getDaysInMonth(r, n));
                                break;
                            case "y":
                            case "Y":
                                r += parseInt(u[1], 10), s = Math.min(s, $.datepicker._getDaysInMonth(r, n))
                        }
                        u = o.exec(t)
                    }
                    return new Date(r, n, s)
                },
                n = null == t || "" === t ? i : "string" == typeof t ? r(t) : "number" == typeof t ? isNaN(t) ? i : a(t) : new Date(t.getTime());
            return n = n && "Invalid Date" == "" + n ? i : n, n && (n.setHours(0), n.setMinutes(0), n.setSeconds(0), n.setMilliseconds(0)), this._daylightSavingAdjust(n)
        },
        _daylightSavingAdjust: function(e) {
            return e ? (e.setHours(e.getHours() > 12 ? e.getHours() + 2 : 0), e) : null
        },
        _setDate: function(e, t, i) {
            var a = !t,
                r = e.selectedMonth,
                n = e.selectedYear,
                s = this._restrictMinMax(e, this._determineDate(e, t, new Date));
            e.selectedDay = e.currentDay = s.getDate(), e.drawMonth = e.selectedMonth = e.currentMonth = s.getMonth(), e.drawYear = e.selectedYear = e.currentYear = s.getFullYear(), r == e.selectedMonth && n == e.selectedYear || i || this._notifyChange(e), this._adjustInstDate(e), e.input && e.input.val(a ? "" : this._formatDate(e))
        },
        _getDate: function(e) {
            var t = !e.currentYear || e.input && "" == e.input.val() ? null : this._daylightSavingAdjust(new Date(e.currentYear, e.currentMonth, e.currentDay));
            return t
        },
        _attachHandlers: function(e) {
            var t = this._get(e, "stepMonths"),
                i = "#" + e.id.replace(/\\\\/g, "\\");
            e.dpDiv.find("[data-handler]").map(function() {
                var e = {
                    prev: function() {
                        window["DP_jQuery_" + dpuuid].datepicker._adjustDate(i, -t, "M")
                    },
                    next: function() {
                        window["DP_jQuery_" + dpuuid].datepicker._adjustDate(i, +t, "M")
                    },
                    hide: function() {
                        window["DP_jQuery_" + dpuuid].datepicker._hideDatepicker()
                    },
                    today: function() {
                        window["DP_jQuery_" + dpuuid].datepicker._gotoToday(i)
                    },
                    selectDay: function() {
                        return window["DP_jQuery_" + dpuuid].datepicker._selectDay(i, +this.getAttribute("data-month"), +this.getAttribute("data-year"), this), !1
                    },
                    selectMonth: function() {
                        return window["DP_jQuery_" + dpuuid].datepicker._selectMonthYear(i, this, "M"), !1
                    },
                    selectYear: function() {
                        return window["DP_jQuery_" + dpuuid].datepicker._selectMonthYear(i, this, "Y"), !1
                    }
                };
                $(this).bind(this.getAttribute("data-event"), e[this.getAttribute("data-handler")])
            })
        },
        _generateHTML: function(e) {
            var t = new Date;
            t = this._daylightSavingAdjust(new Date(t.getFullYear(), t.getMonth(), t.getDate()));
            var i = this._get(e, "isRTL"),
                a = this._get(e, "showButtonPanel"),
                r = this._get(e, "hideIfNoPrevNext"),
                n = this._get(e, "navigationAsDateFormat"),
                s = this._getNumberOfMonths(e),
                o = this._get(e, "showCurrentAtPos"),
                u = this._get(e, "stepMonths"),
                d = 1 != s[0] || 1 != s[1],
                l = this._daylightSavingAdjust(e.currentDay ? new Date(e.currentYear, e.currentMonth, e.currentDay) : new Date(9999, 9, 9)),
                h = this._getMinMaxDate(e, "min"),
                c = this._getMinMaxDate(e, "max"),
                m = e.drawMonth - o,
                p = e.drawYear;
            if (0 > m && (m += 12, p--), c) {
                var f = this._daylightSavingAdjust(new Date(c.getFullYear(), c.getMonth() - s[0] * s[1] + 1, c.getDate()));
                for (f = h && h > f ? h : f; this._daylightSavingAdjust(new Date(p, m, 1)) > f;) m--, 0 > m && (m = 11, p--)
            }
            e.drawMonth = m, e.drawYear = p;
            var g = this._get(e, "prevText");
            g = n ? this.formatDate(g, this._daylightSavingAdjust(new Date(p, m - u, 1)), this._getFormatConfig(e)) : g;
            var y = this._canAdjustMonth(e, -1, p, m) ? '<a class="ui-datepicker-prev ui-corner-all" data-handler="prev" data-event="click" title="' + g + '"><span class="ui-icon ui-icon-circle-triangle-' + (i ? "e" : "w") + '">' + g + "</span></a>" : r ? "" : '<a class="ui-datepicker-prev ui-corner-all ui-state-disabled" title="' + g + '"><span class="ui-icon ui-icon-circle-triangle-' + (i ? "e" : "w") + '">' + g + "</span></a>",
                v = this._get(e, "nextText");
            v = n ? this.formatDate(v, this._daylightSavingAdjust(new Date(p, m + u, 1)), this._getFormatConfig(e)) : v;
            var b = this._canAdjustMonth(e, 1, p, m) ? '<a class="ui-datepicker-next ui-corner-all" data-handler="next" data-event="click" title="' + v + '"><span class="ui-icon ui-icon-circle-triangle-' + (i ? "w" : "e") + '">' + v + "</span></a>" : r ? "" : '<a class="ui-datepicker-next ui-corner-all ui-state-disabled" title="' + v + '"><span class="ui-icon ui-icon-circle-triangle-' + (i ? "w" : "e") + '">' + v + "</span></a>",
                x = this._get(e, "currentText"),
                k = this._get(e, "gotoCurrent") && e.currentDay ? l : t;
            x = n ? this.formatDate(x, k, this._getFormatConfig(e)) : x;
            var _ = e.inline ? "" : '<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" data-handler="hide" data-event="click">' + this._get(e, "closeText") + "</button>",
                D = a ? '<div class="ui-datepicker-buttonpane ui-widget-content">' + (i ? _ : "") + (this._isInRange(e, k) ? '<button type="button" class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" data-handler="today" data-event="click">' + x + "</button>" : "") + (i ? "" : _) + "</div>" : "",
                T = parseInt(this._get(e, "firstDay"), 10);
            T = isNaN(T) ? 0 : T;
            var M = this._get(e, "showWeek"),
                S = this._get(e, "dayNames");
            this._get(e, "dayNamesShort");
            var N = this._get(e, "dayNamesMin"),
                w = this._get(e, "monthNames"),
                C = this._get(e, "monthNamesShort"),
                A = this._get(e, "beforeShowDay"),
                j = this._get(e, "showOtherMonths"),
                F = this._get(e, "selectOtherMonths");
            this._get(e, "calculateWeek") || this.iso8601Week;
            for (var I = this._getDefaultDate(e), P = "", H = 0; s[0] > H; H++) {
                var L = "";
                this.maxRows = 4;
                for (var E = 0; s[1] > E; E++) {
                    var z = this._daylightSavingAdjust(new Date(p, m, e.selectedDay)),
                        Y = " ui-corner-all",
                        O = "";
                    if (d) {
                        if (O += '<div class="ui-datepicker-group', s[1] > 1) switch (E) {
                            case 0:
                                O += " ui-datepicker-group-first", Y = " ui-corner-" + (i ? "right" : "left");
                                break;
                            case s[1] - 1:
                                O += " ui-datepicker-group-last", Y = " ui-corner-" + (i ? "left" : "right");
                                break;
                            default:
                                O += " ui-datepicker-group-middle", Y = ""
                        }
                        O += '">'
                    }
                    O += '<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix' + Y + '">' + (/all|left/.test(Y) && 0 == H ? i ? b : y : "") + (/all|right/.test(Y) && 0 == H ? i ? y : b : "") + this._generateMonthYearHeader(e, m, p, h, c, H > 0 || E > 0, w, C) + '</div><table class="ui-datepicker-calendar"><thead>' + "<tr>";
                    for (var R = M ? '<th class="ui-datepicker-week-col">' + this._get(e, "weekHeader") + "</th>" : "", J = 0; 7 > J; J++) {
                        var W = (J + T) % 7;
                        R += "<th" + ((J + T + 6) % 7 >= 5 ? ' class="ui-datepicker-week-end"' : "") + ">" + '<span title="' + S[W] + '">' + N[W] + "</span></th>"
                    }
                    O += R + "</tr></thead><tbody>";
                    var B = this._getDaysInMonth(p, m);
                    p == e.selectedYear && m == e.selectedMonth && (e.selectedDay = Math.min(e.selectedDay, B));
                    var Q = (this._getFirstDayOfMonth(p, m) - T + 7) % 7,
                        K = Math.ceil((Q + B) / 7),
                        V = d ? this.maxRows > K ? this.maxRows : K : K;
                    this.maxRows = V;
                    for (var U = this._daylightSavingAdjust(new Date(p, m, 1 - Q)), G = 0; V > G; G++) {
                        O += "<tr>";
                        for (var q = M ? '<td class="ui-datepicker-week-col">' + this._get(e, "calculateWeek")(U) + "</td>" : "", J = 0; 7 > J; J++) {
                            var X = A ? A.apply(e.input ? e.input[0] : null, [U]) : [!0, ""],
                                Z = U.getMonth() != m,
                                et = Z && !F || !X[0] || h && h > U || c && U > c;
                            q += '<td class="' + ((J + T + 6) % 7 >= 5 ? " ui-datepicker-week-end" : "") + (Z ? " ui-datepicker-other-month" : "") + (U.getTime() == z.getTime() && m == e.selectedMonth && e._keyEvent || I.getTime() == U.getTime() && I.getTime() == z.getTime() ? " " + this._dayOverClass : "") + (et ? " " + this._unselectableClass + " ui-state-disabled" : "") + (Z && !j ? "" : " " + X[1] + (U.getTime() == l.getTime() ? " " + this._currentClass : "") + (U.getTime() == t.getTime() ? " ui-datepicker-today" : "")) + '"' + (Z && !j || !X[2] ? "" : ' title="' + X[2] + '"') + (et ? "" : ' data-handler="selectDay" data-event="click" data-month="' + U.getMonth() + '" data-year="' + U.getFullYear() + '"') + ">" + (Z && !j ? "&#xa0;" : et ? '<span class="ui-state-default">' + U.getDate() + "</span>" : '<a class="ui-state-default' + (U.getTime() == t.getTime() ? " ui-state-highlight" : "") + (U.getTime() == l.getTime() ? " ui-state-active" : "") + (Z ? " ui-priority-secondary" : "") + '" href="#">' + U.getDate() + "</a>") + "</td>", U.setDate(U.getDate() + 1), U = this._daylightSavingAdjust(U)
                        }
                        O += q + "</tr>"
                    }
                    m++, m > 11 && (m = 0, p++), O += "</tbody></table>" + (d ? "</div>" + (s[0] > 0 && E == s[1] - 1 ? '<div class="ui-datepicker-row-break"></div>' : "") : ""), L += O
                }
                P += L
            }
            return P += D + ($.ui.ie6 && !e.inline ? '<iframe src="javascript:false;" class="ui-datepicker-cover" frameborder="0"></iframe>' : ""), e._keyEvent = !1, P
        },
        _generateMonthYearHeader: function(e, t, i, a, r, n, s, o) {
            var u = this._get(e, "changeMonth"),
                d = this._get(e, "changeYear"),
                l = this._get(e, "showMonthAfterYear"),
                h = '<div class="ui-datepicker-title">',
                c = "";
            if (n || !u) c += '<span class="ui-datepicker-month">' + s[t] + "</span>";
            else {
                var m = a && a.getFullYear() == i,
                    p = r && r.getFullYear() == i;
                c += '<select class="ui-datepicker-month" data-handler="selectMonth" data-event="change">';
                for (var f = 0; 12 > f; f++)(!m || f >= a.getMonth()) && (!p || r.getMonth() >= f) && (c += '<option value="' + f + '"' + (f == t ? ' selected="selected"' : "") + ">" + o[f] + "</option>");
                c += "</select>"
            }
            if (l || (h += c + (!n && u && d ? "" : "&#xa0;")), !e.yearshtml)
                if (e.yearshtml = "", n || !d) h += '<span class="ui-datepicker-year">' + i + "</span>";
                else {
                    var g = this._get(e, "yearRange").split(":"),
                        y = (new Date).getFullYear(),
                        v = function(e) {
                            var t = e.match(/c[+-].*/) ? i + parseInt(e.substring(1), 10) : e.match(/[+-].*/) ? y + parseInt(e, 10) : parseInt(e, 10);
                            return isNaN(t) ? y : t
                        },
                        b = v(g[0]),
                        x = Math.max(b, v(g[1] || ""));
                    for (b = a ? Math.max(b, a.getFullYear()) : b, x = r ? Math.min(x, r.getFullYear()) : x, e.yearshtml += '<select class="ui-datepicker-year" data-handler="selectYear" data-event="change">'; x >= b; b++) e.yearshtml += '<option value="' + b + '"' + (b == i ? ' selected="selected"' : "") + ">" + b + "</option>";
                    e.yearshtml += "</select>", h += e.yearshtml, e.yearshtml = null
                }
            return h += this._get(e, "yearSuffix"), l && (h += (!n && u && d ? "" : "&#xa0;") + c), h += "</div>"
        },
        _adjustInstDate: function(e, t, i) {
            var a = e.drawYear + ("Y" == i ? t : 0),
                r = e.drawMonth + ("M" == i ? t : 0),
                n = Math.min(e.selectedDay, this._getDaysInMonth(a, r)) + ("D" == i ? t : 0),
                s = this._restrictMinMax(e, this._daylightSavingAdjust(new Date(a, r, n)));
            e.selectedDay = s.getDate(), e.drawMonth = e.selectedMonth = s.getMonth(), e.drawYear = e.selectedYear = s.getFullYear(), ("M" == i || "Y" == i) && this._notifyChange(e)
        },
        _restrictMinMax: function(e, t) {
            var i = this._getMinMaxDate(e, "min"),
                a = this._getMinMaxDate(e, "max"),
                r = i && i > t ? i : t;
            return r = a && r > a ? a : r
        },
        _notifyChange: function(e) {
            var t = this._get(e, "onChangeMonthYear");
            t && t.apply(e.input ? e.input[0] : null, [e.selectedYear, e.selectedMonth + 1, e])
        },
        _getNumberOfMonths: function(e) {
            var t = this._get(e, "numberOfMonths");
            return null == t ? [1, 1] : "number" == typeof t ? [1, t] : t
        },
        _getMinMaxDate: function(e, t) {
            return this._determineDate(e, this._get(e, t + "Date"), null)
        },
        _getDaysInMonth: function(e, t) {
            return 32 - this._daylightSavingAdjust(new Date(e, t, 32)).getDate()
        },
        _getFirstDayOfMonth: function(e, t) {
            return new Date(e, t, 1).getDay()
        },
        _canAdjustMonth: function(e, t, i, a) {
            var r = this._getNumberOfMonths(e),
                n = this._daylightSavingAdjust(new Date(i, a + (0 > t ? t : r[0] * r[1]), 1));
            return 0 > t && n.setDate(this._getDaysInMonth(n.getFullYear(), n.getMonth())), this._isInRange(e, n)
        },
        _isInRange: function(e, t) {
            var i = this._getMinMaxDate(e, "min"),
                a = this._getMinMaxDate(e, "max");
            return (!i || t.getTime() >= i.getTime()) && (!a || t.getTime() <= a.getTime())
        },
        _getFormatConfig: function(e) {
            var t = this._get(e, "shortYearCutoff");
            return t = "string" != typeof t ? t : (new Date).getFullYear() % 100 + parseInt(t, 10), {
                shortYearCutoff: t,
                dayNamesShort: this._get(e, "dayNamesShort"),
                dayNames: this._get(e, "dayNames"),
                monthNamesShort: this._get(e, "monthNamesShort"),
                monthNames: this._get(e, "monthNames")
            }
        },
        _formatDate: function(e, t, i, a) {
            t || (e.currentDay = e.selectedDay, e.currentMonth = e.selectedMonth, e.currentYear = e.selectedYear);
            var r = t ? "object" == typeof t ? t : this._daylightSavingAdjust(new Date(a, i, t)) : this._daylightSavingAdjust(new Date(e.currentYear, e.currentMonth, e.currentDay));
            return this.formatDate(this._get(e, "dateFormat"), r, this._getFormatConfig(e))
        }
    }), $.fn.datepicker = function(e) {
        if (!this.length) return this;
        $.datepicker.initialized || ($(document).mousedown($.datepicker._checkExternalClick).find(document.body).append($.datepicker.dpDiv), $.datepicker.initialized = !0);
        var t = Array.prototype.slice.call(arguments, 1);
        return "string" != typeof e || "isDisabled" != e && "getDate" != e && "widget" != e ? "option" == e && 2 == arguments.length && "string" == typeof arguments[1] ? $.datepicker["_" + e + "Datepicker"].apply($.datepicker, [this[0]].concat(t)) : this.each(function() {
            "string" == typeof e ? $.datepicker["_" + e + "Datepicker"].apply($.datepicker, [this].concat(t)) : $.datepicker._attachDatepicker(this, e)
        }) : $.datepicker["_" + e + "Datepicker"].apply($.datepicker, [this[0]].concat(t))
    }, $.datepicker = new Datepicker, $.datepicker.initialized = !1, $.datepicker.uuid = (new Date).getTime(), $.datepicker.version = "1.9.2", window["DP_jQuery_" + dpuuid] = $
})(jQuery);
(function(e, t) {
    var i = "ui-dialog ui-widget ui-widget-content ui-corner-all ",
        a = {
            buttons: !0,
            height: !0,
            maxHeight: !0,
            maxWidth: !0,
            minHeight: !0,
            minWidth: !0,
            width: !0
        },
        n = {
            maxHeight: !0,
            maxWidth: !0,
            minHeight: !0,
            minWidth: !0
        };
    e.widget("ui.dialog", {
        version: "1.9.2",
        options: {
            autoOpen: !0,
            buttons: {},
            closeOnEscape: !0,
            closeText: "close",
            dialogClass: "",
            draggable: !0,
            hide: null,
            height: "auto",
            maxHeight: !1,
            maxWidth: !1,
            minHeight: 150,
            minWidth: 150,
            modal: !1,
            position: {
                my: "center",
                at: "center",
                of: window,
                collision: "fit",
                using: function(t) {
                    var i = e(this).css(t).offset().top;
                    0 > i && e(this).css("top", t.top - i)
                }
            },
            resizable: !0,
            show: null,
            stack: !0,
            title: "",
            width: 300,
            zIndex: 1e3
        },
        _create: function() {
            this.originalTitle = this.element.attr("title"), "string" != typeof this.originalTitle && (this.originalTitle = ""), this.oldPosition = {
                parent: this.element.parent(),
                index: this.element.parent().children().index(this.element)
            }, this.options.title = this.options.title || this.originalTitle;
            var a, n, r, s, o, u = this,
                d = this.options,
                l = d.title || "&#160;";
            a = (this.uiDialog = e("<div>")).addClass(i + d.dialogClass).css({
                display: "none",
                outline: 0,
                zIndex: d.zIndex
            }).attr("tabIndex", -1).keydown(function(t) {
                d.closeOnEscape && !t.isDefaultPrevented() && t.keyCode && t.keyCode === e.ui.keyCode.ESCAPE && (u.close(t), t.preventDefault())
            }).mousedown(function(e) {
                u.moveToTop(!1, e)
            }).appendTo("body"), this.element.show().removeAttr("title").addClass("ui-dialog-content ui-widget-content").appendTo(a), n = (this.uiDialogTitlebar = e("<div>")).addClass("ui-dialog-titlebar  ui-widget-header  ui-corner-all  ui-helper-clearfix").bind("mousedown", function() {
                a.focus()
            }).prependTo(a), r = e("<a href='#'></a>").addClass("ui-dialog-titlebar-close  ui-corner-all").attr("role", "button").click(function(e) {
                e.preventDefault(), u.close(e)
            }).appendTo(n), (this.uiDialogTitlebarCloseText = e("<span>")).addClass("ui-icon ui-icon-closethick").text(d.closeText).appendTo(r), s = e("<span>").uniqueId().addClass("ui-dialog-title").html(l).prependTo(n), o = (this.uiDialogButtonPane = e("<div>")).addClass("ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"), (this.uiButtonSet = e("<div>")).addClass("ui-dialog-buttonset").appendTo(o), a.attr({
                role: "dialog",
                "aria-labelledby": s.attr("id")
            }), n.find("*").add(n).disableSelection(), this._hoverable(r), this._focusable(r), d.draggable && e.fn.draggable && this._makeDraggable(), d.resizable && e.fn.resizable && this._makeResizable(), this._createButtons(d.buttons), this._isOpen = !1, e.fn.bgiframe && a.bgiframe(), this._on(a, {
                keydown: function(i) {
                    if (d.modal && i.keyCode === e.ui.keyCode.TAB) {
                        var n = e(":tabbable", a),
                            r = n.filter(":first"),
                            s = n.filter(":last");
                        return i.target !== s[0] || i.shiftKey ? i.target === r[0] && i.shiftKey ? (s.focus(1), !1) : t : (r.focus(1), !1)
                    }
                }
            })
        },
        _init: function() {
            this.options.autoOpen && this.open()
        },
        _destroy: function() {
            var e, t = this.oldPosition;
            this.overlay && this.overlay.destroy(), this.uiDialog.hide(), this.element.removeClass("ui-dialog-content ui-widget-content").hide().appendTo("body"), this.uiDialog.remove(), this.originalTitle && this.element.attr("title", this.originalTitle), e = t.parent.children().eq(t.index), e.length && e[0] !== this.element[0] ? e.before(this.element) : t.parent.append(this.element)
        },
        widget: function() {
            return this.uiDialog
        },
        close: function(t) {
            var i, a, n = this;
            if (this._isOpen && !1 !== this._trigger("beforeClose", t)) return this._isOpen = !1, this.overlay && this.overlay.destroy(), this.options.hide ? this._hide(this.uiDialog, this.options.hide, function() {
                n._trigger("close", t)
            }) : (this.uiDialog.hide(), this._trigger("close", t)), e.ui.dialog.overlay.resize(), this.options.modal && (i = 0, e(".ui-dialog").each(function() {
                this !== n.uiDialog[0] && (a = e(this).css("z-index"), isNaN(a) || (i = Math.max(i, a)))
            }), e.ui.dialog.maxZ = i), this
        },
        isOpen: function() {
            return this._isOpen
        },
        moveToTop: function(t, i) {
            var a, n = this.options;
            return n.modal && !t || !n.stack && !n.modal ? this._trigger("focus", i) : (n.zIndex > e.ui.dialog.maxZ && (e.ui.dialog.maxZ = n.zIndex), this.overlay && (e.ui.dialog.maxZ += 1, e.ui.dialog.overlay.maxZ = e.ui.dialog.maxZ, this.overlay.$el.css("z-index", e.ui.dialog.overlay.maxZ)), a = {
                scrollTop: this.element.scrollTop(),
                scrollLeft: this.element.scrollLeft()
            }, e.ui.dialog.maxZ += 1, this.uiDialog.css("z-index", e.ui.dialog.maxZ), this.element.attr(a), this._trigger("focus", i), this)
        },
        open: function() {
            if (!this._isOpen) {
                var t, i = this.options,
                    a = this.uiDialog;
                return this._size(), this._position(i.position), a.show(i.show), this.overlay = i.modal ? new e.ui.dialog.overlay(this) : null, this.moveToTop(!0), t = this.element.find(":tabbable"), t.length || (t = this.uiDialogButtonPane.find(":tabbable"), t.length || (t = a)), t.eq(0).focus(), this._isOpen = !0, this._trigger("open"), this
            }
        },
        _createButtons: function(t) {
            var i = this,
                a = !1;
            this.uiDialogButtonPane.remove(), this.uiButtonSet.empty(), "object" == typeof t && null !== t && e.each(t, function() {
                return !(a = !0)
            }), a ? (e.each(t, function(t, a) {
                var n, r;
                a = e.isFunction(a) ? {
                    click: a,
                    text: t
                } : a, a = e.extend({
                    type: "button"
                }, a), r = a.click, a.click = function() {
                    r.apply(i.element[0], arguments)
                }, n = e("<button></button>", a).appendTo(i.uiButtonSet), e.fn.button && n.button()
            }), this.uiDialog.addClass("ui-dialog-buttons"), this.uiDialogButtonPane.appendTo(this.uiDialog)) : this.uiDialog.removeClass("ui-dialog-buttons")
        },
        _makeDraggable: function() {
            function t(e) {
                return {
                    position: e.position,
                    offset: e.offset
                }
            }
            var i = this,
                a = this.options;
            this.uiDialog.draggable({
                cancel: ".ui-dialog-content, .ui-dialog-titlebar-close",
                handle: ".ui-dialog-titlebar",
                containment: "document",
                start: function(a, n) {
                    e(this).addClass("ui-dialog-dragging"), i._trigger("dragStart", a, t(n))
                },
                drag: function(e, a) {
                    i._trigger("drag", e, t(a))
                },
                stop: function(n, r) {
                    a.position = [r.position.left - i.document.scrollLeft(), r.position.top - i.document.scrollTop()], e(this).removeClass("ui-dialog-dragging"), i._trigger("dragStop", n, t(r)), e.ui.dialog.overlay.resize()
                }
            })
        },
        _makeResizable: function(i) {
            function a(e) {
                return {
                    originalPosition: e.originalPosition,
                    originalSize: e.originalSize,
                    position: e.position,
                    size: e.size
                }
            }
            i = i === t ? this.options.resizable : i;
            var n = this,
                r = this.options,
                s = this.uiDialog.css("position"),
                o = "string" == typeof i ? i : "n,e,s,w,se,sw,ne,nw";
            this.uiDialog.resizable({
                cancel: ".ui-dialog-content",
                containment: "document",
                alsoResize: this.element,
                maxWidth: r.maxWidth,
                maxHeight: r.maxHeight,
                minWidth: r.minWidth,
                minHeight: this._minHeight(),
                handles: o,
                start: function(t, i) {
                    e(this).addClass("ui-dialog-resizing"), n._trigger("resizeStart", t, a(i))
                },
                resize: function(e, t) {
                    n._trigger("resize", e, a(t))
                },
                stop: function(t, i) {
                    e(this).removeClass("ui-dialog-resizing"), r.height = e(this).height(), r.width = e(this).width(), n._trigger("resizeStop", t, a(i)), e.ui.dialog.overlay.resize()
                }
            }).css("position", s).find(".ui-resizable-se").addClass("ui-icon ui-icon-grip-diagonal-se")
        },
        _minHeight: function() {
            var e = this.options;
            return "auto" === e.height ? e.minHeight : Math.min(e.minHeight, e.height)
        },
        _position: function(t) {
            var i, a = [],
                n = [0, 0];
            t ? (("string" == typeof t || "object" == typeof t && "0" in t) && (a = t.split ? t.split(" ") : [t[0], t[1]], 1 === a.length && (a[1] = a[0]), e.each(["left", "top"], function(e, t) {
                +a[e] === a[e] && (n[e] = a[e], a[e] = t)
            }), t = {
                my: a[0] + (0 > n[0] ? n[0] : "+" + n[0]) + " " + a[1] + (0 > n[1] ? n[1] : "+" + n[1]),
                at: a.join(" ")
            }), t = e.extend({}, e.ui.dialog.prototype.options.position, t)) : t = e.ui.dialog.prototype.options.position, i = this.uiDialog.is(":visible"), i || this.uiDialog.show(), this.uiDialog.position(t), i || this.uiDialog.hide()
        },
        _setOptions: function(t) {
            var i = this,
                r = {},
                s = !1;
            e.each(t, function(e, t) {
                i._setOption(e, t), e in a && (s = !0), e in n && (r[e] = t)
            }), s && this._size(), this.uiDialog.is(":data(resizable)") && this.uiDialog.resizable("option", r)
        },
        _setOption: function(t, a) {
            var n, r, s = this.uiDialog;
            switch (t) {
                case "buttons":
                    this._createButtons(a);
                    break;
                case "closeText":
                    this.uiDialogTitlebarCloseText.text("" + a);
                    break;
                case "dialogClass":
                    s.removeClass(this.options.dialogClass).addClass(i + a);
                    break;
                case "disabled":
                    a ? s.addClass("ui-dialog-disabled") : s.removeClass("ui-dialog-disabled");
                    break;
                case "draggable":
                    n = s.is(":data(draggable)"), n && !a && s.draggable("destroy"), !n && a && this._makeDraggable();
                    break;
                case "position":
                    this._position(a);
                    break;
                case "resizable":
                    r = s.is(":data(resizable)"), r && !a && s.resizable("destroy"), r && "string" == typeof a && s.resizable("option", "handles", a), r || a === !1 || this._makeResizable(a);
                    break;
                case "title":
                    e(".ui-dialog-title", this.uiDialogTitlebar).html("" + (a || "&#160;"))
            }
            this._super(t, a)
        },
        _size: function() {
            var t, i, a, n = this.options,
                r = this.uiDialog.is(":visible");
            this.element.show().css({
                width: "auto",
                minHeight: 0,
                height: 0
            }), n.minWidth > n.width && (n.width = n.minWidth), t = this.uiDialog.css({
                height: "auto",
                width: n.width
            }).outerHeight(), i = Math.max(0, n.minHeight - t), "auto" === n.height ? e.support.minHeight ? this.element.css({
                minHeight: i,
                height: "auto"
            }) : (this.uiDialog.show(), a = this.element.css("height", "auto").height(), r || this.uiDialog.hide(), this.element.height(Math.max(a, i))) : this.element.height(Math.max(n.height - t, 0)), this.uiDialog.is(":data(resizable)") && this.uiDialog.resizable("option", "minHeight", this._minHeight())
        }
    }), e.extend(e.ui.dialog, {
        uuid: 0,
        maxZ: 0,
        getTitleId: function(e) {
            var t = e.attr("id");
            return t || (this.uuid += 1, t = this.uuid), "ui-dialog-title-" + t
        },
        overlay: function(t) {
            this.$el = e.ui.dialog.overlay.create(t)
        }
    }), e.extend(e.ui.dialog.overlay, {
        instances: [],
        oldInstances: [],
        maxZ: 0,
        events: e.map("focus,mousedown,mouseup,keydown,keypress,click".split(","), function(e) {
            return e + ".dialog-overlay"
        }).join(" "),
        create: function(i) {
            0 === this.instances.length && (setTimeout(function() {
                e.ui.dialog.overlay.instances.length && e(document).bind(e.ui.dialog.overlay.events, function(i) {
                    return e(i.target).zIndex() < e.ui.dialog.overlay.maxZ ? !1 : t
                })
            }, 1), e(window).bind("resize.dialog-overlay", e.ui.dialog.overlay.resize));
            var a = this.oldInstances.pop() || e("<div>").addClass("ui-widget-overlay");
            return e(document).bind("keydown.dialog-overlay", function(t) {
                var n = e.ui.dialog.overlay.instances;
                0 !== n.length && n[n.length - 1] === a && i.options.closeOnEscape && !t.isDefaultPrevented() && t.keyCode && t.keyCode === e.ui.keyCode.ESCAPE && (i.close(t), t.preventDefault())
            }), a.appendTo(document.body).css({
                width: this.width(),
                height: this.height()
            }), e.fn.bgiframe && a.bgiframe(), this.instances.push(a), a
        },
        destroy: function(t) {
            var i = e.inArray(t, this.instances),
                a = 0; - 1 !== i && this.oldInstances.push(this.instances.splice(i, 1)[0]), 0 === this.instances.length && e([document, window]).unbind(".dialog-overlay"), t.height(0).width(0).remove(), e.each(this.instances, function() {
                a = Math.max(a, this.css("z-index"))
            }), this.maxZ = a
        },
        height: function() {
            var t, i;
            return e.ui.ie ? (t = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight), i = Math.max(document.documentElement.offsetHeight, document.body.offsetHeight), i > t ? e(window).height() + "px" : t + "px") : e(document).height() + "px"
        },
        width: function() {
            var t, i;
            return e.ui.ie ? (t = Math.max(document.documentElement.scrollWidth, document.body.scrollWidth), i = Math.max(document.documentElement.offsetWidth, document.body.offsetWidth), i > t ? e(window).width() + "px" : t + "px") : e(document).width() + "px"
        },
        resize: function() {
            var t = e([]);
            e.each(e.ui.dialog.overlay.instances, function() {
                t = t.add(this)
            }), t.css({
                width: 0,
                height: 0
            }).css({
                width: e.ui.dialog.overlay.width(),
                height: e.ui.dialog.overlay.height()
            })
        }
    }), e.extend(e.ui.dialog.overlay.prototype, {
        destroy: function() {
            e.ui.dialog.overlay.destroy(this.$el)
        }
    })
})(jQuery);
(function(e) {
    var t = !1;
    e.widget("ui.menu", {
        version: "1.9.2",
        defaultElement: "<ul>",
        delay: 300,
        options: {
            icons: {
                submenu: "ui-icon-carat-1-e"
            },
            menus: "ul",
            position: {
                my: "left top",
                at: "right top"
            },
            role: "menu",
            blur: null,
            focus: null,
            select: null
        },
        _create: function() {
            this.activeMenu = this.element, this.element.uniqueId().addClass("ui-menu ui-widget ui-widget-content ui-corner-all").toggleClass("ui-menu-icons", !!this.element.find(".ui-icon").length).attr({
                role: this.options.role,
                tabIndex: 0
            }).bind("click" + this.eventNamespace, e.proxy(function(e) {
                this.options.disabled && e.preventDefault()
            }, this)), this.options.disabled && this.element.addClass("ui-state-disabled").attr("aria-disabled", "true"), this._on({
                "mousedown .ui-menu-item > a": function(e) {
                    e.preventDefault()
                },
                "click .ui-state-disabled > a": function(e) {
                    e.preventDefault()
                },
                "click .ui-menu-item:has(a)": function(i) {
                    var a = e(i.target).closest(".ui-menu-item");
                    !t && a.not(".ui-state-disabled").length && (t = !0, this.select(i), a.has(".ui-menu").length ? this.expand(i) : this.element.is(":focus") || (this.element.trigger("focus", [!0]), this.active && 1 === this.active.parents(".ui-menu").length && clearTimeout(this.timer)))
                },
                "mouseenter .ui-menu-item": function(t) {
                    var i = e(t.currentTarget);
                    i.siblings().children(".ui-state-active").removeClass("ui-state-active"), this.focus(t, i)
                },
                mouseleave: "collapseAll",
                "mouseleave .ui-menu": "collapseAll",
                focus: function(e, t) {
                    var i = this.active || this.element.children(".ui-menu-item").eq(0);
                    t || this.focus(e, i)
                },
                blur: function(t) {
                    this._delay(function() {
                        e.contains(this.element[0], this.document[0].activeElement) || this.collapseAll(t)
                    })
                },
                keydown: "_keydown"
            }), this.refresh(), this._on(this.document, {
                click: function(i) {
                    e(i.target).closest(".ui-menu").length || this.collapseAll(i), t = !1
                }
            })
        },
        _destroy: function() {
            this.element.removeAttr("aria-activedescendant").find(".ui-menu").andSelf().removeClass("ui-menu ui-widget ui-widget-content ui-corner-all ui-menu-icons").removeAttr("role").removeAttr("tabIndex").removeAttr("aria-labelledby").removeAttr("aria-expanded").removeAttr("aria-hidden").removeAttr("aria-disabled").removeUniqueId().show(), this.element.find(".ui-menu-item").removeClass("ui-menu-item").removeAttr("role").removeAttr("aria-disabled").children("a").removeUniqueId().removeClass("ui-corner-all ui-state-hover").removeAttr("tabIndex").removeAttr("role").removeAttr("aria-haspopup").children().each(function() {
                var t = e(this);
                t.data("ui-menu-submenu-carat") && t.remove()
            }), this.element.find(".ui-menu-divider").removeClass("ui-menu-divider ui-widget-content")
        },
        _keydown: function(t) {
            function i(e) {
                return e.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
            }
            var a, n, s, r, o, l = !0;
            switch (t.keyCode) {
                case e.ui.keyCode.PAGE_UP:
                    this.previousPage(t);
                    break;
                case e.ui.keyCode.PAGE_DOWN:
                    this.nextPage(t);
                    break;
                case e.ui.keyCode.HOME:
                    this._move("first", "first", t);
                    break;
                case e.ui.keyCode.END:
                    this._move("last", "last", t);
                    break;
                case e.ui.keyCode.UP:
                    this.previous(t);
                    break;
                case e.ui.keyCode.DOWN:
                    this.next(t);
                    break;
                case e.ui.keyCode.LEFT:
                    this.collapse(t);
                    break;
                case e.ui.keyCode.RIGHT:
                    this.active && !this.active.is(".ui-state-disabled") && this.expand(t);
                    break;
                case e.ui.keyCode.ENTER:
                case e.ui.keyCode.SPACE:
                    this._activate(t);
                    break;
                case e.ui.keyCode.ESCAPE:
                    this.collapse(t);
                    break;
                default:
                    l = !1, n = this.previousFilter || "", s = String.fromCharCode(t.keyCode), r = !1, clearTimeout(this.filterTimer), s === n ? r = !0 : s = n + s, o = RegExp("^" + i(s), "i"), a = this.activeMenu.children(".ui-menu-item").filter(function() {
                        return o.test(e(this).children("a").text())
                    }), a = r && -1 !== a.index(this.active.next()) ? this.active.nextAll(".ui-menu-item") : a, a.length || (s = String.fromCharCode(t.keyCode), o = RegExp("^" + i(s), "i"), a = this.activeMenu.children(".ui-menu-item").filter(function() {
                        return o.test(e(this).children("a").text())
                    })), a.length ? (this.focus(t, a), a.length > 1 ? (this.previousFilter = s, this.filterTimer = this._delay(function() {
                        delete this.previousFilter
                    }, 1e3)) : delete this.previousFilter) : delete this.previousFilter
            }
            l && t.preventDefault()
        },
        _activate: function(e) {
            this.active.is(".ui-state-disabled") || (this.active.children("a[aria-haspopup='true']").length ? this.expand(e) : this.select(e))
        },
        refresh: function() {
            var t, i = this.options.icons.submenu,
                a = this.element.find(this.options.menus);
            a.filter(":not(.ui-menu)").addClass("ui-menu ui-widget ui-widget-content ui-corner-all").hide().attr({
                role: this.options.role,
                "aria-hidden": "true",
                "aria-expanded": "false"
            }).each(function() {
                var t = e(this),
                    a = t.prev("a"),
                    n = e("<span>").addClass("ui-menu-icon ui-icon " + i).data("ui-menu-submenu-carat", !0);
                a.attr("aria-haspopup", "true").prepend(n), t.attr("aria-labelledby", a.attr("id"))
            }), t = a.add(this.element), t.children(":not(.ui-menu-item):has(a)").addClass("ui-menu-item").attr("role", "presentation").children("a").uniqueId().addClass("ui-corner-all").attr({
                tabIndex: -1,
                role: this._itemRole()
            }), t.children(":not(.ui-menu-item)").each(function() {
                var t = e(this);
                /[^\-—–\s]/.test(t.text()) || t.addClass("ui-widget-content ui-menu-divider")
            }), t.children(".ui-state-disabled").attr("aria-disabled", "true"), this.active && !e.contains(this.element[0], this.active[0]) && this.blur()
        },
        _itemRole: function() {
            return {
                menu: "menuitem",
                listbox: "option"
            }[this.options.role]
        },
        focus: function(e, t) {
            var i, a;
            this.blur(e, e && "focus" === e.type), this._scrollIntoView(t), this.active = t.first(), a = this.active.children("a").addClass("ui-state-focus"), this.options.role && this.element.attr("aria-activedescendant", a.attr("id")), this.active.parent().closest(".ui-menu-item").children("a:first").addClass("ui-state-active"), e && "keydown" === e.type ? this._close() : this.timer = this._delay(function() {
                this._close()
            }, this.delay), i = t.children(".ui-menu"), i.length && /^mouse/.test(e.type) && this._startOpening(i), this.activeMenu = t.parent(), this._trigger("focus", e, {
                item: t
            })
        },
        _scrollIntoView: function(t) {
            var i, a, n, s, r, o;
            this._hasScroll() && (i = parseFloat(e.css(this.activeMenu[0], "borderTopWidth")) || 0, a = parseFloat(e.css(this.activeMenu[0], "paddingTop")) || 0, n = t.offset().top - this.activeMenu.offset().top - i - a, s = this.activeMenu.scrollTop(), r = this.activeMenu.height(), o = t.height(), 0 > n ? this.activeMenu.scrollTop(s + n) : n + o > r && this.activeMenu.scrollTop(s + n - r + o))
        },
        blur: function(e, t) {
            t || clearTimeout(this.timer), this.active && (this.active.children("a").removeClass("ui-state-focus"), this.active = null, this._trigger("blur", e, {
                item: this.active
            }))
        },
        _startOpening: function(e) {
            clearTimeout(this.timer), "true" === e.attr("aria-hidden") && (this.timer = this._delay(function() {
                this._close(), this._open(e)
            }, this.delay))
        },
        _open: function(t) {
            var i = e.extend({
                of: this.active
            }, this.options.position);
            clearTimeout(this.timer), this.element.find(".ui-menu").not(t.parents(".ui-menu")).hide().attr("aria-hidden", "true"), t.show().removeAttr("aria-hidden").attr("aria-expanded", "true").position(i)
        },
        collapseAll: function(t, i) {
            clearTimeout(this.timer), this.timer = this._delay(function() {
                var a = i ? this.element : e(t && t.target).closest(this.element.find(".ui-menu"));
                a.length || (a = this.element), this._close(a), this.blur(t), this.activeMenu = a
            }, this.delay)
        },
        _close: function(e) {
            e || (e = this.active ? this.active.parent() : this.element), e.find(".ui-menu").hide().attr("aria-hidden", "true").attr("aria-expanded", "false").end().find("a.ui-state-active").removeClass("ui-state-active")
        },
        collapse: function(e) {
            var t = this.active && this.active.parent().closest(".ui-menu-item", this.element);
            t && t.length && (this._close(), this.focus(e, t))
        },
        expand: function(e) {
            var t = this.active && this.active.children(".ui-menu ").children(".ui-menu-item").first();
            t && t.length && (this._open(t.parent()), this._delay(function() {
                this.focus(e, t)
            }))
        },
        next: function(e) {
            this._move("next", "first", e)
        },
        previous: function(e) {
            this._move("prev", "last", e)
        },
        isFirstItem: function() {
            return this.active && !this.active.prevAll(".ui-menu-item").length
        },
        isLastItem: function() {
            return this.active && !this.active.nextAll(".ui-menu-item").length
        },
        _move: function(e, t, i) {
            var a;
            this.active && (a = "first" === e || "last" === e ? this.active["first" === e ? "prevAll" : "nextAll"](".ui-menu-item").eq(-1) : this.active[e + "All"](".ui-menu-item").eq(0)), a && a.length && this.active || (a = this.activeMenu.children(".ui-menu-item")[t]()), this.focus(i, a)
        },
        nextPage: function(t) {
            var i, a, n;
            return this.active ? (this.isLastItem() || (this._hasScroll() ? (a = this.active.offset().top, n = this.element.height(), this.active.nextAll(".ui-menu-item").each(function() {
                return i = e(this), 0 > i.offset().top - a - n
            }), this.focus(t, i)) : this.focus(t, this.activeMenu.children(".ui-menu-item")[this.active ? "last" : "first"]())), undefined) : (this.next(t), undefined)
        },
        previousPage: function(t) {
            var i, a, n;
            return this.active ? (this.isFirstItem() || (this._hasScroll() ? (a = this.active.offset().top, n = this.element.height(), this.active.prevAll(".ui-menu-item").each(function() {
                return i = e(this), i.offset().top - a + n > 0
            }), this.focus(t, i)) : this.focus(t, this.activeMenu.children(".ui-menu-item").first())), undefined) : (this.next(t), undefined)
        },
        _hasScroll: function() {
            return this.element.outerHeight() < this.element.prop("scrollHeight")
        },
        select: function(t) {
            this.active = this.active || e(t.target).closest(".ui-menu-item");
            var i = {
                item: this.active
            };
            this.active.has(".ui-menu").length || this.collapseAll(t, !0), this._trigger("select", t, i)
        }
    })
})(jQuery);
(function(e, t) {
    e.widget("ui.progressbar", {
        version: "1.9.2",
        options: {
            value: 0,
            max: 100
        },
        min: 0,
        _create: function() {
            this.element.addClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").attr({
                role: "progressbar",
                "aria-valuemin": this.min,
                "aria-valuemax": this.options.max,
                "aria-valuenow": this._value()
            }), this.valueDiv = e("<div class='ui-progressbar-value ui-widget-header ui-corner-left'></div>").appendTo(this.element), this.oldValue = this._value(), this._refreshValue()
        },
        _destroy: function() {
            this.element.removeClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow"), this.valueDiv.remove()
        },
        value: function(e) {
            return e === t ? this._value() : (this._setOption("value", e), this)
        },
        _setOption: function(e, t) {
            "value" === e && (this.options.value = t, this._refreshValue(), this._value() === this.options.max && this._trigger("complete")), this._super(e, t)
        },
        _value: function() {
            var e = this.options.value;
            return "number" != typeof e && (e = 0), Math.min(this.options.max, Math.max(this.min, e))
        },
        _percentage: function() {
            return 100 * this._value() / this.options.max
        },
        _refreshValue: function() {
            var e = this.value(),
                t = this._percentage();
            this.oldValue !== e && (this.oldValue = e, this._trigger("change")), this.valueDiv.toggle(e > this.min).toggleClass("ui-corner-right", e === this.options.max).width(t.toFixed(0) + "%"), this.element.attr("aria-valuenow", e)
        }
    })
})(jQuery);
(function(e) {
    var t = 5;
    e.widget("ui.slider", e.ui.mouse, {
        version: "1.9.2",
        widgetEventPrefix: "slide",
        options: {
            animate: !1,
            distance: 0,
            max: 100,
            min: 0,
            orientation: "horizontal",
            range: !1,
            step: 1,
            value: 0,
            values: null
        },
        _create: function() {
            var i, a, s = this.options,
                n = this.element.find(".ui-slider-handle").addClass("ui-state-default ui-corner-all"),
                r = "<a class='ui-slider-handle ui-state-default ui-corner-all' href='#'></a>",
                o = [];
            for (this._keySliding = !1, this._mouseSliding = !1, this._animateOff = !0, this._handleIndex = null, this._detectOrientation(), this._mouseInit(), this.element.addClass("ui-slider ui-slider-" + this.orientation + " ui-widget" + " ui-widget-content" + " ui-corner-all" + (s.disabled ? " ui-slider-disabled ui-disabled" : "")), this.range = e([]), s.range && (s.range === !0 && (s.values || (s.values = [this._valueMin(), this._valueMin()]), s.values.length && 2 !== s.values.length && (s.values = [s.values[0], s.values[0]])), this.range = e("<div></div>").appendTo(this.element).addClass("ui-slider-range ui-widget-header" + ("min" === s.range || "max" === s.range ? " ui-slider-range-" + s.range : ""))), a = s.values && s.values.length || 1, i = n.length; a > i; i++) o.push(r);
            this.handles = n.add(e(o.join("")).appendTo(this.element)), this.handle = this.handles.eq(0), this.handles.add(this.range).filter("a").click(function(e) {
                e.preventDefault()
            }).mouseenter(function() {
                s.disabled || e(this).addClass("ui-state-hover")
            }).mouseleave(function() {
                e(this).removeClass("ui-state-hover")
            }).focus(function() {
                s.disabled ? e(this).blur() : (e(".ui-slider .ui-state-focus").removeClass("ui-state-focus"), e(this).addClass("ui-state-focus"))
            }).blur(function() {
                e(this).removeClass("ui-state-focus")
            }), this.handles.each(function(t) {
                e(this).data("ui-slider-handle-index", t)
            }), this._on(this.handles, {
                keydown: function(i) {
                    var a, s, n, r, o = e(i.target).data("ui-slider-handle-index");
                    switch (i.keyCode) {
                        case e.ui.keyCode.HOME:
                        case e.ui.keyCode.END:
                        case e.ui.keyCode.PAGE_UP:
                        case e.ui.keyCode.PAGE_DOWN:
                        case e.ui.keyCode.UP:
                        case e.ui.keyCode.RIGHT:
                        case e.ui.keyCode.DOWN:
                        case e.ui.keyCode.LEFT:
                            if (i.preventDefault(), !this._keySliding && (this._keySliding = !0, e(i.target).addClass("ui-state-active"), a = this._start(i, o), a === !1)) return
                    }
                    switch (r = this.options.step, s = n = this.options.values && this.options.values.length ? this.values(o) : this.value(), i.keyCode) {
                        case e.ui.keyCode.HOME:
                            n = this._valueMin();
                            break;
                        case e.ui.keyCode.END:
                            n = this._valueMax();
                            break;
                        case e.ui.keyCode.PAGE_UP:
                            n = this._trimAlignValue(s + (this._valueMax() - this._valueMin()) / t);
                            break;
                        case e.ui.keyCode.PAGE_DOWN:
                            n = this._trimAlignValue(s - (this._valueMax() - this._valueMin()) / t);
                            break;
                        case e.ui.keyCode.UP:
                        case e.ui.keyCode.RIGHT:
                            if (s === this._valueMax()) return;
                            n = this._trimAlignValue(s + r);
                            break;
                        case e.ui.keyCode.DOWN:
                        case e.ui.keyCode.LEFT:
                            if (s === this._valueMin()) return;
                            n = this._trimAlignValue(s - r)
                    }
                    this._slide(i, o, n)
                },
                keyup: function(t) {
                    var i = e(t.target).data("ui-slider-handle-index");
                    this._keySliding && (this._keySliding = !1, this._stop(t, i), this._change(t, i), e(t.target).removeClass("ui-state-active"))
                }
            }), this._refreshValue(), this._animateOff = !1
        },
        _destroy: function() {
            this.handles.remove(), this.range.remove(), this.element.removeClass("ui-slider ui-slider-horizontal ui-slider-vertical ui-slider-disabled ui-widget ui-widget-content ui-corner-all"), this._mouseDestroy()
        },
        _mouseCapture: function(t) {
            var i, a, s, n, r, o, l, h, u = this,
                d = this.options;
            return d.disabled ? !1 : (this.elementSize = {
                width: this.element.outerWidth(),
                height: this.element.outerHeight()
            }, this.elementOffset = this.element.offset(), i = {
                x: t.pageX,
                y: t.pageY
            }, a = this._normValueFromMouse(i), s = this._valueMax() - this._valueMin() + 1, this.handles.each(function(t) {
                var i = Math.abs(a - u.values(t));
                s > i && (s = i, n = e(this), r = t)
            }), d.range === !0 && this.values(1) === d.min && (r += 1, n = e(this.handles[r])), o = this._start(t, r), o === !1 ? !1 : (this._mouseSliding = !0, this._handleIndex = r, n.addClass("ui-state-active").focus(), l = n.offset(), h = !e(t.target).parents().andSelf().is(".ui-slider-handle"), this._clickOffset = h ? {
                left: 0,
                top: 0
            } : {
                left: t.pageX - l.left - n.width() / 2,
                top: t.pageY - l.top - n.height() / 2 - (parseInt(n.css("borderTopWidth"), 10) || 0) - (parseInt(n.css("borderBottomWidth"), 10) || 0) + (parseInt(n.css("marginTop"), 10) || 0)
            }, this.handles.hasClass("ui-state-hover") || this._slide(t, r, a), this._animateOff = !0, !0))
        },
        _mouseStart: function() {
            return !0
        },
        _mouseDrag: function(e) {
            var t = {
                    x: e.pageX,
                    y: e.pageY
                },
                i = this._normValueFromMouse(t);
            return this._slide(e, this._handleIndex, i), !1
        },
        _mouseStop: function(e) {
            return this.handles.removeClass("ui-state-active"), this._mouseSliding = !1, this._stop(e, this._handleIndex), this._change(e, this._handleIndex), this._handleIndex = null, this._clickOffset = null, this._animateOff = !1, !1
        },
        _detectOrientation: function() {
            this.orientation = "vertical" === this.options.orientation ? "vertical" : "horizontal"
        },
        _normValueFromMouse: function(e) {
            var t, i, a, s, n;
            return "horizontal" === this.orientation ? (t = this.elementSize.width, i = e.x - this.elementOffset.left - (this._clickOffset ? this._clickOffset.left : 0)) : (t = this.elementSize.height, i = e.y - this.elementOffset.top - (this._clickOffset ? this._clickOffset.top : 0)), a = i / t, a > 1 && (a = 1), 0 > a && (a = 0), "vertical" === this.orientation && (a = 1 - a), s = this._valueMax() - this._valueMin(), n = this._valueMin() + a * s, this._trimAlignValue(n)
        },
        _start: function(e, t) {
            var i = {
                handle: this.handles[t],
                value: this.value()
            };
            return this.options.values && this.options.values.length && (i.value = this.values(t), i.values = this.values()), this._trigger("start", e, i)
        },
        _slide: function(e, t, i) {
            var a, s, n;
            this.options.values && this.options.values.length ? (a = this.values(t ? 0 : 1), 2 === this.options.values.length && this.options.range === !0 && (0 === t && i > a || 1 === t && a > i) && (i = a), i !== this.values(t) && (s = this.values(), s[t] = i, n = this._trigger("slide", e, {
                handle: this.handles[t],
                value: i,
                values: s
            }), a = this.values(t ? 0 : 1), n !== !1 && this.values(t, i, !0))) : i !== this.value() && (n = this._trigger("slide", e, {
                handle: this.handles[t],
                value: i
            }), n !== !1 && this.value(i))
        },
        _stop: function(e, t) {
            var i = {
                handle: this.handles[t],
                value: this.value()
            };
            this.options.values && this.options.values.length && (i.value = this.values(t), i.values = this.values()), this._trigger("stop", e, i)
        },
        _change: function(e, t) {
            if (!this._keySliding && !this._mouseSliding) {
                var i = {
                    handle: this.handles[t],
                    value: this.value()
                };
                this.options.values && this.options.values.length && (i.value = this.values(t), i.values = this.values()), this._trigger("change", e, i)
            }
        },
        value: function(e) {
            return arguments.length ? (this.options.value = this._trimAlignValue(e), this._refreshValue(), this._change(null, 0), undefined) : this._value()
        },
        values: function(t, i) {
            var a, s, n;
            if (arguments.length > 1) return this.options.values[t] = this._trimAlignValue(i), this._refreshValue(), this._change(null, t), undefined;
            if (!arguments.length) return this._values();
            if (!e.isArray(arguments[0])) return this.options.values && this.options.values.length ? this._values(t) : this.value();
            for (a = this.options.values, s = arguments[0], n = 0; a.length > n; n += 1) a[n] = this._trimAlignValue(s[n]), this._change(null, n);
            this._refreshValue()
        },
        _setOption: function(t, i) {
            var a, s = 0;
            switch (e.isArray(this.options.values) && (s = this.options.values.length), e.Widget.prototype._setOption.apply(this, arguments), t) {
                case "disabled":
                    i ? (this.handles.filter(".ui-state-focus").blur(), this.handles.removeClass("ui-state-hover"), this.handles.prop("disabled", !0), this.element.addClass("ui-disabled")) : (this.handles.prop("disabled", !1), this.element.removeClass("ui-disabled"));
                    break;
                case "orientation":
                    this._detectOrientation(), this.element.removeClass("ui-slider-horizontal ui-slider-vertical").addClass("ui-slider-" + this.orientation), this._refreshValue();
                    break;
                case "value":
                    this._animateOff = !0, this._refreshValue(), this._change(null, 0), this._animateOff = !1;
                    break;
                case "values":
                    for (this._animateOff = !0, this._refreshValue(), a = 0; s > a; a += 1) this._change(null, a);
                    this._animateOff = !1;
                    break;
                case "min":
                case "max":
                    this._animateOff = !0, this._refreshValue(), this._animateOff = !1
            }
        },
        _value: function() {
            var e = this.options.value;
            return e = this._trimAlignValue(e)
        },
        _values: function(e) {
            var t, i, a;
            if (arguments.length) return t = this.options.values[e], t = this._trimAlignValue(t);
            for (i = this.options.values.slice(), a = 0; i.length > a; a += 1) i[a] = this._trimAlignValue(i[a]);
            return i
        },
        _trimAlignValue: function(e) {
            if (this._valueMin() >= e) return this._valueMin();
            if (e >= this._valueMax()) return this._valueMax();
            var t = this.options.step > 0 ? this.options.step : 1,
                i = (e - this._valueMin()) % t,
                a = e - i;
            return 2 * Math.abs(i) >= t && (a += i > 0 ? t : -t), parseFloat(a.toFixed(5))
        },
        _valueMin: function() {
            return this.options.min
        },
        _valueMax: function() {
            return this.options.max
        },
        _refreshValue: function() {
            var t, i, a, s, n, r = this.options.range,
                o = this.options,
                l = this,
                h = this._animateOff ? !1 : o.animate,
                u = {};
            this.options.values && this.options.values.length ? this.handles.each(function(a) {
                i = 100 * ((l.values(a) - l._valueMin()) / (l._valueMax() - l._valueMin())), u["horizontal" === l.orientation ? "left" : "bottom"] = i + "%", e(this).stop(1, 1)[h ? "animate" : "css"](u, o.animate), l.options.range === !0 && ("horizontal" === l.orientation ? (0 === a && l.range.stop(1, 1)[h ? "animate" : "css"]({
                    left: i + "%"
                }, o.animate), 1 === a && l.range[h ? "animate" : "css"]({
                    width: i - t + "%"
                }, {
                    queue: !1,
                    duration: o.animate
                })) : (0 === a && l.range.stop(1, 1)[h ? "animate" : "css"]({
                    bottom: i + "%"
                }, o.animate), 1 === a && l.range[h ? "animate" : "css"]({
                    height: i - t + "%"
                }, {
                    queue: !1,
                    duration: o.animate
                }))), t = i
            }) : (a = this.value(), s = this._valueMin(), n = this._valueMax(), i = n !== s ? 100 * ((a - s) / (n - s)) : 0, u["horizontal" === this.orientation ? "left" : "bottom"] = i + "%", this.handle.stop(1, 1)[h ? "animate" : "css"](u, o.animate), "min" === r && "horizontal" === this.orientation && this.range.stop(1, 1)[h ? "animate" : "css"]({
                width: i + "%"
            }, o.animate), "max" === r && "horizontal" === this.orientation && this.range[h ? "animate" : "css"]({
                width: 100 - i + "%"
            }, {
                queue: !1,
                duration: o.animate
            }), "min" === r && "vertical" === this.orientation && this.range.stop(1, 1)[h ? "animate" : "css"]({
                height: i + "%"
            }, o.animate), "max" === r && "vertical" === this.orientation && this.range[h ? "animate" : "css"]({
                height: 100 - i + "%"
            }, {
                queue: !1,
                duration: o.animate
            }))
        }
    })
})(jQuery);
(function(e) {
    function t(e) {
        return function() {
            var t = this.element.val();
            e.apply(this, arguments), this._refresh(), t !== this.element.val() && this._trigger("change")
        }
    }
    e.widget("ui.spinner", {
        version: "1.9.2",
        defaultElement: "<input>",
        widgetEventPrefix: "spin",
        options: {
            culture: null,
            icons: {
                down: "ui-icon-triangle-1-s",
                up: "ui-icon-triangle-1-n"
            },
            incremental: !0,
            max: null,
            min: null,
            numberFormat: null,
            page: 10,
            step: 1,
            change: null,
            spin: null,
            start: null,
            stop: null
        },
        _create: function() {
            this._setOption("max", this.options.max), this._setOption("min", this.options.min), this._setOption("step", this.options.step), this._value(this.element.val(), !0), this._draw(), this._on(this._events), this._refresh(), this._on(this.window, {
                beforeunload: function() {
                    this.element.removeAttr("autocomplete")
                }
            })
        },
        _getCreateOptions: function() {
            var t = {},
                i = this.element;
            return e.each(["min", "max", "step"], function(e, a) {
                var s = i.attr(a);
                void 0 !== s && s.length && (t[a] = s)
            }), t
        },
        _events: {
            keydown: function(e) {
                this._start(e) && this._keydown(e) && e.preventDefault()
            },
            keyup: "_stop",
            focus: function() {
                this.previous = this.element.val()
            },
            blur: function(e) {
                return this.cancelBlur ? (delete this.cancelBlur, void 0) : (this._refresh(), this.previous !== this.element.val() && this._trigger("change", e), void 0)
            },
            mousewheel: function(e, t) {
                if (t) {
                    if (!this.spinning && !this._start(e)) return !1;
                    this._spin((t > 0 ? 1 : -1) * this.options.step, e), clearTimeout(this.mousewheelTimer), this.mousewheelTimer = this._delay(function() {
                        this.spinning && this._stop(e)
                    }, 100), e.preventDefault()
                }
            },
            "mousedown .ui-spinner-button": function(t) {
                function i() {
                    var e = this.element[0] === this.document[0].activeElement;
                    e || (this.element.focus(), this.previous = a, this._delay(function() {
                        this.previous = a
                    }))
                }
                var a;
                a = this.element[0] === this.document[0].activeElement ? this.previous : this.element.val(), t.preventDefault(), i.call(this), this.cancelBlur = !0, this._delay(function() {
                    delete this.cancelBlur, i.call(this)
                }), this._start(t) !== !1 && this._repeat(null, e(t.currentTarget).hasClass("ui-spinner-up") ? 1 : -1, t)
            },
            "mouseup .ui-spinner-button": "_stop",
            "mouseenter .ui-spinner-button": function(t) {
                return e(t.currentTarget).hasClass("ui-state-active") ? this._start(t) === !1 ? !1 : (this._repeat(null, e(t.currentTarget).hasClass("ui-spinner-up") ? 1 : -1, t), void 0) : void 0
            },
            "mouseleave .ui-spinner-button": "_stop"
        },
        _draw: function() {
            var e = this.uiSpinner = this.element.addClass("ui-spinner-input").attr("autocomplete", "off").wrap(this._uiSpinnerHtml()).parent().append(this._buttonHtml());
            this.element.attr("role", "spinbutton"), this.buttons = e.find(".ui-spinner-button").attr("tabIndex", -1).button().removeClass("ui-corner-all"), this.buttons.height() > Math.ceil(.5 * e.height()) && e.height() > 0 && e.height(e.height()), this.options.disabled && this.disable()
        },
        _keydown: function(t) {
            var i = this.options,
                a = e.ui.keyCode;
            switch (t.keyCode) {
                case a.UP:
                    return this._repeat(null, 1, t), !0;
                case a.DOWN:
                    return this._repeat(null, -1, t), !0;
                case a.PAGE_UP:
                    return this._repeat(null, i.page, t), !0;
                case a.PAGE_DOWN:
                    return this._repeat(null, -i.page, t), !0
            }
            return !1
        },
        _uiSpinnerHtml: function() {
            return "<span class='ui-spinner ui-widget ui-widget-content ui-corner-all'></span>"
        },
        _buttonHtml: function() {
            return "<a class='ui-spinner-button ui-spinner-up ui-corner-tr'><span class='ui-icon " + this.options.icons.up + "'>&#9650;</span>" + "</a>" + "<a class='ui-spinner-button ui-spinner-down ui-corner-br'>" + "<span class='ui-icon " + this.options.icons.down + "'>&#9660;</span>" + "</a>"
        },
        _start: function(e) {
            return this.spinning || this._trigger("start", e) !== !1 ? (this.counter || (this.counter = 1), this.spinning = !0, !0) : !1
        },
        _repeat: function(e, t, i) {
            e = e || 500, clearTimeout(this.timer), this.timer = this._delay(function() {
                this._repeat(40, t, i)
            }, e), this._spin(t * this.options.step, i)
        },
        _spin: function(e, t) {
            var i = this.value() || 0;
            this.counter || (this.counter = 1), i = this._adjustValue(i + e * this._increment(this.counter)), this.spinning && this._trigger("spin", t, {
                value: i
            }) === !1 || (this._value(i), this.counter++)
        },
        _increment: function(t) {
            var i = this.options.incremental;
            return i ? e.isFunction(i) ? i(t) : Math.floor(t * t * t / 5e4 - t * t / 500 + 17 * t / 200 + 1) : 1
        },
        _precision: function() {
            var e = this._precisionOf(this.options.step);
            return null !== this.options.min && (e = Math.max(e, this._precisionOf(this.options.min))), e
        },
        _precisionOf: function(e) {
            var t = "" + e,
                i = t.indexOf(".");
            return -1 === i ? 0 : t.length - i - 1
        },
        _adjustValue: function(e) {
            var t, i, a = this.options;
            return t = null !== a.min ? a.min : 0, i = e - t, i = Math.round(i / a.step) * a.step, e = t + i, e = parseFloat(e.toFixed(this._precision())), null !== a.max && e > a.max ? a.max : null !== a.min && a.min > e ? a.min : e
        },
        _stop: function(e) {
            this.spinning && (clearTimeout(this.timer), clearTimeout(this.mousewheelTimer), this.counter = 0, this.spinning = !1, this._trigger("stop", e))
        },
        _setOption: function(e, t) {
            if ("culture" === e || "numberFormat" === e) {
                var i = this._parse(this.element.val());
                return this.options[e] = t, this.element.val(this._format(i)), void 0
            }("max" === e || "min" === e || "step" === e) && "string" == typeof t && (t = this._parse(t)), this._super(e, t), "disabled" === e && (t ? (this.element.prop("disabled", !0), this.buttons.button("disable")) : (this.element.prop("disabled", !1), this.buttons.button("enable")))
        },
        _setOptions: t(function(e) {
            this._super(e), this._value(this.element.val())
        }),
        _parse: function(e) {
            return "string" == typeof e && "" !== e && (e = window.Globalize && this.options.numberFormat ? Globalize.parseFloat(e, 10, this.options.culture) : +e), "" === e || isNaN(e) ? null : e
        },
        _format: function(e) {
            return "" === e ? "" : window.Globalize && this.options.numberFormat ? Globalize.format(e, this.options.numberFormat, this.options.culture) : e
        },
        _refresh: function() {
            this.element.attr({
                "aria-valuemin": this.options.min,
                "aria-valuemax": this.options.max,
                "aria-valuenow": this._parse(this.element.val())
            })
        },
        _value: function(e, t) {
            var i;
            "" !== e && (i = this._parse(e), null !== i && (t || (i = this._adjustValue(i)), e = this._format(i))), this.element.val(e), this._refresh()
        },
        _destroy: function() {
            this.element.removeClass("ui-spinner-input").prop("disabled", !1).removeAttr("autocomplete").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow"), this.uiSpinner.replaceWith(this.element)
        },
        stepUp: t(function(e) {
            this._stepUp(e)
        }),
        _stepUp: function(e) {
            this._spin((e || 1) * this.options.step)
        },
        stepDown: t(function(e) {
            this._stepDown(e)
        }),
        _stepDown: function(e) {
            this._spin((e || 1) * -this.options.step)
        },
        pageUp: t(function(e) {
            this._stepUp((e || 1) * this.options.page)
        }),
        pageDown: t(function(e) {
            this._stepDown((e || 1) * this.options.page)
        }),
        value: function(e) {
            return arguments.length ? (t(this._value).call(this, e), void 0) : this._parse(this.element.val())
        },
        widget: function() {
            return this.uiSpinner
        }
    })
})(jQuery);
(function(e, t) {
    function i() {
        return ++s
    }

    function a(e) {
        return e.hash.length > 1 && e.href.replace(n, "") === location.href.replace(n, "").replace(/\s/g, "%20")
    }
    var s = 0,
        n = /#.*$/;
    e.widget("ui.tabs", {
        version: "1.9.2",
        delay: 300,
        options: {
            active: null,
            collapsible: !1,
            event: "click",
            heightStyle: "content",
            hide: null,
            show: null,
            activate: null,
            beforeActivate: null,
            beforeLoad: null,
            load: null
        },
        _create: function() {
            var i = this,
                a = this.options,
                s = a.active,
                n = location.hash.substring(1);
            this.running = !1, this.element.addClass("ui-tabs ui-widget ui-widget-content ui-corner-all").toggleClass("ui-tabs-collapsible", a.collapsible).delegate(".ui-tabs-nav > li", "mousedown" + this.eventNamespace, function(t) {
                e(this).is(".ui-state-disabled") && t.preventDefault()
            }).delegate(".ui-tabs-anchor", "focus" + this.eventNamespace, function() {
                e(this).closest("li").is(".ui-state-disabled") && this.blur()
            }), this._processTabs(), null === s && (n && this.tabs.each(function(i, a) {
                return e(a).attr("aria-controls") === n ? (s = i, !1) : t
            }), null === s && (s = this.tabs.index(this.tabs.filter(".ui-tabs-active"))), (null === s || -1 === s) && (s = this.tabs.length ? 0 : !1)), s !== !1 && (s = this.tabs.index(this.tabs.eq(s)), -1 === s && (s = a.collapsible ? !1 : 0)), a.active = s, !a.collapsible && a.active === !1 && this.anchors.length && (a.active = 0), e.isArray(a.disabled) && (a.disabled = e.unique(a.disabled.concat(e.map(this.tabs.filter(".ui-state-disabled"), function(e) {
                return i.tabs.index(e)
            }))).sort()), this.active = this.options.active !== !1 && this.anchors.length ? this._findActive(this.options.active) : e(), this._refresh(), this.active.length && this.load(a.active)
        },
        _getCreateEventData: function() {
            return {
                tab: this.active,
                panel: this.active.length ? this._getPanelForTab(this.active) : e()
            }
        },
        _tabKeydown: function(i) {
            var a = e(this.document[0].activeElement).closest("li"),
                s = this.tabs.index(a),
                n = !0;
            if (!this._handlePageNav(i)) {
                switch (i.keyCode) {
                    case e.ui.keyCode.RIGHT:
                    case e.ui.keyCode.DOWN:
                        s++;
                        break;
                    case e.ui.keyCode.UP:
                    case e.ui.keyCode.LEFT:
                        n = !1, s--;
                        break;
                    case e.ui.keyCode.END:
                        s = this.anchors.length - 1;
                        break;
                    case e.ui.keyCode.HOME:
                        s = 0;
                        break;
                    case e.ui.keyCode.SPACE:
                        return i.preventDefault(), clearTimeout(this.activating), this._activate(s), t;
                    case e.ui.keyCode.ENTER:
                        return i.preventDefault(), clearTimeout(this.activating), this._activate(s === this.options.active ? !1 : s), t;
                    default:
                        return
                }
                i.preventDefault(), clearTimeout(this.activating), s = this._focusNextTab(s, n), i.ctrlKey || (a.attr("aria-selected", "false"), this.tabs.eq(s).attr("aria-selected", "true"), this.activating = this._delay(function() {
                    this.option("active", s)
                }, this.delay))
            }
        },
        _panelKeydown: function(t) {
            this._handlePageNav(t) || t.ctrlKey && t.keyCode === e.ui.keyCode.UP && (t.preventDefault(), this.active.focus())
        },
        _handlePageNav: function(i) {
            return i.altKey && i.keyCode === e.ui.keyCode.PAGE_UP ? (this._activate(this._focusNextTab(this.options.active - 1, !1)), !0) : i.altKey && i.keyCode === e.ui.keyCode.PAGE_DOWN ? (this._activate(this._focusNextTab(this.options.active + 1, !0)), !0) : t
        },
        _findNextTab: function(t, i) {
            function a() {
                return t > s && (t = 0), 0 > t && (t = s), t
            }
            for (var s = this.tabs.length - 1; - 1 !== e.inArray(a(), this.options.disabled);) t = i ? t + 1 : t - 1;
            return t
        },
        _focusNextTab: function(e, t) {
            return e = this._findNextTab(e, t), this.tabs.eq(e).focus(), e
        },
        _setOption: function(e, i) {
            return "active" === e ? (this._activate(i), t) : "disabled" === e ? (this._setupDisabled(i), t) : (this._super(e, i), "collapsible" === e && (this.element.toggleClass("ui-tabs-collapsible", i), i || this.options.active !== !1 || this._activate(0)), "event" === e && this._setupEvents(i), "heightStyle" === e && this._setupHeightStyle(i), t)
        },
        _tabId: function(e) {
            return e.attr("aria-controls") || "ui-tabs-" + i()
        },
        _sanitizeSelector: function(e) {
            return e ? e.replace(/[!"$%&'()*+,.\/:;<=>?@\[\]\^`{|}~]/g, "\\$&") : ""
        },
        refresh: function() {
            var t = this.options,
                i = this.tablist.children(":has(a[href])");
            t.disabled = e.map(i.filter(".ui-state-disabled"), function(e) {
                return i.index(e)
            }), this._processTabs(), t.active !== !1 && this.anchors.length ? this.active.length && !e.contains(this.tablist[0], this.active[0]) ? this.tabs.length === t.disabled.length ? (t.active = !1, this.active = e()) : this._activate(this._findNextTab(Math.max(0, t.active - 1), !1)) : t.active = this.tabs.index(this.active) : (t.active = !1, this.active = e()), this._refresh()
        },
        _refresh: function() {
            this._setupDisabled(this.options.disabled), this._setupEvents(this.options.event), this._setupHeightStyle(this.options.heightStyle), this.tabs.not(this.active).attr({
                "aria-selected": "false",
                tabIndex: -1
            }), this.panels.not(this._getPanelForTab(this.active)).hide().attr({
                "aria-expanded": "false",
                "aria-hidden": "true"
            }), this.active.length ? (this.active.addClass("ui-tabs-active ui-state-active").attr({
                "aria-selected": "true",
                tabIndex: 0
            }), this._getPanelForTab(this.active).show().attr({
                "aria-expanded": "true",
                "aria-hidden": "false"
            })) : this.tabs.eq(0).attr("tabIndex", 0)
        },
        _processTabs: function() {
            var t = this;
            this.tablist = this._getList().addClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all").attr("role", "tablist"), this.tabs = this.tablist.find("> li:has(a[href])").addClass("ui-state-default ui-corner-top").attr({
                role: "tab",
                tabIndex: -1
            }), this.anchors = this.tabs.map(function() {
                return e("a", this)[0]
            }).addClass("ui-tabs-anchor").attr({
                role: "presentation",
                tabIndex: -1
            }), this.panels = e(), this.anchors.each(function(i, s) {
                var n, r, o, h = e(s).uniqueId().attr("id"),
                    l = e(s).closest("li"),
                    u = l.attr("aria-controls");
                a(s) ? (n = s.hash, r = t.element.find(t._sanitizeSelector(n))) : (o = t._tabId(l), n = "#" + o, r = t.element.find(n), r.length || (r = t._createPanel(o), r.insertAfter(t.panels[i - 1] || t.tablist)), r.attr("aria-live", "polite")), r.length && (t.panels = t.panels.add(r)), u && l.data("ui-tabs-aria-controls", u), l.attr({
                    "aria-controls": n.substring(1),
                    "aria-labelledby": h
                }), r.attr("aria-labelledby", h)
            }), this.panels.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").attr("role", "tabpanel")
        },
        _getList: function() {
            return this.element.find("ol,ul").eq(0)
        },
        _createPanel: function(t) {
            return e("<div>").attr("id", t).addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").data("ui-tabs-destroy", !0)
        },
        _setupDisabled: function(t) {
            e.isArray(t) && (t.length ? t.length === this.anchors.length && (t = !0) : t = !1);
            for (var i, a = 0; i = this.tabs[a]; a++) t === !0 || -1 !== e.inArray(a, t) ? e(i).addClass("ui-state-disabled").attr("aria-disabled", "true") : e(i).removeClass("ui-state-disabled").removeAttr("aria-disabled");
            this.options.disabled = t
        },
        _setupEvents: function(t) {
            var i = {
                click: function(e) {
                    e.preventDefault()
                }
            };
            t && e.each(t.split(" "), function(e, t) {
                i[t] = "_eventHandler"
            }), this._off(this.anchors.add(this.tabs).add(this.panels)), this._on(this.anchors, i), this._on(this.tabs, {
                keydown: "_tabKeydown"
            }), this._on(this.panels, {
                keydown: "_panelKeydown"
            }), this._focusable(this.tabs), this._hoverable(this.tabs)
        },
        _setupHeightStyle: function(t) {
            var i, a, s = this.element.parent();
            "fill" === t ? (e.support.minHeight || (a = s.css("overflow"), s.css("overflow", "hidden")), i = s.height(), this.element.siblings(":visible").each(function() {
                var t = e(this),
                    a = t.css("position");
                "absolute" !== a && "fixed" !== a && (i -= t.outerHeight(!0))
            }), a && s.css("overflow", a), this.element.children().not(this.panels).each(function() {
                i -= e(this).outerHeight(!0)
            }), this.panels.each(function() {
                e(this).height(Math.max(0, i - e(this).innerHeight() + e(this).height()))
            }).css("overflow", "auto")) : "auto" === t && (i = 0, this.panels.each(function() {
                i = Math.max(i, e(this).height("").height())
            }).height(i))
        },
        _eventHandler: function(t) {
            var i = this.options,
                a = this.active,
                s = e(t.currentTarget),
                n = s.closest("li"),
                r = n[0] === a[0],
                o = r && i.collapsible,
                h = o ? e() : this._getPanelForTab(n),
                l = a.length ? this._getPanelForTab(a) : e(),
                u = {
                    oldTab: a,
                    oldPanel: l,
                    newTab: o ? e() : n,
                    newPanel: h
                };
            t.preventDefault(), n.hasClass("ui-state-disabled") || n.hasClass("ui-tabs-loading") || this.running || r && !i.collapsible || this._trigger("beforeActivate", t, u) === !1 || (i.active = o ? !1 : this.tabs.index(n), this.active = r ? e() : n, this.xhr && this.xhr.abort(), l.length || h.length || e.error("jQuery UI Tabs: Mismatching fragment identifier."), h.length && this.load(this.tabs.index(n), t), this._toggle(t, u))
        },
        _toggle: function(t, i) {
            function a() {
                n.running = !1, n._trigger("activate", t, i)
            }

            function s() {
                i.newTab.closest("li").addClass("ui-tabs-active ui-state-active"), r.length && n.options.show ? n._show(r, n.options.show, a) : (r.show(), a())
            }
            var n = this,
                r = i.newPanel,
                o = i.oldPanel;
            this.running = !0, o.length && this.options.hide ? this._hide(o, this.options.hide, function() {
                i.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), s()
            }) : (i.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), o.hide(), s()), o.attr({
                "aria-expanded": "false",
                "aria-hidden": "true"
            }), i.oldTab.attr("aria-selected", "false"), r.length && o.length ? i.oldTab.attr("tabIndex", -1) : r.length && this.tabs.filter(function() {
                return 0 === e(this).attr("tabIndex")
            }).attr("tabIndex", -1), r.attr({
                "aria-expanded": "true",
                "aria-hidden": "false"
            }), i.newTab.attr({
                "aria-selected": "true",
                tabIndex: 0
            })
        },
        _activate: function(t) {
            var i, a = this._findActive(t);
            a[0] !== this.active[0] && (a.length || (a = this.active), i = a.find(".ui-tabs-anchor")[0], this._eventHandler({
                target: i,
                currentTarget: i,
                preventDefault: e.noop
            }))
        },
        _findActive: function(t) {
            return t === !1 ? e() : this.tabs.eq(t)
        },
        _getIndex: function(e) {
            return "string" == typeof e && (e = this.anchors.index(this.anchors.filter("[href$='" + e + "']"))), e
        },
        _destroy: function() {
            this.xhr && this.xhr.abort(), this.element.removeClass("ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible"), this.tablist.removeClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all").removeAttr("role"), this.anchors.removeClass("ui-tabs-anchor").removeAttr("role").removeAttr("tabIndex").removeData("href.tabs").removeData("load.tabs").removeUniqueId(), this.tabs.add(this.panels).each(function() {
                e.data(this, "ui-tabs-destroy") ? e(this).remove() : e(this).removeClass("ui-state-default ui-state-active ui-state-disabled ui-corner-top ui-corner-bottom ui-widget-content ui-tabs-active ui-tabs-panel").removeAttr("tabIndex").removeAttr("aria-live").removeAttr("aria-busy").removeAttr("aria-selected").removeAttr("aria-labelledby").removeAttr("aria-hidden").removeAttr("aria-expanded").removeAttr("role")
            }), this.tabs.each(function() {
                var t = e(this),
                    i = t.data("ui-tabs-aria-controls");
                i ? t.attr("aria-controls", i) : t.removeAttr("aria-controls")
            }), this.panels.show(), "content" !== this.options.heightStyle && this.panels.css("height", "")
        },
        enable: function(i) {
            var a = this.options.disabled;
            a !== !1 && (i === t ? a = !1 : (i = this._getIndex(i), a = e.isArray(a) ? e.map(a, function(e) {
                return e !== i ? e : null
            }) : e.map(this.tabs, function(e, t) {
                return t !== i ? t : null
            })), this._setupDisabled(a))
        },
        disable: function(i) {
            var a = this.options.disabled;
            if (a !== !0) {
                if (i === t) a = !0;
                else {
                    if (i = this._getIndex(i), -1 !== e.inArray(i, a)) return;
                    a = e.isArray(a) ? e.merge([i], a).sort() : [i]
                }
                this._setupDisabled(a)
            }
        },
        load: function(t, i) {
            t = this._getIndex(t);
            var s = this,
                n = this.tabs.eq(t),
                r = n.find(".ui-tabs-anchor"),
                o = this._getPanelForTab(n),
                h = {
                    tab: n,
                    panel: o
                };
            a(r[0]) || (this.xhr = e.ajax(this._ajaxSettings(r, i, h)), this.xhr && "canceled" !== this.xhr.statusText && (n.addClass("ui-tabs-loading"), o.attr("aria-busy", "true"), this.xhr.success(function(e) {
                setTimeout(function() {
                    o.html(e), s._trigger("load", i, h)
                }, 1)
            }).complete(function(e, t) {
                setTimeout(function() {
                    "abort" === t && s.panels.stop(!1, !0), n.removeClass("ui-tabs-loading"), o.removeAttr("aria-busy"), e === s.xhr && delete s.xhr
                }, 1)
            })))
        },
        _ajaxSettings: function(t, i, a) {
            var s = this;
            return {
                url: t.attr("href"),
                beforeSend: function(t, n) {
                    return s._trigger("beforeLoad", i, e.extend({
                        jqXHR: t,
                        ajaxSettings: n
                    }, a))
                }
            }
        },
        _getPanelForTab: function(t) {
            var i = e(t).attr("aria-controls");
            return this.element.find(this._sanitizeSelector("#" + i))
        }
    }), e.uiBackCompat !== !1 && (e.ui.tabs.prototype._ui = function(e, t) {
        return {
            tab: e,
            panel: t,
            index: this.anchors.index(e)
        }
    }, e.widget("ui.tabs", e.ui.tabs, {
        url: function(e, t) {
            this.anchors.eq(e).attr("href", t)
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        options: {
            ajaxOptions: null,
            cache: !1
        },
        _create: function() {
            this._super();
            var i = this;
            this._on({
                tabsbeforeload: function(a, s) {
                    return e.data(s.tab[0], "cache.tabs") ? (a.preventDefault(), t) : (s.jqXHR.success(function() {
                        i.options.cache && e.data(s.tab[0], "cache.tabs", !0)
                    }), t)
                }
            })
        },
        _ajaxSettings: function(t, i, a) {
            var s = this.options.ajaxOptions;
            return e.extend({}, s, {
                error: function(e, t) {
                    try {
                        s.error(e, t, a.tab.closest("li").index(), a.tab[0])
                    } catch (i) {}
                }
            }, this._superApply(arguments))
        },
        _setOption: function(e, t) {
            "cache" === e && t === !1 && this.anchors.removeData("cache.tabs"), this._super(e, t)
        },
        _destroy: function() {
            this.anchors.removeData("cache.tabs"), this._super()
        },
        url: function(e) {
            this.anchors.eq(e).removeData("cache.tabs"), this._superApply(arguments)
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        abort: function() {
            this.xhr && this.xhr.abort()
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        options: {
            spinner: "<em>Loading&#8230;</em>"
        },
        _create: function() {
            this._super(), this._on({
                tabsbeforeload: function(e, t) {
                    if (e.target === this.element[0] && this.options.spinner) {
                        var i = t.tab.find("span"),
                            a = i.html();
                        i.html(this.options.spinner), t.jqXHR.complete(function() {
                            i.html(a)
                        })
                    }
                }
            })
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        options: {
            enable: null,
            disable: null
        },
        enable: function(t) {
            var i, a = this.options;
            (t && a.disabled === !0 || e.isArray(a.disabled) && -1 !== e.inArray(t, a.disabled)) && (i = !0), this._superApply(arguments), i && this._trigger("enable", null, this._ui(this.anchors[t], this.panels[t]))
        },
        disable: function(t) {
            var i, a = this.options;
            (t && a.disabled === !1 || e.isArray(a.disabled) && -1 === e.inArray(t, a.disabled)) && (i = !0), this._superApply(arguments), i && this._trigger("disable", null, this._ui(this.anchors[t], this.panels[t]))
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        options: {
            add: null,
            remove: null,
            tabTemplate: "<li><a href='#{href}'><span>#{label}</span></a></li>"
        },
        add: function(i, a, s) {
            s === t && (s = this.anchors.length);
            var n, r, o = this.options,
                h = e(o.tabTemplate.replace(/#\{href\}/g, i).replace(/#\{label\}/g, a)),
                l = i.indexOf("#") ? this._tabId(h) : i.replace("#", "");
            return h.addClass("ui-state-default ui-corner-top").data("ui-tabs-destroy", !0), h.attr("aria-controls", l), n = s >= this.tabs.length, r = this.element.find("#" + l), r.length || (r = this._createPanel(l), n ? s > 0 ? r.insertAfter(this.panels.eq(-1)) : r.appendTo(this.element) : r.insertBefore(this.panels[s])), r.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").hide(), n ? h.appendTo(this.tablist) : h.insertBefore(this.tabs[s]), o.disabled = e.map(o.disabled, function(e) {
                return e >= s ? ++e : e
            }), this.refresh(), 1 === this.tabs.length && o.active === !1 && this.option("active", 0), this._trigger("add", null, this._ui(this.anchors[s], this.panels[s])), this
        },
        remove: function(t) {
            t = this._getIndex(t);
            var i = this.options,
                a = this.tabs.eq(t).remove(),
                s = this._getPanelForTab(a).remove();
            return a.hasClass("ui-tabs-active") && this.anchors.length > 2 && this._activate(t + (this.anchors.length > t + 1 ? 1 : -1)), i.disabled = e.map(e.grep(i.disabled, function(e) {
                return e !== t
            }), function(e) {
                return e >= t ? --e : e
            }), this.refresh(), this._trigger("remove", null, this._ui(a.find("a")[0], s[0])), this
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        length: function() {
            return this.anchors.length
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        options: {
            idPrefix: "ui-tabs-"
        },
        _tabId: function(t) {
            var a = t.is("li") ? t.find("a[href]") : t;
            return a = a[0], e(a).closest("li").attr("aria-controls") || a.title && a.title.replace(/\s/g, "_").replace(/[^\w\u00c0-\uFFFF\-]/g, "") || this.options.idPrefix + i()
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        options: {
            panelTemplate: "<div></div>"
        },
        _createPanel: function(t) {
            return e(this.options.panelTemplate).attr("id", t).addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").data("ui-tabs-destroy", !0)
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        _create: function() {
            var e = this.options;
            null === e.active && e.selected !== t && (e.active = -1 === e.selected ? !1 : e.selected), this._super(), e.selected = e.active, e.selected === !1 && (e.selected = -1)
        },
        _setOption: function(e, t) {
            if ("selected" !== e) return this._super(e, t);
            var i = this.options;
            this._super("active", -1 === t ? !1 : t), i.selected = i.active, i.selected === !1 && (i.selected = -1)
        },
        _eventHandler: function() {
            this._superApply(arguments), this.options.selected = this.options.active, this.options.selected === !1 && (this.options.selected = -1)
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        options: {
            show: null,
            select: null
        },
        _create: function() {
            this._super(), this.options.active !== !1 && this._trigger("show", null, this._ui(this.active.find(".ui-tabs-anchor")[0], this._getPanelForTab(this.active)[0]))
        },
        _trigger: function(e, t, i) {
            var a, s, n = this._superApply(arguments);
            return n ? ("beforeActivate" === e ? (a = i.newTab.length ? i.newTab : i.oldTab, s = i.newPanel.length ? i.newPanel : i.oldPanel, n = this._super("select", t, {
                tab: a.find(".ui-tabs-anchor")[0],
                panel: s[0],
                index: a.closest("li").index()
            })) : "activate" === e && i.newTab.length && (n = this._super("show", t, {
                tab: i.newTab.find(".ui-tabs-anchor")[0],
                panel: i.newPanel[0],
                index: i.newTab.closest("li").index()
            })), n) : !1
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        select: function(e) {
            if (e = this._getIndex(e), -1 === e) {
                if (!this.options.collapsible || -1 === this.options.selected) return;
                e = this.options.selected
            }
            this.anchors.eq(e).trigger(this.options.event + this.eventNamespace)
        }
    }), function() {
        var t = 0;
        e.widget("ui.tabs", e.ui.tabs, {
            options: {
                cookie: null
            },
            _create: function() {
                var e, t = this.options;
                null == t.active && t.cookie && (e = parseInt(this._cookie(), 10), -1 === e && (e = !1), t.active = e), this._super()
            },
            _cookie: function(i) {
                var a = [this.cookie || (this.cookie = this.options.cookie.name || "ui-tabs-" + ++t)];
                return arguments.length && (a.push(i === !1 ? -1 : i), a.push(this.options.cookie)), e.cookie.apply(null, a)
            },
            _refresh: function() {
                this._super(), this.options.cookie && this._cookie(this.options.active, this.options.cookie)
            },
            _eventHandler: function() {
                this._superApply(arguments), this.options.cookie && this._cookie(this.options.active, this.options.cookie)
            },
            _destroy: function() {
                this._super(), this.options.cookie && this._cookie(null, this.options.cookie)
            }
        })
    }(), e.widget("ui.tabs", e.ui.tabs, {
        _trigger: function(t, i, a) {
            var s = e.extend({}, a);
            return "load" === t && (s.panel = s.panel[0], s.tab = s.tab.find(".ui-tabs-anchor")[0]), this._super(t, i, s)
        }
    }), e.widget("ui.tabs", e.ui.tabs, {
        options: {
            fx: null
        },
        _getFx: function() {
            var t, i, a = this.options.fx;
            return a && (e.isArray(a) ? (t = a[0], i = a[1]) : t = i = a), a ? {
                show: i,
                hide: t
            } : null
        },
        _toggle: function(e, i) {
            function a() {
                n.running = !1, n._trigger("activate", e, i)
            }

            function s() {
                i.newTab.closest("li").addClass("ui-tabs-active ui-state-active"), r.length && h.show ? r.animate(h.show, h.show.duration, function() {
                    a()
                }) : (r.show(), a())
            }
            var n = this,
                r = i.newPanel,
                o = i.oldPanel,
                h = this._getFx();
            return h ? (n.running = !0, o.length && h.hide ? o.animate(h.hide, h.hide.duration, function() {
                i.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), s()
            }) : (i.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), o.hide(), s()), t) : this._super(e, i)
        }
    }))
})(jQuery);
(function(e) {
    function t(t, i) {
        var a = (t.attr("aria-describedby") || "").split(/\s+/);
        a.push(i), t.data("ui-tooltip-id", i).attr("aria-describedby", e.trim(a.join(" ")))
    }

    function i(t) {
        var i = t.data("ui-tooltip-id"),
            a = (t.attr("aria-describedby") || "").split(/\s+/),
            s = e.inArray(i, a); - 1 !== s && a.splice(s, 1), t.removeData("ui-tooltip-id"), a = e.trim(a.join(" ")), a ? t.attr("aria-describedby", a) : t.removeAttr("aria-describedby")
    }
    var a = 0;
    e.widget("ui.tooltip", {
        version: "1.9.2",
        options: {
            content: function() {
                return e(this).attr("title")
            },
            hide: !0,
            items: "[title]:not([disabled])",
            position: {
                my: "left top+15",
                at: "left bottom",
                collision: "flipfit flip"
            },
            show: !0,
            tooltipClass: null,
            track: !1,
            close: null,
            open: null
        },
        _create: function() {
            this._on({
                mouseover: "open",
                focusin: "open"
            }), this.tooltips = {}, this.parents = {}, this.options.disabled && this._disable()
        },
        _setOption: function(t, i) {
            var a = this;
            return "disabled" === t ? (this[i ? "_disable" : "_enable"](), this.options[t] = i, void 0) : (this._super(t, i), "content" === t && e.each(this.tooltips, function(e, t) {
                a._updateContent(t)
            }), void 0)
        },
        _disable: function() {
            var t = this;
            e.each(this.tooltips, function(i, a) {
                var s = e.Event("blur");
                s.target = s.currentTarget = a[0], t.close(s, !0)
            }), this.element.find(this.options.items).andSelf().each(function() {
                var t = e(this);
                t.is("[title]") && t.data("ui-tooltip-title", t.attr("title")).attr("title", "")
            })
        },
        _enable: function() {
            this.element.find(this.options.items).andSelf().each(function() {
                var t = e(this);
                t.data("ui-tooltip-title") && t.attr("title", t.data("ui-tooltip-title"))
            })
        },
        open: function(t) {
            var i = this,
                a = e(t ? t.target : this.element).closest(this.options.items);
            a.length && !a.data("ui-tooltip-id") && (a.attr("title") && a.data("ui-tooltip-title", a.attr("title")), a.data("ui-tooltip-open", !0), t && "mouseover" === t.type && a.parents().each(function() {
                var t, a = e(this);
                a.data("ui-tooltip-open") && (t = e.Event("blur"), t.target = t.currentTarget = this, i.close(t, !0)), a.attr("title") && (a.uniqueId(), i.parents[this.id] = {
                    element: this,
                    title: a.attr("title")
                }, a.attr("title", ""))
            }), this._updateContent(a, t))
        },
        _updateContent: function(e, t) {
            var i, a = this.options.content,
                s = this,
                n = t ? t.type : null;
            return "string" == typeof a ? this._open(t, e, a) : (i = a.call(e[0], function(i) {
                e.data("ui-tooltip-open") && s._delay(function() {
                    t && (t.type = n), this._open(t, e, i)
                })
            }), i && this._open(t, e, i), void 0)
        },
        _open: function(i, a, s) {
            function n(e) {
                l.of = e, r.is(":hidden") || r.position(l)
            }
            var r, o, h, l = e.extend({}, this.options.position);
            if (s) {
                if (r = this._find(a), r.length) return r.find(".ui-tooltip-content").html(s), void 0;
                a.is("[title]") && (i && "mouseover" === i.type ? a.attr("title", "") : a.removeAttr("title")), r = this._tooltip(a), t(a, r.attr("id")), r.find(".ui-tooltip-content").html(s), this.options.track && i && /^mouse/.test(i.type) ? (this._on(this.document, {
                    mousemove: n
                }), n(i)) : r.position(e.extend({
                    of: a
                }, this.options.position)), r.hide(), this._show(r, this.options.show), this.options.show && this.options.show.delay && (h = setInterval(function() {
                    r.is(":visible") && (n(l.of), clearInterval(h))
                }, e.fx.interval)), this._trigger("open", i, {
                    tooltip: r
                }), o = {
                    keyup: function(t) {
                        if (t.keyCode === e.ui.keyCode.ESCAPE) {
                            var i = e.Event(t);
                            i.currentTarget = a[0], this.close(i, !0)
                        }
                    },
                    remove: function() {
                        this._removeTooltip(r)
                    }
                }, i && "mouseover" !== i.type || (o.mouseleave = "close"), i && "focusin" !== i.type || (o.focusout = "close"), this._on(!0, a, o)
            }
        },
        close: function(t) {
            var a = this,
                s = e(t ? t.currentTarget : this.element),
                n = this._find(s);
            this.closing || (s.data("ui-tooltip-title") && s.attr("title", s.data("ui-tooltip-title")), i(s), n.stop(!0), this._hide(n, this.options.hide, function() {
                a._removeTooltip(e(this))
            }), s.removeData("ui-tooltip-open"), this._off(s, "mouseleave focusout keyup"), s[0] !== this.element[0] && this._off(s, "remove"), this._off(this.document, "mousemove"), t && "mouseleave" === t.type && e.each(this.parents, function(t, i) {
                e(i.element).attr("title", i.title), delete a.parents[t]
            }), this.closing = !0, this._trigger("close", t, {
                tooltip: n
            }), this.closing = !1)
        },
        _tooltip: function(t) {
            var i = "ui-tooltip-" + a++,
                s = e("<div>").attr({
                    id: i,
                    role: "tooltip"
                }).addClass("ui-tooltip ui-widget ui-corner-all ui-widget-content " + (this.options.tooltipClass || ""));
            return e("<div>").addClass("ui-tooltip-content").appendTo(s), s.appendTo(this.document[0].body), e.fn.bgiframe && s.bgiframe(), this.tooltips[i] = t, s
        },
        _find: function(t) {
            var i = t.data("ui-tooltip-id");
            return i ? e("#" + i) : e()
        },
        _removeTooltip: function(e) {
            e.remove(), delete this.tooltips[e.attr("id")]
        },
        _destroy: function() {
            var t = this;
            e.each(this.tooltips, function(i, a) {
                var s = e.Event("blur");
                s.target = s.currentTarget = a[0], t.close(s, !0), e("#" + i).remove(), a.data("ui-tooltip-title") && (a.attr("title", a.data("ui-tooltip-title")), a.removeData("ui-tooltip-title"))
            })
        }
    })
})(jQuery);
jQuery.effects || function(e, t) {
    var i = e.uiBackCompat !== !1,
        a = "ui-effects-";
    e.effects = {
            effect: {}
        },
        function(t, i) {
            function a(e, t, i) {
                var a = c[t.type] || {};
                return null == e ? i || !t.def ? null : t.def : (e = a.floor ? ~~e : parseFloat(e), isNaN(e) ? t.def : a.mod ? (e + a.mod) % a.mod : 0 > e ? 0 : e > a.max ? a.max : e)
            }

            function n(e) {
                var a = h(),
                    n = a._rgba = [];
                return e = e.toLowerCase(), f(u, function(t, s) {
                    var r, o = s.re.exec(e),
                        l = o && s.parse(o),
                        u = s.space || "rgba";
                    return l ? (r = a[u](l), a[d[u].cache] = r[d[u].cache], n = a._rgba = r._rgba, !1) : i
                }), n.length ? ("0,0,0,0" === n.join() && t.extend(n, r.transparent), a) : r[e]
            }

            function s(e, t, i) {
                return i = (i + 1) % 1, 1 > 6 * i ? e + 6 * (t - e) * i : 1 > 2 * i ? t : 2 > 3 * i ? e + 6 * (t - e) * (2 / 3 - i) : e
            }
            var r, o = "backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor color columnRuleColor outlineColor textDecorationColor textEmphasisColor".split(" "),
                l = /^([\-+])=\s*(\d+\.?\d*)/,
                u = [{
                    re: /rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
                    parse: function(e) {
                        return [e[1], e[2], e[3], e[4]]
                    }
                }, {
                    re: /rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
                    parse: function(e) {
                        return [2.55 * e[1], 2.55 * e[2], 2.55 * e[3], e[4]]
                    }
                }, {
                    re: /#([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})/,
                    parse: function(e) {
                        return [parseInt(e[1], 16), parseInt(e[2], 16), parseInt(e[3], 16)]
                    }
                }, {
                    re: /#([a-f0-9])([a-f0-9])([a-f0-9])/,
                    parse: function(e) {
                        return [parseInt(e[1] + e[1], 16), parseInt(e[2] + e[2], 16), parseInt(e[3] + e[3], 16)]
                    }
                }, {
                    re: /hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
                    space: "hsla",
                    parse: function(e) {
                        return [e[1], e[2] / 100, e[3] / 100, e[4]]
                    }
                }],
                h = t.Color = function(e, i, a, n) {
                    return new t.Color.fn.parse(e, i, a, n)
                },
                d = {
                    rgba: {
                        props: {
                            red: {
                                idx: 0,
                                type: "byte"
                            },
                            green: {
                                idx: 1,
                                type: "byte"
                            },
                            blue: {
                                idx: 2,
                                type: "byte"
                            }
                        }
                    },
                    hsla: {
                        props: {
                            hue: {
                                idx: 0,
                                type: "degrees"
                            },
                            saturation: {
                                idx: 1,
                                type: "percent"
                            },
                            lightness: {
                                idx: 2,
                                type: "percent"
                            }
                        }
                    }
                },
                c = {
                    "byte": {
                        floor: !0,
                        max: 255
                    },
                    percent: {
                        max: 1
                    },
                    degrees: {
                        mod: 360,
                        floor: !0
                    }
                },
                p = h.support = {},
                m = t("<p>")[0],
                f = t.each;
            m.style.cssText = "background-color:rgba(1,1,1,.5)", p.rgba = m.style.backgroundColor.indexOf("rgba") > -1, f(d, function(e, t) {
                t.cache = "_" + e, t.props.alpha = {
                    idx: 3,
                    type: "percent",
                    def: 1
                }
            }), h.fn = t.extend(h.prototype, {
                parse: function(s, o, l, u) {
                    if (s === i) return this._rgba = [null, null, null, null], this;
                    (s.jquery || s.nodeType) && (s = t(s).css(o), o = i);
                    var c = this,
                        p = t.type(s),
                        m = this._rgba = [];
                    return o !== i && (s = [s, o, l, u], p = "array"), "string" === p ? this.parse(n(s) || r._default) : "array" === p ? (f(d.rgba.props, function(e, t) {
                        m[t.idx] = a(s[t.idx], t)
                    }), this) : "object" === p ? (s instanceof h ? f(d, function(e, t) {
                        s[t.cache] && (c[t.cache] = s[t.cache].slice())
                    }) : f(d, function(t, i) {
                        var n = i.cache;
                        f(i.props, function(e, t) {
                            if (!c[n] && i.to) {
                                if ("alpha" === e || null == s[e]) return;
                                c[n] = i.to(c._rgba)
                            }
                            c[n][t.idx] = a(s[e], t, !0)
                        }), c[n] && 0 > e.inArray(null, c[n].slice(0, 3)) && (c[n][3] = 1, i.from && (c._rgba = i.from(c[n])))
                    }), this) : i
                },
                is: function(e) {
                    var t = h(e),
                        a = !0,
                        n = this;
                    return f(d, function(e, s) {
                        var r, o = t[s.cache];
                        return o && (r = n[s.cache] || s.to && s.to(n._rgba) || [], f(s.props, function(e, t) {
                            return null != o[t.idx] ? a = o[t.idx] === r[t.idx] : i
                        })), a
                    }), a
                },
                _space: function() {
                    var e = [],
                        t = this;
                    return f(d, function(i, a) {
                        t[a.cache] && e.push(i)
                    }), e.pop()
                },
                transition: function(e, t) {
                    var i = h(e),
                        n = i._space(),
                        s = d[n],
                        r = 0 === this.alpha() ? h("transparent") : this,
                        o = r[s.cache] || s.to(r._rgba),
                        l = o.slice();
                    return i = i[s.cache], f(s.props, function(e, n) {
                        var s = n.idx,
                            r = o[s],
                            u = i[s],
                            h = c[n.type] || {};
                        null !== u && (null === r ? l[s] = u : (h.mod && (u - r > h.mod / 2 ? r += h.mod : r - u > h.mod / 2 && (r -= h.mod)), l[s] = a((u - r) * t + r, n)))
                    }), this[n](l)
                },
                blend: function(e) {
                    if (1 === this._rgba[3]) return this;
                    var i = this._rgba.slice(),
                        a = i.pop(),
                        n = h(e)._rgba;
                    return h(t.map(i, function(e, t) {
                        return (1 - a) * n[t] + a * e
                    }))
                },
                toRgbaString: function() {
                    var e = "rgba(",
                        i = t.map(this._rgba, function(e, t) {
                            return null == e ? t > 2 ? 1 : 0 : e
                        });
                    return 1 === i[3] && (i.pop(), e = "rgb("), e + i.join() + ")"
                },
                toHslaString: function() {
                    var e = "hsla(",
                        i = t.map(this.hsla(), function(e, t) {
                            return null == e && (e = t > 2 ? 1 : 0), t && 3 > t && (e = Math.round(100 * e) + "%"), e
                        });
                    return 1 === i[3] && (i.pop(), e = "hsl("), e + i.join() + ")"
                },
                toHexString: function(e) {
                    var i = this._rgba.slice(),
                        a = i.pop();
                    return e && i.push(~~(255 * a)), "#" + t.map(i, function(e) {
                        return e = (e || 0).toString(16), 1 === e.length ? "0" + e : e
                    }).join("")
                },
                toString: function() {
                    return 0 === this._rgba[3] ? "transparent" : this.toRgbaString()
                }
            }), h.fn.parse.prototype = h.fn, d.hsla.to = function(e) {
                if (null == e[0] || null == e[1] || null == e[2]) return [null, null, null, e[3]];
                var t, i, a = e[0] / 255,
                    n = e[1] / 255,
                    s = e[2] / 255,
                    r = e[3],
                    o = Math.max(a, n, s),
                    l = Math.min(a, n, s),
                    u = o - l,
                    h = o + l,
                    d = .5 * h;
                return t = l === o ? 0 : a === o ? 60 * (n - s) / u + 360 : n === o ? 60 * (s - a) / u + 120 : 60 * (a - n) / u + 240, i = 0 === d || 1 === d ? d : .5 >= d ? u / h : u / (2 - h), [Math.round(t) % 360, i, d, null == r ? 1 : r]
            }, d.hsla.from = function(e) {
                if (null == e[0] || null == e[1] || null == e[2]) return [null, null, null, e[3]];
                var t = e[0] / 360,
                    i = e[1],
                    a = e[2],
                    n = e[3],
                    r = .5 >= a ? a * (1 + i) : a + i - a * i,
                    o = 2 * a - r;
                return [Math.round(255 * s(o, r, t + 1 / 3)), Math.round(255 * s(o, r, t)), Math.round(255 * s(o, r, t - 1 / 3)), n]
            }, f(d, function(e, n) {
                var s = n.props,
                    r = n.cache,
                    o = n.to,
                    u = n.from;
                h.fn[e] = function(e) {
                    if (o && !this[r] && (this[r] = o(this._rgba)), e === i) return this[r].slice();
                    var n, l = t.type(e),
                        d = "array" === l || "object" === l ? e : arguments,
                        c = this[r].slice();
                    return f(s, function(e, t) {
                        var i = d["object" === l ? e : t.idx];
                        null == i && (i = c[t.idx]), c[t.idx] = a(i, t)
                    }), u ? (n = h(u(c)), n[r] = c, n) : h(c)
                }, f(s, function(i, a) {
                    h.fn[i] || (h.fn[i] = function(n) {
                        var s, r = t.type(n),
                            o = "alpha" === i ? this._hsla ? "hsla" : "rgba" : e,
                            u = this[o](),
                            h = u[a.idx];
                        return "undefined" === r ? h : ("function" === r && (n = n.call(this, h), r = t.type(n)), null == n && a.empty ? this : ("string" === r && (s = l.exec(n), s && (n = h + parseFloat(s[2]) * ("+" === s[1] ? 1 : -1))), u[a.idx] = n, this[o](u)))
                    })
                })
            }), f(o, function(e, i) {
                t.cssHooks[i] = {
                    set: function(e, a) {
                        var s, r, o = "";
                        if ("string" !== t.type(a) || (s = n(a))) {
                            if (a = h(s || a), !p.rgba && 1 !== a._rgba[3]) {
                                for (r = "backgroundColor" === i ? e.parentNode : e;
                                    ("" === o || "transparent" === o) && r && r.style;) try {
                                    o = t.css(r, "backgroundColor"), r = r.parentNode
                                } catch (l) {}
                                a = a.blend(o && "transparent" !== o ? o : "_default")
                            }
                            a = a.toRgbaString()
                        }
                        try {
                            e.style[i] = a
                        } catch (u) {}
                    }
                }, t.fx.step[i] = function(e) {
                    e.colorInit || (e.start = h(e.elem, i), e.end = h(e.end), e.colorInit = !0), t.cssHooks[i].set(e.elem, e.start.transition(e.end, e.pos))
                }
            }), t.cssHooks.borderColor = {
                expand: function(e) {
                    var t = {};
                    return f(["Top", "Right", "Bottom", "Left"], function(i, a) {
                        t["border" + a + "Color"] = e
                    }), t
                }
            }, r = t.Color.names = {
                aqua: "#00ffff",
                black: "#000000",
                blue: "#0000ff",
                fuchsia: "#ff00ff",
                gray: "#808080",
                green: "#008000",
                lime: "#00ff00",
                maroon: "#800000",
                navy: "#000080",
                olive: "#808000",
                purple: "#800080",
                red: "#ff0000",
                silver: "#c0c0c0",
                teal: "#008080",
                white: "#ffffff",
                yellow: "#ffff00",
                transparent: [null, null, null, 0],
                _default: "#ffffff"
            }
        }(jQuery),
        function() {
            function i() {
                var t, i, a = this.ownerDocument.defaultView ? this.ownerDocument.defaultView.getComputedStyle(this, null) : this.currentStyle,
                    n = {};
                if (a && a.length && a[0] && a[a[0]])
                    for (i = a.length; i--;) t = a[i], "string" == typeof a[t] && (n[e.camelCase(t)] = a[t]);
                else
                    for (t in a) "string" == typeof a[t] && (n[t] = a[t]);
                return n
            }

            function a(t, i) {
                var a, n, r = {};
                for (a in i) n = i[a], t[a] !== n && (s[a] || (e.fx.step[a] || !isNaN(parseFloat(n))) && (r[a] = n));
                return r
            }
            var n = ["add", "remove", "toggle"],
                s = {
                    border: 1,
                    borderBottom: 1,
                    borderColor: 1,
                    borderLeft: 1,
                    borderRight: 1,
                    borderTop: 1,
                    borderWidth: 1,
                    margin: 1,
                    padding: 1
                };
            e.each(["borderLeftStyle", "borderRightStyle", "borderBottomStyle", "borderTopStyle"], function(t, i) {
                e.fx.step[i] = function(e) {
                    ("none" !== e.end && !e.setAttr || 1 === e.pos && !e.setAttr) && (jQuery.style(e.elem, i, e.end), e.setAttr = !0)
                }
            }), e.effects.animateClass = function(t, s, r, o) {
                var l = e.speed(s, r, o);
                return this.queue(function() {
                    var s, r = e(this),
                        o = r.attr("class") || "",
                        u = l.children ? r.find("*").andSelf() : r;
                    u = u.map(function() {
                        var t = e(this);
                        return {
                            el: t,
                            start: i.call(this)
                        }
                    }), s = function() {
                        e.each(n, function(e, i) {
                            t[i] && r[i + "Class"](t[i])
                        })
                    }, s(), u = u.map(function() {
                        return this.end = i.call(this.el[0]), this.diff = a(this.start, this.end), this
                    }), r.attr("class", o), u = u.map(function() {
                        var t = this,
                            i = e.Deferred(),
                            a = jQuery.extend({}, l, {
                                queue: !1,
                                complete: function() {
                                    i.resolve(t)
                                }
                            });
                        return this.el.animate(this.diff, a), i.promise()
                    }), e.when.apply(e, u.get()).done(function() {
                        s(), e.each(arguments, function() {
                            var t = this.el;
                            e.each(this.diff, function(e) {
                                t.css(e, "")
                            })
                        }), l.complete.call(r[0])
                    })
                })
            }, e.fn.extend({
                _addClass: e.fn.addClass,
                addClass: function(t, i, a, n) {
                    return i ? e.effects.animateClass.call(this, {
                        add: t
                    }, i, a, n) : this._addClass(t)
                },
                _removeClass: e.fn.removeClass,
                removeClass: function(t, i, a, n) {
                    return i ? e.effects.animateClass.call(this, {
                        remove: t
                    }, i, a, n) : this._removeClass(t)
                },
                _toggleClass: e.fn.toggleClass,
                toggleClass: function(i, a, n, s, r) {
                    return "boolean" == typeof a || a === t ? n ? e.effects.animateClass.call(this, a ? {
                        add: i
                    } : {
                        remove: i
                    }, n, s, r) : this._toggleClass(i, a) : e.effects.animateClass.call(this, {
                        toggle: i
                    }, a, n, s)
                },
                switchClass: function(t, i, a, n, s) {
                    return e.effects.animateClass.call(this, {
                        add: i,
                        remove: t
                    }, a, n, s)
                }
            })
        }(),
        function() {
            function n(t, i, a, n) {
                return e.isPlainObject(t) && (i = t, t = t.effect), t = {
                    effect: t
                }, null == i && (i = {}), e.isFunction(i) && (n = i, a = null, i = {}), ("number" == typeof i || e.fx.speeds[i]) && (n = a, a = i, i = {}), e.isFunction(a) && (n = a, a = null), i && e.extend(t, i), a = a || i.duration, t.duration = e.fx.off ? 0 : "number" == typeof a ? a : a in e.fx.speeds ? e.fx.speeds[a] : e.fx.speeds._default, t.complete = n || i.complete, t
            }

            function s(t) {
                return !t || "number" == typeof t || e.fx.speeds[t] ? !0 : "string" != typeof t || e.effects.effect[t] ? !1 : i && e.effects[t] ? !1 : !0
            }
            e.extend(e.effects, {
                version: "1.9.2",
                save: function(e, t) {
                    for (var i = 0; t.length > i; i++) null !== t[i] && e.data(a + t[i], e[0].style[t[i]])
                },
                restore: function(e, i) {
                    var n, s;
                    for (s = 0; i.length > s; s++) null !== i[s] && (n = e.data(a + i[s]), n === t && (n = ""), e.css(i[s], n))
                },
                setMode: function(e, t) {
                    return "toggle" === t && (t = e.is(":hidden") ? "show" : "hide"), t
                },
                getBaseline: function(e, t) {
                    var i, a;
                    switch (e[0]) {
                        case "top":
                            i = 0;
                            break;
                        case "middle":
                            i = .5;
                            break;
                        case "bottom":
                            i = 1;
                            break;
                        default:
                            i = e[0] / t.height
                    }
                    switch (e[1]) {
                        case "left":
                            a = 0;
                            break;
                        case "center":
                            a = .5;
                            break;
                        case "right":
                            a = 1;
                            break;
                        default:
                            a = e[1] / t.width
                    }
                    return {
                        x: a,
                        y: i
                    }
                },
                createWrapper: function(t) {
                    if (t.parent().is(".ui-effects-wrapper")) return t.parent();
                    var i = {
                            width: t.outerWidth(!0),
                            height: t.outerHeight(!0),
                            "float": t.css("float")
                        },
                        a = e("<div></div>").addClass("ui-effects-wrapper").css({
                            fontSize: "100%",
                            background: "transparent",
                            border: "none",
                            margin: 0,
                            padding: 0
                        }),
                        n = {
                            width: t.width(),
                            height: t.height()
                        },
                        s = document.activeElement;
                    try {
                        s.id
                    } catch (r) {
                        s = document.body
                    }
                    return t.wrap(a), (t[0] === s || e.contains(t[0], s)) && e(s).focus(), a = t.parent(), "static" === t.css("position") ? (a.css({
                        position: "relative"
                    }), t.css({
                        position: "relative"
                    })) : (e.extend(i, {
                        position: t.css("position"),
                        zIndex: t.css("z-index")
                    }), e.each(["top", "left", "bottom", "right"], function(e, a) {
                        i[a] = t.css(a), isNaN(parseInt(i[a], 10)) && (i[a] = "auto")
                    }), t.css({
                        position: "relative",
                        top: 0,
                        left: 0,
                        right: "auto",
                        bottom: "auto"
                    })), t.css(n), a.css(i).show()
                },
                removeWrapper: function(t) {
                    var i = document.activeElement;
                    return t.parent().is(".ui-effects-wrapper") && (t.parent().replaceWith(t), (t[0] === i || e.contains(t[0], i)) && e(i).focus()), t
                },
                setTransition: function(t, i, a, n) {
                    return n = n || {}, e.each(i, function(e, i) {
                        var s = t.cssUnit(i);
                        s[0] > 0 && (n[i] = s[0] * a + s[1])
                    }), n
                }
            }), e.fn.extend({
                effect: function() {
                    function t(t) {
                        function i() {
                            e.isFunction(s) && s.call(n[0]), e.isFunction(t) && t()
                        }
                        var n = e(this),
                            s = a.complete,
                            r = a.mode;
                        (n.is(":hidden") ? "hide" === r : "show" === r) ? i(): o.call(n[0], a, i)
                    }
                    var a = n.apply(this, arguments),
                        s = a.mode,
                        r = a.queue,
                        o = e.effects.effect[a.effect],
                        l = !o && i && e.effects[a.effect];
                    return e.fx.off || !o && !l ? s ? this[s](a.duration, a.complete) : this.each(function() {
                        a.complete && a.complete.call(this)
                    }) : o ? r === !1 ? this.each(t) : this.queue(r || "fx", t) : l.call(this, {
                        options: a,
                        duration: a.duration,
                        callback: a.complete,
                        mode: a.mode
                    })
                },
                _show: e.fn.show,
                show: function(e) {
                    if (s(e)) return this._show.apply(this, arguments);
                    var t = n.apply(this, arguments);
                    return t.mode = "show", this.effect.call(this, t)
                },
                _hide: e.fn.hide,
                hide: function(e) {
                    if (s(e)) return this._hide.apply(this, arguments);
                    var t = n.apply(this, arguments);
                    return t.mode = "hide", this.effect.call(this, t)
                },
                __toggle: e.fn.toggle,
                toggle: function(t) {
                    if (s(t) || "boolean" == typeof t || e.isFunction(t)) return this.__toggle.apply(this, arguments);
                    var i = n.apply(this, arguments);
                    return i.mode = "toggle", this.effect.call(this, i)
                },
                cssUnit: function(t) {
                    var i = this.css(t),
                        a = [];
                    return e.each(["em", "px", "%", "pt"], function(e, t) {
                        i.indexOf(t) > 0 && (a = [parseFloat(i), t])
                    }), a
                }
            })
        }(),
        function() {
            var t = {};
            e.each(["Quad", "Cubic", "Quart", "Quint", "Expo"], function(e, i) {
                t[i] = function(t) {
                    return Math.pow(t, e + 2)
                }
            }), e.extend(t, {
                Sine: function(e) {
                    return 1 - Math.cos(e * Math.PI / 2)
                },
                Circ: function(e) {
                    return 1 - Math.sqrt(1 - e * e)
                },
                Elastic: function(e) {
                    return 0 === e || 1 === e ? e : -Math.pow(2, 8 * (e - 1)) * Math.sin((80 * (e - 1) - 7.5) * Math.PI / 15)
                },
                Back: function(e) {
                    return e * e * (3 * e - 2)
                },
                Bounce: function(e) {
                    for (var t, i = 4;
                        ((t = Math.pow(2, --i)) - 1) / 11 > e;);
                    return 1 / Math.pow(4, 3 - i) - 7.5625 * Math.pow((3 * t - 2) / 22 - e, 2)
                }
            }), e.each(t, function(t, i) {
                e.easing["easeIn" + t] = i, e.easing["easeOut" + t] = function(e) {
                    return 1 - i(1 - e)
                }, e.easing["easeInOut" + t] = function(e) {
                    return .5 > e ? i(2 * e) / 2 : 1 - i(-2 * e + 2) / 2
                }
            })
        }()
}(jQuery);
(function(e) {
    var t = /up|down|vertical/,
        i = /up|left|vertical|horizontal/;
    e.effects.effect.blind = function(a, s) {
        var n, r, o, l = e(this),
            d = ["position", "top", "bottom", "left", "right", "height", "width"],
            u = e.effects.setMode(l, a.mode || "hide"),
            h = a.direction || "up",
            c = t.test(h),
            p = c ? "height" : "width",
            m = c ? "top" : "left",
            f = i.test(h),
            g = {},
            y = "show" === u;
        l.parent().is(".ui-effects-wrapper") ? e.effects.save(l.parent(), d) : e.effects.save(l, d), l.show(), n = e.effects.createWrapper(l).css({
            overflow: "hidden"
        }), r = n[p](), o = parseFloat(n.css(m)) || 0, g[p] = y ? r : 0, f || (l.css(c ? "bottom" : "right", 0).css(c ? "top" : "left", "auto").css({
            position: "absolute"
        }), g[m] = y ? o : r + o), y && (n.css(p, 0), f || n.css(m, o + r)), n.animate(g, {
            duration: a.duration,
            easing: a.easing,
            queue: !1,
            complete: function() {
                "hide" === u && l.hide(), e.effects.restore(l, d), e.effects.removeWrapper(l), s()
            }
        })
    }
})(jQuery);
(function(e) {
    e.effects.effect.bounce = function(t, i) {
        var a, s, n, r = e(this),
            o = ["position", "top", "bottom", "left", "right", "height", "width"],
            l = e.effects.setMode(r, t.mode || "effect"),
            d = "hide" === l,
            u = "show" === l,
            h = t.direction || "up",
            c = t.distance,
            p = t.times || 5,
            m = 2 * p + (u || d ? 1 : 0),
            f = t.duration / m,
            g = t.easing,
            y = "up" === h || "down" === h ? "top" : "left",
            v = "up" === h || "left" === h,
            b = r.queue(),
            x = b.length;
        for ((u || d) && o.push("opacity"), e.effects.save(r, o), r.show(), e.effects.createWrapper(r), c || (c = r["top" === y ? "outerHeight" : "outerWidth"]() / 3), u && (n = {
                opacity: 1
            }, n[y] = 0, r.css("opacity", 0).css(y, v ? 2 * -c : 2 * c).animate(n, f, g)), d && (c /= Math.pow(2, p - 1)), n = {}, n[y] = 0, a = 0; p > a; a++) s = {}, s[y] = (v ? "-=" : "+=") + c, r.animate(s, f, g).animate(n, f, g), c = d ? 2 * c : c / 2;
        d && (s = {
            opacity: 0
        }, s[y] = (v ? "-=" : "+=") + c, r.animate(s, f, g)), r.queue(function() {
            d && r.hide(), e.effects.restore(r, o), e.effects.removeWrapper(r), i()
        }), x > 1 && b.splice.apply(b, [1, 0].concat(b.splice(x, m + 1))), r.dequeue()
    }
})(jQuery);
(function(e) {
    e.effects.effect.clip = function(t, i) {
        var a, s, n, r = e(this),
            o = ["position", "top", "bottom", "left", "right", "height", "width"],
            l = e.effects.setMode(r, t.mode || "hide"),
            d = "show" === l,
            u = t.direction || "vertical",
            h = "vertical" === u,
            c = h ? "height" : "width",
            p = h ? "top" : "left",
            m = {};
        e.effects.save(r, o), r.show(), a = e.effects.createWrapper(r).css({
            overflow: "hidden"
        }), s = "IMG" === r[0].tagName ? a : r, n = s[c](), d && (s.css(c, 0), s.css(p, n / 2)), m[c] = d ? n : 0, m[p] = d ? 0 : n / 2, s.animate(m, {
            queue: !1,
            duration: t.duration,
            easing: t.easing,
            complete: function() {
                d || r.hide(), e.effects.restore(r, o), e.effects.removeWrapper(r), i()
            }
        })
    }
})(jQuery);
(function(e) {
    e.effects.effect.drop = function(t, i) {
        var a, s = e(this),
            n = ["position", "top", "bottom", "left", "right", "opacity", "height", "width"],
            r = e.effects.setMode(s, t.mode || "hide"),
            o = "show" === r,
            l = t.direction || "left",
            d = "up" === l || "down" === l ? "top" : "left",
            u = "up" === l || "left" === l ? "pos" : "neg",
            h = {
                opacity: o ? 1 : 0
            };
        e.effects.save(s, n), s.show(), e.effects.createWrapper(s), a = t.distance || s["top" === d ? "outerHeight" : "outerWidth"](!0) / 2, o && s.css("opacity", 0).css(d, "pos" === u ? -a : a), h[d] = (o ? "pos" === u ? "+=" : "-=" : "pos" === u ? "-=" : "+=") + a, s.animate(h, {
            queue: !1,
            duration: t.duration,
            easing: t.easing,
            complete: function() {
                "hide" === r && s.hide(), e.effects.restore(s, n), e.effects.removeWrapper(s), i()
            }
        })
    }
})(jQuery);
(function(e) {
    e.effects.effect.explode = function(t, i) {
        function a() {
            b.push(this), b.length === h * c && s()
        }

        function s() {
            p.css({
                visibility: "visible"
            }), e(b).remove(), f || p.hide(), i()
        }
        var n, r, o, l, d, u, h = t.pieces ? Math.round(Math.sqrt(t.pieces)) : 3,
            c = h,
            p = e(this),
            m = e.effects.setMode(p, t.mode || "hide"),
            f = "show" === m,
            g = p.show().css("visibility", "hidden").offset(),
            y = Math.ceil(p.outerWidth() / c),
            v = Math.ceil(p.outerHeight() / h),
            b = [];
        for (n = 0; h > n; n++)
            for (l = g.top + n * v, u = n - (h - 1) / 2, r = 0; c > r; r++) o = g.left + r * y, d = r - (c - 1) / 2, p.clone().appendTo("body").wrap("<div></div>").css({
                position: "absolute",
                visibility: "visible",
                left: -r * y,
                top: -n * v
            }).parent().addClass("ui-effects-explode").css({
                position: "absolute",
                overflow: "hidden",
                width: y,
                height: v,
                left: o + (f ? d * y : 0),
                top: l + (f ? u * v : 0),
                opacity: f ? 0 : 1
            }).animate({
                left: o + (f ? 0 : d * y),
                top: l + (f ? 0 : u * v),
                opacity: f ? 1 : 0
            }, t.duration || 500, t.easing, a)
    }
})(jQuery);
(function(e) {
    e.effects.effect.fade = function(t, i) {
        var a = e(this),
            s = e.effects.setMode(a, t.mode || "toggle");
        a.animate({
            opacity: s
        }, {
            queue: !1,
            duration: t.duration,
            easing: t.easing,
            complete: i
        })
    }
})(jQuery);
(function(e) {
    e.effects.effect.fold = function(t, i) {
        var a, s, n = e(this),
            r = ["position", "top", "bottom", "left", "right", "height", "width"],
            o = e.effects.setMode(n, t.mode || "hide"),
            l = "show" === o,
            d = "hide" === o,
            h = t.size || 15,
            u = /([0-9]+)%/.exec(h),
            c = !!t.horizFirst,
            p = l !== c,
            m = p ? ["width", "height"] : ["height", "width"],
            f = t.duration / 2,
            g = {},
            y = {};
        e.effects.save(n, r), n.show(), a = e.effects.createWrapper(n).css({
            overflow: "hidden"
        }), s = p ? [a.width(), a.height()] : [a.height(), a.width()], u && (h = parseInt(u[1], 10) / 100 * s[d ? 0 : 1]), l && a.css(c ? {
            height: 0,
            width: h
        } : {
            height: h,
            width: 0
        }), g[m[0]] = l ? s[0] : h, y[m[1]] = l ? s[1] : 0, a.animate(g, f, t.easing).animate(y, f, t.easing, function() {
            d && n.hide(), e.effects.restore(n, r), e.effects.removeWrapper(n), i()
        })
    }
})(jQuery);
(function(e) {
    e.effects.effect.highlight = function(t, i) {
        var a = e(this),
            s = ["backgroundImage", "backgroundColor", "opacity"],
            n = e.effects.setMode(a, t.mode || "show"),
            r = {
                backgroundColor: a.css("backgroundColor")
            };
        "hide" === n && (r.opacity = 0), e.effects.save(a, s), a.show().css({
            backgroundImage: "none",
            backgroundColor: t.color || "#ffff99"
        }).animate(r, {
            queue: !1,
            duration: t.duration,
            easing: t.easing,
            complete: function() {
                "hide" === n && a.hide(), e.effects.restore(a, s), i()
            }
        })
    }
})(jQuery);
(function(e) {
    e.effects.effect.pulsate = function(t, i) {
        var a, s = e(this),
            n = e.effects.setMode(s, t.mode || "show"),
            r = "show" === n,
            o = "hide" === n,
            l = r || "hide" === n,
            d = 2 * (t.times || 5) + (l ? 1 : 0),
            h = t.duration / d,
            u = 0,
            c = s.queue(),
            p = c.length;
        for ((r || !s.is(":visible")) && (s.css("opacity", 0).show(), u = 1), a = 1; d > a; a++) s.animate({
            opacity: u
        }, h, t.easing), u = 1 - u;
        s.animate({
            opacity: u
        }, h, t.easing), s.queue(function() {
            o && s.hide(), i()
        }), p > 1 && c.splice.apply(c, [1, 0].concat(c.splice(p, d + 1))), s.dequeue()
    }
})(jQuery);
(function(e) {
    e.effects.effect.puff = function(t, i) {
        var a = e(this),
            s = e.effects.setMode(a, t.mode || "hide"),
            n = "hide" === s,
            r = parseInt(t.percent, 10) || 150,
            o = r / 100,
            l = {
                height: a.height(),
                width: a.width(),
                outerHeight: a.outerHeight(),
                outerWidth: a.outerWidth()
            };
        e.extend(t, {
            effect: "scale",
            queue: !1,
            fade: !0,
            mode: s,
            complete: i,
            percent: n ? r : 100,
            from: n ? l : {
                height: l.height * o,
                width: l.width * o,
                outerHeight: l.outerHeight * o,
                outerWidth: l.outerWidth * o
            }
        }), a.effect(t)
    }, e.effects.effect.scale = function(t, i) {
        var a = e(this),
            s = e.extend(!0, {}, t),
            n = e.effects.setMode(a, t.mode || "effect"),
            r = parseInt(t.percent, 10) || (0 === parseInt(t.percent, 10) ? 0 : "hide" === n ? 0 : 100),
            o = t.direction || "both",
            l = t.origin,
            h = {
                height: a.height(),
                width: a.width(),
                outerHeight: a.outerHeight(),
                outerWidth: a.outerWidth()
            },
            d = {
                y: "horizontal" !== o ? r / 100 : 1,
                x: "vertical" !== o ? r / 100 : 1
            };
        s.effect = "size", s.queue = !1, s.complete = i, "effect" !== n && (s.origin = l || ["middle", "center"], s.restore = !0), s.from = t.from || ("show" === n ? {
            height: 0,
            width: 0,
            outerHeight: 0,
            outerWidth: 0
        } : h), s.to = {
            height: h.height * d.y,
            width: h.width * d.x,
            outerHeight: h.outerHeight * d.y,
            outerWidth: h.outerWidth * d.x
        }, s.fade && ("show" === n && (s.from.opacity = 0, s.to.opacity = 1), "hide" === n && (s.from.opacity = 1, s.to.opacity = 0)), a.effect(s)
    }, e.effects.effect.size = function(t, i) {
        var a, s, n, r = e(this),
            o = ["position", "top", "bottom", "left", "right", "width", "height", "overflow", "opacity"],
            l = ["position", "top", "bottom", "left", "right", "overflow", "opacity"],
            h = ["width", "height", "overflow"],
            d = ["fontSize"],
            u = ["borderTopWidth", "borderBottomWidth", "paddingTop", "paddingBottom"],
            c = ["borderLeftWidth", "borderRightWidth", "paddingLeft", "paddingRight"],
            p = e.effects.setMode(r, t.mode || "effect"),
            m = t.restore || "effect" !== p,
            f = t.scale || "both",
            g = t.origin || ["middle", "center"],
            y = r.css("position"),
            v = m ? o : l,
            b = {
                height: 0,
                width: 0,
                outerHeight: 0,
                outerWidth: 0
            };
        "show" === p && r.show(), a = {
            height: r.height(),
            width: r.width(),
            outerHeight: r.outerHeight(),
            outerWidth: r.outerWidth()
        }, "toggle" === t.mode && "show" === p ? (r.from = t.to || b, r.to = t.from || a) : (r.from = t.from || ("show" === p ? b : a), r.to = t.to || ("hide" === p ? b : a)), n = {
            from: {
                y: r.from.height / a.height,
                x: r.from.width / a.width
            },
            to: {
                y: r.to.height / a.height,
                x: r.to.width / a.width
            }
        }, ("box" === f || "both" === f) && (n.from.y !== n.to.y && (v = v.concat(u), r.from = e.effects.setTransition(r, u, n.from.y, r.from), r.to = e.effects.setTransition(r, u, n.to.y, r.to)), n.from.x !== n.to.x && (v = v.concat(c), r.from = e.effects.setTransition(r, c, n.from.x, r.from), r.to = e.effects.setTransition(r, c, n.to.x, r.to))), ("content" === f || "both" === f) && n.from.y !== n.to.y && (v = v.concat(d).concat(h), r.from = e.effects.setTransition(r, d, n.from.y, r.from), r.to = e.effects.setTransition(r, d, n.to.y, r.to)), e.effects.save(r, v), r.show(), e.effects.createWrapper(r), r.css("overflow", "hidden").css(r.from), g && (s = e.effects.getBaseline(g, a), r.from.top = (a.outerHeight - r.outerHeight()) * s.y, r.from.left = (a.outerWidth - r.outerWidth()) * s.x, r.to.top = (a.outerHeight - r.to.outerHeight) * s.y, r.to.left = (a.outerWidth - r.to.outerWidth) * s.x), r.css(r.from), ("content" === f || "both" === f) && (u = u.concat(["marginTop", "marginBottom"]).concat(d), c = c.concat(["marginLeft", "marginRight"]), h = o.concat(u).concat(c), r.find("*[width]").each(function() {
            var i = e(this),
                a = {
                    height: i.height(),
                    width: i.width(),
                    outerHeight: i.outerHeight(),
                    outerWidth: i.outerWidth()
                };
            m && e.effects.save(i, h), i.from = {
                height: a.height * n.from.y,
                width: a.width * n.from.x,
                outerHeight: a.outerHeight * n.from.y,
                outerWidth: a.outerWidth * n.from.x
            }, i.to = {
                height: a.height * n.to.y,
                width: a.width * n.to.x,
                outerHeight: a.height * n.to.y,
                outerWidth: a.width * n.to.x
            }, n.from.y !== n.to.y && (i.from = e.effects.setTransition(i, u, n.from.y, i.from), i.to = e.effects.setTransition(i, u, n.to.y, i.to)), n.from.x !== n.to.x && (i.from = e.effects.setTransition(i, c, n.from.x, i.from), i.to = e.effects.setTransition(i, c, n.to.x, i.to)), i.css(i.from), i.animate(i.to, t.duration, t.easing, function() {
                m && e.effects.restore(i, h)
            })
        })), r.animate(r.to, {
            queue: !1,
            duration: t.duration,
            easing: t.easing,
            complete: function() {
                0 === r.to.opacity && r.css("opacity", r.from.opacity), "hide" === p && r.hide(), e.effects.restore(r, v), m || ("static" === y ? r.css({
                    position: "relative",
                    top: r.to.top,
                    left: r.to.left
                }) : e.each(["top", "left"], function(e, t) {
                    r.css(t, function(t, i) {
                        var a = parseInt(i, 10),
                            s = e ? r.to.left : r.to.top;
                        return "auto" === i ? s + "px" : a + s + "px"
                    })
                })), e.effects.removeWrapper(r), i()
            }
        })
    }
})(jQuery);
(function(e) {
    e.effects.effect.shake = function(t, i) {
        var a, s = e(this),
            n = ["position", "top", "bottom", "left", "right", "height", "width"],
            r = e.effects.setMode(s, t.mode || "effect"),
            o = t.direction || "left",
            l = t.distance || 20,
            h = t.times || 3,
            d = 2 * h + 1,
            u = Math.round(t.duration / d),
            c = "up" === o || "down" === o ? "top" : "left",
            p = "up" === o || "left" === o,
            m = {},
            f = {},
            g = {},
            y = s.queue(),
            v = y.length;
        for (e.effects.save(s, n), s.show(), e.effects.createWrapper(s), m[c] = (p ? "-=" : "+=") + l, f[c] = (p ? "+=" : "-=") + 2 * l, g[c] = (p ? "-=" : "+=") + 2 * l, s.animate(m, u, t.easing), a = 1; h > a; a++) s.animate(f, u, t.easing).animate(g, u, t.easing);
        s.animate(f, u, t.easing).animate(m, u / 2, t.easing).queue(function() {
            "hide" === r && s.hide(), e.effects.restore(s, n), e.effects.removeWrapper(s), i()
        }), v > 1 && y.splice.apply(y, [1, 0].concat(y.splice(v, d + 1))), s.dequeue()
    }
})(jQuery);
(function(e) {
    e.effects.effect.slide = function(t, i) {
        var a, s = e(this),
            n = ["position", "top", "bottom", "left", "right", "width", "height"],
            r = e.effects.setMode(s, t.mode || "show"),
            o = "show" === r,
            l = t.direction || "left",
            h = "up" === l || "down" === l ? "top" : "left",
            d = "up" === l || "left" === l,
            u = {};
        e.effects.save(s, n), s.show(), a = t.distance || s["top" === h ? "outerHeight" : "outerWidth"](!0), e.effects.createWrapper(s).css({
            overflow: "hidden"
        }), o && s.css(h, d ? isNaN(a) ? "-" + a : -a : a), u[h] = (o ? d ? "+=" : "-=" : d ? "-=" : "+=") + a, s.animate(u, {
            queue: !1,
            duration: t.duration,
            easing: t.easing,
            complete: function() {
                "hide" === r && s.hide(), e.effects.restore(s, n), e.effects.removeWrapper(s), i()
            }
        })
    }
})(jQuery);
(function(e) {
    e.effects.effect.transfer = function(t, i) {
        var a = e(this),
            s = e(t.to),
            n = "fixed" === s.css("position"),
            r = e("body"),
            o = n ? r.scrollTop() : 0,
            l = n ? r.scrollLeft() : 0,
            h = s.offset(),
            d = {
                top: h.top - o,
                left: h.left - l,
                height: s.innerHeight(),
                width: s.innerWidth()
            },
            u = a.offset(),
            c = e('<div class="ui-effects-transfer"></div>').appendTo(document.body).addClass(t.className).css({
                top: u.top - o,
                left: u.left - l,
                height: a.innerHeight(),
                width: a.innerWidth(),
                position: n ? "fixed" : "absolute"
            }).animate(d, t.duration, t.easing, function() {
                c.remove(), i()
            })
    }
})(jQuery);;

/*/js/jquery/jquery.easing.1.3.js
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built In easIng capabilities added In jQuery 1.1
 * to offer multiple easIng options
 *
 * Copyright (c) 2007 George Smith
 * Licensed under the MIT License:
 *   http://www.opensource.org/licenses/mit-license.php
 

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});*/

/*/kobstereshop/js/tools.js
/*
* 2007-2012 PrestaShop
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
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14009 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

function ps_round(value, precision) {
    if (typeof(roundMode) == 'undefined')
        roundMode = 2;
    if (typeof(precision) == 'undefined')
        precision = 2;

    method = roundMode;
    if (method == 0)
        return ceilf(value, precision);
    else if (method == 1)
        return floorf(value, precision);
    precisionFactor = precision == 0 ? 1 : Math.pow(10, precision);
    return Math.round(value * precisionFactor) / precisionFactor;
}

function autoUrl(name, dest) {
    var loc;
    var id_list;

    id_list = document.getElementById(name);
    loc = id_list.options[id_list.selectedIndex].value;
    if (loc != 0)
        location.href = dest + loc;
    return;
}

function autoUrlNoList(name, dest) {
    var loc;

    loc = document.getElementById(name).checked;
    location.href = dest + (loc == true ? 1 : 0);
    return;
}

/*
 ** show or hide element e depending on condition show
 */
function toggle(e, show) {
    e.style.display = show ? '' : 'none';
}

function toggleMultiple(tab) {
    var len = tab.length;

    for (var i = 0; i < len; i++)
        if (tab[i].style)
            toggle(tab[i], tab[i].style.display == 'none');
}

/**
 * Show dynamicaly an element by changing the sytle "display" property
 * depending on the option selected in a select.
 *
 * @param string $select_id id of the select who controls the display
 * @param string $elem_id prefix id of the elements controlled by the select
 *   the real id must be : 'elem_id'+nb with nb the corresponding number in the
 *   select (starting with 0).
 */
function showElemFromSelect(select_id, elem_id) {
    var select = document.getElementById(select_id);
    for (var i = 0; i < select.length; ++i) {
        var elem = document.getElementById(elem_id + select.options[i].value);
        if (elem != null)
            toggle(elem, i == select.selectedIndex);
    }
}

/**
 * Get all div with specified name and for each one (by id), toggle their visibility
 */
function openCloseAllDiv(name, option) {
    var tab = $('*[name=' + name + ']');
    for (var i = 0; i < tab.length; ++i)
        toggle(tab[i], option);
}

/**
 * Toggle the value of the element id_button between text1 and text2
 */
function toggleElemValue(id_button, text1, text2) {
    var obj = document.getElementById(id_button);
    if (obj)
        obj.value = ((!obj.value || obj.value == text2) ? text1 : text2);
}

function addBookmark(url, title) {
    if (window.sidebar)
        return window.sidebar.addPanel(title, url, "");
    else if (window.external)
        return window.external.AddFavorite(url, title);
    else if (window.opera && window.print)
        return true;
    return true;
}

function writeBookmarkLink(url, title, text, img) {
    var insert = '';
    if (img)
        insert = writeBookmarkLinkObject(url, title, '<img src="' + img + '" alt="' + escape(text) + '" title="' + escape(text) + '" />') + '&nbsp';
    insert += writeBookmarkLinkObject(url, title, text);
    document.write(insert);
}

function writeBookmarkLinkObject(url, title, insert) {
    if (window.sidebar || window.external)
        return ('<a href="javascript:addBookmark(\'' + escape(url) + '\', \'' + escape(title) + '\')">' + insert + '</a>');
    else if (window.opera && window.print)
        return ('<a rel="sidebar" href="' + escape(url) + '" title="' + escape(title) + '">' + insert + '</a>');
    return ('');
}

function checkCustomizations() {
    var pattern = new RegExp(' ?filled ?');

    if (typeof customizationFields != 'undefined')
        for (var i = 0; i < customizationFields.length; i++)
        /* If the field is required and empty then we abort */
            if (parseInt(customizationFields[i][1]) == 1 && ($('#' + customizationFields[i][0]).html() == '' || $('#' + customizationFields[i][0]).html() != $('#' + customizationFields[i][0]).val()) && !pattern.test($('#' + customizationFields[i][0]).attr('class')))
                return false;
    return true;
}

function emptyCustomizations() {
    if (typeof(customizationFields) == 'undefined') return;

    $('.customization_block .success').fadeOut(function() {
        $(this).remove();
    });
    $('.customization_block .error').fadeOut(function() {
        $(this).remove();
    });
    for (var i = 0; i < customizationFields.length; i++) {
        $('#' + customizationFields[i][0]).html('');
        $('#' + customizationFields[i][0]).val('');
    }
}

function ceilf(value, precision) {
    if (typeof(precision) == 'undefined')
        precision = 0;
    var precisionFactor = precision == 0 ? 1 : Math.pow(10, precision);
    var tmp = value * precisionFactor;
    var tmp2 = tmp.toString();
    // If the current value has already the desired precision
    if (tmp2.indexOf('.') === false)
        return (value);
    if (tmp2.charAt(tmp2.length - 1) == 0)
        return value;
    return Math.ceil(tmp) / precisionFactor;
}

function floorf(value, precision) {
    if (typeof(precision) == 'undefined')
        precision = 0;
    var precisionFactor = precision == 0 ? 1 : Math.pow(10, precision);
    var tmp = value * precisionFactor;
    var tmp2 = tmp.toString();
    // If the current value has already the desired precision
    if (tmp2.indexOf('.') === false)
        return (value);
    if (tmp2.charAt(tmp2.length - 1) == 0)
        return value;
    return Math.floor(tmp) / precisionFactor;
}

function setCurrency(id_currency) {
    $.ajax({
        type: 'POST',
        url: baseDir + 'changecurrency.php',
        data: 'id_currency=' + parseInt(id_currency),
        success: function(msg) {
            location.reload(true);
        }
    });
}

function isArrowKey(k_ev) {
    var unicode = k_ev.keyCode ? k_ev.keyCode : k_ev.charCode;
    if (unicode >= 37 && unicode <= 40)
        return true;

}

//On dom ready
$().ready(function() {
    // Hide all elements with .hideOnSubmit class when parent form is submit
    $('form').submit(function() {
        $(this).find('.hideOnSubmit').hide();
    });
});

/*
 * Autocomplete - jQuery plugin 1.0.2
 *
 * Copyright (c) 2007 Dylan Verheul, Dan G. Switzer, Anjesh Tuladhar, Jörn Zaefferer
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Revision: $Id: jquery.autocomplete.js 6594 2011-05-23 07:11:44Z mMarinetti $
 *
 */

;
(function($) {

    $.fn.extend({
        autocomplete: function(urlOrData, options) {
            var isUrl = typeof urlOrData == "string";
            options = $.extend({}, $.Autocompleter.defaults, {
                url: isUrl ? urlOrData : null,
                data: isUrl ? null : urlOrData,
                delay: isUrl ? $.Autocompleter.defaults.delay : 10,
                max: options && !options.scroll ? 10 : 150
            }, options);

            // if highlight is set to false, replace it with a do-nothing function
            options.highlight = options.highlight || function(value) {
                return value;
            };

            // if the formatMatch option is not specified, then use formatItem for backwards compatibility
            options.formatMatch = options.formatMatch || options.formatItem;

            return this.each(function() {
                new $.Autocompleter(this, options);
            });
        },
        result: function(handler) {
            return this.bind("result", handler);
        },
        search: function(handler) {
            return this.trigger("search", [handler]);
        },
        flushCache: function() {
            return this.trigger("flushCache");
        },
        setOptions: function(options) {
            return this.trigger("setOptions", [options]);
        },
        unautocomplete: function() {
            return this.trigger("unautocomplete");
        }
    });

    $.Autocompleter = function(input, options) {

        var KEY = {
            UP: 38,
            DOWN: 40,
            DEL: 46,
            TAB: 9,
            RETURN: 13,
            ESC: 27,
            COMMA: 188,
            PAGEUP: 33,
            PAGEDOWN: 34,
            BACKSPACE: 8
        };

        // Create $ object for input element
        var $input = $(input).attr("autocomplete", "off").addClass(options.inputClass);

        var timeout;
        var previousValue = "";
        var cache = $.Autocompleter.Cache(options);
        var hasFocus = 0;
        var lastKeyPressCode;
        var config = {
            mouseDownOnSelect: false
        };
        var select = $.Autocompleter.Select(options, input, selectCurrent, config);

        var blockSubmit;

        // prevent form submit in opera when selecting with return key
        $.browser.opera && $(input.form).bind("submit.autocomplete", function() {
            if (blockSubmit) {
                blockSubmit = false;
                return false;
            }
        });

        // only opera doesn't trigger keydown multiple times while pressed, others don't work with keypress at all
        $input.bind(($.browser.opera ? "keypress" : "keydown") + ".autocomplete", function(event) {
            // track last key pressed
            lastKeyPressCode = event.keyCode;
            switch (event.keyCode) {

                case KEY.UP:
                    event.preventDefault();
                    if (select.visible()) {
                        select.prev();
                    } else {
                        onChange(0, true);
                    }
                    break;

                case KEY.DOWN:
                    event.preventDefault();
                    if (select.visible()) {
                        select.next();
                    } else {
                        onChange(0, true);
                    }
                    break;

                case KEY.PAGEUP:
                    event.preventDefault();
                    if (select.visible()) {
                        select.pageUp();
                    } else {
                        onChange(0, true);
                    }
                    break;

                case KEY.PAGEDOWN:
                    event.preventDefault();
                    if (select.visible()) {
                        select.pageDown();
                    } else {
                        onChange(0, true);
                    }
                    break;

                    // matches also semicolon
                case options.multiple && $.trim(options.multipleSeparator) == "," && KEY.COMMA:
                case KEY.TAB:
                case KEY.RETURN:
                    if (selectCurrent()) {
                        // stop default to prevent a form submit, Opera needs special handling
                        event.preventDefault();
                        blockSubmit = true;
                        return false;
                    }
                    break;

                case KEY.ESC:
                    select.hide();
                    break;

                default:
                    clearTimeout(timeout);
                    timeout = setTimeout(onChange, options.delay);
                    break;
            }
        }).focus(function() {
            // track whether the field has focus, we shouldn't process any
            // results if the field no longer has focus
            hasFocus++;
        }).blur(function() {
            hasFocus = 0;
            if (!config.mouseDownOnSelect) {
                hideResults();
            }
        }).click(function() {
            // show select when clicking in a focused field
            if (hasFocus++ > 1 && !select.visible()) {
                onChange(0, true);
            }
        }).bind("search", function() {
            // TODO why not just specifying both arguments?
            var fn = (arguments.length > 1) ? arguments[1] : null;

            function findValueCallback(q, data) {
                var result;
                if (data && data.length) {
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].result.toLowerCase() == q.toLowerCase()) {
                            result = data[i];
                            break;
                        }
                    }
                }
                if (typeof fn == "function") fn(result);
                else $input.trigger("result", result && [result.data, result.value]);
            }
            $.each(trimWords($input.val()), function(i, value) {
                request(value, findValueCallback, findValueCallback);
            });
        }).bind("flushCache", function() {
            cache.flush();
        }).bind("setOptions", function() {
            $.extend(options, arguments[1]);
            // if we've updated the data, repopulate
            if ("data" in arguments[1])
                cache.populate();
        }).bind("unautocomplete", function() {
            select.unbind();
            $input.unbind();
            $(input.form).unbind(".autocomplete");
        });


        function selectCurrent() {
            var selected = select.selected();
            if (!selected)
                return false;

            var v = selected.result;
            previousValue = v;

            if (options.multiple) {
                var words = trimWords($input.val());
                if (words.length > 1) {
                    v = words.slice(0, words.length - 1).join(options.multipleSeparator) + options.multipleSeparator + v;
                }
                v += options.multipleSeparator;
            }

            $input.val(v);
            hideResultsNow();
            $input.trigger("result", [selected.data, selected.value]);
            return true;
        }

        function onChange(crap, skipPrevCheck) {
            if (lastKeyPressCode == KEY.DEL) {
                select.hide();
                return;
            }

            var currentValue = $input.val();

            if (!skipPrevCheck && currentValue == previousValue)
                return;

            previousValue = currentValue;

            currentValue = lastWord(currentValue);
            if (currentValue.length >= options.minChars) {
                $input.addClass(options.loadingClass);
                if (!options.matchCase)
                    currentValue = currentValue.toLowerCase();
                request(currentValue, receiveData, hideResultsNow);
            } else {
                stopLoading();
                select.hide();
            }
        };

        function trimWords(value) {
            if (!value) {
                return [""];
            }
            var words = value.split(options.multipleSeparator);
            var result = [];
            $.each(words, function(i, value) {
                if ($.trim(value))
                    result[i] = $.trim(value);
            });
            return result;
        }

        function lastWord(value) {
            if (!options.multiple)
                return value;
            var words = trimWords(value);
            return words[words.length - 1];
        }

        // fills in the input box w/the first match (assumed to be the best match)
        // q: the term entered
        // sValue: the first matching result
        function autoFill(q, sValue) {
            // autofill in the complete box w/the first match as long as the user hasn't entered in more data
            // if the last user key pressed was backspace, don't autofill
            if (options.autoFill && (lastWord($input.val()).toLowerCase() == q.toLowerCase()) && lastKeyPressCode != KEY.BACKSPACE) {
                // fill in the value (keep the case the user has typed)
                $input.val($input.val() + sValue.substring(lastWord(previousValue).length));
                // select the portion of the value not typed by the user (so the next character will erase)
                $.Autocompleter.Selection(input, previousValue.length, previousValue.length + sValue.length);
            }
        };

        function hideResults() {
            clearTimeout(timeout);
            timeout = setTimeout(hideResultsNow, 200);
        };

        function hideResultsNow() {
            var wasVisible = select.visible();
            select.hide();
            clearTimeout(timeout);
            stopLoading();
            if (options.mustMatch) {
                // call search and run callback
                $input.search(
                    function(result) {
                        // if no value found, clear the input box
                        if (!result) {
                            if (options.multiple) {
                                var words = trimWords($input.val()).slice(0, -1);
                                $input.val(words.join(options.multipleSeparator) + (words.length ? options.multipleSeparator : ""));
                            } else
                                $input.val("");
                        }
                    }
                );
            }
            if (wasVisible)
            // position cursor at end of input field
                $.Autocompleter.Selection(input, input.value.length, input.value.length);
        };

        function receiveData(q, data) {
            if (data && data.length && hasFocus) {
                stopLoading();
                select.display(data, q);
                autoFill(q, data[0].value);
                select.show();
            } else {
                hideResultsNow();
            }
        };

        function request(term, success, failure) {
            if (!options.matchCase)
                term = term.toLowerCase();
            var data = cache.load(term);
            // recieve the cached data
            if (data && data.length) {
                success(term, data);
                // if an AJAX url has been supplied, try loading the data now
            } else if ((typeof options.url == "string") && (options.url.length > 0)) {

                var extraParams = {
                    timestamp: +new Date()
                };
                $.each(options.extraParams, function(key, param) {
                    extraParams[key] = typeof param == "function" ? param() : param;
                });

                $.ajax({
                    // try to leverage ajaxQueue plugin to abort previous requests
                    mode: "abort",
                    // limit abortion to this input
                    port: "autocomplete" + input.name,
                    dataType: options.dataType,
                    url: options.url,
                    data: $.extend({
                        q: lastWord(term),
                        limit: options.max
                    }, extraParams),
                    success: function(data) {
                        var parsed = options.parse && options.parse(data) || parse(data);
                        cache.add(term, parsed);
                        success(term, parsed);
                    }
                });
            } else {
                // if we have a failure, we need to empty the list -- this prevents the the [TAB] key from selecting the last successful match
                select.emptyList();
                failure(term);
            }
        };

        function parse(data) {
            var parsed = [];
            var rows = data.split("\n");
            for (var i = 0; i < rows.length; i++) {
                var row = $.trim(rows[i]);
                if (row) {
                    row = row.split("|");
                    parsed[parsed.length] = {
                        data: row,
                        value: row[0],
                        result: options.formatResult && options.formatResult(row, row[0]) || row[0]
                    };
                }
            }
            return parsed;
        };

        function stopLoading() {
            $input.removeClass(options.loadingClass);
        };

    };

    $.Autocompleter.defaults = {
        inputClass: "ac_input",
        resultsClass: "ac_results",
        loadingClass: "ac_loading",
        minChars: 1,
        delay: 400,
        matchCase: false,
        matchSubset: true,
        matchContains: false,
        cacheLength: 10,
        max: 100,
        mustMatch: false,
        extraParams: {},
        selectFirst: true,
        formatItem: function(row) {
            return row[0];
        },
        formatMatch: null,
        autoFill: false,
        width: 0,
        multiple: false,
        multipleSeparator: ", ",
        highlight: function(value, term) {
            return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + term.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi, "\\$1") + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>");
        },
        scroll: true,
        scrollHeight: 180
    };

    $.Autocompleter.Cache = function(options) {

        var data = {};
        var length = 0;

        function matchSubset(s, sub) {
            if (!options.matchCase)
                s = s.toLowerCase();
            var i = s.indexOf(sub);
            if (i == -1) return false;
            return i == 0 || options.matchContains;
        };

        function add(q, value) {
            if (length > options.cacheLength) {
                flush();
            }
            if (!data[q]) {
                length++;
            }
            data[q] = value;
        }

        function populate() {
            if (!options.data) return false;
            // track the matches
            var stMatchSets = {},
                nullData = 0;

            // no url was specified, we need to adjust the cache length to make sure it fits the local data store
            if (!options.url) options.cacheLength = 1;

            // track all options for minChars = 0
            stMatchSets[""] = [];

            // loop through the array and create a lookup structure
            for (var i = 0, ol = options.data.length; i < ol; i++) {
                var rawValue = options.data[i];
                // if rawValue is a string, make an array otherwise just reference the array
                rawValue = (typeof rawValue == "string") ? [rawValue] : rawValue;

                var value = options.formatMatch(rawValue, i + 1, options.data.length);
                if (value === false)
                    continue;

                var firstChar = value.charAt(0).toLowerCase();
                // if no lookup array for this character exists, look it up now
                if (!stMatchSets[firstChar])
                    stMatchSets[firstChar] = [];

                // if the match is a string
                var row = {
                    value: value,
                    data: rawValue,
                    result: options.formatResult && options.formatResult(rawValue) || value
                };

                // push the current match into the set list
                stMatchSets[firstChar].push(row);

                // keep track of minChars zero items
                if (nullData++ < options.max) {
                    stMatchSets[""].push(row);
                }
            };

            // add the data items to the cache
            $.each(stMatchSets, function(i, value) {
                // increase the cache size
                options.cacheLength++;
                // add to the cache
                add(i, value);
            });
        }

        // populate any existing data
        setTimeout(populate, 25);

        function flush() {
            data = {};
            length = 0;
        }

        return {
            flush: flush,
            add: add,
            populate: populate,
            load: function(q) {
                if (!options.cacheLength || !length)
                    return null;
                /* 
                 * if dealing w/local data and matchContains than we must make sure
                 * to loop through all the data collections looking for matches
                 */
                if (!options.url && options.matchContains) {
                    // track all matches
                    var csub = [];
                    // loop through all the data grids for matches
                    for (var k in data) {
                        // don't search through the stMatchSets[""] (minChars: 0) cache
                        // this prevents duplicates
                        if (k.length > 0) {
                            var c = data[k];
                            $.each(c, function(i, x) {
                                // if we've got a match, add it to the array
                                if (matchSubset(x.value, q)) {
                                    csub.push(x);
                                }
                            });
                        }
                    }
                    return csub;
                } else
                // if the exact item exists, use it
                if (data[q]) {
                    return data[q];
                } else
                if (options.matchSubset) {
                    for (var i = q.length - 1; i >= options.minChars; i--) {
                        var c = data[q.substr(0, i)];
                        if (c) {
                            var csub = [];
                            $.each(c, function(i, x) {
                                if (matchSubset(x.value, q)) {
                                    csub[csub.length] = x;
                                }
                            });
                            return csub;
                        }
                    }
                }
                return null;
            }
        };
    };

    $.Autocompleter.Select = function(options, input, select, config) {
        var CLASSES = {
            ACTIVE: "ac_over"
        };

        var listItems,
            active = -1,
            data,
            term = "",
            needsInit = true,
            element,
            list;

        // Create results
        function init() {
            if (!needsInit)
                return;
            element = $("<div/>")
                .hide()
                .addClass(options.resultsClass)
                .css("position", "absolute")
                .appendTo(document.body);

            list = $("<ul/>").appendTo(element).mouseover(function(event) {
                if (target(event).nodeName && target(event).nodeName.toUpperCase() == 'LI') {
                    active = $("li", list).removeClass(CLASSES.ACTIVE).index(target(event));
                    $(target(event)).addClass(CLASSES.ACTIVE);
                }
            }).click(function(event) {
                $(target(event)).addClass(CLASSES.ACTIVE);
                select();
                // TODO provide option to avoid setting focus again after selection? useful for cleanup-on-focus
                input.focus();
                return false;
            }).mousedown(function() {
                config.mouseDownOnSelect = true;
            }).mouseup(function() {
                config.mouseDownOnSelect = false;
            });

            if (options.width > 0)
                element.css("width", options.width);

            needsInit = false;
        }

        function target(event) {
            var element = event.target;
            while (element && element.tagName != "LI")
                element = element.parentNode;
            // more fun with IE, sometimes event.target is empty, just ignore it then
            if (!element)
                return [];
            return element;
        }

        function moveSelect(step) {
            listItems.slice(active, active + 1).removeClass(CLASSES.ACTIVE);
            movePosition(step);
            var activeItem = listItems.slice(active, active + 1).addClass(CLASSES.ACTIVE);
            if (options.scroll) {
                var offset = 0;
                listItems.slice(0, active).each(function() {
                    offset += this.offsetHeight;
                });
                if ((offset + activeItem[0].offsetHeight - list.scrollTop()) > list[0].clientHeight) {
                    list.scrollTop(offset + activeItem[0].offsetHeight - list.innerHeight());
                } else if (offset < list.scrollTop()) {
                    list.scrollTop(offset);
                }
            }
        };

        function movePosition(step) {
            active += step;
            if (active < 0) {
                active = listItems.size() - 1;
            } else if (active >= listItems.size()) {
                active = 0;
            }
        }

        function limitNumberOfItems(available) {
            return options.max && options.max < available ? options.max : available;
        }

        function fillList() {
            list.empty();
            var max = limitNumberOfItems(data.length);
            for (var i = 0; i < max; i++) {
                if (!data[i])
                    continue;
                var formatted = options.formatItem(data[i].data, i + 1, max, data[i].value, term);
                if (formatted === false)
                    continue;
                var li = $("<li/>").html(options.highlight(formatted, term)).addClass(i % 2 == 0 ? "ac_even" : "ac_odd").appendTo(list)[0];
                $.data(li, "ac_data", data[i]);
            }
            listItems = list.find("li");
            if (options.selectFirst) {
                listItems.slice(0, 1).addClass(CLASSES.ACTIVE);
                active = 0;
            }
            // apply bgiframe if available
            if ($.fn.bgiframe)
                list.bgiframe();
        }

        return {
            display: function(d, q) {
                init();
                data = d;
                term = q;
                fillList();
            },
            next: function() {
                moveSelect(1);
            },
            prev: function() {
                moveSelect(-1);
            },
            pageUp: function() {
                if (active != 0 && active - 8 < 0) {
                    moveSelect(-active);
                } else {
                    moveSelect(-8);
                }
            },
            pageDown: function() {
                if (active != listItems.size() - 1 && active + 8 > listItems.size()) {
                    moveSelect(listItems.size() - 1 - active);
                } else {
                    moveSelect(8);
                }
            },
            hide: function() {
                element && element.hide();
                listItems && listItems.removeClass(CLASSES.ACTIVE);
                active = -1;
            },
            visible: function() {
                return element && element.is(":visible");
            },
            current: function() {
                return this.visible() && (listItems.filter("." + CLASSES.ACTIVE)[0] || options.selectFirst && listItems[0]);
            },
            show: function() {
                var offset = $(input).offset();
                element.css({
                    width: typeof options.width == "string" || options.width > 0 ? options.width : $(input).width(),
                    top: offset.top + input.offsetHeight,
                    left: offset.left
                }).show();
                if (options.scroll) {
                    list.css({
                        maxHeight: options.scrollHeight,
                        overflow: 'auto'
                    });

                    if ($.browser.msie && typeof document.body.style.maxHeight === "undefined") {
                        var listHeight = 0;
                        listItems.each(function() {
                            listHeight += this.offsetHeight;
                        });
                        var scrollbarsVisible = listHeight > options.scrollHeight;
                        list.css('height', scrollbarsVisible ? options.scrollHeight : listHeight);
                        if (!scrollbarsVisible) {
                            // IE doesn't recalculate width when scrollbar disappears
                            listItems.width(list.width() - parseInt(listItems.css("padding-left")) - parseInt(listItems.css("padding-right")));
                        }
                    }

                }
            },
            selected: function() {
                var selected = listItems && listItems.filter("." + CLASSES.ACTIVE).removeClass(CLASSES.ACTIVE);
                return selected && selected.length && $.data(selected[0], "ac_data");
            },
            emptyList: function() {
                list && list.empty();
            },
            unbind: function() {
                element && element.remove();
            }
        };
    };

    $.Autocompleter.Selection = function(field, start, end) {
        if (field.createTextRange) {
            var selRange = field.createTextRange();
            selRange.collapse(true);
            selRange.moveStart("character", start);
            selRange.moveEnd("character", end);
            selRange.select();
        } else if (field.setSelectionRange) {
            field.setSelectionRange(start, end);
        } else {
            if (field.selectionStart) {
                field.selectionStart = start;
                field.selectionEnd = end;
            }
        }
        field.focus();
    };

})(jQuery);


/* productscategory module
 * 2007-2011 PrestaShop 
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
 *  @copyright  2007-2011 PrestaShop SA
 *  @version  Release: $Revision: 7044 $
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

// function pc_serialScrollFixLock(event, targeted, scrolled, items, position)
// {
// 	var leftArrow1 = position == 0 ? true : false;
// 	var rightArrow1 = position + 5 >= $('#productscategory_list li:visible').length ? true : false;

// 	$('a#productscategory_scroll_left').css('cursor', leftArrow1 ? 'default' : 'pointer').fadeTo(0, leftArrow1 ? 0 : 1);		
// 	$('a#productscategory_scroll_right').css('cursor', rightArrow1 ? 'default' : 'pointer').fadeTo(0, rightArrow1 ? 0 : 1).css('display', rightArrow1 ? 'none' : 'block');

// 	return true;
// }

// $(document).ready(function()
// {
// 	$('#productscategory_list').serialScroll({
// 		items: 'li',
// 		prev: 'a#productscategory_scroll_left',
// 		next: 'a#productscategory_scroll_right',
// 		axis: 'x',
// 		offset: 0,
// 		stop: true,
// 		onBefore: pc_serialScrollFixLock,
// 		duration: 300,
// 		step: 1,
// 		lazy: true,
// 		lock: false,
// 		force: false,
// 		cycle: false });
// 	$('#productscategory_list').trigger( 'goto', 0);
// });


/*
 * jQuery.SerialScroll - Animated scrolling of series
 * Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 06/14/2009
 * @author Ariel Flesler
 * @version 1.2.2
 * http://flesler.blogspot.com/2008/02/jqueryserialscroll.html
 */
;
(function(a) {
    var b = a.serialScroll = function(c) {
        return a(window).serialScroll(c)
    };
    b.defaults = {
        duration: 1e3,
        axis: "x",
        event: "click",
        start: 0,
        step: 1,
        lock: !0,
        cycle: !0,
        constant: !0
    };
    a.fn.serialScroll = function(c) {
        return this.each(function() {
            var t = a.extend({}, b.defaults, c),
                s = t.event,
                i = t.step,
                r = t.lazy,
                e = t.target ? this : document,
                u = a(t.target || this, e),
                p = u[0],
                m = t.items,
                h = t.start,
                g = t.interval,
                k = t.navigation,
                l;
            if (!r) {
                m = d()
            }
            if (t.force) {
                f({}, h)
            }
            a(t.prev || [], e).bind(s, -i, q);
            a(t.next || [], e).bind(s, i, q);
            if (!p.ssbound) {
                u.bind("prev.serialScroll", -i, q).bind("next.serialScroll", i, q).bind("goto.serialScroll", f)
            }
            if (g) {
                u.bind("start.serialScroll", function(v) {
                    if (!g) {
                        o();
                        g = !0;
                        n()
                    }
                }).bind("stop.serialScroll", function() {
                    o();
                    g = !1
                })
            }
            u.bind("notify.serialScroll", function(x, w) {
                var v = j(w);
                if (v > -1) {
                    h = v
                }
            });
            p.ssbound = !0;
            if (t.jump) {
                (r ? u : d()).bind(s, function(v) {
                    f(v, j(v.target))
                })
            }
            if (k) {
                k = a(k, e).bind(s, function(v) {
                    v.data = Math.round(d().length / k.length) * k.index(this);
                    f(v, this)
                })
            }

            function q(v) {
                v.data += h;
                f(v, this)
            }

            function f(B, z) {
                if (!isNaN(z)) {
                    B.data = z;
                    z = p
                }
                var C = B.data,
                    v, D = B.type,
                    A = t.exclude ? d().slice(0, -t.exclude) : d(),
                    y = A.length,
                    w = A[C],
                    x = t.duration;
                if (D) {
                    B.preventDefault()
                }
                if (g) {
                    o();
                    l = setTimeout(n, t.interval)
                }
                if (!w) {
                    v = C < 0 ? 0 : y - 1;
                    if (h != v) {
                        C = v
                    } else {
                        if (!t.cycle) {
                            return
                        } else {
                            C = y - v - 1
                        }
                    }
                    w = A[C]
                }
                if (!w || t.lock && u.is(":animated") || D && t.onBefore && t.onBefore(B, w, u, d(), C) === !1) {
                    return
                }
                if (t.stop) {
                    u.queue("fx", []).stop()
                }
                if (t.constant) {
                    x = Math.abs(x / i * (h - C))
                }
                u.scrollTo(w, x, t).trigger("notify.serialScroll", [C])
            }

            function n() {
                u.trigger("next.serialScroll")
            }

            function o() {
                clearTimeout(l)
            }

            function d() {
                return a(m, p)
            }

            function j(w) {
                if (!isNaN(w)) {
                    return w
                }
                var x = d(),
                    v;
                while ((v = x.index(w)) == -1 && w != p) {
                    w = w.parentNode
                }
                return v
            }
        })
    }
})(jQuery);

//jgrowl.js
(function($) {
    $.jGrowl = function(m, o) {
        if ($('#jGrowl').size() == 0) $('<div id="jGrowl"></div>').addClass($.jGrowl.defaults.position).appendTo('body');
        $('#jGrowl').jGrowl(m, o);
    };
    $.fn.jGrowl = function(m, o) {
        if ($.isFunction(this.each)) {
            var args = arguments;
            return this.each(function() {
                var self = this;
                if ($(this).data('jGrowl.instance') == undefined) {
                    $(this).data('jGrowl.instance', $.extend(new $.fn.jGrowl(), {
                        notifications: [],
                        element: null,
                        interval: null
                    }));
                    $(this).data('jGrowl.instance').startup(this);
                }
                if ($.isFunction($(this).data('jGrowl.instance')[m])) {
                    $(this).data('jGrowl.instance')[m].apply($(this).data('jGrowl.instance'), $.makeArray(args).slice(1));
                } else {
                    $(this).data('jGrowl.instance').create(m, o);
                }
            });
        };
    };
    $.extend($.fn.jGrowl.prototype, {
        defaults: {
            pool: 0,
            header: '',
            group: '',
            sticky: false,
            position: 'top-right',
            glue: 'after',
            theme: 'default',
            corners: '10px',
            check: 250,
            life: 3000,
            speed: 'normal',
            easing: 'swing',
            closer: true,
            closeTemplate: '&times;',
            closerTemplate: '<div>[ close all ]</div>',
            log: function(e, m, o) {},
            beforeOpen: function(e, m, o) {},
            open: function(e, m, o) {},
            beforeClose: function(e, m, o) {},
            close: function(e, m, o) {},
            animateOpen: {
                opacity: 'show'
            },
            animateClose: {
                opacity: 'hide'
            }
        },
        notifications: [],
        element: null,
        interval: null,
        create: function(message, o) {
            var o = $.extend({}, this.defaults, o);
            this.notifications[this.notifications.length] = {
                message: message,
                options: o
            };
            o.log.apply(this.element, [this.element, message, o]);
        },
        render: function(notification) {
            var self = this;
            var message = notification.message;
            var o = notification.options;
            var notification = $('<div class="jGrowl-notification' + ((o.group != undefined && o.group != '') ? ' ' + o.group : '') + '"><div class="close">' + o.closeTemplate + '</div><div class="header">' + o.header + '</div><div class="message">' + message + '</div></div>').data("jGrowl", o).addClass(o.theme).children('div.close').bind("click.jGrowl", function() {
                $(this).parent().trigger('jGrowl.close');
            }).parent();
            (o.glue == 'after') ? $('div.jGrowl-notification:last', this.element).after(notification): $('div.jGrowl-notification:first', this.element).before(notification);
            $(notification).bind("mouseover.jGrowl", function() {
                $(this).data("jGrowl").pause = true;
            }).bind("mouseout.jGrowl", function() {
                $(this).data("jGrowl").pause = false;
            }).bind('jGrowl.beforeOpen', function() {
                o.beforeOpen.apply(self.element, [self.element, message, o]);
            }).bind('jGrowl.open', function() {
                o.open.apply(self.element, [self.element, message, o]);
            }).bind('jGrowl.beforeClose', function() {
                o.beforeClose.apply(self.element, [self.element, message, o]);
            }).bind('jGrowl.close', function() {
                $(this).data('jGrowl').pause = true;
                $(this).trigger('jGrowl.beforeClose').animate(o.animateClose, o.speed, o.easing, function() {
                    $(this).remove();
                    o.close.apply(self.element, [self.element, message, o]);
                });
            }).trigger('jGrowl.beforeOpen').animate(o.animateOpen, o.speed, o.easing, function() {
                $(this).data("jGrowl").created = new Date();
            }).trigger('jGrowl.open');
            if ($.fn.corner != undefined) $(notification).corner(o.corners);
            if ($('div.jGrowl-notification:parent', this.element).size() > 1 && $('div.jGrowl-closer', this.element).size() == 0 && this.defaults.closer != false) {
                $(this.defaults.closerTemplate).addClass('jGrowl-closer').addClass(this.defaults.theme).appendTo(this.element).animate(this.defaults.animateOpen, this.defaults.speed, this.defaults.easing).bind("click.jGrowl", function() {
                    $(this).siblings().children('div.close').trigger("click.jGrowl");
                    if ($.isFunction(self.defaults.closer)) self.defaults.closer.apply($(this).parent()[0], [$(this).parent()[0]]);
                });
            };
        },
        update: function() {
            $(this.element).find('div.jGrowl-notification:parent').each(function() {
                if ($(this).data("jGrowl") != undefined && $(this).data("jGrowl").created != undefined && ($(this).data("jGrowl").created.getTime() + $(this).data("jGrowl").life) < (new Date()).getTime() && $(this).data("jGrowl").sticky != true && ($(this).data("jGrowl").pause == undefined || $(this).data("jGrowl").pause != true)) {
                    $(this).trigger('jGrowl.close');
                }
            });
            if (this.notifications.length > 0 && (this.defaults.pool == 0 || $(this.element).find('div.jGrowl-notification:parent').size() < this.defaults.pool)) {
                this.render(this.notifications.shift());
            }
            if ($(this.element).find('div.jGrowl-notification:parent').size() < 2) {
                $(this.element).find('div.jGrowl-closer').animate(this.defaults.animateClose, this.defaults.speed, this.defaults.easing, function() {
                    $(this).remove();
                });
            };
        },
        startup: function(e) {
            this.element = $(e).addClass('jGrowl').append('<div class="jGrowl-notification"></div>');
            this.interval = setInterval(function() {
                $(e).data('jGrowl.instance').update();
            }, this.defaults.check);
            if ($.browser.msie && parseInt($.browser.version) < 7 && !window["XMLHttpRequest"]) $(this.element).addClass('ie6');
        },
        shutdown: function() {
            $(this.element).removeClass('jGrowl').find('div.jGrowl-notification').remove();
            clearInterval(this.interval);
        }
    });
    $.jGrowl.defaults = $.fn.jGrowl.prototype.defaults;
})(jQuery);

/* sisterCategory module
 * 2007-2011 PrestaShop 
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
 *  @copyright  2007-2011 PrestaShop SA
 *  @version  Release: $Revision: 7044 $
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

function pc_serialScrollFixLock(event, targeted, scrolled, items, position) {
    var leftArrow = position == 0 ? true : false;
    var rightArrow = position + 5 >= $('#productscategory_list li:visible').length ? true : false;

    $('a#productscategory_scroll_left').css('cursor', leftArrow ? 'default' : 'pointer').fadeTo(0, leftArrow ? 0 : 1);
    $('a#productscategory_scroll_right').css('cursor', rightArrow ? 'default' : 'pointer').fadeTo(0, rightArrow ? 0 : 1).css('display', rightArrow ? 'none' : 'block');

    return true;
}

$(document).ready(function() {
    $("#sisterProducts_list img.lazyImage").jail({
        effect: 'fadeIn',
        speed: 500
    });
    $('#block_content_bv img.lazyImage').jail({
        effect: 'fadeIn',
        speed: 500
    });
    $('#productscategory_list img.lazyImage').jail({
        effect: 'fadeIn',
        speed: 500
    });
    $('#productscategory_list').serialScroll({
        items: 'li',
        prev: 'a#productscategory_scroll_left',
        next: 'a#productscategory_scroll_right',
        axis: 'x',
        offset: 0,
        stop: true,
        onBefore: pc_serialScrollFixLock,
        duration: 300,
        step: 1,
        lazy: true,
        lock: false,
        force: false,
        cycle: false
    });
    $('#productscategory_list').trigger('goto', 0);
});


/*kobstereshop/modules/blockcart/ajax-cart.js
* 2007-2011 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with
 this package in the file LICENSE.txt.
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
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 13108 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/


//JS Object : update the cart by ajax actions
var ajaxCart = {

    //override every button in the page in relation to the cart
    overrideButtonsInThePage: function() {
        //for every gv 'add' buttons...
        $('.ajax_add_to_cart_button').unbind('click').click(function() {

            var idProduct = $(this).attr('rel').replace('ajax_id_product_', '');
            var quantity_name = '#'.concat(idProduct, '_quantity_wanted');
            if ($(this).attr('disabled') != 'disabled') {
                ajaxCart.add(idProduct, null, false, this, $(quantity_name).val(), null);
            }
            return false;
        });
        //for every lv 'add' buttons...
        $('.lv_ajax_add_to_cart_button').unbind('click').click(function() {
            var idProduct = $(this).attr('rel').replace('ajax_id_product_', '');
            var quantity_name = '#'.concat(idProduct, '_lv_quantity_wanted');
            if ($(this).attr('disabled') != 'disabled') {
                ajaxCart.add(idProduct, null, false, this, $(quantity_name).val(), null);
            }
            return false;
        });
        //for every hc 'add' buttons...
        $('.hc_ajax_add_to_cart_button').unbind('click').click(function() {
            var idProduct = $(this).attr('rel').replace('ajax_id_product_', '');
            var quantity_name = '#'.concat(idProduct, '_hc_quantity_wanted');
            if ($(this).attr('disabled') != 'disabled') {
                ajaxCart.add(idProduct, null, false, this, $(quantity_name).val(), null);
            }
            return false;
        });
        //for every hc qv 'add' buttons...
        $('.hc_qv_ajax_add_to_cart_button').unbind('click').click(function() {
            var idProduct = $(this).attr('rel').replace('ajax_id_product_', '');
            var quantity_name = '#'.concat(idProduct, '_hc_qv_quantity_wanted');
            if ($(this).attr('disabled') != 'disabled') {
                ajaxCart.add(idProduct, null, false, this, $(quantity_name).val(), null);
            }
            return false;
        });
        //for every hc 'add' buttons...
        $('.hf_ajax_add_to_cart_button').unbind('click').click(function() {
            var idProduct = $(this).attr('rel').replace('ajax_id_product_', '');
            var quantity_name = '#'.concat(idProduct, '_hf_quantity_wanted');
            if ($(this).attr('disabled') != 'disabled') {
                ajaxCart.add(idProduct, null, false, this, $(quantity_name).val(), null);
            }
            return false;
        });
        //for every hc qv 'add' buttons...
        $('.hf_qv_ajax_add_to_cart_button').unbind('click').click(function() {
            var idProduct = $(this).attr('rel').replace('ajax_id_product_', '');
            var quantity_name = '#'.concat(idProduct, '_hf_qv_quantity_wanted');
            if ($(this).attr('disabled') != 'disabled') {
                ajaxCart.add(idProduct, null, false, this, $(quantity_name).val(), null);
            }
            return false;
        });
        //for every hc qv 'add' buttons...
        $('.bs_ajax_add_to_cart_button').unbind('click').click(function() {
            var idProduct = $(this).attr('rel').replace('ajax_id_product_', '');
            var quantity_name = '#'.concat(idProduct, '_bs_quantity_wanted');
            if ($(this).attr('disabled') != 'disabled') {
                ajaxCart.add(idProduct, null, false, this, $(quantity_name).val(), null);
            }
            return false;
        });
        //for every hc qv 'add' buttons...
        $('.bs_qv_ajax_add_to_cart_button').unbind('click').click(function() {
            var idProduct = $(this).attr('rel').replace('ajax_id_product_', '');
            var quantity_name = '#'.concat(idProduct, '_bs_qv_quantity_wanted');
            if ($(this).attr('disabled') != 'disabled') {
                ajaxCart.add(idProduct, null, false, this, $(quantity_name).val(), null);
            }
            return false;
        });
        //for every hc qv 'add' buttons...
        $('.gi_ajax_add_to_cart_button').unbind('click').click(function() {
            var idProduct = $(this).attr('rel').replace('ajax_id_product_', '');
            var quantity_name = '#'.concat(idProduct, '_gi_quantity_wanted');
            if ($(this).attr('disabled') != 'disabled') {
                ajaxCart.add(idProduct, null, false, this, $(quantity_name).val(), null);
            }
            return false;
        });
        //for every hc qv 'add' buttons...
        $('.gi_qv_ajax_add_to_cart_button').unbind('click').click(function() {
            var idProduct = $(this).attr('rel').replace('ajax_id_product_', '');
            var quantity_name = '#'.concat(idProduct, '_gi_qv_quantity_wanted');
            if ($(this).attr('disabled') != 'disabled') {
                ajaxCart.add(idProduct, null, false, this, $(quantity_name).val(), null);
            }
            return false;
        });
        //For quick view add to cart
        $('.qv_ajax_add_to_cart_button').unbind('click').click(function() {
            var idProduct = $(this).attr('rel').replace('ajax_id_product_', '');
            var quantity_name = '#'.concat(idProduct, '_qv_quantity_wanted');
            if ($(this).attr('disabled') != 'disabled') {
                ajaxCart.add(idProduct, null, false, this, $(quantity_name).val(), null);
            }
            return false;
        });
        //for product page 'add' button...
        $('body#product p#add_to_cart input').unbind('click').click(function() {
            if ($('#hiddenpincode').val() == 1) {
                ajaxCart.add($('#product_page_product_id').val(), $('#idCombination').val(), true, null, $('#quantity_wanted').val(), null);
                return false;
            } else {
                $.jGrowl("Please Check the product availability at your location");
                $('#pincode').focus();
                return false;
            }
        });

        //for 'delete' buttons in the cart block...
        $('#cart_block_list .ajax_cart_block_remove_link').unbind('click').click(function() {
            // Customized product management
            var customizationId = 0;
            var productId = 0;
            var productAttributeId = 0;
            if ($($(this).parent().parent()).attr('name') == 'customization')
            // Reverse two levels: a >> div >> li
                var customizableProductDiv = $($(this).parent().parent()).find("div[id^=deleteCustomizableProduct_]");
            else
                var customizableProductDiv = $($(this).parent()).find("div[id^=deleteCustomizableProduct_]");
            if (customizableProductDiv && $(customizableProductDiv).length) {
                $(customizableProductDiv).each(function() {
                    var ids = $(this).attr('id').split('_');
                    if (typeof(ids[1]) != 'undefined') {
                        customizationId = parseInt(ids[1]);
                        productId = parseInt(ids[2]);
                        if (typeof(ids[3]) != 'undefined')
                            productAttributeId = parseInt(ids[3]);
                        return false;
                    }
                });
            }

            // Common product management
            if (!customizationId) {
                //retrieve idProduct and idCombination from the displayed product in the block cart
                var firstCut = $(this).parent().parent().attr('id').replace('cart_block_product_', '');
                firstCut = firstCut.replace('deleteCustomizableProduct_', '');
                ids = firstCut.split('_');
                productId = parseInt(ids[0]);
                if (typeof(ids[1]) != 'undefined')
                    productAttributeId = parseInt(ids[1]);
            }

            // Removing product from the cart
            ajaxCart.remove(productId, productAttributeId, customizationId);
            return false;
        });
    },

    // try to expand the cart
    expand: function() {
        $(['left_column', 'right_column', 'header']).each(function(id, parentId) {
            if ($('#' + parentId + ' #cart_block #cart_block_list').hasClass('collapsed')) {
                $('#' + parentId + ' #cart_block #cart_block_summary').slideUp(20, function() {
                    $(this).addClass('collapsed').removeClass('expanded');
                    $('#' + parentId + ' #cart_block #cart_block_list').slideDown({
                        duration: 60,
                        complete: function() {
                            $(this).addClass('expanded').removeClass('collapsed');
                            $('#block_content').slideDown();
                        }
                    });
                });
                // toogle the button expand/collapse button
                $('#' + parentId + ' #cart_block h4 span#block_cart_expand').fadeOut('slow', function() {
                    $('#' + parentId + ' #cart_block h4 span#block_cart_collapse').fadeIn('fast');
                });

                // save the expand statut in the user cookie
                $.ajax({
                    type: 'GET',
                    url: baseDir + 'modules/blockcart/blockcart-set-collapse.php',
                    async: true,
                    data: 'ajax_blockcart_display=expand' + '&rand=' + new Date().getTime()
                });
            }
        });
    },
    // cart to fix display when using back and previous browsers buttons
    refresh: function() {
        //send the ajax request to the server
        $.ajax({
            type: 'GET',
            url: baseDir + 'cart.php',
            async: true,
            cache: false,
            dataType: "json",
            data: 'ajax=true&token=' + static_token,
            success: function(jsonData) {
                ajaxCart.updateCart(jsonData);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                // in front-office, do not display technical error
                //alert("TECHNICAL ERROR: unable to refresh the cart.\n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
            }
        });
    },

    // try to collapse the cart
    collapse: function() {

        if ($('#cart_block #cart_block_list').hasClass('expanded')) {
            $('#cart_block #cart_block_list').slideUp('slow', function() {
                $(this).addClass('collapsed').removeClass('expanded');
                $('#cart_block #cart_block_summary').slideDown(70, function() {
                    $(this).addClass('expanded').removeClass('collapsed');
                });
            });
            $('#cart_block h4 span#block_cart_collapse').fadeOut('slow', function() {
                $('#cart_block h4 span#block_cart_expand').fadeIn('fast');
            });

            // save the expand statut in the user cookie
            $.ajax({
                type: 'GET',
                url: baseDir + 'modules/blockcart/blockcart-set-collapse.php',
                async: true,
                data: 'ajax_blockcart_display=collapse' + '&rand=' + new Date().getTime()
            });
        }
        $('#block_content').slideUp();
    },

    // Update the cart information
    updateCartInformation: function(jsonData, addedFromProductPage) {
        ajaxCart.updateCart(jsonData);

        //reactive the button when adding has finished
        if (addedFromProductPage) {

            var value1 = $('body#product p#add_to_cart input');
            $('body#product p#add_to_cart input').removeAttr('disabled'). /*addClass('exclusive').*/ removeClass('exclusive_disabled');
        } else {
            if ($('.ajax_add_to_cart_button').length > 0) {

                $('.ajax_add_to_cart_button').removeAttr('disabled');
            }
            if ($('.hc_ajax_add_to_cart_button').length > 0) {
                $('.hc_ajax_add_to_cart_button').removeAttr('disabled');
            }
            if ($('.hc_qv_ajax_add_to_cart_button').length > 0) {
                $('.hc_qv_ajax_add_to_cart_button').removeAttr('disabled');
            }
            if ($('.qv_ajax_add_to_cart_button').length > 0) {
                $('.qv_ajax_add_to_cart_button').removeAttr('disabled');
            }
        }
    },

    // add a product in the cart via ajax
    add: function(idProduct, idCombination, addedFromProductPage, callerElement, quantity, whishlist) {
        if (addedFromProductPage && !checkCustomizations()) {
            alert(fieldRequired);
            return;
        }
        emptyCustomizations();
        //disabled the button when adding to do not double add if user double click
        if (addedFromProductPage) {
            //alert("2");
            $('body#product p#add_to_cart input').attr('disabled', 'disabled').removeClass('exclusive') /*.addClass('exclusive_disabled')*/ ;
            $('.filled').removeClass('filled');
        }
        if (callerElement != null)
            $(callerElement).attr('disabled', 'disabled');


        //if ($('#cart_block #cart_block_list').hasClass('collapsed'))
        //this.expand();
        //send the ajax request to the server
        $.ajax({
            type: 'POST',
            url: baseDir + 'cart.php',
            async: true,
            cache: false,
            dataType: "json",
            data: 'add=1&ajax=true&qty=' + ((quantity && quantity != null) ? quantity : '1') + '&id_product=' + idProduct + '&token=' + static_token + ((parseInt(idCombination) && idCombination != null) ? '&ipa=' + parseInt(idCombination) : ''),
            success: function(jsonData, textStatus, jqXHR) {
                //Display alert
                if ($('#cart_block #cart_block_list').hasClass('collapsed'))
                    $.jGrowl('Item added to cart!<br/><b>(Click down arrow to view cart)</b>');
                $('.quickView').hide();
                $('.quickViewClose').click();
                // add appliance to whishlist module
                if (whishlist && !jsonData.errors)
                    WishlistAddProductCart(whishlist[0], idProduct, idCombination, whishlist[1]);

                // add the picture to the cart
                var $element = $(callerElement).parent().parent().find('a.product_image img,a.product_img_link img');
                if (!$element.length)
                    $element = $('#bigpic');
                var $picture = $element.clone();
                var pictureOffsetOriginal = $element.offset();

                if ($picture.size())
                    $picture.css({
                        'position': 'absolute',
                        'top': pictureOffsetOriginal.top,
                        'left': pictureOffsetOriginal.left
                    });

                var pictureOffset = $picture.offset();
                var cartBlockOffset = $('#cart_block').offset();

                // Check if the block cart is activated for the animation
                if (cartBlockOffset != undefined && $picture.size() && false) {
                    $picture.appendTo('body');
                    $picture.css({
                            'z-index': 9999,
                            'top': $picture.css('top'),
                            'left': $picture.css('left')
                        })
                        .animate({
                            'width': $element.attr('width') * 0.66,
                            'height': $element.attr('height') * 0.66,
                            'opacity': 0.2,
                            'top': cartBlockOffset.top + 30,
                            'left': cartBlockOffset.left + 15
                        }, 1000)
                        .fadeOut(100, function() {
                            ajaxCart.updateCartInformation(jsonData, addedFromProductPage);
                        });
                } else
                    ajaxCart.updateCartInformation(jsonData, addedFromProductPage);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("TECHNICAL ERROR: unable to add the product.\n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                //reactive the button when adding has finished
                if (addedFromProductPage) {
                    //alert("3");
                    $('body#product p#add_to_cart input').removeAttr('disabled').addClass('exclusive').removeClass('exclusive_disabled');
                } else
                    $(callerElement).removeAttr('disabled');
            }
        });
    },

    //remove a product from the cart via ajax
    remove: function(idProduct, idCombination, customizationId) {
        //send the ajax request to the server
        $.ajax({
            type: 'POST',
            url: baseDir + 'cart.php',
            async: true,
            cache: false,
            dataType: "json",
            data: 'delete=1&id_product=' + idProduct + '&ipa=' + ((idCombination != null && parseInt(idCombination)) ? idCombination : '') + ((customizationId && customizationId != null) ? '&id_customization=' + customizationId : '') + '&token=' + static_token + '&ajax=true',
            success: function(jsonData) {
                ajaxCart.updateCart(jsonData);
                if ($('body').attr('id') == 'order' || $('body').attr('id') == 'order-opc')
                    deletProductFromSummary(idProduct + '_' + idCombination);
            },
            error: function() {
                alert('ERROR: unable to delete the product');
            }
        });
    },

    //hide the products displayed in the page but no more in the json data
    hideOldProducts: function(jsonData) {
        $(['left_column', 'right_column', 'header']).each(function(id, parentId) {
            //delete an eventually removed product of the displayed cart (only if cart is not empty!)
            if ($('#cart_block #cart_block_list dl.products').length > 0) {
                var removedProductId = null;
                var removedProductData = null;
                var removedProductDomId = null;
                //look for a product to delete...
                $('#' + parentId + ' #cart_block_list dl.products dt').each(function() {
                    //retrieve idProduct and idCombination from the displayed product in the block cart
                    var domIdProduct = $(this).attr('id');
                    var firstCut = domIdProduct.replace('cart_block_product_', '');
                    var ids = firstCut.split('_');

                    //try to know if the current product is still in the new list
                    var stayInTheCart = false;
                    for (aProduct in jsonData.products) {
                        //we've called the variable aProduct because IE6 bug if this variable is called product
                        //if product has attributes
                        if (jsonData.products[aProduct]['id'] == ids[0] && (!ids[1] || jsonData.products[aProduct]['idCombination'] == ids[1])) {
                            stayInTheCart = true;
                            // update the product customization display (when the product is still in the cart)
                            ajaxCart.hideOldProductCustomizations(jsonData.products[aProduct], domIdProduct);
                        }
                    }
                    //remove product if it's no more in the cart
                    if (!stayInTheCart) {
                        removedProductId = $(this).attr('id');
                        //return false; // Regarding that the customer can only remove products one by one, we break the loop
                    }

                    //if there is a removed product, delete it from the displayed block cart
                    if (removedProductId != null) {
                        var firstCut = removedProductId.replace('cart_block_product_', '');
                        var ids = firstCut.split('_');

                        $('#' + parentId + ' #' + removedProductId).addClass('strike').fadeTo('slow', 0, function() {
                            $(this).slideUp('slow', function() {
                                $(this).remove();
                                //if the cart is now empty, show the 'no product in the cart' message
                                if ($('#' + parentId + ' #cart_block dl.products dt').length == 0) {
                                    $('#' + parentId + ' p#cart_block_no_products').slideDown('fast');
                                    $('#' + parentId + ' div#cart_block dl.products').remove();
                                }
                            });
                        });
                        $('#' + parentId + ' dd#cart_block_combination_of_' + ids[0] + (ids[1] ? '_' + ids[1] : '')).fadeTo('fast', 0, function() {
                            $(this).slideUp('fast', function() {
                                $(this).remove();
                            });
                        });
                    }
                });
            }
        });
    },

    hideOldProductCustomizations: function(product, domIdProduct) {
        $(['left_column', 'right_column', 'header']).each(function(id, parentId) {
            var customizationList = $('#' + parentId + ' #cart_block #cart_block_list ul#customization_' + product['id'] + '_' + product['idCombination']);
            if (customizationList.length > 0) {
                $(customizationList).find("li").each(function() {
                    $(this).find("div").each(function() {
                        var customizationDiv = $(this).attr('id');
                        var tmp = customizationDiv.replace('deleteCustomizableProduct_', '');
                        var ids = tmp.split('_');
                        if ((parseInt(product.idCombination) == parseInt(ids[2])) && !ajaxCart.doesCustomizationStillExist(product, ids[0]))
                            $('#' + customizationDiv).parent().addClass('strike').fadeTo('slow', 0, function() {
                                $(this).slideUp('slow');
                                $(this).remove();
                            });
                    });
                });
            }
            var removeLinks = $('#' + parentId + ' #cart_block_product_' + domIdProduct).find('a.ajax_cart_block_remove_link');
            if (!product.hasCustomizedDatas && !removeLinks.length)
                $('#' + parentId + ' #' + domIdProduct + ' span.remove_link').html('<a class="ajax_cart_block_remove_link" rel="nofollow" href="' + baseDir + 'cart.php?delete&amp;id_product=' + product['id'] + '&amp;ipa=' + product['idCombination'] + '&amp;token=' + static_token + '" title="' + removingLinkText + '"> </a>');
        });
    },

    doesCustomizationStillExist: function(product, customizationId) {
        var exists = false;

        $(product.customizedDatas).each(function() {
            if (this.customizationId == customizationId) {
                exists = true;
                // This return does not mean that we found nothing but simply break the loop
                return false;
            }
        });
        return (exists);
    },

    //refresh display of vouchers (needed for vouchers in % of the total)
    refreshVouchers: function(jsonData) {
        if (jsonData.discounts.length == 0)
            $('#vouchers').remove();
        else {
            $('.bloc_cart_voucher').each(function() {
                var idElmt = $(this).attr('id').replace('bloc_cart_voucher_', '');
                var toDelete = true;
                for (i = 0; i < jsonData.discounts.length; i++) {
                    if (jsonData.discounts[i].id == idElmt) {
                        $('#bloc_cart_voucher_' + idElmt + ' td.price').text(jsonData.discounts[i].price);
                        toDelete = false;
                    }
                }
                if (toDelete) {
                    $('#bloc_cart_voucher_' + idElmt).fadeTo('fast', 0, function() {
                        $(this).remove();
                    });
                }
            });
        }


    },

    // Update product quantity
    updateProductQuantity: function(product, quantity) {
        $(['left_column', 'right_column', 'header']).each(function(id, parentId) {
            $('#' + parentId + ' dt#cart_block_product_' + product.id + (product.idCombination ? '_' + product.idCombination : '') + ' .quantity').fadeTo('fast', 0, function() {
                $(this).text(quantity);
                $(this).fadeTo('fast', 1, function() {
                    $(this).fadeTo('fast', 0, function() {
                        $(this).fadeTo('fast', 1, function() {
                            $(this).fadeTo('fast', 0, function() {
                                $(this).fadeTo('fast', 1);
                            });
                        });
                    });
                });
            });
        });
    },


    //display the products witch are in json data but not already displayed
    displayNewProducts: function(jsonData) {
        $(['left_column', 'right_column', 'header']).each(function(id, parentId) {
            //add every new products or update displaying of every updated products
            $(jsonData.products).each(function() {
                //fix ie6 bug (one more item 'undefined' in IE6)
                if (this.id != undefined) {
                    //create a container for listing the products and hide the 'no product in the cart' message (only if the cart was empty)
                    if ($('#' + parentId + ' div#cart_block dl.products').length == 0)
                        $('#' + parentId + ' p#cart_block_no_products').fadeTo('fast', 0, function() {
                            $(this).slideUp('fast').fadeTo(0, 1);
                        }).before('<dl class="products"></dl>');

                    //if product is not in the displayed cart, add a new product's line
                    var domIdProduct = this.id + (this.idCombination ? '_' + this.idCombination : '');
                    var domIdProductAttribute = this.id + '_' + (this.idCombination ? this.idCombination : '0');
                    if ($('#' + parentId + ' #cart_block dt#cart_block_product_' + domIdProduct).length == 0) {
                        var productId = parseInt(this.id);
                        var productAttributeId = (this.hasAttributes ? parseInt(this.attributes) : 0);
                        var content = '<dt class="hidden" id="cart_block_product_' + domIdProduct + '">';
                        var name = (this.name.length > 12 ? this.name.substring(0, 25) + '...' : this.name);
                        content += '<a href="' + this.link + '" title="' + this.name + '">' + name + '</a>';
                        content += '<span class="quantity-formated"><span class="quantity">' + this.quantity + '</span></span>';
                        content += '<span class="remove_link"><a rel="nofollow" class="ajax_cart_block_remove_link" href="' + baseDir + 'cart.php?delete&amp;id_product=' + productId + '&amp;token=' + static_token + (this.hasAttributes ? '&amp;ipa=' + parseInt(this.idCombination) : '') + '"> </a></span>';
                        content += '<span class="price">' + this.priceByLine + '</span>';
                        content += '</dt>';
                        if (this.hasAttributes)
                            content += '<dd id="cart_block_combination_of_' + domIdProduct + '" class="hidden"><a href="' + this.link + '" title="' + this.name + '">' + this.attributes.substring(0, 20) + '</a>';
                        if (this.hasCustomizedDatas)
                            content += ajaxCart.displayNewCustomizedDatas(this);
                        if (this.hasAttributes) content += '</dd>';
                        $('#' + parentId + ' #cart_block dl.products').append(content);
                    }
                    //else update the product's line
                    else {
                        var jsonProduct = this;
                        if ($('#' + parentId + ' dt#cart_block_product_' + domIdProduct + ' .quantity').text() != jsonProduct.quantity || $('dt#cart_block_product_' + domIdProduct + ' .price').text() != jsonProduct.priceByLine) {
                            // Usual product
                            $('#' + parentId + ' dt#cart_block_product_' + domIdProduct + ' .price').text(jsonProduct.priceByLine);
                            ajaxCart.updateProductQuantity(jsonProduct, jsonProduct.quantity);

                            // Customized product
                            if (jsonProduct.hasCustomizedDatas) {
                                customizationFormatedDatas = ajaxCart.displayNewCustomizedDatas(jsonProduct);
                                if (!$('#' + parentId + ' #cart_block ul#customization_' + domIdProductAttribute).length) {
                                    if (jsonProduct.hasAttributes)
                                        $('#' + parentId + ' #cart_block dd#cart_block_combination_of_' + domIdProduct).append(customizationFormatedDatas);
                                    else
                                        $('#' + parentId + ' #cart_block dl.products').append(customizationFormatedDatas);
                                } else
                                    $('#' + parentId + ' #cart_block ul#customization_' + domIdProductAttribute).append(customizationFormatedDatas);
                            }
                        }
                    }
                    $('#' + parentId + ' #cart_block dl.products .hidden').slideDown('slow').removeClass('hidden');

                    var removeLinks = $('#' + parentId + ' #cart_block_product_' + domIdProduct).find('a.ajax_cart_block_remove_link');
                    if (this.hasCustomizedDatas && removeLinks.length)
                        $(removeLinks).each(function() {
                            $(this).remove();
                        });
                }
            });
        });
    },

    displayNewCustomizedDatas: function(product) {
        var content = '';
        $('#cart_block').each(function(id, parentId) {
            var productId = parseInt(product.id);
            var productAttributeId = typeof(product.idCombination) == 'undefined' ? 0 : parseInt(product.idCombination);
            var hasAlreadyCustomizations = $(this).children('ul#customization_' + productId + '_' + productAttributeId).length;

            if (!hasAlreadyCustomizations) {
                if (!product.hasAttributes)
                    content += '<dd id="cart_block_combination_of_' + productId + '" class="hidden">';
                if ($('#customization_' + productId + '_' + productAttributeId).val() == undefined)
                    content += '<ul class="cart_block_customizations" id="customization_' + productId + '_' + productAttributeId + '">';
            }

            $(product.customizedDatas).each(function() {
                var done = 0;
                customizationId = parseInt(this.customizationId);
                productAttributeId = typeof(product.idCombination) == 'undefined' ? 0 : parseInt(product.idCombination);
                // If the customization is already displayed on the cart, no update's needed
                if ($("#deleteCustomizableProduct_" + customizationId + "_" + productId + "_" + productAttributeId).length)
                    return ('');
                content += '<li name="customization"><div class="deleteCustomizableProduct" id="deleteCustomizableProduct_' + customizationId + '_' + productId + '_' + (productAttributeId ? productAttributeId : '0') + '"><a  rel="nofollow" class="ajax_cart_block_remove_link" href="' + baseDir + 'cart.php?delete&amp;id_product=' + productId + '&amp;ipa=' + productAttributeId + '&amp;id_customization=' + customizationId + '&amp;token=' + static_token + '"> </a></div><span class="quantity-formated"><span class="quantity">' + parseInt(this.quantity) + '</span>x</span>';

                // Give to the customized product the first textfield value as name
                $(this.datas).each(function() {
                    if (this['type'] == CUSTOMIZE_TEXTFIELD) {
                        $(this.datas).each(function() {
                            if (this['index'] == 0) {
                                content += this.truncatedValue.replace(/<br \/>/g, ' ');
                                done = 1;
                                return false;
                            }
                        })
                    }
                });

                // If the customized product did not have any textfield, it will have the customizationId as name
                if (!done)
                    content += customizationIdMessage + customizationId;
                if (!hasAlreadyCustomizations) content += '</li>';
                // Field cleaning
                if (customizationId) {
                    $(this).children('#uploadable_files li div.customizationUploadBrowse img').remove();
                    $(this).children('#text_fields li input').attr('value', '');
                }
            });

            if (!hasAlreadyCustomizations) {
                content += '</ul>';
                if (!product.hasAttributes) content += '</dd>';
            }
        });
        return content;
    },


    //genarally update the display of the cart
    updateCart: function(jsonData) {
        //user errors display
        if (jsonData.hasError) {
            var errors = '';
            for (error in jsonData.errors)
            //IE6 bug fix
                if (error != 'indexOf')
                    errors += jsonData.errors[error] + "\n";
            alert(errors);
        } else {
            ajaxCart.updateCartEverywhere(jsonData);
            ajaxCart.hideOldProducts(jsonData);
            ajaxCart.displayNewProducts(jsonData);
            ajaxCart.refreshVouchers(jsonData);

            //update 'first' and 'last' item classes
            $(['left_column', 'right_column', 'header']).each(function(id, parentId) {
                $('#' + parentId + ' #cart_block dl.products dt').removeClass('first_item').removeClass('last_item').removeClass('item');
                $('#' + parentId + ' #cart_block dl.products dt:first').addClass('first_item');
                $('#' + parentId + ' #cart_block dl.products dt:not(:first,:last)').addClass('item');
                $('#' + parentId + ' #cart_block dl.products dt:last').addClass('last_item');
            });

            //reset the onlick events in relation to the cart block (it allow to bind the onclick event to the new 'delete' buttons added)
            ajaxCart.overrideButtonsInThePage();
        }
    },

    //update general cart informations everywhere in the page
    updateCartEverywhere: function(jsonData) {

        $('.ajax_cart_shipping_cost').text(jsonData.shippingCost);
        $('.ajax_cart_tax_cost').text(jsonData.taxCost);
        $('.cart_block_wrapping_cost').text(jsonData.wrappingCost);
        $('.ajax_block_cart_total').text(jsonData.total);
        if (parseInt(jsonData.nbTotalProducts) > 0) {
            //$('.ajax_cart_total').text(jsonData.productTotal);
            $('.ajax_cart_total').text(jsonData.total);
            $('.ajax_cart_no_product').hide();
            $('.ajax_cart_quantity').text(jsonData.nbTotalProducts);
            $('.ajax_cart_quantity').fadeIn('slow');
            //$('.ajax_cart_total').fadeIn('slow');

            if (parseInt(jsonData.nbTotalProducts) > 1) {
                $('.ajax_cart_product_txt').each(function() {
                    $(this).hide();
                });

                $('.ajax_cart_product_txt_s').each(function() {
                    $(this).show();
                });

            } else {
                $('.ajax_cart_product_txt').each(function() {
                    $(this).show();
                });

                $('.ajax_cart_product_txt_s').each(function() {
                    $(this).hide();
                });
            }
        } else {
            $('.ajax_cart_total').text("SHOPPING CART");
            $('.ajax_cart_product_txt_s, .ajax_cart_product_txt').each(function() {
                $(this).hide();
            });
            $('.ajax_cart_no_product').show('slow');
            $('.ajax_cart_quantity').text('0 ITEM');
        }
    }
};

//when document is loaded...
$(document).ready(function() {

    ajaxCart.collapse();

    // expand/collapse management
    $('#block_cart_collapse').click(function() {
        ajaxCart.collapse();
    });
    $('#block_cart_expand').click(function() {
        ajaxCart.expand();
    });
    ajaxCart.overrideButtonsInThePage();
    ajaxCart.refresh();
});


function checkMinimalQuantityList(id_product, minimal_quantity) {
    var name_qc = '#'.concat(id_product, "_quantity_wanted");

    if ($(name_qc).val() < minimal_quantity) {
        $(name_qc).css('border', '1px solid red');
    } else {
        $(name_qc).css('border', '1px solid #000000');
    }
}

function checkMinimalQuantityListQV(id_product, minimal_quantity) {
    var name_qc1 = '#'.concat(id_product, "_qv_quantity_wanted");

    if ($(name_qc1).val() < minimal_quantity) {
        $(name_qc1).css('border', '1px solid red');
    } else {
        $(name_qc1).css('border', '1px solid #000000');
    }
}

function checkMinimalQuantityListLV(id_product, minimal_quantity) {
    var name_qc2 = '#'.concat(id_product, "_lv_quantity_wanted");

    if ($(name_qc2).val() < minimal_quantity)

    {
        $(name_qc2).css('border', '1px solid red');
    } else {
        $(name_qc2).css('border', '1px solid #000000');
    }
}

// pm_advancedtopmenu module
function activateParentMenu(e, type) {
    //alert(type);
    if (type == 'element') {
        $(e).parents('.adtm_column').children('h5').children('a').addClass('advtm_menu_actif');
        $(e).parents('.li-niveau1').children('a').addClass('advtm_menu_actif');

    }
    if (type == 'column') {
        $(e).parents('.li-niveau1').children('a').addClass('advtm_menu_actif');
    }

}

/*/kobstereshop/modules/blockwishlist/js/ajax-wishlist.js
 * 2007-2012 PrestaShop
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
 *  @copyright  2007-2012 PrestaShop SA
 *  @version  Release: $Revision: 14011 $
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

/**
 * Update WishList Cart by adding, deleting, updating objects
 *
 * @return void
 */
function WishlistCart(id, action, id_product, id_product_attribute, quantity) {
    $.ajax({
        type: 'GET',
        url: baseDir + 'modules/blockwishlist/cart.php',
        async: true,
        cache: false,
        data: 'action=' + action + '&id_product=' + id_product + '&quantity=' + quantity + '&token=' + static_token + '&id_product_attribute=' + id_product_attribute,
        success: function(data) {
            if (action == 'add') {
                var $element = $('#bigpic');
                if (!$element.length)
                    var $element = $('#wishlist_button');
                var $picture = $element.clone();
                var pictureOffsetOriginal = $element.offset();
                $picture.css({
                    'position': 'absolute',
                    'top': pictureOffsetOriginal.top,
                    'left': pictureOffsetOriginal.left
                });
                var pictureOffset = $picture.offset();
                var wishlistBlockOffset = $('#wishlist_block').offset();

                $picture.appendTo('body');
                $picture.css({
                        'position': 'absolute',
                        'top': $picture.css('top'),
                        'left': $picture.css('left')
                    })
                    .animate({
                        'width': $element.attr('width') * 0.66,
                        'height': $element.attr('height') * 0.66,
                        'opacity': 0.2,
                        'top': wishlistBlockOffset.top + 30,
                        'left': wishlistBlockOffset.left + 15
                    }, 1000)
                    .fadeOut(800);
            }

            if ($('#' + id).length != 0) {
                $('#' + id).slideUp('normal');
                document.getElementById(id).innerHTML = data;
                $('#' + id).slideDown('normal');
            }
        }
    });
}

/**
 * Change customer default wishlist
 *
 * @return void
 */
function WishlistChangeDefault(id, id_wishlist) {
    $.ajax({
        type: 'GET',
        url: baseDir + 'modules/blockwishlist/cart.php',
        async: true,
        data: 'id_wishlist=' + id_wishlist + '&token=' + static_token,
        cache: false,
        success: function(data) {
            $('#' + id).slideUp('normal');
            document.getElementById(id).innerHTML = data;
            $('#' + id).slideDown('normal');
        }
    });
}

/**
 * Buy Product
 *
 * @return void
 */
function WishlistBuyProduct(token, id_product, id_product_attribute, id_quantity, button, ajax) {
    if (ajax)
        ajaxCart.add(id_product, id_product_attribute, false, button, 1, [token, id_quantity]);
    else {
        $('#' + id_quantity).val(0);
        WishlistAddProductCart(token, id_product, id_product_attribute, id_quantity)
        document.forms['addtocart' + '_' + id_product + '_' + id_product_attribute].method = 'POST';
        document.forms['addtocart' + '_' + id_product + '_' + id_product_attribute].action = baseDir + 'cart.php';
        document.forms['addtocart' + '_' + id_product + '_' + id_product_attribute].elements['token'].value = static_token;
        document.forms['addtocart' + '_' + id_product + '_' + id_product_attribute].submit();
    }
    return (true);
}

function WishlistAddProductCart(token, id_product, id_product_attribute, id_quantity) {
    if ($('#' + id_quantity).val() <= 0)
        return (false);
    $.ajax({
        type: 'GET',
        url: baseDir + 'modules/blockwishlist/buywishlistproduct.php',
        data: 'token=' + token + '&static_token=' + static_token + '&id_product=' + id_product + '&id_product_attribute=' + id_product_attribute,
        async: true,
        cache: false,
        success: function(data) {
            if (data)
                alert(data);
            else {
                $('#' + id_quantity).val($('#' + id_quantity).val() - 1);
            }
        }
    });
    return (true);
}

/**
 * Show wishlist managment page
 *
 * @return void
 */

function WishlistManage(id, id_wishlist) {
    var tot_qty = parseInt($('#total_products_all').val());
    var tot_price = parseInt($('#total_price_all').val());


    $.ajax({
        type: 'GET',
        async: true,
        url: baseDir + 'modules/blockwishlist/managewishlist.php',
        data: 'id_wishlist=' + id_wishlist + '&refresh=' + false,
        cache: false,
        beforeSend: function() {
            $('#block-order-detail').html("<div class='loading_products' ><img src='../../../img/loader.gif' id='loading_image' /></div>");
        },
        success: function(data) {
            $('#' + id).hide();
            document.getElementById(id).innerHTML = data;
            $('#' + id).fadeIn('slow');

            $(".qv_quantity_wanted").each(function(i, obj) {
                var elem = $(obj);
                elem.change();
                elem.attr('tabindex', i + 1);
                if (i == 0) {
                    elem.focus();
                }
            });

            $(".quickViewButton").click(function() {
                var id = $(this).attr('href');
                centerPopup(id);
                loadPopup(id);
            });

            //Close popup by clicking the x
            $(".quickViewClose").click(function() {
                var id = $(this).attr('href');
                disablePopup(id);
            });

            //Close popup by clicking outside the box
            $(".backgroundQuickView").click(function() {
                disablePopup(0);
            });

            //Close popup by clicking escape
            $(document).keypress(function(e) {
                if (e.keyCode == 27 && popupStatus == 1) {
                    disablePopup('#cart_block');
                    disablePopup(0);
                }
            });

            $('#total_qty_sans').html(tot_qty - parseInt($('#total_products').val()));
            $('#total_price_sans').html(tot_price - parseInt($('#total_price').val()));

            $('#total_products_all').html(parseInt($('#total_qty_sans').html()) + parseInt($('#total_products').html()));
            $('#total_price_all').html(parseInt($('#total_price_sans').html()) + parseInt($('#total_price').html()));

        },
        complete: function() {
            $('.loading_products').hide();
        }
    });
}

function removeAllProducts() {
    $.ajax({
        type: 'GET',
        async: true,
        dataType: 'json',
        url: baseDir + 'modules/blockwishlist/getProductsPurchaseList.php',
        cache: false,
        success: function(jsonData) {
            //alert(jsonData.length);
            for (var i = 0; i < jsonData.length; i++) {
                ajaxCart.remove(jsonData[i].id_product, null, null);
            }
            //window.location = "/kobstereshop/order.php";
        }
    });
}

function WishlistRefreshManage(id, id_wishlist) {
    if (confirm('This will delete your existing list. Do you want to continue?')) {
        $.ajax({
            type: 'GET',
            async: true,
            url: baseDir + 'modules/blockwishlist/refreshProductQuantityPurchaseList.php',
            data: 'id_wishlist=' + id_wishlist,
            cache: false,
            success: function(data) {
                WishlistManage(id, id_wishlist);
                location.reload();
            }
        });
    }
}

/**
 * Show wishlist product managment page
 *
 * @return void
 */
function WishlistProductManage(id, action, id_wishlist, id_product, id_product_attribute, quantity, priority) {
    $.ajax({
        type: 'GET',
        async: true,
        url: baseDir + 'modules/blockwishlist/managewishlist.php',
        data: 'action=' + action + '&id_wishlist=' + id_wishlist + '&id_product=' + id_product + '&id_product_attribute=' + id_product_attribute + '&quantity=' + quantity + '&priority=' + priority + '&refresh=' + true,
        cache: false,
        success: function(data) {
            if (action == 'delete')
                $('#wlp_' + id_product + '_' + id_product_attribute).fadeOut('fast');
            else if (action == 'update') {
                $('#wlp_' + id_product + '_' + id_product_attribute).fadeOut('fast');
                $('#wlp_' + id_product + '_' + id_product_attribute).fadeIn('fast');
            }
        }
    });
}

/**
 * Delete wishlist
 *
 * @return boolean succeed
 */
function WishlistDelete(id, id_wishlist, msg) {
    var res = confirm(msg);
    if (res == false)
        return (false);
    $.ajax({
        type: 'GET',
        async: true,
        url: baseDir + 'modules/blockwishlist/mywishlist.php',
        cache: false,
        data: 'deleted&id_wishlist=' + id_wishlist,
        success: function(data) {
            $('#' + id).fadeOut('slow');
        }
    });
}

/**
 * Hide/Show bought product
 *
 * @return void
 */
function WishlistVisibility(bought_class, id_button) {
    if ($('#hide' + id_button).css('display') == 'none') {
        $('.' + bought_class).slideDown('fast');
        $('#show' + id_button).hide();
        $('#hide' + id_button).fadeIn('fast');
    } else {
        $('.' + bought_class).slideUp('fast');
        $('#hide' + id_button).hide();
        $('#show' + id_button).fadeIn('fast');
    }
}

/**
 * Send wishlist by email
 *
 * @return void
 */
function WishlistSend(id, id_wishlist, id_email) {
    $.post(baseDir + 'modules/blockwishlist/sendwishlist.php', {
            token: static_token,
            id_wishlist: id_wishlist,
            email1: $('#' + id_email + '1').val(),
            email2: $('#' + id_email + '2').val(),
            email3: $('#' + id_email + '3').val(),
            email4: $('#' + id_email + '4').val(),
            email5: $('#' + id_email + '5').val(),
            email6: $('#' + id_email + '6').val(),
            email7: $('#' + id_email + '7').val(),
            email8: $('#' + id_email + '8').val(),
            email9: $('#' + id_email + '9').val(),
            email10: $('#' + id_email + '10').val()
        },
        function(data) {
            if (data)
                alert(data);
            else
                WishlistVisibility(id, 'hideSendWishlist');
        });
}

// /kobstereshop/modules/blockwishlist/js/purchaseList.js
/*whenever the update happen in the purchase list the function comes here nad excuite*/
function updateTotalPrice(id_product, price, quantity, totalProducts, id_wishlist, id_product_attribute) {
    finalPrice = Number((quantity.value * price).toFixed(2));
    ele_name = "#" + id_product + "_final_price";
    if (isNaN(finalPrice)) {
        $(ele_name).html("Invalid!");
    } else {
        $(ele_name).html(finalPrice);
        var dataparam = 'id_wishlist=' + id_wishlist + '&id_product=' + id_product + '&id_product_attribute=' + id_product_attribute + '&quantity=' + quantity.value + '&totalprice=' + finalPrice;
        $.ajax({
            type: 'GET',
            async: true,
            dataType: "json",
            url: baseDir + 'modules/blockwishlist/updateProductQuantityPurchaseList.php',
            data: dataparam,
            cache: false,
            success: function(data) {
                $('#total_products_all').val(data[0].totalqty);
                $('#total_price_all').val(data[0].totalprice);
                $('#total_products').val(data[0].cur_qty);
                $('#total_price').val(data[0].cur_price);
            }
        });
    }
}

function fun_position_up() {
    $(".qv_quantity_wanted").focus(function(e) {
        var relativeY = e.pageY - this.offsetTop;
        if (relativeY < -650) {
            window.scroll(0, this.offsetTop - 300);

        }
    });
}

/* /kobstereshop/modules/tmnivoslider/js/nivo.slider.js
 * jQuery Nivo Slider v2.7.1
 * http://nivo.dev7studios.com
 *
 * Copyright 2011, Gilbert Pellegrom
 * Free to use and abuse under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * March 2010
 */

(function($) {

    var NivoSlider = function(element, options) {
        //Defaults are below
        var settings = $.extend({}, $.fn.nivoSlider.defaults, options);

        //Useful variables. Play carefully.
        var vars = {
            currentSlide: 0,
            currentImage: '',
            totalSlides: 0,
            running: false,
            paused: false,
            stop: false
        };

        //Get this slider
        var slider = $(element);
        slider.data('nivo:vars', vars);
        slider.css('position', 'relative');
        slider.addClass('nivoSlider');

        //Find our slider children
        var kids = slider.children();
        kids.each(function() {
            var child = $(this);
            var link = '';
            if (!child.is('img')) {
                if (child.is('a')) {
                    child.addClass('nivo-imageLink');
                    link = child;
                }
                child = child.find('img:first');
            }
            //Get img width & height
            var childWidth = child.width();
            if (childWidth == 0) childWidth = child.attr('width');
            var childHeight = child.height();
            if (childHeight == 0) childHeight = child.attr('height');
            //Resize the slider
            if (childWidth > slider.width()) {
                slider.width(childWidth);
            }
            if (childHeight > slider.height()) {
                slider.height(childHeight);
            }
            if (link != '') {
                link.css('display', 'none');
            }
            child.css('display', 'none');
            vars.totalSlides++;
        });

        //If randomStart
        if (settings.randomStart) {
            settings.startSlide = Math.floor(Math.random() * vars.totalSlides);
        }

        //Set startSlide
        if (settings.startSlide > 0) {
            if (settings.startSlide >= vars.totalSlides) settings.startSlide = vars.totalSlides - 1;
            vars.currentSlide = settings.startSlide;
        }

        //Get initial image
        if ($(kids[vars.currentSlide]).is('img')) {
            vars.currentImage = $(kids[vars.currentSlide]);
        } else {
            vars.currentImage = $(kids[vars.currentSlide]).find('img:first');
        }

        //Show initial link
        if ($(kids[vars.currentSlide]).is('a')) {
            $(kids[vars.currentSlide]).css('display', 'block');
        }

        //Set first background
        slider.css('background', 'url("' + vars.currentImage.attr('src') + '") no-repeat');

        //Create caption
        slider.append(
            $('<div class="nivo-caption"><p></p></div>').css({
                display: 'none',
                opacity: settings.captionOpacity
            })
        );

        // Cross browser default caption opacity
        $('.nivo-caption', slider).css('opacity', 0);

        // Process caption function
        var processCaption = function(settings) {
            var nivoCaption = $('.nivo-caption', slider);
            if (vars.currentImage.attr('title') != '' && vars.currentImage.attr('title') != undefined) {
                var title = vars.currentImage.attr('title');
                if (title.substr(0, 1) == '#') title = $(title).html();

                if (nivoCaption.css('opacity') != 0) {
                    nivoCaption.find('p').stop().fadeTo(settings.animSpeed, 0, function() {
                        $(this).html(title);
                        $(this).stop().fadeTo(settings.animSpeed, 1);
                    });
                } else {
                    nivoCaption.find('p').html(title);
                }
                nivoCaption.stop().fadeTo(settings.animSpeed, settings.captionOpacity);
            } else {
                nivoCaption.stop().fadeTo(settings.animSpeed, 0);
            }
        }

        //Process initial  caption
        processCaption(settings);

        //In the words of Super Mario "let's a go!"
        var timer = 0;
        if (!settings.manualAdvance && kids.length > 1) {
            timer = setInterval(function() {
                nivoRun(slider, kids, settings, false);
            }, settings.pauseTime);
        }

        //Add Direction nav
        if (settings.directionNav) {
            slider.append('<div class="nivo-directionNav"><a class="nivo-prevNav">' + settings.prevText + '</a><a class="nivo-nextNav">' + settings.nextText + '</a></div>');

            //Hide Direction nav
            if (settings.directionNavHide) {
                $('.nivo-directionNav', slider).hide();
                slider.hover(function() {
                    $('.nivo-directionNav', slider).show();
                }, function() {
                    $('.nivo-directionNav', slider).hide();
                });
            }

            $('a.nivo-prevNav', slider).live('click', function() {
                if (vars.running) return false;
                clearInterval(timer);
                timer = '';
                vars.currentSlide -= 2;
                nivoRun(slider, kids, settings, 'prev');
            });

            $('a.nivo-nextNav', slider).live('click', function() {
                if (vars.running) return false;
                clearInterval(timer);
                timer = '';
                nivoRun(slider, kids, settings, 'next');
            });
        }

        //Add Control nav
        if (settings.controlNav) {
            var nivoControl = $('<div class="nivo-controlNav"></div>');
            slider.append(nivoControl);
            for (var i = 0; i < kids.length; i++) {
                if (settings.controlNavThumbs) {
                    var child = kids.eq(i);
                    if (!child.is('img')) {
                        child = child.find('img:first');
                    }
                    if (settings.controlNavThumbsFromRel) {
                        nivoControl.append('<a class="nivo-control" rel="' + i + '"><img src="' + child.attr('rel') + '" alt="" /></a>');
                    } else {
                        nivoControl.append('<a class="nivo-control" rel="' + i + '"><img src="' + child.attr('src').replace(settings.controlNavThumbsSearch, settings.controlNavThumbsReplace) + '" alt="" /></a>');
                    }
                } else {
                    nivoControl.append('<a class="nivo-control" rel="' + i + '">' + (i + 1) + '</a>');
                }

            }
            //Set initial active link
            $('.nivo-controlNav a:eq(' + vars.currentSlide + ')', slider).addClass('active');

            $('.nivo-controlNav a', slider).live('click', function() {
                if (vars.running) return false;
                if ($(this).hasClass('active')) return false;
                clearInterval(timer);
                timer = '';
                slider.css('background', 'url("' + vars.currentImage.attr('src') + '") no-repeat');
                vars.currentSlide = $(this).attr('rel') - 1;
                nivoRun(slider, kids, settings, 'control');
            });
        }

        //Keyboard Navigation
        if (settings.keyboardNav) {
            $(window).keypress(function(event) {
                //Left
                if (event.keyCode == '37') {
                    if (vars.running) return false;
                    clearInterval(timer);
                    timer = '';
                    vars.currentSlide -= 2;
                    nivoRun(slider, kids, settings, 'prev');
                }
                //Right
                if (event.keyCode == '39') {
                    if (vars.running) return false;
                    clearInterval(timer);
                    timer = '';
                    nivoRun(slider, kids, settings, 'next');
                }
            });
        }

        //For pauseOnHover setting
        if (settings.pauseOnHover) {
            slider.hover(function() {
                vars.paused = true;
                clearInterval(timer);
                timer = '';
            }, function() {
                vars.paused = false;
                //Restart the timer
                if (timer == '' && !settings.manualAdvance) {
                    timer = setInterval(function() {
                        nivoRun(slider, kids, settings, false);
                    }, settings.pauseTime);
                }
            });
        }

        //Event when Animation finishes
        slider.bind('nivo:animFinished', function() {
            vars.running = false;
            //Hide child links
            $(kids).each(function() {
                if ($(this).is('a')) {
                    $(this).css('display', 'none');
                }
            });
            //Show current link
            if ($(kids[vars.currentSlide]).is('a')) {
                $(kids[vars.currentSlide]).css('display', 'block');
            }
            //Restart the timer
            if (timer == '' && !vars.paused && !settings.manualAdvance) {
                timer = setInterval(function() {
                    nivoRun(slider, kids, settings, false);
                }, settings.pauseTime);
            }
            //Trigger the afterChange callback
            settings.afterChange.call(this);
        });

        // Add slices for slice animations
        var createSlices = function(slider, settings, vars) {
            for (var i = 0; i < settings.slices; i++) {
                var sliceWidth = Math.round(slider.width() / settings.slices);
                if (i == settings.slices - 1) {
                    slider.append(
                        $('<div class="nivo-slice"></div>').css({
                            left: (sliceWidth * i) + 'px',
                            width: (slider.width() - (sliceWidth * i)) + 'px',
                            height: '0px',
                            opacity: '0',
                            background: 'url("' + vars.currentImage.attr('src') + '") no-repeat -' + ((sliceWidth + (i * sliceWidth)) - sliceWidth) + 'px 0%'
                        })
                    );
                } else {
                    slider.append(
                        $('<div class="nivo-slice"></div>').css({
                            left: (sliceWidth * i) + 'px',
                            width: sliceWidth + 'px',
                            height: '0px',
                            opacity: '0',
                            background: 'url("' + vars.currentImage.attr('src') + '") no-repeat -' + ((sliceWidth + (i * sliceWidth)) - sliceWidth) + 'px 0%'
                        })
                    );
                }
            }
        }

        // Add boxes for box animations
        var createBoxes = function(slider, settings, vars) {
            var boxWidth = Math.round(slider.width() / settings.boxCols);
            var boxHeight = Math.round(slider.height() / settings.boxRows);

            for (var rows = 0; rows < settings.boxRows; rows++) {
                for (var cols = 0; cols < settings.boxCols; cols++) {
                    if (cols == settings.boxCols - 1) {
                        slider.append(
                            $('<div class="nivo-box"></div>').css({
                                opacity: 0,
                                left: (boxWidth * cols) + 'px',
                                top: (boxHeight * rows) + 'px',
                                width: (slider.width() - (boxWidth * cols)) + 'px',
                                height: boxHeight + 'px',
                                background: 'url("' + vars.currentImage.attr('src') + '") no-repeat -' + ((boxWidth + (cols * boxWidth)) - boxWidth) + 'px -' + ((boxHeight + (rows * boxHeight)) - boxHeight) + 'px'
                            })
                        );
                    } else {
                        slider.append(
                            $('<div class="nivo-box"></div>').css({
                                opacity: 0,
                                left: (boxWidth * cols) + 'px',
                                top: (boxHeight * rows) + 'px',
                                width: boxWidth + 'px',
                                height: boxHeight + 'px',
                                background: 'url("' + vars.currentImage.attr('src') + '") no-repeat -' + ((boxWidth + (cols * boxWidth)) - boxWidth) + 'px -' + ((boxHeight + (rows * boxHeight)) - boxHeight) + 'px'
                            })
                        );
                    }
                }
            }
        }

        // Private run method
        var nivoRun = function(slider, kids, settings, nudge) {
            //Get our vars
            var vars = slider.data('nivo:vars');

            //Trigger the lastSlide callback
            if (vars && (vars.currentSlide == vars.totalSlides - 1)) {
                settings.lastSlide.call(this);
            }

            // Stop
            if ((!vars || vars.stop) && !nudge) return false;

            //Trigger the beforeChange callback
            settings.beforeChange.call(this);

            //Set current background before change
            if (!nudge) {
                slider.css('background', 'url("' + vars.currentImage.attr('src') + '") no-repeat');
            } else {
                if (nudge == 'prev') {
                    slider.css('background', 'url("' + vars.currentImage.attr('src') + '") no-repeat');
                }
                if (nudge == 'next') {
                    slider.css('background', 'url("' + vars.currentImage.attr('src') + '") no-repeat');
                }
            }
            vars.currentSlide++;
            //Trigger the slideshowEnd callback
            if (vars.currentSlide == vars.totalSlides) {
                vars.currentSlide = 0;
                settings.slideshowEnd.call(this);
            }
            if (vars.currentSlide < 0) vars.currentSlide = (vars.totalSlides - 1);
            //Set vars.currentImage
            if ($(kids[vars.currentSlide]).is('img')) {
                vars.currentImage = $(kids[vars.currentSlide]);
            } else {
                vars.currentImage = $(kids[vars.currentSlide]).find('img:first');
            }

            //Set active links
            if (settings.controlNav) {
                $('.nivo-controlNav a', slider).removeClass('active');
                $('.nivo-controlNav a:eq(' + vars.currentSlide + ')', slider).addClass('active');
            }

            //Process caption
            processCaption(settings);

            // Remove any slices from last transition
            $('.nivo-slice', slider).remove();

            // Remove any boxes from last transition
            $('.nivo-box', slider).remove();

            var currentEffect = settings.effect;
            //Generate random effect
            if (settings.effect == 'random') {
                var anims = new Array('sliceDownRight', 'sliceDownLeft', 'sliceUpRight', 'sliceUpLeft', 'sliceUpDown', 'sliceUpDownLeft', 'fold', 'fade',
                    'boxRandom', 'boxRain', 'boxRainReverse', 'boxRainGrow', 'boxRainGrowReverse');
                currentEffect = anims[Math.floor(Math.random() * (anims.length + 1))];
                if (currentEffect == undefined) currentEffect = 'fade';
            }

            //Run random effect from specified set (eg: effect:'fold,fade')
            if (settings.effect.indexOf(',') != -1) {
                var anims = settings.effect.split(',');
                currentEffect = anims[Math.floor(Math.random() * (anims.length))];
                if (currentEffect == undefined) currentEffect = 'fade';
            }

            //Custom transition as defined by "data-transition" attribute
            if (vars.currentImage.attr('data-transition')) {
                currentEffect = vars.currentImage.attr('data-transition');
            }

            //Run effects
            vars.running = true;
            if (currentEffect == 'sliceDown' || currentEffect == 'sliceDownRight' || currentEffect == 'sliceDownLeft') {
                createSlices(slider, settings, vars);
                var timeBuff = 0;
                var i = 0;
                var slices = $('.nivo-slice', slider);
                if (currentEffect == 'sliceDownLeft') slices = $('.nivo-slice', slider)._reverse();

                slices.each(function() {
                    var slice = $(this);
                    slice.css({
                        'top': '0px'
                    });
                    if (i == settings.slices - 1) {
                        setTimeout(function() {
                            slice.animate({
                                height: '100%',
                                opacity: '1.0'
                            }, settings.animSpeed, '', function() {
                                slider.trigger('nivo:animFinished');
                            });
                        }, (100 + timeBuff));
                    } else {
                        setTimeout(function() {
                            slice.animate({
                                height: '100%',
                                opacity: '1.0'
                            }, settings.animSpeed);
                        }, (100 + timeBuff));
                    }
                    timeBuff += 50;
                    i++;
                });
            } else if (currentEffect == 'sliceUp' || currentEffect == 'sliceUpRight' || currentEffect == 'sliceUpLeft') {
                createSlices(slider, settings, vars);
                var timeBuff = 0;
                var i = 0;
                var slices = $('.nivo-slice', slider);
                if (currentEffect == 'sliceUpLeft') slices = $('.nivo-slice', slider)._reverse();

                slices.each(function() {
                    var slice = $(this);
                    slice.css({
                        'bottom': '0px'
                    });
                    if (i == settings.slices - 1) {
                        setTimeout(function() {
                            slice.animate({
                                height: '100%',
                                opacity: '1.0'
                            }, settings.animSpeed, '', function() {
                                slider.trigger('nivo:animFinished');
                            });
                        }, (100 + timeBuff));
                    } else {
                        setTimeout(function() {
                            slice.animate({
                                height: '100%',
                                opacity: '1.0'
                            }, settings.animSpeed);
                        }, (100 + timeBuff));
                    }
                    timeBuff += 50;
                    i++;
                });
            } else if (currentEffect == 'sliceUpDown' || currentEffect == 'sliceUpDownRight' || currentEffect == 'sliceUpDownLeft') {
                createSlices(slider, settings, vars);
                var timeBuff = 0;
                var i = 0;
                var v = 0;
                var slices = $('.nivo-slice', slider);
                if (currentEffect == 'sliceUpDownLeft') slices = $('.nivo-slice', slider)._reverse();

                slices.each(function() {
                    var slice = $(this);
                    if (i == 0) {
                        slice.css('top', '0px');
                        i++;
                    } else {
                        slice.css('bottom', '0px');
                        i = 0;
                    }

                    if (v == settings.slices - 1) {
                        setTimeout(function() {
                            slice.animate({
                                height: '100%',
                                opacity: '1.0'
                            }, settings.animSpeed, '', function() {
                                slider.trigger('nivo:animFinished');
                            });
                        }, (100 + timeBuff));
                    } else {
                        setTimeout(function() {
                            slice.animate({
                                height: '100%',
                                opacity: '1.0'
                            }, settings.animSpeed);
                        }, (100 + timeBuff));
                    }
                    timeBuff += 50;
                    v++;
                });
            } else if (currentEffect == 'fold') {
                createSlices(slider, settings, vars);
                var timeBuff = 0;
                var i = 0;

                $('.nivo-slice', slider).each(function() {
                    var slice = $(this);
                    var origWidth = slice.width();
                    slice.css({
                        top: '0px',
                        height: '100%',
                        width: '0px'
                    });
                    if (i == settings.slices - 1) {
                        setTimeout(function() {
                            slice.animate({
                                width: origWidth,
                                opacity: '1.0'
                            }, settings.animSpeed, '', function() {
                                slider.trigger('nivo:animFinished');
                            });
                        }, (100 + timeBuff));
                    } else {
                        setTimeout(function() {
                            slice.animate({
                                width: origWidth,
                                opacity: '1.0'
                            }, settings.animSpeed);
                        }, (100 + timeBuff));
                    }
                    timeBuff += 50;
                    i++;
                });
            } else if (currentEffect == 'fade') {
                createSlices(slider, settings, vars);

                var firstSlice = $('.nivo-slice:first', slider);
                firstSlice.css({
                    'height': '100%',
                    'width': slider.width() + 'px'
                });

                firstSlice.animate({
                    opacity: '1.0'
                }, (settings.animSpeed * 2), '', function() {
                    slider.trigger('nivo:animFinished');
                });
            } else if (currentEffect == 'slideInRight') {
                createSlices(slider, settings, vars);

                var firstSlice = $('.nivo-slice:first', slider);
                firstSlice.css({
                    'height': '100%',
                    'width': '0px',
                    'opacity': '1'
                });

                firstSlice.animate({
                    width: slider.width() + 'px'
                }, (settings.animSpeed * 2), '', function() {
                    slider.trigger('nivo:animFinished');
                });
            } else if (currentEffect == 'slideInLeft') {
                createSlices(slider, settings, vars);

                var firstSlice = $('.nivo-slice:first', slider);
                firstSlice.css({
                    'height': '100%',
                    'width': '0px',
                    'opacity': '1',
                    'left': '',
                    'right': '0px'
                });

                firstSlice.animate({
                    width: slider.width() + 'px'
                }, (settings.animSpeed * 2), '', function() {
                    // Reset positioning
                    firstSlice.css({
                        'left': '0px',
                        'right': ''
                    });
                    slider.trigger('nivo:animFinished');
                });
            } else if (currentEffect == 'boxRandom') {
                createBoxes(slider, settings, vars);

                var totalBoxes = settings.boxCols * settings.boxRows;
                var i = 0;
                var timeBuff = 0;

                var boxes = shuffle($('.nivo-box', slider));
                boxes.each(function() {
                    var box = $(this);
                    if (i == totalBoxes - 1) {
                        setTimeout(function() {
                            box.animate({
                                opacity: '1'
                            }, settings.animSpeed, '', function() {
                                slider.trigger('nivo:animFinished');
                            });
                        }, (100 + timeBuff));
                    } else {
                        setTimeout(function() {
                            box.animate({
                                opacity: '1'
                            }, settings.animSpeed);
                        }, (100 + timeBuff));
                    }
                    timeBuff += 20;
                    i++;
                });
            } else if (currentEffect == 'boxRain' || currentEffect == 'boxRainReverse' || currentEffect == 'boxRainGrow' || currentEffect == 'boxRainGrowReverse') {
                createBoxes(slider, settings, vars);

                var totalBoxes = settings.boxCols * settings.boxRows;
                var i = 0;
                var timeBuff = 0;

                // Split boxes into 2D array
                var rowIndex = 0;
                var colIndex = 0;
                var box2Darr = new Array();
                box2Darr[rowIndex] = new Array();
                var boxes = $('.nivo-box', slider);
                if (currentEffect == 'boxRainReverse' || currentEffect == 'boxRainGrowReverse') {
                    boxes = $('.nivo-box', slider)._reverse();
                }
                boxes.each(function() {
                    box2Darr[rowIndex][colIndex] = $(this);
                    colIndex++;
                    if (colIndex == settings.boxCols) {
                        rowIndex++;
                        colIndex = 0;
                        box2Darr[rowIndex] = new Array();
                    }
                });

                // Run animation
                for (var cols = 0; cols < (settings.boxCols * 2); cols++) {
                    var prevCol = cols;
                    for (var rows = 0; rows < settings.boxRows; rows++) {
                        if (prevCol >= 0 && prevCol < settings.boxCols) {
                            /* Due to some weird JS bug with loop vars 
                            being used in setTimeout, this is wrapped
                            with an anonymous function call */
                            (function(row, col, time, i, totalBoxes) {
                                var box = $(box2Darr[row][col]);
                                var w = box.width();
                                var h = box.height();
                                if (currentEffect == 'boxRainGrow' || currentEffect == 'boxRainGrowReverse') {
                                    box.width(0).height(0);
                                }
                                if (i == totalBoxes - 1) {
                                    setTimeout(function() {
                                        box.animate({
                                            opacity: '1',
                                            width: w,
                                            height: h
                                        }, settings.animSpeed / 1.3, '', function() {
                                            slider.trigger('nivo:animFinished');
                                        });
                                    }, (100 + time));
                                } else {
                                    setTimeout(function() {
                                        box.animate({
                                            opacity: '1',
                                            width: w,
                                            height: h
                                        }, settings.animSpeed / 1.3);
                                    }, (100 + time));
                                }
                            })(rows, prevCol, timeBuff, i, totalBoxes);
                            i++;
                        }
                        prevCol--;
                    }
                    timeBuff += 100;
                }
            }
        }

        // Shuffle an array
        var shuffle = function(arr) {
            for (var j, x, i = arr.length; i; j = parseInt(Math.random() * i), x = arr[--i], arr[i] = arr[j], arr[j] = x);
            return arr;
        }

        // For debugging
        var trace = function(msg) {
            if (this.console && typeof console.log != "undefined")
                console.log(msg);
        }

        // Start / Stop
        this.stop = function() {
            if (!$(element).data('nivo:vars').stop) {
                $(element).data('nivo:vars').stop = true;
                trace('Stop Slider');
            }
        }

        this.start = function() {
            if ($(element).data('nivo:vars').stop) {
                $(element).data('nivo:vars').stop = false;
                trace('Start Slider');
            }
        }

        //Trigger the afterLoad callback
        settings.afterLoad.call(this);

        return this;
    };

    $.fn.nivoSlider = function(options) {

        return this.each(function(key, value) {
            var element = $(this);
            // Return early if this element already has a plugin instance
            if (element.data('nivoslider')) return element.data('nivoslider');
            // Pass options to plugin constructor
            var nivoslider = new NivoSlider(this, options);
            // Store plugin object in this element's data
            element.data('nivoslider', nivoslider);
        });

    };

    //Default settings
    $.fn.nivoSlider.defaults = {
        effect: 'random',
        slices: 15,
        boxCols: 8,
        boxRows: 4,
        animSpeed: 500,
        pauseTime: 3000,
        startSlide: 0,
        directionNav: true,
        directionNavHide: true,
        controlNav: true,
        controlNavThumbs: false,
        controlNavThumbsFromRel: false,
        controlNavThumbsSearch: '.jpg',
        controlNavThumbsReplace: '_thumb.jpg',
        keyboardNav: true,
        pauseOnHover: true,
        manualAdvance: false,
        captionOpacity: 0.8,
        prevText: 'Prev',
        nextText: 'Next',
        randomStart: false,
        beforeChange: function() {},
        afterChange: function() {},
        slideshowEnd: function() {},
        lastSlide: function() {},
        afterLoad: function() {}
    };

    $.fn._reverse = [].reverse;

})(jQuery);

/*
 * jQuery Cycle Plugin (with Transition Definitions)
 * Examples and documentation at: http://jquery.malsup.com/cycle/
 * Copyright (c) 2007-2009 M. Alsup
 * Version: 2.73 (04-NOV-2009)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 * Requires: jQuery v1.2.6 or later
 *
 * Originally based on the work of:
 *	1) Matt Oakes
 *	2) Torsten Baldes (http://medienfreunde.com/lab/innerfade/)
 *	3) Benjamin Sterling (http://www.benjaminsterling.com/experiments/jqShuffle/)
 */
(function(i) {
    var l = "2.73";
    if (i.support == undefined) {
        i.support = {
            opacity: !(i.browser.msie)
        }
    }

    function a(q) {
        if (i.fn.cycle.debug) {
            f(q)
        }
    }

    function f() {
        if (window.console && window.console.log) {
            window.console.log("[cycle] " + Array.prototype.join.call(arguments, " "))
        }
    }
    i.fn.cycle = function(r, q) {
        var s = {
            s: this.selector,
            c: this.context
        };
        if (this.length === 0 && r != "stop") {
            if (!i.isReady && s.s) {
                f("DOM not ready, queuing slideshow");
                i(function() {
                    i(s.s, s.c).cycle(r, q)
                });
                return this
            }
            f("terminating; zero elements found by selector" + (i.isReady ? "" : " (DOM not ready)"));
            return this
        }
        return this.each(function() {
            var w = m(this, r, q);
            if (w === false) {
                return
            }
            if (this.cycleTimeout) {
                clearTimeout(this.cycleTimeout)
            }
            this.cycleTimeout = this.cyclePause = 0;
            var x = i(this);
            var y = w.slideExpr ? i(w.slideExpr, this) : x.children();
            var u = y.get();
            if (u.length < 2) {
                f("terminating; too few slides: " + u.length);
                return
            }
            var t = k(x, y, u, w, s);
            if (t === false) {
                return
            }
            var v = t.continuous ? 10 : h(t.currSlide, t.nextSlide, t, !t.rev);
            if (v) {
                v += (t.delay || 0);
                if (v < 10) {
                    v = 10
                }
                a("first timeout: " + v);
                this.cycleTimeout = setTimeout(function() {
                    e(u, t, 0, !t.rev)
                }, v)
            }
        })
    };

    function m(q, t, r) {
        if (q.cycleStop == undefined) {
            q.cycleStop = 0
        }
        if (t === undefined || t === null) {
            t = {}
        }
        if (t.constructor == String) {
            switch (t) {
                case "stop":
                    q.cycleStop++;
                    if (q.cycleTimeout) {
                        clearTimeout(q.cycleTimeout)
                    }
                    q.cycleTimeout = 0;
                    i(q).removeData("cycle.opts");
                    return false;
                case "pause":
                    q.cyclePause = 1;
                    return false;
                case "resume":
                    q.cyclePause = 0;
                    if (r === true) {
                        t = i(q).data("cycle.opts");
                        if (!t) {
                            f("options not found, can not resume");
                            return false
                        }
                        if (q.cycleTimeout) {
                            clearTimeout(q.cycleTimeout);
                            q.cycleTimeout = 0
                        }
                        e(t.elements, t, 1, 1)
                    }
                    return false;
                case "prev":
                case "next":
                    var u = i(q).data("cycle.opts");
                    if (!u) {
                        f('options not found, "prev/next" ignored');
                        return false
                    }
                    i.fn.cycle[t](u);
                    return false;
                default:
                    t = {
                        fx: t
                    }
            }
            return t
        } else {
            if (t.constructor == Number) {
                var s = t;
                t = i(q).data("cycle.opts");
                if (!t) {
                    f("options not found, can not advance slide");
                    return false
                }
                if (s < 0 || s >= t.elements.length) {
                    f("invalid slide index: " + s);
                    return false
                }
                t.nextSlide = s;
                if (q.cycleTimeout) {
                    clearTimeout(q.cycleTimeout);
                    q.cycleTimeout = 0
                }
                if (typeof r == "string") {
                    t.oneTimeFx = r
                }
                e(t.elements, t, 1, s >= t.currSlide);
                return false
            }
        }
        return t
    }

    function b(q, r) {
        if (!i.support.opacity && r.cleartype && q.style.filter) {
            try {
                q.style.removeAttribute("filter")
            } catch (s) {}
        }
    }

    function k(y, J, u, t, E) {
        var C = i.extend({}, i.fn.cycle.defaults, t || {}, i.metadata ? y.metadata() : i.meta ? y.data() : {});
        if (C.autostop) {
            C.countdown = C.autostopCount || u.length
        }
        var r = y[0];
        y.data("cycle.opts", C);
        C.$cont = y;
        C.stopCount = r.cycleStop;
        C.elements = u;
        C.before = C.before ? [C.before] : [];
        C.after = C.after ? [C.after] : [];
        C.after.unshift(function() {
            C.busy = 0
        });
        if (!i.support.opacity && C.cleartype) {
            C.after.push(function() {
                b(this, C)
            })
        }
        if (C.continuous) {
            C.after.push(function() {
                e(u, C, 0, !C.rev)
            })
        }
        n(C);
        if (!i.support.opacity && C.cleartype && !C.cleartypeNoBg) {
            g(J)
        }
        if (y.css("position") == "static") {
            y.css("position", "relative")
        }
        if (C.width) {
            y.width(C.width)
        }
        if (C.height && C.height != "auto") {
            y.height(C.height)
        }
        if (C.startingSlide) {
            C.startingSlide = parseInt(C.startingSlide)
        }
        if (C.random) {
            C.randomMap = [];
            for (var H = 0; H < u.length; H++) {
                C.randomMap.push(H)
            }
            C.randomMap.sort(function(L, w) {
                return Math.random() - 0.5
            });
            C.randomIndex = 0;
            C.startingSlide = C.randomMap[0]
        } else {
            if (C.startingSlide >= u.length) {
                C.startingSlide = 0
            }
        }
        C.currSlide = C.startingSlide = C.startingSlide || 0;
        var x = C.startingSlide;
        J.css({
            position: "absolute",
            top: 0,
            left: 0
        }).hide().each(function(w) {
            var L = x ? w >= x ? u.length - (w - x) : x - w : u.length - w;
            i(this).css("z-index", L)
        });
        i(u[x]).css("opacity", 1).show();
        b(u[x], C);
        if (C.fit && C.width) {
            J.width(C.width)
        }
        if (C.fit && C.height && C.height != "auto") {
            J.height(C.height)
        }
        var D = C.containerResize && !y.innerHeight();
        if (D) {
            var v = 0,
                B = 0;
            for (var F = 0; F < u.length; F++) {
                var q = i(u[F]),
                    K = q[0],
                    A = q.outerWidth(),
                    I = q.outerHeight();
                if (!A) {
                    A = K.offsetWidth
                }
                if (!I) {
                    I = K.offsetHeight
                }
                v = A > v ? A : v;
                B = I > B ? I : B
            }
            if (v > 0 && B > 0) {
                y.css({
                    width: v + "px",
                    height: B + "px"
                })
            }
        }
        if (C.pause) {
            y.hover(function() {
                this.cyclePause++
            }, function() {
                this.cyclePause--
            })
        }
        if (c(C) === false) {
            return false
        }
        var s = false;
        t.requeueAttempts = t.requeueAttempts || 0;
        J.each(function() {
            var N = i(this);
            this.cycleH = (C.fit && C.height) ? C.height : N.height();
            this.cycleW = (C.fit && C.width) ? C.width : N.width();
            if (N.is("img")) {
                var L = (i.browser.msie && this.cycleW == 28 && this.cycleH == 30 && !this.complete);
                var O = (i.browser.mozilla && this.cycleW == 34 && this.cycleH == 19 && !this.complete);
                var M = (i.browser.opera && ((this.cycleW == 42 && this.cycleH == 19) || (this.cycleW == 37 && this.cycleH == 17)) && !this.complete);
                var w = (this.cycleH == 0 && this.cycleW == 0 && !this.complete);
                if (L || O || M || w) {
                    if (E.s && C.requeueOnImageNotLoaded && ++t.requeueAttempts < 100) {
                        f(t.requeueAttempts, " - img slide not loaded, requeuing slideshow: ", this.src, this.cycleW, this.cycleH);
                        setTimeout(function() {
                            i(E.s, E.c).cycle(t)
                        }, C.requeueTimeout);
                        s = true;
                        return false
                    } else {
                        f("could not determine size of image: " + this.src, this.cycleW, this.cycleH)
                    }
                }
            }
            return true
        });
        if (s) {
            return false
        }
        C.cssBefore = C.cssBefore || {};
        C.animIn = C.animIn || {};
        C.animOut = C.animOut || {};
        J.not(":eq(" + x + ")").css(C.cssBefore);
        if (C.cssFirst) {
            i(J[x]).css(C.cssFirst)
        }
        if (C.timeout) {
            C.timeout = parseInt(C.timeout);
            if (C.speed.constructor == String) {
                C.speed = i.fx.speeds[C.speed] || parseInt(C.speed)
            }
            if (!C.sync) {
                C.speed = C.speed / 2
            }
            while ((C.timeout - C.speed) < 250) {
                C.timeout += C.speed
            }
        }
        if (C.easing) {
            C.easeIn = C.easeOut = C.easing
        }
        if (!C.speedIn) {
            C.speedIn = C.speed
        }
        if (!C.speedOut) {
            C.speedOut = C.speed
        }
        C.slideCount = u.length;
        C.currSlide = C.lastSlide = x;
        if (C.random) {
            C.nextSlide = C.currSlide;
            if (++C.randomIndex == u.length) {
                C.randomIndex = 0
            }
            C.nextSlide = C.randomMap[C.randomIndex]
        } else {
            C.nextSlide = C.startingSlide >= (u.length - 1) ? 0 : C.startingSlide + 1
        }
        if (!C.multiFx) {
            var G = i.fn.cycle.transitions[C.fx];
            if (i.isFunction(G)) {
                G(y, J, C)
            } else {
                if (C.fx != "custom" && !C.multiFx) {
                    f("unknown transition: " + C.fx, "; slideshow terminating");
                    return false
                }
            }
        }
        var z = J[x];
        if (C.before.length) {
            C.before[0].apply(z, [z, z, C, true])
        }
        if (C.after.length > 1) {
            C.after[1].apply(z, [z, z, C, true])
        }
        if (C.next) {
            i(C.next).bind(C.prevNextEvent, function() {
                return o(C, C.rev ? -1 : 1)
            })
        }
        if (C.prev) {
            i(C.prev).bind(C.prevNextEvent, function() {
                return o(C, C.rev ? 1 : -1)
            })
        }
        if (C.pager) {
            d(u, C)
        }
        j(C, u);
        return C
    }

    function n(q) {
        q.original = {
            before: [],
            after: []
        };
        q.original.cssBefore = i.extend({}, q.cssBefore);
        q.original.cssAfter = i.extend({}, q.cssAfter);
        q.original.animIn = i.extend({}, q.animIn);
        q.original.animOut = i.extend({}, q.animOut);
        i.each(q.before, function() {
            q.original.before.push(this)
        });
        i.each(q.after, function() {
            q.original.after.push(this)
        })
    }

    function c(w) {
        var u, s, r = i.fn.cycle.transitions;
        if (w.fx.indexOf(",") > 0) {
            w.multiFx = true;
            w.fxs = w.fx.replace(/\s*/g, "").split(",");
            for (u = 0; u < w.fxs.length; u++) {
                var v = w.fxs[u];
                s = r[v];
                if (!s || !r.hasOwnProperty(v) || !i.isFunction(s)) {
                    f("discarding unknown transition: ", v);
                    w.fxs.splice(u, 1);
                    u--
                }
            }
            if (!w.fxs.length) {
                f("No valid transitions named; slideshow terminating.");
                return false
            }
        } else {
            if (w.fx == "all") {
                w.multiFx = true;
                w.fxs = [];
                for (p in r) {
                    s = r[p];
                    if (r.hasOwnProperty(p) && i.isFunction(s)) {
                        w.fxs.push(p)
                    }
                }
            }
        }
        if (w.multiFx && w.randomizeEffects) {
            var t = Math.floor(Math.random() * 20) + 30;
            for (u = 0; u < t; u++) {
                var q = Math.floor(Math.random() * w.fxs.length);
                w.fxs.push(w.fxs.splice(q, 1)[0])
            }
            a("randomized fx sequence: ", w.fxs)
        }
        return true
    }

    function j(r, q) {
        r.addSlide = function(u, v) {
            var t = i(u),
                w = t[0];
            if (!r.autostopCount) {
                r.countdown++
            }
            q[v ? "unshift" : "push"](w);
            if (r.els) {
                r.els[v ? "unshift" : "push"](w)
            }
            r.slideCount = q.length;
            t.css("position", "absolute");
            t[v ? "prependTo" : "appendTo"](r.$cont);
            if (v) {
                r.currSlide++;
                r.nextSlide++
            }
            if (!i.support.opacity && r.cleartype && !r.cleartypeNoBg) {
                g(t)
            }
            if (r.fit && r.width) {
                t.width(r.width)
            }
            if (r.fit && r.height && r.height != "auto") {
                $slides.height(r.height)
            }
            w.cycleH = (r.fit && r.height) ? r.height : t.height();
            w.cycleW = (r.fit && r.width) ? r.width : t.width();
            t.css(r.cssBefore);
            if (r.pager) {
                i.fn.cycle.createPagerAnchor(q.length - 1, w, i(r.pager), q, r)
            }
            if (i.isFunction(r.onAddSlide)) {
                r.onAddSlide(t)
            } else {
                t.hide()
            }
        }
    }
    i.fn.cycle.resetState = function(r, q) {
        q = q || r.fx;
        r.before = [];
        r.after = [];
        r.cssBefore = i.extend({}, r.original.cssBefore);
        r.cssAfter = i.extend({}, r.original.cssAfter);
        r.animIn = i.extend({}, r.original.animIn);
        r.animOut = i.extend({}, r.original.animOut);
        r.fxFn = null;
        i.each(r.original.before, function() {
            r.before.push(this)
        });
        i.each(r.original.after, function() {
            r.after.push(this)
        });
        var s = i.fn.cycle.transitions[q];
        if (i.isFunction(s)) {
            s(r.$cont, i(r.elements), r)
        }
    };

    function e(x, q, w, y) {
        if (w && q.busy && q.manualTrump) {
            i(x).stop(true, true);
            q.busy = false
        }
        if (q.busy) {
            return
        }
        var u = q.$cont[0],
            A = x[q.currSlide],
            z = x[q.nextSlide];
        if (u.cycleStop != q.stopCount || u.cycleTimeout === 0 && !w) {
            return
        }
        if (!w && !u.cyclePause && ((q.autostop && (--q.countdown <= 0)) || (q.nowrap && !q.random && q.nextSlide < q.currSlide))) {
            if (q.end) {
                q.end(q)
            }
            return
        }
        if (w || !u.cyclePause) {
            var v = q.fx;
            A.cycleH = A.cycleH || i(A).height();
            A.cycleW = A.cycleW || i(A).width();
            z.cycleH = z.cycleH || i(z).height();
            z.cycleW = z.cycleW || i(z).width();
            if (q.multiFx) {
                if (q.lastFx == undefined || ++q.lastFx >= q.fxs.length) {
                    q.lastFx = 0
                }
                v = q.fxs[q.lastFx];
                q.currFx = v
            }
            if (q.oneTimeFx) {
                v = q.oneTimeFx;
                q.oneTimeFx = null
            }
            i.fn.cycle.resetState(q, v);
            if (q.before.length) {
                i.each(q.before, function(B, C) {
                    if (u.cycleStop != q.stopCount) {
                        return
                    }
                    C.apply(z, [A, z, q, y])
                })
            }
            var s = function() {
                i.each(q.after, function(B, C) {
                    if (u.cycleStop != q.stopCount) {
                        return
                    }
                    C.apply(z, [A, z, q, y])
                })
            };
            if (q.nextSlide != q.currSlide) {
                q.busy = 1;
                if (q.fxFn) {
                    q.fxFn(A, z, q, s, y)
                } else {
                    if (i.isFunction(i.fn.cycle[q.fx])) {
                        i.fn.cycle[q.fx](A, z, q, s)
                    } else {
                        i.fn.cycle.custom(A, z, q, s, w && q.fastOnEvent)
                    }
                }
            }
            q.lastSlide = q.currSlide;
            if (q.random) {
                q.currSlide = q.nextSlide;
                if (++q.randomIndex == x.length) {
                    q.randomIndex = 0
                }
                q.nextSlide = q.randomMap[q.randomIndex]
            } else {
                var t = (q.nextSlide + 1) == x.length;
                q.nextSlide = t ? 0 : q.nextSlide + 1;
                q.currSlide = t ? x.length - 1 : q.nextSlide - 1
            }
            if (q.pager) {
                i.fn.cycle.updateActivePagerLink(q.pager, q.currSlide)
            }
        }
        var r = 0;
        if (q.timeout && !q.continuous) {
            r = h(A, z, q, y)
        } else {
            if (q.continuous && u.cyclePause) {
                r = 10
            }
        }
        if (r > 0) {
            u.cycleTimeout = setTimeout(function() {
                e(x, q, 0, !q.rev)
            }, r)
        }
    }
    i.fn.cycle.updateActivePagerLink = function(q, r) {
        i(q).each(function() {
            i(this).find("a").removeClass("activeSlide").filter("a:eq(" + r + ")").addClass("activeSlide")
        })
    };

    function h(v, s, u, r) {
        if (u.timeoutFn) {
            var q = u.timeoutFn(v, s, u, r);
            while ((q - u.speed) < 250) {
                q += u.speed
            }
            a("calculated timeout: " + q + "; speed: " + u.speed);
            if (q !== false) {
                return q
            }
        }
        return u.timeout
    }
    i.fn.cycle.next = function(q) {
        o(q, q.rev ? -1 : 1)
    };
    i.fn.cycle.prev = function(q) {
        o(q, q.rev ? 1 : -1)
    };

    function o(r, u) {
        var q = r.elements;
        var t = r.$cont[0],
            s = t.cycleTimeout;
        if (s) {
            clearTimeout(s);
            t.cycleTimeout = 0
        }
        if (r.random && u < 0) {
            r.randomIndex--;
            if (--r.randomIndex == -2) {
                r.randomIndex = q.length - 2
            } else {
                if (r.randomIndex == -1) {
                    r.randomIndex = q.length - 1
                }
            }
            r.nextSlide = r.randomMap[r.randomIndex]
        } else {
            if (r.random) {
                if (++r.randomIndex == q.length) {
                    r.randomIndex = 0
                }
                r.nextSlide = r.randomMap[r.randomIndex]
            } else {
                r.nextSlide = r.currSlide + u;
                if (r.nextSlide < 0) {
                    if (r.nowrap) {
                        return false
                    }
                    r.nextSlide = q.length - 1
                } else {
                    if (r.nextSlide >= q.length) {
                        if (r.nowrap) {
                            return false
                        }
                        r.nextSlide = 0
                    }
                }
            }
        }
        if (i.isFunction(r.prevNextClick)) {
            r.prevNextClick(u > 0, r.nextSlide, q[r.nextSlide])
        }
        e(q, r, 1, u >= 0);
        return false
    }

    function d(r, s) {
        var q = i(s.pager);
        i.each(r, function(t, u) {
            i.fn.cycle.createPagerAnchor(t, u, q, r, s)
        });
        i.fn.cycle.updateActivePagerLink(s.pager, s.startingSlide)
    }
    i.fn.cycle.createPagerAnchor = function(u, v, s, t, w) {
        var r;
        if (i.isFunction(w.pagerAnchorBuilder)) {
            r = w.pagerAnchorBuilder(u, v)
        } else {
            r = '<a href="#">' + (u + 1) + "</a>"
        }
        if (!r) {
            return
        }
        var x = i(r);
        if (x.parents("body").length === 0) {
            var q = [];
            if (s.length > 1) {
                s.each(function() {
                    var y = x.clone(true);
                    i(this).append(y);
                    q.push(y[0])
                });
                x = i(q)
            } else {
                x.appendTo(s)
            }
        }
        x.bind(w.pagerEvent, function(A) {
            A.preventDefault();
            w.nextSlide = u;
            var z = w.$cont[0],
                y = z.cycleTimeout;
            if (y) {
                clearTimeout(y);
                z.cycleTimeout = 0
            }
            if (i.isFunction(w.pagerClick)) {
                w.pagerClick(w.nextSlide, t[w.nextSlide])
            }
            e(t, w, 1, w.currSlide < u);
            return false
        });
        if (w.pagerEvent != "click") {
            x.click(function() {
                return false
            })
        }
        if (w.pauseOnPagerHover) {
            x.hover(function() {
                w.$cont[0].cyclePause++
            }, function() {
                w.$cont[0].cyclePause--
            })
        }
    };
    i.fn.cycle.hopsFromLast = function(t, s) {
        var r, q = t.lastSlide,
            u = t.currSlide;
        if (s) {
            r = u > q ? u - q : t.slideCount - q
        } else {
            r = u < q ? q - u : q + t.slideCount - u
        }
        return r
    };

    function g(s) {
        function r(t) {
            t = parseInt(t).toString(16);
            return t.length < 2 ? "0" + t : t
        }

        function q(w) {
            for (; w && w.nodeName.toLowerCase() != "html"; w = w.parentNode) {
                var t = i.css(w, "background-color");
                if (t.indexOf("rgb") >= 0) {
                    var u = t.match(/\d+/g);
                    return "#" + r(u[0]) + r(u[1]) + r(u[2])
                }
                if (t && t != "transparent") {
                    return t
                }
            }
            return "#ffffff"
        }
        s.each(function() {
            i(this).css("background-color", q(this))
        })
    }
    i.fn.cycle.commonReset = function(v, t, u, r, s, q) {
        i(u.elements).not(v).hide();
        u.cssBefore.opacity = 1;
        u.cssBefore.display = "block";
        if (r !== false && t.cycleW > 0) {
            u.cssBefore.width = t.cycleW
        }
        if (s !== false && t.cycleH > 0) {
            u.cssBefore.height = t.cycleH
        }
        u.cssAfter = u.cssAfter || {};
        u.cssAfter.display = "none";
        i(v).css("zIndex", u.slideCount + (q === true ? 1 : 0));
        i(t).css("zIndex", u.slideCount + (q === true ? 0 : 1))
    };
    i.fn.cycle.custom = function(B, v, q, s, r) {
        var A = i(B),
            w = i(v);
        var t = q.speedIn,
            z = q.speedOut,
            u = q.easeIn,
            y = q.easeOut;
        w.css(q.cssBefore);
        if (r) {
            if (typeof r == "number") {
                t = z = r
            } else {
                t = z = 1
            }
            u = y = null
        }
        var x = function() {
            w.animate(q.animIn, t, u, s)
        };
        A.animate(q.animOut, z, y, function() {
            if (q.cssAfter) {
                A.css(q.cssAfter)
            }
            if (!q.sync) {
                x()
            }
        });
        if (q.sync) {
            x()
        }
    };
    i.fn.cycle.transitions = {
        fade: function(r, s, q) {
            s.not(":eq(" + q.currSlide + ")").css("opacity", 0);
            q.before.push(function(v, t, u) {
                i.fn.cycle.commonReset(v, t, u);
                u.cssBefore.opacity = 0
            });
            q.animIn = {
                opacity: 1
            };
            q.animOut = {
                opacity: 0
            };
            q.cssBefore = {
                top: 0,
                left: 0
            }
        }
    };
    i.fn.cycle.ver = function() {
        return l
    };
    i.fn.cycle.defaults = {
        fx: "fade",
        timeout: 4000,
        timeoutFn: null,
        continuous: 0,
        speed: 1000,
        speedIn: null,
        speedOut: null,
        next: null,
        prev: null,
        prevNextClick: null,
        prevNextEvent: "click",
        pager: null,
        pagerClick: null,
        pagerEvent: "click",
        pagerAnchorBuilder: null,
        before: null,
        after: null,
        end: null,
        easing: null,
        easeIn: null,
        easeOut: null,
        shuffle: null,
        animIn: null,
        animOut: null,
        cssBefore: null,
        cssAfter: null,
        fxFn: null,
        height: "auto",
        startingSlide: 0,
        sync: 1,
        random: 0,
        fit: 0,
        containerResize: 1,
        pause: 0,
        pauseOnPagerHover: 0,
        autostop: 0,
        autostopCount: 0,
        delay: 0,
        slideExpr: null,
        cleartype: !i.support.opacity,
        cleartypeNoBg: false,
        nowrap: 0,
        fastOnEvent: 0,
        randomizeEffects: 1,
        rev: 0,
        manualTrump: true,
        requeueOnImageNotLoaded: true,
        requeueTimeout: 250
    }
})(jQuery);
/*
 * jQuery Cycle Plugin Transition Definitions
 * This script is a plugin for the jQuery Cycle Plugin
 * Examples and documentation at: http://malsup.com/jquery/cycle/
 * Copyright (c) 2007-2008 M. Alsup
 * Version:	 2.72
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */
(function(a) {
    a.fn.cycle.transitions.none = function(c, d, b) {
        b.fxFn = function(g, e, f, h) {
            a(e).show();
            a(g).hide();
            h()
        }
    };
    a.fn.cycle.transitions.scrollUp = function(d, e, c) {
        d.css("overflow", "hidden");
        c.before.push(a.fn.cycle.commonReset);
        var b = d.height();
        c.cssBefore = {
            top: b,
            left: 0
        };
        c.cssFirst = {
            top: 0
        };
        c.animIn = {
            top: 0
        };
        c.animOut = {
            top: -b
        }
    };
    a.fn.cycle.transitions.scrollDown = function(d, e, c) {
        d.css("overflow", "hidden");
        c.before.push(a.fn.cycle.commonReset);
        var b = d.height();
        c.cssFirst = {
            top: 0
        };
        c.cssBefore = {
            top: -b,
            left: 0
        };
        c.animIn = {
            top: 0
        };
        c.animOut = {
            top: b
        }
    };
    a.fn.cycle.transitions.scrollLeft = function(d, e, c) {
        d.css("overflow", "hidden");
        c.before.push(a.fn.cycle.commonReset);
        var b = d.width();
        c.cssFirst = {
            left: 0
        };
        c.cssBefore = {
            left: b,
            top: 0
        };
        c.animIn = {
            left: 0
        };
        c.animOut = {
            left: 0 - b
        }
    };
    a.fn.cycle.transitions.scrollRight = function(d, e, c) {
        d.css("overflow", "hidden");
        c.before.push(a.fn.cycle.commonReset);
        var b = d.width();
        c.cssFirst = {
            left: 0
        };
        c.cssBefore = {
            left: -b,
            top: 0
        };
        c.animIn = {
            left: 0
        };
        c.animOut = {
            left: b
        }
    };
    a.fn.cycle.transitions.scrollHorz = function(c, d, b) {
        c.css("overflow", "hidden").width();
        b.before.push(function(h, f, g, e) {
            a.fn.cycle.commonReset(h, f, g);
            g.cssBefore.left = e ? (f.cycleW - 1) : (1 - f.cycleW);
            g.animOut.left = e ? -h.cycleW : h.cycleW
        });
        b.cssFirst = {
            left: 0
        };
        b.cssBefore = {
            top: 0
        };
        b.animIn = {
            left: 0
        };
        b.animOut = {
            top: 0
        }
    };
    a.fn.cycle.transitions.scrollVert = function(c, d, b) {
        c.css("overflow", "hidden");
        b.before.push(function(h, f, g, e) {
            a.fn.cycle.commonReset(h, f, g);
            g.cssBefore.top = e ? (1 - f.cycleH) : (f.cycleH - 1);
            g.animOut.top = e ? h.cycleH : -h.cycleH
        });
        b.cssFirst = {
            top: 0
        };
        b.cssBefore = {
            left: 0
        };
        b.animIn = {
            top: 0
        };
        b.animOut = {
            left: 0
        }
    };
    a.fn.cycle.transitions.slideX = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a(f.elements).not(g).hide();
            a.fn.cycle.commonReset(g, e, f, false, true);
            f.animIn.width = e.cycleW
        });
        b.cssBefore = {
            left: 0,
            top: 0,
            width: 0
        };
        b.animIn = {
            width: "show"
        };
        b.animOut = {
            width: 0
        }
    };
    a.fn.cycle.transitions.slideY = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a(f.elements).not(g).hide();
            a.fn.cycle.commonReset(g, e, f, true, false);
            f.animIn.height = e.cycleH
        });
        b.cssBefore = {
            left: 0,
            top: 0,
            height: 0
        };
        b.animIn = {
            height: "show"
        };
        b.animOut = {
            height: 0
        }
    };
    a.fn.cycle.transitions.shuffle = function(e, f, d) {
        var c, b = e.css("overflow", "visible").width();
        f.css({
            left: 0,
            top: 0
        });
        d.before.push(function(i, g, h) {
            a.fn.cycle.commonReset(i, g, h, true, true, true)
        });
        if (!d.speedAdjusted) {
            d.speed = d.speed / 2;
            d.speedAdjusted = true
        }
        d.random = 0;
        d.shuffle = d.shuffle || {
            left: -b,
            top: 15
        };
        d.els = [];
        for (c = 0; c < f.length; c++) {
            d.els.push(f[c])
        }
        for (c = 0; c < d.currSlide; c++) {
            d.els.push(d.els.shift())
        }
        d.fxFn = function(m, j, l, g, i) {
            var h = i ? a(m) : a(j);
            a(j).css(l.cssBefore);
            var k = l.slideCount;
            h.animate(l.shuffle, l.speedIn, l.easeIn, function() {
                var o = a.fn.cycle.hopsFromLast(l, i);
                for (var q = 0; q < o; q++) {
                    i ? l.els.push(l.els.shift()) : l.els.unshift(l.els.pop())
                }
                if (i) {
                    for (var r = 0, n = l.els.length; r < n; r++) {
                        a(l.els[r]).css("z-index", n - r + k)
                    }
                } else {
                    var s = a(m).css("z-index");
                    h.css("z-index", parseInt(s) + 1 + k)
                }
                h.animate({
                    left: 0,
                    top: 0
                }, l.speedOut, l.easeOut, function() {
                    a(i ? this : m).hide();
                    if (g) {
                        g()
                    }
                })
            })
        };
        d.cssBefore = {
            display: "block",
            opacity: 1,
            top: 0,
            left: 0
        }
    };
    a.fn.cycle.transitions.turnUp = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a.fn.cycle.commonReset(g, e, f, true, false);
            f.cssBefore.top = e.cycleH;
            f.animIn.height = e.cycleH
        });
        b.cssFirst = {
            top: 0
        };
        b.cssBefore = {
            left: 0,
            height: 0
        };
        b.animIn = {
            top: 0
        };
        b.animOut = {
            height: 0
        }
    };
    a.fn.cycle.transitions.turnDown = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a.fn.cycle.commonReset(g, e, f, true, false);
            f.animIn.height = e.cycleH;
            f.animOut.top = g.cycleH
        });
        b.cssFirst = {
            top: 0
        };
        b.cssBefore = {
            left: 0,
            top: 0,
            height: 0
        };
        b.animOut = {
            height: 0
        }
    };
    a.fn.cycle.transitions.turnLeft = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a.fn.cycle.commonReset(g, e, f, false, true);
            f.cssBefore.left = e.cycleW;
            f.animIn.width = e.cycleW
        });
        b.cssBefore = {
            top: 0,
            width: 0
        };
        b.animIn = {
            left: 0
        };
        b.animOut = {
            width: 0
        }
    };
    a.fn.cycle.transitions.turnRight = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a.fn.cycle.commonReset(g, e, f, false, true);
            f.animIn.width = e.cycleW;
            f.animOut.left = g.cycleW
        });
        b.cssBefore = {
            top: 0,
            left: 0,
            width: 0
        };
        b.animIn = {
            left: 0
        };
        b.animOut = {
            width: 0
        }
    };
    a.fn.cycle.transitions.zoom = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a.fn.cycle.commonReset(g, e, f, false, false, true);
            f.cssBefore.top = e.cycleH / 2;
            f.cssBefore.left = e.cycleW / 2;
            f.animIn = {
                top: 0,
                left: 0,
                width: e.cycleW,
                height: e.cycleH
            };
            f.animOut = {
                width: 0,
                height: 0,
                top: g.cycleH / 2,
                left: g.cycleW / 2
            }
        });
        b.cssFirst = {
            top: 0,
            left: 0
        };
        b.cssBefore = {
            width: 0,
            height: 0
        }
    };
    a.fn.cycle.transitions.fadeZoom = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a.fn.cycle.commonReset(g, e, f, false, false);
            f.cssBefore.left = e.cycleW / 2;
            f.cssBefore.top = e.cycleH / 2;
            f.animIn = {
                top: 0,
                left: 0,
                width: e.cycleW,
                height: e.cycleH
            }
        });
        b.cssBefore = {
            width: 0,
            height: 0
        };
        b.animOut = {
            opacity: 0
        }
    };
    a.fn.cycle.transitions.blindX = function(d, e, c) {
        var b = d.css("overflow", "hidden").width();
        c.before.push(function(h, f, g) {
            a.fn.cycle.commonReset(h, f, g);
            g.animIn.width = f.cycleW;
            g.animOut.left = h.cycleW
        });
        c.cssBefore = {
            left: b,
            top: 0
        };
        c.animIn = {
            left: 0
        };
        c.animOut = {
            left: b
        }
    };
    a.fn.cycle.transitions.blindY = function(d, e, c) {
        var b = d.css("overflow", "hidden").height();
        c.before.push(function(h, f, g) {
            a.fn.cycle.commonReset(h, f, g);
            g.animIn.height = f.cycleH;
            g.animOut.top = h.cycleH
        });
        c.cssBefore = {
            top: b,
            left: 0
        };
        c.animIn = {
            top: 0
        };
        c.animOut = {
            top: b
        }
    };
    a.fn.cycle.transitions.blindZ = function(e, f, d) {
        var c = e.css("overflow", "hidden").height();
        var b = e.width();
        d.before.push(function(i, g, h) {
            a.fn.cycle.commonReset(i, g, h);
            h.animIn.height = g.cycleH;
            h.animOut.top = i.cycleH
        });
        d.cssBefore = {
            top: c,
            left: b
        };
        d.animIn = {
            top: 0,
            left: 0
        };
        d.animOut = {
            top: c,
            left: b
        }
    };
    a.fn.cycle.transitions.growX = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a.fn.cycle.commonReset(g, e, f, false, true);
            f.cssBefore.left = this.cycleW / 2;
            f.animIn = {
                left: 0,
                width: this.cycleW
            };
            f.animOut = {
                left: 0
            }
        });
        b.cssBefore = {
            width: 0,
            top: 0
        }
    };
    a.fn.cycle.transitions.growY = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a.fn.cycle.commonReset(g, e, f, true, false);
            f.cssBefore.top = this.cycleH / 2;
            f.animIn = {
                top: 0,
                height: this.cycleH
            };
            f.animOut = {
                top: 0
            }
        });
        b.cssBefore = {
            height: 0,
            left: 0
        }
    };
    a.fn.cycle.transitions.curtainX = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a.fn.cycle.commonReset(g, e, f, false, true, true);
            f.cssBefore.left = e.cycleW / 2;
            f.animIn = {
                left: 0,
                width: this.cycleW
            };
            f.animOut = {
                left: g.cycleW / 2,
                width: 0
            }
        });
        b.cssBefore = {
            top: 0,
            width: 0
        }
    };
    a.fn.cycle.transitions.curtainY = function(c, d, b) {
        b.before.push(function(g, e, f) {
            a.fn.cycle.commonReset(g, e, f, true, false, true);
            f.cssBefore.top = e.cycleH / 2;
            f.animIn = {
                top: 0,
                height: e.cycleH
            };
            f.animOut = {
                top: g.cycleH / 2,
                height: 0
            }
        });
        b.cssBefore = {
            left: 0,
            height: 0
        }
    };
    a.fn.cycle.transitions.cover = function(f, g, e) {
        var i = e.direction || "left";
        var b = f.css("overflow", "hidden").width();
        var c = f.height();
        e.before.push(function(j, d, h) {
            a.fn.cycle.commonReset(j, d, h);
            if (i == "right") {
                h.cssBefore.left = -b
            } else {
                if (i == "up") {
                    h.cssBefore.top = c
                } else {
                    if (i == "down") {
                        h.cssBefore.top = -c
                    } else {
                        h.cssBefore.left = b
                    }
                }
            }
        });
        e.animIn = {
            left: 0,
            top: 0
        };
        e.animOut = {
            opacity: 1
        };
        e.cssBefore = {
            top: 0,
            left: 0
        }
    };
    a.fn.cycle.transitions.uncover = function(f, g, e) {
        var i = e.direction || "left";
        var b = f.css("overflow", "hidden").width();
        var c = f.height();
        e.before.push(function(j, d, h) {
            a.fn.cycle.commonReset(j, d, h, true, true, true);
            if (i == "right") {
                h.animOut.left = b
            } else {
                if (i == "up") {
                    h.animOut.top = -c
                } else {
                    if (i == "down") {
                        h.animOut.top = c
                    } else {
                        h.animOut.left = -b
                    }
                }
            }
        });
        e.animIn = {
            left: 0,
            top: 0
        };
        e.animOut = {
            opacity: 1
        };
        e.cssBefore = {
            top: 0,
            left: 0
        }
    };
    a.fn.cycle.transitions.toss = function(e, f, d) {
        var b = e.css("overflow", "visible").width();
        var c = e.height();
        d.before.push(function(i, g, h) {
            a.fn.cycle.commonReset(i, g, h, true, true, true);
            if (!h.animOut.left && !h.animOut.top) {
                h.animOut = {
                    left: b * 2,
                    top: -c / 2,
                    opacity: 0
                }
            } else {
                h.animOut.opacity = 0
            }
        });
        d.cssBefore = {
            left: 0,
            top: 0
        };
        d.animIn = {
            left: 0
        }
    };
    a.fn.cycle.transitions.wipe = function(s, m, e) {
        var q = s.css("overflow", "hidden").width();
        var j = s.height();
        e.cssBefore = e.cssBefore || {};
        var g;
        if (e.clip) {
            if (/l2r/.test(e.clip)) {
                g = "rect(0px 0px " + j + "px 0px)"
            } else {
                if (/r2l/.test(e.clip)) {
                    g = "rect(0px " + q + "px " + j + "px " + q + "px)"
                } else {
                    if (/t2b/.test(e.clip)) {
                        g = "rect(0px " + q + "px 0px 0px)"
                    } else {
                        if (/b2t/.test(e.clip)) {
                            g = "rect(" + j + "px " + q + "px " + j + "px 0px)"
                        } else {
                            if (/zoom/.test(e.clip)) {
                                var o = parseInt(j / 2);
                                var f = parseInt(q / 2);
                                g = "rect(" + o + "px " + f + "px " + o + "px " + f + "px)"
                            }
                        }
                    }
                }
            }
        }
        e.cssBefore.clip = e.cssBefore.clip || g || "rect(0px 0px 0px 0px)";
        var k = e.cssBefore.clip.match(/(\d+)/g);
        var u = parseInt(k[0]),
            c = parseInt(k[1]),
            n = parseInt(k[2]),
            i = parseInt(k[3]);
        e.before.push(function(w, h, t) {
            if (w == h) {
                return
            }
            var d = a(w),
                b = a(h);
            a.fn.cycle.commonReset(w, h, t, true, true, false);
            t.cssAfter.display = "block";
            var r = 1,
                l = parseInt((t.speedIn / 13)) - 1;
            (function v() {
                var y = u ? u - parseInt(r * (u / l)) : 0;
                var z = i ? i - parseInt(r * (i / l)) : 0;
                var A = n < j ? n + parseInt(r * ((j - n) / l || 1)) : j;
                var x = c < q ? c + parseInt(r * ((q - c) / l || 1)) : q;
                b.css({
                    clip: "rect(" + y + "px " + x + "px " + A + "px " + z + "px)"
                });
                (r++ <= l) ? setTimeout(v, 13): d.css("display", "none")
            })()
        });
        e.cssBefore = {
            display: "block",
            opacity: 1,
            top: 0,
            left: 0
        };
        e.animIn = {
            left: 0
        };
        e.animOut = {
            left: 0
        }
    }
})(jQuery);
//C:\wamp\www\kobstereshop\themes\theme335\js\script.js
$(function() {
    $('#tmfooterlinks ul li a').hover(function() {
        $(this).stop().animate({
            paddingLeft: '10px'
        }, 500);
    }, function() {
        $(this).stop().animate({
            paddingLeft: '0px'
        }, 500);
    });
});

$(function() {
    $('#cat ul.subcat1 li a').hover(function() {
        $(this).stop().animate({
            paddingLeft: '10px'
        }, 500);
    }, function() {
        $(this).stop().animate({
            paddingLeft: '0px'
        }, 500);
    });
});


jQuery(document).ready(function() {
    // hide #back-top first
    jQuery("#back-top").hide();
    // fade in #back-top
    jQuery(function() {
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > 100) {
                jQuery('#back-top').fadeIn();
            } else {
                jQuery('#back-top').fadeOut();
            }
        });

        // scroll body to 0px on click
        jQuery('#back-top a').click(function() {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });

});


/*http://media.kobster.com/themes/theme335/js/jquery.easing.1.3.js
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright Â© 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 */

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend(jQuery.easing, {
    def: 'easeOutQuad',
    swing: function(x, t, b, c, d) {
        //alert(jQuery.easing.default);
        return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
    },
    easeInQuad: function(x, t, b, c, d) {
        return c * (t /= d) * t + b;
    },
    easeOutQuad: function(x, t, b, c, d) {
        return -c * (t /= d) * (t - 2) + b;
    },
    easeInOutQuad: function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t + b;
        return -c / 2 * ((--t) * (t - 2) - 1) + b;
    },
    easeInCubic: function(x, t, b, c, d) {
        return c * (t /= d) * t * t + b;
    },
    easeOutCubic: function(x, t, b, c, d) {
        return c * ((t = t / d - 1) * t * t + 1) + b;
    },
    easeInOutCubic: function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t + 2) + b;
    },
    easeInQuart: function(x, t, b, c, d) {
        return c * (t /= d) * t * t * t + b;
    },
    easeOutQuart: function(x, t, b, c, d) {
        return -c * ((t = t / d - 1) * t * t * t - 1) + b;
    },
    easeInOutQuart: function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
        return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
    },
    easeInQuint: function(x, t, b, c, d) {
        return c * (t /= d) * t * t * t * t + b;
    },
    easeOutQuint: function(x, t, b, c, d) {
        return c * ((t = t / d - 1) * t * t * t * t + 1) + b;
    },
    easeInOutQuint: function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t * t * t + 2) + b;
    },
    easeInSine: function(x, t, b, c, d) {
        return -c * Math.cos(t / d * (Math.PI / 2)) + c + b;
    },
    easeOutSine: function(x, t, b, c, d) {
        return c * Math.sin(t / d * (Math.PI / 2)) + b;
    },
    easeInOutSine: function(x, t, b, c, d) {
        return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b;
    },
    easeInExpo: function(x, t, b, c, d) {
        return (t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b;
    },
    easeOutExpo: function(x, t, b, c, d) {
        return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
    },
    easeInOutExpo: function(x, t, b, c, d) {
        if (t == 0) return b;
        if (t == d) return b + c;
        if ((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
        return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
    },
    easeInCirc: function(x, t, b, c, d) {
        return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b;
    },
    easeOutCirc: function(x, t, b, c, d) {
        return c * Math.sqrt(1 - (t = t / d - 1) * t) + b;
    },
    easeInOutCirc: function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b;
        return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;
    },
    easeInElastic: function(x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0) return b;
        if ((t /= d) == 1) return b + c;
        if (!p) p = d * .3;
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4;
        } else var s = p / (2 * Math.PI) * Math.asin(c / a);
        return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
    },
    easeOutElastic: function(x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0) return b;
        if ((t /= d) == 1) return b + c;
        if (!p) p = d * .3;
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4;
        } else var s = p / (2 * Math.PI) * Math.asin(c / a);
        return a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b;
    },
    easeInOutElastic: function(x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0) return b;
        if ((t /= d / 2) == 2) return b + c;
        if (!p) p = d * (.3 * 1.5);
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4;
        } else var s = p / (2 * Math.PI) * Math.asin(c / a);
        if (t < 1) return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
        return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b;
    },
    easeInBack: function(x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c * (t /= d) * t * ((s + 1) * t - s) + b;
    },
    easeOutBack: function(x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b;
    },
    easeInOutBack: function(x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
        return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
    },
    easeInBounce: function(x, t, b, c, d) {
        return c - jQuery.easing.easeOutBounce(x, d - t, 0, c, d) + b;
    },
    easeOutBounce: function(x, t, b, c, d) {
        if ((t /= d) < (1 / 2.75)) {
            return c * (7.5625 * t * t) + b;
        } else if (t < (2 / 2.75)) {
            return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b;
        } else if (t < (2.5 / 2.75)) {
            return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b;
        } else {
            return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b;
        }
    },
    easeInOutBounce: function(x, t, b, c, d) {
        if (t < d / 2) return jQuery.easing.easeInBounce(x, t * 2, 0, c, d) * .5 + b;
        return jQuery.easing.easeOutBounce(x, t * 2 - d, 0, c, d) * .5 + c * .5 + b;
    }
});

/*
 *
 * TERMS OF USE - EASING EQUATIONS
 * 
 * Open source under the BSD License. 
 * 
 * Copyright Â© 2001 Robert Penner
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 */

/**
 * jQuery bxSlider v3.0
 * http://bxslider.com
 *
 * Copyright 2010, Steven Wanderski
 * http://bxcreative.com
 *
 * Free to use and abuse under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 
(function(a){a.fn.bxSlider=function(b){function Z(b,c,d,e){var f=[];var g=d;var h=false;if(e=="backward"){b=a.makeArray(b);b.reverse()}while(g>0){a.each(b,function(b,d){if(g>0){if(!h){if(b==c){h=true;f.push(a(this).clone());g--}}else{f.push(a(this).clone());g--}}else{return false}})}return f}function Y(){var a=i.outerHeight()*b.displaySlideQty;return a}function X(){var a=i.outerWidth()*b.displaySlideQty;return a}function W(b,c){if(c=="left"){var d=a(".pager",h).eq(b).position().left}else if(c=="top"){var d=a(".pager",h).eq(b).position().top}return d}function V(){if(!b.infiniteLoop&&b.hideControlOnEnd){if(x==F){a(".bx-prev",h).hide()}else{a(".bx-prev",h).show()}if(x==G){a(".bx-next",h).hide()}else{a(".bx-next",h).show()}}}function U(c,e,f,g){p=a('<a href="" class="bx-start"></a>');if(c=="text"){r=e}else{r='<img src="'+e+'" />'}if(f=="text"){s=g}else{s='<img src="'+g+'" />'}if(b.autoControlsSelector){a(b.autoControlsSelector).append(p)}else{h.append('<div class="bx-auto"></div>');a(".bx-auto",h).html(p)}p.click(function(){if(b.ticker){if(a(this).hasClass("stop")){d.stopTicker()}else if(a(this).hasClass("start")){d.startTicker()}}else{if(a(this).hasClass("stop")){d.stopShow(true)}else if(a(this).hasClass("start")){d.startShow(true)}}return false})}function T(){var c=a("img",g.eq(x)).attr("title");if(c!=""){if(b.captionsSelector){a(b.captionsSelector).html(c)}else{a(".bx-captions",h).html(c)}}else{if(b.captionsSelector){a(b.captionsSelector).html(" ")}else{a(".bx-captions",h).html(" ")}}}function S(c){var e=g.length;if(b.moveSlideQty>1){if(g.length%b.moveSlideQty!=0){e=Math.ceil(g.length/b.moveSlideQty)}else{e=g.length/b.moveSlideQty}}var f="";if(b.buildPager){for(var i=0;i<e;i++){f+=b.buildPager(i,g.eq(i*b.moveSlideQty))}}else if(c=="full"){for(var i=1;i<=e;i++){f+='<a href="" class="pager-link pager-'+i+'">'+i+"</a>"}}else if(c=="short"){f='<span class="bx-pager-current">'+(b.startingSlide+1)+"</span> "+b.pagerShortSeparator+' <span class="bx-pager-total">'+g.length+"</span>"}if(b.pagerSelector){a(b.pagerSelector).append(f);n=a(b.pagerSelector)}else{var j=a('<div class="bx-pager"></div>');j.append(f);if(b.pagerLocation=="top"){h.prepend(j)}else if(b.pagerLocation=="bottom"){h.append(j)}n=a(".bx-pager",h)}n.children().click(function(){if(b.pagerType=="full"){var a=n.children().index(this);if(b.moveSlideQty>1){a*=b.moveSlideQty}d.goToSlide(a)}return false})}function R(c,e,f,g){var i=a('<a href="" class="bx-next"></a>');var j=a('<a href="" class="bx-prev"></a>');if(c=="text"){i.html(e)}else{i.html('<img src="'+e+'" />')}if(f=="text"){j.html(g)}else{j.html('<img src="'+g+'" />')}if(b.prevSelector){a(b.prevSelector).append(j)}else{h.append(j)}if(b.nextSelector){a(b.nextSelector).append(i)}else{h.append(i)}i.click(function(){d.goToNextSlide();return false});j.click(function(){d.goToPreviousSlide();return false})}function Q(c){if(b.pagerType=="full"&&b.pager){a("a",n).removeClass(b.pagerActiveClass);a("a",n).eq(c).addClass(b.pagerActiveClass)}else if(b.pagerType=="short"&&b.pager){a(".bx-pager-current",n).html(x+1)}}function P(){g.not(":eq("+x+")").fadeTo(b.speed,0).css("zIndex",98);g.eq(x).css("zIndex",99).fadeTo(b.speed,1,function(){E=false;if(jQuery.browser.msie){g.eq(x).get(0).style.removeAttribute("filter")}b.onAfterSlide(x,g.length,g.eq(x))})}function O(){e.hover(function(){if(t){d.stopTicker(false)}},function(){if(t){d.startTicker(false)}})}function N(){h.find(".bx-window").hover(function(){if(t){d.stopShow(false)}},function(){if(t){d.startShow(false)}})}function M(){if(b.startImage!=""){startContent=b.startImage;startType="image"}else{startContent=b.startText;startType="text"}if(b.stopImage!=""){stopContent=b.stopImage;stopType="image"}else{stopContent=b.stopText;stopType="text"}U(startType,startContent,stopType,stopContent)}function L(a,c,d){if(b.mode=="horizontal"){if(b.tickerDirection=="next"){e.animate({left:"-="+c+"px"},d,"linear",function(){e.css("left",a);L(a,A,b.tickerSpeed)})}else if(b.tickerDirection=="prev"){e.animate({left:"+="+c+"px"},d,"linear",function(){e.css("left",a);L(a,A,b.tickerSpeed)})}}else if(b.mode=="vertical"){if(b.tickerDirection=="next"){e.animate({top:"-="+c+"px"},d,"linear",function(){e.css("top",a);L(a,B,b.tickerSpeed)})}else if(b.tickerDirection=="prev"){e.animate({top:"+="+c+"px"},d,"linear",function(){e.css("top",a);L(a,B,b.tickerSpeed)})}}}function K(){if(b.auto){if(!b.infiniteLoop){if(b.autoDirection=="next"){o=setInterval(function(){x+=b.moveSlideQty;if(x>G){x=x%g.length}d.goToSlide(x,false)},b.pause)}else if(b.autoDirection=="prev"){o=setInterval(function(){x-=b.moveSlideQty;if(x<0){negativeOffset=x%g.length;if(negativeOffset==0){x=0}else{x=g.length+negativeOffset}}d.goToSlide(x,false)},b.pause)}}else{if(b.autoDirection=="next"){o=setInterval(function(){d.goToNextSlide(false)},b.pause)}else if(b.autoDirection=="prev"){o=setInterval(function(){d.goToPreviousSlide(false)},b.pause)}}}else if(b.ticker){b.tickerSpeed*=10;a(".pager",h).each(function(b){A+=a(this).width();B+=a(this).height()});if(b.tickerDirection=="prev"&&b.mode=="horizontal"){e.css("left","-"+(A+y)+"px")}else if(b.tickerDirection=="prev"&&b.mode=="vertical"){e.css("top","-"+(B+z)+"px")}if(b.mode=="horizontal"){C=parseInt(e.css("left"));L(C,A,b.tickerSpeed)}else if(b.mode=="vertical"){D=parseInt(e.css("top"));L(D,B,b.tickerSpeed)}if(b.tickerHover){O()}}}function J(){if(b.nextImage!=""){nextContent=b.nextImage;nextType="image"}else{nextContent=b.nextText;nextType="text"}if(b.prevImage!=""){prevContent=b.prevImage;prevType="image"}else{prevContent=b.prevText;prevType="text"}R(nextType,nextContent,prevType,prevContent)}function I(){if(b.mode=="horizontal"||b.mode=="vertical"){var c=Z(g,0,b.moveSlideQty,"backward");a.each(c,function(b){e.prepend(a(this))});var d=g.length+b.moveSlideQty-1;var f=g.length-b.displaySlideQty;var h=d-f;var i=Z(g,0,h,"forward");if(b.infiniteLoop){a.each(i,function(b){e.append(a(this))})}}}function H(){I(b.startingSlide);if(b.mode=="horizontal"){e.wrap('<div class="'+b.wrapperClass+'" style="width:'+l+'px; position:relative;"></div>').wrap('<div class="bx-window" style="position:relative; overflow:hidden; width:'+l+'px;"></div>').css({width:"999999px",position:"relative",left:"-"+y+"px"});e.children().css({width:j,"float":"left",listStyle:"none"});h=e.parent().parent();g.addClass("pager")}else if(b.mode=="vertical"){e.wrap('<div class="'+b.wrapperClass+'" style="width:'+v+'px; position:relative;"></div>').wrap('<div class="bx-window" style="width:'+v+"px; height:"+m+'px; position:relative; overflow:hidden;"></div>').css({height:"999999px",position:"relative",top:"-"+z+"px"});e.children().css({listStyle:"none",height:w});h=e.parent().parent();g.addClass("pager")}else if(b.mode=="fade"){e.wrap('<div class="'+b.wrapperClass+'" style="width:'+v+'px; position:relative;"></div>').wrap('<div class="bx-window" style="height:'+w+"px; width:"+v+'px; position:relative; overflow:hidden;"></div>');e.children().css({listStyle:"none",position:"absolute",top:0,left:0,zIndex:98});h=e.parent().parent();g.not(":eq("+x+")").fadeTo(0,0);g.eq(x).css("zIndex",99)}if(b.captions&&b.captionsSelector==null){h.append('<div class="bx-captions"></div>')}}var c={mode:"horizontal",infiniteLoop:true,hideControlOnEnd:false,controls:true,speed:500,easing:"swing",pager:false,pagerSelector:null,pagerType:"full",pagerLocation:"bottom",pagerShortSeparator:"/",pagerActiveClass:"pager-active",nextText:"next",nextImage:"",nextSelector:null,prevText:"prev",prevImage:"",prevSelector:null,captions:false,captionsSelector:null,auto:false,autoDirection:"next",autoControls:false,autoControlsSelector:null,autoStart:true,autoHover:false,autoDelay:0,pause:3e3,startText:"start",startImage:"",stopText:"stop",stopImage:"",ticker:false,tickerSpeed:5e3,tickerDirection:"next",tickerHover:false,wrapperClass:"bx-wrapper",startingSlide:0,displaySlideQty:1,moveSlideQty:1,randomStart:false,onBeforeSlide:function(){},onAfterSlide:function(){},onLastSlide:function(){},onFirstSlide:function(){},onNextSlide:function(){},onPrevSlide:function(){},buildPager:null};var b=a.extend(c,b);var d=this;var e="";var f="";var g="";var h="";var i="";var j="";var k="";var l="";var m="";var n="";var o="";var p="";var q="";var r="";var s="";var t=true;var u=false;var v=0;var w=0;var x=0;var y=0;var z=0;var A=0;var B=0;var C=0;var D=0;var E=false;var F=0;var G=g.length-1;this.goToSlide=function(a,c){if(!E){E=true;x=a;b.onBeforeSlide(x,g.length,g.eq(x));if(typeof c=="undefined"){var c=true}if(c){if(b.auto){d.stopShow(true)}}slide=a;if(slide==F){b.onFirstSlide(x,g.length,g.eq(x))}if(slide==G){b.onLastSlide(x,g.length,g.eq(x))}if(b.mode=="horizontal"){e.animate({left:"-"+W(slide,"left")+"px"},b.speed,b.easing,function(){E=false;b.onAfterSlide(x,g.length,g.eq(x))})}else if(b.mode=="vertical"){e.animate({top:"-"+W(slide,"top")+"px"},b.speed,b.easing,function(){E=false;b.onAfterSlide(x,g.length,g.eq(x))})}else if(b.mode=="fade"){P()}V();if(b.moveSlideQty>1){a=Math.floor(a/b.moveSlideQty)}Q(a);T()}};this.goToNextSlide=function(a){if(typeof a=="undefined"){var a=true}if(a){if(b.auto){d.stopShow(true)}}if(!b.infiniteLoop){if(!E){var c=false;x=x+b.moveSlideQty;if(x<=G){V();b.onNextSlide(x,g.length,g.eq(x));d.goToSlide(x)}else{x-=b.moveSlideQty}}}else{if(!E){E=true;var c=false;x=x+b.moveSlideQty;if(x>G){x=x%g.length;c=true}b.onNextSlide(x,g.length,g.eq(x));b.onBeforeSlide(x,g.length,g.eq(x));if(b.mode=="horizontal"){var f=b.moveSlideQty*k;e.animate({left:"-="+f+"px"},b.speed,b.easing,function(){E=false;if(c){e.css("left","-"+W(x,"left")+"px")}b.onAfterSlide(x,g.length,g.eq(x))})}else if(b.mode=="vertical"){var h=b.moveSlideQty*w;e.animate({top:"-="+h+"px"},b.speed,b.easing,function(){E=false;if(c){e.css("top","-"+W(x,"top")+"px")}b.onAfterSlide(x,g.length,g.eq(x))})}else if(b.mode=="fade"){P()}if(b.moveSlideQty>1){Q(Math.ceil(x/b.moveSlideQty))}else{Q(x)}T()}}};this.goToPreviousSlide=function(c){if(typeof c=="undefined"){var c=true}if(c){if(b.auto){d.stopShow(true)}}if(!b.infiniteLoop){if(!E){var f=false;x=x-b.moveSlideQty;if(x<0){x=0;if(b.hideControlOnEnd){a(".bx-prev",h).hide()}}V();b.onPrevSlide(x,g.length,g.eq(x));d.goToSlide(x)}}else{if(!E){E=true;var f=false;x=x-b.moveSlideQty;if(x<0){negativeOffset=x%g.length;if(negativeOffset==0){x=0}else{x=g.length+negativeOffset}f=true}b.onPrevSlide(x,g.length,g.eq(x));b.onBeforeSlide(x,g.length,g.eq(x));if(b.mode=="horizontal"){var i=b.moveSlideQty*k;e.animate({left:"+="+i+"px"},b.speed,b.easing,function(){E=false;if(f){e.css("left","-"+W(x,"left")+"px")}b.onAfterSlide(x,g.length,g.eq(x))})}else if(b.mode=="vertical"){var j=b.moveSlideQty*w;e.animate({top:"+="+j+"px"},b.speed,b.easing,function(){E=false;if(f){e.css("top","-"+W(x,"top")+"px")}b.onAfterSlide(x,g.length,g.eq(x))})}else if(b.mode=="fade"){P()}if(b.moveSlideQty>1){Q(Math.ceil(x/b.moveSlideQty))}else{Q(x)}T()}}};this.goToFirstSlide=function(a){if(typeof a=="undefined"){var a=true}d.goToSlide(F,a)};this.goToLastSlide=function(){if(typeof a=="undefined"){var a=true}d.goToSlide(G,a)};this.getCurrentSlide=function(){return x};this.getSlideCount=function(){return g.length};this.stopShow=function(a){clearInterval(o);if(typeof a=="undefined"){var a=true}if(a&&b.autoControls){p.html(r).removeClass("stop").addClass("start");t=false}};this.startShow=function(a){if(typeof a=="undefined"){var a=true}K();if(a&&b.autoControls){p.html(s).removeClass("start").addClass("stop");t=true}};this.stopTicker=function(a){e.stop();if(typeof a=="undefined"){var a=true}if(a&&b.ticker){p.html(r).removeClass("stop").addClass("start");t=false}};this.startTicker=function(a){if(b.mode=="horizontal"){if(b.tickerDirection=="next"){var c=parseInt(e.css("left"));var d=A+c+g.eq(0).width()}else if(b.tickerDirection=="prev"){var c=-parseInt(e.css("left"));var d=c-g.eq(0).width()}var f=d*b.tickerSpeed/A;L(C,d,f)}else if(b.mode=="vertical"){if(b.tickerDirection=="next"){var h=parseInt(e.css("top"));var d=B+h+g.eq(0).height()}else if(b.tickerDirection=="prev"){var h=-parseInt(e.css("top"));var d=h-g.eq(0).height()}var f=d*b.tickerSpeed/B;L(D,d,f);if(typeof a=="undefined"){var a=true}if(a&&b.ticker){p.html(s).removeClass("start").addClass("stop");t=true}}};this.initShow=function(){e=a(this);f=e.clone();g=e.children();h="";i=e.children(":first");j=i.width();v=0;k=i.outerWidth();w=0;l=X();m=Y();E=false;n="";x=0;y=0;z=0;o="";p="";q="";r="";s="";t=true;u=false;A=0;B=0;C=0;D=0;F=0;G=g.length-1;g.each(function(b){if(a(this).outerHeight()>w){w=a(this).outerHeight()}if(a(this).outerWidth()>v){v=a(this).outerWidth()}});if(b.randomStart){var c=Math.floor(Math.random()*g.length);x=c;y=k*(b.moveSlideQty+c);z=w*(b.moveSlideQty+c)}else{x=b.startingSlide;y=k*(b.moveSlideQty+b.startingSlide);z=w*(b.moveSlideQty+b.startingSlide)}H();if(b.pager&&!b.ticker){if(b.pagerType=="full"){S("full")}else if(b.pagerType=="short"){S("short")}}if(b.controls&&!b.ticker){J()}if(b.auto||b.ticker){if(b.autoControls){M()}if(b.autoStart){setTimeout(function(){d.startShow(true)},b.autoDelay)}else{d.stopShow(true)}if(b.autoHover&&!b.ticker){N()}}if(b.moveSlideQty>1){Q(Math.ceil(x/b.moveSlideQty))}else{Q(x)}V();if(b.captions){T()}b.onAfterSlide(x,g.length,g.eq(x))};this.destroyShow=function(){clearInterval(o);a(".bx-next, .bx-prev, .bx-pager, .bx-auto",h).remove();e.unwrap().unwrap().removeAttr("style");e.children().removeAttr("style").not(".pager").remove();g.removeClass("pager")};this.reloadShow=function(){d.destroyShow();d.initShow()};this.each(function(){if(a(this).children().length>0){d.initShow()}});return this};jQuery.fx.prototype.cur=function(){if(this.elem[this.prop]!=null&&(!this.elem.style||this.elem.style[this.prop]==null)){return this.elem[this.prop]}var a=parseFloat(jQuery.css(this.elem,this.prop));return a}})(jQuery)
*/

//http://localhost/kobstereshop/themes/theme335/js/feedback.js
var ajaxLoaderOn = 0;
var ajaxQueries = new Array();
var feedbackDivStatus = 0;

$(document).ready(function() {
    jQuery(".pull_feedback").toggle(function() {
            if (feedbackDivStatus == 0) {
                jQuery("#feedback").animate({
                    left: "0px"
                });
                feedbackDivStatus = 1;
                return false;
            } else {
                jQuery("#feedback").animate({
                    left: "-380px"
                });
                feedbackDivStatus = 0;
                return false;
            }
        },
        function() {
            if (feedbackDivStatus == 1) {
                jQuery("#feedback").animate({
                    left: "-380px"
                });
                feedbackDivStatus = 0;
                return false;
            } else {
                jQuery("#feedback").animate({
                    left: "0px"
                });
                feedbackDivStatus = 1;
                return false;
            }
        }
    ); //toggle

    // Click on submit feedback
    $('#feedback input[type=button]').live('click', function() {
        submitFeedback();
    });

    function submitFeedback(params_plus) {
        var name = $("input#name").val();
        var email = $("input#email").val();
        var message = $("#message").val();

        //Validation
        if (name == "") {
            $("input#name").focus();
            $('#feedback_error').replaceWith('<p id="feedback_error">Name is required</p>');
            return false;
        }
        if (email == "") {
            $("input#email").focus();
            $('#feedback_error').replaceWith('<p id="feedback_error">Email is required</p>');
            return false;
        } else {
            var atpos = email.indexOf("@");
            var dotpos = email.lastIndexOf(".");
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
                $("input#email").focus();
                $('#feedback_error').replaceWith('<p id="feedback_error">Oops, that appears to be an invalid email!</p>');
                return false;
            }
        }

        if (message == "") {
            $("message").focus();
            $('#feedback_error').replaceWith('<p id="feedback_error">Your Message is blank</p>');
            return false;
        }

        var data = 'name=' + name + '&email=' + email + '&message=' + message;

        if (ajaxLoaderOn == 0) {
            $('#feedback_res').prepend($('#feedback_ajax_loader').html());
            $('#feedback').css('opacity', '0.9');
            ajaxLoaderOn = 1;
        }

        $.ajax({
            type: 'POST',
            url: baseDir + 'feedback-ajax.php',
            data: data,
            dataType: 'json',
            cache: false,
            success: function(result) {
                if (result.feedback_confirmation == 1) {

                    var res = '<div id="feedback_res">' +
                        '<p class="feedback_res">Thank you for your feedback! <br />' +
                        'We appreciate the time you took out for this.</p>' +
                        '</div>';

                    $('#feedback_res').replaceWith(res);

                    $('#feedback').css('opacity', '1');
                    ajaxLoaderOn = 0;
                    if ($.browser.msie) // Fix bug with IE8 and aliasing
                        $('#feedback').css('filter', '');
                } else {
                    var res = '<div id="feedback_res">' +
                        '<p class="feedback_res">Oops, there seems to be problem! <br />' +
                        'Please try again latter or drop a mail at feedback@kobster.com</p>' +
                        '</div>';

                    $('#feedback_res').replaceWith(res);

                    $('#feedback').css('opacity', '1');
                    ajaxLoaderOn = 0;
                    if ($.browser.msie) // Fix bug with IE8 and aliasing
                        $('#feedback').css('filter', '');
                }
            }
        });
    }
}); //document.ready



/*  http://localhost/kobstereshop/themes/theme335/js/jquery.carouFredSel-6.1.0-packed.js
 *	jQuery carouFredSel 6.1.0
 *	Demo's and documentation:
 *	caroufredsel.frebsite.nl
 *
 *	Copyright (c) 2012 Fred Heusschen
 *	www.frebsite.nl
 *
 *	Dual licensed under the MIT and GPL licenses.
 *	http://en.wikipedia.org/wiki/MIT_License
 *	http://en.wikipedia.org/wiki/GNU_General_Public_License
 */


(function($) {
    if ($.fn.carouFredSel) {
        return
    }
    $.fn.caroufredsel = $.fn.carouFredSel = function(u, w) {
        if (this.length == 0) {
            debug(true, 'No element found for "' + this.selector + '".');
            return this
        }
        if (this.length > 1) {
            return this.each(function() {
                $(this).carouFredSel(u, w)
            })
        }
        var y = this,
            $tt0 = this[0],
            starting_position = false;
        if (y.data('_cfs_isCarousel')) {
            starting_position = y.triggerHandler('_cfs_triggerEvent', 'currentPosition');
            y.trigger('_cfs_triggerEvent', ['destroy', true])
        }
        y._cfs_init = function(o, a, b) {
            o = go_getObject($tt0, o);
            o.items = go_getItemsObject($tt0, o.items);
            o.scroll = go_getScrollObject($tt0, o.scroll);
            o.auto = go_getAutoObject($tt0, o.auto);
            o.prev = go_getPrevNextObject($tt0, o.prev);
            o.next = go_getPrevNextObject($tt0, o.next);
            o.pagination = go_getPaginationObject($tt0, o.pagination);
            o.swipe = go_getSwipeObject($tt0, o.swipe);
            o.mousewheel = go_getMousewheelObject($tt0, o.mousewheel);
            if (a) {
                opts_orig = $.extend(true, {}, $.fn.carouFredSel.defaults, o)
            }
            opts = $.extend(true, {}, $.fn.carouFredSel.defaults, o);
            opts.d = cf_getDimensions(opts);
            z.direction = (opts.direction == 'up' || opts.direction == 'left') ? 'next' : 'prev';
            var c = y.children(),
                avail_primary = ms_getParentSize($wrp, opts, 'width');
            if (is_true(opts.cookie)) {
                opts.cookie = 'caroufredsel_cookie_' + conf.serialNumber
            }
            opts.maxDimension = ms_getMaxDimension(opts, avail_primary);
            opts.items = in_complementItems(opts.items, opts, c, b);
            opts[opts.d['width']] = in_complementPrimarySize(opts[opts.d['width']], opts, c);
            opts[opts.d['height']] = in_complementSecondarySize(opts[opts.d['height']], opts, c);
            if (opts.responsive) {
                if (!is_percentage(opts[opts.d['width']])) {
                    opts[opts.d['width']] = '100%'
                }
            }
            if (is_percentage(opts[opts.d['width']])) {
                z.upDateOnWindowResize = true;
                z.primarySizePercentage = opts[opts.d['width']];
                opts[opts.d['width']] = ms_getPercentage(avail_primary, z.primarySizePercentage);
                if (!opts.items.visible) {
                    opts.items.visibleConf.variable = true
                }
            }
            if (opts.responsive) {
                opts.usePadding = false;
                opts.padding = [0, 0, 0, 0];
                opts.align = false;
                opts.items.visibleConf.variable = false
            } else {
                if (!opts.items.visible) {
                    opts = in_complementVisibleItems(opts, avail_primary)
                }
                if (!opts[opts.d['width']]) {
                    if (!opts.items.visibleConf.variable && is_number(opts.items[opts.d['width']]) && opts.items.filter == '*') {
                        opts[opts.d['width']] = opts.items.visible * opts.items[opts.d['width']];
                        opts.align = false
                    } else {
                        opts[opts.d['width']] = 'variable'
                    }
                }
                if (is_undefined(opts.align)) {
                    opts.align = (is_number(opts[opts.d['width']])) ? 'center' : false
                }
                if (opts.items.visibleConf.variable) {
                    opts.items.visible = gn_getVisibleItemsNext(c, opts, 0)
                }
            }
            if (opts.items.filter != '*' && !opts.items.visibleConf.variable) {
                opts.items.visibleConf.org = opts.items.visible;
                opts.items.visible = gn_getVisibleItemsNextFilter(c, opts, 0)
            }
            opts.items.visible = cf_getItemsAdjust(opts.items.visible, opts, opts.items.visibleConf.adjust, $tt0);
            opts.items.visibleConf.old = opts.items.visible;
            if (opts.responsive) {
                if (!opts.items.visibleConf.min) {
                    opts.items.visibleConf.min = opts.items.visible
                }
                if (!opts.items.visibleConf.max) {
                    opts.items.visibleConf.max = opts.items.visible
                }
                opts = in_getResponsiveValues(opts, c, avail_primary)
            } else {
                opts.padding = cf_getPadding(opts.padding);
                if (opts.align == 'top') {
                    opts.align = 'left'
                } else if (opts.align == 'bottom') {
                    opts.align = 'right'
                }
                switch (opts.align) {
                    case 'center':
                    case 'left':
                    case 'right':
                        if (opts[opts.d['width']] != 'variable') {
                            opts = in_getAlignPadding(opts, c);
                            opts.usePadding = true
                        }
                        break;
                    default:
                        opts.align = false;
                        opts.usePadding = (opts.padding[0] == 0 && opts.padding[1] == 0 && opts.padding[2] == 0 && opts.padding[3] == 0) ? false : true;
                        break
                }
            }
            if (!is_number(opts.scroll.duration)) {
                opts.scroll.duration = 500
            }
            if (is_undefined(opts.scroll.items)) {
                opts.scroll.items = (opts.responsive || opts.items.visibleConf.variable || opts.items.filter != '*') ? 'visible' : opts.items.visible
            }
            opts.auto = $.extend(true, {}, opts.scroll, opts.auto);
            opts.prev = $.extend(true, {}, opts.scroll, opts.prev);
            opts.next = $.extend(true, {}, opts.scroll, opts.next);
            opts.pagination = $.extend(true, {}, opts.scroll, opts.pagination);
            opts.auto = go_complementAutoObject($tt0, opts.auto);
            opts.prev = go_complementPrevNextObject($tt0, opts.prev);
            opts.next = go_complementPrevNextObject($tt0, opts.next);
            opts.pagination = go_complementPaginationObject($tt0, opts.pagination);
            opts.swipe = go_complementSwipeObject($tt0, opts.swipe);
            opts.mousewheel = go_complementMousewheelObject($tt0, opts.mousewheel);
            if (opts.synchronise) {
                opts.synchronise = cf_getSynchArr(opts.synchronise)
            }
            if (opts.auto.onPauseStart) {
                opts.auto.onTimeoutStart = opts.auto.onPauseStart;
                deprecated('auto.onPauseStart', 'auto.onTimeoutStart')
            }
            if (opts.auto.onPausePause) {
                opts.auto.onTimeoutPause = opts.auto.onPausePause;
                deprecated('auto.onPausePause', 'auto.onTimeoutPause')
            }
            if (opts.auto.onPauseEnd) {
                opts.auto.onTimeoutEnd = opts.auto.onPauseEnd;
                deprecated('auto.onPauseEnd', 'auto.onTimeoutEnd')
            }
            if (opts.auto.pauseDuration) {
                opts.auto.timeoutDuration = opts.auto.pauseDuration;
                deprecated('auto.pauseDuration', 'auto.timeoutDuration')
            }
        };
        y._cfs_build = function() {
            y.data('_cfs_isCarousel', true);
            var a = y.children(),
                orgCSS = in_mapCss(y, ['textAlign', 'float', 'position', 'top', 'right', 'bottom', 'left', 'zIndex', 'width', 'height', 'marginTop', 'marginRight', 'marginBottom', 'marginLeft']),
                newPosition = 'relative';
            switch (orgCSS.position) {
                case 'absolute':
                case 'fixed':
                    newPosition = orgCSS.position;
                    break
            }
            $wrp.css(orgCSS).css({
                'overflow': 'hidden',
                'position': newPosition
            });
            y.data('_cfs_origCss', orgCSS).css({
                'textAlign': 'left',
                'float': 'none',
                'position': 'absolute',
                'top': 0,
                'right': 'auto',
                'bottom': 'auto',
                'left': 0,
                'marginTop': 0,
                'marginRight': 0,
                'marginBottom': 0,
                'marginLeft': 0
            });
            sz_storeMargin(a, opts);
            sz_storeSizes(a, opts);
            if (opts.responsive) {
                sz_setResponsiveSizes(opts, a)
            }
        };
        y._cfs_bind_events = function() {
            y._cfs_unbind_events();
            y.bind(cf_e('stop', conf), function(e, a) {
                e.stopPropagation();
                if (!z.isStopped) {
                    if (opts.auto.button) {
                        opts.auto.button.addClass(cf_c('stopped', conf))
                    }
                }
                z.isStopped = true;
                if (opts.auto.play) {
                    opts.auto.play = false;
                    y.trigger(cf_e('pause', conf), a)
                }
                return true
            });
            y.bind(cf_e('finish', conf), function(e) {
                e.stopPropagation();
                if (z.isScrolling) {
                    sc_stopScroll(scrl)
                }
                return true
            });
            y.bind(cf_e('pause', conf), function(e, a, b) {
                e.stopPropagation();
                tmrs = sc_clearTimers(tmrs);
                if (a && z.isScrolling) {
                    scrl.isStopped = true;
                    var c = getTime() - scrl.startTime;
                    scrl.duration -= c;
                    if (scrl.pre) {
                        scrl.pre.duration -= c
                    }
                    if (scrl.post) {
                        scrl.post.duration -= c
                    }
                    sc_stopScroll(scrl, false)
                }
                if (!z.isPaused && !z.isScrolling) {
                    if (b) {
                        tmrs.timePassed += getTime() - tmrs.startTime
                    }
                }
                if (!z.isPaused) {
                    if (opts.auto.button) {
                        opts.auto.button.addClass(cf_c('paused', conf))
                    }
                }
                z.isPaused = true;
                if (opts.auto.onTimeoutPause) {
                    var d = opts.auto.timeoutDuration - tmrs.timePassed,
                        perc = 100 - Math.ceil(d * 100 / opts.auto.timeoutDuration);
                    opts.auto.onTimeoutPause.call($tt0, perc, d)
                }
                return true
            });
            y.bind(cf_e('play', conf), function(e, b, c, d) {
                e.stopPropagation();
                tmrs = sc_clearTimers(tmrs);
                var v = [b, c, d],
                    t = ['string', 'number', 'boolean'],
                    a = cf_sortParams(v, t);
                b = a[0];
                c = a[1];
                d = a[2];
                if (b != 'prev' && b != 'next') {
                    b = z.direction
                }
                if (!is_number(c)) {
                    c = 0
                }
                if (!is_boolean(d)) {
                    d = false
                }
                if (d) {
                    z.isStopped = false;
                    opts.auto.play = true
                }
                if (!opts.auto.play) {
                    e.stopImmediatePropagation();
                    return debug(conf, 'Carousel stopped: Not scrolling.')
                }
                if (z.isPaused) {
                    if (opts.auto.button) {
                        opts.auto.button.removeClass(cf_c('stopped', conf));
                        opts.auto.button.removeClass(cf_c('paused', conf))
                    }
                }
                z.isPaused = false;
                tmrs.startTime = getTime();
                var f = opts.auto.timeoutDuration + c;
                dur2 = f - tmrs.timePassed;
                perc = 100 - Math.ceil(dur2 * 100 / f);
                if (opts.auto.progress) {
                    tmrs.progress = setInterval(function() {
                        var a = getTime() - tmrs.startTime + tmrs.timePassed,
                            perc = Math.ceil(a * 100 / f);
                        opts.auto.progress.updater.call(opts.auto.progress.bar[0], perc)
                    }, opts.auto.progress.interval)
                }
                tmrs.auto = setTimeout(function() {
                    if (opts.auto.progress) {
                        opts.auto.progress.updater.call(opts.auto.progress.bar[0], 100)
                    }
                    if (opts.auto.onTimeoutEnd) {
                        opts.auto.onTimeoutEnd.call($tt0, perc, dur2)
                    }
                    if (z.isScrolling) {
                        y.trigger(cf_e('play', conf), b)
                    } else {
                        y.trigger(cf_e(b, conf), opts.auto)
                    }
                }, dur2);
                if (opts.auto.onTimeoutStart) {
                    opts.auto.onTimeoutStart.call($tt0, perc, dur2)
                }
                return true
            });
            y.bind(cf_e('resume', conf), function(e) {
                e.stopPropagation();
                if (scrl.isStopped) {
                    scrl.isStopped = false;
                    z.isPaused = false;
                    z.isScrolling = true;
                    scrl.startTime = getTime();
                    sc_startScroll(scrl)
                } else {
                    y.trigger(cf_e('play', conf))
                }
                return true
            });
            y.bind(cf_e('prev', conf) + ' ' + cf_e('next', conf), function(e, b, f, g, h) {
                e.stopPropagation();
                if (z.isStopped || y.is(':hidden')) {
                    e.stopImmediatePropagation();
                    return debug(conf, 'Carousel stopped or hidden: Not scrolling.')
                }
                var i = (is_number(opts.items.minimum)) ? opts.items.minimum : opts.items.visible + 1;
                if (i > itms.total) {
                    e.stopImmediatePropagation();
                    return debug(conf, 'Not enough items (' + itms.total + ' total, ' + i + ' needed): Not scrolling.')
                }
                var v = [b, f, g, h],
                    t = ['object', 'number/string', 'function', 'boolean'],
                    a = cf_sortParams(v, t);
                b = a[0];
                f = a[1];
                g = a[2];
                h = a[3];
                var k = e.type.slice(conf.events.prefix.length);
                if (!is_object(b)) {
                    b = {}
                }
                if (is_function(g)) {
                    b.onAfter = g
                }
                if (is_boolean(h)) {
                    b.queue = h
                }
                b = $.extend(true, {}, opts[k], b);
                if (b.conditions && !b.conditions.call($tt0, k)) {
                    e.stopImmediatePropagation();
                    return debug(conf, 'Callback "conditions" returned false.')
                }
                if (!is_number(f)) {
                    if (opts.items.filter != '*') {
                        f = 'visible'
                    } else {
                        var m = [f, b.items, opts[k].items];
                        for (var a = 0, l = m.length; a < l; a++) {
                            if (is_number(m[a]) || m[a] == 'page' || m[a] == 'visible') {
                                f = m[a];
                                break
                            }
                        }
                    }
                    switch (f) {
                        case 'page':
                            e.stopImmediatePropagation();
                            return y.triggerHandler(cf_e(k + 'Page', conf), [b, g]);
                            break;
                        case 'visible':
                            if (!opts.items.visibleConf.variable && opts.items.filter == '*') {
                                f = opts.items.visible
                            }
                            break
                    }
                }
                if (scrl.isStopped) {
                    y.trigger(cf_e('resume', conf));
                    y.trigger(cf_e('queue', conf), [k, [b, f, g]]);
                    e.stopImmediatePropagation();
                    return debug(conf, 'Carousel resumed scrolling.')
                }
                if (b.duration > 0) {
                    if (z.isScrolling) {
                        if (b.queue) {
                            if (b.queue == 'last') {
                                queu = []
                            }
                            if (b.queue != 'first' || queu.length == 0) {
                                y.trigger(cf_e('queue', conf), [k, [b, f, g]])
                            }
                        }
                        e.stopImmediatePropagation();
                        return debug(conf, 'Carousel currently scrolling.')
                    }
                }
                tmrs.timePassed = 0;
                y.trigger(cf_e('slide_' + k, conf), [b, f]);
                if (opts.synchronise) {
                    var s = opts.synchronise,
                        c = [b, f];
                    for (var j = 0, l = s.length; j < l; j++) {
                        var d = k;
                        if (!s[j][2]) {
                            d = (d == 'prev') ? 'next' : 'prev'
                        }
                        if (!s[j][1]) {
                            c[0] = s[j][0].triggerHandler('_cfs_triggerEvent', ['configuration', d])
                        }
                        c[1] = f + s[j][3];
                        s[j][0].trigger('_cfs_triggerEvent', ['slide_' + d, c])
                    }
                }
                return true
            });
            y.bind(cf_e('slide_prev', conf), function(e, b, c) {
                e.stopPropagation();
                var d = y.children();
                if (!opts.circular) {
                    if (itms.first == 0) {
                        if (opts.infinite) {
                            y.trigger(cf_e('next', conf), itms.total - 1)
                        }
                        return e.stopImmediatePropagation()
                    }
                }
                sz_resetMargin(d, opts);
                if (!is_number(c)) {
                    if (opts.items.visibleConf.variable) {
                        c = gn_getVisibleItemsPrev(d, opts, itms.total - 1)
                    } else if (opts.items.filter != '*') {
                        var f = (is_number(b.items)) ? b.items : gn_getVisibleOrg(y, opts);
                        c = gn_getScrollItemsPrevFilter(d, opts, itms.total - 1, f)
                    } else {
                        c = opts.items.visible
                    }
                    c = cf_getAdjust(c, opts, b.items, $tt0)
                }
                if (!opts.circular) {
                    if (itms.total - c < itms.first) {
                        c = itms.total - itms.first
                    }
                }
                opts.items.visibleConf.old = opts.items.visible;
                if (opts.items.visibleConf.variable) {
                    var g = cf_getItemsAdjust(gn_getVisibleItemsNext(d, opts, itms.total - c), opts, opts.items.visibleConf.adjust, $tt0);
                    if (opts.items.visible + c <= g && c < itms.total) {
                        c++;
                        g = cf_getItemsAdjust(gn_getVisibleItemsNext(d, opts, itms.total - c), opts, opts.items.visibleConf.adjust, $tt0)
                    }
                    opts.items.visible = g
                } else if (opts.items.filter != '*') {
                    var g = gn_getVisibleItemsNextFilter(d, opts, itms.total - c);
                    opts.items.visible = cf_getItemsAdjust(g, opts, opts.items.visibleConf.adjust, $tt0)
                }
                sz_resetMargin(d, opts, true);
                if (c == 0) {
                    e.stopImmediatePropagation();
                    return debug(conf, '0 items to scroll: Not scrolling.')
                }
                debug(conf, 'Scrolling ' + c + ' items backward.');
                itms.first += c;
                while (itms.first >= itms.total) {
                    itms.first -= itms.total
                }
                if (!opts.circular) {
                    if (itms.first == 0 && b.onEnd) {
                        b.onEnd.call($tt0, 'prev')
                    }
                    if (!opts.infinite) {
                        nv_enableNavi(opts, itms.first, conf)
                    }
                }
                y.children().slice(itms.total - c, itms.total).prependTo(y);
                if (itms.total < opts.items.visible + c) {
                    y.children().slice(0, (opts.items.visible + c) - itms.total).clone(true).appendTo(y)
                }
                var d = y.children(),
                    i_old = gi_getOldItemsPrev(d, opts, c),
                    i_new = gi_getNewItemsPrev(d, opts),
                    i_cur_l = d.eq(c - 1),
                    i_old_l = i_old.last(),
                    i_new_l = i_new.last();
                sz_resetMargin(d, opts);
                var h = 0,
                    pR = 0;
                if (opts.align) {
                    var p = cf_getAlignPadding(i_new, opts);
                    h = p[0];
                    pR = p[1]
                }
                var i = (h < 0) ? opts.padding[opts.d[3]] : 0;
                var j = false,
                    i_skp = $();
                if (opts.items.visible < c) {
                    i_skp = d.slice(opts.items.visibleConf.old, c);
                    if (b.fx == 'directscroll') {
                        var k = opts.items[opts.d['width']];
                        j = i_skp;
                        i_cur_l = i_new_l;
                        sc_hideHiddenItems(j);
                        opts.items[opts.d['width']] = 'variable'
                    }
                }
                var l = false,
                    i_siz = ms_getTotalSize(d.slice(0, c), opts, 'width'),
                    w_siz = cf_mapWrapperSizes(ms_getSizes(i_new, opts, true), opts, !opts.usePadding),
                    i_siz_vis = 0,
                    a_cfs = {},
                    a_wsz = {},
                    a_cur = {},
                    a_old = {},
                    a_new = {},
                    a_lef = {},
                    a_lef_vis = {},
                    a_dur = sc_getDuration(b, opts, c, i_siz);
                switch (b.fx) {
                    case 'cover':
                    case 'cover-fade':
                        i_siz_vis = ms_getTotalSize(d.slice(0, opts.items.visible), opts, 'width');
                        break
                }
                if (j) {
                    opts.items[opts.d['width']] = k
                }
                sz_resetMargin(d, opts, true);
                if (pR >= 0) {
                    sz_resetMargin(i_old_l, opts, opts.padding[opts.d[1]])
                }
                if (h >= 0) {
                    sz_resetMargin(i_cur_l, opts, opts.padding[opts.d[3]])
                }
                if (opts.align) {
                    opts.padding[opts.d[1]] = pR;
                    opts.padding[opts.d[3]] = h
                }
                a_lef[opts.d['left']] = -(i_siz - i);
                a_lef_vis[opts.d['left']] = -(i_siz_vis - i);
                a_wsz[opts.d['left']] = w_siz[opts.d['width']];
                var m = function() {},
                    _a_wrapper = function() {},
                    _s_paddingold = function() {},
                    _a_paddingold = function() {},
                    _s_paddingnew = function() {},
                    _a_paddingnew = function() {},
                    _s_paddingcur = function() {},
                    _a_paddingcur = function() {},
                    _onafter = function() {},
                    _moveitems = function() {},
                    _position = function() {};
                switch (b.fx) {
                    case 'crossfade':
                    case 'cover':
                    case 'cover-fade':
                    case 'uncover':
                    case 'uncover-fade':
                        l = y.clone(true).appendTo($wrp);
                        break
                }
                switch (b.fx) {
                    case 'crossfade':
                    case 'uncover':
                    case 'uncover-fade':
                        l.children().slice(0, c).remove();
                        l.children().slice(opts.items.visibleConf.old).remove();
                        break;
                    case 'cover':
                    case 'cover-fade':
                        l.children().slice(opts.items.visible).remove();
                        l.css(a_lef_vis);
                        break
                }
                y.css(a_lef);
                scrl = sc_setScroll(a_dur, b.easing);
                a_cfs[opts.d['left']] = (opts.usePadding) ? opts.padding[opts.d[3]] : 0;
                if (opts[opts.d['width']] == 'variable' || opts[opts.d['height']] == 'variable') {
                    m = function() {
                        $wrp.css(w_siz)
                    };
                    _a_wrapper = function() {
                        scrl.anims.push([$wrp, w_siz])
                    }
                }
                if (opts.usePadding) {
                    if (i_new_l.not(i_cur_l).length) {
                        a_cur[opts.d['marginRight']] = i_cur_l.data('_cfs_origCssMargin');
                        if (h < 0) {
                            i_cur_l.css(a_cur)
                        } else {
                            _s_paddingcur = function() {
                                i_cur_l.css(a_cur)
                            };
                            _a_paddingcur = function() {
                                scrl.anims.push([i_cur_l, a_cur])
                            }
                        }
                    }
                    switch (b.fx) {
                        case 'cover':
                        case 'cover-fade':
                            l.children().eq(c - 1).css(a_cur);
                            break
                    }
                    if (i_new_l.not(i_old_l).length) {
                        a_old[opts.d['marginRight']] = i_old_l.data('_cfs_origCssMargin');
                        _s_paddingold = function() {
                            i_old_l.css(a_old)
                        };
                        _a_paddingold = function() {
                            scrl.anims.push([i_old_l, a_old])
                        }
                    }
                    if (pR >= 0) {
                        a_new[opts.d['marginRight']] = i_new_l.data('_cfs_origCssMargin') + opts.padding[opts.d[1]];
                        _s_paddingnew = function() {
                            i_new_l.css(a_new)
                        };
                        _a_paddingnew = function() {
                            scrl.anims.push([i_new_l, a_new])
                        }
                    }
                }
                _position = function() {
                    y.css(a_cfs)
                };
                var n = opts.items.visible + c - itms.total;
                _moveitems = function() {
                    if (n > 0) {
                        y.children().slice(itms.total).remove();
                        i_old = $(y.children().slice(itms.total - (opts.items.visible - n)).get().concat(y.children().slice(0, n).get()))
                    }
                    sc_showHiddenItems(j);
                    if (opts.usePadding) {
                        var a = y.children().eq(opts.items.visible + c - 1);
                        a.css(opts.d['marginRight'], a.data('_cfs_origCssMargin'))
                    }
                };
                var o = sc_mapCallbackArguments(i_old, i_skp, i_new, c, 'prev', a_dur, w_siz);
                _onafter = function() {
                    sc_afterScroll(y, l, b);
                    z.isScrolling = false;
                    clbk.onAfter = sc_fireCallbacks($tt0, b, 'onAfter', o, clbk);
                    queu = sc_fireQueue(y, queu, conf);
                    if (!z.isPaused) {
                        y.trigger(cf_e('play', conf))
                    }
                };
                z.isScrolling = true;
                tmrs = sc_clearTimers(tmrs);
                clbk.onBefore = sc_fireCallbacks($tt0, b, 'onBefore', o, clbk);
                switch (b.fx) {
                    case 'none':
                        y.css(a_cfs);
                        m();
                        _s_paddingold();
                        _s_paddingnew();
                        _s_paddingcur();
                        _position();
                        _moveitems();
                        _onafter();
                        break;
                    case 'fade':
                        scrl.anims.push([y, {
                            'opacity': 0
                        }, function() {
                            m();
                            _s_paddingold();
                            _s_paddingnew();
                            _s_paddingcur();
                            _position();
                            _moveitems();
                            scrl = sc_setScroll(a_dur, b.easing);
                            scrl.anims.push([y, {
                                'opacity': 1
                            }, _onafter]);
                            sc_startScroll(scrl)
                        }]);
                        break;
                    case 'crossfade':
                        y.css({
                            'opacity': 0
                        });
                        scrl.anims.push([l, {
                            'opacity': 0
                        }]);
                        scrl.anims.push([y, {
                            'opacity': 1
                        }, _onafter]);
                        _a_wrapper();
                        _s_paddingold();
                        _s_paddingnew();
                        _s_paddingcur();
                        _position();
                        _moveitems();
                        break;
                    case 'cover':
                        scrl.anims.push([l, a_cfs, function() {
                            _s_paddingold();
                            _s_paddingnew();
                            _s_paddingcur();
                            _position();
                            _moveitems();
                            _onafter()
                        }]);
                        _a_wrapper();
                        break;
                    case 'cover-fade':
                        scrl.anims.push([y, {
                            'opacity': 0
                        }]);
                        scrl.anims.push([l, a_cfs, function() {
                            y.css({
                                'opacity': 1
                            });
                            _s_paddingold();
                            _s_paddingnew();
                            _s_paddingcur();
                            _position();
                            _moveitems();
                            _onafter()
                        }]);
                        _a_wrapper();
                        break;
                    case 'uncover':
                        scrl.anims.push([l, a_wsz, _onafter]);
                        _a_wrapper();
                        _s_paddingold();
                        _s_paddingnew();
                        _s_paddingcur();
                        _position();
                        _moveitems();
                        break;
                    case 'uncover-fade':
                        y.css({
                            'opacity': 0
                        });
                        scrl.anims.push([y, {
                            'opacity': 1
                        }]);
                        scrl.anims.push([l, a_wsz, _onafter]);
                        _a_wrapper();
                        _s_paddingold();
                        _s_paddingnew();
                        _s_paddingcur();
                        _position();
                        _moveitems();
                        break;
                    default:
                        scrl.anims.push([y, a_cfs, function() {
                            _moveitems();
                            _onafter()
                        }]);
                        _a_wrapper();
                        _a_paddingold();
                        _a_paddingnew();
                        _a_paddingcur();
                        break
                }
                sc_startScroll(scrl);
                cf_setCookie(opts.cookie, y, conf);
                y.trigger(cf_e('updatePageStatus', conf), [false, w_siz]);
                return true
            });
            y.bind(cf_e('slide_next', conf), function(e, c, d) {
                e.stopPropagation();
                var f = y.children();
                if (!opts.circular) {
                    if (itms.first == opts.items.visible) {
                        if (opts.infinite) {
                            y.trigger(cf_e('prev', conf), itms.total - 1)
                        }
                        return e.stopImmediatePropagation()
                    }
                }
                sz_resetMargin(f, opts);
                if (!is_number(d)) {
                    if (opts.items.filter != '*') {
                        var g = (is_number(c.items)) ? c.items : gn_getVisibleOrg(y, opts);
                        d = gn_getScrollItemsNextFilter(f, opts, 0, g)
                    } else {
                        d = opts.items.visible
                    }
                    d = cf_getAdjust(d, opts, c.items, $tt0)
                }
                var h = (itms.first == 0) ? itms.total : itms.first;
                if (!opts.circular) {
                    if (opts.items.visibleConf.variable) {
                        var i = gn_getVisibleItemsNext(f, opts, d),
                            g = gn_getVisibleItemsPrev(f, opts, h - 1)
                    } else {
                        var i = opts.items.visible,
                            g = opts.items.visible
                    }
                    if (d + i > h) {
                        d = h - g
                    }
                }
                opts.items.visibleConf.old = opts.items.visible;
                if (opts.items.visibleConf.variable) {
                    var i = cf_getItemsAdjust(gn_getVisibleItemsNextTestCircular(f, opts, d, h), opts, opts.items.visibleConf.adjust, $tt0);
                    while (opts.items.visible - d >= i && d < itms.total) {
                        d++;
                        i = cf_getItemsAdjust(gn_getVisibleItemsNextTestCircular(f, opts, d, h), opts, opts.items.visibleConf.adjust, $tt0)
                    }
                    opts.items.visible = i
                } else if (opts.items.filter != '*') {
                    var i = gn_getVisibleItemsNextFilter(f, opts, d);
                    opts.items.visible = cf_getItemsAdjust(i, opts, opts.items.visibleConf.adjust, $tt0)
                }
                sz_resetMargin(f, opts, true);
                if (d == 0) {
                    e.stopImmediatePropagation();
                    return debug(conf, '0 items to scroll: Not scrolling.')
                }
                debug(conf, 'Scrolling ' + d + ' items forward.');
                itms.first -= d;
                while (itms.first < 0) {
                    itms.first += itms.total
                }
                if (!opts.circular) {
                    if (itms.first == opts.items.visible && c.onEnd) {
                        c.onEnd.call($tt0, 'next')
                    }
                    if (!opts.infinite) {
                        nv_enableNavi(opts, itms.first, conf)
                    }
                }
                if (itms.total < opts.items.visible + d) {
                    y.children().slice(0, (opts.items.visible + d) - itms.total).clone(true).appendTo(y)
                }
                var f = y.children(),
                    i_old = gi_getOldItemsNext(f, opts),
                    i_new = gi_getNewItemsNext(f, opts, d),
                    i_cur_l = f.eq(d - 1),
                    i_old_l = i_old.last(),
                    i_new_l = i_new.last();
                sz_resetMargin(f, opts);
                var j = 0,
                    pR = 0;
                if (opts.align) {
                    var p = cf_getAlignPadding(i_new, opts);
                    j = p[0];
                    pR = p[1]
                }
                var k = false,
                    i_skp = $();
                if (opts.items.visibleConf.old < d) {
                    i_skp = f.slice(opts.items.visibleConf.old, d);
                    if (c.fx == 'directscroll') {
                        var l = opts.items[opts.d['width']];
                        k = i_skp;
                        i_cur_l = i_old_l;
                        sc_hideHiddenItems(k);
                        opts.items[opts.d['width']] = 'variable'
                    }
                }
                var m = false,
                    i_siz = ms_getTotalSize(f.slice(0, d), opts, 'width'),
                    w_siz = cf_mapWrapperSizes(ms_getSizes(i_new, opts, true), opts, !opts.usePadding),
                    i_siz_vis = 0,
                    a_cfs = {},
                    a_cfs_vis = {},
                    a_cur = {},
                    a_old = {},
                    a_lef = {},
                    a_dur = sc_getDuration(c, opts, d, i_siz);
                switch (c.fx) {
                    case 'uncover':
                    case 'uncover-fade':
                        i_siz_vis = ms_getTotalSize(f.slice(0, opts.items.visibleConf.old), opts, 'width');
                        break
                }
                if (k) {
                    opts.items[opts.d['width']] = l
                }
                if (opts.align) {
                    if (opts.padding[opts.d[1]] < 0) {
                        opts.padding[opts.d[1]] = 0
                    }
                }
                sz_resetMargin(f, opts, true);
                sz_resetMargin(i_old_l, opts, opts.padding[opts.d[1]]);
                if (opts.align) {
                    opts.padding[opts.d[1]] = pR;
                    opts.padding[opts.d[3]] = j
                }
                a_lef[opts.d['left']] = (opts.usePadding) ? opts.padding[opts.d[3]] : 0;
                var n = function() {},
                    _a_wrapper = function() {},
                    _s_paddingold = function() {},
                    _a_paddingold = function() {},
                    _s_paddingcur = function() {},
                    _a_paddingcur = function() {},
                    _onafter = function() {},
                    _moveitems = function() {},
                    _position = function() {};
                switch (c.fx) {
                    case 'crossfade':
                    case 'cover':
                    case 'cover-fade':
                    case 'uncover':
                    case 'uncover-fade':
                        m = y.clone(true).appendTo($wrp);
                        m.children().slice(opts.items.visibleConf.old).remove();
                        break
                }
                switch (c.fx) {
                    case 'crossfade':
                    case 'cover':
                    case 'cover-fade':
                        y.css('zIndex', 1);
                        m.css('zIndex', 0);
                        break
                }
                scrl = sc_setScroll(a_dur, c.easing);
                a_cfs[opts.d['left']] = -i_siz;
                a_cfs_vis[opts.d['left']] = -i_siz_vis;
                if (j < 0) {
                    a_cfs[opts.d['left']] += j
                }
                if (opts[opts.d['width']] == 'variable' || opts[opts.d['height']] == 'variable') {
                    n = function() {
                        $wrp.css(w_siz)
                    };
                    _a_wrapper = function() {
                        scrl.anims.push([$wrp, w_siz])
                    }
                }
                if (opts.usePadding) {
                    var o = i_new_l.data('_cfs_origCssMargin');
                    if (pR >= 0) {
                        o += opts.padding[opts.d[1]]
                    }
                    i_new_l.css(opts.d['marginRight'], o);
                    if (i_cur_l.not(i_old_l).length) {
                        a_old[opts.d['marginRight']] = i_old_l.data('_cfs_origCssMargin')
                    }
                    _s_paddingold = function() {
                        i_old_l.css(a_old)
                    };
                    _a_paddingold = function() {
                        scrl.anims.push([i_old_l, a_old])
                    };
                    var q = i_cur_l.data('_cfs_origCssMargin');
                    if (j > 0) {
                        q += opts.padding[opts.d[3]]
                    }
                    a_cur[opts.d['marginRight']] = q;
                    _s_paddingcur = function() {
                        i_cur_l.css(a_cur)
                    };
                    _a_paddingcur = function() {
                        scrl.anims.push([i_cur_l, a_cur])
                    }
                }
                _position = function() {
                    y.css(a_lef)
                };
                var r = opts.items.visible + d - itms.total;
                _moveitems = function() {
                    if (r > 0) {
                        y.children().slice(itms.total).remove()
                    }
                    var a = y.children().slice(0, d).appendTo(y).last();
                    if (r > 0) {
                        i_new = gi_getCurrentItems(f, opts)
                    }
                    sc_showHiddenItems(k);
                    if (opts.usePadding) {
                        if (itms.total < opts.items.visible + d) {
                            var b = y.children().eq(opts.items.visible - 1);
                            b.css(opts.d['marginRight'], b.data('_cfs_origCssMargin') + opts.padding[opts.d[3]])
                        }
                        a.css(opts.d['marginRight'], a.data('_cfs_origCssMargin'))
                    }
                };
                var s = sc_mapCallbackArguments(i_old, i_skp, i_new, d, 'next', a_dur, w_siz);
                _onafter = function() {
                    y.css('zIndex', y.data('_cfs_origCss').zIndex);
                    sc_afterScroll(y, m, c);
                    z.isScrolling = false;
                    clbk.onAfter = sc_fireCallbacks($tt0, c, 'onAfter', s, clbk);
                    queu = sc_fireQueue(y, queu, conf);
                    if (!z.isPaused) {
                        y.trigger(cf_e('play', conf))
                    }
                };
                z.isScrolling = true;
                tmrs = sc_clearTimers(tmrs);
                clbk.onBefore = sc_fireCallbacks($tt0, c, 'onBefore', s, clbk);
                switch (c.fx) {
                    case 'none':
                        y.css(a_cfs);
                        n();
                        _s_paddingold();
                        _s_paddingcur();
                        _position();
                        _moveitems();
                        _onafter();
                        break;
                    case 'fade':
                        scrl.anims.push([y, {
                            'opacity': 0
                        }, function() {
                            n();
                            _s_paddingold();
                            _s_paddingcur();
                            _position();
                            _moveitems();
                            scrl = sc_setScroll(a_dur, c.easing);
                            scrl.anims.push([y, {
                                'opacity': 1
                            }, _onafter]);
                            sc_startScroll(scrl)
                        }]);
                        break;
                    case 'crossfade':
                        y.css({
                            'opacity': 0
                        });
                        scrl.anims.push([m, {
                            'opacity': 0
                        }]);
                        scrl.anims.push([y, {
                            'opacity': 1
                        }, _onafter]);
                        _a_wrapper();
                        _s_paddingold();
                        _s_paddingcur();
                        _position();
                        _moveitems();
                        break;
                    case 'cover':
                        y.css(opts.d['left'], $wrp[opts.d['width']]());
                        scrl.anims.push([y, a_lef, _onafter]);
                        _a_wrapper();
                        _s_paddingold();
                        _s_paddingcur();
                        _moveitems();
                        break;
                    case 'cover-fade':
                        y.css(opts.d['left'], $wrp[opts.d['width']]());
                        scrl.anims.push([m, {
                            'opacity': 0
                        }]);
                        scrl.anims.push([y, a_lef, _onafter]);
                        _a_wrapper();
                        _s_paddingold();
                        _s_paddingcur();
                        _moveitems();
                        break;
                    case 'uncover':
                        scrl.anims.push([m, a_cfs_vis, _onafter]);
                        _a_wrapper();
                        _s_paddingold();
                        _s_paddingcur();
                        _position();
                        _moveitems();
                        break;
                    case 'uncover-fade':
                        y.css({
                            'opacity': 0
                        });
                        scrl.anims.push([y, {
                            'opacity': 1
                        }]);
                        scrl.anims.push([m, a_cfs_vis, _onafter]);
                        _a_wrapper();
                        _s_paddingold();
                        _s_paddingcur();
                        _position();
                        _moveitems();
                        break;
                    default:
                        scrl.anims.push([y, a_cfs, function() {
                            _position();
                            _moveitems();
                            _onafter()
                        }]);
                        _a_wrapper();
                        _a_paddingold();
                        _a_paddingcur();
                        break
                }
                sc_startScroll(scrl);
                cf_setCookie(opts.cookie, y, conf);
                y.trigger(cf_e('updatePageStatus', conf), [false, w_siz]);
                return true
            });
            y.bind(cf_e('slideTo', conf), function(e, b, c, d, f, g, h) {
                e.stopPropagation();
                var v = [b, c, d, f, g, h],
                    t = ['string/number/object', 'number', 'boolean', 'object', 'string', 'function'],
                    a = cf_sortParams(v, t);
                f = a[3];
                g = a[4];
                h = a[5];
                b = gn_getItemIndex(a[0], a[1], a[2], itms, y);
                if (b == 0) {
                    return false
                }
                if (!is_object(f)) {
                    f = false
                }
                if (g != 'prev' && g != 'next') {
                    if (opts.circular) {
                        g = (b <= itms.total / 2) ? 'next' : 'prev'
                    } else {
                        g = (itms.first == 0 || itms.first > b) ? 'next' : 'prev'
                    }
                }
                if (g == 'prev') {
                    b = itms.total - b
                }
                y.trigger(cf_e(g, conf), [f, b, h]);
                return true
            });
            y.bind(cf_e('prevPage', conf), function(e, a, b) {
                e.stopPropagation();
                var c = y.triggerHandler(cf_e('currentPage', conf));
                return y.triggerHandler(cf_e('slideToPage', conf), [c - 1, a, 'prev', b])
            });
            y.bind(cf_e('nextPage', conf), function(e, a, b) {
                e.stopPropagation();
                var c = y.triggerHandler(cf_e('currentPage', conf));
                return y.triggerHandler(cf_e('slideToPage', conf), [c + 1, a, 'next', b])
            });
            y.bind(cf_e('slideToPage', conf), function(e, a, b, c, d) {
                e.stopPropagation();
                if (!is_number(a)) {
                    a = y.triggerHandler(cf_e('currentPage', conf))
                }
                var f = opts.pagination.items || opts.items.visible,
                    max = Math.ceil(itms.total / f) - 1;
                if (a < 0) {
                    a = max
                }
                if (a > max) {
                    a = 0
                }
                return y.triggerHandler(cf_e('slideTo', conf), [a * f, 0, true, b, c, d])
            });
            y.bind(cf_e('jumpToStart', conf), function(e, s) {
                e.stopPropagation();
                if (s) {
                    s = gn_getItemIndex(s, 0, true, itms, y)
                } else {
                    s = 0
                }
                s += itms.first;
                if (s != 0) {
                    if (itms.total > 0) {
                        while (s > itms.total) {
                            s -= itms.total
                        }
                    }
                    y.prepend(y.children().slice(s, itms.total))
                }
                return true
            });
            y.bind(cf_e('synchronise', conf), function(e, s) {
                e.stopPropagation();
                if (s) {
                    s = cf_getSynchArr(s)
                } else if (opts.synchronise) {
                    s = opts.synchronise
                } else {
                    return debug(conf, 'No carousel to synchronise.')
                }
                var n = y.triggerHandler(cf_e('currentPosition', conf)),
                    x = true;
                for (var j = 0, l = s.length; j < l; j++) {
                    if (!s[j][0].triggerHandler(cf_e('slideTo', conf), [n, s[j][3], true])) {
                        x = false
                    }
                }
                return x
            });
            y.bind(cf_e('queue', conf), function(e, a, b) {
                e.stopPropagation();
                if (is_function(a)) {
                    a.call($tt0, queu)
                } else if (is_array(a)) {
                    queu = a
                } else if (!is_undefined(a)) {
                    queu.push([a, b])
                }
                return queu
            });
            y.bind(cf_e('insertItem', conf), function(e, b, c, d, f) {
                e.stopPropagation();
                var v = [b, c, d, f],
                    t = ['string/object', 'string/number/object', 'boolean', 'number'],
                    a = cf_sortParams(v, t);
                b = a[0];
                c = a[1];
                d = a[2];
                f = a[3];
                if (is_object(b) && !is_jquery(b)) {
                    b = $(b)
                } else if (is_string(b)) {
                    b = $(b)
                }
                if (!is_jquery(b) || b.length == 0) {
                    return debug(conf, 'Not a valid object.')
                }
                if (is_undefined(c)) {
                    c = 'end'
                }
                sz_storeMargin(b, opts);
                sz_storeSizes(b, opts);
                var g = c,
                    before = 'before';
                if (c == 'end') {
                    if (d) {
                        if (itms.first == 0) {
                            c = itms.total - 1;
                            before = 'after'
                        } else {
                            c = itms.first;
                            itms.first += b.length
                        }
                        if (c < 0) {
                            c = 0
                        }
                    } else {
                        c = itms.total - 1;
                        before = 'after'
                    }
                } else {
                    c = gn_getItemIndex(c, f, d, itms, y)
                }
                var h = y.children().eq(c);
                if (h.length) {
                    h[before](b)
                } else {
                    debug(conf, 'Correct insert-position not found! Appending item to the end.');
                    y.append(b)
                }
                if (g != 'end' && !d) {
                    if (c < itms.first) {
                        itms.first += b.length
                    }
                }
                itms.total = y.children().length;
                if (itms.first >= itms.total) {
                    itms.first -= itms.total
                }
                y.trigger(cf_e('updateSizes', conf));
                y.trigger(cf_e('linkAnchors', conf));
                return true
            });
            y.bind(cf_e('removeItem', conf), function(e, c, d, f) {
                e.stopPropagation();
                var v = [c, d, f],
                    t = ['string/number/object', 'boolean', 'number'],
                    a = cf_sortParams(v, t);
                c = a[0];
                d = a[1];
                f = a[2];
                var g = false;
                if (c instanceof $ && c.length > 1) {
                    h = $();
                    c.each(function(i, a) {
                        var b = y.trigger(cf_e('removeItem', conf), [$(this), d, f]);
                        if (b) h = h.add(b)
                    });
                    return h
                }
                if (is_undefined(c) || c == 'end') {
                    h = y.children().last()
                } else {
                    c = gn_getItemIndex(c, f, d, itms, y);
                    var h = y.children().eq(c);
                    if (h.length) {
                        if (c < itms.first) itms.first -= h.length
                    }
                }
                if (h && h.length) {
                    h.detach();
                    itms.total = y.children().length;
                    y.trigger(cf_e('updateSizes', conf))
                }
                return h
            });
            y.bind(cf_e('onBefore', conf) + ' ' + cf_e('onAfter', conf), function(e, a) {
                e.stopPropagation();
                var b = e.type.slice(conf.events.prefix.length);
                if (is_array(a)) {
                    clbk[b] = a
                }
                if (is_function(a)) {
                    clbk[b].push(a)
                }
                return clbk[b]
            });
            y.bind(cf_e('currentPosition', conf), function(e, a) {
                e.stopPropagation();
                if (itms.first == 0) {
                    var b = 0
                } else {
                    var b = itms.total - itms.first
                }
                if (is_function(a)) {
                    a.call($tt0, b)
                }
                return b
            });
            y.bind(cf_e('currentPage', conf), function(e, a) {
                e.stopPropagation();
                var b = opts.pagination.items || opts.items.visible,
                    max = Math.ceil(itms.total / b - 1),
                    nr;
                if (itms.first == 0) {
                    nr = 0
                } else if (itms.first < itms.total % b) {
                    nr = 0
                } else if (itms.first == b && !opts.circular) {
                    nr = max
                } else {
                    nr = Math.round((itms.total - itms.first) / b)
                }
                if (nr < 0) {
                    nr = 0
                }
                if (nr > max) {
                    nr = max
                }
                if (is_function(a)) {
                    a.call($tt0, nr)
                }
                return nr
            });
            y.bind(cf_e('currentVisible', conf), function(e, a) {
                e.stopPropagation();
                var b = gi_getCurrentItems(y.children(), opts);
                if (is_function(a)) {
                    a.call($tt0, b)
                }
                return b
            });
            y.bind(cf_e('slice', conf), function(e, f, l, b) {
                e.stopPropagation();
                if (itms.total == 0) {
                    return false
                }
                var v = [f, l, b],
                    t = ['number', 'number', 'function'],
                    a = cf_sortParams(v, t);
                f = (is_number(a[0])) ? a[0] : 0;
                l = (is_number(a[1])) ? a[1] : itms.total;
                b = a[2];
                f += itms.first;
                l += itms.first;
                if (items.total > 0) {
                    while (f > itms.total) {
                        f -= itms.total
                    }
                    while (l > itms.total) {
                        l -= itms.total
                    }
                    while (f < 0) {
                        f += itms.total
                    }
                    while (l < 0) {
                        l += itms.total
                    }
                }
                var c = y.children(),
                    $i;
                if (l > f) {
                    $i = c.slice(f, l)
                } else {
                    $i = $(c.slice(f, itms.total).get().concat(c.slice(0, l).get()))
                }
                if (is_function(b)) {
                    b.call($tt0, $i)
                }
                return $i
            });
            y.bind(cf_e('isPaused', conf) + ' ' + cf_e('isStopped', conf) + ' ' + cf_e('isScrolling', conf), function(e, a) {
                e.stopPropagation();
                var b = e.type.slice(conf.events.prefix.length),
                    value = z[b];
                if (is_function(a)) {
                    a.call($tt0, value)
                }
                return value
            });
            y.bind(cf_e('configuration', conf), function(e, a, b, c) {
                e.stopPropagation();
                var d = false;
                if (is_function(a)) {
                    a.call($tt0, opts)
                } else if (is_object(a)) {
                    opts_orig = $.extend(true, {}, opts_orig, a);
                    if (b !== false) d = true;
                    else opts = $.extend(true, {}, opts, a)
                } else if (!is_undefined(a)) {
                    if (is_function(b)) {
                        var f = eval('opts.' + a);
                        if (is_undefined(f)) {
                            f = ''
                        }
                        b.call($tt0, f)
                    } else if (!is_undefined(b)) {
                        if (typeof c !== 'boolean') c = true;
                        eval('opts_orig.' + a + ' = b');
                        if (c !== false) d = true;
                        else eval('opts.' + a + ' = b')
                    } else {
                        return eval('opts.' + a)
                    }
                }
                if (d) {
                    sz_resetMargin(y.children(), opts);
                    y._cfs_init(opts_orig);
                    y._cfs_bind_buttons();
                    var g = sz_setSizes(y, opts);
                    y.trigger(cf_e('updatePageStatus', conf), [true, g])
                }
                return opts
            });
            y.bind(cf_e('linkAnchors', conf), function(e, a, b) {
                e.stopPropagation();
                if (is_undefined(a)) {
                    a = $('body')
                } else if (is_string(a)) {
                    a = $(a)
                }
                if (!is_jquery(a) || a.length == 0) {
                    return debug(conf, 'Not a valid object.')
                }
                if (!is_string(b)) {
                    b = 'a.caroufredsel'
                }
                a.find(b).each(function() {
                    var h = this.hash || '';
                    if (h.length > 0 && y.children().index($(h)) != -1) {
                        $(this).unbind('click').click(function(e) {
                            e.preventDefault();
                            y.trigger(cf_e('slideTo', conf), h)
                        })
                    }
                });
                return true
            });
            y.bind(cf_e('updatePageStatus', conf), function(e, b, c) {
                e.stopPropagation();
                if (!opts.pagination.container) {
                    return
                }
                var d = opts.pagination.items || opts.items.visible,
                    pgs = Math.ceil(itms.total / d);
                if (b) {
                    if (opts.pagination.anchorBuilder) {
                        opts.pagination.container.children().remove();
                        opts.pagination.container.each(function() {
                            for (var a = 0; a < pgs; a++) {
                                var i = y.children().eq(gn_getItemIndex(a * d, 0, true, itms, y));
                                $(this).append(opts.pagination.anchorBuilder.call(i[0], a + 1))
                            }
                        })
                    }
                    opts.pagination.container.each(function() {
                        $(this).children().unbind(opts.pagination.event).each(function(a) {
                            $(this).bind(opts.pagination.event, function(e) {
                                e.preventDefault();
                                y.trigger(cf_e('slideTo', conf), [a * d, -opts.pagination.deviation, true, opts.pagination])
                            })
                        })
                    })
                }
                var f = y.triggerHandler(cf_e('currentPage', conf)) + opts.pagination.deviation;
                if (f >= pgs) {
                    f = 0
                }
                if (f < 0) {
                    f = pgs - 1
                }
                opts.pagination.container.each(function() {
                    $(this).children().removeClass(cf_c('selected', conf)).eq(f).addClass(cf_c('selected', conf))
                });
                return true
            });
            y.bind(cf_e('updateSizes', conf), function(e) {
                var a = opts.items.visible,
                    a_itm = y.children(),
                    avail_primary = ms_getParentSize($wrp, opts, 'width');
                itms.total = a_itm.length;
                if (z.primarySizePercentage) {
                    opts.maxDimension = avail_primary;
                    opts[opts.d['width']] = ms_getPercentage(avail_primary, z.primarySizePercentage)
                } else {
                    opts.maxDimension = ms_getMaxDimension(opts, avail_primary)
                }
                if (opts.responsive) {
                    opts.items.width = opts.items.sizesConf.width;
                    opts.items.height = opts.items.sizesConf.height;
                    opts = in_getResponsiveValues(opts, a_itm, avail_primary);
                    a = opts.items.visible;
                    sz_setResponsiveSizes(opts, a_itm)
                } else if (opts.items.visibleConf.variable) {
                    a = gn_getVisibleItemsNext(a_itm, opts, 0)
                } else if (opts.items.filter != '*') {
                    a = gn_getVisibleItemsNextFilter(a_itm, opts, 0)
                }
                if (!opts.circular && itms.first != 0 && a > itms.first) {
                    if (opts.items.visibleConf.variable) {
                        var b = gn_getVisibleItemsPrev(a_itm, opts, itms.first) - itms.first
                    } else if (opts.items.filter != '*') {
                        var b = gn_getVisibleItemsPrevFilter(a_itm, opts, itms.first) - itms.first
                    } else {
                        var b = opts.items.visible - itms.first
                    }
                    debug(conf, 'Preventing non-circular: sliding ' + b + ' items backward.');
                    y.trigger(cf_e('prev', conf), b)
                }
                opts.items.visible = cf_getItemsAdjust(a, opts, opts.items.visibleConf.adjust, $tt0);
                opts.items.visibleConf.old = opts.items.visible;
                opts = in_getAlignPadding(opts, a_itm);
                var c = sz_setSizes(y, opts);
                y.trigger(cf_e('updatePageStatus', conf), [true, c]);
                nv_showNavi(opts, itms.total, conf);
                nv_enableNavi(opts, itms.first, conf);
                return c
            });
            y.bind(cf_e('destroy', conf), function(e, a) {
                e.stopPropagation();
                tmrs = sc_clearTimers(tmrs);
                y.data('_cfs_isCarousel', false);
                y.trigger(cf_e('finish', conf));
                if (a) {
                    y.trigger(cf_e('jumpToStart', conf))
                }
                sz_resetMargin(y.children(), opts);
                if (opts.responsive) {
                    y.children().each(function() {
                        $(this).css($(this).data('_cfs_origCssSizes'))
                    })
                }
                y.css(y.data('_cfs_origCss'));
                y._cfs_unbind_events();
                y._cfs_unbind_buttons();
                $wrp.replaceWith(y);
                return true
            });
            y.bind(cf_e('debug', conf), function(e) {
                debug(conf, 'Carousel width: ' + opts.width);
                debug(conf, 'Carousel height: ' + opts.height);
                debug(conf, 'Item widths: ' + opts.items.width);
                debug(conf, 'Item heights: ' + opts.items.height);
                debug(conf, 'Number of items visible: ' + opts.items.visible);
                if (opts.auto.play) {
                    debug(conf, 'Number of items scrolled automatically: ' + opts.auto.items)
                }
                if (opts.prev.button) {
                    debug(conf, 'Number of items scrolled backward: ' + opts.prev.items)
                }
                if (opts.next.button) {
                    debug(conf, 'Number of items scrolled forward: ' + opts.next.items)
                }
                return conf.debug
            });
            y.bind('_cfs_triggerEvent', function(e, n, o) {
                e.stopPropagation();
                return y.triggerHandler(cf_e(n, conf), o)
            })
        };
        y._cfs_unbind_events = function() {
            y.unbind(cf_e('', conf));
            y.unbind(cf_e('', conf, false));
            y.unbind('_cfs_triggerEvent')
        };
        y._cfs_bind_buttons = function() {
            y._cfs_unbind_buttons();
            nv_showNavi(opts, itms.total, conf);
            nv_enableNavi(opts, itms.first, conf);
            if (opts.auto.pauseOnHover) {
                var b = bt_pauseOnHoverConfig(opts.auto.pauseOnHover);
                $wrp.bind(cf_e('mouseenter', conf, false), function() {
                    y.trigger(cf_e('pause', conf), b)
                }).bind(cf_e('mouseleave', conf, false), function() {
                    y.trigger(cf_e('resume', conf))
                })
            }
            if (opts.auto.button) {
                opts.auto.button.bind(cf_e(opts.auto.event, conf, false), function(e) {
                    e.preventDefault();
                    var a = false,
                        b = null;
                    if (z.isPaused) {
                        a = 'play'
                    } else if (opts.auto.pauseOnEvent) {
                        a = 'pause';
                        b = bt_pauseOnHoverConfig(opts.auto.pauseOnEvent)
                    }
                    if (a) {
                        y.trigger(cf_e(a, conf), b)
                    }
                })
            }
            if (opts.prev.button) {
                opts.prev.button.bind(cf_e(opts.prev.event, conf, false), function(e) {
                    e.preventDefault();
                    y.trigger(cf_e('prev', conf))
                });
                if (opts.prev.pauseOnHover) {
                    var b = bt_pauseOnHoverConfig(opts.prev.pauseOnHover);
                    opts.prev.button.bind(cf_e('mouseenter', conf, false), function() {
                        y.trigger(cf_e('pause', conf), b)
                    }).bind(cf_e('mouseleave', conf, false), function() {
                        y.trigger(cf_e('resume', conf))
                    })
                }
            }
            if (opts.next.button) {
                opts.next.button.bind(cf_e(opts.next.event, conf, false), function(e) {
                    e.preventDefault();
                    y.trigger(cf_e('next', conf))
                });
                if (opts.next.pauseOnHover) {
                    var b = bt_pauseOnHoverConfig(opts.next.pauseOnHover);
                    opts.next.button.bind(cf_e('mouseenter', conf, false), function() {
                        y.trigger(cf_e('pause', conf), b)
                    }).bind(cf_e('mouseleave', conf, false), function() {
                        y.trigger(cf_e('resume', conf))
                    })
                }
            }
            if (opts.pagination.container) {
                if (opts.pagination.pauseOnHover) {
                    var b = bt_pauseOnHoverConfig(opts.pagination.pauseOnHover);
                    opts.pagination.container.bind(cf_e('mouseenter', conf, false), function() {
                        y.trigger(cf_e('pause', conf), b)
                    }).bind(cf_e('mouseleave', conf, false), function() {
                        y.trigger(cf_e('resume', conf))
                    })
                }
            }
            if (opts.prev.key || opts.next.key) {
                $(document).bind(cf_e('keyup', conf, false, true, true), function(e) {
                    var k = e.keyCode;
                    if (k == opts.next.key) {
                        e.preventDefault();
                        y.trigger(cf_e('next', conf))
                    }
                    if (k == opts.prev.key) {
                        e.preventDefault();
                        y.trigger(cf_e('prev', conf))
                    }
                })
            }
            if (opts.pagination.keys) {
                $(document).bind(cf_e('keyup', conf, false, true, true), function(e) {
                    var k = e.keyCode;
                    if (k >= 49 && k < 58) {
                        k = (k - 49) * opts.items.visible;
                        if (k <= itms.total) {
                            e.preventDefault();
                            y.trigger(cf_e('slideTo', conf), [k, 0, true, opts.pagination])
                        }
                    }
                })
            }
            if (opts.prev.wipe || opts.next.wipe) {
                deprecated('the touchwipe-plugin', 'the touchSwipe-plugin');
                if ($.fn.touchwipe) {
                    var c = (opts.prev.wipe) ? function() {
                            y.trigger(cf_e('prev', conf))
                        } : null,
                        wN = (opts.next.wipe) ? function() {
                            y.trigger(cf_e('next', conf))
                        } : null;
                    if (wN || wN) {
                        if (!z.touchwipe) {
                            z.touchwipe = true;
                            var d = {
                                'min_move_x': 30,
                                'min_move_y': 30,
                                'preventDefaultEvents': true
                            };
                            switch (opts.direction) {
                                case 'up':
                                case 'down':
                                    d.wipeUp = c;
                                    d.wipeDown = wN;
                                    break;
                                default:
                                    d.wipeLeft = wN;
                                    d.wipeRight = c
                            }
                            $wrp.touchwipe(d)
                        }
                    }
                }
            }
            if ($.fn.swipe) {
                var f = 'ontouchstart' in window;
                if ((f && opts.swipe.onTouch) || (!f && opts.swipe.onMouse)) {
                    var g = $.extend(true, {}, opts.prev, opts.swipe),
                        scN = $.extend(true, {}, opts.next, opts.swipe),
                        swP = function() {
                            y.trigger(cf_e('prev', conf), [g])
                        },
                        swN = function() {
                            y.trigger(cf_e('next', conf), [scN])
                        };
                    switch (opts.direction) {
                        case 'up':
                        case 'down':
                            opts.swipe.options.swipeUp = swN;
                            opts.swipe.options.swipeDown = swP;
                            break;
                        default:
                            opts.swipe.options.swipeLeft = swN;
                            opts.swipe.options.swipeRight = swP
                    }
                    if (z.swipe) {
                        y.swipe('destroy')
                    }
                    $wrp.swipe(opts.swipe.options);
                    $wrp.css('cursor', 'move');
                    z.swipe = true
                }
            }
            if ($.fn.mousewheel) {
                if (opts.prev.mousewheel) {
                    deprecated('The prev.mousewheel option', 'the mousewheel configuration object');
                    opts.prev.mousewheel = null;
                    opts.mousewheel = {
                        items: bt_mousesheelNumber(opts.prev.mousewheel)
                    }
                }
                if (opts.next.mousewheel) {
                    deprecated('The next.mousewheel option', 'the mousewheel configuration object');
                    opts.next.mousewheel = null;
                    opts.mousewheel = {
                        items: bt_mousesheelNumber(opts.next.mousewheel)
                    }
                }
                if (opts.mousewheel) {
                    var h = $.extend(true, {}, opts.prev, opts.mousewheel),
                        mcN = $.extend(true, {}, opts.next, opts.mousewheel);
                    if (z.mousewheel) {
                        $wrp.unbind(cf_e('mousewheel', conf, false))
                    }
                    $wrp.bind(cf_e('mousewheel', conf, false), function(e, a) {
                        e.preventDefault();
                        if (a > 0) {
                            y.trigger(cf_e('prev', conf), [h])
                        } else {
                            y.trigger(cf_e('next', conf), [mcN])
                        }
                    });
                    z.mousewheel = true
                }
            }
            if (opts.auto.play) {
                y.trigger(cf_e('play', conf), opts.auto.delay)
            }
            if (z.upDateOnWindowResize) {
                var i = function(e) {
                    y.trigger(cf_e('finish', conf));
                    if (opts.auto.pauseOnResize && !z.isPaused) {
                        y.trigger(cf_e('play', conf))
                    }
                    sz_resetMargin(y.children(), opts);
                    y.trigger(cf_e('updateSizes', conf))
                };
                var j = $(window),
                    onResize = null;
                if ($.debounce && conf.onWindowResize == 'debounce') {
                    onResize = $.debounce(200, i)
                } else if ($.throttle && conf.onWindowResize == 'throttle') {
                    onResize = $.throttle(300, i)
                } else {
                    var l = 0,
                        _windowHeight = 0;
                    onResize = function() {
                        var a = j.width(),
                            nh = j.height();
                        if (a != l || nh != _windowHeight) {
                            i();
                            l = a;
                            _windowHeight = nh
                        }
                    }
                }
                j.bind(cf_e('resize', conf, false, true, true), onResize)
            }
        };
        y._cfs_unbind_buttons = function() {
            var a = cf_e('', conf),
                ns2 = cf_e('', conf, false);
            ns3 = cf_e('', conf, false, true, true);
            $(document).unbind(ns3);
            $(window).unbind(ns3);
            $wrp.unbind(ns2);
            if (opts.auto.button) {
                opts.auto.button.unbind(ns2)
            }
            if (opts.prev.button) {
                opts.prev.button.unbind(ns2)
            }
            if (opts.next.button) {
                opts.next.button.unbind(ns2)
            }
            if (opts.pagination.container) {
                opts.pagination.container.unbind(ns2);
                if (opts.pagination.anchorBuilder) {
                    opts.pagination.container.children().remove()
                }
            }
            if (z.swipe) {
                y.swipe('destroy');
                $wrp.css('cursor', 'default');
                z.swipe = false
            }
            if (z.mousewheel) {
                z.mousewheel = false
            }
            nv_showNavi(opts, 'hide', conf);
            nv_enableNavi(opts, 'removeClass', conf)
        };
        if (is_boolean(w)) {
            w = {
                'debug': w
            }
        }
        var z = {
                'direction': 'next',
                'isPaused': true,
                'isScrolling': false,
                'isStopped': false,
                'mousewheel': false,
                'swipe': false
            },
            itms = {
                'total': y.children().length,
                'first': 0
            },
            tmrs = {
                'auto': null,
                'progress': null,
                'startTime': getTime(),
                'timePassed': 0
            },
            scrl = {
                'isStopped': false,
                'duration': 0,
                'startTime': 0,
                'easing': '',
                'anims': []
            },
            clbk = {
                'onBefore': [],
                'onAfter': []
            },
            queu = [],
            conf = $.extend(true, {}, $.fn.carouFredSel.configs, w),
            opts = {},
            opts_orig = $.extend(true, {}, u),
            $wrp = y.wrap('<' + conf.wrapper.element + ' class="' + conf.wrapper.classname + '" />').parent();
        conf.selector = y.selector;
        conf.serialNumber = $.fn.carouFredSel.serialNumber++;
        y._cfs_init(opts_orig, true, starting_position);
        y._cfs_build();
        y._cfs_bind_events();
        y._cfs_bind_buttons();
        if (is_array(opts.items.start)) {
            var A = opts.items.start
        } else {
            var A = [];
            if (opts.items.start != 0) {
                A.push(opts.items.start)
            }
        }
        if (opts.cookie) {
            A.unshift(parseInt(cf_getCookie(opts.cookie), 10))
        }
        if (A.length > 0) {
            for (var a = 0, l = A.length; a < l; a++) {
                var s = A[a];
                if (s == 0) {
                    continue
                }
                if (s === true) {
                    s = window.location.hash;
                    if (s.length < 1) {
                        continue
                    }
                } else if (s === 'random') {
                    s = Math.floor(Math.random() * itms.total)
                }
                if (y.triggerHandler(cf_e('slideTo', conf), [s, 0, true, {
                        fx: 'none'
                    }])) {
                    break
                }
            }
        }
        var B = sz_setSizes(y, opts),
            itm = gi_getCurrentItems(y.children(), opts);
        if (opts.onCreate) {
            opts.onCreate.call($tt0, {
                'width': B.width,
                'height': B.height,
                'items': itm
            })
        }
        y.trigger(cf_e('updatePageStatus', conf), [true, B]);
        y.trigger(cf_e('linkAnchors', conf));
        if (conf.debug) {
            y.trigger(cf_e('debug', conf))
        }
        return y
    };
    $.fn.carouFredSel.serialNumber = 1;
    $.fn.carouFredSel.defaults = {
        'synchronise': false,
        'infinite': true,
        'circular': true,
        'responsive': false,
        'direction': 'left',
        'items': {
            'start': 0
        },
        'scroll': {
            'easing': 'swing',
            'duration': 500,
            'pauseOnHover': false,
            'event': 'click',
            'queue': false
        }
    };
    $.fn.carouFredSel.configs = {
        'debug': false,
        'onWindowResize': 'throttle',
        'events': {
            'prefix': '',
            'namespace': 'cfs'
        },
        'wrapper': {
            'element': 'div',
            'classname': 'caroufredsel_wrapper'
        },
        'classnames': {}
    };
    $.fn.carouFredSel.pageAnchorBuilder = function(a) {
        return '<a href="#"><span>' + a + '</span></a>'
    };
    $.fn.carouFredSel.progressbarUpdater = function(a) {
        $(this).css('width', a + '%')
    };
    $.fn.carouFredSel.cookie = {
        get: function(n) {
            n += '=';
            var b = document.cookie.split(';');
            for (var a = 0, l = b.length; a < l; a++) {
                var c = b[a];
                while (c.charAt(0) == ' ') {
                    c = c.slice(1)
                }
                if (c.indexOf(n) == 0) {
                    return c.slice(n.length)
                }
            }
            return 0
        },
        set: function(n, v, d) {
            var e = "";
            if (d) {
                var a = new Date();
                a.setTime(a.getTime() + (d * 24 * 60 * 60 * 1000));
                e = "; expires=" + a.toGMTString()
            }
            document.cookie = n + '=' + v + e + '; path=/'
        },
        remove: function(n) {
            $.fn.carouFredSel.cookie.set(n, "", -1)
        }
    };

    function sc_setScroll(d, e) {
        return {
            anims: [],
            duration: d,
            orgDuration: d,
            easing: e,
            startTime: getTime()
        }
    }

    function sc_startScroll(s) {
        if (is_object(s.pre)) {
            sc_startScroll(s.pre)
        }
        for (var a = 0, l = s.anims.length; a < l; a++) {
            var b = s.anims[a];
            if (!b) {
                continue
            }
            if (b[3]) {
                b[0].stop()
            }
            b[0].animate(b[1], {
                complete: b[2],
                duration: s.duration,
                easing: s.easing
            })
        }
        if (is_object(s.post)) {
            sc_startScroll(s.post)
        }
    }

    function sc_stopScroll(s, c) {
        if (!is_boolean(c)) {
            c = true
        }
        if (is_object(s.pre)) {
            sc_stopScroll(s.pre, c)
        }
        for (var a = 0, l = s.anims.length; a < l; a++) {
            var b = s.anims[a];
            b[0].stop(true);
            if (c) {
                b[0].css(b[1]);
                if (is_function(b[2])) {
                    b[2]()
                }
            }
        }
        if (is_object(s.post)) {
            sc_stopScroll(s.post, c)
        }
    }

    function sc_afterScroll(a, b, o) {
        if (b) {
            b.remove()
        }
        switch (o.fx) {
            case 'fade':
            case 'crossfade':
            case 'cover-fade':
            case 'uncover-fade':
                a.css('filter', '');
                break
        }
    }

    function sc_fireCallbacks(d, o, b, a, c) {
        if (o[b]) {
            o[b].call(d, a)
        }
        if (c[b].length) {
            for (var i = 0, l = c[b].length; i < l; i++) {
                c[b][i].call(d, a)
            }
        }
        return []
    }

    function sc_fireQueue(a, q, c) {
        if (q.length) {
            a.trigger(cf_e(q[0][0], c), q[0][1]);
            q.shift()
        }
        return q
    }

    function sc_hideHiddenItems(b) {
        b.each(function() {
            var a = $(this);
            a.data('_cfs_isHidden', a.is(':hidden')).hide()
        })
    }

    function sc_showHiddenItems(b) {
        if (b) {
            b.each(function() {
                var a = $(this);
                if (!a.data('_cfs_isHidden')) {
                    a.show()
                }
            })
        }
    }

    function sc_clearTimers(t) {
        if (t.auto) {
            clearTimeout(t.auto)
        }
        if (t.progress) {
            clearInterval(t.progress)
        }
        return t
    }

    function sc_mapCallbackArguments(a, b, c, d, e, f, g) {
        return {
            'width': g.width,
            'height': g.height,
            'items': {
                'old': a,
                'skipped': b,
                'visible': c,
                'new': c
            },
            'scroll': {
                'items': d,
                'direction': e,
                'duration': f
            }
        }
    }

    function sc_getDuration(a, o, b, c) {
        var d = a.duration;
        if (a.fx == 'none') {
            return 0
        }
        if (d == 'auto') {
            d = o.scroll.duration / o.scroll.items * b
        } else if (d < 10) {
            d = c / d
        }
        if (d < 1) {
            return 0
        }
        if (a.fx == 'fade') {
            d = d / 2
        }
        return Math.round(d)
    }

    function nv_showNavi(o, t, c) {
        var a = (is_number(o.items.minimum)) ? o.items.minimum : o.items.visible + 1;
        if (t == 'show' || t == 'hide') {
            var f = t
        } else if (a > t) {
            debug(c, 'Not enough items (' + t + ' total, ' + a + ' needed): Hiding navigation.');
            var f = 'hide'
        } else {
            var f = 'show'
        }
        var s = (f == 'show') ? 'removeClass' : 'addClass',
            h = cf_c('hidden', c);
        if (o.auto.button) {
            o.auto.button[f]()[s](h)
        }
        if (o.prev.button) {
            o.prev.button[f]()[s](h)
        }
        if (o.next.button) {
            o.next.button[f]()[s](h)
        }
        if (o.pagination.container) {
            o.pagination.container[f]()[s](h)
        }
    }

    function nv_enableNavi(o, f, c) {
        if (o.circular || o.infinite) return;
        var a = (f == 'removeClass' || f == 'addClass') ? f : false,
            di = cf_c('disabled', c);
        if (o.auto.button && a) {
            o.auto.button[a](di)
        }
        if (o.prev.button) {
            var b = a || (f == 0) ? 'addClass' : 'removeClass';
            o.prev.button[b](di)
        }
        if (o.next.button) {
            var b = a || (f == o.items.visible) ? 'addClass' : 'removeClass';
            o.next.button[b](di)
        }
    }

    function go_getObject(a, b) {
        if (is_function(b)) {
            b = b.call(a)
        } else if (is_undefined(b)) {
            b = {}
        }
        return b
    }

    function go_getItemsObject(a, b) {
        b = go_getObject(a, b);
        if (is_number(b)) {
            b = {
                'visible': b
            }
        } else if (b == 'variable') {
            b = {
                'visible': b,
                'width': b,
                'height': b
            }
        } else if (!is_object(b)) {
            b = {}
        }
        return b
    }

    function go_getScrollObject(a, b) {
        b = go_getObject(a, b);
        if (is_number(b)) {
            if (b <= 50) {
                b = {
                    'items': b
                }
            } else {
                b = {
                    'duration': b
                }
            }
        } else if (is_string(b)) {
            b = {
                'easing': b
            }
        } else if (!is_object(b)) {
            b = {}
        }
        return b
    }

    function go_getNaviObject(a, b) {
        b = go_getObject(a, b);
        if (is_string(b)) {
            var c = cf_getKeyCode(b);
            if (c == -1) {
                b = $(b)
            } else {
                b = c
            }
        }
        return b
    }

    function go_getAutoObject(a, b) {
        b = go_getNaviObject(a, b);
        if (is_jquery(b)) {
            b = {
                'button': b
            }
        } else if (is_boolean(b)) {
            b = {
                'play': b
            }
        } else if (is_number(b)) {
            b = {
                'timeoutDuration': b
            }
        }
        if (b.progress) {
            if (is_string(b.progress) || is_jquery(b.progress)) {
                b.progress = {
                    'bar': b.progress
                }
            }
        }
        return b
    }

    function go_complementAutoObject(a, b) {
        if (is_function(b.button)) {
            b.button = b.button.call(a)
        }
        if (is_string(b.button)) {
            b.button = $(b.button)
        }
        if (!is_boolean(b.play)) {
            b.play = true
        }
        if (!is_number(b.delay)) {
            b.delay = 0
        }
        if (is_undefined(b.pauseOnEvent)) {
            b.pauseOnEvent = true
        }
        if (!is_boolean(b.pauseOnResize)) {
            b.pauseOnResize = true
        }
        if (!is_number(b.timeoutDuration)) {
            b.timeoutDuration = (b.duration < 10) ? 2500 : b.duration * 5
        }
        if (b.progress) {
            if (is_function(b.progress.bar)) {
                b.progress.bar = b.progress.bar.call(a)
            }
            if (is_string(b.progress.bar)) {
                b.progress.bar = $(b.progress.bar)
            }
            if (b.progress.bar) {
                if (!is_function(b.progress.updater)) {
                    b.progress.updater = $.fn.carouFredSel.progressbarUpdater
                }
                if (!is_number(b.progress.interval)) {
                    b.progress.interval = 50
                }
            } else {
                b.progress = false
            }
        }
        return b
    }

    function go_getPrevNextObject(a, b) {
        b = go_getNaviObject(a, b);
        if (is_jquery(b)) {
            b = {
                'button': b
            }
        } else if (is_number(b)) {
            b = {
                'key': b
            }
        }
        return b
    }

    function go_complementPrevNextObject(a, b) {
        if (is_function(b.button)) {
            b.button = b.button.call(a)
        }
        if (is_string(b.button)) {
            b.button = $(b.button)
        }
        if (is_string(b.key)) {
            b.key = cf_getKeyCode(b.key)
        }
        return b
    }

    function go_getPaginationObject(a, b) {
        b = go_getNaviObject(a, b);
        if (is_jquery(b)) {
            b = {
                'container': b
            }
        } else if (is_boolean(b)) {
            b = {
                'keys': b
            }
        }
        return b
    }

    function go_complementPaginationObject(a, b) {
        if (is_function(b.container)) {
            b.container = b.container.call(a)
        }
        if (is_string(b.container)) {
            b.container = $(b.container)
        }
        if (!is_number(b.items)) {
            b.items = false
        }
        if (!is_boolean(b.keys)) {
            b.keys = false
        }
        if (!is_function(b.anchorBuilder) && !is_false(b.anchorBuilder)) {
            b.anchorBuilder = $.fn.carouFredSel.pageAnchorBuilder
        }
        if (!is_number(b.deviation)) {
            b.deviation = 0
        }
        return b
    }

    function go_getSwipeObject(a, b) {
        if (is_function(b)) {
            b = b.call(a)
        }
        if (is_undefined(b)) {
            b = {
                'onTouch': false
            }
        }
        if (is_true(b)) {
            b = {
                'onTouch': b
            }
        } else if (is_number(b)) {
            b = {
                'items': b
            }
        }
        return b
    }

    function go_complementSwipeObject(a, b) {
        if (!is_boolean(b.onTouch)) {
            b.onTouch = true
        }
        if (!is_boolean(b.onMouse)) {
            b.onMouse = false
        }
        if (!is_object(b.options)) {
            b.options = {}
        }
        if (!is_boolean(b.options.triggerOnTouchEnd)) {
            b.options.triggerOnTouchEnd = false
        }
        return b
    }

    function go_getMousewheelObject(a, b) {
        if (is_function(b)) {
            b = b.call(a)
        }
        if (is_true(b)) {
            b = {}
        } else if (is_number(b)) {
            b = {
                'items': b
            }
        } else if (is_undefined(b)) {
            b = false
        }
        return b
    }

    function go_complementMousewheelObject(a, b) {
        return b
    }

    function gn_getItemIndex(a, b, c, d, e) {
        if (is_string(a)) {
            a = $(a, e)
        }
        if (is_object(a)) {
            a = $(a, e)
        }
        if (is_jquery(a)) {
            a = e.children().index(a);
            if (!is_boolean(c)) {
                c = false
            }
        } else {
            if (!is_boolean(c)) {
                c = true
            }
        }
        if (!is_number(a)) {
            a = 0
        }
        if (!is_number(b)) {
            b = 0
        }
        if (c) {
            a += d.first
        }
        a += b;
        if (d.total > 0) {
            while (a >= d.total) {
                a -= d.total
            }
            while (a < 0) {
                a += d.total
            }
        }
        return a
    }

    function gn_getVisibleItemsPrev(i, o, s) {
        var t = 0,
            x = 0;
        for (var a = s; a >= 0; a--) {
            var j = i.eq(a);
            t += (j.is(':visible')) ? j[o.d['outerWidth']](true) : 0;
            if (t > o.maxDimension) {
                return x
            }
            if (a == 0) {
                a = i.length
            }
            x++
        }
    }

    function gn_getVisibleItemsPrevFilter(i, o, s) {
        return gn_getItemsPrevFilter(i, o.items.filter, o.items.visibleConf.org, s)
    }

    function gn_getScrollItemsPrevFilter(i, o, s, m) {
        return gn_getItemsPrevFilter(i, o.items.filter, m, s)
    }

    function gn_getItemsPrevFilter(i, f, m, s) {
        var t = 0,
            x = 0;
        for (var a = s, l = i.length; a >= 0; a--) {
            x++;
            if (x == l) {
                return x
            }
            var j = i.eq(a);
            if (j.is(f)) {
                t++;
                if (t == m) {
                    return x
                }
            }
            if (a == 0) {
                a = l
            }
        }
    }

    function gn_getVisibleOrg(a, o) {
        return o.items.visibleConf.org || a.children().slice(0, o.items.visible).filter(o.items.filter).length
    }

    function gn_getVisibleItemsNext(i, o, s) {
        var t = 0,
            x = 0;
        for (var a = s, l = i.length - 1; a <= l; a++) {
            var j = i.eq(a);
            t += (j.is(':visible')) ? j[o.d['outerWidth']](true) : 0;
            if (t > o.maxDimension) {
                return x
            }
            x++;
            if (x == l + 1) {
                return x
            }
            if (a == l) {
                a = -1
            }
        }
    }

    function gn_getVisibleItemsNextTestCircular(i, o, s, l) {
        var v = gn_getVisibleItemsNext(i, o, s);
        if (!o.circular) {
            if (s + v > l) {
                v = l - s
            }
        }
        return v
    }

    function gn_getVisibleItemsNextFilter(i, o, s) {
        return gn_getItemsNextFilter(i, o.items.filter, o.items.visibleConf.org, s, o.circular)
    }

    function gn_getScrollItemsNextFilter(i, o, s, m) {
        return gn_getItemsNextFilter(i, o.items.filter, m + 1, s, o.circular) - 1
    }

    function gn_getItemsNextFilter(i, f, m, s, c) {
        var t = 0,
            x = 0;
        for (var a = s, l = i.length - 1; a <= l; a++) {
            x++;
            if (x >= l) {
                return x
            }
            var j = i.eq(a);
            if (j.is(f)) {
                t++;
                if (t == m) {
                    return x
                }
            }
            if (a == l) {
                a = -1
            }
        }
    }

    function gi_getCurrentItems(i, o) {
        return i.slice(0, o.items.visible)
    }

    function gi_getOldItemsPrev(i, o, n) {
        return i.slice(n, o.items.visibleConf.old + n)
    }

    function gi_getNewItemsPrev(i, o) {
        return i.slice(0, o.items.visible)
    }

    function gi_getOldItemsNext(i, o) {
        return i.slice(0, o.items.visibleConf.old)
    }

    function gi_getNewItemsNext(i, o, n) {
        return i.slice(n, o.items.visible + n)
    }

    function sz_storeMargin(i, o, d) {
        if (o.usePadding) {
            if (!is_string(d)) {
                d = '_cfs_origCssMargin'
            }
            i.each(function() {
                var j = $(this),
                    m = parseInt(j.css(o.d['marginRight']), 10);
                if (!is_number(m)) {
                    m = 0
                }
                j.data(d, m)
            })
        }
    }

    function sz_resetMargin(i, o, m) {
        if (o.usePadding) {
            var x = (is_boolean(m)) ? m : false;
            if (!is_number(m)) {
                m = 0
            }
            sz_storeMargin(i, o, '_cfs_tempCssMargin');
            i.each(function() {
                var j = $(this);
                j.css(o.d['marginRight'], ((x) ? j.data('_cfs_tempCssMargin') : m + j.data('_cfs_origCssMargin')))
            })
        }
    }

    function sz_storeSizes(i, o) {
        if (o.responsive) {
            i.each(function() {
                var j = $(this),
                    s = in_mapCss(j, ['width', 'height']);
                j.data('_cfs_origCssSizes', s)
            })
        }
    }

    function sz_setResponsiveSizes(o, b) {
        var c = o.items.visible,
            newS = o.items[o.d['width']],
            seco = o[o.d['height']],
            secp = is_percentage(seco);
        b.each(function() {
            var a = $(this),
                nw = newS - ms_getPaddingBorderMargin(a, o, 'Width');
            a[o.d['width']](nw);
            if (secp) {
                a[o.d['height']](ms_getPercentage(nw, seco))
            }
        })
    }

    function sz_setSizes(a, o) {
        var b = a.parent(),
            $i = a.children(),
            $v = gi_getCurrentItems($i, o),
            sz = cf_mapWrapperSizes(ms_getSizes($v, o, true), o, false);
        b.css(sz);
        if (o.usePadding) {
            var p = o.padding,
                r = p[o.d[1]];
            if (o.align && r < 0) {
                r = 0
            }
            var c = $v.last();
            c.css(o.d['marginRight'], c.data('_cfs_origCssMargin') + r);
            a.css(o.d['top'], p[o.d[0]]);
            a.css(o.d['left'], p[o.d[3]])
        }
        a.css(o.d['width'], sz[o.d['width']] + (ms_getTotalSize($i, o, 'width') * 2));
        a.css(o.d['height'], ms_getLargestSize($i, o, 'height'));
        return sz
    }

    function ms_getSizes(i, o, a) {
        return [ms_getTotalSize(i, o, 'width', a), ms_getLargestSize(i, o, 'height', a)]
    }

    function ms_getLargestSize(i, o, a, b) {
        if (!is_boolean(b)) {
            b = false
        }
        if (is_number(o[o.d[a]]) && b) {
            return o[o.d[a]]
        }
        if (is_number(o.items[o.d[a]])) {
            return o.items[o.d[a]]
        }
        a = (a.toLowerCase().indexOf('width') > -1) ? 'outerWidth' : 'outerHeight';
        return ms_getTrueLargestSize(i, o, a)
    }

    function ms_getTrueLargestSize(i, o, b) {
        var s = 0;
        for (var a = 0, l = i.length; a < l; a++) {
            var j = i.eq(a);
            var m = (j.is(':visible')) ? j[o.d[b]](true) : 0;
            if (s < m) {
                s = m
            }
        }
        return s
    }

    function ms_getTotalSize(i, o, b, c) {
        if (!is_boolean(c)) {
            c = false
        }
        if (is_number(o[o.d[b]]) && c) {
            return o[o.d[b]]
        }
        if (is_number(o.items[o.d[b]])) {
            return o.items[o.d[b]] * i.length
        }
        var d = (b.toLowerCase().indexOf('width') > -1) ? 'outerWidth' : 'outerHeight',
            s = 0;
        for (var a = 0, l = i.length; a < l; a++) {
            var j = i.eq(a);
            s += (j.is(':visible')) ? j[o.d[d]](true) : 0
        }
        return s
    }

    function ms_getParentSize(a, o, d) {
        var b = a.is(':visible');
        if (b) {
            a.hide()
        }
        var s = a.parent()[o.d[d]]();
        if (b) {
            a.show()
        }
        return s
    }

    function ms_getMaxDimension(o, a) {
        return (is_number(o[o.d['width']])) ? o[o.d['width']] : a
    }

    function ms_hasVariableSizes(i, o, b) {
        var s = false,
            v = false;
        for (var a = 0, l = i.length; a < l; a++) {
            var j = i.eq(a);
            var c = (j.is(':visible')) ? j[o.d[b]](true) : 0;
            if (s === false) {
                s = c
            } else if (s != c) {
                v = true
            }
            if (s == 0) {
                v = true
            }
        }
        return v
    }

    function ms_getPaddingBorderMargin(i, o, d) {
        return i[o.d['outer' + d]](true) - i[o.d[d.toLowerCase()]]()
    }

    function ms_getPercentage(s, o) {
        if (is_percentage(o)) {
            o = parseInt(o.slice(0, -1), 10);
            if (!is_number(o)) {
                return s
            }
            s *= o / 100
        }
        return s
    }

    function cf_e(n, c, a, b, d) {
        if (!is_boolean(a)) {
            a = true
        }
        if (!is_boolean(b)) {
            b = true
        }
        if (!is_boolean(d)) {
            d = false
        }
        if (a) {
            n = c.events.prefix + n
        }
        if (b) {
            n = n + '.' + c.events.namespace
        }
        if (b && d) {
            n += c.serialNumber
        }
        return n
    }

    function cf_c(n, c) {
        return (is_string(c.classnames[n])) ? c.classnames[n] : n
    }

    function cf_mapWrapperSizes(a, o, p) {
        if (!is_boolean(p)) {
            p = true
        }
        var b = (o.usePadding && p) ? o.padding : [0, 0, 0, 0];
        var c = {};
        c[o.d['width']] = a[0] + b[1] + b[3];
        c[o.d['height']] = a[1] + b[0] + b[2];
        return c
    }

    function cf_sortParams(c, d) {
        var e = [];
        for (var a = 0, l1 = c.length; a < l1; a++) {
            for (var b = 0, l2 = d.length; b < l2; b++) {
                if (d[b].indexOf(typeof c[a]) > -1 && is_undefined(e[b])) {
                    e[b] = c[a];
                    break
                }
            }
        }
        return e
    }

    function cf_getPadding(p) {
        if (is_undefined(p)) {
            return [0, 0, 0, 0]
        }
        if (is_number(p)) {
            return [p, p, p, p]
        }
        if (is_string(p)) {
            p = p.split('px').join('').split('em').join('').split(' ')
        }
        if (!is_array(p)) {
            return [0, 0, 0, 0]
        }
        for (var i = 0; i < 4; i++) {
            p[i] = parseInt(p[i], 10)
        }
        switch (p.length) {
            case 0:
                return [0, 0, 0, 0];
            case 1:
                return [p[0], p[0], p[0], p[0]];
            case 2:
                return [p[0], p[1], p[0], p[1]];
            case 3:
                return [p[0], p[1], p[2], p[1]];
            default:
                return [p[0], p[1], p[2], p[3]]
        }
    }

    function cf_getAlignPadding(a, o) {
        var x = (is_number(o[o.d['width']])) ? Math.ceil(o[o.d['width']] - ms_getTotalSize(a, o, 'width')) : 0;
        switch (o.align) {
            case 'left':
                return [0, x];
            case 'right':
                return [x, 0];
            case 'center':
            default:
                return [Math.ceil(x / 2), Math.floor(x / 2)]
        }
    }

    function cf_getDimensions(o) {
        var a = [
            ['width', 'innerWidth', 'outerWidth', 'height', 'innerHeight', 'outerHeight', 'left', 'top', 'marginRight', 0, 1, 2, 3],
            ['height', 'innerHeight', 'outerHeight', 'width', 'innerWidth', 'outerWidth', 'top', 'left', 'marginBottom', 3, 2, 1, 0]
        ];
        var b = a[0].length,
            dx = (o.direction == 'right' || o.direction == 'left') ? 0 : 1;
        var c = {};
        for (var d = 0; d < b; d++) {
            c[a[0][d]] = a[dx][d]
        }
        return c
    }

    function cf_getAdjust(x, o, a, b) {
        var v = x;
        if (is_function(a)) {
            v = a.call(b, v)
        } else if (is_string(a)) {
            var p = a.split('+'),
                m = a.split('-');
            if (m.length > p.length) {
                var c = true,
                    sta = m[0],
                    adj = m[1]
            } else {
                var c = false,
                    sta = p[0],
                    adj = p[1]
            }
            switch (sta) {
                case 'even':
                    v = (x % 2 == 1) ? x - 1 : x;
                    break;
                case 'odd':
                    v = (x % 2 == 0) ? x - 1 : x;
                    break;
                default:
                    v = x;
                    break
            }
            adj = parseInt(adj, 10);
            if (is_number(adj)) {
                if (c) {
                    adj = -adj
                }
                v += adj
            }
        }
        if (!is_number(v) || v < 1) {
            v = 1
        }
        return v
    }

    function cf_getItemsAdjust(x, o, a, b) {
        return cf_getItemAdjustMinMax(cf_getAdjust(x, o, a, b), o.items.visibleConf)
    }

    function cf_getItemAdjustMinMax(v, i) {
        if (is_number(i.min) && v < i.min) {
            v = i.min
        }
        if (is_number(i.max) && v > i.max) {
            v = i.max
        }
        if (v < 1) {
            v = 1
        }
        return v
    }

    function cf_getSynchArr(s) {
        if (!is_array(s)) {
            s = [
                [s]
            ]
        }
        if (!is_array(s[0])) {
            s = [s]
        }
        for (var j = 0, l = s.length; j < l; j++) {
            if (is_string(s[j][0])) {
                s[j][0] = $(s[j][0])
            }
            if (!is_boolean(s[j][1])) {
                s[j][1] = true
            }
            if (!is_boolean(s[j][2])) {
                s[j][2] = true
            }
            if (!is_number(s[j][3])) {
                s[j][3] = 0
            }
        }
        return s
    }

    function cf_getKeyCode(k) {
        if (k == 'right') {
            return 39
        }
        if (k == 'left') {
            return 37
        }
        if (k == 'up') {
            return 38
        }
        if (k == 'down') {
            return 40
        }
        return -1
    }

    function cf_setCookie(n, a, c) {
        if (n) {
            var v = a.triggerHandler(cf_e('currentPosition', c));
            $.fn.carouFredSel.cookie.set(n, v)
        }
    }

    function cf_getCookie(n) {
        var c = $.fn.carouFredSel.cookie.get(n);
        return (c == '') ? 0 : c
    }

    function in_mapCss(a, b) {
        var c = {},
            prop;
        for (var p = 0, l = b.length; p < l; p++) {
            prop = b[p];
            c[prop] = a.css(prop)
        }
        return c
    }

    function in_complementItems(a, b, c, d) {
        if (!is_object(a.visibleConf)) {
            a.visibleConf = {}
        }
        if (!is_object(a.sizesConf)) {
            a.sizesConf = {}
        }
        if (a.start == 0 && is_number(d)) {
            a.start = d
        }
        if (is_object(a.visible)) {
            a.visibleConf.min = a.visible.min;
            a.visibleConf.max = a.visible.max;
            a.visible = false
        } else if (is_string(a.visible)) {
            if (a.visible == 'variable') {
                a.visibleConf.variable = true
            } else {
                a.visibleConf.adjust = a.visible
            }
            a.visible = false
        } else if (is_function(a.visible)) {
            a.visibleConf.adjust = a.visible;
            a.visible = false
        }
        if (!is_string(a.filter)) {
            a.filter = (c.filter(':hidden').length > 0) ? ':visible' : '*'
        }
        if (!a[b.d['width']]) {
            if (b.responsive) {
                debug(true, 'Set a ' + b.d['width'] + ' for the items!');
                a[b.d['width']] = ms_getTrueLargestSize(c, b, 'outerWidth')
            } else {
                a[b.d['width']] = (ms_hasVariableSizes(c, b, 'outerWidth')) ? 'variable' : c[b.d['outerWidth']](true)
            }
        }
        if (!a[b.d['height']]) {
            a[b.d['height']] = (ms_hasVariableSizes(c, b, 'outerHeight')) ? 'variable' : c[b.d['outerHeight']](true)
        }
        a.sizesConf.width = a.width;
        a.sizesConf.height = a.height;
        return a
    }

    function in_complementVisibleItems(a, b) {
        if (a.items[a.d['width']] == 'variable') {
            a.items.visibleConf.variable = true
        }
        if (!a.items.visibleConf.variable) {
            if (is_number(a[a.d['width']])) {
                a.items.visible = Math.floor(a[a.d['width']] / a.items[a.d['width']])
            } else {
                a.items.visible = Math.floor(b / a.items[a.d['width']]);
                a[a.d['width']] = a.items.visible * a.items[a.d['width']];
                if (!a.items.visibleConf.adjust) {
                    a.align = false
                }
            }
            if (a.items.visible == 'Infinity' || a.items.visible < 1) {
                debug(true, 'Not a valid number of visible items: Set to "variable".');
                a.items.visibleConf.variable = true
            }
        }
        return a
    }

    function in_complementPrimarySize(a, b, c) {
        if (a == 'auto') {
            a = ms_getTrueLargestSize(c, b, 'outerWidth')
        }
        return a
    }

    function in_complementSecondarySize(a, b, c) {
        if (a == 'auto') {
            a = ms_getTrueLargestSize(c, b, 'outerHeight')
        }
        if (!a) {
            a = b.items[b.d['height']]
        }
        return a
    }

    function in_getAlignPadding(o, a) {
        var p = cf_getAlignPadding(gi_getCurrentItems(a, o), o);
        o.padding[o.d[1]] = p[1];
        o.padding[o.d[3]] = p[0];
        return o
    }

    function in_getResponsiveValues(o, a, b) {
        var c = cf_getItemAdjustMinMax(Math.ceil(o[o.d['width']] / o.items[o.d['width']]), o.items.visibleConf);
        if (c > a.length) {
            c = a.length
        }
        var d = Math.floor(o[o.d['width']] / c);
        o.items.visible = c;
        o.items[o.d['width']] = d;
        o[o.d['width']] = c * d;
        return o
    }

    function bt_pauseOnHoverConfig(p) {
        if (is_string(p)) {
            var i = (p.indexOf('immediate') > -1) ? true : false,
                r = (p.indexOf('resume') > -1) ? true : false
        } else {
            var i = r = false
        }
        return [i, r]
    }

    function bt_mousesheelNumber(a) {
        return (is_number(a)) ? a : null
    }

    function is_null(a) {
        return (a === null)
    }

    function is_undefined(a) {
        return (is_null(a) || typeof a == 'undefined' || a === '' || a === 'undefined')
    }

    function is_array(a) {
        return (a instanceof Array)
    }

    function is_jquery(a) {
        return (a instanceof jQuery)
    }

    function is_object(a) {
        return ((a instanceof Object || typeof a == 'object') && !is_null(a) && !is_jquery(a) && !is_array(a))
    }

    function is_number(a) {
        return ((a instanceof Number || typeof a == 'number') && !isNaN(a))
    }

    function is_string(a) {
        return ((a instanceof String || typeof a == 'string') && !is_undefined(a) && !is_true(a) && !is_false(a))
    }

    function is_function(a) {
        return (a instanceof Function || typeof a == 'function')
    }

    function is_boolean(a) {
        return (a instanceof Boolean || typeof a == 'boolean' || is_true(a) || is_false(a))
    }

    function is_true(a) {
        return (a === true || a === 'true')
    }

    function is_false(a) {
        return (a === false || a === 'false')
    }

    function is_percentage(x) {
        return (is_string(x) && x.slice(-1) == '%')
    }

    function getTime() {
        return new Date().getTime()
    }

    function deprecated(o, n) {
        debug(true, o + ' is DEPRECATED, support for it will be removed. Use ' + n + ' instead.')
    }

    function debug(d, m) {
        if (is_object(d)) {
            var s = ' (' + d.selector + ')';
            d = d.debug
        } else {
            var s = ''
        }
        if (!d) {
            return false
        }
        if (is_string(m)) {
            m = 'carouFredSel' + s + ': ' + m
        } else {
            m = ['carouFredSel' + s + ':', m]
        }
        if (window.console && window.console.log) {
            window.console.log(m)
        }
        return false
    }
    $.extend($.easing, {
        'quadratic': function(t) {
            var a = t * t;
            return t * (-a * t + 4 * a - 6 * t + 4)
        },
        'cubic': function(t) {
            return t * (4 * t * t - 9 * t + 6)
        },
        'elastic': function(t) {
            var a = t * t;
            return t * (33 * a * a - 106 * a * t + 126 * a - 67 * t + 15)
        }
    })
})(jQuery);

//http://localhost/kobstereshop/themes/theme335/js/popup.js
//Setting up the popup
//0 is disabled; 1 is enabled;
var popupStatus = 0;

function loadPopup(id) {
    //Will only be loaded if the status is 0
    if (popupStatus == 0) {
        $(".backgroundQuickView").css({
            "opacity": "0.8"
        });
        $(".backgroundQuickView").fadeIn("slow");
        $(id).fadeIn("slow");
        popupStatus = 1;
    }
}

//This will disable the popup when needed
function disablePopup(id) {
    //Will only disable if status is 1
    if (popupStatus == 1) {
        $(".backgroundQuickView").fadeOut("slow");
        if (id == 0) {
            $(".quickView").fadeOut("slow");
        } else {
            $(id).fadeOut("slow");
        }
        popupStatus = 0;
    }
}

//Centers the popup to your window size 
function centerPopup(id) {
    var windowWidth = document.body.offsetWidth;
    var windowHeight = document.body.offsetHeight;
    var popupHeight = $(id).height();
    var popupWidth = $(id).width();
    $(id).css({
        "top": windowHeight / 2 - popupHeight / 2,
        "left": windowWidth / 2 - popupWidth / 2
    });
    //this is needed for ie6
    $(".backgroundQuickView").css({
        "height": windowHeight
    });
}

//Click event controller
$(document).ready(function() {
    //Open the popup and center
    $(".quickViewButton").click(function() {
        var id = $(this).attr('href');
        centerPopup(id);
        loadPopup(id);
    });
    //Close popup by clicking the x
    $(".quickViewClose").click(function() {
        var id = $(this).attr('href');
        disablePopup(id);
    });
    //Close popup by clicking outside the box
    $(".backgroundQuickView").click(function() {
        disablePopup(0);
    });

    //Close popup by clicking escape
    $(document).keypress(function(e) {
        if (e.keyCode == 27 && popupStatus == 1) {
            disablePopup(0);
        }
    });
});

//jail.min.js
(function(e, t) {
    var n = t(jQuery),
        r = typeof define == "function" && define.amd;
    r ? define(e, ["jquery"], n) : (this.jQuery || this.$ || this)[e] = n
})("jail", function(e) {
    function s(e, n) {
        var r = !1;
        !n || (r = n.data("triggerElem")), !!r && typeof r.bind == "function" && (r.bind(e.event, {
            options: e,
            images: n
        }, u), t.bind("resize", {
            options: e,
            images: n
        }, u))
    }

    function o(e) {
        var t = 0;
        if (e.length === 0) return;
        for (;;) {
            if (t === e.length) break;
            e[t].getAttribute("data-src") ? t++ : e.splice(t, 1)
        }
    }

    function u(n) {
        var i = n.data.images,
            u = n.data.options;
        i.data("poller", setTimeout(function() {
            r = e.extend({}, i), o(r), e(r).each(function() {
                if (this === window) return;
                f(u, this, r)
            });
            if (a(r)) {
                e(n.currentTarget).unbind(n.type);
                return
            }
            if (u.event !== "scroll") {
                var l = /scroll/i.test(u.event) ? i.data("triggerElem") : t;
                u.event = "scroll", i.data("triggerElem", l), s(u, e(r))
            }
        }, u.timeout))
    }

    function a(t) {
        var n = !0;
        return e(t).each(function() {
            !e(this).attr("data-src") || (n = !1)
        }), n
    }

    function f(n, r, i) {
        var s = e(r),
            o = /scroll/i.test(n.event) ? i.data("triggerElem") : t,
            u = !0;
        n.loadHiddenImages || (u = h(s, o, n) && s.is(":visible")), u && l(o, s, n.offset) && c(n, s)
    }

    function l(e, t, n) {
        var r = e[0] === window,
            i = r ? {
                top: 0,
                left: 0
            } : e.offset(),
            s = i.top + (r ? e.scrollTop() : 0),
            o = i.left + (r ? e.scrollLeft() : 0),
            u = o + e.width(),
            a = s + e.height(),
            f = t.offset(),
            l = t.width(),
            c = t.height();
        return s - n <= f.top + c && a + n >= f.top && o - n <= f.left + l && u + n >= f.left
    }

    function c(t, n) {
        var s = new Image;
        s.onload = function() {
            n.hide().attr("src", s.src), n.removeAttr("data-src"), t.effect ? (t.speed ? n[t.effect](t.speed) : n[t.effect](), n.css("opacity", 1), n.show()) : n.show(), o(r), !t.callbackAfterEachImage || t.callbackAfterEachImage.call(this, n, t), a(r) && !!t.callback && !i && (t.callback.call(e.jail, t), i = !0)
        }, s.src = n.attr("data-src")
    }

    function h(n, i, o) {
        var u = n.parent(),
            a = !0;
        while (u.length && u.get(0).nodeName.toUpperCase() !== "BODY") {
            if (u.css("overflow") === "hidden") {
                if (!l(u, n, o.offset)) {
                    a = !1;
                    break
                }
            } else if (u.css("overflow") === "scroll" && !l(u, n, o.offset)) {
                a = !1, e(r).data("triggerElem", u), o.event = "scroll", s(o, e(r));
                break
            }
            if (u.css("visibility") === "hidden" || n.css("visibility") === "hidden") {
                a = !1;
                break
            }
            if (i !== t && u === i) break;
            u = u.parent()
        }
        return a
    }
    var t = e(window),
        n = {
            timeout: 1,
            effect: !1,
            speed: 400,
            triggerElement: null,
            offset: 0,
            event: "load",
            callback: null,
            callbackAfterEachImage: null,
            placeholder: !1,
            loadHiddenImages: !1
        },
        r = [],
        i = !1;
    return e.jail = function(t, r) {
        var i = t || {},
            s = e.extend({}, n, r);
        e.jail.prototype.init(i, s), /^(load|scroll)/.test(s.event) ? e.jail.prototype.later.call(i, s) : e.jail.prototype.onEvent.call(i, s)
    }, e.jail.prototype.init = function(n, r) {
        n.data("triggerElem", r.triggerElement ? e(r.triggerElement) : t), !r.placeholder || n.each(function() {
            e(this).attr("src", r.placeholder)
        })
    }, e.jail.prototype.onEvent = function(t) {
        var n = this;
        t.triggerElement ? s(t, n) : n.bind(t.event, {
            options: t,
            images: n
        }, function(t) {
            var n = e(this),
                i = t.data.options,
                s = t.data.images;
            r = e.extend({}, s), c(i, n), e(t.currentTarget).unbind(t.type)
        })
    }, e.jail.prototype.later = function(t) {
        var n = this;
        setTimeout(function() {
            r = e.extend({}, n), n.each(function() {
                f(t, this, n)
            }), t.event = "scroll", s(t, n)
        }, t.timeout)
    }, e.fn.jail = function(t) {
        return new e.jail(this, t), r = [], this
    }, e.jail
});



/*jquery.jcarousel.pack.js
 * jCarousel - Riding carousels with jQuery
 *   http://sorgalla.com/jcarousel/
 *
 * Copyright (c) 2006 Jan Sorgalla (http://sorgalla.com)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * Built on top of the jQuery library
 *   http://jquery.com
 *
 * Inspired by the "Carousel Component" by Bill Scott
 *   http://billwscott.com/carousel/
 */
(function($) {
    $.fn.jcarousel = function(o) {
        return this.each(function() {
            new r(this, o)
        })
    };
    var q = {
        vertical: false,
        start: 1,
        offset: 1,
        size: null,
        scroll: 3,
        visible: null,
        animation: 'normal',
        easing: 'swing',
        auto: 0,
        wrap: null,
        initCallback: null,
        reloadCallback: null,
        itemLoadCallback: null,
        itemFirstInCallback: null,
        itemFirstOutCallback: null,
        itemLastInCallback: null,
        itemLastOutCallback: null,
        itemVisibleInCallback: null,
        itemVisibleOutCallback: null,
        buttonNextHTML: '<div></div>',
        buttonPrevHTML: '<div></div>',
        buttonNextEvent: 'click',
        buttonPrevEvent: 'click',
        buttonNextCallback: null,
        buttonPrevCallback: null
    };
    $.jcarousel = function(e, o) {
        this.options = $.extend({}, q, o || {});
        this.locked = false;
        this.container = null;
        this.clip = null;
        this.list = null;
        this.buttonNext = null;
        this.buttonPrev = null;
        this.wh = !this.options.vertical ? 'width' : 'height';
        this.lt = !this.options.vertical ? 'left' : 'top';
        var a = '',
            split = e.className.split(' ');
        for (var i = 0; i < split.length; i++) {
            if (split[i].indexOf('jcarousel-skin') != -1) {
                $(e).removeClass(split[i]);
                var a = split[i];
                break
            }
        }
        if (e.nodeName == 'UL' || e.nodeName == 'OL') {
            this.list = $(e);
            this.container = this.list.parent();
            if (this.container.hasClass('jcarousel-clip')) {
                if (!this.container.parent().hasClass('jcarousel-container')) this.container = this.container.wrap('<div></div>');
                this.container = this.container.parent()
            } else if (!this.container.hasClass('jcarousel-container')) this.container = this.list.wrap('<div></div>').parent()
        } else {
            this.container = $(e);
            this.list = $(e).find('>ul,>ol,div>ul,div>ol')
        }
        if (a != '' && this.container.parent()[0].className.indexOf('jcarousel-skin') == -1) this.container.wrap('<div class=" ' + a + '"></div>');
        this.clip = this.list.parent();
        if (!this.clip.length || !this.clip.hasClass('jcarousel-clip')) this.clip = this.list.wrap('<div></div>').parent();
        this.buttonPrev = $('.jcarousel-prev', this.container);
        if (this.buttonPrev.size() == 0 && this.options.buttonPrevHTML != null) this.buttonPrev = this.clip.before(this.options.buttonPrevHTML).prev();
        this.buttonPrev.addClass(this.className('jcarousel-prev'));
        this.buttonNext = $('.jcarousel-next', this.container);
        if (this.buttonNext.size() == 0 && this.options.buttonNextHTML != null) this.buttonNext = this.clip.before(this.options.buttonNextHTML).prev();
        this.buttonNext.addClass(this.className('jcarousel-next'));
        this.clip.addClass(this.className('jcarousel-clip'));
        this.list.addClass(this.className('jcarousel-list'));
        this.container.addClass(this.className('jcarousel-container'));
        var b = this.options.visible != null ? Math.ceil(this.clipping() / this.options.visible) : null;
        var c = this.list.children('li');
        var d = this;
        if (c.size() > 0) {
            var f = 0,
                i = this.options.offset;
            c.each(function() {
                d.format(this, i++);
                f += d.dimension(this, b)
            });
            this.list.css(this.wh, f + 'px');
            if (!o || o.size === undefined) this.options.size = c.size()
        }
        this.container.css('display', 'block');
        this.buttonNext.css('display', 'block');
        this.buttonPrev.css('display', 'block');
        this.funcNext = function() {
            d.next()
        };
        this.funcPrev = function() {
            d.prev()
        };
        this.funcResize = function() {
            d.reload()
        };
        if (this.options.initCallback != null) this.options.initCallback(this, 'init');
        if ($.browser.safari) {
            this.buttons(false, false);
            $(window).bind('load', function() {
                d.setup()
            })
        } else this.setup()
    };
    var r = $.jcarousel;
    r.fn = r.prototype = {
        jcarousel: '0.2.3'
    };
    r.fn.extend = r.extend = $.extend;
    r.fn.extend({
        setup: function() {
            this.first = null;
            this.last = null;
            this.prevFirst = null;
            this.prevLast = null;
            this.animating = false;
            this.timer = null;
            this.tail = null;
            this.inTail = false;
            if (this.locked) return;
            this.list.css(this.lt, this.pos(this.options.offset) + 'px');
            var p = this.pos(this.options.start);
            this.prevFirst = this.prevLast = null;
            this.animate(p, false);
            $(window).unbind('resize', this.funcResize).bind('resize', this.funcResize)
        },
        reset: function() {
            this.list.empty();
            this.list.css(this.lt, '0px');
            this.list.css(this.wh, '10px');
            if (this.options.initCallback != null) this.options.initCallback(this, 'reset');
            this.setup()
        },
        reload: function() {
            if (this.tail != null && this.inTail) this.list.css(this.lt, r.intval(this.list.css(this.lt)) + this.tail);
            this.tail = null;
            this.inTail = false;
            if (this.options.reloadCallback != null) this.options.reloadCallback(this);
            if (this.options.visible != null) {
                var a = this;
                var b = Math.ceil(this.clipping() / this.options.visible),
                    wh = 0,
                    lt = 0;
                $('li', this.list).each(function(i) {
                    wh += a.dimension(this, b);
                    if (i + 1 < a.first) lt = wh
                });
                this.list.css(this.wh, wh + 'px');
                this.list.css(this.lt, -lt + 'px')
            }
            this.scroll(this.first, false)
        },
        lock: function() {
            this.locked = true;
            this.buttons()
        },
        unlock: function() {
            this.locked = false;
            this.buttons()
        },
        size: function(s) {
            if (s != undefined) {
                this.options.size = s;
                if (!this.locked) this.buttons()
            }
            return this.options.size
        },
        has: function(i, a) {
            if (a == undefined || !a) a = i;
            if (this.options.size !== null && a > this.options.size) a = this.options.size;
            for (var j = i; j <= a; j++) {
                var e = this.get(j);
                if (!e.length || e.hasClass('jcarousel-item-placeholder')) return false
            }
            return true
        },
        get: function(i) {
            return $('.jcarousel-item-' + i, this.list)
        },
        add: function(i, s) {
            var e = this.get(i),
                old = 0,
                add = 0;
            if (e.length == 0) {
                var c, e = this.create(i),
                    j = r.intval(i);
                while (c = this.get(--j)) {
                    if (j <= 0 || c.length) {
                        j <= 0 ? this.list.prepend(e) : c.after(e);
                        break
                    }
                }
            } else old = this.dimension(e);
            e.removeClass(this.className('jcarousel-item-placeholder'));
            typeof s == 'string' ? e.html(s) : e.empty().append(s);
            var a = this.options.visible != null ? Math.ceil(this.clipping() / this.options.visible) : null;
            var b = this.dimension(e, a) - old;
            if (i > 0 && i < this.first) this.list.css(this.lt, r.intval(this.list.css(this.lt)) - b + 'px');
            this.list.css(this.wh, r.intval(this.list.css(this.wh)) + b + 'px');
            return e
        },
        remove: function(i) {
            var e = this.get(i);
            if (!e.length || (i >= this.first && i <= this.last)) return;
            var d = this.dimension(e);
            if (i < this.first) this.list.css(this.lt, r.intval(this.list.css(this.lt)) + d + 'px');
            e.remove();
            this.list.css(this.wh, r.intval(this.list.css(this.wh)) - d + 'px')
        },
        next: function() {
            this.stopAuto();
            if (this.tail != null && !this.inTail) this.scrollTail(false);
            else this.scroll(((this.options.wrap == 'both' || this.options.wrap == 'last') && this.options.size != null && this.last == this.options.size) ? 1 : this.first + this.options.scroll)
        },
        prev: function() {
            this.stopAuto();
            if (this.tail != null && this.inTail) this.scrollTail(true);
            else this.scroll(((this.options.wrap == 'both' || this.options.wrap == 'first') && this.options.size != null && this.first == 1) ? this.options.size : this.first - this.options.scroll)
        },
        scrollTail: function(b) {
            if (this.locked || this.animating || !this.tail) return;
            var a = r.intval(this.list.css(this.lt));
            !b ? a -= this.tail : a += this.tail;
            this.inTail = !b;
            this.prevFirst = this.first;
            this.prevLast = this.last;
            this.animate(a)
        },
        scroll: function(i, a) {
            if (this.locked || this.animating) return;
            this.animate(this.pos(i), a)
        },
        pos: function(i) {
            if (this.locked || this.animating) return;
            if (this.options.wrap != 'circular') i = i < 1 ? 1 : (this.options.size && i > this.options.size ? this.options.size : i);
            var a = this.first > i;
            var b = r.intval(this.list.css(this.lt));
            var f = this.options.wrap != 'circular' && this.first <= 1 ? 1 : this.first;
            var c = a ? this.get(f) : this.get(this.last);
            var j = a ? f : f - 1;
            var e = null,
                l = 0,
                p = false,
                d = 0;
            while (a ? --j >= i : ++j < i) {
                e = this.get(j);
                p = !e.length;
                if (e.length == 0) {
                    e = this.create(j).addClass(this.className('jcarousel-item-placeholder'));
                    c[a ? 'before' : 'after'](e)
                }
                c = e;
                d = this.dimension(e);
                if (p) l += d;
                if (this.first != null && (this.options.wrap == 'circular' || (j >= 1 && (this.options.size == null || j <= this.options.size)))) b = a ? b + d : b - d
            }
            var g = this.clipping();
            var h = [];
            var k = 0,
                j = i,
                v = 0;
            var c = this.get(i - 1);
            while (++k) {
                e = this.get(j);
                p = !e.length;
                if (e.length == 0) {
                    e = this.create(j).addClass(this.className('jcarousel-item-placeholder'));
                    c.length == 0 ? this.list.prepend(e) : c[a ? 'before' : 'after'](e)
                }
                c = e;
                var d = this.dimension(e);
                if (d == 0) {
                    alert('jCarousel: No width/height set for items. This will cause an infinite loop. Aborting...');
                    return 0
                }
                if (this.options.wrap != 'circular' && this.options.size !== null && j > this.options.size) h.push(e);
                else if (p) l += d;
                v += d;
                if (v >= g) break;
                j++
            }
            for (var x = 0; x < h.length; x++) h[x].remove();
            if (l > 0) {
                this.list.css(this.wh, this.dimension(this.list) + l + 'px');
                if (a) {
                    b -= l;
                    this.list.css(this.lt, r.intval(this.list.css(this.lt)) - l + 'px')
                }
            }
            var n = i + k - 1;
            if (this.options.wrap != 'circular' && this.options.size && n > this.options.size) n = this.options.size;
            if (j > n) {
                k = 0, j = n, v = 0;
                while (++k) {
                    var e = this.get(j--);
                    if (!e.length) break;
                    v += this.dimension(e);
                    if (v >= g) break
                }
            }
            var o = n - k + 1;
            if (this.options.wrap != 'circular' && o < 1) o = 1;
            if (this.inTail && a) {
                b += this.tail;
                this.inTail = false
            }
            this.tail = null;
            if (this.options.wrap != 'circular' && n == this.options.size && (n - k + 1) >= 1) {
                var m = r.margin(this.get(n), !this.options.vertical ? 'marginRight' : 'marginBottom');
                if ((v - m) > g) this.tail = v - g - m
            }
            while (i-- > o) b += this.dimension(this.get(i));
            this.prevFirst = this.first;
            this.prevLast = this.last;
            this.first = o;
            this.last = n;
            return b
        },
        animate: function(p, a) {
            if (this.locked || this.animating) return;
            this.animating = true;
            var b = this;
            var c = function() {
                b.animating = false;
                if (p == 0) b.list.css(b.lt, 0);
                if (b.options.wrap == 'both' || b.options.wrap == 'last' || b.options.size == null || b.last < b.options.size) b.startAuto();
                b.buttons();
                b.notify('onAfterAnimation')
            };
            this.notify('onBeforeAnimation');
            if (!this.options.animation || a == false) {
                this.list.css(this.lt, p + 'px');
                c()
            } else {
                var o = !this.options.vertical ? {
                    'left': p
                } : {
                    'top': p
                };
                this.list.animate(o, this.options.animation, this.options.easing, c)
            }
        },
        startAuto: function(s) {
            if (s != undefined) this.options.auto = s;
            if (this.options.auto == 0) return this.stopAuto();
            if (this.timer != null) return;
            var a = this;
            this.timer = setTimeout(function() {
                a.next()
            }, this.options.auto * 1000)
        },
        stopAuto: function() {
            if (this.timer == null) return;
            clearTimeout(this.timer);
            this.timer = null
        },
        buttons: function(n, p) {
            if (n == undefined || n == null) {
                var n = !this.locked && this.options.size !== 0 && ((this.options.wrap && this.options.wrap != 'first') || this.options.size == null || this.last < this.options.size);
                if (!this.locked && (!this.options.wrap || this.options.wrap == 'first') && this.options.size != null && this.last >= this.options.size) n = this.tail != null && !this.inTail
            }
            if (p == undefined || p == null) {
                var p = !this.locked && this.options.size !== 0 && ((this.options.wrap && this.options.wrap != 'last') || this.first > 1);
                if (!this.locked && (!this.options.wrap || this.options.wrap == 'last') && this.options.size != null && this.first == 1) p = this.tail != null && this.inTail
            }
            var a = this;
            this.buttonNext[n ? 'bind' : 'unbind'](this.options.buttonNextEvent, this.funcNext)[n ? 'removeClass' : 'addClass'](this.className('jcarousel-next-disabled')).attr('disabled', n ? false : true);
            this.buttonPrev[p ? 'bind' : 'unbind'](this.options.buttonPrevEvent, this.funcPrev)[p ? 'removeClass' : 'addClass'](this.className('jcarousel-prev-disabled')).attr('disabled', p ? false : true);
            if (this.buttonNext.length > 0 && (this.buttonNext[0].jcarouselstate == undefined || this.buttonNext[0].jcarouselstate != n) && this.options.buttonNextCallback != null) {
                this.buttonNext.each(function() {
                    a.options.buttonNextCallback(a, this, n)
                });
                this.buttonNext[0].jcarouselstate = n
            }
            if (this.buttonPrev.length > 0 && (this.buttonPrev[0].jcarouselstate == undefined || this.buttonPrev[0].jcarouselstate != p) && this.options.buttonPrevCallback != null) {
                this.buttonPrev.each(function() {
                    a.options.buttonPrevCallback(a, this, p)
                });
                this.buttonPrev[0].jcarouselstate = p
            }
        },
        notify: function(a) {
            var b = this.prevFirst == null ? 'init' : (this.prevFirst < this.first ? 'next' : 'prev');
            this.callback('itemLoadCallback', a, b);
            if (this.prevFirst !== this.first) {
                this.callback('itemFirstInCallback', a, b, this.first);
                this.callback('itemFirstOutCallback', a, b, this.prevFirst)
            }
            if (this.prevLast !== this.last) {
                this.callback('itemLastInCallback', a, b, this.last);
                this.callback('itemLastOutCallback', a, b, this.prevLast)
            }
            this.callback('itemVisibleInCallback', a, b, this.first, this.last, this.prevFirst, this.prevLast);
            this.callback('itemVisibleOutCallback', a, b, this.prevFirst, this.prevLast, this.first, this.last)
        },
        callback: function(a, b, c, d, e, f, g) {
            if (this.options[a] == undefined || (typeof this.options[a] != 'object' && b != 'onAfterAnimation')) return;
            var h = typeof this.options[a] == 'object' ? this.options[a][b] : this.options[a];
            if (!$.isFunction(h)) return;
            var j = this;
            if (d === undefined) h(j, c, b);
            else if (e === undefined) this.get(d).each(function() {
                h(j, this, d, c, b)
            });
            else {
                for (var i = d; i <= e; i++)
                    if (i !== null && !(i >= f && i <= g)) this.get(i).each(function() {
                        h(j, this, i, c, b)
                    })
            }
        },
        create: function(i) {
            return this.format('<li></li>', i)
        },
        format: function(e, i) {
            var a = $(e).addClass(this.className('jcarousel-item')).addClass(this.className('jcarousel-item-' + i));
            a.attr('jcarouselindex', i);
            return a
        },
        className: function(c) {
            return c + ' ' + c + (!this.options.vertical ? '-horizontal' : '-vertical')
        },
        dimension: function(e, d) {
            var a = e.jquery != undefined ? e[0] : e;
            var b = !this.options.vertical ? a.offsetWidth + r.margin(a, 'marginLeft') + r.margin(a, 'marginRight') : a.offsetHeight + r.margin(a, 'marginTop') + r.margin(a, 'marginBottom');
            if (d == undefined || b == d) return b;
            var w = !this.options.vertical ? d - r.margin(a, 'marginLeft') - r.margin(a, 'marginRight') : d - r.margin(a, 'marginTop') - r.margin(a, 'marginBottom');
            $(a).css(this.wh, w + 'px');
            return this.dimension(a)
        },
        clipping: function() {
            return !this.options.vertical ? this.clip[0].offsetWidth - r.intval(this.clip.css('borderLeftWidth')) - r.intval(this.clip.css('borderRightWidth')) : this.clip[0].offsetHeight - r.intval(this.clip.css('borderTopWidth')) - r.intval(this.clip.css('borderBottomWidth'))
        },
        index: function(i, s) {
            if (s == undefined) s = this.options.size;
            return Math.round((((i - 1) / s) - Math.floor((i - 1) / s)) * s) + 1
        }
    });
    r.extend({
        defaults: function(d) {
            return $.extend(q, d || {})
        },
        margin: function(e, p) {
            if (!e) return 0;
            var a = e.jquery != undefined ? e[0] : e;
            if (p == 'marginRight' && $.browser.safari) {
                var b = {
                        'display': 'block',
                        'float': 'none',
                        'width': 'auto'
                    },
                    oWidth, oWidth2;
                $.swap(a, b, function() {
                    oWidth = a.offsetWidth
                });
                b['marginRight'] = 0;
                $.swap(a, b, function() {
                    oWidth2 = a.offsetWidth
                });
                return oWidth2 - oWidth
            }
            return r.intval($.css(a, p))
        },
        intval: function(v) {
            v = parseInt(v);
            return isNaN(v) ? 0 : v
        }
    })
})(jQuery);


/**
 * jQuery.ScrollTo - Easy element scrolling using jQuery.
 * Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 5/25/2009
 * @author Ariel Flesler
 * @version 1.4.2
 *
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 */
;
(function(d) {
    var k = d.scrollTo = function(a, i, e) {
        d(window).scrollTo(a, i, e)
    };
    k.defaults = {
        axis: 'xy',
        duration: parseFloat(d.fn.jquery) >= 1.3 ? 0 : 1
    };
    k.window = function(a) {
        return d(window)._scrollable()
    };
    d.fn._scrollable = function() {
        return this.map(function() {
            var a = this,
                i = !a.nodeName || d.inArray(a.nodeName.toLowerCase(), ['iframe', '#document', 'html', 'body']) != -1;
            if (!i) return a;
            var e = (a.contentWindow || a).document || a.ownerDocument || a;
            return d.browser.safari || e.compatMode == 'BackCompat' ? e.body : e.documentElement
        })
    };
    d.fn.scrollTo = function(n, j, b) {
        if (typeof j == 'object') {
            b = j;
            j = 0
        }
        if (typeof b == 'function') b = {
            onAfter: b
        };
        if (n == 'max') n = 9e9;
        b = d.extend({}, k.defaults, b);
        j = j || b.speed || b.duration;
        b.queue = b.queue && b.axis.length > 1;
        if (b.queue) j /= 2;
        b.offset = p(b.offset);
        b.over = p(b.over);
        return this._scrollable().each(function() {
            var q = this,
                r = d(q),
                f = n,
                s, g = {},
                u = r.is('html,body');
            switch (typeof f) {
                case 'number':
                case 'string':
                    if (/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(f)) {
                        f = p(f);
                        break
                    }
                    f = d(f, this);
                case 'object':
                    if (f.is || f.style) s = (f = d(f)).offset()
            }
            d.each(b.axis.split(''), function(a, i) {
                var e = i == 'x' ? 'Left' : 'Top',
                    h = e.toLowerCase(),
                    c = 'scroll' + e,
                    l = q[c],
                    m = k.max(q, i);
                if (s) {
                    g[c] = s[h] + (u ? 0 : l - r.offset()[h]);
                    if (b.margin) {
                        g[c] -= parseInt(f.css('margin' + e)) || 0;
                        g[c] -= parseInt(f.css('border' + e + 'Width')) || 0
                    }
                    g[c] += b.offset[h] || 0;
                    if (b.over[h]) g[c] += f[i == 'x' ? 'width' : 'height']() * b.over[h]
                } else {
                    var o = f[h];
                    g[c] = o.slice && o.slice(-1) == '%' ? parseFloat(o) / 100 * m : o
                }
                if (/^\d+$/.test(g[c])) g[c] = g[c] <= 0 ? 0 : Math.min(g[c], m);
                if (!a && b.queue) {
                    if (l != g[c]) t(b.onAfterFirst);
                    delete g[c]
                }
            });
            t(b.onAfter);

            function t(a) {
                r.animate(g, j, b.easing, a && function() {
                    a.call(this, n, b)
                })
            }
        }).end()
    };
    k.max = function(a, i) {
        var e = i == 'x' ? 'Width' : 'Height',
            h = 'scroll' + e;
        if (!d(a).is('html,body')) return a[h] - d(a)[e.toLowerCase()]();
        var c = 'client' + e,
            l = a.ownerDocument.documentElement,
            m = a.ownerDocument.body;
        return Math.max(l[h], m[h]) - Math.min(l[c], m[c])
    };

    function p(a) {
        return typeof a == 'object' ? a : {
            top: a,
            left: a
        }
    }
})(jQuery);


//http://media.kobster.com/themes/theme335/js/quancorrect.js
function checkMinimalQuantityList(id_product, minimal_quantity) {
    var name = '#'.concat(id_product, "_quantity_wanted");

    if ($(name).val() < minimal_quantity) {
        $(name).css('border', '1px solid red');
    } else {
        $(name).css('border', '1px solid #000000');
    }
}

function checkMinimalQuantityListQV(id_product, minimal_quantity) {
    var name = '#'.concat(id_product, "_qv_quantity_wanted");

    if ($(name).val() < minimal_quantity) {
        $(name).css('border', '1px solid red');
    } else {
        $(name).css('border', '1px solid #000000');
    }
}

function checkMinimalQuantityListLV(id_product, minimal_quantity) {
    var name = '#'.concat(id_product, "_lv_quantity_wanted");

    if ($(name).val() < minimal_quantity) {
        $(name).css('border', '1px solid red');
    } else {
        $(name).css('border', '1px solid #000000');
    }
}

//show the order-details with ajax
function showOrder(mode, var_content, file) {
    var url;
    if (file.match(/^https?:\/\//))
        url = file;
    else
        url = baseDir + file + '.php';

    $.get(
        url, ((mode == 1) ? {
            'id_order': var_content,
            'ajax': true
        } : {
            'id_order_return': var_content,
            'ajax': true
        }),
        function(data) {
            $('#block-order-detail').fadeOut('slow', function() {
                $(this).html(data);
                /* if return is allowed*/
                if ($('div#order-detail-content table td.order_cb').length > 0) {
                    //return slip : check or uncheck every checkboxes
                    $('form div#order-detail-content th input[type=checkbox]').click(function() {
                        $('form div#order-detail-content td input[type=checkbox]').each(function() {
                            this.checked = $('form div#order-detail-content th input[type=checkbox]').is(':checked');
                            updateOrderLineDisplay(this);
                        });
                    });
                    //return slip : enable or disable 'global' quantity editing
                    $('form div#order-detail-content td input[type=checkbox]').click(function() {
                        updateOrderLineDisplay(this);
                    });
                    //return slip : limit quantities
                    $('form div#order-detail-content td input.order_qte_input').keyup(function() {
                        var maxQuantity = parseInt($(this).parent().find('span.order_qte_span').text());
                        var quantity = parseInt($(this).val());
                        if (isNaN($(this).val()) && $(this).val() != '') {
                            $(this).val(maxQuantity);
                        } else {
                            if (quantity > maxQuantity)
                                $(this).val(maxQuantity);
                            else if (quantity < 1)
                                $(this).val(1);
                        }
                    });
                }
                //catch the submit event of sendOrderMessage form
                $('form#sendOrderMessage').submit(function() {
                    return sendOrderMessage();
                });
                $(this).fadeIn('slow');
                $.scrollTo(this, 1200);
                if (typeof(resizeAddressesBox) == 'function')
                    resizeAddressesBox();
            });
        });
}

function updateOrderLineDisplay(domCheckbox) {
    var lineQuantitySpan = $(domCheckbox).parent().parent().find('span.order_qte_span');
    var lineQuantityInput = $(domCheckbox).parent().parent().find('input.order_qte_input');
    if ($(domCheckbox).is(':checked')) {
        lineQuantitySpan.hide();
        lineQuantityInput.show();
    } else {
        lineQuantityInput.hide();
        lineQuantityInput.val(lineQuantitySpan.text());
        lineQuantitySpan.show();
    }
}

//send a message in relation to the order with ajax
function sendOrderMessage() {
    paramString = "ajax=true";
    $('form#sendOrderMessage').find('input, textarea').each(function() {
        paramString += '&' + $(this).attr('name') + '=' + encodeURI($(this).val());
    });
    $.ajax({
        type: "POST",
        url: baseDir + "order-detail.php",
        data: paramString,
        success: function(msg) {
            $('#block-order-detail').fadeOut('slow', function() {
                $(this).html(msg);
                //catch the submit event of sendOrderMessage form
                $('form#sendOrderMessage').submit(function() {
                    return sendOrderMessage();
                });
                $(this).fadeIn('slow');
            });
        }
    });
    return false;
}

//themes/theme335/js/tools.js
function ps_round(value, precision) {
    if (typeof(roundMode) == 'undefined')
        roundMode = 2;
    if (typeof(precision) == 'undefined')
        precision = 2;

    method = roundMode;
    if (method == 0)
        return ceilf(value, precision);
    else if (method == 1)
        return floorf(value, precision);
    precisionFactor = precision == 0 ? 1 : Math.pow(10, precision);
    return Math.round(value * precisionFactor) / precisionFactor;
}

function ceilf(value, precision) {
    if (typeof(precision) == 'undefined')
        precision = 0;
    precisionFactor = precision == 0 ? 1 : Math.pow(10, precision);
    tmp = value * precisionFactor;
    tmp2 = tmp.toString();
    if (tmp2[tmp2.length - 1] == 0)
        return value;
    return Math.ceil(value * precisionFactor) / precisionFactor;
}

function floorf(value, precision) {
    if (typeof(precision) == 'undefined')
        precision = 0;
    precisionFactor = precision == 0 ? 1 : Math.pow(10, precision);
    tmp = value * precisionFactor;
    tmp2 = tmp.toString();
    if (tmp2[tmp2.length - 1] == 0)
        return value;
    return Math.floor(value * precisionFactor) / precisionFactor;
}

function formatedNumberToFloat(price, currencyFormat, currencySign) {
    price = price.replace(currencySign, '');
    if (currencyFormat == 1)
        return parseFloat(price.replace(',', '').replace(' ', ''));
    else if (currencyFormat == 2)
        return parseFloat(price.replace(' ', '').replace(',', '.'));
    else if (currencyFormat == 3)
        return parseFloat(price.replace('.', '').replace(' ', '').replace(',', '.'));
    else if (currencyFormat == 4)
        return parseFloat(price.replace(',', '').replace(' ', ''));
    return price;
}

//return a formatted price
function formatCurrency(price, currencyFormat, currencySign, currencyBlank) {
    // if you modified this function, don't forget to modify the PHP function displayPrice (in the Tools.php class)
    blank = '';
    price = parseFloat(price.toFixed(6));
    price = ps_round(price, priceDisplayPrecision);
    if (currencyBlank > 0)
        blank = ' ';
    if (currencyFormat == 1)
        return currencySign + blank + formatNumber(price, priceDisplayPrecision, ',', '.');
    if (currencyFormat == 2)
        return (formatNumber(price, priceDisplayPrecision, ' ', ',') + blank + currencySign);
    if (currencyFormat == 3)
        return (currencySign + blank + formatNumber(price, priceDisplayPrecision, '.', ','));
    if (currencyFormat == 4)
        return (formatNumber(price, priceDisplayPrecision, ',', '.') + blank + currencySign);
    return price;
}

//return a formatted number
function formatNumber(value, numberOfDecimal, thousenSeparator, virgule) {
    value = value.toFixed(numberOfDecimal);
    var val_string = value + '';
    var tmp = val_string.split('.');
    var abs_val_string = (tmp.length == 2) ? tmp[0] : val_string;
    var deci_string = ('0.' + (tmp.length == 2 ? tmp[1] : 0)).substr(2);
    var nb = abs_val_string.length;

    for (var i = 1; i < 4; i++)
        if (value >= Math.pow(10, (3 * i)))
            abs_val_string = abs_val_string.substring(0, nb - (3 * i)) + thousenSeparator + abs_val_string.substring(nb - (3 * i));

    if (parseInt(numberOfDecimal) == 0)
        return abs_val_string;
    return abs_val_string + virgule + (deci_string > 0 ? deci_string : '00');
}

//change the text of a jQuery element with a sliding effect (velocity could be a number in ms, 'slow' or 'fast', effect1 and effect2 could be slide, fade, hide, show)
function updateTextWithEffect(jQueryElement, text, velocity, effect1, effect2, newClass) {
    if (jQueryElement.text() != text)
        if (effect1 == 'fade')
            jQueryElement.fadeOut(velocity, function() {
                $(this).addClass(newClass);
                if (effect2 == 'fade') $(this).text(text).fadeIn(velocity);
                else if (effect2 == 'slide') $(this).text(text).slideDown(velocity);
                else if (effect2 == 'show') $(this).text(text).show(velocity, function() {});
            });
        else if (effect1 == 'slide')
        jQueryElement.slideUp(velocity, function() {
            $(this).addClass(newClass);
            if (effect2 == 'fade') $(this).text(text).fadeIn(velocity);
            else if (effect2 == 'slide') $(this).text(text).slideDown(velocity);
            else if (effect2 == 'show') $(this).text(text).show(velocity);
        });
    else if (effect1 == 'hide')
        jQueryElement.hide(velocity, function() {
            $(this).addClass(newClass);
            if (effect2 == 'fade') $(this).text(text).fadeIn(velocity);
            else if (effect2 == 'slide') $(this).text(text).slideDown(velocity);
            else if (effect2 == 'show') $(this).text(text).show(velocity);
        });
}

//show a JS debug
function dbg(value) {
    var active = false; //true for active
    var firefox = true; //true if debug under firefox

    if (active)
        if (firefox)
            console.log(value);
        else
            alert(value);
}

/**
 * Function : print_r()
 * Arguments: The data  - array,hash(associative array),object
 *            The level - OPTIONAL
 * Returns  : The textual representation of the array.
 * This function was inspired by the print_r function of PHP.
 * This will accept some data as the argument and return a
 * text that will be a more readable version of the
 * array/hash/object that is given.
 */
function print_r(arr, level) {
    var dumped_text = "";
    if (!level)
        level = 0;

    //The padding given at the beginning of the line.
    var level_padding = "";
    for (var j = 0; j < level + 1; j++)
        level_padding += "    ";

    if (typeof(arr) == 'object') { //Array/Hashes/Objects 
        for (var item in arr) {
            var value = arr[item];
            if (typeof(value) == 'object') { //If it is an array,
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += dump(value, level + 1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
            }
        }
    } else { //Stings/Chars/Numbers etc.
        dumped_text = "===>" + arr + "<===(" + typeof(arr) + ")";
    }
    return dumped_text;
}

//verify if value is in the array
function in_array(value, array) {
    for (var i in array)
        if (array[i] == value)
            return true;
    return false;
}

function resizeAddressesBox(nameBox) {
    maxHeight = 0;

    if (typeof(nameBox) == 'undefined')
        nameBox = '.address';
    $(nameBox).each(function() {
        $(this).css('height', 'auto');
        currentHeight = $(this).height();
        if (maxHeight < currentHeight)
            maxHeight = currentHeight;
    });
    $(nameBox).height(maxHeight);
}

/* jQuery Cat Slider */
;
(function($, window, undefined) {

    'use strict';

    $.CatSlider = function(options, element) {

        this.$el = $(element);
        this._init(options);
    };

    $.CatSlider.prototype = {

        _init: function(options) {

            // the categories (ul)
            this.$categories = this.$el.children('ul');
            // the navigation
            this.$navcategories = this.$el.find('nav > a');
            var animEndEventNames = {
                'WebkitAnimation': 'webkitAnimationEnd',
                'OAnimation': 'oAnimationEnd',
                'msAnimation': 'MSAnimationEnd',
                'animation': 'animationend'
            };
            // animation end event name
            this.animEndEventName = animEndEventNames[Modernizr.prefixed('animation')];
            // animations and transforms support
            this.support = Modernizr.csstransforms && Modernizr.cssanimations;
            // if currently animating
            this.isAnimating = false;
            // current category
            this.current = 0;
            var $currcat = this.$categories.eq(0);
            if (!this.support) {
                this.$categories.hide();
                $currcat.show();
            } else {
                $currcat.addClass('mi-current');
            }
            // current nav category
            this.$navcategories.eq(0).addClass('mi-selected');
            // initialize the events
            this._initEvents();

        },
        _initEvents: function() {

            var self = this;
            this.$navcategories.on('click.catslider', function() {
                self.showCategory($(this).index());
                return false;
            });

            // reset on window resize..
            $(window).on('resize', function() {
                self.$categories.removeClass().eq(0).addClass('mi-current');
                self.$navcategories.eq(self.current).removeClass('mi-selected').end().eq(0).addClass('mi-selected');
                self.current = 0;
            });

        },
        showCategory: function(catidx) {
            if (catidx === this.current || this.isAnimating) {
                return false;
            }
            this.isAnimating = true;
            // update selected navigation
            this.$navcategories.eq(this.current).removeClass('mi-selected').end().eq(catidx).addClass('mi-selected');

            var dir = catidx > this.current ? 'right' : 'left',
                toClass = dir === 'right' ? 'mi-moveToLeft' : 'mi-moveToRight',
                fromClass = dir === 'right' ? 'mi-moveFromRight' : 'mi-moveFromLeft',
                // current category
                $currcat = this.$categories.eq(this.current),
                // new category
                $newcat = this.$categories.eq(catidx),
                $newcatchild = $newcat.children(),
                lastEnter = dir === 'right' ? $newcatchild.length - 1 : 0,
                self = this;
            if (this.support) {

                $currcat.removeClass().addClass(toClass);

                setTimeout(function() {

                    $newcat.removeClass().addClass(fromClass);
                    $newcatchild.eq(lastEnter).on(self.animEndEventName, function() {

                        $(this).off(self.animEndEventName);
                        $newcat.addClass('mi-current');
                        self.current = catidx;
                        var $this = $(this);
                        // solve chrome bug
                        self.forceRedraw($this.get(0));
                        self.isAnimating = false;

                    });

                }, $newcatchild.length * 90);

            } else {

                $currcat.hide();
                $newcat.show();
                this.current = catidx;
                this.isAnimating = false;

            }

        },
        // based on http://stackoverflow.com/a/8840703/989439
        forceRedraw: function(element) {
            if (!element) {
                return;
            }
            var n = document.createTextNode(' '),
                position = element.style.position;
            element.appendChild(n);
            element.style.position = 'relative';
            setTimeout(function() {
                element.style.position = position;
                n.parentNode.removeChild(n);
            }, 25);
        }

    }

    $.fn.catslider = function(options) {
        var instance = $.data(this, 'catslider');
        if (typeof options === 'string') {
            var args = Array.prototype.slice.call(arguments, 1);
            this.each(function() {
                instance[options].apply(instance, args);
            });
        } else {
            this.each(function() {
                instance ? instance._init() : instance = $.data(this, 'catslider', new $.CatSlider(options, this));
            });
        }
        return instance;
    };

})(jQuery, window);
/* End of cat slider */

/*
 * FancyBox - jQuery Plugin
 * Simple and fancy lightbox alternative
 *
 * Examples and documentation at: http://fancybox.net
 *
 * Copyright (c) 2008 - 2010 Janis Skarnelis
 * That said, it is hardly a one-person project. Many people have submitted bugs, code, and offered their advice freely. Their support is greatly appreciated.
 *
 * Version: 1.3.4 (11/11/2010)
 * Requires: jQuery v1.3+
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

;
(function($) {
    var tmp, loading, overlay, wrap, outer, content, close, title, nav_left, nav_right,

        selectedIndex = 0,
        selectedOpts = {},
        selectedArray = [],
        currentIndex = 0,
        currentOpts = {},
        currentArray = [],

        ajaxLoader = null,
        imgPreloader = new Image(),
        imgRegExp = /\.(jpg|gif|png|bmp|jpeg)(.*)?$/i,
        swfRegExp = /[^\.]\.(swf)\s*$/i,

        loadingTimer, loadingFrame = 1,

        titleHeight = 0,
        titleStr = '',
        start_pos, final_pos, busy = false,
        fx = $.extend($('<div/>')[0], {
            prop: 0
        }),

        isIE6 = $.browser.msie && $.browser.version < 7 && !window.XMLHttpRequest,

        /*
         * Private methods 
         */

        _abort = function() {
            loading.hide();

            imgPreloader.onerror = imgPreloader.onload = null;

            if (ajaxLoader) {
                ajaxLoader.abort();
            }

            tmp.empty();
        },

        _error = function() {
            if (false === selectedOpts.onError(selectedArray, selectedIndex, selectedOpts)) {
                loading.hide();
                busy = false;
                return;
            }

            selectedOpts.titleShow = false;

            selectedOpts.width = 'auto';
            selectedOpts.height = 'auto';

            tmp.html('<p id="fancybox-error">The requested content cannot be loaded.<br />Please try again later.</p>');

            _process_inline();
        },

        _start = function() {
            var obj = selectedArray[selectedIndex],
                href,
                type,
                title,
                str,
                emb,
                ret;

            _abort();

            selectedOpts = $.extend({}, $.fn.fancybox.defaults, (typeof $(obj).data('fancybox') == 'undefined' ? selectedOpts : $(obj).data('fancybox')));

            ret = selectedOpts.onStart(selectedArray, selectedIndex, selectedOpts);

            if (ret === false) {
                busy = false;
                return;
            } else if (typeof ret == 'object') {
                selectedOpts = $.extend(selectedOpts, ret);
            }

            title = selectedOpts.title || (obj.nodeName ? $(obj).attr('title') : obj.title) || '';

            if (obj.nodeName && !selectedOpts.orig) {
                selectedOpts.orig = $(obj).children("img:first").length ? $(obj).children("img:first") : $(obj);
            }

            if (title === '' && selectedOpts.orig && selectedOpts.titleFromAlt) {
                title = selectedOpts.orig.attr('alt');
            }

            href = selectedOpts.href || (obj.nodeName ? $(obj).attr('href') : obj.href) || null;

            if ((/^(?:javascript)/i).test(href) || href == '#') {
                href = null;
            }

            if (selectedOpts.type) {
                type = selectedOpts.type;

                if (!href) {
                    href = selectedOpts.content;
                }

            } else if (selectedOpts.content) {
                type = 'html';

            } else if (href) {
                if (href.match(imgRegExp)) {
                    type = 'image';

                } else if (href.match(swfRegExp)) {
                    type = 'swf';

                } else if ($(obj).hasClass("iframe")) {
                    type = 'iframe';

                } else if (href.indexOf("#") === 0) {
                    type = 'inline';

                } else {
                    type = 'ajax';
                }
            }

            if (!type) {
                _error();
                return;
            }

            if (type == 'inline') {
                obj = href.substr(href.indexOf("#"));
                type = $(obj).length > 0 ? 'inline' : 'ajax';
            }

            selectedOpts.type = type;
            selectedOpts.href = href;
            selectedOpts.title = title;

            if (selectedOpts.autoDimensions) {
                if (selectedOpts.type == 'html' || selectedOpts.type == 'inline' || selectedOpts.type == 'ajax') {
                    selectedOpts.width = 'auto';
                    selectedOpts.height = 'auto';
                } else {
                    selectedOpts.autoDimensions = false;
                }
            }

            if (selectedOpts.modal) {
                selectedOpts.overlayShow = true;
                selectedOpts.hideOnOverlayClick = false;
                selectedOpts.hideOnContentClick = false;
                selectedOpts.enableEscapeButton = false;
                selectedOpts.showCloseButton = false;
            }

            selectedOpts.padding = parseInt(selectedOpts.padding, 10);
            selectedOpts.margin = parseInt(selectedOpts.margin, 10);

            tmp.css('padding', (selectedOpts.padding + selectedOpts.margin));

            $('.fancybox-inline-tmp').unbind('fancybox-cancel').bind('fancybox-change', function() {
                $(this).replaceWith(content.children());
            });

            switch (type) {
                case 'html':
                    tmp.html(selectedOpts.content);
                    _process_inline();
                    break;

                case 'inline':
                    if ($(obj).parent().is('#fancybox-content') === true) {
                        busy = false;
                        return;
                    }

                    $('<div class="fancybox-inline-tmp" />')
                        .hide()
                        .insertBefore($(obj))
                        .bind('fancybox-cleanup', function() {
                            $(this).replaceWith(content.children());
                        }).bind('fancybox-cancel', function() {
                            $(this).replaceWith(tmp.children());
                        });

                    $(obj).appendTo(tmp);

                    _process_inline();
                    break;

                case 'image':
                    busy = false;

                    $.fancybox.showActivity();

                    imgPreloader = new Image();

                    imgPreloader.onerror = function() {
                        _error();
                    };

                    imgPreloader.onload = function() {
                        busy = true;

                        imgPreloader.onerror = imgPreloader.onload = null;

                        _process_image();
                    };

                    imgPreloader.src = href;
                    break;

                case 'swf':
                    selectedOpts.scrolling = 'no';

                    str = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' + selectedOpts.width + '" height="' + selectedOpts.height + '"><param name="movie" value="' + href + '"></param>';
                    emb = '';

                    $.each(selectedOpts.swf, function(name, val) {
                        str += '<param name="' + name + '" value="' + val + '"></param>';
                        emb += ' ' + name + '="' + val + '"';
                    });

                    str += '<embed src="' + href + '" type="application/x-shockwave-flash" width="' + selectedOpts.width + '" height="' + selectedOpts.height + '"' + emb + '></embed></object>';

                    tmp.html(str);

                    _process_inline();
                    break;

                case 'ajax':
                    busy = false;

                    $.fancybox.showActivity();

                    selectedOpts.ajax.win = selectedOpts.ajax.success;

                    ajaxLoader = $.ajax($.extend({}, selectedOpts.ajax, {
                        url: href,
                        data: selectedOpts.ajax.data || {},
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            if (XMLHttpRequest.status > 0) {
                                _error();
                            }
                        },
                        success: function(data, textStatus, XMLHttpRequest) {
                            var o = typeof XMLHttpRequest == 'object' ? XMLHttpRequest : ajaxLoader;
                            if (o.status == 200) {
                                if (typeof selectedOpts.ajax.win == 'function') {
                                    ret = selectedOpts.ajax.win(href, data, textStatus, XMLHttpRequest);

                                    if (ret === false) {
                                        loading.hide();
                                        return;
                                    } else if (typeof ret == 'string' || typeof ret == 'object') {
                                        data = ret;
                                    }
                                }

                                tmp.html(data);
                                _process_inline();
                            }
                        }
                    }));

                    break;

                case 'iframe':
                    _show();
                    break;
            }
        },

        _process_inline = function() {
            var
                w = selectedOpts.width,
                h = selectedOpts.height;

            if (w.toString().indexOf('%') > -1) {
                w = parseInt(($(window).width() - (selectedOpts.margin * 2)) * parseFloat(w) / 100, 10) + 'px';

            } else {
                w = w == 'auto' ? 'auto' : w + 'px';
            }

            if (h.toString().indexOf('%') > -1) {
                h = parseInt(($(window).height() - (selectedOpts.margin * 2)) * parseFloat(h) / 100, 10) + 'px';

            } else {
                h = h == 'auto' ? 'auto' : h + 'px';
            }

            tmp.wrapInner('<div style="width:' + w + ';height:' + h + ';overflow: ' + (selectedOpts.scrolling == 'auto' ? 'auto' : (selectedOpts.scrolling == 'yes' ? 'scroll' : 'hidden')) + ';position:relative;"></div>');

            selectedOpts.width = tmp.width();
            selectedOpts.height = tmp.height();

            _show();
        },

        _process_image = function() {
            selectedOpts.width = imgPreloader.width;
            selectedOpts.height = imgPreloader.height;

            $("<img />").attr({
                'id': 'fancybox-img',
                'src': imgPreloader.src,
                'alt': selectedOpts.title
            }).appendTo(tmp);

            _show();
        },

        _show = function() {
            var pos, equal;

            loading.hide();

            if (wrap.is(":visible") && false === currentOpts.onCleanup(currentArray, currentIndex, currentOpts)) {
                $.event.trigger('fancybox-cancel');

                busy = false;
                return;
            }

            busy = true;

            $(content.add(overlay)).unbind();

            $(window).unbind("resize.fb scroll.fb");
            $(document).unbind('keydown.fb');

            if (wrap.is(":visible") && currentOpts.titlePosition !== 'outside') {
                wrap.css('height', wrap.height());
            }

            currentArray = selectedArray;
            currentIndex = selectedIndex;
            currentOpts = selectedOpts;

            if (currentOpts.overlayShow) {
                overlay.css({
                    'background-color': currentOpts.overlayColor,
                    'opacity': currentOpts.overlayOpacity,
                    'cursor': currentOpts.hideOnOverlayClick ? 'pointer' : 'auto',
                    'height': $(document).height()
                });

                if (!overlay.is(':visible')) {
                    if (isIE6) {
                        $('select:not(#fancybox-tmp select)').filter(function() {
                            return this.style.visibility !== 'hidden';
                        }).css({
                            'visibility': 'hidden'
                        }).one('fancybox-cleanup', function() {
                            this.style.visibility = 'inherit';
                        });
                    }

                    overlay.show();
                }
            } else {
                overlay.hide();
            }

            final_pos = _get_zoom_to();

            _process_title();

            if (wrap.is(":visible")) {
                $(close.add(nav_left).add(nav_right)).hide();

                pos = wrap.position(),

                    start_pos = {
                        top: pos.top,
                        left: pos.left,
                        width: wrap.width(),
                        height: wrap.height()
                    };

                equal = (start_pos.width == final_pos.width && start_pos.height == final_pos.height);

                content.fadeTo(currentOpts.changeFade, 0.3, function() {
                    var finish_resizing = function() {
                        content.html(tmp.contents()).fadeTo(currentOpts.changeFade, 1, _finish);
                    };

                    $.event.trigger('fancybox-change');

                    content
                        .empty()
                        .removeAttr('filter')
                        .css({
                            'border-width': currentOpts.padding,
                            'width': final_pos.width - currentOpts.padding * 2,
                            'height': selectedOpts.autoDimensions ? 'auto' : final_pos.height - titleHeight - currentOpts.padding * 2
                        });

                    if (equal) {
                        finish_resizing();

                    } else {
                        fx.prop = 0;

                        $(fx).animate({
                            prop: 1
                        }, {
                            duration: currentOpts.changeSpeed,
                            easing: currentOpts.easingChange,
                            step: _draw,
                            complete: finish_resizing
                        });
                    }
                });

                return;
            }

            wrap.removeAttr("style");

            content.css('border-width', currentOpts.padding);

            if (currentOpts.transitionIn == 'elastic') {
                start_pos = _get_zoom_from();

                content.html(tmp.contents());

                wrap.show();

                if (currentOpts.opacity) {
                    final_pos.opacity = 0;
                }

                fx.prop = 0;

                $(fx).animate({
                    prop: 1
                }, {
                    duration: currentOpts.speedIn,
                    easing: currentOpts.easingIn,
                    step: _draw,
                    complete: _finish
                });

                return;
            }

            if (currentOpts.titlePosition == 'inside' && titleHeight > 0) {
                title.show();
            }

            content
                .css({
                    'width': final_pos.width - currentOpts.padding * 2,
                    'height': selectedOpts.autoDimensions ? 'auto' : final_pos.height - titleHeight - currentOpts.padding * 2
                })
                .html(tmp.contents());

            wrap
                .css(final_pos)
                .fadeIn(currentOpts.transitionIn == 'none' ? 0 : currentOpts.speedIn, _finish);
        },

        _format_title = function(title) {
            if (title && title.length) {
                if (currentOpts.titlePosition == 'float') {
                    return '<table id="fancybox-title-float-wrap" cellpadding="0" cellspacing="0"><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">' + title + '</td><td id="fancybox-title-float-right"></td></tr></table>';
                }

                return '<div id="fancybox-title-' + currentOpts.titlePosition + '">' + title + '</div>';
            }

            return false;
        },

        _process_title = function() {
            titleStr = currentOpts.title || '';
            titleHeight = 0;

            title
                .empty()
                .removeAttr('style')
                .removeClass();

            if (currentOpts.titleShow === false) {
                title.hide();
                return;
            }

            titleStr = $.isFunction(currentOpts.titleFormat) ? currentOpts.titleFormat(titleStr, currentArray, currentIndex, currentOpts) : _format_title(titleStr);

            if (!titleStr || titleStr === '') {
                title.hide();
                return;
            }

            title
                .addClass('fancybox-title-' + currentOpts.titlePosition)
                .html(titleStr)
                .appendTo('body')
                .show();

            switch (currentOpts.titlePosition) {
                case 'inside':
                    title
                        .css({
                            'width': final_pos.width - (currentOpts.padding * 2),
                            'marginLeft': currentOpts.padding,
                            'marginRight': currentOpts.padding
                        });

                    titleHeight = title.outerHeight(true);

                    title.appendTo(outer);

                    final_pos.height += titleHeight;
                    break;

                case 'over':
                    title
                        .css({
                            'marginLeft': currentOpts.padding,
                            'width': final_pos.width - (currentOpts.padding * 2),
                            'bottom': currentOpts.padding
                        })
                        .appendTo(outer);
                    break;

                case 'float':
                    title
                        .css('left', parseInt((title.width() - final_pos.width - 40) / 2, 10) * -1)
                        .appendTo(wrap);
                    break;

                default:
                    title
                        .css({
                            'width': final_pos.width - (currentOpts.padding * 2),
                            'paddingLeft': currentOpts.padding,
                            'paddingRight': currentOpts.padding
                        })
                        .appendTo(wrap);
                    break;
            }

            title.hide();
        },

        _set_navigation = function() {
            if (currentOpts.enableEscapeButton || currentOpts.enableKeyboardNav) {
                $(document).bind('keydown.fb', function(e) {
                    if (e.keyCode == 27 && currentOpts.enableEscapeButton) {
                        e.preventDefault();
                        $.fancybox.close();

                    } else if ((e.keyCode == 37 || e.keyCode == 39) && currentOpts.enableKeyboardNav && e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA' && e.target.tagName !== 'SELECT') {
                        e.preventDefault();
                        $.fancybox[e.keyCode == 37 ? 'prev' : 'next']();
                    }
                });
            }

            if (!currentOpts.showNavArrows) {
                nav_left.hide();
                nav_right.hide();
                return;
            }

            if ((currentOpts.cyclic && currentArray.length > 1) || currentIndex !== 0) {
                nav_left.show();
            }

            if ((currentOpts.cyclic && currentArray.length > 1) || currentIndex != (currentArray.length - 1)) {
                nav_right.show();
            }
        },

        _finish = function() {
            if (!$.support.opacity) {
                content.get(0).style.removeAttribute('filter');
                wrap.get(0).style.removeAttribute('filter');
            }

            if (selectedOpts.autoDimensions) {
                content.css('height', 'auto');
            }

            wrap.css('height', 'auto');

            if (titleStr && titleStr.length) {
                title.show();
            }

            if (currentOpts.showCloseButton) {
                close.show();
            }

            _set_navigation();

            if (currentOpts.hideOnContentClick) {
                content.bind('click', $.fancybox.close);
            }

            if (currentOpts.hideOnOverlayClick) {
                overlay.bind('click', $.fancybox.close);
            }

            $(window).bind("resize.fb", $.fancybox.resize);

            if (currentOpts.centerOnScroll) {
                $(window).bind("scroll.fb", $.fancybox.center);
            }

            if (currentOpts.type == 'iframe') {
                $('<iframe id="fancybox-frame" name="fancybox-frame' + new Date().getTime() + '" frameborder="0" hspace="0" ' + ($.browser.msie ? 'allowtransparency="true""' : '') + ' scrolling="' + selectedOpts.scrolling + '" src="' + currentOpts.href + '"></iframe>').appendTo(content);
            }

            wrap.show();

            busy = false;

            $.fancybox.center();

            currentOpts.onComplete(currentArray, currentIndex, currentOpts);

            _preload_images();
        },

        _preload_images = function() {
            var href,
                objNext;

            if ((currentArray.length - 1) > currentIndex) {
                href = currentArray[currentIndex + 1].href;

                if (typeof href !== 'undefined' && href.match(imgRegExp)) {
                    objNext = new Image();
                    objNext.src = href;
                }
            }

            if (currentIndex > 0) {
                href = currentArray[currentIndex - 1].href;

                if (typeof href !== 'undefined' && href.match(imgRegExp)) {
                    objNext = new Image();
                    objNext.src = href;
                }
            }
        },

        _draw = function(pos) {
            var dim = {
                width: parseInt(start_pos.width + (final_pos.width - start_pos.width) * pos, 10),
                height: parseInt(start_pos.height + (final_pos.height - start_pos.height) * pos, 10),

                top: parseInt(start_pos.top + (final_pos.top - start_pos.top) * pos, 10),
                left: parseInt(start_pos.left + (final_pos.left - start_pos.left) * pos, 10)
            };

            if (typeof final_pos.opacity !== 'undefined') {
                dim.opacity = pos < 0.5 ? 0.5 : pos;
            }

            wrap.css(dim);

            content.css({
                'width': dim.width - currentOpts.padding * 2,
                'height': dim.height - (titleHeight * pos) - currentOpts.padding * 2
            });
        },

        _get_viewport = function() {
            return [
                $(window).width() - (currentOpts.margin * 2),
                $(window).height() - (currentOpts.margin * 2),
                $(document).scrollLeft() + currentOpts.margin,
                $(document).scrollTop() + currentOpts.margin
            ];
        },

        _get_zoom_to = function() {
            var view = _get_viewport(),
                to = {},
                resize = currentOpts.autoScale,
                double_padding = currentOpts.padding * 2,
                ratio;

            if (currentOpts.width.toString().indexOf('%') > -1) {
                to.width = parseInt((view[0] * parseFloat(currentOpts.width)) / 100, 10);
            } else {
                to.width = currentOpts.width + double_padding;
            }

            if (currentOpts.height.toString().indexOf('%') > -1) {
                to.height = parseInt((view[1] * parseFloat(currentOpts.height)) / 100, 10);
            } else {
                to.height = currentOpts.height + double_padding;
            }

            if (resize && (to.width > view[0] || to.height > view[1])) {
                if (selectedOpts.type == 'image' || selectedOpts.type == 'swf') {
                    ratio = (currentOpts.width) / (currentOpts.height);

                    if ((to.width) > view[0]) {
                        to.width = view[0];
                        to.height = parseInt(((to.width - double_padding) / ratio) + double_padding, 10);
                    }

                    if ((to.height) > view[1]) {
                        to.height = view[1];
                        to.width = parseInt(((to.height - double_padding) * ratio) + double_padding, 10);
                    }

                } else {
                    to.width = Math.min(to.width, view[0]);
                    to.height = Math.min(to.height, view[1]);
                }
            }

            to.top = parseInt(Math.max(view[3] - 20, view[3] + ((view[1] - to.height - 40) * 0.5)), 10);
            to.left = parseInt(Math.max(view[2] - 20, view[2] + ((view[0] - to.width - 40) * 0.5)), 10);

            return to;
        },

        _get_obj_pos = function(obj) {
            var pos = obj.offset();

            pos.top += parseInt(obj.css('paddingTop'), 10) || 0;
            pos.left += parseInt(obj.css('paddingLeft'), 10) || 0;

            pos.top += parseInt(obj.css('border-top-width'), 10) || 0;
            pos.left += parseInt(obj.css('border-left-width'), 10) || 0;

            pos.width = obj.width();
            pos.height = obj.height();

            return pos;
        },

        _get_zoom_from = function() {
            var orig = selectedOpts.orig ? $(selectedOpts.orig) : false,
                from = {},
                pos,
                view;

            if (orig && orig.length) {
                pos = _get_obj_pos(orig);

                from = {
                    width: pos.width + (currentOpts.padding * 2),
                    height: pos.height + (currentOpts.padding * 2),
                    top: pos.top - currentOpts.padding - 20,
                    left: pos.left - currentOpts.padding - 20
                };

            } else {
                view = _get_viewport();

                from = {
                    width: currentOpts.padding * 2,
                    height: currentOpts.padding * 2,
                    top: parseInt(view[3] + view[1] * 0.5, 10),
                    left: parseInt(view[2] + view[0] * 0.5, 10)
                };
            }

            return from;
        },

        _animate_loading = function() {
            if (!loading.is(':visible')) {
                clearInterval(loadingTimer);
                return;
            }

            $('div', loading).css('top', (loadingFrame * -40) + 'px');

            loadingFrame = (loadingFrame + 1) % 12;
        };

    /*
     * Public methods 
     */

    $.fn.fancybox = function(options) {
        if (!$(this).length) {
            return this;
        }

        $(this)
            .data('fancybox', $.extend({}, options, ($.metadata ? $(this).metadata() : {})))
            .unbind('click.fb')
            .bind('click.fb', function(e) {
                e.preventDefault();

                if (busy) {
                    return;
                }

                busy = true;

                $(this).blur();

                selectedArray = [];
                selectedIndex = 0;

                var rel = $(this).attr('rel') || '';

                if (!rel || rel == '' || rel === 'nofollow') {
                    selectedArray.push(this);

                } else {
                    selectedArray = $("a[rel=" + rel + "], area[rel=" + rel + "]");
                    selectedIndex = selectedArray.index(this);
                }

                _start();

                return;
            });

        return this;
    };

    $.fancybox = function(obj) {
        var opts;

        if (busy) {
            return;
        }

        busy = true;
        opts = typeof arguments[1] !== 'undefined' ? arguments[1] : {};

        selectedArray = [];
        selectedIndex = parseInt(opts.index, 10) || 0;

        if ($.isArray(obj)) {
            for (var i = 0, j = obj.length; i < j; i++) {
                if (typeof obj[i] == 'object') {
                    $(obj[i]).data('fancybox', $.extend({}, opts, obj[i]));
                } else {
                    obj[i] = $({}).data('fancybox', $.extend({
                        content: obj[i]
                    }, opts));
                }
            }

            selectedArray = jQuery.merge(selectedArray, obj);

        } else {
            if (typeof obj == 'object') {
                $(obj).data('fancybox', $.extend({}, opts, obj));
            } else {
                obj = $({}).data('fancybox', $.extend({
                    content: obj
                }, opts));
            }

            selectedArray.push(obj);
        }

        if (selectedIndex > selectedArray.length || selectedIndex < 0) {
            selectedIndex = 0;
        }

        _start();
    };

    $.fancybox.showActivity = function() {
        clearInterval(loadingTimer);

        loading.show();
        loadingTimer = setInterval(_animate_loading, 66);
    };

    $.fancybox.hideActivity = function() {
        loading.hide();
    };

    $.fancybox.next = function() {
        return $.fancybox.pos(currentIndex + 1);
    };

    $.fancybox.prev = function() {
        return $.fancybox.pos(currentIndex - 1);
    };

    $.fancybox.pos = function(pos) {
        if (busy) {
            return;
        }

        pos = parseInt(pos);

        selectedArray = currentArray;

        if (pos > -1 && pos < currentArray.length) {
            selectedIndex = pos;
            _start();

        } else if (currentOpts.cyclic && currentArray.length > 1) {
            selectedIndex = pos >= currentArray.length ? 0 : currentArray.length - 1;
            _start();
        }

        return;
    };

    $.fancybox.cancel = function() {
        if (busy) {
            return;
        }

        busy = true;

        $.event.trigger('fancybox-cancel');

        _abort();

        selectedOpts.onCancel(selectedArray, selectedIndex, selectedOpts);

        busy = false;
    };

    // Note: within an iframe use - parent.$.fancybox.close();
    $.fancybox.close = function() {
        if (busy || wrap.is(':hidden')) {
            return;
        }

        busy = true;

        if (currentOpts && false === currentOpts.onCleanup(currentArray, currentIndex, currentOpts)) {
            busy = false;
            return;
        }

        _abort();

        $(close.add(nav_left).add(nav_right)).hide();

        $(content.add(overlay)).unbind();

        $(window).unbind("resize.fb scroll.fb");
        $(document).unbind('keydown.fb');

        content.find('iframe').attr('src', isIE6 && /^https/i.test(window.location.href || '') ? 'javascript:void(false)' : 'about:blank');

        if (currentOpts.titlePosition !== 'inside') {
            title.empty();
        }

        wrap.stop();

        function _cleanup() {
            overlay.fadeOut('fast');

            title.empty().hide();
            wrap.hide();

            $.event.trigger('fancybox-cleanup');

            content.empty();

            currentOpts.onClosed(currentArray, currentIndex, currentOpts);

            currentArray = selectedOpts = [];
            currentIndex = selectedIndex = 0;
            currentOpts = selectedOpts = {};

            busy = false;
        }

        if (currentOpts.transitionOut == 'elastic') {
            start_pos = _get_zoom_from();

            var pos = wrap.position();

            final_pos = {
                top: pos.top,
                left: pos.left,
                width: wrap.width(),
                height: wrap.height()
            };

            if (currentOpts.opacity) {
                final_pos.opacity = 1;
            }

            title.empty().hide();

            fx.prop = 1;

            $(fx).animate({
                prop: 0
            }, {
                duration: currentOpts.speedOut,
                easing: currentOpts.easingOut,
                step: _draw,
                complete: _cleanup
            });

        } else {
            wrap.fadeOut(currentOpts.transitionOut == 'none' ? 0 : currentOpts.speedOut, _cleanup);
        }
    };

    $.fancybox.resize = function() {
        if (overlay.is(':visible')) {
            overlay.css('height', $(document).height());
        }

        $.fancybox.center(true);
    };

    $.fancybox.center = function() {
        var view, align;

        if (busy) {
            return;
        }

        align = arguments[0] === true ? 1 : 0;
        view = _get_viewport();

        if (!align && (wrap.width() > view[0] || wrap.height() > view[1])) {
            return;
        }

        wrap
            .stop()
            .animate({
                'top': parseInt(Math.max(view[3] - 20, view[3] + ((view[1] - content.height() - 40) * 0.5) - currentOpts.padding)),
                'left': parseInt(Math.max(view[2] - 20, view[2] + ((view[0] - content.width() - 40) * 0.5) - currentOpts.padding))
            }, typeof arguments[0] == 'number' ? arguments[0] : 200);
    };

    $.fancybox.init = function() {
        if ($("#fancybox-wrap").length) {
            return;
        }

        $('body').append(
            tmp = $('<div id="fancybox-tmp"></div>'),
            loading = $('<div id="fancybox-loading"><div></div></div>'),
            overlay = $('<div id="fancybox-overlay"></div>'),
            wrap = $('<div id="fancybox-wrap"></div>')
        );

        outer = $('<div id="fancybox-outer"></div>')
            .append('<div class="fancybox-bg" id="fancybox-bg-n"></div><div class="fancybox-bg" id="fancybox-bg-ne"></div><div class="fancybox-bg" id="fancybox-bg-e"></div><div class="fancybox-bg" id="fancybox-bg-se"></div><div class="fancybox-bg" id="fancybox-bg-s"></div><div class="fancybox-bg" id="fancybox-bg-sw"></div><div class="fancybox-bg" id="fancybox-bg-w"></div><div class="fancybox-bg" id="fancybox-bg-nw"></div>')
            .appendTo(wrap);

        outer.append(
            content = $('<div id="fancybox-content"></div>'),
            close = $('<a id="fancybox-close"></a>'),
            title = $('<div id="fancybox-title"></div>'),

            nav_left = $('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),
            nav_right = $('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>')
        );

        close.click($.fancybox.close);
        loading.click($.fancybox.cancel);

        nav_left.click(function(e) {
            e.preventDefault();
            $.fancybox.prev();
        });

        nav_right.click(function(e) {
            e.preventDefault();
            $.fancybox.next();
        });

        if ($.fn.mousewheel) {
            wrap.bind('mousewheel.fb', function(e, delta) {
                if (busy) {
                    e.preventDefault();

                } else if ($(e.target).get(0).clientHeight == 0 || $(e.target).get(0).scrollHeight === $(e.target).get(0).clientHeight) {
                    e.preventDefault();
                    $.fancybox[delta > 0 ? 'prev' : 'next']();
                }
            });
        }

        if (!$.support.opacity) {
            wrap.addClass('fancybox-ie');
        }

        if (isIE6) {
            loading.addClass('fancybox-ie6');
            wrap.addClass('fancybox-ie6');

            $('<iframe id="fancybox-hide-sel-frame" src="' + (/^https/i.test(window.location.href || '') ? 'javascript:void(false)' : 'about:blank') + '" scrolling="no" border="0" frameborder="0" tabindex="-1"></iframe>').prependTo(outer);
        }
    };

    $.fn.fancybox.defaults = {
        padding: 10,
        margin: 40,
        opacity: false,
        modal: false,
        cyclic: false,
        scrolling: 'auto', // 'auto', 'yes' or 'no'

        width: 560,
        height: 340,

        autoScale: true,
        autoDimensions: true,
        centerOnScroll: false,

        ajax: {},
        swf: {
            wmode: 'transparent'
        },

        hideOnOverlayClick: true,
        hideOnContentClick: false,

        overlayShow: true,
        overlayOpacity: 0.7,
        overlayColor: '#777',

        titleShow: true,
        titlePosition: 'float', // 'float', 'outside', 'inside' or 'over'
        titleFormat: null,
        titleFromAlt: false,

        transitionIn: 'fade', // 'elastic', 'fade' or 'none'
        transitionOut: 'fade', // 'elastic', 'fade' or 'none'

        speedIn: 300,
        speedOut: 300,

        changeSpeed: 300,
        changeFade: 'fast',

        easingIn: 'swing',
        easingOut: 'swing',

        showCloseButton: true,
        showNavArrows: true,
        enableEscapeButton: true,
        enableKeyboardNav: true,

        onStart: function() {},
        onCancel: function() {},
        onComplete: function() {},
        onCleanup: function() {},
        onClosed: function() {},
        onError: function() {}
    };

    $(document).ready(function() {
        $.fancybox.init();
    });

})(jQuery);

/**
 * BxSlider v4.1.2 - Fully loaded, responsive content slider
 * http://bxslider.com
 *
 * Copyright 2014, Steven Wanderski - http://stevenwanderski.com - http://bxcreative.com
 * Written while drinking Belgian ales and listening to jazz
 *
 * Released under the MIT license - http://opensource.org/licenses/MIT
 */
! function(t) {
    var e = {},
        s = {
            mode: "horizontal",
            slideSelector: "",
            infiniteLoop: !1,
            hideControlOnEnd: !1,
            speed: 500,
            easing: null,
            slideMargin: 0,
            startSlide: 0,
            randomStart: !1,
            captions: !1,
            ticker: !1,
            tickerHover: !1,
            adaptiveHeight: !1,
            adaptiveHeightSpeed: 500,
            video: !1,
            useCSS: !0,
            preloadImages: "visible",
            responsive: !0,
            slideZIndex: 50,
            touchEnabled: !0,
            swipeThreshold: 50,
            oneToOneTouch: !0,
            preventDefaultSwipeX: !0,
            preventDefaultSwipeY: !1,
            pager: !0,
            pagerType: "full",
            pagerShortSeparator: " / ",
            pagerSelector: null,
            buildPager: null,
            pagerCustom: null,
            controls: !0,
            nextText: "Next",
            prevText: "Prev",
            nextSelector: null,
            prevSelector: null,
            autoControls: !1,
            startText: "Start",
            stopText: "Stop",
            autoControlsCombine: !1,
            autoControlsSelector: null,
            auto: !1,
            pause: 4e3,
            autoStart: !0,
            autoDirection: "next",
            autoHover: !1,
            autoDelay: 0,
            minSlides: 1,
            maxSlides: 1,
            moveSlides: 0,
            slideWidth: 0,
            onSliderLoad: function() {},
            onSlideBefore: function() {},
            onSlideAfter: function() {},
            onSlideNext: function() {},
            onSlidePrev: function() {},
            onSliderResize: function() {}
        };
    $('.bx-wrapper').remove();
    t.fn.bxSlider = function(n) {
        if (0 == this.length) return this;
        if (this.length > 1) return this.each(function() {
            t(this).bxSlider(n)
        }), this;
        var o = {},
            r = this;
        e.el = this;
        var a = t(window).width(),
            l = t(window).height(),
            d = function() {
                o.settings = t.extend({}, s, n), o.settings.slideWidth = parseInt(o.settings.slideWidth), o.children = r.children(o.settings.slideSelector), o.children.length < o.settings.minSlides && (o.settings.minSlides = o.children.length), o.children.length < o.settings.maxSlides && (o.settings.maxSlides = o.children.length), o.settings.randomStart && (o.settings.startSlide = Math.floor(Math.random() * o.children.length)), o.active = {
                    index: o.settings.startSlide
                }, o.carousel = o.settings.minSlides > 1 || o.settings.maxSlides > 1, o.carousel && (o.settings.preloadImages = "all"), o.minThreshold = o.settings.minSlides * o.settings.slideWidth + (o.settings.minSlides - 1) * o.settings.slideMargin, o.maxThreshold = o.settings.maxSlides * o.settings.slideWidth + (o.settings.maxSlides - 1) * o.settings.slideMargin, o.working = !1, o.controls = {}, o.interval = null, o.animProp = "vertical" == o.settings.mode ? "top" : "left", o.usingCSS = o.settings.useCSS && "fade" != o.settings.mode && function() {
                    var t = document.createElement("div"),
                        e = ["WebkitPerspective", "MozPerspective", "OPerspective", "msPerspective"];
                    for (var i in e)
                        if (void 0 !== t.style[e[i]]) return o.cssPrefix = e[i].replace("Perspective", "").toLowerCase(), o.animProp = "-" + o.cssPrefix + "-transform", !0;
                    return !1
                }(), "vertical" == o.settings.mode && (o.settings.maxSlides = o.settings.minSlides), r.data("origStyle", r.attr("style")), r.children(o.settings.slideSelector).each(function() {
                    t(this).data("origStyle", t(this).attr("style"))
                }), c()
            },
            c = function() {

                r.wrap('<div class="bx-wrapper"><div class="bx-viewport"></div></div>'), o.viewport = r.parent(), o.loader = t('<div class="bx-loading" />'), o.viewport.prepend(o.loader), r.css({
                    width: "horizontal" == o.settings.mode ? 100 * o.children.length + 215 + "%" : "auto",
                    position: "relative"
                }), o.usingCSS && o.settings.easing ? r.css("-" + o.cssPrefix + "-transition-timing-function", o.settings.easing) : o.settings.easing || (o.settings.easing = "swing"), f(), o.viewport.css({
                    width: "100%",
                    overflow: "hidden",
                    position: "relative"
                }), o.viewport.parent().css({
                    maxWidth: p()
                }), o.settings.pager || o.viewport.parent().css({
                    margin: "0 auto 0px"
                }), o.children.css({
                    "float": "horizontal" == o.settings.mode ? "left" : "none",
                    listStyle: "none",
                    position: "relative"
                }), o.children.css("width", u()), "horizontal" == o.settings.mode && o.settings.slideMargin > 0 && o.children.css("marginRight", o.settings.slideMargin), "vertical" == o.settings.mode && o.settings.slideMargin > 0 && o.children.css("marginBottom", o.settings.slideMargin), "fade" == o.settings.mode && (o.children.css({
                    position: "absolute",
                    zIndex: 0,
                    display: "none"
                }), o.children.eq(o.settings.startSlide).css({
                    zIndex: o.settings.slideZIndex,
                    display: "block"
                })), o.controls.el = t('<div class="bx-controls" />'), o.settings.captions && P(), o.active.last = o.settings.startSlide == x() - 1, o.settings.video && r.fitVids();
                var e = o.children.eq(o.settings.startSlide);
                "all" == o.settings.preloadImages && (e = o.children), o.settings.ticker ? o.settings.pager = !1 : (o.settings.pager && T(), o.settings.controls && C(), o.settings.auto && o.settings.autoControls && E(), (o.settings.controls || o.settings.autoControls || o.settings.pager) && o.viewport.after(o.controls.el)), g(e, h)
            },
            g = function(e, i) {
                var s = e.find("img, iframe").length;
                if (0 == s) return i(), void 0;
                var n = 0;
                e.find("img, iframe").each(function() {
                    t(this).one("load", function() {
                        ++n == s && i()
                    }).each(function() {
                        this.complete && t(this).load()
                    })
                })
            },
            h = function() {
                if (o.settings.infiniteLoop && "fade" != o.settings.mode && !o.settings.ticker) {
                    var e = "vertical" == o.settings.mode ? o.settings.minSlides : o.settings.maxSlides,
                        i = o.children.slice(0, e).clone().addClass("bx-clone"),
                        s = o.children.slice(-e).clone().addClass("bx-clone");
                    r.append(i).prepend(s)
                }
                o.loader.remove(), S(), "vertical" == o.settings.mode && (o.settings.adaptiveHeight = !0), o.viewport.height(v()), r.redrawSlider(), o.settings.onSliderLoad(o.active.index), o.initialized = !0, o.settings.responsive && t(window).bind("resize", Z), o.settings.auto && o.settings.autoStart && H(), o.settings.ticker && L(), o.settings.pager && q(o.settings.startSlide), o.settings.controls && W(), o.settings.touchEnabled && !o.settings.ticker && O()
            },
            v = function() {
                var e = 0,
                    s = t();
                if ("vertical" == o.settings.mode || o.settings.adaptiveHeight)
                    if (o.carousel) {
                        var n = 1 == o.settings.moveSlides ? o.active.index : o.active.index * m();
                        for (s = o.children.eq(n), i = 1; i <= o.settings.maxSlides - 1; i++) s = n + i >= o.children.length ? s.add(o.children.eq(i - 1)) : s.add(o.children.eq(n + i))
                    } else s = o.children.eq(o.active.index);
                else s = o.children;
                return "vertical" == o.settings.mode ? (s.each(function() {
                    e += t(this).outerHeight()
                }), o.settings.slideMargin > 0 && (e += o.settings.slideMargin * (o.settings.minSlides - 1))) : e = Math.max.apply(Math, s.map(function() {
                    return t(this).outerHeight(!1)
                }).get()), e
            },
            p = function() {
                var t = "100%";
                return o.settings.slideWidth > 0 && (t = "horizontal" == o.settings.mode ? o.settings.maxSlides * o.settings.slideWidth + (o.settings.maxSlides - 1) * o.settings.slideMargin : o.settings.slideWidth), t
            },
            u = function() {
                var t = o.settings.slideWidth,
                    e = o.viewport.width();
                return 0 == o.settings.slideWidth || o.settings.slideWidth > e && !o.carousel || "vertical" == o.settings.mode ? t = e : o.settings.maxSlides > 1 && "horizontal" == o.settings.mode && (e > o.maxThreshold || e < o.minThreshold && (t = (e - o.settings.slideMargin * (o.settings.minSlides - 1)) / o.settings.minSlides)), t
            },
            f = function() {
                var t = 1;
                if ("horizontal" == o.settings.mode && o.settings.slideWidth > 0)
                    if (o.viewport.width() < o.minThreshold) t = o.settings.minSlides;
                    else if (o.viewport.width() > o.maxThreshold) t = o.settings.maxSlides;
                else {
                    var e = o.children.first().width();
                    t = Math.floor(o.viewport.width() / e)
                } else "vertical" == o.settings.mode && (t = o.settings.minSlides);
                return t
            },
            x = function() {
                var t = 0;
                if (o.settings.moveSlides > 0)
                    if (o.settings.infiniteLoop) t = o.children.length / m();
                    else
                        for (var e = 0, i = 0; e < o.children.length;) ++t, e = i + f(), i += o.settings.moveSlides <= f() ? o.settings.moveSlides : f();
                else t = Math.ceil(o.children.length / f());
                return t
            },
            m = function() {
                return o.settings.moveSlides > 0 && o.settings.moveSlides <= f() ? o.settings.moveSlides : f()
            },
            S = function() {
                if (o.children.length > o.settings.maxSlides && o.active.last && !o.settings.infiniteLoop) {
                    if ("horizontal" == o.settings.mode) {
                        var t = o.children.last(),
                            e = t.position();
                        b(-(e.left - (o.viewport.width() - t.width())), "reset", 0)
                    } else if ("vertical" == o.settings.mode) {
                        var i = o.children.length - o.settings.minSlides,
                            e = o.children.eq(i).position();
                        b(-e.top, "reset", 0)
                    }
                } else {
                    var e = o.children.eq(o.active.index * m()).position();
                    o.active.index == x() - 1 && (o.active.last = !0), void 0 != e && ("horizontal" == o.settings.mode ? b(-e.left, "reset", 0) : "vertical" == o.settings.mode && b(-e.top, "reset", 0))
                }
            },
            b = function(t, e, i, s) {
                if (o.usingCSS) {
                    var n = "vertical" == o.settings.mode ? "translate3d(0, " + t + "px, 0)" : "translate3d(" + t + "px, 0, 0)";
                    r.css("-" + o.cssPrefix + "-transition-duration", i / 1e3 + "s"), "slide" == e ? (r.css(o.animProp, n), r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function() {
                        r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"), D()
                    })) : "reset" == e ? r.css(o.animProp, n) : "ticker" == e && (r.css("-" + o.cssPrefix + "-transition-timing-function", "linear"), r.css(o.animProp, n), r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function() {
                        r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"), b(s.resetValue, "reset", 0), N()
                    }))
                } else {
                    var a = {};
                    a[o.animProp] = t, "slide" == e ? r.animate(a, i, o.settings.easing, function() {
                        D()
                    }) : "reset" == e ? r.css(o.animProp, t) : "ticker" == e && r.animate(a, speed, "linear", function() {
                        b(s.resetValue, "reset", 0), N()
                    })
                }
            },
            w = function() {
                for (var e = "", i = x(), s = 0; i > s; s++) {
                    var n = "";
                    o.settings.buildPager && t.isFunction(o.settings.buildPager) ? (n = o.settings.buildPager(s), o.pagerEl.addClass("bx-custom-pager")) : (n = s + 1, o.pagerEl.addClass("bx-default-pager")), e += '<div class="bx-pager-item"><a href="" data-slide-index="' + s + '" class="bx-pager-link">' + n + "</a></div>"
                }
                if (s == 1)
                    o.pagerEl.removeClass("bx-default-pager");
                o.pagerEl.html(e)
            },
            T = function() {
                o.settings.pagerCustom ? o.pagerEl = t(o.settings.pagerCustom) : (o.pagerEl = t('<div class="bx-pager" />'), o.settings.pagerSelector ? t(o.settings.pagerSelector).html(o.pagerEl) : o.controls.el.addClass("bx-has-pager").append(o.pagerEl), w()), o.pagerEl.on("click", "a", I)
            },
            C = function() {
                o.controls.next = t('<a class="bx-next" href="">' + o.settings.nextText + "</a>"), o.controls.prev = t('<a class="bx-prev" href="">' + o.settings.prevText + "</a>"), o.controls.next.bind("click", y), o.controls.prev.bind("click", z), o.settings.nextSelector && t(o.settings.nextSelector).append(o.controls.next), o.settings.prevSelector && t(o.settings.prevSelector).append(o.controls.prev), o.settings.nextSelector || o.settings.prevSelector || (o.controls.directionEl = t('<div class="bx-controls-direction" />'), o.controls.directionEl.append(o.controls.prev).append(o.controls.next), o.controls.el.addClass("bx-has-controls-direction").append(o.controls.directionEl))
            },
            E = function() {
                o.controls.start = t('<div class="bx-controls-auto-item"><a class="bx-start" href="">' + o.settings.startText + "</a></div>"), o.controls.stop = t('<div class="bx-controls-auto-item"><a class="bx-stop" href="">' + o.settings.stopText + "</a></div>"), o.controls.autoEl = t('<div class="bx-controls-auto" />'), o.controls.autoEl.on("click", ".bx-start", k), o.controls.autoEl.on("click", ".bx-stop", M), o.settings.autoControlsCombine ? o.controls.autoEl.append(o.controls.start) : o.controls.autoEl.append(o.controls.start).append(o.controls.stop), o.settings.autoControlsSelector ? t(o.settings.autoControlsSelector).html(o.controls.autoEl) : o.controls.el.addClass("bx-has-controls-auto").append(o.controls.autoEl), A(o.settings.autoStart ? "stop" : "start")
            },
            P = function() {
                o.children.each(function() {
                    var e = t(this).find("img:first").attr("title");
                    void 0 != e && ("" + e).length && t(this).append('<div class="bx-caption"><span>' + e + "</span></div>")
                })
            },
            y = function(t) {
                o.settings.auto && r.stopAuto(), r.goToNextSlide(), t.preventDefault()
            },
            z = function(t) {
                o.settings.auto && r.stopAuto(), r.goToPrevSlide(), t.preventDefault()
            },
            k = function(t) {
                r.startAuto(), t.preventDefault()
            },
            M = function(t) {
                r.stopAuto(), t.preventDefault()
            },
            I = function(e) {
                o.settings.auto && r.stopAuto();
                var i = t(e.currentTarget),
                    s = parseInt(i.attr("data-slide-index"));
                s != o.active.index && r.goToSlide(s), e.preventDefault()
            },
            q = function(e) {
                var i = o.children.length;
                return "short" == o.settings.pagerType ? (o.settings.maxSlides > 1 && (i = Math.ceil(o.children.length / o.settings.maxSlides)), o.pagerEl.html(e + 1 + o.settings.pagerShortSeparator + i), void 0) : (o.pagerEl.find("a").removeClass("active"), o.pagerEl.each(function(i, s) {
                    t(s).find("a").eq(e).addClass("active")
                }), void 0)
            },
            D = function() {
                if (o.settings.infiniteLoop) {
                    var t = "";
                    0 == o.active.index ? t = o.children.eq(0).position() : o.active.index == x() - 1 && o.carousel ? t = o.children.eq((x() - 1) * m()).position() : o.active.index == o.children.length - 1 && (t = o.children.eq(o.children.length - 1).position()), t && ("horizontal" == o.settings.mode ? b(-t.left, "reset", 0) : "vertical" == o.settings.mode && b(-t.top, "reset", 0))
                }
                o.working = !1, o.settings.onSlideAfter(o.children.eq(o.active.index), o.oldIndex, o.active.index)
            },
            A = function(t) {
                o.settings.autoControlsCombine ? o.controls.autoEl.html(o.controls[t]) : (o.controls.autoEl.find("a").removeClass("active"), o.controls.autoEl.find("a:not(.bx-" + t + ")").addClass("active"))
            },
            W = function() {
                1 == x() ? (o.controls.prev.addClass("disabled"), o.controls.next.addClass("disabled")) : !o.settings.infiniteLoop && o.settings.hideControlOnEnd && (0 == o.active.index ? (o.controls.prev.addClass("disabled"), o.controls.next.removeClass("disabled")) : o.active.index == x() - 1 ? (o.controls.next.addClass("disabled"), o.controls.prev.removeClass("disabled")) : (o.controls.prev.removeClass("disabled"), o.controls.next.removeClass("disabled")))
            },
            H = function() {
                o.settings.autoDelay > 0 ? setTimeout(r.startAuto, o.settings.autoDelay) : r.startAuto(), o.settings.autoHover && r.hover(function() {
                    o.interval && (r.stopAuto(!0), o.autoPaused = !0)
                }, function() {
                    o.autoPaused && (r.startAuto(!0), o.autoPaused = null)
                })
            },
            L = function() {
                var e = 0;
                if ("next" == o.settings.autoDirection) r.append(o.children.clone().addClass("bx-clone"));
                else {
                    r.prepend(o.children.clone().addClass("bx-clone"));
                    var i = o.children.first().position();
                    e = "horizontal" == o.settings.mode ? -i.left : -i.top
                }
                b(e, "reset", 0), o.settings.pager = !1, o.settings.controls = !1, o.settings.autoControls = !1, o.settings.tickerHover && !o.usingCSS && o.viewport.hover(function() {
                    r.stop()
                }, function() {
                    var e = 0;
                    o.children.each(function() {
                        e += "horizontal" == o.settings.mode ? t(this).outerWidth(!0) : t(this).outerHeight(!0)
                    });
                    var i = o.settings.speed / e,
                        s = "horizontal" == o.settings.mode ? "left" : "top",
                        n = i * (e - Math.abs(parseInt(r.css(s))));
                    N(n)
                }), N()
            },
            N = function(t) {
                speed = t ? t : o.settings.speed;
                var e = {
                        left: 0,
                        top: 0
                    },
                    i = {
                        left: 0,
                        top: 0
                    };
                "next" == o.settings.autoDirection ? e = r.find(".bx-clone").first().position() : i = o.children.first().position();
                var s = "horizontal" == o.settings.mode ? -e.left : -e.top,
                    n = "horizontal" == o.settings.mode ? -i.left : -i.top,
                    a = {
                        resetValue: n
                    };
                b(s, "ticker", speed, a)
            },
            O = function() {
                o.touch = {
                    start: {
                        x: 0,
                        y: 0
                    },
                    end: {
                        x: 0,
                        y: 0
                    }
                }, o.viewport.bind("touchstart", X)
            },
            X = function(t) {
                if (o.working) t.preventDefault();
                else {
                    o.touch.originalPos = r.position();
                    var e = t.originalEvent;
                    o.touch.start.x = e.changedTouches[0].pageX, o.touch.start.y = e.changedTouches[0].pageY, o.viewport.bind("touchmove", Y), o.viewport.bind("touchend", V)
                }
            },
            Y = function(t) {
                var e = t.originalEvent,
                    i = Math.abs(e.changedTouches[0].pageX - o.touch.start.x),
                    s = Math.abs(e.changedTouches[0].pageY - o.touch.start.y);
                if (3 * i > s && o.settings.preventDefaultSwipeX ? t.preventDefault() : 3 * s > i && o.settings.preventDefaultSwipeY && t.preventDefault(), "fade" != o.settings.mode && o.settings.oneToOneTouch) {
                    var n = 0;
                    if ("horizontal" == o.settings.mode) {
                        var r = e.changedTouches[0].pageX - o.touch.start.x;
                        n = o.touch.originalPos.left + r
                    } else {
                        var r = e.changedTouches[0].pageY - o.touch.start.y;
                        n = o.touch.originalPos.top + r
                    }
                    b(n, "reset", 0)
                }
            },
            V = function(t) {
                o.viewport.unbind("touchmove", Y);
                var e = t.originalEvent,
                    i = 0;
                if (o.touch.end.x = e.changedTouches[0].pageX, o.touch.end.y = e.changedTouches[0].pageY, "fade" == o.settings.mode) {
                    var s = Math.abs(o.touch.start.x - o.touch.end.x);
                    s >= o.settings.swipeThreshold && (o.touch.start.x > o.touch.end.x ? r.goToNextSlide() : r.goToPrevSlide(), r.stopAuto())
                } else {
                    var s = 0;
                    "horizontal" == o.settings.mode ? (s = o.touch.end.x - o.touch.start.x, i = o.touch.originalPos.left) : (s = o.touch.end.y - o.touch.start.y, i = o.touch.originalPos.top), !o.settings.infiniteLoop && (0 == o.active.index && s > 0 || o.active.last && 0 > s) ? b(i, "reset", 200) : Math.abs(s) >= o.settings.swipeThreshold ? (0 > s ? r.goToNextSlide() : r.goToPrevSlide(), r.stopAuto()) : b(i, "reset", 200)
                }
                o.viewport.unbind("touchend", V)
            },
            Z = function() {
                var e = t(window).width(),
                    i = t(window).height();
                (a != e || l != i) && (a = e, l = i, r.redrawSlider(), o.settings.onSliderResize.call(r, o.active.index))
            };
        return r.goToSlide = function(e, i) {
            if (!o.working && o.active.index != e)
                if (o.working = !0, o.oldIndex = o.active.index, o.active.index = 0 > e ? x() - 1 : e >= x() ? 0 : e, o.settings.onSlideBefore(o.children.eq(o.active.index), o.oldIndex, o.active.index), "next" == i ? o.settings.onSlideNext(o.children.eq(o.active.index), o.oldIndex, o.active.index) : "prev" == i && o.settings.onSlidePrev(o.children.eq(o.active.index), o.oldIndex, o.active.index), o.active.last = o.active.index >= x() - 1, o.settings.pager && q(o.active.index), o.settings.controls && W(), "fade" == o.settings.mode) o.settings.adaptiveHeight && o.viewport.height() != v() && o.viewport.animate({
                    height: v()
                }, o.settings.adaptiveHeightSpeed), o.children.filter(":visible").fadeOut(o.settings.speed).css({
                    zIndex: 0
                }), o.children.eq(o.active.index).css("zIndex", o.settings.slideZIndex + 1).fadeIn(o.settings.speed, function() {
                    t(this).css("zIndex", o.settings.slideZIndex), D()
                });
                else {
                    o.settings.adaptiveHeight && o.viewport.height() != v() && o.viewport.animate({
                        height: v()
                    }, o.settings.adaptiveHeightSpeed);
                    var s = 0,
                        n = {
                            left: 0,
                            top: 0
                        };
                    if (!o.settings.infiniteLoop && o.carousel && o.active.last)
                        if ("horizontal" == o.settings.mode) {
                            var a = o.children.eq(o.children.length - 1);
                            n = a.position(), s = o.viewport.width() - a.outerWidth()
                        } else {
                            var l = o.children.length - o.settings.minSlides;
                            n = o.children.eq(l).position()
                        } else if (o.carousel && o.active.last && "prev" == i) {
                        var d = 1 == o.settings.moveSlides ? o.settings.maxSlides - m() : (x() - 1) * m() - (o.children.length - o.settings.maxSlides),
                            a = r.children(".bx-clone").eq(d);
                        n = a.position()
                    } else if ("next" == i && 0 == o.active.index) n = r.find("> .bx-clone").eq(o.settings.maxSlides).position(), o.active.last = !1;
                    else if (e >= 0) {
                        var c = e * m();
                        n = o.children.eq(c).position()
                    }
                    if ("undefined" != typeof n) {
                        var g = "horizontal" == o.settings.mode ? -(n.left - s) : -n.top;
                        b(g, "slide", o.settings.speed)
                    }
                }
        }, r.goToNextSlide = function() {
            if (o.settings.infiniteLoop || !o.active.last) {
                var t = parseInt(o.active.index) + 1;
                r.goToSlide(t, "next")
            }
        }, r.goToPrevSlide = function() {
            if (o.settings.infiniteLoop || 0 != o.active.index) {
                var t = parseInt(o.active.index) - 1;
                r.goToSlide(t, "prev")
            }
        }, r.startAuto = function(t) {
            o.interval || (o.interval = setInterval(function() {
                "next" == o.settings.autoDirection ? r.goToNextSlide() : r.goToPrevSlide()
            }, o.settings.pause), o.settings.autoControls && 1 != t && A("stop"))
        }, r.stopAuto = function(t) {
            o.interval && (clearInterval(o.interval), o.interval = null, o.settings.autoControls && 1 != t && A("start"))
        }, r.getCurrentSlide = function() {
            return o.active.index
        }, r.getCurrentSlideElement = function() {
            return o.children.eq(o.active.index)
        }, r.getSlideCount = function() {
            return o.children.length
        }, r.redrawSlider = function() {
            o.children.add(r.find(".bx-clone")).outerWidth(u()), o.viewport.css("height", v()), o.settings.ticker || S(), o.active.last && (o.active.index = x() - 1), o.active.index >= x() && (o.active.last = !0), o.settings.pager && !o.settings.pagerCustom && (w(), q(o.active.index))
        }, r.destroySlider = function() {
            o.initialized && (o.initialized = !1, t(".bx-clone", this).remove(), o.children.each(function() {
                void 0 != t(this).data("origStyle") ? t(this).attr("style", t(this).data("origStyle")) : t(this).removeAttr("style")
            }), void 0 != t(this).data("origStyle") ? this.attr("style", t(this).data("origStyle")) : t(this).removeAttr("style"), t(this).unwrap().unwrap(), o.controls.el && o.controls.el.remove(), o.controls.next && o.controls.next.remove(), o.controls.prev && o.controls.prev.remove(), o.pagerEl && o.settings.controls && o.pagerEl.remove(), t(".bx-caption", this).remove(), o.controls.autoEl && o.controls.autoEl.remove(), clearInterval(o.interval), o.settings.responsive && t(window).unbind("resize", Z))
        }, r.reloadSlider = function(t) {
            void 0 != t && (n = t), r.destroySlider(), d()
        }, d(), this
    }
}(jQuery);
/************Lite weight popup model box plugin start her*******************/
(function(e) {
    var t = 0;
    e.fn.modalPopLite = function(n) {
        var n = e.extend({}, {
            openButton: "modalPopLite-open-btn",
            closeButton: "modalPopLite-close-btn",
            isModal: true,
            callBack: null
        }, n);
        return this.each(function() {
            t++;
            var r = t;
            var i = false;
            var s = e(this);
            var o = n.openButton;
            var u = n.closeButton;
            var a = n.isModal;
            s.before('<div id="modalPopLite-mask' + r + '" style="width:100%" class="modalPopLite-mask" />');
            s.wrap('<div id="modalPopLite-wrapper' + r + '" style="left: -10000px;" class="modalPopLite-wrapper" />');
            s.addClass("modalPopLite-child-" + r);
            e(o).on("click", function(t) {
                t.preventDefault();
                var n = e(window).width();
                var s = e(window).height();
                var o = e(".modalPopLite-child-" + r).outerWidth();
                var u = e(".modalPopLite-child-" + r).outerHeight();
                var a = n / 2 - o / 2;
                var f = s / 2 - u / 2;
                e("#modalPopLite-mask" + r).css("height", s + "px");
                e("#modalPopLite-mask" + r).fadeTo("slow", .6);
                e("#modalPopLite-wrapper" + r).css({
                    left: a + "px",
                    top: f
                });
                e("#modalPopLite-wrapper" + r).fadeIn("slow");
                i = true
            });
            e(u).on("click", function(t) {
                t.preventDefault();
                e("#modalPopLite-mask" + r).hide();
                e("#modalPopLite-wrapper" + r).css("left", "-10000px");
                i = false;
                if (n.callBack != null) {
                    n.callBack.call(this)
                }
            });
            if (!a) {
                e("#modalPopLite-mask" + r).click(function(t) {
                    t.preventDefault();
                    e(this).hide();
                    e("#modalPopLite-wrapper" + r).css("left", "-10000px");
                    i = false;
                    if (n.callBack != null) {
                        n.callBack.call(this)
                    }
                })
            }
            e(window).resize(function() {
                if (i) {
                    var t = e(window).width();
                    var n = e(window).height();
                    var s = e(".modalPopLite-child-" + r).outerWidth();
                    var o = e(".modalPopLite-child-" + r).outerHeight();
                    var u = t / 2 - s / 2;
                    var a = n / 2 - o / 2;
                    e("#modalPopLite-wrapper" + r).css({
                        left: u + "px",
                        top: a
                    });
                    e("#modalPopLite-mask" + r).css("height", n + "px")
                }
            })
        })
    };
    e.fn.modalPopLite.Close = function(t) {
        e("#modalPopLite-mask" + t).hide();
        e("#modalPopLite-wrapper" + thisPopID).css("left", "-10000px");
        if (options.callBack != null) {
            options.callBack.call(this)
        }
    };
    e.fn.modalPopLite.ShowProgress = function() {
        e('<div class="popBox-ajax-progress"></div>').appendTo("body")
    };
    e.fn.modalPopLite.HideProgress = function() {
        e(".popBox-ajax-progress").remove()
    }
})(jQuery)
/********************************End of lite weight model popup Ends here**********************************************/


$(document).ready(function() {
    var $zoho = $zoho || {
        livedesk: {
            values: {},
            ready: function() {}
        }
    };
    var d = document;
    s = d.createElement("script");
    s.type = "text/javascript";
    s.defer = true;
    s.src = "https://salesiq.zoho.com/support.kobstereshoppvtltd/float.ls?embedname=kobstereshoppvtltd";
    t = d.getElementsByTagName("script")[0];
    t.parentNode.insertBefore(s, t);
});

function online_chat() {
    $("#zls_ctn_wrap").click();
    //window.open("online_chat.php", "newwindow", "width=500, height=350, left=300"); 
    //return false;
}