<?php
$seo_page = 'environment'; // tiêu đề/mô tả cho Google: xem $seo['environment'] trong languages/*.php
include('../layouts/header.php');

// Danh sách tài liệu môi trường.
// Thêm tài liệu mới: chép file PDF vào assets/files/environment/ rồi thêm một phần tử vào mảng này.
$env_documents = [
    [
        'title'  => $env_gpmt_196,
        'issuer' => $env_issuer_stnmt,
        'date'   => '28/02/2025',
        'file'   => '/LYVGroup/assets/files/environment/GPMT_2025_196.pdf',
    ],
];
$env_first = $env_documents[0];
?>

<head>
    <link rel="stylesheet" href="../assets/css/environment.css?v=<?= @filemtime(__DIR__ . '/../assets/css/environment.css') ?>">
</head>

<div style="margin-top: 70px;" class="screen-padding">
    <h1 class="title-name env-title h2">🌿 <?= $env_title; ?> 🌿</h1>

    <div class="env-doc-list">
        <?php foreach ($env_documents as $i => $doc) { ?>
            <div class="env-doc <?= $i === 0 ? 'active' : '' ?>"
                data-file="<?= htmlspecialchars($doc['file']) ?>"
                data-title="<?= htmlspecialchars($doc['title']) ?>">
                <div class="env-doc-icon"><i class="fa-solid fa-file-pdf"></i></div>
                <div class="env-doc-info">
                    <div class="env-doc-name"><?= htmlspecialchars($doc['title']) ?></div>
                    <div class="env-doc-meta"><?= htmlspecialchars($doc['issuer']) ?></div>
                    <div class="env-doc-meta">
                        <i class="fa-regular fa-calendar"></i>
                        <?= $env_issue_date; ?>: <strong><?= $doc['date'] ?></strong>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>


    <div class="env-viewer">
        <div id="env_viewer" class="env-pages">
            <div id="env_loading" class="env-loading">
                <div class="spinner-border" role="status"></div>
                <div><?= $env_pdf_loading; ?></div>
            </div>
        </div>
        <div id="env_fallback" class="env-fallback" hidden>
            <p><?= $env_pdf_fallback; ?></p>
            <a id="env_open_tab" class="btn btn-env" href="<?= htmlspecialchars($env_first['file']) ?>" target="_blank" rel="noopener">
                <i class="fa-solid fa-up-right-from-square"></i> <?= $env_open_new_tab; ?>
            </a>
            <a id="env_download" class="btn btn-env" href="<?= htmlspecialchars($env_first['file']) ?>" download>
                <i class="fa-solid fa-download"></i> <?= $env_download; ?>
            </a>
        </div>
    </div>
</div>

<script src="/LYVGroup/assets/vendor/pdfjs-3.11.174/pdf.min.js"></script>
<script>
    (function() {
        var pagesBox = document.getElementById('env_viewer');
        var loadingEl = document.getElementById('env_loading');
        var fallbackEl = document.getElementById('env_fallback');
        var current = null; // tài liệu đang hiển thị: { task, observer, urls }

        function showFallback() {
            loadingEl.hidden = true;
            pagesBox.hidden = true;
            fallbackEl.hidden = false;
        }

        if (!window.pdfjsLib) {
            showFallback();
            return;
        }
        pdfjsLib.GlobalWorkerOptions.workerSrc = '/LYVGroup/assets/vendor/pdfjs-3.11.174/pdf.worker.min.js';

        // Vẽ 1 trang ra canvas rồi đổi sang ảnh JPEG để giải phóng bộ nhớ canvas
        // (Safari iOS giới hạn tổng bộ nhớ canvas, nhiều trang sẽ bị trắng).
        function renderPage(pdf, holder, state) {
            if (holder.getAttribute('data-rendered')) return;
            holder.setAttribute('data-rendered', '1');
            var num = parseInt(holder.getAttribute('data-page'), 10);

            pdf.getPage(num).then(function(page) {
                if (current !== state) return;
                var base = page.getViewport({
                    scale: 1
                });
                holder.style.paddingTop = (base.height / base.width * 100) + '%';

                // Độ phân giải đủ nét khi người dùng zoom bằng 2 ngón tay, tối đa 2000px
                var dpr = Math.max(window.devicePixelRatio || 1, 2);
                var targetWidth = Math.min(Math.round(holder.clientWidth * dpr * 1.25), 2000);
                var viewport = page.getViewport({
                    scale: targetWidth / base.width
                });

                var canvas = document.createElement('canvas');
                canvas.width = Math.floor(viewport.width);
                canvas.height = Math.floor(viewport.height);
                var ctx = canvas.getContext('2d');
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                return page.render({
                    canvasContext: ctx,
                    viewport: viewport
                }).promise.then(function() {
                    page.cleanup();
                    if (current !== state) return;
                    if (!canvas.toBlob) {
                        holder.appendChild(canvas);
                        return;
                    }
                    canvas.toBlob(function(blob) {
                        if (current !== state) return;
                        if (!blob) {
                            holder.appendChild(canvas);
                            return;
                        }
                        var url = URL.createObjectURL(blob);
                        state.urls.push(url);
                        var img = new Image();
                        img.alt = 'Page ' + num;
                        img.src = url;
                        holder.appendChild(img);
                        canvas.width = canvas.height = 0;
                    }, 'image/jpeg', 0.85);
                });
            }).catch(function() {
                holder.removeAttribute('data-rendered'); // cho phép thử lại khi cuộn tới lần sau
            });
        }

        function loadDocument(file) {
            if (current) {
                if (current.observer) current.observer.disconnect();
                current.urls.forEach(function(u) {
                    URL.revokeObjectURL(u);
                });
                current.task.destroy();
            }
            pagesBox.querySelectorAll('.env-page').forEach(function(p) {
                p.remove();
            });
            pagesBox.scrollTop = 0;
            pagesBox.hidden = false;
            loadingEl.hidden = false;
            fallbackEl.hidden = true;
            document.getElementById('env_open_tab').href = file;
            document.getElementById('env_download').href = file;

            var state = {
                task: pdfjsLib.getDocument(file),
                observer: null,
                urls: []
            };
            current = state;

            state.task.promise.then(function(pdf) {
                return pdf.getPage(1).then(function(first) {
                    if (current !== state) return;
                    var base = first.getViewport({
                        scale: 1
                    });
                    var ratio = base.height / base.width * 100;
                    loadingEl.hidden = true;

                    // Chỉ vẽ trang khi sắp cuộn tới, tránh tốn bộ nhớ với tài liệu nhiều trang
                    var observer = ('IntersectionObserver' in window) ? new IntersectionObserver(function(entries) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) {
                                observer.unobserve(entry.target);
                                renderPage(pdf, entry.target, state);
                            }
                        });
                    }, {
                        root: pagesBox,
                        rootMargin: '150% 0px'
                    }) : null;
                    state.observer = observer;

                    for (var n = 1; n <= pdf.numPages; n++) {
                        var holder = document.createElement('div');
                        holder.className = 'env-page';
                        holder.setAttribute('data-page', n);
                        holder.style.paddingTop = ratio + '%';
                        pagesBox.appendChild(holder);
                        if (observer) observer.observe(holder);
                        else renderPage(pdf, holder, state);
                    }
                });
            }).catch(function() {
                if (current === state) showFallback();
            });
        }

        document.querySelectorAll('.env-doc').forEach(function(item) {
            item.addEventListener('click', function() {
                if (item.classList.contains('active') && current) return;
                document.querySelectorAll('.env-doc.active').forEach(function(a) {
                    a.classList.remove('active');
                });
                item.classList.add('active');
                loadDocument(item.getAttribute('data-file'));
            });
        });

        loadDocument(<?= json_encode($env_first['file']) ?>);
    })();
</script>

<?php include('../layouts/footer.php') ?>