<?php
session_start();
session_unset();
session_destroy();
$_SESSION['error'] = "ออกจากระบบสำเร็จ!";
header("Location: ../../../index");
exit;
