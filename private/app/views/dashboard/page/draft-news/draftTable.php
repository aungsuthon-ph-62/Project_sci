<?php $role = $user->access('นักสื่อสารองค์กร');
if ($role) { ?>
    <?php
    $draft = new News;
    $draft_result = $draft->all_draft_by($uid);
    ?>
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="?page=draftAdd" class="btn btn-primary"><i class="fa-solid fa-plus"></i> ร่างข่าว</a>
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
                            <th>เพิ่มโดย</th>
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
                                            <a href="?page=draftInfo&id=<?= cleanData($row['draft_unique']); ?>" class="btn btn-info text-white"><i class="bi bi-info-circle-fill"></i></a>
                                            <a href="?page=draftEdit&id=<?= cleanData($row['draft_unique']); ?>" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                            <button type="button" class="btn btn-danger deletePost" id="<?php echo $row['draft_unique'] ?>" data-draft-title="<?php echo $row['draft_unique'] ?>"><i class="bi bi-x-circle-fill"></i></button>
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