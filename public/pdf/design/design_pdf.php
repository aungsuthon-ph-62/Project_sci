<?php if (isset($_POST['submitValid'])) { ?>
    <?php
    session_start();
    require_once "../../../private/config/config" . '.php';
    require_once "../../../vendor/autoload" . '.php';

    $title = $_POST['title'];

    $content = $_POST['designContent'];

    if (empty($content) || empty($title)) {
        $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบถ้วน!";
        echo "<script> window.history.back()</script>";
        exit;
    }

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

    $mpdf->showImageErrors = true;

    $imagePath = '../../img/banner/designBanner-removebg-preview.png';

    // Read the image file contents
    $imageData = file_get_contents($imagePath);

    // Convert the image data to base64 encoding
    $base64Image = base64_encode($imageData);

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
            h1 {
                font-family: 'Sarabun', sans-serif;
                font-size: 22px;
                padding: 20px 25px;
            }
        </style>
    </head>

    <body>
        <div class="text-center">
            <img class="img-fluid" src="data:image/png;base64, <?= $base64Image; ?>" width="auto" style="object-fit: cover;">
            <h1><?= $title ?></h1>
        </div>
        <article>
            <?= $content ?>
        </article>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>

    </html>
    <?php

    $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ23456789'), 0, 10);
    $file_name = $uniqid = "design_" . $rand . ".pdf";

    $html = ob_get_contents();
    $mpdf->WriteHTML($html);
    $mpdf->Output($file_name);
    $endObj = ob_end_flush();


    if ($endObj) {
        global $conn;
        $newsletter = $file_name;
        $newsletterTopic = $title;
        $author = addslashes($_SESSION['id']);
        date_default_timezone_set('Asia/Bangkok');
        $date = date("Y-m-d H:i:s");

        $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ23456789'), 0, 10);
        $uniqid = "newsletter_" . $rand;
        $qP = "SELECT * FROM newsletter WHERE newsletter_unique = '$uniqid'";
        $rP =  mysqli_query($conn, $qP);
        $row =  mysqli_fetch_assoc($rP);

        if ($row) {
            $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ23456789'), 0, 10);
            $uniqid = "newsletter_" . $rand;
        }

        $query = "INSERT INTO newsletter (newsletter_unique, newsletter_file, newsletter_topic, newsletter_author, newsletter_created) VALUES ('$uniqid', '$newsletter', '$newsletterTopic', '$author', '$date')";
        $result =  mysqli_query($conn, $query);
        if (!$result) {
            $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
            echo "<script>window.history.back()</script>";
            exit;
        }

        foreach ($_POST['selectedValues'] as $news) {
            $escaped_news = mysqli_real_escape_string($conn, $news);

            $Updatequery = "UPDATE news SET news_newsletterUsed='$uniqid' WHERE news_unique = '$escaped_news'";
            $Updateresult = mysqli_query($conn, $Updatequery);

            if (!$Updateresult) {
                $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
                echo "<script>window.history.back()</script>";
                exit;
            }
        }

        $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ!";
        echo "<script> window.location.href='../../../index?page=newsletter-list';</script>";
        exit;
    }
    ?>
<?php } ?>