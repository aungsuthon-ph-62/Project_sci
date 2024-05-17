<div class="card">
    <div class="card-header">
        <div class="card-tools">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory"><i class="fa-solid fa-plus"></i> เพิ่มหมวดหมู่</button>
        </div>
    </div>

    <div class="card-body p-3 p-lg-5">
        <?php
        $news = new News;
        $category_result = $news->news_category();
        ?>
        <div class="table-resposive">
            <table id="postTable" class="table table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>หมายเลขหมวดหมู่</th>
                        <th>ชื่อหมวดหมู่</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($category_result) {
                        $i = 0 ?>
                        <?php foreach ($category_result as $row) { ?>
                            <tr>
                                <td><?php echo $i = $i + 1; ?></td>
                                <td><?= cleanData($row['category_unique']); ?></td>
                                <td class="text-truncate"><?= cleanData($row['category_name']) ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-warning edit-btn" data-id="<?= cleanData($row['category_unique']); ?>"><i class="bi bi-pencil-square"></i></button>
                                        <button type="button" class="btn btn-danger deleteCategory" id="<?= $row['category_unique'] ?>" data-category-title="<?= $row['category_unique'] ?>"><i class="bi bi-x-circle-fill"></i></button>
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

<?php include_once('categoryModal' . '.php'); ?>

<script>
    $(document).on('click', '.deleteCategory', function() {
        var id = $(this).attr("id");
        var categoryTitle = $(this).attr("data-category-title");

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-3',
                cancelButton: 'btn btn-danger mx-3'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'ยืนยันการลบรายการนี้ใช่หรือไม่?',
            html: "<h5>รายการ : " + categoryTitle + "</h5>",
            footer: '<b>ลบรายการแล้วจะไม่สามารถกู้คืนได้อีก</b>',
            icon: "warning",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่, ยืนยันการลบ!',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                window.location.href = "private/app/controller/category.php?deleteCategory=" + id;
            }
        });
    });

    $(function() {
        $('.edit-btn').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'private/app/controller/category.php',
                method: 'POST',
                data: {
                    getCategory: id
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $('#editCategoryModal input[name="id"]').val(data.category_unique);
                    $('#editCategoryModal input[name="categoryName"]').val(data.category_name);
                    $('#editCategoryModal').modal('show');
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'There was an error retrieving the data.',
                        showConfirmButton: true,
                        timer: '3000',
                        focusConfirm: true
                    });
                }
            });
        });

        $('#editCategoryModal form').on('submit', function(e) {
            e.preventDefault();
            var id = $('#editCategoryModal input[name="id"]').val();
            var categoryName = $('#editCategoryModal input[name="categoryName"]').val();
            $.ajax({
                url: 'private/app/controller/category.php',
                method: 'POST',
                data: {
                    action: 'editCategory',
                    id: id,
                    categoryName: categoryName
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'อัพเดตข้อมูลสำเร็จ!',
                            focusConfirm: true,
                            timer: '3000',
                            confirmButtonText: 'ตกลง'
                        }).then(function() {
                            // Reload the page or update the table
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'There was an error updating the data.',
                            showConfirmButton: true,
                            timer: '3000',
                            focusConfirm: true
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'There was an error updating the data.',
                        showConfirmButton: true,
                        timer: '3000',
                        focusConfirm: true
                    });
                }
            });
        });
    });
</script>