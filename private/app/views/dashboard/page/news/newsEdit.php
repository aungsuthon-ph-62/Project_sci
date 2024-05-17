<div class="pagetitle">
    <h1>แก้ไขข่าว</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">แก้ไขข่าว</li>
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
                        <form id="newsAddForm" action="private/app/controller/news.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="action" value="updateNews">
                            <input type="hidden" name="oldBanner" value="<?= $row['news_banner'] ?>">
                            <input type="hidden" name="newsId" value="<?= $row['news_unique'] ?>">
                            <input type="hidden" name="author" value="<?= $row['news_author'] ?>">  
                            
                            <div class="mb-3">
                                <label for="previewImg"><i class="fa-solid fa-image"></i> แนบรูปภาพหน้าปก</label>
                                <div class="p-lg-3">
                                    <img src="public/img/banner/<?= $row['news_banner'] ?>" id='previewImg' class='img-thumbnail rounded-lg w-25' alt="<?= $row['news_banner'] ?>">
                                </div>
                                <label class="form-label" for="newsBanner">เลือกไฟล์</label>
                                <input type="file" class="form-control" id="newsBanner" name="newsBanner" accept='image/gif, image/jpeg, image/png, image/jpg, image/webp, image/svg'>
                            </div>
                            <div class="mb-3">
                                <label for="newsTopic" class="form-label">หัวข้อข่าว</label>
                                <input class="form-control" type="text" id="newsTopic" name="newsTopic" value="<?= $row['news_topic'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="newsCategory" class="form-label">หมวดหมู่ข่าว</label>
                                <select class="form-select" id="newsCategory" name="newsCategory" aria-label="newsCategory">
                                    <option class="text-primary" value="<?= $row['category_unique'] ?>" selected><?= $row['category_name'] ?></option>
                                    <?php
                                    $news_category = $news->news_category();
                                    if ($news_category) {
                                    ?>
                                        <?php foreach ($news_category as $cat) { ?>
                                            <?php if ($cat['category_unique'] != $row['category_unique']) { ?>
                                                <option value="<?= $cat['category_unique'] ?>"><?= $cat['category_name'] ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="newsArticle" class="form-label">เนื้อหาข่าว</label>
                                <textarea id="newsArticle" name="newsArticle" class="form-control"><?= $row['news_article'] ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-success rounded-pill float-start"><i class="bi bi-pen"></i> แก้ไขข่าว</button>
                        </form>
                    <?php } ?>
                </div>
                <div class="card-footer">
                    <a href="?page=news-list" class="btn btn-warning rounded-pill float-end"><i class="bi bi-arrow-left"></i> ย้อนกลับ</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="private/app/views/dashboard/assets/js/newsAdd.js"></script>