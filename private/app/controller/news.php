<?php
session_start();
require_once("../../config/config.php");

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $action = stripslashes($action);
    if ($action == 'addNews') {
        addNews();
        exit;
    } elseif ($action == 'addDraft') {
        addDraft();
        exit;
    } elseif ($action == 'editDraft') {
        editDraft();
        exit;
    } elseif ($action == 'editNews') {
        editNews();
        exit;
    } elseif ($action == 'updateNews') {
        updateNews();
        exit;
    } elseif ($action == 'publicNews') {
        publicNews();
        exit;
    }
}

if (isset($_GET['deleteNews'])) {
    global $conn;
    $unid = $_GET['deleteNews'];

    $checkSql = "SELECT * FROM news WHERE news_unique = '$unid' LIMIT 1";
    $checkQuery = $conn->query($checkSql);
    $row = $checkQuery->fetch_assoc();
    $banner = $row['news_banner'];
    $id = $row['news_unique'];

    $sql = "DELETE FROM news WHERE news_unique = '$id'";
    $query = $conn->query($sql);

    if ($query) {

        $checkDraft = "SELECT * FROM draftnews WHERE draft_unique = '$unid' LIMIT 1";
        $queryDraft = $conn->query($checkDraft);
        $Draftrow = $queryDraft->fetch_assoc();

        if ($Draftrow) {
            $updateSql = "UPDATE draftnews SET draft_status='ร่าง' WHERE draft_unique = '$unid'";
            $updateQuery = $conn->query($updateSql);
        }

        unlink("../../../public/img/banner/$banner");
        $_SESSION['success'] = "ลบรายการสำเร็จ!";
        echo "<script> window.location.href='../../../index?page=news-list';</script>";
        exit;
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด! กรุณาลองอีกครั้ง";
        echo "<script> window.history.back()</script>";
        exit;
    }
}

function addNews()
{

    global $conn;
    $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ23456789'), 0, 10);
    $uniqid = "news_" . $rand;
    $qP = "SELECT * FROM news WHERE news_unique = '$uniqid'";
    $rP =  mysqli_query($conn, $qP);
    $row =  mysqli_fetch_assoc($rP);

    if ($row) {
        $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ23456789'), 0, 10);
        $uniqid = "news_" . $rand;
    }

    $banner = $_FILES['newsBanner']['name'];
    $banner_tmp = $_FILES['newsBanner']['tmp_name'];
    $topic = addslashes($_POST['newsTopic']);
    $category = addslashes($_POST['newsCategory']);
    $article = $_POST['newsArticle'];
    $status = $_POST['newsStatus'];
    $author = addslashes($_SESSION['id']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    if (empty($topic) | empty($category) | empty($article)) {
        $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบถ้วน!";
        mysqli_close($conn);
        echo "<script> window.history.back()</script>";
        exit;
    }

    // Validate input data
    if (empty($article)) {
        $_SESSION['error'] = "กรุณากรอกเนื้อหาข้อความ!";
        mysqli_close($conn);
        echo "<script> window.history.back()</script>";
        exit;
    }

    if ($banner_tmp) {
        // Image extension valid
        $validImgExt = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        $imgExt = explode('.', $banner);

        $name = $imgExt[0];
        $imgExt = strtolower(end($imgExt));

        if (!in_array($imgExt, $validImgExt)) {
            $_SESSION['error'] = "นามสกุลของไฟล์ไม่ถูกต้อง!";
            echo "<script> window.history.back()</script>";
            exit;
        } else {
            $newImgName = $name . "_" . uniqid(); // Gen new img name
            $newImgName .= "." . $imgExt;

            $move = move_uploaded_file($banner_tmp, '../../../public/img/banner/' . $newImgName);
            if (!$move) {
                $_SESSION['error'] = "ไม่สามารถเพิ่มไฟล์ได้!";
                mysqli_close($conn);
                echo "<script> window.history.back()</script>";
                exit;
            }
        }
    }

    // Insert new user into database
    $query = "INSERT INTO news (news_unique, news_topic, news_banner, news_article, news_category, news_status, news_author, news_created) VALUES ('$uniqid', '$topic', '$newImgName', '$article', '$category', 'เผยแพร่', '$author', '$date')";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
        mysqli_close($conn);
        echo "<script> window.history.back()</script>";
        exit;
    }

    $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ!";
    mysqli_close($conn);
    header("Location: ../../../index?page=news-list");
    exit;
}


function editNews()
{
    global $conn;
    $newsID =  addslashes($_POST['newsId']);
    $banner = $_FILES['newsBanner']['name'];
    $banner_tmp = $_FILES['newsBanner']['tmp_name'];
    $oldBanner = $_POST['oldBanner'];
    $topic = addslashes($_POST['newsTopic']);
    $category = addslashes($_POST['newsCategory']);
    $article = $_POST['newsArticle'];
    $author = addslashes($_POST['author']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    if (empty($topic) | empty($category) | empty($article)) {
        $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบถ้วน!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    // Validate input data
    if (empty($article)) {
        $_SESSION['error'] = "กรุณากรอกเนื้อหาข้อความ!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    if ($banner_tmp) {
        if ($oldBanner != '') {
            // Delete the old picture
            unlink('../../../public/img/banner/' . $oldBanner);
        }
        // Image extension valid
        $validImgExt = ['jpg', 'jpeg', 'png', 'gif'];
        $imgExt = explode('.', $banner);

        $name = $imgExt[0];
        $imgExt = strtolower(end($imgExt));

        if (!in_array($imgExt, $validImgExt)) {
            $_SESSION['error'] = "นามสกุลของไฟล์ไม่ถูกต้อง!";
            echo "<script> window.history.back()</script>";
            exit;
        } else {
            $newImgName = $name . "-" . uniqid(); // Gen new img name
            $newImgName .= "." . $imgExt;

            move_uploaded_file($banner_tmp, '../../../public/img/banner/' . $newImgName);
        }
    } else {
        $newImgName = $oldBanner;
    }

    // Insert new user into database
    $query = "UPDATE news SET news_topic='$topic', news_banner='$newImgName', news_article='$article', news_category='$category', news_author='$author', news_edit='$date' WHERE news_unique = '$newsID'";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ!";
    header("Location: ../../../index?page=draft-list");
    exit;
}

function updateNews()
{
    global $conn;
    $newsID =  addslashes($_POST['newsId']);
    $banner = $_FILES['newsBanner']['name'];
    $banner_tmp = $_FILES['newsBanner']['tmp_name'];
    $oldBanner = $_POST['oldBanner'];
    $topic = addslashes($_POST['newsTopic']);
    $category = addslashes($_POST['newsCategory']);
    $article = $_POST['newsArticle'];
    $author = addslashes($_POST['author']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    if (empty($topic) | empty($category) | empty($article)) {
        $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบถ้วน!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    // Validate input data
    if (empty($article)) {
        $_SESSION['error'] = "กรุณากรอกเนื้อหาข้อความ!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    if ($banner_tmp) {
        if ($oldBanner != '') {
            // Delete the old picture
            unlink('../../../public/img/banner/' . $oldBanner);
        }
        // Image extension valid
        $validImgExt = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
        $imgExt = explode('.', $banner);

        $name = $imgExt[0];
        $imgExt = strtolower(end($imgExt));

        if (!in_array($imgExt, $validImgExt)) {
            $_SESSION['error'] = "นามสกุลของไฟล์ไม่ถูกต้อง!";
            echo "<script> window.history.back()</script>";
            exit;
        } else {
            $newImgName = $name . "-" . uniqid(); // Gen new img name
            $newImgName .= "." . $imgExt;

            move_uploaded_file($banner_tmp, '../../../public/img/banner/' . $newImgName);
        }
    } else {
        $newImgName = $oldBanner;
    }

    if (empty($author)) {
        $author = $_SESSION['id'];
    }

    // Insert new user into database
    $query = "UPDATE news SET news_topic='$topic', news_banner='$newImgName', news_article='$article', news_category='$category', news_author='$author', news_status='เผยแพร่', news_edit='$date' WHERE news_unique = '$newsID'";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    $_SESSION['success'] = "แก้ไขข้อมูลข่าวสำเร็จ!";
    header("Location: ../../../index?page=news-list");
    exit;
}

function publicNews()
{

    global $conn;
    $newsID =  addslashes($_POST['newsId']);
    $banner = $_FILES['newsBanner']['name'];
    $banner_tmp = $_FILES['newsBanner']['tmp_name'];
    $oldBanner = $_POST['oldBanner'];
    $topic = addslashes($_POST['newsTopic']);
    $category = addslashes($_POST['newsCategory']);
    $article = $_POST['newsArticle'];
    $author = addslashes($_POST['author']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    if (empty($topic) | empty($category) | empty($article)) {
        $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบถ้วน!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    // Validate input data
    if (empty($article)) {
        $_SESSION['error'] = "กรุณากรอกเนื้อหาข้อความ!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    if ($banner_tmp) {
        // Image extension valid
        $validImgExt = ['jpg', 'jpeg', 'png', 'gif'];
        $imgExt = explode('.', $banner);

        $name = $imgExt[0];
        $imgExt = strtolower(end($imgExt));

        if (!in_array($imgExt, $validImgExt)) {
            $_SESSION['error'] = "นามสกุลของไฟล์ไม่ถูกต้อง!";
            echo "<script> window.history.back()</script>";
            exit;
        } else {
            $newImgName = $name . "-" . uniqid(); // Gen new img name
            $newImgName .= "." . $imgExt;

            move_uploaded_file($banner_tmp, '../../../public/img/banner/' . $newImgName);
        }
    } else {
        $file = '../../../public/img/draft_banner/' . $oldBanner;
        $newfile = '../../../public/img/banner/' . $oldBanner;
        if (!copy($file, $newfile)) {
            $_SESSION['error'] = "สร้างไฟล์ในโฟลเดอร์ใหม่ไม่สำเร็จ!";
            echo "<script> window.history.back()</script>";
            exit;
        }
        $newImgName = $oldBanner;
    }

    // Insert new user into database
    $query = "INSERT INTO news (news_unique, news_topic, news_banner, news_article, news_category, news_status, news_author, news_created) VALUES ('$newsID', '$topic', '$newImgName', '$article', '$category', 'เผยแพร่', '$author', '$date')";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
        mysqli_close($conn);
        echo "<script> window.history.back()</script>";
        exit;
    }

    // Insert new user into database
    $Updatequery = "UPDATE draftnews SET draft_status='เผยแพร่' WHERE draft_unique = '$newsID'";
    $Updateresult =  mysqli_query($conn, $Updatequery);
    if (!$Updateresult) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    $_SESSION['success'] = "เผยแพร่ข่าวสำเร็จ!";
    mysqli_close($conn);
    header("Location: ../../../index?page=news-list");
    exit;
}

if (isset($_GET['deleteDraft'])) {
    global $conn;
    $unid = $_GET['deleteDraft'];

    $sql = "SELECT * FROM draftnews WHERE draft_unique = '$unid' LIMIT 1";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();
    $banner = $row['draft_banner'];
    $id = $row['draft_unique'];

    $sql = "DELETE FROM draftnews WHERE draft_unique = '$id'";
    $query = $conn->query($sql);

    if ($query) {
        unlink("../../../public/img/draft_banner/$banner");
        $_SESSION['success'] = "ลบรายการสำเร็จ!";
        echo "<script> window.location.href='../../../index?page=draft-list';</script>";
        exit;
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด! กรุณาลองอีกครั้ง";
        echo "<script> window.history.back()</script>";
        exit;
    }
}

function addDraft()
{
    $role = addslashes($_SESSION['role']);
    global $conn;
    $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ23456789'), 0, 10);
    $uniqid = "news_" . $rand;
    $qP = "SELECT * FROM news WHERE news_unique = '$uniqid'";
    $rP =  mysqli_query($conn, $qP);
    $row =  mysqli_fetch_assoc($rP);

    if ($row) {
        $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ23456789'), 0, 10);
        $uniqid = "news_" . $rand;
    }

    $banner = $_FILES['newsBanner']['name'];
    $banner_tmp = $_FILES['newsBanner']['tmp_name'];
    $topic = addslashes($_POST['newsTopic']);
    $category = addslashes($_POST['newsCategory']);
    $article = $_POST['newsArticle'];
    $author = addslashes($_SESSION['id']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    if (empty($topic) | empty($category) | empty($article)) {
        $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบถ้วน!";
        mysqli_close($conn);
        echo "<script> window.history.back()</script>";
        exit;
    }

    // Validate input data
    if (empty($article)) {
        $_SESSION['error'] = "กรุณากรอกเนื้อหาข้อความ!";
        mysqli_close($conn);
        echo "<script> window.history.back()</script>";
        exit;
    }

    if ($banner_tmp) {
        // Image extension valid
        $validImgExt = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        $imgExt = explode('.', $banner);

        $name = $imgExt[0];
        $imgExt = strtolower(end($imgExt));

        if (!in_array($imgExt, $validImgExt)) {
            $_SESSION['error'] = "นามสกุลของไฟล์ไม่ถูกต้อง!";
            echo "<script> window.history.back()</script>";
            exit;
        } else {
            $newImgName = $name . "_" . uniqid(); // Gen new img name
            $newImgName .= "." . $imgExt;

            $move = move_uploaded_file($banner_tmp, '../../../public/img/draft_banner/' . $newImgName);
            if (!$move) {
                $_SESSION['error'] = "ไม่สามารถเพิ่มไฟล์ได้!";
                mysqli_close($conn);
                echo "<script> window.history.back()</script>";
                exit;
            }
        }
    }

    // Insert new user into database
    $query = "INSERT INTO draftnews (draft_unique, draft_topic, draft_banner, draft_article, draft_category, draft_author, draft_created) VALUES ('$uniqid', '$topic', '$newImgName', '$article', '$category', '$author', '$date')";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
        mysqli_close($conn);
        echo "<script> window.history.back()</script>";
        exit;
    }

    if ($role == 'นักสื่อสารองค์กร') {
        $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ!";
        mysqli_close($conn);
        header("Location: ../../../index?page=draft-list");
        exit;
    } else {
        $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ!";
        mysqli_close($conn);
        header("Location: ../../../index?page=news-list");
        exit;
    }
}

function editDraft()
{
    global $conn;
    $newsID =  addslashes($_POST['newsId']);
    $banner = $_FILES['newsBanner']['name'];
    $banner_tmp = $_FILES['newsBanner']['tmp_name'];
    $oldBanner = $_POST['oldBanner'];
    $topic = addslashes($_POST['newsTopic']);
    $category = addslashes($_POST['newsCategory']);
    $article = $_POST['newsArticle'];
    $author = addslashes($_SESSION['id']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    if (empty($topic) | empty($category) | empty($article)) {
        $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบถ้วน!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    // Validate input data
    if (empty($article)) {
        $_SESSION['error'] = "กรุณากรอกเนื้อหาข้อความ!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    if ($banner_tmp) {
        if ($oldBanner != '') {
            // Delete the old picture
            unlink('../../../public/img/draft_banner/' . $oldBanner);
        }
        // Image extension valid
        $validImgExt = ['jpg', 'jpeg', 'png', 'gif'];
        $imgExt = explode('.', $banner);

        $name = $imgExt[0];
        $imgExt = strtolower(end($imgExt));

        if (!in_array($imgExt, $validImgExt)) {
            $_SESSION['error'] = "นามสกุลของไฟล์ไม่ถูกต้อง!";
            echo "<script> window.history.back()</script>";
            exit;
        } else {
            $newImgName = $name . "-" . uniqid(); // Gen new img name
            $newImgName .= "." . $imgExt;

            move_uploaded_file($banner_tmp, '../../../public/img/draft_banner/' . $newImgName);
        }
    } else {
        $newImgName = $oldBanner;
    }

    // Insert new user into database
    $query = "UPDATE draftnews SET draft_topic='$topic', draft_banner='$newImgName', draft_article='$article', draft_category='$category', draft_author='$author', draft_edit='$date' WHERE draft_unique = '$newsID'";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ!";
    header("Location: ../../../index?page=draft-list");
    exit;
}
