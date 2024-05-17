<?php
if (isset($_SESSION['id'])) {
    $id = addslashes($_SESSION['id']);

    $getUser = $user->getUserByUniqueID($id);
} else {
    echo "<script> window.history.back()</script>";
    exit;
}
$news = new News();
?>

<!DOCTYPE html>
<html lang="th">
<?php include_once("layout/head.php"); ?>

<body class="goto-here">
    <?php include_once("layout/navbar.php"); ?>

    <?php include_once("layout/hero-section.php"); ?>

    <section class="ftco-section contact-section bg-light">
        <div class="container">
            <div class="row block-9">
                <div class="col-md-6 d-flex text-warning font-weight-bold">
                    <form action="private/app/controller/users.php" class="bg-white p-5 contact-form bg-primary rounded" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="editInfo">
                        <input type="hidden" name="oldImage" value="<?= cleanData($getUser['user_image']) ?>">
                        <input type="hidden" name="oldPassword" value="<?= cleanData($getUser['user_password']) ?>">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputImageLabel"><i class="fa-solid fa-upload"></i></span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputImage" name="inputImage" aria-describedby="inputImageLabel" accept='image/gif, image/jpeg, image/png, image/jpg, image/webp, image/svg'>
                                <label class="custom-file-label" for="inputImage">เลือกรูปภาพ</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputFname">ชื่อจริง</label>
                                <input type="text" class="form-control rounded" id="inputFname" name="inputFname" value="<?= cleanData($getUser['user_fname']) ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputLname">นามสกุล</label>
                                <input type="text" class="form-control rounded" id="inputLname" name="inputLname" value="<?= cleanData($getUser['user_lname']) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">อีเมลล์</label>
                            <input type="email" class="form-control rounded" id="inputEmail" name="inputEmail" value="<?= cleanData($getUser['user_email']) ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">รหัสผ่าน <small>(หากไม่ต้องการเปลี่ยนไม่ต้องกรอก)</small></label>
                            <input type="password" class="form-control rounded" id="inputPassword" name="inputPassword" autocomplete="off">
                        </div>
                        <div class="form-group text-center mt-5">
                            <input type="submit" class="btn btn-primary py-2 px-5">
                        </div>
                    </form>

                </div>

                <div class="col-md-6 d-flex order-first">
                    <div id="map" class="text-center">
                        <?php if ($getUser['user_image'] != '') { ?>
                            <img src="public/img/user_img/<?= cleanData($getUser['user_image']) ?>" id="userImage" class="img-fluid rounded" alt="" loading="lazy">
                        <?php } else { ?>
                            <img src="public/img/undraw_personal_info_re_ur1n.svg" id="userImage" class="img-fluid rounded" alt="" loading="lazy">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- .section -->

    <?php include_once("layout/footer.php"); ?>
    <?php include_once("layout/loader.php"); ?>

    <script>
        let imgInput = document.querySelector('#inputImage');
        let previewImg = document.querySelector('#userImage');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }

        $(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: 'private/app/controller/users.php',
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
        });
    </script>

</body>

</html>