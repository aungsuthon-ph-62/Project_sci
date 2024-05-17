<?php
if (isset($_SESSION['id'])) {
	$id = addslashes($_SESSION['id']);

	$getUser = $user->getUserByUniqueID($id);
}
$news = new News();
$getNews = $news->home_news('เผยแพร่', 'ข่าวทั่วไป');
$getMostViews = $news->most_views_news();
$getSubject = $news->news_subject();
?>

<!DOCTYPE html>
<html lang="th">
<?php include_once("layout/head.php"); ?>

<body class="goto-here">

	<?php include_once("layout/navbar.php"); ?>

	<?php include_once("layout/hero-section.php"); ?>

	<section class="ftco-section bg-light">
		<div class="container">
			<div class="row justify-content-center mb-3 pb-3">
				<div class="col-md-12 heading-section text-center ftco-animate">
					<p class="subheading text-left">ข่าวล่าสุด <span class="font-weight-normal text-warning"><i class="fa-solid fa-square-rss"></i></span></p>
				</div>
			</div>
		</div>
		<div class="container">
			<?php
			if ($getNews) {
			?>
				<div class="row">
					<?php foreach ($getNews as $news) { ?>
						<div class="col-md-6 col-lg-3 ftco-animate">
							<div class="product shadow-lg border-0">
								<a href="detail?id=<?= cleanData($news['news_unique']); ?>" class="img-prod"><img class="img-fluid" src="public/img/banner/<?= cleanData($news['news_banner']); ?>" alt="<?= cleanData($news['news_banner']); ?>" loading="lazy">
									<span class="status"><i class="fa-solid fa-tag"></i> <?= cleanData($news['category_name']); ?></span>
									<div class="overlay"></div>
								</a>
								<div class="text py-3 pb-4 px-3 text-center">
									<h3><a href="detail?id=<?= cleanData($news['news_unique']); ?>"><?= cleanData($news['news_topic']); ?></a></h3>
									<div class="d-flex">
										<div class="pricing">
											<p class="price text-primary"><span class="mr-3"><i class="fa-solid fa-eye"></i> <?= cleanData($news['news_view']); ?></span><span class="text-info"><i class="fa-solid fa-calendar-days"></i> <?= DateThaiOnly(cleanData($news['news_created'])); ?></span></p>
										</div>
									</div>
									<div class="bottom-area d-flex px-3">
										<div class="m-auto d-flex">
											<a href="detail?id=<?= cleanData($news['news_unique']); ?>" class="p-auto align-items-center text-center rounded shadow-lg">
												<span class="mx-3">ดูเพิ่มเติม <i class="fa-solid fa-circle-info"></i></span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } else { ?>
				<div class="row justify-content-center mb-3 pb-3">
					<div class="col-md-12 heading-section text-center ftco-animate">
						<p class="subheading text-center text-warning">- ไม่มีข้อมูล -</p>
						<img class="img-fluid w-25" src="public/img/undraw_taken_re_yn20.svg" alt="No Data!">
					</div>
				</div>
			<?php } ?>
			<div class="text-center mt-5"><a href="news-list" class="btn btn-primary">ดูข่าวทั้งหมด <i class="fa-solid fa-square-arrow-up-right"></i></a></div>
		</div>
	</section>

	<section class="ftco-section testimony-section">
		<div class="container">
			<div class="row justify-content-center pb-3 mb-5">
				<div class="col-md-7 heading-section ftco-animate text-center border-bottom">
					<span class="subheading"><span class="font-weight-normal text-warning"><i class="fa-solid fa-star"></i></span> ยอดเข้าชมสูงสุด</span>
				</div>
			</div>
			<div class="row ftco-animate">
				<div class="col-md-12">
					<?php
					if ($getMostViews) {
					?>
						<div class="carousel-testimony owl-carousel">
							<?php foreach ($getMostViews as $mostViews) { ?>
								<div class="item">
									<div class="testimony-wrap p-4 pb-5">
										<div class="user-img mb-5" style="background-image: url(public/img/banner/<?= cleanData($mostViews['news_banner']) ?>)">
											<span class="quote d-flex align-items-center justify-content-center">
												<i class="fa-solid fa-tag mr-1"></i>
												<small>
													<?= cleanData($mostViews['category_name']) ?>
												</small>
											</span>
										</div>
										<div class="text text-center">
											<p class="pl-4 line"><?= cleanData($mostViews['news_topic']) ?></p>
											<p class="name mb-3"><i class="fa-solid fa-eye mr-1 text-primary"></i> <small><?= cleanData($mostViews['news_view']) ?></small> <span class="ml-5"><i class="fa-solid fa-calendar-days text-info"></i> <small><?= DateThaiOnly(cleanData($mostViews['news_created'])) ?></small></span></p>
											<a href="detail?id=<?= cleanData($mostViews['news_unique']); ?>" class="btn btn-primary p-auto align-items-center text-center rounded shadow-lg">
												<span class="mx-3">ดูเพิ่มเติม <i class="fa-solid fa-circle-info"></i></span>
											</a>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					<?php } else { ?>
						<div class="row justify-content-center mb-3 pb-3">
							<div class="col-md-12 heading-section text-center ftco-animate">
								<p class="subheading text-center text-warning">- ไม่มีข้อมูล -</p>
								<img class="img-fluid w-25" src="public/img/box.png" alt="No Data!">
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>

	<section class="ftco-section ftco-category bg-light">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12 align-items-stretch d-flex mb-3">
							<div class="category-wrap-2 ftco-animate img align-self-stretch d-flex bg-primary align-items-center rounded-lg p-5">
								<div class="text text-center">
									<h2 class=" pb-2 text-warning"><i class="fa-solid fa-bullhorn text-warning"></i> ข่าวประกาศจากภาควิชา</h2>
									<p><a href="news-list?category=ภาควิชา" class="btn btn-primary">ดูข่าวทั้งหมด <i class="fa-solid fa-square-arrow-up-right"></i></a></p>
								</div>
							</div>
						</div>
						<?php if ($getSubject) { ?>
							<?php foreach ($getSubject as $subject) { ?>
								<div class="col-md-4">
									<a href="detail?id=<?= $subject['news_unique'] ?>">
										<div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url(public/img/banner/<?= cleanData($subject['news_banner']); ?>);">
											<div class="text px-3 py-1">
												<p class="text-white m-0">
													<i class="fa-solid fa-tag mr-1 text-warning"></i>
													<?= cleanData($subject['category_name']); ?>
												</p>
												<h2 class="mb-0 text-white"><?= cleanData($subject['news_topic']); ?></h2>
											</div>
										</div>
									</a>
								</div>
							<?php } ?>
						<?php } else { ?>
							<div class="row justify-content-center mb-3 pb-3">
								<div class="col-md-12 heading-section text-center ftco-animate">
									<p class="subheading text-center text-warning">- ไม่มีข้อมูล -</p>
									<img class="img-fluid w-25" src="public/img/box.png" alt="No Data!">
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php include_once("layout/footer.php"); ?>
	<?php include_once("layout/loader.php"); ?>


	



</body>

</html>