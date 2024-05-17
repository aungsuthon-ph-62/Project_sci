<?php 
$role = $user->access('นักสื่อสารองค์กร');
if ($role) { ?>
    <?php
    $draft = new News;
    $draft_result = $draft->get_all_public($uid);
    ?>
    <div class="card">

        <div class="card-body p-3 p-lg-5">
            <div class="table-resposive">
                <table id="postTable" class="table table-bordered table-hover datatable">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>หมายเลขข่าว</th>
                            <th>หัวข้อข่าว</th>
                            <th>เพิ่มข่าวโดย</th>
                            <th>สถานะ</th>
                            <th>วันที่เผยแพร่</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($draft_result) {
                            $i = 0 ?>
                            <?php foreach ($draft_result as $row) { ?>
                                <tr>
                                    <td><?php echo $i = $i + 1; ?></td>
                                    <td><?= cleanData($row['news_unique']); ?></td>
                                    <td class="text-truncate"><?= substr(cleanData($row['news_topic']), 0, 50) . "..."; ?></td>
                                    <td><?= cleanData($row['user_fname']); ?> <?= cleanData($row['user_lname']); ?></td>
                                    <td>
                                        <?php if ($row['news_status'] == 'ร่าง') { ?>
                                            <p class="text-bg-warning rounded text-center"><?= cleanData($row['news_status']); ?></p>
                                        <?php } elseif ($row['news_status'] == 'เผยแพร่') { ?>
                                            <p class="text-bg-success rounded text-center"><?= cleanData($row['news_status']); ?></p>
                                        <?php } ?>
                                    </td>
                                    <td><?= DateThai($row['news_created']); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <a href="?page=publicInfo&id=<?= cleanData($row['news_unique']); ?>" class="btn btn-info text-white"><i class="bi bi-info-circle-fill"></i></a>
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
<?php } else {
    echo "<script> window.history.back()</script>";
    exit;
} ?>

<script>
    $(document).on('click', '.deletePost', function() {
        var id = $(this).attr("id");
        var draftTitle = $(this).attr("data-draft-title");

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-3',
                cancelButton: 'btn btn-danger mx-3'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'ยืนยันการลบรายการนี้ใช่หรือไม่?',
            html: "<h5>รายการ : " + draftTitle + "</h5>",
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