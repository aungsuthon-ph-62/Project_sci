<?php
session_start();
require_once("../../config/config.php");

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $action = stripslashes($action);
    if ($action == 'addUsers') {
        addUsers();
        exit;
    } elseif ($action == 'editUsers') {
        editUsers();
        exit;
    } elseif ($action == 'editInfo') {
        editInfo();
        exit;
    }
}

if (isset($_POST['getUser'])) {
    $id = addslashes($_POST['getUser']);
    getUser($id);
}

if (isset($_GET['deleteUser'])) {
    global $conn;
    $unid = addslashes($_GET['deleteUser']);

    $sql = "DELETE FROM users WHERE user_unique = '$unid'";
    $query = $conn->query($sql);

    if ($query) {
        $_SESSION['success'] = "ลบรายการสำเร็จ!";
        echo "<script> window.location.href='../../../index?page=member-list';</script>";
        exit;
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด! กรุณาลองอีกครั้ง";
        echo "<script> window.history.back()</script>";
        exit;
    }
}

function addUsers()
{
    global $conn;
    $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
    $uniqid = "user_" . $rand;
    $qP = "SELECT * FROM users WHERE user_unique = '$uniqid'";
    $rP =  mysqli_query($conn, $qP);
    $uniqidExist =  mysqli_fetch_assoc($rP);

    if ($uniqidExist) {
        $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
        $uniqid = "user_" . $rand;
    }

    $firstName = addslashes($_POST['usersFname']);
    $lastName = addslashes($_POST['usersLname']);
    $email = addslashes($_POST['usersEmail']);
    $password = addslashes($_POST['usersPassword']);
    $role = addslashes($_POST['usersRole']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    if (empty($firstName) | empty($lastName) | empty($email) | empty($password) | empty($role)) {
        $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบถ้วน!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    $qE = "SELECT * FROM users WHERE user_email = '$email'";
    $rE =  mysqli_query($conn, $qE);
    $rows =  mysqli_fetch_assoc($rE);

    if ($rows) {
        $_SESSION['error'] = "อีเมลล์นี้ถูกงานใช้แล้ว, กรุณาลองใหม่อีกครั้ง!";
        echo "<script> window.history.back()</script>";
        exit;
    }


    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (user_unique, user_fname, user_lname, user_email, user_password, user_role, user_approve, user_created) VALUES ('$uniqid', '$firstName', '$lastName', '$email', '$password_hash', '$role', 'ยืนยันแล้ว', '$date')";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ!";
    header("Location: ../../../index?page=member-list");
    exit;
}

function editUsers()
{
    global $conn;
    $usersID =  addslashes($_POST['id']);
    $oldPassword =  addslashes($_POST['oldPassword']);
    $firstName = addslashes($_POST['first_name']);
    $lastName = addslashes($_POST['last_name']);
    $email = addslashes($_POST['email']);
    $passwordInput = addslashes($_POST['password']);
    $role = addslashes($_POST['role']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");
    $approve = null;

    if (empty($firstName) | empty($lastName) | empty($email) | empty($role)) {
        echo json_encode(array('error' => 'กรุณากรอกข้อมูลให้ครบถ้วน'));
        exit;
    }

    if (empty($passwordInput)) {
        $password = $oldPassword;
    } else {
        $password = password_hash($passwordInput, PASSWORD_DEFAULT);
    }

    if (isset($_POST['approve'])) {
        $approve = addslashes($_POST['approve']);
        // Insert new user into database
        $query = "UPDATE users SET user_fname='$firstName', user_lname='$lastName', user_email='$email', user_password='$password', user_role='$role', user_approve='$approve', user_edit='$date' WHERE user_unique = '$usersID'";
        $result =  mysqli_query($conn, $query);
        if (!$result) {
            echo json_encode(array('error' => 'เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!'));
            exit;
        }
    } else {
        // Insert new user into database
        $query = "UPDATE users SET user_fname='$firstName', user_lname='$lastName', user_email='$email', user_password='$password', user_role='$role', user_approve=NULL, user_edit='$date' WHERE user_unique = '$usersID'";
        $result =  mysqli_query($conn, $query);
        if (!$result) {
            echo json_encode(array('error' => 'เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!'));
            exit;
        }
    }

    echo json_encode(array('success' => true));
    exit;
}

function getUser($id)
{
    global $conn;
    // Get record from database
    $sql = "SELECT * FROM users WHERE user_unique = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    // Return data as JSON
    echo json_encode($data);
}

function editInfo()
{
    global $conn;
    $usersID =  addslashes($_SESSION['id']);
    $oldImage =  addslashes($_POST['oldImage']);
    $oldPassword =  addslashes($_POST['oldPassword']);
    $image = $_FILES['inputImage']['name'];
    $image_tmp = $_FILES['inputImage']['tmp_name'];
    $firstName = addslashes($_POST['inputFname']);
    $lastName = addslashes($_POST['inputLname']);
    $email = addslashes($_POST['inputEmail']);
    $passwordInput = addslashes($_POST['inputPassword']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    if (empty($firstName) | empty($lastName) | empty($email)) {
        echo json_encode(array('error' => 'กรุณากรอกข้อมูลให้ครบถ้วน'));
        exit;
    }

    if ($image_tmp) {
        if ($oldImage != '') {
            // Delete the old picture
            unlink('../../../public/img/user_img/' . $oldImage);
        }
        // Image extension valid
        $validImgExt = ['jpg', 'jpeg', 'png', 'gif'];
        $imgExt = explode('.', $image);

        $name = $imgExt[0];
        $imgExt = strtolower(end($imgExt));

        if (!in_array($imgExt, $validImgExt)) {
            echo json_encode(array('error' => 'นามสกุลของไฟล์ไม่ถูกต้อง'));
            exit;
        } else {
            $newImgName = $name . "-" . uniqid(); // Gen new img name
            $newImgName .= "." . $imgExt;

            move_uploaded_file($image_tmp, '../../../public/img/user_img/' . $newImgName);
        }
    } else {
        $newImgName = $oldImage;
    }

    if (empty($passwordInput)) {
        $password = $oldPassword;
    } else {
        $password = password_hash($passwordInput, PASSWORD_DEFAULT);
    }

    // Insert new user into database
    $query = "UPDATE users SET user_image='$newImgName', user_fname='$firstName', user_lname='$lastName', user_email='$email', user_password='$password', user_edit='$date' WHERE user_unique = '$usersID'";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        echo json_encode(array('error' => 'เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!'));
        exit;
    }

    echo json_encode(array('success' => true));
    exit;
}
