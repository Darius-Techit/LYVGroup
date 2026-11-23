<?php
require('../sidebar.php');
?>
<style>
    @keyframes seFadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    #se-page .se-card {
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(21, 33, 92, 0.08);
        overflow: visible;
        animation: seFadeInUp 0.35s ease both;
    }

    /* ---------- Header ---------- */
    #se-page .se-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 22px 24px 18px;
        border-bottom: 1px solid #eef1fa;
        flex-wrap: wrap;
    }
    #se-page .se-header-left { display: flex; align-items: center; gap: 14px; }
    #se-page .se-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #4154f1, #7b8cff);
        color: #fff; font-size: 22px; flex-shrink: 0;
    }
    #se-page .se-header h5 { margin: 0; padding: 0; font-weight: 700; color: #012970; }
    #se-page .se-header small { color: #8a94b3; }
    #se-page .se-status {
        display: flex; align-items: center; gap: 10px;
        padding: 8px 16px; border-radius: 12px;
        background: #f8f9ff; border: 1px solid #eef1fa;
    }
    #se-page .se-status .dot { width: 10px; height: 10px; border-radius: 50%; background: #c3c8d9; flex-shrink: 0; }
    #se-page .se-status.on .dot { background: #22c55e; box-shadow: 0 0 0 4px rgba(34, 197, 94, .18); }
    #se-page .se-status b { display: block; font-size: 14px; color: #012970; line-height: 1.2; }
    #se-page .se-status span { display: block; font-size: 11.5px; color: #8a94b3; text-transform: uppercase; letter-spacing: .3px; }

    /* ---------- Layout ---------- */
    #se-page .se-body { padding: 20px 24px 8px; }
    #se-page .se-block {
        border: 1px solid #eef1fa; border-radius: 14px;
        padding: 18px 20px; margin-bottom: 18px; background: #fff;
    }
    #se-page .se-block-title {
        display: flex; align-items: center; gap: 8px;
        font-size: 15px; font-weight: 700; color: #012970; margin-bottom: 14px;
    }
    #se-page .se-block-title i { color: #4154f1; }
    #se-page .se-row {
        display: grid; grid-template-columns: 170px minmax(0, 1fr);
        align-items: center; gap: 10px 16px; padding: 9px 0;
        border-bottom: 1px dashed #eef1fa;
    }
    #se-page .se-row:last-child { border-bottom: 0; }
    #se-page .se-label { font-weight: 600; font-size: 13px; color: #4b5580; }
    #se-page .se-hint { display: block; font-weight: 400; font-size: 11.5px; color: #8a94b3; margin-top: 2px; }

    /* ---------- Segmented / chips ---------- */
    #se-page .se-seg { display: flex; flex-wrap: wrap; gap: 6px; }
    #se-page .se-chip {
        display: inline-flex; align-items: center; gap: 6px;
        min-height: 36px; padding: 6px 14px; border-radius: 99px;
        border: 1.5px solid #e3e6f5; background: #fff; color: #4b5580;
        font-size: 13px; font-weight: 600; cursor: pointer;
        transition: border-color .15s, background .15s, color .15s;
    }
    #se-page .se-chip:hover { border-color: #b7c0f7; color: #4154f1; }
    #se-page .se-chip.active { border-color: #4154f1; background: #eef0ff; color: #2c3ea1; }
    #se-page .se-chip canvas { width: 22px; height: 22px; }
    #se-page .se-chip .sw { display: inline-flex; }
    #se-page .se-chip .sw i { width: 10px; height: 10px; border-radius: 50%; border: 1px solid rgba(0, 0, 0, .15); margin-right: -3px; }

    #se-page .form-switch .form-check-input { width: 3em; height: 1.5em; cursor: pointer; }
    #se-page .form-switch .form-check-label { font-weight: 600; color: #012970; margin-left: 6px; cursor: pointer; }
    #se-page .form-select, #se-page .form-control { border-radius: 10px; border-color: #e3e6f5; font-size: 13px; }

    /* ---------- Season tabs ---------- */
    #se-page .se-tabs { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 8px; margin-bottom: 14px; }
    #se-page .se-tab {
        position: relative; display: flex; flex-direction: column; align-items: center; gap: 2px;
        padding: 10px 6px; border-radius: 12px; border: 1.5px solid #e3e6f5; background: #fff;
        color: #4b5580; font-weight: 700; font-size: 14px; cursor: pointer; transition: all .15s;
    }
    #se-page .se-tab i { font-size: 20px; color: var(--c); }
    #se-page .se-tab small { font-weight: 500; font-size: 11px; color: #8a94b3; }
    #se-page .se-tab:hover { border-color: var(--c); }
    #se-page .se-tab.active { border-color: var(--c); background: var(--bg); color: #012970; box-shadow: 0 6px 14px -8px var(--c); }
    #se-page .se-tab .now {
        position: absolute; top: -8px; right: 8px; padding: 1px 8px; border-radius: 99px;
        background: #22c55e; color: #fff; font-size: 10px; font-weight: 700;
    }

    /* ---------- Colors ---------- */
    #se-page .se-colors { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
    #se-page .se-color { position: relative; }
    #se-page .se-color input[type=color] {
        width: 40px; height: 40px; padding: 0; border: 2px solid #e3e6f5; border-radius: 10px;
        cursor: pointer; background: none;
    }
    #se-page .se-color .rm {
        position: absolute; top: -7px; right: -7px; width: 18px; height: 18px; border-radius: 50%;
        border: 0; background: #eb3349; color: #fff; font-size: 11px; line-height: 18px; padding: 0;
        display: none; cursor: pointer;
    }
    #se-page .se-color:hover .rm { display: block; }
    #se-page .se-add {
        width: 40px; height: 40px; border-radius: 10px; border: 2px dashed #c9cfe8;
        background: #fff; color: #8a94b3; font-size: 18px; cursor: pointer;
    }
    #se-page .se-add:hover { border-color: #4154f1; color: #4154f1; }

    /* ---------- Range ---------- */
    #se-page .se-range { display: flex; align-items: center; gap: 12px; }
    #se-page .se-range input { flex: 1; accent-color: #4154f1; }
    #se-page .se-range output {
        min-width: 44px; text-align: center; padding: 3px 8px; border-radius: 8px;
        background: #eef0ff; color: #2c3ea1; font-weight: 700; font-size: 13px;
    }

    /* ---------- Preview ---------- */
    #se-page .se-preview-wrap { position: sticky; top: 80px; }
    #se-page .se-preview {
        position: relative; height: 380px; border-radius: 14px; overflow: hidden;
        border: 1px solid #e3e6f5; background: #fff;
    }
    #se-page .se-preview canvas { position: absolute; inset: 0; pointer-events: none; z-index: 1; }
    #se-page .se-preview.over canvas { z-index: 3; }
    #se-page .mock { position: absolute; inset: 0; z-index: 2; pointer-events: none; }
    #se-page .mock .bar { height: 26px; background: #fff; border-bottom: 1px solid #edf1ef; display: flex; align-items: center; gap: 6px; padding: 0 10px; }
    #se-page .mock .bar i { width: 30px; height: 6px; border-radius: 3px; background: #dfe7e3; display: block; }
    #se-page .mock .bar i:first-child { width: 14px; height: 14px; border-radius: 4px; background: #11885c; }
    #se-page .mock .nav { height: 16px; background: #11885c; }
    #se-page .mock .hero { margin: 10px; height: 80px; border-radius: 8px; background: #f3f6f4; }
    #se-page .mock .cards { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 8px; margin: 0 10px; }
    #se-page .mock .cards div { height: 70px; border-radius: 8px; background: #fff; border: 1px solid #e3e8e5; box-shadow: 0 2px 6px rgba(0, 0, 0, .06); }
    #se-page .se-preview-cap { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; font-size: 12.5px; color: #8a94b3; }
    #se-page .se-preview-cap b { color: #012970; }

    /* ---------- Month timeline ---------- */
    #se-page .se-timeline { display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 3px; margin-top: 14px; }
    #se-page .se-timeline div {
        position: relative; height: 34px; border-radius: 6px; background: #eef1fa;
        display: flex; align-items: flex-end; justify-content: center; padding-bottom: 3px;
        font-size: 10.5px; font-weight: 700; color: rgba(0, 0, 0, .55);
    }
    #se-page .se-timeline div.cur { outline: 2px solid #012970; outline-offset: 1px; }
    #se-page .se-legend { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 8px; font-size: 11.5px; color: #4b5580; }
    #se-page .se-legend span::before { content: ""; display: inline-block; width: 10px; height: 10px; border-radius: 3px; background: var(--c); margin-right: 5px; vertical-align: -1px; }

    /* ---------- Footer ---------- */
    #se-page .se-footer {
        position: sticky; bottom: 0; z-index: 5;
        display: flex; justify-content: flex-end; align-items: center; gap: 10px; flex-wrap: wrap;
        padding: 14px 24px; background: rgba(255, 255, 255, .96); border-top: 1px solid #eef1fa;
        border-radius: 0 0 16px 16px;
    }
    #se-page .se-dirty { margin-right: auto; font-size: 12.5px; color: #f59e0b; font-weight: 600; display: none; }
    #se-page .se-dirty.show { display: inline-flex; align-items: center; gap: 6px; }
    #se-page .se-footer .btn { border-radius: 50px; font-weight: 600; padding: 8px 22px; }
    #se-page .se-footer .btn-primary { background: linear-gradient(135deg, #4154f1, #7b8cff); border: 0; box-shadow: 0 6px 16px rgba(65, 84, 241, .35); }
    #se-page .se-footer .btn-light { border: 1px solid #e3e6f5; }

    @media (max-width: 576px) {
        #se-page .se-row { grid-template-columns: minmax(0, 1fr); gap: 6px; }
        #se-page .se-tabs { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        #se-page .se-body { padding: 16px 14px 4px; }
        #se-page .se-block { padding: 14px; }
        #se-page .se-preview { height: 300px; }
    }
</style>

<main id="main" class="main">
    <section class="section" id="se-page">
        <div class="card se-card">
            <div class="se-header">
                <div class="se-header-left">
                    <div class="se-icon"><i class="bi bi-snow2"></i></div>
                    <div>
                        <h5 class="card-title"><?= $season_effect ?></h5>
                        <small><?= $season_effect_sub ?></small>
                    </div>
                </div>
                <div class="se-status" id="se-status">
                    <span class="dot"></span>
                    <div><span id="se-status-cap"></span><b id="se-status-text">…</b></div>
                </div>
            </div>

            <div class="se-body">
                <div class="row g-4">
                    <div class="col-12 col-xl-7">
                        <div class="se-block" id="se-general"></div>
                        <div class="se-block">
                            <div class="se-block-title"><i class="bi bi-sliders"></i><span data-t="perSeason"></span></div>
                            <div class="se-tabs" id="se-tabs"></div>
                            <div id="se-season"></div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-5">
                        <div class="se-preview-wrap">
                            <div class="se-block">
                                <div class="se-block-title"><i class="bi bi-eye"></i><span data-t="preview"></span></div>
                                <div class="se-preview" id="se-preview">
                                    <div class="mock" aria-hidden="true">
                                        <div class="bar"><i></i><i></i><i></i></div>
                                        <div class="nav"></div>
                                        <div class="hero"></div>
                                        <div class="cards"><div></div><div></div><div></div></div>
                                    </div>
                                    <canvas id="se-canvas"></canvas>
                                </div>
                                <div class="se-preview-cap"><span id="se-preview-cap"></span><span id="se-preview-layer"></span></div>

                                <div class="se-timeline" id="se-timeline"></div>
                                <div class="se-legend" id="se-legend"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="se-footer">
                <span class="se-dirty" id="se-dirty"><i class="bi bi-exclamation-circle"></i><span data-t="unsaved"></span></span>
                <button type="button" class="btn btn-light" id="se-reset"><i class="bi bi-arrow-counterclockwise"></i> <span data-t="reset"></span></button>
                <button type="button" class="btn btn-primary" id="se-save"><i class="bi bi-check2"></i> <?= $save ?></button>
            </div>
        </div>
    </section>
</main>

<script>window.SE_LANG = <?= json_encode($languages) ?>;</script>
<script src="/LYVGroup/assets/js/season-effect.js?v=<?= @filemtime($_SERVER['DOCUMENT_ROOT'] . '/LYVGroup/assets/js/season-effect.js') ?>"></script>
<script src="../js/season_effect.js?v=<?= @filemtime(__DIR__ . '/../js/season_effect.js') ?>"></script>
