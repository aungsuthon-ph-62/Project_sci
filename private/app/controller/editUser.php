<?php

session_start();
require_once("../../config/config.php");

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $action = stripslashes($action);
    if ($action == 'editUser') {
        editUser();
        exit;
    } elseif ($action == 'changePassword') {
        changePassword();
        exit;
    }
}

function editUser()
{
    global $conn;
    $usersID =  addslashes($_POST['id']);
    $oldImg =  addslashes($_POST['oldImg']);
    $userImg = $_FILES['userImg']['name'];
    $userImg_tmp = $_FILES['userImg']['tmp_name'];
    $firstName = addslashes($_POST['userFname']);
    $lastName = addslashes($_POST['userLname']);
    $email = addslashes($_POST['userEmail']);
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    if (empty($firstName) | empty($lastName) | empty($email)) {
        echo json_encode(array('error' => 'กรุณากรอกข้อมูลให้ครบถ้วน'));
        exit;
    }

    if ($userImg) {
        if ($oldImg != '') {
            // Delete the old picture
            unlink('../../../public/img/user_img/' . $oldImg);
        }
        // Image extension valid
        $validImgExt = ['jpg', 'jpeg', 'png', 'gif'];
        $imgExt = explode('.', $userImg);

        $name = $imgExt[0];
        $imgExt = strtolower(end($imgExt));

        if (!in_array($imgExt, $validImgExt)) {
            echo json_encode(array('error' => 'นามสกุลของไฟล์ไม่ถูกต้อง'));
            exit;
        } else {
            $newImgName = $name . "-" . uniqid(); // Gen new img name
            $newImgName .= "." . $imgExt;

            move_uploaded_file($userImg_tmp, '../../../public/img/user_img/' . $newImgName);
        }
    } else {
        $newImgName = $oldImg;
    }

    // Insert new user into database
    $query = "UPDATE users SET user_fname='$firstName', user_lname='$lastName', user_email='$email', user_image='$newImgName', user_edit='$date' WHERE user_unique = '$usersID'";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        echo json_encode(array('error' => 'เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!'));
        exit;
    }

    echo json_encode(array('success' => true));
    exit;
}

function changePassword()
{
    global $conn;
    $usersID =  addslashes($_POST['id']);
    $password =  addslashes($_POST['password']);
    $newpassword = addslashes($_POST['newpassword']);
    $renewpassword = addslashes($_POST['renewpassword']);

    if (empty($password) | empty($newpassword) | empty($renewpassword)) {
        echo json_encode(array('error' => 'กรุณากรอกข้อมูลให้ครบถ้วน!'));
        exit;
    }

    $qP = "SELECT user_password FROM users WHERE user_unique = '$usersID'";
    $rP =  mysqli_query($conn, $qP);
    $row =  mysqli_fetch_assoc($rP);

    if ($row) {
        $storedPassword = $row['user_password'];
        $verify = password_verify($password, $storedPassword);
        if (!$verify) {
            echo json_encode(array('error' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง!'));
            mysqli_close($conn);
            exit;
        }
    }

    $specialChars = '!@#$%^&*()-_=+';
    $hasNumber = false;
    $hasSpecialChar = false;

    if (strlen($newpassword) < 8) {
        echo json_encode(array('error' => 'รหัสผ่านต้องความยาวมีมากกว่า 8 ตัวอักษร!'));
        mysqli_close($conn);
        exit;
    }

    for ($i = 0; $i < strlen($newpassword); $i++) {
        $char = $newpassword[$i];

        if (is_numeric($char)) {
            $hasNumber = true;
        } elseif (strpos($specialChars, $char) !== false) {
            $hasSpecialChar = true;
        }

        if ($hasNumber != true) {
            echo json_encode(array('error' => 'รหัสผ่านต้องมีตัวเลขมากกว่า 1 ตัว!'));
            mysqli_close($conn);
            exit;
        }

        if ($hasSpecialChar != true) {
            echo json_encode(array('error' => 'รหัสผ่านต้องมีตัวอักษรพิเศษมากกว่า 1 ตัว!'));
            mysqli_close($conn);
            exit;
        }
    }

    if ($password == $newpassword) {
        echo json_encode(array('error' => 'รหัสผ่านต้องไม่ซ้ำกัน!'));
        exit;
    }

    if ($renewpassword != $newpassword) {
        echo json_encode(array('error' => 'รหัสผ่านใหม่ไม่ตรงกัน!'));
        mysqli_close($conn);
        exit;
    }

    $passwordHash = password_hash($newpassword, PASSWORD_DEFAULT);

    // Insert new user into database
    $query = "UPDATE users SET user_password='$passwordHash' WHERE user_unique = '$usersID'";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        echo json_encode(array('error' => 'เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!'));
        mysqli_close($conn);
        exit;
    }

    echo json_encode(array('success' => true));
    mysqli_close($conn);
    exit;
}

