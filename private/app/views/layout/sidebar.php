<?php
$sidebarNews = $news->sidebar_news('เผยแพร่');
?>

<div class="sidebar-box bg-primary">
    <form class="search-form" id="search-form">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="ค้นหา..." aria-describedby="searchSubmit" name="search" id="search">
            <div class="input-group-append">
                <button class="btn btn-primary rounded-0" type="submit" id="searchSubmit" name="searchSubmit"><i class="fa-solid fa-magnifying-glass"></i> ค้นหา</button>
            </div>
        </div>
    </form>
</div>
<div class="sidebar-box ftco-animate rounded">
    <h3 class="heading"><i class="fa-solid fa-tag text-warning"></i> หมวดหมู่ข่าว</h3>
    <ul class="categories">
        <?php foreach ($category as $cat) { ?>
            <li>
                <a href="news-list?category=<?= cleanData($cat['category_name']) ?>"><?= cleanData($cat['category_name']) ?>
                    <?php if ($countNewsCategory = $news->countNewsCategory($cat['category_unique'])) { ?>
                        <span>(<?= cleanData($countNewsCategory['countNewsCategory']) ?>)</span>
                    <?php } ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>

<div class="sidebar-box ftco-animate rounded">
    <h3 class="heading"><i class="fa-solid fa-rss text-warning"></i> ข่าวล่าสุด</h3>
    <?php foreach ($sidebarNews as $sidebar) { ?>
        <div class="block-21 mb-4 d-flex">
            <a class="blog-img mr-4" style="background-image: url(public/img/banner/<?= cleanData($sidebar['news_banner']) ?>);"></a>
            <div class="text">
                <h3 class="heading-1"><a href="detail?id=<?= cleanData($sidebar['news_unique']) ?>"><?= cleanData($sidebar['news_topic']) ?></a></h3>
                <div class="meta">
                    <div><a href="detail?id=<?= cleanData($sidebar['news_unique']) ?>"><span class="icon-calendar text-primary"></span> <?= DateThaiOnly(cleanData($sidebar['news_created'])) ?></a></div>
                    <div><a href="detail?id=<?= cleanData($sidebar['news_unique']) ?>"><span><i class="fa-solid fa-eye text-info"></i></span> <?= cleanData($sidebar['news_view']) ?></a></div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    const form = document.querySelector('#search-form');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        var search = $('#search-form input[name="search"]').val();

        if (search === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน!',
                showConfirmButton: true,
                timer: '3000',
                focusConfirm: true
            });
        }

        window.location.href = "news-list?search=" + search;
    });
</script>