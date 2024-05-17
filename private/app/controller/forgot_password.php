<?php

session_start();
require_once("../../config/config.php");

if (isset($_POST['submitChange'])) {
    forgotPassword();
    exit;
}

function forgotPassword()
{
    global $conn;
    $email =  addslashes($_POST['changeEmail']);
    $newpassword = addslashes($_POST['changePassword']);
    $renewpassword = addslashes($_POST['changeConfirm']);

    if (empty($email) | empty($newpassword) | empty($renewpassword)) {
        echo json_encode(array('error' => 'กรุณากรอกข้อมูลให้ครบถ้วน!'));
        exit;
    }

    $qP = "SELECT * FROM users WHERE user_email = '$email'";
    $rP =  mysqli_query($conn, $qP);
    $row =  mysqli_fetch_assoc($rP);

    if (!$row) {
        echo json_encode(array('error' => 'อีเมลล์นี้ไม่มีในระบบ!'));
        exit;
    } else {
        if ($row['user_approve'] == null) {
            echo json_encode(array('error' => 'บัญชีของท่านยังไม่ได้รับการยืนยันจากผู้ดูแล ยังไม่สามารถเปลี่ยนรหัสผ่านได้!'));
            exit;
        }
    }

    if (strlen($newpassword) < 8) {
        echo json_encode(array('error' => 'รหัสผ่านต้องความยาวมีมากกว่า 8 ตัวอักษร!'));
        mysqli_close($conn);
        exit;
    }

    // Check if the password contains at least one number
    if (!preg_match('/\d/', $newpassword)) {
        echo json_encode(array('error' => 'รหัสผ่านต้องมีตัวเลขอย่างน้อย 1 ตัว!'));
        mysqli_close($conn);
        exit;
    }

    // Check if the password contains at least one uppercase character
    if (!preg_match('/[A-Z]/', $newpassword)) {
        echo json_encode(array('error' => 'รหัสผ่านต้องมีตัวพิมพ์ใหญ่อย่างน้อย 1 ตัว!'));
        mysqli_close($conn);
        exit;
    }

    if ($renewpassword != $newpassword) {
        echo json_encode(array('error' => 'รหัสผ่านใหม่ไม่ตรงกัน!'));
        mysqli_close($conn);
        exit;
    }

    $passwordHash = password_hash($newpassword, PASSWORD_DEFAULT);

    // Insert new user into database
    $query = "UPDATE users SET user_password='$passwordHash' WHERE user_email = '$email'";
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
