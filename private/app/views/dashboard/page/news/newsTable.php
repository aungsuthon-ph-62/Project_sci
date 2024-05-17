<?php $role = $user->access('ประชาสัมพันธ์');
if ($role) { ?>
    <?php
    $news = new News;
    $draft_result = $news->get_all_draft();
    ?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-bg-warning rounded-pill px-3 py-2"><i class="fa-solid fa-pen-ruler"></i> ข่าวร่างทั้งหมด</h5>
            <!-- <div class="card-tools">
                <a href="?page=newsAdd" class="btn btn-primary"><i class="fa-solid fa-plus"></i> เพิ่มข่าว</a>
            </div> -->
        </div>

        <div class="card-body p-3 p-lg-5">
            <div class="table-resposive">
                <table id="postTable" class="table table-bordered table-hover datatable">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>หมายเลขข่าว</th>
                            <th>หัวข้อข่าว</th>
                            <th>หมวดหมู่ข่าว</th>
                            <th>ร่างข่าวโดย</th>
                            <th>วันที่เพิ่ม</th>
                            <th>วันที่แก้ไขล่าสุด</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($draft_result) {
                            $i = 0 ?>
                            <?php foreach ($draft_result as $row) { ?>
                                <tr>
                                    <td><?php echo $i = $i + 1; ?></td>
                                    <td><?= cleanData($row['draft_unique']); ?></td>
                                    <td class="text-truncate"><?= substr(cleanData($row['draft_topic']), 0, 50) . "..."; ?></td>
                                    <td><?= cleanData($row['category_name']); ?></td>
                                    <td><?= cleanData($row['user_fname']); ?> <?= cleanData($row['user_lname']); ?></td>
                                    <td><?= DateThai($row['draft_created']); ?></td>
                                    <td>
                                        <?php if ($row['draft_edit'] != null) { ?>
                                            <p class="text-warning rounded text-center m-0"><?= DateThai($row['draft_edit']); ?></p>
                                        <?php } else { ?>
                                            <p class="text-danger rounded text-center m-0">ยังไม่มีการแก้ไข</p>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <?php if ($row['draft_status'] == 'ร่าง') { ?>
                                                <a href="?page=newsDraftEdit&id=<?= cleanData($row['draft_unique']); ?>" class="btn btn-success"><i class="bi bi-globe2"></i></a>
                                            <?php } ?>
                                            <a href="?page=newsDraftInfo&id=<?= cleanData($row['draft_unique']); ?>" class="btn btn-info text-white"><i class="bi bi-info-circle-fill"></i></a>
                                            <button type="button" class="btn btn-danger deletePost" id="<?php echo $row['draft_unique'] ?>" data-news-title="<?php echo $row['draft_unique'] ?>"><i class="bi bi-x-circle-fill"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    $news_result = $news->get_all_news();
    ?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-bg-success rounded-pill px-3 py-2"><i class="bi bi-globe2"></i> ข่าวเผยแพร่ทั้งหมด</h5>
            <div class="card-tools">
                <a href="?page=newsAdd" class="btn btn-primary"><i class="fa-solid fa-plus"></i> เพิ่มข่าว</a>
            </div>
        </div>

        <div class="card-body p-3 p-lg-5">
            <div class="table-resposive">
                <table id="postTable" class="table table-bordered table-hover datatable">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>หมายเลขข่าว</th>
                            <th>หัวข้อข่าว</th>
                            <th>หมวดหมู่ข่าว</th>
                            <th>เขียนข่าวโดย</th>
                            <th>วันที่เผยแพร่</th>
                            <th>วันที่แก้ไขล่าสุด</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($news_result) {
                            $i = 0 ?>
                            <?php foreach ($news_result as $newsRow) { ?>
                                <tr>
                                    <td><?php echo $i = $i + 1; ?></td>
                                    <td><?= cleanData($newsRow['news_unique']); ?></td>
                                    <td class="text-truncate"><?= substr(cleanData($newsRow['news_topic']), 0, 50) . "..."; ?></td>
                                    <td><?= cleanData($newsRow['category_name']); ?></td>
                                    <td><?= cleanData($newsRow['user_fname']); ?> <?= cleanData($newsRow['user_lname']); ?></td>
                                    <td><?= DateThai($newsRow['news_created']); ?></td>
                                    <td>
                                        <?php if ($newsRow['news_edit'] != null) { ?>
                                            <p class="text-warning rounded text-center m-0"><?= DateThai($newsRow['news_edit']); ?></p>
                                        <?php } else { ?>
                                            <p class="text-danger rounded text-center m-0">ยังไม่มีการแก้ไข</p>
                                        <?php } ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <a href="?page=newsEdit&id=<?= cleanData($newsRow['news_unique']); ?>" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                            <a href="?page=newsInfo&id=<?= cleanData($newsRow['news_unique']); ?>" class="btn btn-info text-white"><i class="bi bi-info-circle-fill"></i></a>
                                            <a href="public/pdf/news_pdf?id=<?= cleanData($newsRow['news_unique']); ?>" class="btn btn-dark" target="_blank"><i class="bi bi-filetype-pdf"></i></a>
                                            <button type="button" class="btn btn-danger deleteNews" id="<?php echo $newsRow['news_unique'] ?>" data-title="<?php echo $newsRow['news_unique'] ?>"><i class="bi bi-x-circle-fill"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.deletePost', function() {
            var id = $(this).attr("id");
            var newsTitle = $(this).attr("data-news-title");

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-3',
                    cancelButton: 'btn btn-danger mx-3'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'ยืนยันการลบรายการนี้ใช่หรือไม่?',
                html: "<h5>รายการ : " + newsTitle + "</h5>",
                footer: '<b>ลบรายการแล้วจะไม่สามารถกู้คืนได้อีก</b>',
                icon: "warning",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ยืนยันการลบ!',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    window.location.href = "private/app/controller/news.php?deleteDraft=" + id;
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.deleteNews', function() {
            var newsID = $(this).attr("id");
            var title = $(this).attr("data-title");

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-3',
                    cancelButton: 'btn btn-danger mx-3'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'ยืนยันการลบรายการนี้ใช่หรือไม่?',
                html: "<h5>รายการ : " + title + "</h5>",
                footer: '<b>ลบรายการแล้วจะไม่สามารถกู้คืนได้อีก</b>',
                icon: "warning",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ยืนยันการลบ!',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    window.location.href = "private/app/controller/news.php?deleteNews=" + newsID;
                }
            });
        });
    </script>
<?php } ?>