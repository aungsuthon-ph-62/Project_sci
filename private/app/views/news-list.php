<?php
if (isset($_SESSION['id'])) {
  $id = addslashes($_SESSION['id']);

  $getUser = $user->getUserByUniqueID($id);
}
$news = new News();

if (isset($_GET['category'])) {
  $searchCategory = addslashes($_GET['category']);
  $getNews = $news->newslist_category($searchCategory);
} elseif (isset($_GET['search'])) {
  $search = addslashes($_GET['search']);
  $getNews = $news->newslist_search($search);
} else {
  $getNews = $news->newslist();
}
?>

<!DOCTYPE html>
<html lang="th">
<?php include_once("layout/head.php"); ?>

<body class="goto-here">
  <?php include_once("layout/navbar.php"); ?>

  <?php include_once("layout/hero-section.php"); ?>

  <section class="ftco-section ftco-degree-bg">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 ftco-animate">
          <div class="row">
            <?php if ($getNews) { ?>
              <?php foreach ($getNews as $newslist) { ?>
                <div class="col-md-12 d-flex ftco-animate">
                  <div class="blog-entry align-self-stretch d-md-flex">
                    <a href="detail?id=<?= cleanData($newslist['news_unique']) ?>" class="block-20" style="background-image: url('public/img/banner/<?= cleanData($newslist['news_banner']) ?>');">
                    </a>
                    <div class="text d-block pl-md-4">
                      <div class="meta mb-3">
                        <div><a href="#"><i class="fa-solid fa-calendar-days text-primary"></i> <?= DateThaiOnly(cleanData($newslist['news_created'])) ?></a></div>
                        <div><a href="#"><i class="fa-solid fa-user text-success"></i> <?= cleanData($newslist['user_fname']) ?> <?= cleanData($newslist['user_lname']) ?></a></div>
                        <div><a href="#"><i class="fa-solid fa-eye text-info"></i> <?= cleanData($newslist['news_view']) ?></a></div>
                      </div>
                      <h3 class="heading"><a href="#"><?= cleanData($newslist['news_topic']) ?></a></h3>
                      <p><a href="detail?id=<?= cleanData($newslist['news_unique']) ?>" class="btn btn-primary py-2 px-3">อ่านเพิ่มเติม <i class="fa-solid fa-circle-arrow-right"></i></a></p>
                    </div>
                  </div>
                </div>
              <?php } ?>
            <?php } else { ?>
              <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                  <p class="subheading text-center text-warning">- ไม่มีข้อมูล -</p>
                  <img class="img-fluid w-25" src="public/img/box.png" alt="No Data!" loading="lazy">
                </div>
              </div>
            <?php } ?>
          </div>
        </div> <!-- .col-md-8 -->
        <div class="col-lg-4 sidebar ftco-animate bg-primary py-3 rounded">

          <?php include_once("layout/sidebar.php"); ?>
        </div>

      </div>
    </div>
  </section> <!-- .section -->

  <?php include_once("layout/footer.php"); ?>
  <?php include_once("layout/loader.php"); ?>


</body>

</html>