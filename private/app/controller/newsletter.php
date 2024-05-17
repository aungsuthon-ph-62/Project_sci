<?php
session_start();
require_once("../../config/config.php");

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $action = stripslashes($action);
    if ($action == 'editNewsletter') {
        editNewsletter();
        exit;
    }
}

if (isset($_POST['getNewsletter'])) {
    $id = addslashes($_POST['getNewsletter']);
    getNewsletter($id);
}

if (isset($_GET['deleteNewsletter'])) {
    global $conn;
    $unid = addslashes($_GET['deleteNewsletter']);
    $file = addslashes($_GET['file']);

    if($file)
    {
        unlink("../../../public/pdf/design/$file"); 
    }

    $sql = "DELETE FROM newsletter WHERE newsletter_unique = '$unid'";
    $query = $conn->query($sql);

    if ($query) {
        $_SESSION['success'] = "ลบรายการสำเร็จ!";
        echo "<script> window.location.href='../../../index?page=newsletter-list';</script>";
        exit;
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด! กรุณาลองอีกครั้ง";
        echo "<script> window.history.back()</script>";
        exit;
    }
}

function editNewsletter()
{
    global $conn;
    $newsletterID = addslashes($_POST['id']);
    $oldNewsletter = addslashes($_POST['oldNewsletter']);
    $newsletter = $_FILES['newsletterFile']['name'];
    $newsletter_tmp = $_FILES['newsletterFile']['tmp_name'];
    $newsletterTopic = addslashes($_POST['newsletterTopic']);
    $author = addslashes($_SESSION['id']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    if ($newsletterTopic == '') {
        echo json_encode(array('error' => 'กรุณากรอกหัวข้อจดหมายข่าว!'));
        exit;
    }

    if ($newsletter_tmp) {
        if ($oldNewsletter != '') {
            // Delete the old picture
            unlink('../../../public/pdf/upload/' . $oldNewsletter);
        }
        // Image extension valid
        $validImgExt = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];
        $imgExt = explode('.', $newsletter);

        $name = $imgExt[0];
        $imgExt = strtolower(end($imgExt));

        if (!in_array($imgExt, $validImgExt)) {
            echo json_encode(array('error' => 'นามสกุลของไฟล์ไม่ถูกต้อง'));
            exit;
        } else {
            $newImgName = $name . "-" . uniqid(); // Gen new img name
            $newImgName .= "." . $imgExt;

            move_uploaded_file($newsletter_tmp, '../../../public/pdf/upload/' . $newImgName);
        }
    } else {
        $newImgName = $oldNewsletter;
    }


    $query = "UPDATE newsletter SET newsletter_file='$newImgName', newsletter_topic='$newsletterTopic', newsletter_author='$author', newsletter_edit='$date' WHERE newsletter_unique = '$newsletterID'";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        echo json_encode(array('error' => 'เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!'));
        exit;
    }

    echo json_encode(array('success' => true));
    exit;
}

function getNewsletter($id)
{
    global $conn;
    // Get record from database
    $sql = "SELECT * FROM newsletter WHERE newsletter_unique = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    // Return data as JSON
    echo json_encode($data);
}
