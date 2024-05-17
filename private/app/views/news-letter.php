<?php
if (isset($_SESSION['id'])) {
	$id = addslashes($_SESSION['id']);

	$getUser = $user->getUserByUniqueID($id);
}
$news = new News();
$getNews = $news->home_news('เผยแพร่', 'ข่าวทั่วไป');

$newsletter = new newsletter();
$getNewsletter = $newsletter->get_all_newsletter();
?>

<!DOCTYPE html>
<html lang="th">
<?php include_once("layout/head.php"); ?>

<body class="goto-here">

	<?php include_once("layout/navbar.php"); ?>

	<?php include_once("layout/hero-section.php"); ?>

	<section class="ftco-section ftco-cart">
		<div class="container">
			<div class="row">
				<div class="col-md-12 ftco-animate">
					<div class="cart-list">
						<table class="table">
							<thead class="thead-primary">
								<tr class="text-center">
									<th>ลำดับ</th>
									<th>หัวข้อ</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($getNewsletter) {
									$i = 0;
								?>
									<?php foreach ($getNewsletter as $letter) { ?>
										<tr class="text-center">
											<td class="price">
												<?php echo $i = $i + 1; ?>
											</td>
											<td class="product-name">
												<a href="public/pdf/design/<?= cleanData($letter['newsletter_file']); ?>" target="_blank" ><?= cleanData($letter['newsletter_topic']); ?></a>
											</td>
											<td class="product-remove"><a href="public/pdf/design/<?= cleanData($letter['newsletter_file']); ?>" target="_blank"><i class="fa-solid fa-square-arrow-up-right"></i></a></td>
										</tr><!-- END TR-->
									<?php } ?>
								<?php } else { ?>
									<div class="row justify-content-center mb-3 pb-3">
										<div class="col-md-12 heading-section text-center ftco-animate">
											<p class="subheading text-center text-warning">- ไม่มีข้อมูล -</p>
											<img class="img-fluid w-25" src="public/img/undraw_taken_re_yn20.svg" alt="No Data!">
										</div>
									</div>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="ftco-section bg-light">
		<div class="container">
			<div class="row justify-content-center mb-3 pb-3">
				<div class="col-md-12 heading-section text-center ftco-animate">
					<span class="subheading">- ข่าวล่าสุด -</span>
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
		</div>
	</section>

	<?php include_once("layout/footer.php"); ?>
	<?php include_once("layout/loader.php"); ?>

</body>

</html>