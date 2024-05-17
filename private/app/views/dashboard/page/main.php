<div class="pagetitle">
  <h1>แดชบอร์ด</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard">หน้าแรก</a></li>
      <li class="breadcrumb-item active">แดชบอร์ด</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-8">
      <div class="row">

        <!-- Draft Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card draft-card">

            <div class="card-body">
              <h5 class="card-title">ข่าวร่างทั้งหมด</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-pen-ruler"></i>
                </div>
                <div class="ps-3">
                  <?php
                  $news = new News();
                  $countDraft = $news->draft_count();
                  ?>
                  <h6><?= $countDraft['countDraft'] ?></h6>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- End Draft Card -->

        <!-- Public Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card public-card">

            <div class="card-body">
              <h5 class="card-title">ข่าวเผยแพร่ทั้งหมด</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-globe2"></i>
                </div>
                <div class="ps-3">
                  <?php
                  $countPublic = $news->public_count();
                  ?>
                  <h6><?= $countPublic['countPublic'] ?></h6>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- End Public Card -->

        <!-- News Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">ข่าวทั้งหมด</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-newspaper"></i>
                </div>
                <div class="ps-3">
                  <?php
                  $countNews = $news->news_count();
                  ?>
                  <h6><?= $countNews['countNews'] ?></h6>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- End News Card -->

        <!-- Category Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card category-card">

            <div class="card-body">
              <h5 class="card-title">หมวดหมู่ทั้งหมด</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-tags-fill"></i>
                </div>
                <div class="ps-3">
                  <?php
                  $countCategory = $news->newsCategory_count();
                  ?>
                  <h6><?= $countCategory['countCategory'] ?></h6>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- End Category Card -->

        <!-- Newsletter Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card revenue-card">

            <div class="card-body">
              <h5 class="card-title">จดหมายข่าวทั้งหมด </h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar-date-fill"></i>
                </div>
                <div class="ps-3">
                  <?php
                  $newsletter = new newsletter();
                  $countNewsletter = $newsletter->newsletter_count();
                  ?>
                  <h6><?= $countNewsletter['countNewsletter'] ?></h6>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- End Newsletter Card -->

        <!-- Member Card -->
        <div class="col-xxl-4 col-xl-12">

          <div class="card info-card customers-card">

            <div class="card-body">
              <h5 class="card-title">ผู้ใช้งานทั้งหมด</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <?php
                  $countUsers = $user->users_count();
                  ?>
                  <h6><?= $countUsers['countUsers'] ?></h6>

                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- End Member Card -->

        <!-- All news -->
        <div class="col-12">
          <?php include_once("news/newsTable.php"); ?>
        </div><!-- End All news -->

        <!-- Newsletter -->
        <div class="col-12">
          <?php include_once("newsletter/newsletterTable.php"); ?>
        </div>
        <!-- End Newsletter -->

      </div>
    </div><!-- End Left side columns -->

    <!-- Right side columns -->
    <div class="col-lg-4">

      <!-- Banner -->
      <?php include_once("banner/bannerTable.php"); ?>
      <!-- End Banner -->

      <!-- Category -->
      <?php include_once("category/categoryTable.php"); ?>
      <!-- End Category -->

      <!-- Users -->
      <?php include_once("member/memberTable.php"); ?>
      <!-- End Users -->

    </div><!-- End Right side columns -->

  </div>
</section>