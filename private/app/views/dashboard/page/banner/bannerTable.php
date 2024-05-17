<div class="card">
    <div class="card-header">
        <div class="card-tools">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBanner"><i class="fa-solid fa-plus"></i> เพิ่มแบนเนอร์</button>
        </div>
    </div>

    <div class="card-body p-3 p-lg-5">
        <?php
        $banner = new Banner;
        $banner_result = $banner->get_all_banner();
        ?>
        <div class="table-resposive">
            <table class="table table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>รูปภาพ</th>
                        <th>หัวข้อ</th>
                        <th>คำอธิบาย</th>
                        <th>ลิงก์</th>
                        <th>วันที่เพิ่ม</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($banner_result) {
                        $i = 0 ?>
                        <?php foreach ($banner_result as $row) { ?>
                            <tr>
                                <td><?php echo $i = $i + 1; ?></td>
                                <td class="text-center"><img src="public/img/slide/<?= cleanData($row['banner_img']); ?>" alt="<?= cleanData($row['banner_img']); ?>" width="200px" loading="lazy"></td>
                                <td><?= cleanData($row['banner_topic']); ?></td>
                                <td><?= cleanData($row['banner_description']); ?></td>
                                <td><a href="<?= cleanData($row['banner_link']) ?>" target="_blank"><?= cleanData($row['banner_link']) ?></a></td>
                                <td><?= DateThai(cleanData($row['banner_created'])); ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-warning editBanner" data-id="<?= cleanData($row['banner_id']); ?>"><i class="bi bi-pencil-square"></i></button>
                                        <button type="button" class="btn btn-danger deleteBanner" id="<?= $row['banner_id'] ?>"><i class="bi bi-x-circle-fill"></i></button>
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

<?php include_once('bannerModal' . '.php'); ?>

<script>
    $(document).on('click', '.deleteBanner', function() {
        var id = $(this).attr("id");

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-3',
                cancelButton: 'btn btn-danger mx-3'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'ยืนยันการลบรายการนี้ใช่หรือไม่?',
            footer: '<b>ลบรายการแล้วจะไม่สามารถกู้คืนได้อีก</b>',
            icon: "warning",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่, ยืนยันการลบ!',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                window.location.href = "private/app/controller/banner.php?deleteBanner=" + id;
            }
        });
    });

    $(function() {
        $('.editBanner').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'private/app/controller/banner.php',
                method: 'POST',
                data: {
                    getBanner: id
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $('#editBanner input[name="id"]').val(data.banner_id);
                    $('#editBanner input[name="oldBanner"]').val(data.banner_img);
                    $('#editBanner input[name="bannerTopic"]').val(data.banner_topic);
                    $('#editBanner input[name="bannerDesc"]').val(data.banner_description);
                    $('#editBanner input[name="bannerLink"]').val(data.banner_link);
                    $('#editBanner').modal('show');
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

        $('#editBanner form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: 'private/app/controller/banner.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    try {
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
                            // Handle error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'There was an error updating the data.',
                                showConfirmButton: true,
                                timer: '3000',
                                focusConfirm: true
                            });
                        }
                    } catch (e) {
                        // console.log(e); // Log the error to the console
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown); // Log any errors to the console
                }
            });
        });
    });
</script>