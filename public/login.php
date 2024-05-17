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
include_once '../private/app/views/dashboard/assets/layout/head' . '.php';
?>


<body>
    <div class="vh-100 d-flex justify-content-center align-items-center" data-aos="fade-out" data-aos-delay="500">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card bg-white border-0 shadow-lg">
                        <div class="card-body p-5">
                            <form class="mb-3 mt-md-4" id="signInForm" autocomplete="on">
                                <div class="row justify-content-center border-bottom border-2 py-3">
                                    <img src="public/img/logo/sci_atomic.png" style="width: 40%;" loading="lazy">
                                </div>
                                <h4 class="my-3 text-center">
                                    เข้าสู่ระบบ
                                </h4>
                                <div class="row gy-2 mb-4">
                                    <div class="col-12">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" id="signin_email" placeholder="กรุณากรอกอีเมลล์" autocomplete="on">
                                                <label for="signin_email">อีเมลล์</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="signin_password" placeholder="กรุณากรอกรหัสผ่าน" autocomplete="on">
                                                <label for="signin_password">รหัสผ่าน</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="small"><a class="text-primary" href="forgot">ลืมรหัสผ่าน</a></p>
                                <div class="d-grid">
                                    <button class="btn btn-outline-primary border-0 rounded-pill shadow" type="submit">เข้าสู่ระบบ <i class="fa-solid fa-right-to-bracket"></i></button>
                                </div>
                            </form>
                            <div class="mt-4">
                                <p class="mb-0  text-center">หากยังไม่มีบัญชี <a href="register" class="text-primary fw-bold">สมัครสมาชิก <i class="fa-solid fa-user-plus"></i></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="resources/js/sign-in.js"></script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>