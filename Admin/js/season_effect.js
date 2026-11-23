/* Admin › Hiệu ứng mùa */
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: "2500",
};

(function ($) {
    var LANG = (window.SE_LANG || localStorage.getItem("languages")) === "vn" ? "vn" : "en";

    var I18N = {
        vn: {
            general: "Cài đặt chung", perSeason: "Tùy chỉnh theo mùa", preview: "Xem trước",
            enabled: "Bật hiệu ứng", enabledOn: "Đang bật", enabledOff: "Đang tắt",
            mode: "Chế độ", modeHint: "Tự động đổi mùa theo tháng hiện tại",
            auto: "Tự động theo tháng", manual: "Chọn thủ công",
            manualSeason: "Mùa hiển thị",
            pages: "Hiển thị trên", home: "Trang chủ", all: "Tất cả các trang",
            layer: "Vị trí lớp", layerHint: "Dưới: không che chữ và nút", under: "Dưới nội dung", over: "Trên nội dung",
            mobile: "Trên điện thoại", full: "Đầy đủ", reduce: "Giảm một nửa", off: "Tắt",
            months: "Áp dụng", from: "Từ tháng", to: "đến tháng", month: "Tháng",
            shapes: "Hình dạng", colors: "Màu sắc", presets: "Bảng màu gợi ý",
            motion: "Kiểu rơi", size: "Kích thước", qty: "Số lượng", speed: "Tốc độ",
            save: "Lưu thay đổi", reset: "Khôi phục mặc định", unsaved: "Có thay đổi chưa lưu",
            statusCap: "Trạng thái", statusOff: "Hiệu ứng đang tắt", statusNone: "Bật · tháng này không thuộc mùa nào",
            statusOn: "Đang hiển thị: ", now: "Hiện tại",
            previewOf: "Đang xem: ", layerUnder: "Lớp: dưới nội dung", layerOver: "Lớp: trên nội dung",
            resetTitle: "Khôi phục mặc định?", resetText: "Toàn bộ cài đặt sẽ trở về mặc định (chưa lưu cho đến khi bấm Lưu).",
            yes: "Đồng ý", cancel: "Hủy", resetDone: "Đã khôi phục — bấm Lưu để áp dụng",
            needShape: "Cần chọn ít nhất 1 hình dạng", needColor: "Cần ít nhất 1 màu",
            loadError: "Không tải được cài đặt", saveError: "Lưu thất bại",
            overlap: "Tháng {m} đang thuộc nhiều mùa — mùa đứng trước được ưu tiên",
            seasons: { spring: "Xuân", summer: "Hạ", autumn: "Thu", winter: "Đông" },
            seasonFull: { spring: "Mùa Xuân", summer: "Mùa Hạ", autumn: "Mùa Thu", winter: "Mùa Đông" },
            shapeNames: { flake: "Bông tuyết", dot: "Hạt tuyết", pine: "Lá thông", flower: "Hoa mai/đào", petal: "Cánh hoa", leaf: "Lá", maple: "Lá phong", sparkle: "Đốm nắng" },
            motionNames: { sway: "Lắc nhẹ", straight: "Rơi thẳng", wind: "Gió xiên", windy: "Gió thay đổi", flutter: "Lật xoay (lá)", depth: "Có chiều sâu", twinkle: "Lấp lánh", fade: "Tan dần" }
        },
        en: {
            general: "General settings", perSeason: "Per-season settings", preview: "Preview",
            enabled: "Enable effect", enabledOn: "On", enabledOff: "Off",
            mode: "Mode", modeHint: "Switch season automatically by month",
            auto: "Auto by month", manual: "Manual",
            manualSeason: "Season shown",
            pages: "Show on", home: "Home page", all: "All pages",
            layer: "Layer", layerHint: "Under: never covers text or buttons", under: "Under content", over: "Over content",
            mobile: "On mobile", full: "Full", reduce: "Half amount", off: "Off",
            months: "Active", from: "From month", to: "to month", month: "Month",
            shapes: "Shapes", colors: "Colors", presets: "Suggested palettes",
            motion: "Motion", size: "Size", qty: "Amount", speed: "Speed",
            save: "Save changes", reset: "Reset to defaults", unsaved: "Unsaved changes",
            statusCap: "Status", statusOff: "Effect is off", statusNone: "On · no season this month",
            statusOn: "Showing: ", now: "Now",
            previewOf: "Previewing: ", layerUnder: "Layer: under content", layerOver: "Layer: over content",
            resetTitle: "Reset to defaults?", resetText: "All settings go back to defaults (not saved until you press Save).",
            yes: "Yes", cancel: "Cancel", resetDone: "Defaults restored — press Save to apply",
            needShape: "Select at least 1 shape", needColor: "Keep at least 1 color",
            loadError: "Could not load settings", saveError: "Save failed",
            overlap: "Month {m} belongs to several seasons — the earlier one wins",
            seasons: { spring: "Spring", summer: "Summer", autumn: "Autumn", winter: "Winter" },
            seasonFull: { spring: "Spring", summer: "Summer", autumn: "Autumn", winter: "Winter" },
            shapeNames: { flake: "Snowflake", dot: "Snow dot", pine: "Pine needle", flower: "Blossom", petal: "Petal", leaf: "Leaf", maple: "Maple leaf", sparkle: "Sparkle" },
            motionNames: { sway: "Gentle sway", straight: "Straight", wind: "Slanted wind", windy: "Gusty wind", flutter: "Flutter (leaves)", depth: "Depth", twinkle: "Twinkle", fade: "Fade out" }
        }
    };
    var T = I18N[LANG];

    var SEASONS = ["spring", "summer", "autumn", "winter"];
    var SEASON_UI = {
        spring: { icon: "bi-flower1", c: "#e75a8a", bg: "#fff0f5" },
        summer: { icon: "bi-sun", c: "#f08c00", bg: "#fff7e6" },
        autumn: { icon: "bi-tree", c: "#c4561d", bg: "#fdf1ea" },
        winter: { icon: "bi-snow2", c: "#3b82c4", bg: "#eef5fc" }
    };
    var SHAPES = ["flower", "petal", "sparkle", "leaf", "maple", "flake", "dot", "pine"];
    var MOTIONS = ["sway", "straight", "wind", "windy", "flutter", "depth", "twinkle", "fade"];
    var PRESETS = {
        spring: [
            [["Mai vàng", "Yellow apricot"], ["#ffd24d", "#f5b335", "#ffe08a"]],
            [["Đào hồng", "Pink peach"], ["#ffb3c7", "#ff8fab", "#ffd1dc"]],
            [["Mai + đào", "Apricot + peach"], ["#ffd24d", "#f5b335", "#ffb3c7", "#ff8fab"]]
        ],
        summer: [
            [["Phượng đỏ", "Flame red"], ["#e8141c", "#ff5a36", "#ff8a3d"]],
            [["Nắng vàng", "Sunshine"], ["#ffd24d", "#ffe08a", "#f5b335"]],
            [["Phượng + nắng", "Flame + sun"], ["#e8141c", "#ff5a36", "#ff8a3d", "#ffd24d"]]
        ],
        autumn: [
            [["Lá cam", "Orange leaves"], ["#e07a1f", "#c4561d", "#f5b335"]],
            [["Lá nâu", "Brown leaves"], ["#a0522d", "#8b5a2b", "#c68642"]],
            [["Thu vàng", "Golden autumn"], ["#e07a1f", "#c4561d", "#f5b335", "#a0522d"]]
        ],
        winter: [
            [["Xanh nhạt + vàng", "Mint + gold"], ["#8fd3a8", "#6cc28d", "#a9dfbc", "#ffd24d", "#f5b335"]],
            [["Xanh dương", "Blue"], ["#78aadc", "#a8c8ee", "#5b8fd1"]],
            [["Trắng + xanh biển", "White + sky"], ["#ffffff", "#ffffff", "#a8d4f2"]],
            [["Bạc", "Silver"], ["#9aa7b5", "#b8c2cd"]],
            [["Noel", "Christmas"], ["#78aadc", "#5b8fd1", "#e57373"]]
        ]
    };

    var API = "../data/data_season_effect.php";
    var cfg = null, defaults = null, savedJson = "", serverCurrent = null, curMonth = new Date().getMonth() + 1;
    var tab = "winter", fx = null;

    function clone(o) { return JSON.parse(JSON.stringify(o)); }
    function isDirty() { return JSON.stringify(cfg) !== savedJson; }

    /* ---------- Tính mùa theo tháng (giống PHP) ---------- */
    function seasonOfMonth(c, m) {
        for (var i = 0; i < SEASONS.length; i++) {
            var s = c.seasons[SEASONS[i]], f = +s.from, t = +s.to;
            if (f <= t ? (m >= f && m <= t) : (m >= f || m <= t)) return SEASONS[i];
        }
        return null;
    }
    function currentSeason(c) { return c.mode === "manual" ? c.manualSeason : seasonOfMonth(c, curMonth); }

    /* ---------- Render ---------- */
    function seg(field, value, opts) {
        return '<div class="se-seg">' + opts.map(function (o) {
            return '<button type="button" class="se-chip' + (o[0] === value ? " active" : "") + '" data-field="' + field + '" data-value="' + o[0] + '">' +
                (o[2] ? '<i class="bi ' + o[2] + '"></i>' : "") + o[1] + "</button>";
        }).join("") + "</div>";
    }
    function row(label, hint, html, id) {
        return '<div class="se-row"' + (id ? ' id="' + id + '"' : "") + '><div class="se-label">' + label +
            (hint ? '<span class="se-hint">' + hint + "</span>" : "") + "</div><div>" + html + "</div></div>";
    }

    function renderGeneral() {
        var h = '<div class="se-block-title"><i class="bi bi-gear"></i>' + T.general + "</div>";
        h += row(T.enabled, "",
            '<div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="se-enabled"' + (cfg.enabled ? " checked" : "") +
            '><label class="form-check-label" for="se-enabled">' + (cfg.enabled ? T.enabledOn : T.enabledOff) + "</label></div>");
        h += row(T.mode, T.modeHint, seg("mode", cfg.mode, [["auto", T.auto, "bi-calendar3"], ["manual", T.manual, "bi-hand-index"]]));
        if (cfg.mode === "manual") {
            h += row(T.manualSeason, "", seg("manualSeason", cfg.manualSeason, SEASONS.map(function (k) {
                return [k, T.seasons[k], SEASON_UI[k].icon];
            })));
        }
        h += row(T.pages, "", seg("pages", cfg.pages, [["home", T.home, "bi-house"], ["all", T.all, "bi-files"]]));
        h += row(T.layer, T.layerHint, seg("layer", cfg.layer, [["under", T.under, "bi-layers"], ["over", T.over, "bi-layers-fill"]]));
        h += row(T.mobile, "", seg("mobile", cfg.mobile, [["full", T.full], ["reduce", T.reduce], ["off", T.off]]));
        $("#se-general").html(h);
    }

    function renderTabs() {
        var now = currentSeason(cfg);
        $("#se-tabs").html(SEASONS.map(function (k) {
            var s = cfg.seasons[k], ui = SEASON_UI[k];
            return '<button type="button" class="se-tab' + (k === tab ? " active" : "") + '" data-tab="' + k + '" style="--c:' + ui.c + ";--bg:" + ui.bg + '">' +
                (k === now ? '<span class="now">' + T.now + "</span>" : "") +
                '<i class="bi ' + ui.icon + '"></i>' + T.seasons[k] +
                "<small>" + (cfg.mode === "auto" ? T.month + " " + s.from + "–" + s.to : "&nbsp;") + "</small></button>";
        }).join(""));
    }

    function monthOptions(sel) {
        var h = "";
        for (var m = 1; m <= 12; m++) h += '<option value="' + m + '"' + (m === +sel ? " selected" : "") + ">" + T.month + " " + m + "</option>";
        return h;
    }

    function renderSeason() {
        var s = cfg.seasons[tab], h = "";

        h += row(T.months, cfg.mode === "manual" ? '<i class="bi bi-info-circle"></i> ' + T.manual : "",
            '<div class="d-flex align-items-center gap-2 flex-wrap">' +
            '<select class="form-select form-select-sm w-auto" data-sfield="from">' + monthOptions(s.from) + "</select>" +
            '<span class="se-hint m-0">' + T.to + "</span>" +
            '<select class="form-select form-select-sm w-auto" data-sfield="to">' + monthOptions(s.to) + "</select></div>");

        h += row(T.shapes, "", '<div class="se-seg">' + SHAPES.map(function (k) {
            return '<button type="button" class="se-chip' + (s.shapes.indexOf(k) >= 0 ? " active" : "") + '" data-shape="' + k + '">' +
                '<canvas data-icon="' + k + '"></canvas>' + T.shapeNames[k] + "</button>";
        }).join("") + "</div>");

        var colors = '<div class="se-colors">' + s.colors.map(function (c, i) {
            return '<span class="se-color"><input type="color" value="' + c + '" data-color="' + i + '" aria-label="' + T.colors + " " + (i + 1) + '">' +
                (s.colors.length > 1 ? '<button type="button" class="rm" data-rmcolor="' + i + '" aria-label="x">&times;</button>' : "") + "</span>";
        }).join("") + (s.colors.length < 6 ? '<button type="button" class="se-add" id="se-addcolor" aria-label="+">+</button>' : "") + "</div>";
        h += row(T.colors, "", colors);

        h += row(T.presets, "", '<div class="se-seg">' + PRESETS[tab].map(function (p, i) {
            return '<button type="button" class="se-chip" data-preset="' + i + '"><span class="sw">' +
                p[1].map(function (c) { return '<i style="background:' + c + '"></i>'; }).join("") + "</span>&nbsp;" + p[0][LANG === "vn" ? 0 : 1] + "</button>";
        }).join("") + "</div>");

        h += row(T.motion, "", '<div class="se-seg">' + MOTIONS.map(function (k) {
            return '<button type="button" class="se-chip' + (s.motion === k ? " active" : "") + '" data-motion="' + k + '">' + T.motionNames[k] + "</button>";
        }).join("") + "</div>");

        h += row(T.size, "", range("size", s.size, 6, 40, 1));
        h += row(T.qty, "", range("qty", s.qty, 0, 300, 5));
        h += row(T.speed, "", range("speed", s.speed, 1, 25, 1));

        $("#se-season").html(h);
        drawIcons();
    }

    function range(f, v, min, max, step) {
        return '<div class="se-range"><input type="range" min="' + min + '" max="' + max + '" step="' + step + '" value="' + v +
            '" data-sfield="' + f + '" aria-label="' + T[f] + '"><output>' + v + "</output></div>";
    }

    function drawIcons() {
        var col = cfg.seasons[tab].colors;
        $("#se-season canvas[data-icon]").each(function (i) {
            SeasonEffect.drawIcon(this, this.getAttribute("data-icon"), col[i % col.length]);
        });
    }

    function renderTimeline() {
        var h = "";
        for (var m = 1; m <= 12; m++) {
            var k = cfg.mode === "manual" ? cfg.manualSeason : seasonOfMonth(cfg, m);
            var bg = k ? SEASON_UI[k].c : "#eef1fa";
            h += '<div class="' + (m === curMonth ? "cur" : "") + '" style="background:' + bg + (k ? ";color:#fff" : "") +
                '" title="' + T.month + " " + m + (k ? " · " + T.seasonFull[k] : "") + '">' + m + "</div>";
        }
        $("#se-timeline").html(h);
        $("#se-legend").html(SEASONS.map(function (k) {
            return '<span style="--c:' + SEASON_UI[k].c + '">' + T.seasonFull[k] + "</span>";
        }).join(""));
    }

    function renderStatus() {
        var cur = serverCurrent, on = savedCfg().enabled;
        var text = !on ? T.statusOff : (cur ? T.statusOn + T.seasonFull[cur] : T.statusNone);
        $("#se-status").toggleClass("on", !!(on && cur));
        $("#se-status-cap").text(T.statusCap);
        $("#se-status-text").text(text);
    }
    function savedCfg() { return savedJson ? JSON.parse(savedJson) : cfg; }

    function updatePreview() {
        if (!fx) fx = SeasonEffect.create(document.getElementById("se-canvas"), { fullscreen: false });
        fx.setConfig(cfg.seasons[tab]);
        $("#se-preview").toggleClass("over", cfg.layer === "over");
        $("#se-preview-cap").html(T.previewOf + "<b>" + T.seasonFull[tab] + "</b>");
        $("#se-preview-layer").text(cfg.layer === "over" ? T.layerOver : T.layerUnder);
    }

    function updateDirty() { $("#se-dirty").toggleClass("show", isDirty()); }

    function renderAll() {
        $("[data-t]").each(function () { $(this).text(T[$(this).data("t")]); });
        renderGeneral(); renderTabs(); renderSeason(); renderTimeline(); renderStatus(); updatePreview(); updateDirty();
    }

    /* Cảnh báo khi một tháng thuộc nhiều mùa */
    function checkOverlap() {
        if (cfg.mode !== "auto") return;
        for (var m = 1; m <= 12; m++) {
            var n = 0;
            SEASONS.forEach(function (k) {
                var s = cfg.seasons[k], f = +s.from, t = +s.to;
                if (f <= t ? (m >= f && m <= t) : (m >= f || m <= t)) n++;
            });
            if (n > 1) { toastr.warning(T.overlap.replace("{m}", m)); return; }
        }
    }

    /* ---------- Sự kiện ---------- */
    var $page = $("#se-page");

    $page.on("change", "#se-enabled", function () {
        cfg.enabled = this.checked; renderGeneral(); updateDirty();
    });

    $page.on("click", "[data-field]", function () {
        var f = $(this).data("field"), v = $(this).data("value");
        cfg[f] = v;
        if (f === "manualSeason") tab = v;
        renderGeneral(); renderTabs(); renderTimeline(); updatePreview(); updateDirty();
        if (f === "manualSeason" || f === "mode") renderSeason();
    });

    $page.on("click", "[data-tab]", function () {
        tab = $(this).data("tab");
        renderTabs(); renderSeason(); updatePreview();
    });

    $page.on("change", "select[data-sfield]", function () {
        cfg.seasons[tab][$(this).data("sfield")] = +this.value;
        renderTabs(); renderTimeline(); updateDirty(); checkOverlap();
    });

    $page.on("input", "input[type=range][data-sfield]", function () {
        cfg.seasons[tab][$(this).data("sfield")] = +this.value;
        $(this).next("output").text(this.value);
        updatePreview(); updateDirty();
    });

    $page.on("click", "[data-shape]", function () {
        var s = cfg.seasons[tab], k = $(this).data("shape"), i = s.shapes.indexOf(k);
        if (i >= 0) {
            if (s.shapes.length === 1) { toastr.info(T.needShape); return; }
            s.shapes.splice(i, 1);
        } else s.shapes.push(k);
        $(this).toggleClass("active");
        updatePreview(); updateDirty();
    });

    $page.on("input", "input[type=color][data-color]", function () {
        cfg.seasons[tab].colors[+$(this).data("color")] = this.value.toLowerCase();
        drawIcons(); updatePreview(); updateDirty();
    });

    $page.on("click", "[data-rmcolor]", function () {
        var c = cfg.seasons[tab].colors;
        if (c.length <= 1) { toastr.info(T.needColor); return; }
        c.splice(+$(this).data("rmcolor"), 1);
        renderSeason(); updatePreview(); updateDirty();
    });

    $page.on("click", "#se-addcolor", function () {
        var c = cfg.seasons[tab].colors;
        if (c.length < 6) c.push(c[c.length - 1] || "#ffffff");
        renderSeason(); updatePreview(); updateDirty();
    });

    $page.on("click", "[data-preset]", function () {
        cfg.seasons[tab].colors = PRESETS[tab][+$(this).data("preset")][1].slice();
        renderSeason(); updatePreview(); updateDirty();
    });

    $page.on("click", "[data-motion]", function () {
        cfg.seasons[tab].motion = $(this).data("motion");
        $page.find("[data-motion]").removeClass("active");
        $(this).addClass("active");
        updatePreview(); updateDirty();
    });

    $("#se-reset").on("click", function () {
        Swal.fire({
            title: T.resetTitle, text: T.resetText, icon: "warning",
            showCancelButton: true, confirmButtonText: T.yes, cancelButtonText: T.cancel,
            confirmButtonColor: "#4154f1"
        }).then(function (r) {
            if (!(r.isConfirmed || r.value)) return;
            cfg = clone(defaults);
            tab = currentSeason(cfg) || "winter";
            renderAll();
            toastr.info(T.resetDone);
        });
    });

    $("#se-save").on("click", function () {
        var $b = $(this).prop("disabled", true);
        $.ajax({
            url: API + "?Action=SaveSetting", method: "POST", dataType: "json",
            data: { config: JSON.stringify(cfg) }
        }).done(function (res) {
            if (res.status === "Success") {
                cfg = res.config; savedJson = JSON.stringify(cfg); serverCurrent = res.current;
                renderAll();
                toastr.success(res.message);
            } else toastr.error(res.message || T.saveError);
        }).fail(function () { toastr.error(T.saveError); })
            .always(function () { $b.prop("disabled", false); });
    });

    window.addEventListener("beforeunload", function (e) {
        if (cfg && isDirty()) { e.preventDefault(); e.returnValue = ""; }
    });

    /* ---------- Tải dữ liệu ---------- */
    $.getJSON(API, { Action: "GetSetting" }).done(function (res) {
        cfg = res.config; defaults = res.defaults; serverCurrent = res.current;
        curMonth = res.month || curMonth;
        savedJson = JSON.stringify(cfg);
        tab = res.current || currentSeason(cfg) || "winter";
        renderAll();
    }).fail(function () { toastr.error(T.loadError); });
})(jQuery);
