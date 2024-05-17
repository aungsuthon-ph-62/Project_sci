<?php
$uid = $_SESSION['id'];
$users = new User();
$user = $users->getUserByUniqueID($uid);

?>
<!DOCTYPE html>
<html lang="en">

<?php include_once(__DIR__ . "/assets/layout/head" . '.php') ?>

<body>


  <!-- ======= Header ======= -->
  <?php include_once(__DIR__ . "/assets/layout/header" . '.php') ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php include_once(__DIR__ . "/assets/layout/sidebar" . '.php') ?>
  <!-- End Sidebar-->

  <main id="main" class="main">
    <?php $page = isset($_GET['page']) ? $_GET['page'] : '';
    if ($page) { ?>
      <?php
      switch ($page) {
        case "profile":
          include_once 'page/profile/profile.php';
          break;
        case "newsletter-valid":
          include_once 'page/newsletter/newsletter-valid.php';
          break;
        case "newsletter-add":
          include_once 'page/newsletter/newsletter-add.php';
          break;
        case "newsletter-list":
          include_once 'page/newsletter/newsletter-list.php';
          break;
        case "design":
          include_once 'page/design/design.php';
          break;
        case "banner-list":
          include_once 'page/banner/banner-list.php';
          break;
        case "member-list":
          include_once 'page/member/member-list.php';
          break;
        case "category-list":
          include_once 'page/category/category-list.php';
          break;
        case "newsDraftInfo":
          include_once 'page/news/newsDraftInfo.php';
          break;
        case "newsDraftEdit":
          include_once 'page/news/newsDraftEdit.php';
          break;
        case "newsEdit":
          include_once 'page/news/newsEdit.php';
          break;
        case "newsAdd":
          include_once 'page/news/newsAdd.php';
          break;
        case "newsInfo":
          include_once 'page/news/newsInfo.php';
          break;
        case "news-list":
          include_once 'page/news/news-list.php';
          break;
        case "publicInfo":
          include_once 'page/public-news/publicInfo.php';
          break;
        case "public-list":
          include_once 'page/public-news/public-list.php';
          break;
        case "draftEdit":
          include_once 'page/draft-news/draftEdit.php';
          break;
        case "draftAdd":
          include_once 'page/draft-news/draftAdd.php';
          break;
        case "draftInfo":
          include_once 'page/draft-news/draftInfo.php';
          break;
        case "draft-list":
          include_once 'page/draft-news/draft-list.php';
          break;
        default:
          $userRole = new User();
          if ($role = $userRole->access('แอดมิน')) {
            include_once 'page/main.php';
          } elseif ($role = $userRole->access('นักสื่อสารองค์กร')) {
            include_once 'page/draft-news/draft-list.php';
          } elseif ($role = $userRole->access('ประชาสัมพันธ์')) {
            include_once 'page/news/news-list.php';
          } elseif ($role = $userRole->access('บรรณาธิการ')) {
            include_once 'page/newsletter/newsletter-list.php';
          }
      }
      ?>
    <?php } else { ?>
      <?php
      $userRole = new User();
      if ($role = $userRole->access('แอดมิน')) {
        include_once 'page/main.php';
      } elseif ($role = $userRole->access('นักสื่อสารองค์กร')) {
        include_once 'page/draft-news/draft-list.php';
      } elseif ($role = $userRole->access('ประชาสัมพันธ์')) {
        include_once 'page/news/news-list.php';
      } elseif ($role = $userRole->access('บรรณาธิการ')) {
        include_once 'page/newsletter/newsletter-list.php';
      }
      ?>
    <?php } ?>

  </main><!-- End #main -->

  <!-- ======= Alert ======= -->
  <?php include_once(__DIR__ . "/assets/layout/alert" . '.php') ?>
  <!-- End Alert -->

  <!-- ======= Footer ======= -->
  <?php include_once(__DIR__ . "/assets/layout/footer" . '.php') ?>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->

  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


  <!-- Template Main JS File -->
  <script src="private/app/views/dashboard/assets/js/main.js"></script>
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

</body>

</html>