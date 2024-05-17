<?php
// include User class and necessary functions
require_once(dirname(__DIR__) . '/controller/function.php');
// handle form submission
if (count($_POST) > 0) {
    $user = new User();

    // proceed with the registration
    $signIn = $user->signIn($_POST);
    if ($signIn == "success") {
        $response = array('status' => 'success', 'message' => 'Sign in successful!');
    } else {
        $response = array('error' => $signIn);
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
