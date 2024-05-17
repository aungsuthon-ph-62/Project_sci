<div class="pagetitle">
    <h1>เพิ่มข่าว</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">เพิ่มข่าว</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3 p-lg-5">
                    <form id="newsAddForm" action="private/app/controller/news.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="addDraft">
                        <div class="mb-3">
                            <label for="previewImg"><i class="fa-solid fa-image"></i> แนบรูปภาพหน้าปก</label>
                            <div class="p-lg-3">
                                <img src="public/img/photo.png" id='previewImg' class='img-thumbnail rounded-lg w-25'>
                            </div>
                            <label class="form-label" for="newsBanner">เลือกไฟล์</label>
                            <input type="file" class="form-control" id="newsBanner" name="newsBanner" accept='image/gif, image/jpeg, image/png, image/jpg, image/webp, image/svg'>
                        </div>
                        <div class="mb-3">
                            <label for="newsTopic" class="form-label">หัวข้อข่าว</label>
                            <input class="form-control" type="text" id="newsTopic" name="newsTopic">
                        </div>
                        <div class="mb-3">
                            <label for="newsCategory" class="form-label">หมวดหมู่ข่าว</label>
                            <select class="form-select" id="newsCategory" name="newsCategory" aria-label="newsCategory">
                                <option value="" selected>กรุณาเลือกหมวดหมู่</option>
                                <?php
                                $news = new News;
                                $news_category = $news->news_category();
                                if ($news_category) {
                                ?>
                                    <?php foreach ($news_category as $row) { ?>
                                        <option value="<?= $row['category_unique'] ?>"><?= $row['category_name'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="newsArticle" class="form-label">เนื้อหาข่าว</label>
                            <textarea id="newsArticle" name="newsArticle" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success rounded-pill float-start"><i class="bi bi-plus-circle-fill"></i> เพิ่มข่าว</button>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="?page=draft-list" class="btn btn-warning rounded-pill float-end"><i class="bi bi-arrow-left"></i> ย้อนกลับ</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="private/app/views/dashboard/assets/js/newsAdd.js"></script>