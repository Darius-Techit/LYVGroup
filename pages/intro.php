<?php include('../layouts/header.php') ?>
<head>
    <link rel="stylesheet" href="../assets/css/intro.css">
  
</head>

<style>
    main {
        color: var(--green-color);
        margin: 0 ;
        padding: 0;
    }

</style>

<main>
<div class="intro" style="margin-top: 70px;">
        <div class="intro-selection">
            <h1><?= $intro; ?></h1>
            <h2><?= $lacty;?></h2>
        </div>
        <p class="mb-5" style="font-size: 18px;">
            <?= $intro_detail; ?>
        </p>


        <div class="intro-selection">
            <h1><?= $why;?></h1>
            <h2 ><?= $choose;?></h2>
        </div>
        <p style="font-size: 18px;">
            <?= $intro_about;?>
        </p>
    </div>
    <div class="screen-padding">
   
    <div class="border border-1 rounded-4 p-4 application" >
        <h2 class="text-center mb-4 fw-bold apply-title"><?= $application_process; ?></h2>
        <div class="d-flex align-items-start justify-content-center application-process">
            <div class="step">
                <img src="../assets/images/apply1.png" alt="" class="apply-img">
                <p class="fw-bold fs-5 m-2 step-title"><?= $submit_application;?></p>
                <div class="desc"><?= $application_process_detail;?>
                </div>
            </div>
            <div class="arrow"></div>
            <div class="step">
                <img src="../assets/images/apply2.png" alt="" class="apply-img">
                <p class="fw-bold fs-5 m-2 step-title"><?= $interview;?></p>
                <div class="desc"><?= $interview_detail;?></div>
            </div>
            <div class="arrow"></div>
            <div class="step">
                <img src="../assets/images/apply3.png" alt="" class="apply-img">
                <p class="fw-bold fs-5 m-2 step-title"><?= $get_job;?></p>
                <div class="desc"><?= $get_job_detail;?></div>
            </div>
            <div class="arrow"></div>
            <div class="step">
                <img src="../assets/images/apply4.png" alt="" class="apply-img">
                <p class="fw-bold fs-5 m-2 step-title"><?= $training;?></p>
            </div>


        </div>
    </div>
    </div>
  
    
</main>


<?php include('../layouts/footer.php') ?>
