<?php
require_once '../private/app/controller/function' . '.php';
if (isset($_SESSION['id'])) {
    echo "<script> window.history.back()</script>";
    exit;
}
?>
<!doctype html>
<html lang="en">


<?php
include_once dirname(__DIR__) . '/private/app/views/dashboard/assets/layout/head' . '.php';
?>


<body>
    <div class="vh-100 d-flex justify-content-center align-items-center" data-aos="fade-out" data-aos-delay="500">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card bg-white border-0 shadow-lg">
                        <div class="card-body p-5">
                            <form class="mb-3 mt-md-4" action="private/app/controller/forgot_password.php" method="POST" autocomplete="off">
                                <div class="row justify-content-center border-bottom border-2 py-3">
                                    <img src="public/img/logo/sci_atomic.png" style="width: 40%;" loading="lazy">
                                </div>
                                <h4 class="my-3 text-center">
                                    เปลี่ยนรหัสผ่าน
                                </h4>
                                <div class="row gy-2 mb-4">
                                    <div class="col-12">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" id="changeEmail" name="changeEmail" placeholder="กรุณากรอกอีเมลล์" autocomplete="off" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                                                <label for="changeEmail">อีเมลล์</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="changePassword" name="changePassword" placeholder="กรุณากรอกรหัสผ่าน" autocomplete="off" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                                                <label for="changePassword">รหัสผ่านใหม่</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="changeConfirm" name="changeConfirm" placeholder="กรุณากรอกรหัสผ่านอีกครั้ง" autocomplete="off">
                                                <label for="changeConfirm">ยืนยันรหัสผ่านใหม่</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="submitChange" value="submitChange">
                                <div class="d-grid">
                                    <button class="btn btn-outline-primary border-0 rounded-pill shadow" type="submit">ยืนยัน</button>
                                </div>
                            </form>
                            <div>
                                <p class="mb-0  text-center">หากมีบัญชีแล้ว <a href="login" class="text-primary fw-bold">เข้าสู่ระบบ <i class="fa-solid fa-right-to-bracket"></i></a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();
                var changeEmail = $('form input[name="changeEmail"]').val();
                var password = $('form input[name="changePassword"]').val();
                var confirm = $('form input[name="changeConfirm"]').val();
                var submit = $('form input[name="submitChange"]').val();
                $.ajax({
                    url: 'private/app/controller/forgot_password.php',
                    method: 'POST',
                    data: {
                        submitChange: submit,
                        changeEmail: changeEmail,
                        changePassword: password,
                        changeConfirm: confirm
                    },
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
                                    window.location.href = 'login';
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

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>