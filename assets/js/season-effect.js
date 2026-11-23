/*!
 * Season Effect — hiệu ứng rơi theo mùa (Xuân / Hạ / Thu / Đông)
 * Dùng chung cho website (toàn màn hình) và khung xem trước trong Admin.
 *
 *   var fx = SeasonEffect.create(canvas, { fullscreen: true, qtyScale: 1 });
 *   fx.setConfig({ shapes:[...], colors:[...], motion:'sway', size:16, qty:80, speed:10 });
 *   fx.destroy();
 */
(function (window) {
    'use strict';

    var TAU = Math.PI * 2;

    function rand(a, b) { return a + Math.random() * (b - a); }
    function pick(arr) { return arr[Math.floor(Math.random() * arr.length)]; }

    /* ---------- Hình dạng: vẽ quanh gốc (0,0), bán kính r ---------- */
    var SHAPES = {
        // Bông tuyết 6 cánh
        flake: function (cx, r, col) {
            cx.beginPath();
            for (var i = 0; i < 3; i++) {
                var a = i * Math.PI / 3, c = Math.cos(a), s = Math.sin(a);
                cx.moveTo(-c * r, -s * r); cx.lineTo(c * r, s * r);
                // nhánh nhỏ
                for (var d = -1; d <= 1; d += 2) {
                    var bx = c * r * 0.55 * d, by = s * r * 0.55 * d;
                    cx.moveTo(bx, by); cx.lineTo(bx + Math.cos(a + 0.7) * r * 0.25 * d, by + Math.sin(a + 0.7) * r * 0.25 * d);
                    cx.moveTo(bx, by); cx.lineTo(bx + Math.cos(a - 0.7) * r * 0.25 * d, by + Math.sin(a - 0.7) * r * 0.25 * d);
                }
            }
            var w = Math.max(1.2, r / 6);
            cx.lineCap = 'round';
            cx.lineWidth = w + 2; cx.strokeStyle = 'rgba(60,110,170,.35)'; cx.stroke();
            cx.lineWidth = w; cx.strokeStyle = col; cx.stroke();
        },
        // Hạt tuyết tròn
        dot: function (cx, r, col) {
            cx.beginPath(); cx.arc(0, 0, r * 0.6, 0, TAU);
            cx.fillStyle = col; cx.fill();
            cx.lineWidth = 1; cx.strokeStyle = 'rgba(10,100,60,.28)'; cx.stroke();
        },
        // Lá thông
        pine: function (cx, r, col) {
            cx.beginPath(); cx.moveTo(0, -r); cx.lineTo(0, r);
            for (var k = -2; k <= 2; k++) {
                var y = k * r / 2.6;
                cx.moveTo(0, y); cx.lineTo(r * 0.5, y - r * 0.32);
                cx.moveTo(0, y); cx.lineTo(-r * 0.5, y - r * 0.32);
            }
            cx.lineCap = 'round';
            cx.lineWidth = Math.max(1.4, r / 6); cx.strokeStyle = col; cx.stroke();
        },
        // Hoa 5 cánh (mai / đào)
        flower: function (cx, r, col) {
            for (var i = 0; i < 5; i++) {
                cx.save(); cx.rotate(i * TAU / 5);
                cx.beginPath(); cx.ellipse(0, -r * 0.5, r * 0.32, r * 0.5, 0, 0, TAU);
                cx.fillStyle = col; cx.fill();
                cx.lineWidth = 0.8; cx.strokeStyle = 'rgba(0,0,0,.12)'; cx.stroke();
                cx.restore();
            }
            cx.beginPath(); cx.arc(0, 0, r * 0.2, 0, TAU);
            cx.fillStyle = '#e0861f'; cx.fill();
        },
        // Cánh hoa rời (đào / phượng)
        petal: function (cx, r, col) {
            cx.beginPath();
            cx.moveTo(0, -r);
            cx.bezierCurveTo(r * 0.75, -r * 0.55, r * 0.6, r * 0.6, 0, r);
            cx.bezierCurveTo(-r * 0.6, r * 0.6, -r * 0.75, -r * 0.55, 0, -r);
            cx.fillStyle = col; cx.fill();
            cx.lineWidth = 0.8; cx.strokeStyle = 'rgba(0,0,0,.14)'; cx.stroke();
        },
        // Lá thường (thu)
        leaf: function (cx, r, col) {
            cx.beginPath();
            cx.moveTo(0, -r);
            cx.bezierCurveTo(r * 0.85, -r * 0.45, r * 0.6, r * 0.55, 0, r * 0.8);
            cx.bezierCurveTo(-r * 0.6, r * 0.55, -r * 0.85, -r * 0.45, 0, -r);
            cx.fillStyle = col; cx.fill();
            cx.lineWidth = 0.8; cx.strokeStyle = 'rgba(0,0,0,.18)'; cx.stroke();
            // gân lá + cuống
            cx.beginPath(); cx.moveTo(0, -r * 0.8); cx.lineTo(0, r);
            for (var k = -1; k <= 1; k++) {
                var y = k * r * 0.3;
                cx.moveTo(0, y); cx.lineTo(r * 0.35, y - r * 0.22);
                cx.moveTo(0, y); cx.lineTo(-r * 0.35, y - r * 0.22);
            }
            cx.lineWidth = Math.max(0.8, r / 12); cx.strokeStyle = 'rgba(0,0,0,.22)'; cx.stroke();
        },
        // Lá phong
        maple: function (cx, r, col) {
            var pts = [[0, -1], [.18, -.55], [.55, -.72], [.42, -.3], [.95, -.25], [.62, .05], [.75, .35],
                [.3, .25], [.12, .55], [0, .45], [-.12, .55], [-.3, .25], [-.75, .35], [-.62, .05],
                [-.95, -.25], [-.42, -.3], [-.55, -.72], [-.18, -.55]];
            cx.beginPath(); cx.moveTo(pts[0][0] * r, pts[0][1] * r);
            for (var i = 1; i < pts.length; i++) cx.lineTo(pts[i][0] * r, pts[i][1] * r);
            cx.closePath();
            cx.lineJoin = 'round';
            cx.fillStyle = col; cx.fill();
            cx.lineWidth = 0.8; cx.strokeStyle = 'rgba(0,0,0,.18)'; cx.stroke();
            cx.beginPath(); cx.moveTo(0, r * 0.45); cx.lineTo(0, r);
            cx.lineWidth = Math.max(1, r / 10); cx.strokeStyle = 'rgba(90,50,20,.6)'; cx.stroke();
        },
        // Đốm nắng lấp lánh (hạ)
        sparkle: function (cx, r, col) {
            cx.beginPath();
            cx.moveTo(0, -r);
            cx.quadraticCurveTo(0, 0, r, 0);
            cx.quadraticCurveTo(0, 0, 0, r);
            cx.quadraticCurveTo(0, 0, -r, 0);
            cx.quadraticCurveTo(0, 0, 0, -r);
            cx.fillStyle = col; cx.fill();
            cx.lineWidth = 0.8; cx.strokeStyle = 'rgba(180,120,0,.3)'; cx.stroke();
        }
    };

    var MOTIONS = ['sway', 'straight', 'wind', 'windy', 'flutter', 'depth', 'twinkle', 'fade'];

    var DEFAULT_CFG = {
        shapes: ['flake', 'dot'],
        colors: ['#8fd3a8', '#ffd24d'],
        motion: 'sway',
        size: 16,
        qty: 80,
        speed: 10
    };

    function normalize(cfg) {
        cfg = cfg || {};
        var out = {};
        out.shapes = (cfg.shapes || []).filter(function (s) { return SHAPES[s]; });
        if (!out.shapes.length) out.shapes = DEFAULT_CFG.shapes.slice();
        out.colors = (cfg.colors || []).filter(function (c) { return /^#[0-9a-f]{6}$/i.test(c); });
        if (!out.colors.length) out.colors = DEFAULT_CFG.colors.slice();
        out.motion = MOTIONS.indexOf(cfg.motion) >= 0 ? cfg.motion : 'sway';
        out.size = Math.min(40, Math.max(6, +cfg.size || DEFAULT_CFG.size));
        out.qty = Math.min(300, Math.max(0, Math.round(+cfg.qty || 0)));
        out.speed = Math.min(25, Math.max(1, +cfg.speed || DEFAULT_CFG.speed));
        return out;
    }

    /* ---------- Bộ chạy hiệu ứng ---------- */
    function Effect(canvas, opt) {
        this.cv = canvas;
        this.cx = canvas.getContext('2d');
        this.opt = opt || {};
        this.items = [];
        this.cfg = normalize(null);
        this.raf = 0;
        this.last = 0;
        this.W = 0; this.H = 0;
        this.reduce = !!(this.opt.respectReducedMotion && window.matchMedia &&
            window.matchMedia('(prefers-reduced-motion: reduce)').matches);

        var self = this;
        this._onResize = function () { self.resize(); };
        this._loop = function (ts) { self.frame(ts); };
        window.addEventListener('resize', this._onResize);
        if (!this.opt.fullscreen && window.ResizeObserver && canvas.parentNode) {
            this._ro = new ResizeObserver(this._onResize);
            this._ro.observe(canvas.parentNode);
        }
        this.resize();
    }

    Effect.prototype.resize = function () {
        var dpr = Math.min(window.devicePixelRatio || 1, 2);
        var w, h;
        if (this.opt.fullscreen) { w = window.innerWidth; h = window.innerHeight; }
        else { var p = this.cv.parentNode; w = p.clientWidth; h = p.clientHeight; }
        this.W = w; this.H = h;
        this.cv.width = Math.round(w * dpr);
        this.cv.height = Math.round(h * dpr);
        this.cv.style.width = w + 'px';
        this.cv.style.height = h + 'px';
        this.cx.setTransform(dpr, 0, 0, dpr, 0, 0);
    };

    Effect.prototype.count = function () {
        var n = this.cfg.qty * (this.opt.qtyScale == null ? 1 : this.opt.qtyScale);
        // khung nhỏ (xem trước) thì giảm số lượng theo diện tích
        if (!this.opt.fullscreen) n = n * Math.min(1, (this.W * this.H) / (1440 * 800)) * 1.6;
        return Math.max(0, Math.round(n));
    };

    Effect.prototype.make = function (init) {
        var c = this.cfg;
        return {
            x: Math.random() * this.W,
            y: init ? Math.random() * this.H : -c.size * 2,
            r: c.size * rand(0.35, 1) / 2,
            v: rand(0.4, 1.3),
            d: Math.random() * TAU,
            a: Math.random() * TAU,
            spin: rand(-0.02, 0.02),
            z: Math.random(),
            tw: Math.random() * TAU,
            shape: pick(c.shapes),
            col: pick(c.colors)
        };
    };

    Effect.prototype.rebuild = function () {
        this.items = [];
        for (var i = 0, n = this.count(); i < n; i++) this.items.push(this.make(true));
    };

    Effect.prototype.setConfig = function (cfg) {
        this.cfg = normalize(cfg);
        this.rebuild();
        this.start();
    };

    Effect.prototype.start = function () {
        if (this.reduce || this.raf) return;
        this.last = 0;
        this.raf = window.requestAnimationFrame(this._loop);
    };

    Effect.prototype.stop = function () {
        if (this.raf) window.cancelAnimationFrame(this.raf);
        this.raf = 0;
        this.cx.clearRect(0, 0, this.W, this.H);
    };

    Effect.prototype.destroy = function () {
        this.stop();
        window.removeEventListener('resize', this._onResize);
        if (this._ro) this._ro.disconnect();
    };

    Effect.prototype.frame = function (ts) {
        var dt = this.last ? Math.min(3, (ts - this.last) / 16.67) : 1;
        this.last = ts;
        var cx = this.cx, c = this.cfg, W = this.W, H = this.H;
        var sp = c.speed / 10, gust = Math.sin(ts * 0.0004) * 1.6;
        cx.clearRect(0, 0, W, H);

        for (var i = 0; i < this.items.length; i++) {
            var f = this.items[i], al = 1, sc = 1, sx = 1;
            var vy = f.v * sp, dx = Math.sin(f.d) * 0.6;
            f.d += 0.015 * dt;

            switch (c.motion) {
                case 'straight': dx = Math.sin(f.d) * 0.12; break;
                case 'wind': dx = Math.sin(f.d) * 0.3 + 1.1 * sp; break;
                case 'windy': dx = Math.sin(f.d) * 0.3 + gust * sp; break;
                case 'flutter': dx = Math.sin(f.d * 1.6) * 1.1; sx = Math.cos(ts * 0.003 + f.tw); break;
                case 'depth': vy *= (0.5 + f.z); dx *= (0.5 + f.z); sc = 0.5 + f.z; al = 0.55 + 0.45 * f.z; break;
            }
            f.y += vy * dt; f.x += dx * dt; f.a += (c.motion === 'flutter' ? f.spin * 2 : f.spin + 0.004) * dt;

            if (f.x > W + 40) f.x = -40; else if (f.x < -40) f.x = W + 40;
            if (f.y > H + 40) { this.items[i] = this.make(false); continue; }

            if (c.motion === 'twinkle' || f.shape === 'sparkle') al *= 0.4 + 0.6 * (0.5 + 0.5 * Math.sin(ts * 0.004 + f.tw));
            if (c.motion === 'fade') al *= Math.max(0, 1 - Math.pow(Math.max(0, f.y) / H, 1.5));

            cx.save();
            cx.globalAlpha = al;
            cx.translate(f.x, f.y);
            cx.rotate(f.a);
            cx.scale(sc * (Math.abs(sx) < 0.15 ? 0.15 * (sx < 0 ? -1 : 1) : sx), sc);
            SHAPES[f.shape](cx, f.r, f.col);
            cx.restore();
        }
        this.raf = window.requestAnimationFrame(this._loop);
    };

    /* Vẽ 1 hình tĩnh (dùng cho icon trong Admin) */
    function drawIcon(canvas, shape, color) {
        var dpr = Math.min(window.devicePixelRatio || 1, 2);
        var w = canvas.clientWidth || 32, h = canvas.clientHeight || 32;
        canvas.width = w * dpr; canvas.height = h * dpr;
        var cx = canvas.getContext('2d');
        cx.setTransform(dpr, 0, 0, dpr, 0, 0);
        cx.clearRect(0, 0, w, h);
        cx.translate(w / 2, h / 2);
        if (SHAPES[shape]) SHAPES[shape](cx, Math.min(w, h) * 0.38, color);
    }

    window.SeasonEffect = {
        create: function (canvas, opt) { return new Effect(canvas, opt); },
        shapes: Object.keys(SHAPES),
        motions: MOTIONS.slice(),
        drawIcon: drawIcon
    };
})(window);
