<?php
include_once("../private/app/controller/function.php");

$user = new User();

if ($role = $user->access('แอดมิน') || $role = $user->access('นักสื่อสารองค์กร') || $role = $user->access('ประชาสัมพันธ์') || $role = $user->access('บรรณาธิการ')) {
    $index = 'dashboard';
    $folder = '../private/app/views/dashboard/';
} else {
    $index = 'home';
    $folder = '../private/app/views/';
}

$page = isset($_GET['url']) ? $_GET['url'] : $index;
// Get all files from folder
$files = glob($folder . "*.php");
$file_name = $folder . $page . '.php';

if (in_array($file_name, $files)) {
    include_once($file_name);
} else {
    include_once('../private/app/views/404.php');
}
