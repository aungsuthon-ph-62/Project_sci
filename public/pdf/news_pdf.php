<?php
require_once "../../private/config/config" . '.php';
require_once "../../private/app/controller/function" . '.php';
require_once "../../vendor/autoload" . '.php';

$id = addslashes($_GET['id']);
$news = new News();
$getNews = $news->get_news($id);
$row = $getNews[0];

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];


$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' =>  'THSarabunNew Bold.ttf',
        ]
    ],
]);


ob_start();
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="robots" content="index, follow">

    <title>คณะวิทยาศาสตร์ - Dashboard</title>

    <meta content="เว็บไซต์ข่าวสารคณะวิทยาศาสตร์ มหาวิทยาลัยอุบลราชธานี" name="description">
    <meta content="คณะวิทยาศาสตร์, คณะวิทย์, วิทยาศาสตร์, วิทย์, มหาวิทยาลัยอุบลราชธานี, ม.อุบล, คณะวิทย์ ม.อุบล" name="keywords">

    <!-- Favicons -->
    <link href="public/img/logo/Ubu_logo.png" rel="icon">
    <link href="public/img/logo/Ubu_logo.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


    <style>
        body {
            font-family: "sarabun";
        }
    </style>
</head>

<body>
    <h1>
        หัวข้อข่าว : <b class="fw-bold"><?= $row['news_topic'] ?></b>
    </h1>
    <h1>
        หมวดหมู่ : <b class="fw-bold"><?= $row['category_name'] ?></b>
    </h1>
    <h1>
        ผู้เขียน : <b class="fw-bold"><?= $row['user_fname'] ?> <?= $row['user_lname'] ?></b>
    </h1>
    <h1>เนื้อหาข่าว :</h1>
    <article class="py-3">

        <?= $row['news_article'] ?>
    </article>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
<?php

$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->Output('NewsPDF.pdf');
$endObj = ob_end_flush();

echo '<script>window.location.href = "NewsPDF.pdf";</script>'

?>