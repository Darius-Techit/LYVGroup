<?php
require('../sidebar.php');
?>
<style>
    .pdf-container {
        /* padding: 0px 10px 10px 10px; */
        width: 100%;
        height: calc(100vh - 200px);
        overflow: hidden;
    }


    .pdf-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $helper_center ?></h5>

                        <div class="pdf-container">
                            <iframe
                                src="../Company Admin Guideline.pdf#toolbar=0"
                                frameborder="0">
                            </iframe>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>