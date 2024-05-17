<div class="pagetitle">
    <h1>รายละเอียดข่าว</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">รายละเอียดข่าว</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3 p-lg-5">
                    <?php
                    $news = new News;
                    $news_result = $news->get_news($_GET['id']);
                    $row = $news_result[0];
                    ?>
                    <?php if ($row) { ?>
                        <fieldset disabled>
                            <div class="mb-3">
                                <?php
                                if ($row['news_banner'] == "") { ?>
                                    <label for="newsBanner"><i class="fa-solid fa-image"></i> รูปภาพหน้าปก</label>
                                    <div class="d-none d-md-block">
                                        <img src="public/img/out-of-stock.png" class='img-thumbnail rounded-lg' style="width: 30%;" loading="lazy">
                                    </div>
                                    <div class="d-block d-md-none">
                                        <img src="public/img/out-of-stock.png" class='img-thumbnail rounded-lg' style="width: 70%;" loading="lazy">
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-pill" id="basic-addon1">ไม่มีไฟล์ภาพ</span>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <label for="newsBanner"><i class="fa-solid fa-image"></i> รูปภาพหน้าปก</label>
                                    <div class="d-none d-md-block">
                                        <img src="public/img/banner/<?= cleanData($row['news_banner']) ?>" class='img-thumbnail rounded-lg' style="width: 30%;" loading="lazy">
                                    </div>
                                    <div class="d-block d-md-none">
                                        <img src="public/img/banner/<?= cleanData($row['news_banner']) ?>" class='img-thumbnail rounded-lg' style="width: 70%;" loading="lazy">
                                    </div>
                                    <a href="public/img/banner/<?= cleanData($row['news_banner']) ?>">
                                        <pre class="text-muted text-wrap"><?= cleanData($row['news_banner']); ?></pre>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="newsTopic" class="form-label">หัวข้อข่าว</label>
                                <input class="form-control" type="text" id="newsTopic" value="<?= cleanData($row['news_topic']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="newsCategory" class="form-label">หมวดหมู่ข่าว</label>
                                <input class="form-control" type="text" id="newsCategory" value="<?= cleanData($row['category_name']) ?>">
                            </div>
                            <h5><i class="fa-solid fa-circle-info"></i> รายละเอียด </h5>
                            <div class="border rounded-3 mb-3 py-4">
                                <article class="container overflow-hidden"> <?= $row['news_article']; ?></article>
                            </div>
                            <div class="mb-3">
                                <label for="newsAuthor" class="form-label">เพิ่มข่าวโดย</label>
                                <input class="form-control" type="text" id="newsAuthor" value="<?= cleanData($row['user_fname']) ?> <?= cleanData($row['user_lname']) ?>">
                            </div>
                        </fieldset>
                    <?php } ?>
                </div>
                <div class="card-footer">
                    <a href="?page=news-list" class="btn btn-warning rounded-pill float-right float-md-left"><i class="bi bi-arrow-left"></i> ย้อนกลับ</a>
                </div>
            </div>
        </div>
    </div>
</section>