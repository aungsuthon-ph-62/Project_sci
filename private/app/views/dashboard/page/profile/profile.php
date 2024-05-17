<?php
$uid = $_SESSION['id'];
$users = new User();
$user = $users->getUserByUniqueID($uid);
?>

<div class="pagetitle">
    <h1>โปรไฟล์</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">หน้าแรก</a></li>
            <li class="breadcrumb-item">ตั้งค่าบัญชี</li>
            <li class="breadcrumb-item active">โปรไฟล์</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section profile">
    <div class="row">
        <div class="col-xl-12">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">ภาพรวม</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">แก้ไขโปรไฟล์</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">เปลี่ยนรหัสผ่าน</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <div class="container">
                                <h5 class="card-title">รายละเอียดโปรไฟล์</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">รูปโปรไฟล์</div>
                                    <div class="col-lg-9 col-md-8 py-4">
                                        <?php if ($user['user_image'] == "") { ?>
                                            <div class="avatar rounded-circle" data-label="<?= cleanData($user['user_fname']); ?>"></div>
                                        <?php } else { ?>
                                            <img src="public/img/user_img/<?= cleanData($user['user_image']); ?>" alt="Profile" class="rounded-circle w-25" loading="lazy">
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">รหัสผู้ใช้งาน</div>
                                    <div class="col-lg-9 col-md-8"><?= cleanData($user['user_unique']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">ชื่อจริง</div>
                                    <div class="col-lg-9 col-md-8"><?= cleanData($user['user_fname']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">นามสกุล</div>
                                    <div class="col-lg-9 col-md-8"><?= cleanData($user['user_lname']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">อีเมลล์</div>
                                    <div class="col-lg-9 col-md-8"><?= cleanData($user['user_email']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">สถานะ</div>
                                    <div class="col-lg-9 col-md-8"><?= cleanData($user['user_role']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">เข้าร่วมเมื่อ</div>
                                    <div class="col-lg-9 col-md-8"><?= DateThai(cleanData($user['user_created'])); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">แก้ไขล่าสุดเมื่อ</div>
                                    <div class="col-lg-9 col-md-8"><?= DateThai(cleanData($user['user_edit'])); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <div class="container">
                                <!-- Profile Edit Form -->
                                <form id="editUser" method="POST" action="private/app/controller/editUser.php" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" name="action" value="editUser">
                                    <input type="hidden" name="id" value="<?= cleanData($user['user_unique']); ?>">
                                    <input type="hidden" name="oldImg" value="<?= cleanData($user['user_image']); ?>">
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">รูปโปรไฟล์</label>
                                        <div class="col-md-8 col-lg-9">
                                            <?php if ($user['user_image'] == "") { ?>
                                                <img src="public/img/photo.png" id='previewImg' class='img-fluid' loading="lazy">
                                            <?php } else { ?>
                                                <img src="public/img/user_img/<?= cleanData($user['user_image']); ?>" id='previewImg' class='img-fluid' loading="lazy">
                                            <?php } ?>
                                            <div class="my-3">
                                                <div class="input-group">
                                                    <input type="file" class="form-control" name="userImg" id="userImg" accept='image/gif, image/jpeg, image/png, image/jpg, image/webp, image/svg'>
                                                    <label class="input-group-text text-bg-primary" for="userImg"><i class="bi bi-upload"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="userFname" class="col-md-4 col-lg-3 col-form-label">ชื่อจริง</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="userFname" type="text" class="form-control" id="userFname" value="<?= cleanData($user['user_fname']); ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="userLname" class="col-md-4 col-lg-3 col-form-label">นามสกุล</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="userLname" type="text" class="form-control" id="userLname" value="<?= cleanData($user['user_lname']); ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="userEmail" class="col-md-4 col-lg-3 col-form-label">อีเมลล์</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="userEmail" type="text" class="form-control" id="userEmail" value="<?= cleanData($user['user_email']); ?>" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="text-center mt-5">
                                        <button type="submit" class="btn btn-success rounded-pill"><i class="fa-solid fa-floppy-disk"></i> บันทึกข้อมูล</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>
                        </div>

                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <div class="container">
                                <!-- Change Password Form -->
                                <form id="changePassword" method="POST" action="private/app/controller/editUser.php" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" name="action" value="changePassword">
                                    <input type="hidden" name="id" value="<?= cleanData($user['user_unique']); ?>">
                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">รหัสผ่านปัจจุบัน</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control" id="currentPassword" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">รหัสผ่านใหม่</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="newpassword" type="password" class="form-control" id="newPassword" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">กรอกรหัสผ่านใหม่อีกครั้ง</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="renewpassword" type="password" class="form-control" id="renewPassword" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="text-center mt-5">
                                        <button type="submit" class="btn btn-success rounded-pill"><i class="fa-solid fa-floppy-disk"></i> บันทึกข้อมูล</button>
                                    </div>
                                </form><!-- End Change Password Form -->
                            </div>
                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>
</section>

<script>
    let imgInput = document.querySelector('#userImg');
    let previewImg = document.querySelector('#previewImg');

    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            previewImg.src = URL.createObjectURL(file);
        }
    }
</script>

<script>
    $(function() {
        $('#profile-edit form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: 'private/app/controller/editUser.php',
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
                                text: data.error,
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

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-3',
                cancelButton: 'btn btn-info mx-3'
            },
            buttonsStyling: false
        });

        $('#profile-change-password form').on('submit', function(e) {
            e.preventDefault();
            var form = document.querySelector('#changePassword');
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: 'private/app/controller/editUser.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    try {
                        var data = JSON.parse(response);
                        if (data.success) {
                            swalWithBootstrapButtons.fire({
                                title: 'เปลี่ยนรหัสผ่านสำเร็จ!',
                                html: "<h6>รหัสผ่านมีการเปลี่ยนแปลง, ต้องการเข้าสู่ระบบใหม่อีกครั้งหรือไม่?</h6>",
                                icon: "success",
                                type: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'ใช่, เข้าสู่ระบบใหม่อีกครั้ง!',
                                cancelButtonText: 'อยู่ในระบบต่อไป',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = "private/app/controller/signOut.php";
                                }else{
                                    form.reset();
                                }
                            });
                        } else {
                            // Handle error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.error,
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
    });
</script>