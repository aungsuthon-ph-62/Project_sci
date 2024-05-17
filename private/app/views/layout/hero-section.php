<?php

$banner = new Banner();
$getBanner = $banner->get_all_banner();

?>
<section id="home-section" class="hero">
    <div class="home-slider owl-carousel">
        <?php
        foreach ($getBanner as $banner) {
        ?>
            <div class="slider-item" style="background-image: url(public/img/slide/<?= cleanData($banner['banner_img']); ?>);">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                        <div class="col-md-12 ftco-animate text-center">
                            <h3 class="mb-2 text-white"><?= cleanData($banner['banner_topic']); ?></h3>
                            <h5 class="subheading mb-4"><?= cleanData($banner['banner_description']); ?></h5>
                            <p><a href="<?= cleanData($banner['banner_link']); ?>" class="btn btn-primary">ดูเพิ่มเติม <i class="fa-solid fa-arrow-up-right-from-square"></i></a></p>
                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>