<?php
include('../layouts/header.php');
include('../src/conn.php');
ini_set('display_startup_errors', 1);
ini_set('display_errors', 'Off');
error_reporting(0);
//turn off error by Duc
$id = isset($_GET['news']) ? $_GET['news'] : "";
    if (!preg_match('/^[A-Za-z0-9]{1,19}$/', $id)) {
        echo "<script>
            alert('$delete');
            window.location.href ='../index.php'
        </script>";
    exit();
    }

//$sql = "SELECT CONVERT(VARCHAR(20),UserDate,120) UserDate,Post_Content,Post_ContentEN FROM CO_ContentCompany
//        WHERE Id_News = '$id' ORDER BY CreateDate DESC";
$sql = "EXEC [LYV_CO_ContentCompany] '$id'";
$rs_sql = fetch_to_array($sql);

?>

<head>
     <link rel="stylesheet" href="../assets/css/new.css">
     <link href="../assets/vendor/ckeditor5/ckeditor5.css" rel="stylesheet">

</head>
<style>
	.empty-news {
		min-height: 400px;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		text-align: center;
		color: #1b7f5c;
	}

	.empty-news__icon {
		width: 150px;
		height: 150px;
		background: #e6f5ef;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-bottom: 20px;
	}

	.empty-news__icon i {
		font-size: 52px;
		color: #ee0707ff;
	}

	.empty-news h2 {
		font-size: 28px;
		font-weight: 700;
		margin-bottom: 10px;
	}

	.empty-news p {
		font-size: 16px;
		color: #555;
		max-width: 420px;
		margin-bottom: 20px;
	}
</style>

<div style="margin-top: 50px;" class="screen-padding">
	<?php if (isset($rs_sql) && is_array($rs_sql) && count($rs_sql) > 0) { ?>
	
     <?php foreach ($rs_sql as $row) {
			$content = ($lang == 'vn') ? $row['Post_Content'] : $row['Post_ContentEN'];
			$time = new DateTime($row['UserDate']);
			// get thu
			$dayOfWeek = $time->format('D');

			// ngon ngu
			$days = [
				'Mon' => 'Thứ Hai',
				'Tue' => 'Thứ Ba',
				'Wed' => 'Thứ Tư',
				'Thu' => 'Thứ Năm',
				'Fri' => 'Thứ Sáu',
				'Sat' => 'Thứ Bảy',
				'Sun' => 'Chủ Nhật'
			];
			$days_en = [
				'Mon' => 'Monday',
				'Tue' => 'Tuesday',
				'Wed' => 'Wednesday',
				'Thu' => 'Thursday',
				'Fri' => 'Friday',
				'Sat' => 'Saturday',
				'Sun' => 'Sunday'
			];

			$dayVN = ($lang == 'vn') ? $days[$dayOfWeek] : $days_en[$dayOfWeek];
		?>
			<div class="d-flex justify-content-between align-items-center mt-3">
				
					<a href="../pages/new.php" style="color:var(--green-color)">
					<i class="fa-solid fa-arrow-left fs-3"></i>
				</a>
				<p class="font-14"><?= $dayVN .", ". $time->format('d/m/Y H:i:s') ?></p>
			</div>

			<div class="news-content">
				<div class="new-detail-text">
					<?php include('./news_detail_content.php'); ?>
				</div>
			</div>
		<?php } ?>
    <?php } else { ?>
		<div class="empty-news">
			<div class="empty-news__icon">
				<i class="fa-regular fa-newspaper"></i>
			</div>
			<h2>Tin tức không tồn tại</h2>
			<p>Nội dung bạn đang tìm kiếm không có hoặc đã bị gỡ bỏ.</p>
		</div>

	<?php } ?>
</div>


<?php include('../layouts/footer.php') ?>
<!-- <script type="module" src="../assets/vendor/ckeditor5/ckeditor5.js"></script> -->