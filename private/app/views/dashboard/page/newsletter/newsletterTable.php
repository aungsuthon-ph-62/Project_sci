<?php $role = $user->access('บรรณาธิการ');
if ($role) { ?>
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-primary" href="?page=newsletter-add"><i class="fa-solid fa-plus"></i> เพิ่มจดหมายข่าว</a>
            </div>
        </div>

        <div class="card-body p-3 p-lg-5">
            <?php
            $newsletter = new newsletter;
            $newsletter_result = $newsletter->get_all_newsletter();
            ?>
            <div class="table-resposive">
                <table class="table table-bordered table-hover datatable">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>หัวข้อ</th>
                            <th>ไฟล์</th>
                            <th>ผู้เพิ่ม</th>
                            <th>วันที่เพิ่ม</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($newsletter_result) {
                            $i = 0 ?>
                            <?php foreach ($newsletter_result as $row) { ?>
                                <tr>
                                    <td><?php echo $i = $i + 1; ?></td>
                                    <td><?= cleanData($row['newsletter_topic']); ?></td>
                                    <td><a href="public/pdf/design/<?= cleanData($row['newsletter_file']); ?>" target="_blank"><?= cleanData($row['newsletter_file']); ?></a></td>
                                    <td><?= cleanData($row['user_fname']); ?> <?= cleanData($row['user_lname']); ?></td>
                                    <td><?= DateThai(cleanData($row['newsletter_created'])); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-danger deleteNewsletter" id="<?= $row['newsletter_unique'] ?>" data-newsletter-title="<?= $row['newsletter_topic'] ?>" data-newsletter-file="<?= $row['newsletter_file'] ?>"><i class="bi bi-x-circle-fill"></i></button>
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

    <?php include_once('newsletterModal' . '.php'); ?>

    <script>
        $(document).on('click', '.deleteNewsletter', function() {
            var id = $(this).attr("id");
            var newsletterTitle = $(this).attr("data-newsletter-title");
            var file = $(this).attr("data-newsletter-file");

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-3',
                    cancelButton: 'btn btn-danger mx-3'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'ยืนยันการลบรายการนี้ใช่หรือไม่?',
                html: "<h5>รายการ : " + newsletterTitle + "</h5>",
                footer: '<b>ลบรายการแล้วจะไม่สามารถกู้คืนได้อีก</b>',
                icon: "warning",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ยืนยันการลบ!',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    window.location.href = "private/app/controller/newsletter.php?deleteNewsletter=" + id + "&file=" + file;
                }
            });
        });

        $(function() {
            $('.editNewsletter').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: 'private/app/controller/newsletter.php',
                    method: 'POST',
                    data: {
                        getNewsletter: id
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#editNewsletter input[name="id"]').val(data.newsletter_unique);
                        $('#editNewsletter input[name="oldNewsletter"]').val(data.newsletter_file);
                        $('#editNewsletter input[name="newsletterTopic"]').val(data.newsletter_topic);
                        $('#editNewsletter').modal('show');
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

            $('#editNewsletter form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: 'private/app/controller/newsletter.php',
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
                            console.log(e); // Log the error to the console
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown); // Log any errors to the console
                    }
                });
            });

            $(function() {
                $('.edit-btn').on('click', function() {
                    var id = $(this).data('id');
                    $.ajax({
                        url: 'private/app/controller/users.php',
                        method: 'POST',
                        data: {
                            getUser: id
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            $('#editUsers input[name="id"]').val(data.user_unique);
                            $('#editUsers input[name="usersFname"]').val(data.user_fname);
                            $('#editUsers input[name="usersLname"]').val(data.user_lname);
                            $('#editUsers input[name="usersEmail"]').val(data.user_email);
                            $('#editUsers input[name="oldPassword"]').val(data.user_password);
                            $('#editUsers select[name="usersRole"]').val(data.user_role);
                            $('#editUsers').modal('show');
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

                $('#newsletterAdd form').on('submit', function(e) {
                    e.preventDefault();
                    var newsletterTopic = $('#newsletterAdd input[name="newsletterTopic"]').val();
                    var designBanner = $('#newsletterAdd input[name="designBanner"]').val();
                    var first_name = $('#newsletterAdd input[name="usersFname"]').val();
                    var last_name = $('#newsletterAdd input[name="usersLname"]').val();
                    var email = $('#newsletterAdd input[name="usersEmail"]').val();
                    var password = $('#newsletterAdd input[name="usersPassword"]').val();
                    var role = $('#newsletterAdd select[name="usersRole"]').val();
                    $.ajax({
                        url: 'private/app/controller/users.php',
                        method: 'POST',
                        data: {
                            action: 'editUsers',
                            id: id,
                            oldPassword: oldPassword,
                            first_name: first_name,
                            last_name: last_name,
                            email: email,
                            password: password,
                            role: role
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
        });
    </script>
<?php } ?>