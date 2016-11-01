(function($){
	$.fn.marquee=function(){
		
		
		function o(t) {
			if (!t) throw new Error("[Marquee Exception]: No arguments.");
			if (!a(t.container).length) throw new Error('[Marquee Exception]: Invalid argument "container".');
			if (this.container = a(t.container), this.units = a(".wgt_marquee_unit", this.container), this.unitCount = this.units.length, this.direction = /^(?:top|right|bottom|left)$/i.test(t.direction) ? RegExp.$_.toLowerCase() : "left", this.isPositive = /^(?:left|top)$/.test(this.direction), this.isVertical = /^(?:top|bottom)$/.test(this.direction), this.keyProperty = this.isPositive ? this.isVertical ? "top" : "left" : this.isVertical ? "bottom" : "right", this.isVarWidth = "boolean" == typeof t.isVarWidth ? t.isVarWidth : !1, this.isVarWidth) {
				if ("object" != a.type(t.viewportSize)) throw new Error('[Marquee Exception]: Invalid argument "viewportSize".');
				this.viewportSize = t.viewportSize, this.unitSize = "array" == a.type(t.unitSize) && t.unitSize.length == this.unitCount ? t.unitSize : []
			} else {
				var i = a(this.units[0]);
				this.unitSize = a.extend({
					width: i.outerWidth(),
					height: i.outerHeight()
				}, "object" != a.type(t.unitSize) || a.isEmptyObject(t.unitSize) ? null : t.unitSize), this.viewportCap = isNaN(parseInt(t.viewportCap)) ? 1 : Math.abs(parseInt(t.viewportCap)), this.scrollStep = isNaN(parseInt(t.scrollStep)) ? this.viewportCap : Math.max(Math.min(parseInt(t.scrollStep), this.viewportCap), 1), this.scrollLen = (this.isVertical ? this.unitSize.height : this.unitSize.width) * this.scrollStep, this.isContinuous = "boolean" == typeof t.isContinuous ? t.isContinuous : !1
			}
			if (this.endBehavior = /^REVERSE|RESUME$/i.test(t.endBehavior) ? RegExp.$_.toUpperCase() : "REVERSE", this.isBackward = !1, this.pausingTriggers = [this.container[0]], t.pausingTriggers) {
				t.pausingTriggers = [].concat(t.pausingTriggers);
				var e = this,
					s = !1;   
				a(t.pausingTriggers).each(function(t, i) {
					var n = a(i);
					n.length && n[0] != e.container[0] && (a.contains(e.container[0], n[0]) || a.contains(n[0], e.container[0]) ? a.contains(n[0], e.container[0]) && (e.pausingTriggers.push(n[0]), s = !0) : e.pausingTriggers.push(n[0]))
				}), s && e.pausingTriggers.splice(0, 1)
			}
			this.autoScrollInterval = isNaN(parseInt(t.autoScrollInterval)) ? 4e3 : Math.abs(parseInt(t.autoScrollInterval)), this.autoScrollTimer = null, this.onAniStart = "function" == a.type(t.onAniStart) ? t.onAniStart : null, this.onAniComplete = "function" == a.type(t.onAniComplete) ? t.onAniComplete : null, this.duration = isNaN(parseInt(t.duration)) ? 2e3 : Math.abs(parseInt(t.duration)), this.easing = void 0, this.aniQueue = [], this.aniState = "STOP", this.tick = 0, this.maxTick = 0, this.targetTick = 0, this.aniEngine = null
	}
	}
})(jQuery);