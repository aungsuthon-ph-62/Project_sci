<div class="card">
    <div class="card-header">
        <div class="card-tools">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUsers"><i class="fa-solid fa-plus"></i> เพิ่มผู้ใช้งาน</button>
        </div>
    </div>

    <div class="card-body p-3 p-lg-5">
        <?php
        $users = new User;
        $users_result = $users->get_all_user($_SESSION['id']);
        ?>
        <div class="table-resposive">
            <table id="postTable" class="table table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>หมายเลขผู้ใช้งาน</th>
                        <th>อีเมลล์</th>
                        <th>ชื่อจริง - นามสกุล</th>
                        <th>ระดับผู้ใช้</th>
                        <th>ยืนยันเข้าใช้งาน</th>
                        <th>สมัครเมื่อ</th>
                        <th>แก้ไขข้อมูลล่าสุด</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users_result) {
                        $i = 0 ?>
                        <?php foreach ($users_result as $row) { ?>
                            <tr>
                                <td><?php echo $i = $i + 1; ?></td>
                                <td><?= cleanData($row['user_unique']); ?></td>
                                <td><?= cleanData($row['user_email']); ?></td>
                                <td class="text-truncate"><?= cleanData($row['user_fname']) ?> <?= cleanData($row['user_lname']) ?></td>
                                <td><?= cleanData($row['user_role']); ?></td>
                                <td class="px-4">
                                    <?php if ($row['user_approve'] != null) { ?>
                                        <p class="text-bg-success rounded text-center"><?= cleanData($row['user_approve']); ?></p>
                                    <?php } else { ?>
                                        <p class="text-bg-danger rounded text-center">ยังไม่ยืนยัน</p>
                                    <?php } ?>
                                </td>
                                <td><?= DateThai(cleanData($row['user_created'])); ?></td>
                                <td>
                                    <?php if ($row['user_edit'] != null) { ?>
                                        <p class="text-info rounded text-center m-0"><?= DateThai($row['user_edit']); ?></p>
                                    <?php } else { ?>
                                        <p class="text-danger rounded text-center m-0">ยังไม่มีการแก้ไข</p>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-warning edit-btn" data-id="<?= cleanData($row['user_unique']); ?>"><i class="bi bi-pencil-square"></i></button>
                                        <button type="button" class="btn btn-danger deleteUser" id="<?= $row['user_unique'] ?>" data-user-title="<?= $row['user_unique'] ?>"><i class="bi bi-x-circle-fill"></i></button>
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

<?php include_once('memberModal' . '.php'); ?>

<script>
    $(document).on('click', '.deleteUser', function() {
        var id = $(this).attr("id");
        var userTitle = $(this).attr("data-user-title");

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-3',
                cancelButton: 'btn btn-danger mx-3'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'ยืนยันการลบรายการนี้ใช่หรือไม่?',
            html: "<h5>รายการ : " + userTitle + "</h5>",
            footer: '<b>ลบรายการแล้วจะไม่สามารถกู้คืนได้อีก</b>',
            icon: "warning",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่, ยืนยันการลบ!',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                window.location.href = "private/app/controller/users.php?deleteUser=" + id;
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

                    // Check if response data.user_approve is null
                    if (data.user_approve != null) {
                        // Hide the select element
                        $('#usersApproveSelect').hide();
                        const mySwitch = document.querySelector('#editUsers input[name="usersApprove"]');
                        const switchValue = this.checked;
                        approve = switchValue ? '' : 'ยืนยันแล้ว';
                    } else {
                        // Show the select element
                        $('#usersApproveSelect').show();
                    }

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

        const mySwitch = document.querySelector('#editUsers input[name="usersApprove"]');
        let approve;

        mySwitch.addEventListener('change', function() {
            const switchValue = this.checked;

            // Update the value of approve based on switchValue
            approve = switchValue ? 'ยืนยันแล้ว' : '';
        });

        $('#editUsers form').on('submit', function(e) {
            e.preventDefault();
            var id = $('#editUsers input[name="id"]').val();
            var oldPassword = $('#editUsers input[name="oldPassword"]').val();
            var first_name = $('#editUsers input[name="usersFname"]').val();
            var last_name = $('#editUsers input[name="usersLname"]').val();
            var email = $('#editUsers input[name="usersEmail"]').val();
            var password = $('#editUsers input[name="usersPassword"]').val();
            var role = $('#editUsers select[name="usersRole"]').val();

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
                    role: role,
                    approve: approve
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
                            text: data.error,
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