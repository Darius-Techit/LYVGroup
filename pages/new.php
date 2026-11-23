<?php
include('../layouts/header.php');
include('../src/conn.php');

?>

<head>
    <!-- <link rel="stylesheet" href="../assets/css/home.css"> -->
    <link rel="stylesheet" href="../assets/css/new.css">
    <link href="../assets/vendor/ckeditor5/ckeditor5.css" rel="stylesheet">

</head>
<div class="screen-padding">
    <div style="margin-top:70px">
        <h2 style="color:var(--yellow-color);" class="title-name">
            <img src="../assets/images/news.png" alt="" style="width: 24px;"> <?= $general_news; ?> <img src="../assets/images/news.png" alt="" style="width: 24px;">
        </h2>

        <div class="position-relative ">
            <div class="carousel-wrapper-news">
                <div class="d-flex carousel-news news-page" id="carousel_news" style="gap: 30px; flex-wrap: wrap; margin: 5px;">
                    <?php
                    $limit = 6;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $start = ($page - 1) * $limit;

                    $sql_count = "SELECT COUNT(*) AS total FROM CO_ContentCompany";

                    $total_jobs = query_count($sql_count);
                    $total_pages = ceil($total_jobs / $limit);

                    // Không lấy Post_Content/Post_ContentEN: chứa ảnh base64, rất nặng (vượt memory_limit)
                    $sql = "SELECT ID_News, Title_Name, Title_NameEN, Description_Content, Description_ContentEN, Image_Content
						FROM CO_ContentCompany
                        WHERE Is_Active = 1 
                        ORDER BY CreateDate DESC
                        OFFSET $start ROWS
                        FETCH NEXT $limit ROWS ONLY
                   ";
                    $rs_sql = fetch_to_array($sql);

                    foreach ($rs_sql as $row) {
                        $id = $row['ID_News'];
                        $title  = $row['Title_Name'];
                        $title_en  = $row['Title_NameEN'];
                        $description = $row['Description_Content'];
                        $description_en = $row['Description_ContentEN'];
                        $image = $row['Image_Content'];

                    ?>
						
                            <div class="p-3 card-new new-item" >
								<a href="../pages/new_detail.php?news=<?php echo $id ?>&lang=<?= $lang; ?>" style="text-decoration:none;">
									<div class="new-text">
										<img src="<?= $image; ?>" alt="">
										<?php if ($lang == 'vn') { ?>
											<h3><?= $title; ?></h3>
											<span><?= $description ?></span>
										<?php } else { ?>
											<h3><?= $title_en ?></h3>
											<p><?= $description_en ?></p>
										<?php } ?>
									</div>
								</a>
							</div>
						
                    <?php }; ?>
                </div>
            </div>
        </div>
        <!-- pagination -->
        <?php if (empty($rs_sql)) {
        ?>
            <div class="text-center"><?= $no_news ?></div>
        <?php } else { ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-3">
                    <!-- Previous -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= max(1, $page - 1) ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <?php
                    if ($total_pages <= 5) {
                        // Hiện hết nếu ít trang
                        for ($p = 1; $p <= $total_pages; $p++) {
                            echo '<li class="page-item ' . ($p == $page ? 'active' : '') . '">
                        <a class="page-link" href="?page=' . $p . '">' . $p . '</a>
                      </li>';
                        }
                    } else {
                        // Trang 1
                        echo '<li class="page-item ' . ($page == 1 ? 'active' : '') . '">
                    <a class="page-link" href="?page=1">1</a>
                  </li>';

                        if ($page > 3) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }

                        // Các trang ở giữa (trước và sau trang hiện tại)
                        $start_page = max(2, $page - 1);
                        $end_page   = min($total_pages - 1, $page + 1);

                        for ($p = $start_page; $p <= $end_page; $p++) {
                            echo '<li class="page-item ' . ($p == $page ? 'active' : '') . '">
                        <a class="page-link" href="?page=' . $p . '">' . $p . '</a>
                      </li>';
                        }

                        if ($page < $total_pages - 2) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }

                        // Trang cuối
                        echo '<li class="page-item ' . ($page == $total_pages ? 'active' : '') . '">
                    <a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a>
                  </li>';
                    }
                    ?>

                    <!-- Next -->
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php } ?>


    </div>

</div>
<?php include('../layouts/footer.php') ?>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>