<?php
// include User class and necessary functions
require_once(dirname(__DIR__) .'/controller/function.php');
// handle form submission
if (count($_POST) > 0) {
    $user = new User();

    $existingUser = $user->getUserByEmail($_POST['email']);
    if ($existingUser) {
        $response = array('error' => 'อีเมลล์นี้มีในระบบแล้ว');
    } else {
        // proceed with the registration
        $signUp = $user->signUp($_POST);
        if ($signUp == "success") {
            $response = array('status' => 'success', 'message' => 'กรุณารอการยืนยันบัญชีจากผู้ดูแล');
        } else {
            $response = array('error' => $signUp);
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}