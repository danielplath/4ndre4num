!(function(e, t) {
  "object" == typeof exports && "undefined" != typeof module
    ? t(exports)
    : "function" == typeof define && define.amd
    ? define(["exports"], t)
    : t(
        ((e =
          "undefined" != typeof globalThis
            ? globalThis
            : e || self).DetectIt = {})
      );
})(this, function(e) {
  "use strict";
  var t = "undefined" != typeof window ? window : { screen: {}, navigator: {} },
    n = (
      t.matchMedia ||
      function() {
        return { matches: !1 };
      }
    ).bind(t),
    o = !1,
    i = {
      get passive() {
        return (o = !0);
      }
    },
    s = function() {};
  t.addEventListener && t.addEventListener("p", s, i),
    t.removeEventListener && t.removeEventListener("p", s, !1);
  var r = o,
    a = "PointerEvent" in t,
    c = "ontouchstart" in t,
    u = c || ("TouchEvent" in t && n("(any-pointer: coarse)").matches),
    d = (t.navigator.maxTouchPoints || 0) > 0 || u,
    h = t.navigator.userAgent || "",
    p =
      n("(pointer: coarse)").matches &&
      /iPad|Macintosh/.test(h) &&
      Math.min(t.screen.width || 0, t.screen.height || 0) >= 768,
    v =
      (n("(pointer: coarse)").matches ||
        (!n("(pointer: fine)").matches && c)) &&
      !/Windows.*Firefox/.test(h),
    f =
      n("(any-pointer: fine)").matches ||
      n("(any-hover: hover)").matches ||
      p ||
      !c,
    m = !d || (!f && v) ? (d ? "touchOnly" : "mouseOnly") : "hybrid",
    y =
      "mouseOnly" === m ? "mouse" : "touchOnly" === m || v ? "touch" : "mouse";
  (e.deviceType = m),
    (e.primaryInput = y),
    (e.supportsPassiveEvents = r),
    (e.supportsPointerEvents = a),
    (e.supportsTouchEvents = u),
    Object.defineProperty(e, "__esModule", { value: !0 });
});
//# sourceMappingURL=detect-it.umd.production.js.map
