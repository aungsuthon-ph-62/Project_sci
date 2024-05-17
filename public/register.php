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
                            <form class="mb-3 mt-md-4" id="signUpForm" action="private/app/controller/signUp.php" method="POST" autocomplete="off">
                                <div class="row justify-content-center border-bottom border-2 py-3">
                                    <img src="public/img/logo/sci_atomic.png" style="width: 40%;" loading="lazy">
                                </div>
                                <h4 class="my-3 text-center">
                                    สมัครสมาชิก
                                </h4>
                                <div class="row gy-2 mb-4">
                                    <div class="col-12">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="signup_fname" placeholder="กรุณากรอกชื่อจริง" value="<?= $fname = isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>">
                                                <label for="signup_fname">ชื่อจริง</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="signup_lname" placeholder="กรุณากรอกชื่อจริง" value="<?= $lname = isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>">
                                                <label for="signup_lname">นามสกุล</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" id="signup_email" placeholder="กรุณากรอกอีเมลล์" autocomplete="off" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                                                <label for="signup_email">อีเมลล์</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="signup_password" placeholder="กรุณากรอกรหัสผ่าน" autocomplete="off" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                                                <label for="signup_password">รหัสผ่าน</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="signup_confirm_password" placeholder="กรุณากรอกรหัสผ่านอีกครั้ง" autocomplete="off">
                                                <label for="signup_confirm_password">ยืนยันรหัสผ่าน</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 my-3">
                                        <select class="form-select" aria-label="กรุณาเลือกสถานะผู้ใช้" id="signup_role">
                                            <option value="" selected>--- กรุณาเลือกสถานะผู้ใช้ ---</option>
                                            <option value="นักสื่อสารองค์กร">นักสื่อสารองค์กร</option>
                                            <option value="นักประชาสัมพันธ์">นักประชาสัมพันธ์</option>
                                            <option value="บรรณาธิการ">บรรณาธิการ</option>
                                        </select>
                                    </div>
                                </div>
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

    <script src="resources/js/sign-up.js"></script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>