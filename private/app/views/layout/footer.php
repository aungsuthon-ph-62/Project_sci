<footer class="ftco-footer ftco-section bg-primary">
    <div class="container">
        <div class="row">
            <div class="mouse">
                <a href="#" class="mouse-icon">
                    <div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
                </a>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-3 m-0 p-0">
                <div class="ftco-footer-widget mb-4">
                    <div class="text-center">
                        <img src="public/img/logo/Ubu_logo.png" alt="Ubu_logo" class="img-fluid w-50" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-5 mb-md-0">
                <div class="ftco-footer-widget mt-5">
                    <h2 class="ftco-heading-2 text-center m-0 p-0">มหาวิทยาลัยอุบลราชธานี <p class="text-center text-white">Ubonratchathani University</p>
                    </h2>
                    <h6 class="text-center"><b>คณะวิทยาศาสตร์ Faculty of science</b></h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ftco-footer-widget mb-4 ml-md-5">
                    <h2 class="ftco-heading-2">เมนู</h2>
                    <ul class="list-unstyled">
                        <li><a href="news-letter" class="py-2 d-block">จดหมายข่าว</a></li>
                        <li><a href="register" class="py-2 d-block">สมัครสมาชิก</a></li>
                        <li><a href="login" class="py-2 d-block">เข้าสู่ระบบ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">หมวดหมู่ข่าว</h2>
                    <div class="d-flex">
                        <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
                            <?php
                            foreach ($category as $cat) {
                            ?>
                                <li><a href="news-list?category=<?= cleanData($cat['category_name']) ?>" class="py-2 d-block"><?= cleanData($cat['category_name']) ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">

                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | คณะวิทยาศาสตร์ Faculty of science <i class="fa-solid fa-atom"></i></a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="resources/js/jquery.min.js"></script>
<script src="resources/js/jquery-migrate-3.0.1.min.js"></script>
<script src="resources/js/popper.min.js"></script>
<script src="resources/js/bootstrap.min.js"></script>
<script src="resources/js/jquery.easing.1.3.js"></script>
<script src="resources/js/jquery.waypoints.min.js"></script>
<script src="resources/js/jquery.stellar.min.js"></script>
<script src="resources/js/owl.carousel.min.js"></script>
<script src="resources/js/jquery.magnific-popup.min.js"></script>
<script src="resources/js/aos.js"></script>
<script src="resources/js/jquery.animateNumber.min.js"></script>
<script src="resources/js/bootstrap-datepicker.js"></script>
<script src="resources/js/scrollax.min.js"></script>
<script src="resources/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>

<script>
    const avatars = document.querySelectorAll(".avatar");

    avatars.forEach((a) => {
        const charCodeRed = a.dataset.label.charCodeAt(0);
        const charCodeGreen = a.dataset.label.charCodeAt(1) || charCodeRed;

        const red = Math.pow(charCodeRed, 7) % 200;
        const green = Math.pow(charCodeGreen, 7) % 200;
        const blue = (red + green) % 200;

        a.style.background = `rgb(${red}, ${green}, ${blue})`;
    });
</script>

<script>
    $(document).on('click', '#signOut', function() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success rounded-lg mx-3',
                cancelButton: 'btn btn-danger rounded-lg mx-3'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'ต้องการจะออกจากระบบใช่หรือไม่?',
            icon: "warning",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ออกจากระบบ',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                window.location.href = "private/app/controller/signOut.php";
            }
        });
    });
</script>