<?php
if (isset($_SESSION['id'])) {
  $id = addslashes($_SESSION['id']);

  $getUser = $user->getUserByUniqueID($id);
}
if (!isset($_GET['id'])) {
  echo "<script> window.history.back()</script>";
  exit;
} else {
  $id = addslashes($_GET['id']);
}

if ($id) {
  $db = new Database();
  $query = "UPDATE news SET news_view=news_view + 1 WHERE news_unique = '$id'";
  $result = $db->db_write($query);
}

$news = new News();
$getNewsByID = $news->get_news($id);
$row = $getNewsByID[0];


?>

<!DOCTYPE html>
<html lang="th">
<?php include_once("layout/head.php"); ?>

<body class="goto-here">

  <?php include_once("layout/navbar.php"); ?>
  <!-- END nav -->

  <?php if ($row['news_banner'] == "") { ?>
    <div class="hero-wrap hero-bread" id="newsBanner" style="background-image: url('public/img/banner/undraw_newspaper_re_syf5.svg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><a href="index">หน้าแรก</a></span>/ <span>ข่าว</span></p>
            <h1 class="mb-0 bread"><?= cleanData($row['news_topic']) ?></h1>
          </div>
        </div>
      </div>
    </div>
  <?php } else { ?>
    <div class="hero-wrap hero-bread" id="newsBanner" style="background-image: url('public/img/banner/<?= cleanData($row['news_banner']) ?>');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><a href="index">หน้าแรก</a></span>/ <span>ข่าว</span></p>
            <h1 class="mb-0 bread"><?= cleanData($row['news_topic']) ?></h1>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <section class="ftco-section ftco-degree-bg">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 ftco-animate">
          <blockquote>
            <?= $row['news_article']; ?>
          </blockquote>
          <div class="tag-widget post-tag-container mb-5 mt-5">
            <div class="tagcloud">
              <a href="category?id=<?= cleanData($row['category_unique']) ?>" class="tag-cloud-link btn btn-primary"><i class="fa-solid fa-tag"></i> <?= cleanData($row['category_name']) ?></a>
              <span class="mx-3"><i class="fa-solid fa-calendar-days text-primary"></i> <?= DateThaiOnly(cleanData($row['news_created'])) ?></span>
              <span class="mx-3"><i class="fa-solid fa-eye text-info"></i> <?= cleanData($row['news_view']) ?></span>
            </div>
          </div>

          <ul class="comment-list">
            <li class="comment bg-light p-5">
              <div class="vcard bio">
                <img src="public/img/user_img/<?= cleanData($row['user_image']); ?>" alt="<?= cleanData($row['user_image']); ?>">
              </div>
              <div class="comment-body">
                <h3><?= cleanData($row['user_fname']); ?> <?= cleanData($row['user_lname']); ?></h3>
                <p><i class="fa-solid fa-user text-primary"></i> <?= cleanData($row['user_role']); ?></p>
              </div>
            </li>
          </ul>
        </div> <!-- .col-md-8 -->


        <?php include_once("layout/sidebar.php"); ?>
      </div>
  </section> <!-- .section -->

  <?php include_once("layout/footer.php"); ?>
  <?php include_once("layout/loader.php"); ?>

</body>

</html>