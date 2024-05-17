<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand d-flex" href="index">
            <img src="public/img/logo/sci_atomic.png" width="80" height="80" alt="Sci_Atomic">
            <div class="py-2">
                คณะวิทยาศาสตร์
                <br>
                Faculty of Science
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> เมนู
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="index" class="nav-link">หน้าแรก</a></li>
                <li class="nav-item"><a href="news-letter" class="nav-link">จดหมายข่าว</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">หมวดหมู่</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <?php

                        $category = $news->news_category();
                        foreach ($category as $cat) {
                        ?>
                            <a class="dropdown-item" href="news-list?category=<?= cleanData($cat['category_name']) ?>"><?= cleanData($cat['category_name']) ?></a>
                        <?php } ?>
                    </div>
                </li>
                <?php if (!isset($_SESSION['id'])) { ?>
                    <li class="nav-item cta cta-colored"><a href="login" class="nav-link"><i class="fa-solid fa-right-to-bracket"></i>เข้าสู่ระบบ</a></li>
                <?php } else { ?>
                    <?php if ($getUser['user_image'] == '') { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle avatar" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-label="<?= cleanData($getUser['user_fname']); ?>"></a>
                            <div class="dropdown-menu" aria-labelledby="dropdown04">
                                <a class="dropdown-item" href="profile">ตั้งค่าบัญชี</a>
                                <button type="button" id="signOut" class="dropdown-item btn btn-danger rounded"><i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ</button>
                            </div>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle" src="public/img/user_img/<?= cleanData($getUser['user_image']); ?>" alt="" style="width: 30px;">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdown04">
                                <a class="dropdown-item" href="profile">ตั้งค่าบัญชี</a>
                                <button type="button" id="signOut" class="dropdown-item btn btn-danger rounded"><i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ</button>
                            </div>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<!-- END nav -->