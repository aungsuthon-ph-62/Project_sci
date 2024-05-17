<?php
session_start();
require_once("../../config/config.php");

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $action = stripslashes($action);
    if ($action == 'addBanner') {
        addBanner();
        exit;
    } elseif ($action == 'editBanner') {
        editBanner();
        exit;
    }
}

if (isset($_POST['getBanner'])) {
    $id = addslashes($_POST['getBanner']);
    getBanner($id);
}

if (isset($_GET['deleteBanner'])) {
    global $conn;
    $unid = addslashes($_GET['deleteBanner']);

    $sql = "SELECT * FROM banner WHERE banner_id = '$unid' LIMIT 1";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();
    $banner = $row['banner_img'];
    $id = $row['banner_id'];

    $sql = "DELETE FROM banner WHERE banner_id = '$id'";
    $query = $conn->query($sql);

    if ($query) {
        unlink("../../../public/img/slide/$banner");
        $_SESSION['success'] = "ลบรายการสำเร็จ!";
        echo "<script> window.location.href='../../../index?page=banner-list';</script>";
        exit;
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด! กรุณาลองอีกครั้ง";
        echo "<script> window.history.back()</script>";
        exit;
    }
}

function addBanner()
{
    global $conn;
    $banner = $_FILES['bannerImg']['name'];
    $banner_tmp = $_FILES['bannerImg']['tmp_name'];
    $bannerTopic = addslashes($_POST['bannerTopic']);
    $bannerDesc = addslashes($_POST['bannerDesc']);
    $bannerLink = addslashes($_POST['bannerLink']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

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

            $move = move_uploaded_file($banner_tmp, '../../../public/img/slide/' . $newImgName);
            if (!$move) {
                $_SESSION['error'] = "ไม่สามารถเพิ่มไฟล์ได้!";
                echo "<script> window.history.back()</script>";
                exit;
            }
        }
    }


    $query = "INSERT INTO banner (banner_img, banner_topic, banner_description, banner_link, banner_created) VALUES ('$newImgName', '$bannerTopic', '$bannerDesc', '$bannerLink', '$date')";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ!";
    header("Location: ../../../index?page=banner-list");
    exit;
}

function editBanner()
{
    global $conn;
    $bannerID = addslashes($_POST['id']);
    $oldBanner = addslashes($_POST['oldBanner']);
    $banner = $_FILES['bannerImg']['name'];
    $banner_tmp = $_FILES['bannerImg']['tmp_name'];
    $bannerTopic = addslashes($_POST['bannerTopic']);
    $bannerDesc = addslashes($_POST['bannerDesc']);
    $bannerLink = addslashes($_POST['bannerLink']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    if ($banner_tmp) {
        if ($oldBanner != '') {
            // Delete the old picture
            unlink('../../../public/img/slide/' . $oldBanner);
        }
        // Image extension valid
        $validImgExt = ['jpg', 'jpeg', 'png', 'gif'];
        $imgExt = explode('.', $banner);

        $name = $imgExt[0];
        $imgExt = strtolower(end($imgExt));

        if (!in_array($imgExt, $validImgExt)) {
            echo json_encode(array('error' => 'นามสกุลของไฟล์ไม่ถูกต้อง'));
            exit;
        } else {
            $newImgName = $name . "-" . uniqid(); // Gen new img name
            $newImgName .= "." . $imgExt;

            move_uploaded_file($banner_tmp, '../../../public/img/slide/' . $newImgName);
        }
    } else {
        $newImgName = $oldBanner;
    }


    $query = "UPDATE banner SET banner_img='$newImgName', banner_topic='$bannerTopic', banner_description='$bannerDesc', banner_link='$bannerLink', banner_edit='$date' WHERE banner_id = '$bannerID'";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        echo json_encode(array('error' => 'เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!'));
        exit;
    }

    echo json_encode(array('success' => true));
    exit;
}

function getBanner($id)
{
    global $conn;
    // Get record from database
    $sql = "SELECT * FROM banner WHERE banner_id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    // Return data as JSON
    echo json_encode($data);
}
