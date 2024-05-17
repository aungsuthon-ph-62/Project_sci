<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="dashboard" class="logo align-items-center text-center">
            <img src="public/img/logo/sci_atomic.png" alt="Sci_atomic logo" loading="lazy">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <?php if ($user['user_image'] == "") { ?>
                        <div class="avatar rounded-circle" data-label="<?= cleanData($user['user_fname']); ?>"></div>
                    <?php } else { ?>
                        <img src="public/img/user_img/<?= cleanData($user['user_image']); ?>" alt="Profile" class="rounded-circle" loading="lazy">
                    <?php } ?>
                    <span class="d-none d-md-block dropdown-toggle ps-2"></span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= $user['user_fname'] ?> <?= $user['user_lname'] ?></h6>
                        <span>
                            <?php if ($user['user_role'] == 'แอดมิน') { ?>
                                <i class="bi bi-person-fill-gear text-danger"></i>
                            <?php } ?>
                            <?= cleanData($user['user_role']); ?>
                        </span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="?page=profile">
                            <i class="bi bi-gear"></i>
                            <span>ตั้งค่าบัญชี</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center signOut" href="#">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>ออกจากระบบ</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>


<script>
    $(document).on('click', '.signOut', function() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-lg-3',
                cancelButton: 'btn btn-danger mx-lg-3'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'ยืนยันการออกจากระบบใช่หรือไม่?',
            text: "หากต้องการออกจากระบบ กรุณาคลิ๊กที่ปุ่มยืนยัน",
            icon: "warning",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่, ยืนยันการออกจากระบบ!',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                window.location.href = "private/app/controller/signOut.php";
            }
        });
    });
</script>