<?php
include('../conn.php');
session_start();
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'vn';
if ($lang === 'vn') {
    $lang = 'vn';
} else {
    $lang = 'en';
}

include('../../languages/' . $lang . '.php');

$Action = $_REQUEST['Action'];

if ($Action == 'popularJobs') {
    $q = isset($_GET['q']) ? trim($_GET['q']) : "";

    if ($q !== "") {
       
        if ($lang === 'en') {
            // 🔹 Search CHỈ theo tiếng Anh
            $sql = "
                SELECT DISTINCT TOP 5 d.Dep_Name, d.Dep_NameEN
                FROM CO_WorkList AS w
                LEFT JOIN CO_DepartmentCompany AS d
                    ON d.Dep_ID = w.Dep_ID
                WHERE w.Date_Applications >= CAST(GETDATE() AS DATE)
                  AND d.Dep_NameEN COLLATE Latin1_General_CI_AI LIKE N'%$q%'
                ORDER BY d.Dep_NameEN
            ";
        } else {
            // 🔸 Search CHỈ theo tiếng Việt (có hoặc không dấu)
            $sql = "
                SELECT DISTINCT TOP 5 d.Dep_Name, d.Dep_NameEN
                FROM CO_WorkList AS w
                LEFT JOIN CO_DepartmentCompany AS d
                    ON d.Dep_ID = w.Dep_ID
                WHERE w.Date_Applications >= CAST(GETDATE() AS DATE)
                  AND d.Dep_Name COLLATE Latin1_General_CI_AI LIKE N'%$q%'
                ORDER BY d.Dep_Name
            ";
        }
        $rs_popular = fetch_to_array($sql);

        if ($rs_popular) {
            echo '<p class="fw-bold m-0 px-3 py-2">' . htmlspecialchars($keyword) . '</p>';

            foreach ($rs_popular as $row) {
                  $depName = ($lang === 'en') 
                    ? (!empty($row['Dep_NameEN']) ? $row['Dep_NameEN'] : $row['Dep_Name'])
                    : (!empty($row['Dep_Name']) ? $row['Dep_Name'] : $row['Dep_NameEN']);

                echo '
                    <li class="p-2">
                        <a href="#" class="dropdown-item suggest-item popular">
                            <i class="bi bi-search me-2"></i> ' . htmlspecialchars($depName) . '
                        </a>
                    </li>
                ';
            }  
        }else{
            echo '<div class="text-center">
                    <i class="bi bi-lightbulb-off fs-1"></i>
                    <p>'.htmlspecialchars($no_suggestion).'</p>
                </div>';
        }
    } else {
        echo '
        <p class="fw-bold m-0 px-3 py-2">'. $hot_search.'</p>
        <li class="p-2"><a class="dropdown-item popular" href="#">
            <i class="fa-solid fa-arrow-trend-up me-2"></i> '. $worker .'
        </a></li>

        <li class="p-2"><a class="dropdown-item popular" href="#">
            <i class="fa-solid fa-arrow-trend-up me-2"></i> '. $sewing .'
        </a></li>

        <li class="p-2"><a class="dropdown-item popular" href="#">
            <i class="fa-solid fa-arrow-trend-up me-2"></i> '. $product_development_staff .'
        </a></li>

        <li class="p-2"><a class="dropdown-item popular" href="#">
            <i class="fa-solid fa-arrow-trend-up me-2"></i> '. $shoe_warehouse_staff .'
        </a></li> 
    ';
    }
}

if ($Action  == 'loadJobs') {

    $limit = 6;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    $dep_name = isset($_GET['Dep_Name']) ? $_GET['Dep_Name'] : "";
    $category = isset($_GET['Category']) ? $_GET['Category'] : "";

    $where = "";
    if ($dep_name != "") {
        $where .= " AND (d.Dep_Name LIKE N'%$dep_name%' OR d.Dep_NameEN LIKE N'%$dep_name%') ";
    }
    if ($category  != "") {
        $where .= " AND w.Position_Level = '$category'";
    }
    $sql_count = "SELECT COUNT(*) AS total 
                                FROM CO_WorkList AS w
                                LEFT JOIN CO_DepartmentCompany AS d ON d.Dep_ID = w.Dep_ID 
                                WHERE 1=1 AND w.Date_Applications >= CAST(GETDATE() AS DATE)
                                AND w.STATUS = '1'
                                $where";

    $total_jobs = query_count($sql_count);
    $total_pages = ceil($total_jobs / $limit);
	

    $sql = "SELECT w.*, d.Dep_Name, d.Dep_NameEN 
            FROM CO_WorkList AS w
            LEFT JOIN CO_DepartmentCompany AS d
            ON d.Dep_ID = w.Dep_ID
            WHERE 1=1 AND w.Date_Applications >= CAST(GETDATE() AS DATE)
            AND w.STATUS = '1'
            
            $where
            ORDER BY w.ID DESC
            OFFSET $start ROWS
            FETCH NEXT $limit ROWS ONLY
    ";
    // echo $sql;

    $rs_sql = fetch_to_array($sql);
    if (!$rs_sql) {
        echo '<div class="hj-empty"><i class="fa-regular fa-folder-open"></i>' . $not_job . '</div>';
    } else {
        // Cùng mẫu thẻ với "Danh sách việc làm" ở trang chủ (CSS: assets/css/job-list.css)
        echo '<div class="hj-grid">';
        foreach ($rs_sql as $row) {

            $id = $row['Dep_ID'];
            $dep_name        = ($lang == 'en') ? $row['Dep_NameEN'] : $row['Dep_Name'];
            $working_time    = ($lang == 'en') ? $row['Working_TimeEN'] : $row['Working_Time'];
            $salary          = ($lang == 'en') ? $row['SalaryEN'] : $row['Salary'];
            $request         = ($lang == 'en') ? $row['Request_WorkEN'] : $row['Request_Work'];
            $job_description = ($lang == 'en') ? $row['Job_DescriptionEN'] : $row['Job_Description'];
            $benefit         = ($lang == 'en') ? $row['Compensation_BenefitsEN'] : $row['Compensation_Benefits'];
        ?>
            <article class="hj-card">
                <a class="hj-card__link" href="../pages/job_detail.php?job=<?= $id ?>&lang=<?= $lang ?>" target="_blank">
                    <div class="hj-card__head">
                        <span class="hj-logo"><img src="../assets/images/logo/LAI_logo.png" alt="Logo"></span>
                        <div class="hj-card__titles">
                            <span class="hj-card__company"><?= $company ?></span>
                            <h3 class="hj-card__title"><?= $dep_name ?></h3>
                        </div>
                    </div>

                    <ul class="hj-meta">
                        <li class="hj-meta__address" title="<?= htmlspecialchars($company_address) ?>">
                            <i class="fa-solid fa-location-dot"></i><span><?= $company_address ?></span>
                        </li>
                        <li><i class="fa-regular fa-clock"></i><span><?= $working_time ?></span></li>
                        <li class="hj-meta__salary"><i class="fa-solid fa-sack-dollar"></i><span><?= $salary ?></span></li>
                    </ul>
                </a>

                <div class="hj-card__foot">
                    <button type="button" class="hj-btn hj-btn--primary"
                        onclick="applyNow('<?= $id ?>', '<?= htmlspecialchars($dep_name) ?>','<?= $lang ?>')">
                        <?= $apply ?> <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <button type="button" class="hj-btn hj-btn--soft"
                        onclick="onDescription(
                            '<?= $id ?>',
                            '<?= htmlentities($dep_name) ?>',
                            '<?= htmlentities($job_description) ?>',
                            '<?= htmlentities($request) ?>',
                            '<?= htmlentities($benefit) ?>'
                        )">
                        <i class="fa-regular fa-file-lines"></i> <?= $describe ?>
                    </button>
                </div>
            </article>
    <?php };
        echo '</div>';
    }

    // chỉ hiện phân trang khi có từ 2 trang trở lên
    if ($total_pages > 1) {
    ?>
    <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center mt-3">
        <!-- Previous -->
        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link page-link-ajax" data-page="<?= max(1, $page - 1) ?>" href="#">&laquo;</a>
        </li>

        <?php
        if ($total_pages <= 5) {
            for ($p = 1; $p <= $total_pages; $p++) {
                echo '<li class="page-item ' . ($p == $page ? 'active' : '') . '">
                        <a class="page-link page-link-ajax" data-page="' . $p . '" href="#">' . $p . '</a>
                    </li>';
            }
        } else {
            // dùng page-link-ajax như các nút khác (job.js bắt click và tải trang qua AJAX)
            if ($page > 2) {
                echo '<li class="page-item"><a class="page-link page-link-ajax" data-page="1" href="#">1</a></li>';
                if ($page > 3) {
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                }
            }

            for ($p = max(1, $page - 1); $p <= min($total_pages, $page + 1); $p++) {
                echo '<li class="page-item ' . ($p == $page ? 'active' : '') . '">
                        <a class="page-link page-link-ajax" data-page="' . $p . '" href="#">' . $p . '</a>
                      </li>';
            }

            if ($page < $total_pages - 1) {
                if ($page < $total_pages - 2) {
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                }
                echo '<li class="page-item"><a class="page-link page-link-ajax" data-page="' . $total_pages . '" href="#">' . $total_pages . '</a></li>';
            }
        }
        ?>

        <!-- Next -->
        <li class="page-item <?= ($page >= $total_pages) ? 'disabled