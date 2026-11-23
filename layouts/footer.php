<head>
  <link rel="stylesheet" href="/LYVGroup/assets/css/footer.css">
  <link rel="stylesheet" href="/LYVGroup/assets/vendor/icons/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="/LYVGroup/assets/vendor/icons/bootstrap-icons/bootstrap-icons.json">
  <link rel="stylesheet" href="/LYVGroup/assets/vendor/icons/bootstrap-icons/bootstrap-icons.min.css">



</head>

<footer>
  <div class="d-flex align-items-center justify-content-between footer screen-padding">
    <div class="contact-img">
      <img src="/LYVGroup/assets/images/internet.png" alt="">
    </div>
    <div class="contact">
      <h4 class="fw-bold"><?= $linked; ?></h4>
      <p class="fst-italic"><?= $linked_detail; ?>
      </p>
      <button class="text-white fw-bold rounded-5 border-0 btn-contact" style="font-size: 14px; padding: 12px;"
        data-bs-toggle="modal" data-bs-target="#modalContact"><?= $contact_us ?></button>
    </div>
  </div>
  <div style="background-color: var(--green-color); color: white;">
    <div style="background-color: var(--yellow-color); height:16px">
    </div>
    <div class="d-flex justify-content-between contact-footer">
      <div class="px-4 py-4 rounded-5 contact-box" style="height: 100% !important;">
        <h4 class="fw-bold pb-3"><?= $contact; ?></h4>
        <div class="d-flex align-items-center pb-3">
          <i class="fa-solid fa-envelope text-white fs-3 me-2"></i>
          <div>
            <p class="fw-bold m-0">Email:</p>
            <span>tuyendung@lacty.com.vn</span>
          </div>
        </div>
        <div class="d-flex align-items-center pb-3">
          <i class="fa-solid fa-location-dot text-white fs-3 me-2"></i>
          <div>
            <p class="fw-bold m-0"><?= $address; ?>: </p>
            <span><?= $company_address; ?></span>
          </div>
        </div>
        <div class="d-flex align-items-center">
          <i class="fa-solid fa-phone text-white fs-3 me-2"></i>
          <div>
            <div>
              <span class="fw-bold"><?= $phone; ?>: </span>(028) 38 762 443
            </div>
            <div>
              <span class="fw-bold"><?= $hotline; ?>: </span>0902 590 113 - 0932 097 116
            </div>
          </div>
        </div>
      </div>
      <div class="contact-map">
        <h4 class="fw-bold">GOOGLE MAP</h4>
        <div class="map-wrap">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.9294176618228!2d106.61605443981449!3d10.739923338869039!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752dcb018c0b6b%3A0xf34a97d39578aa34!2zQ8O0bmcgVHkgVE5ISCBM4bqhYyBU4bu3!5e0!3m2!1svi!2s!4v1793328952004!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>

        <h4 class="m-0 fw-bold"><?= $connect; ?></h4>
        <div class="social-network-icon align-items-center d-flex gap-3 ">
          <a href=" https://www.facebook.com/HRLYV" alt="" class="text-white" target="_blank">
            <i class="bi bi-facebook"></i>
          </a>
          <a href=" https://www.tiktok.com/@lactyhcm" alt="" class="text-white" target="_blank">
            <i class="bi bi-tiktok"></i>
          </a>
          <a href="">
            <img src="/LYVGroup/assets/images/zalo.png" alt="">
          </a>
          <a href="https://www.linkedin.com/company/l%E1%BA%A1c-t%E1%BB%B7-company/" alt="" class="text-white" target="_blank">
            <i class="bi bi-linkedin"></i>
          </a>
        </div>
      </div>
    </div>
    <div class="text-start border-top text-white border-2 copyright">© <?php echo date("Y"); ?> by Lac Ty Company Limited</div>

  </div>

</footer>
</body>

</html>