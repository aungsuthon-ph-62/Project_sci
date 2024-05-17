<?php
session_start();
require_once("../../config/config.php");

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $action = stripslashes($action);
    if ($action == 'addCategory') {
        addCategory();
        exit;
    } elseif ($action == 'editCategory') {
        editCategory();
        exit;
    }
}

if (isset($_POST['getCategory'])) {
    $id = addslashes($_POST['getCategory']);
    getCategory($id);
}

if (isset($_GET['deleteCategory'])) {
    global $conn;
    $unid = addslashes($_GET['deleteCategory']);

    $sql = "DELETE FROM category WHERE category_unique = '$unid'";
    $query = $conn->query($sql);

    if ($query) {
        $_SESSION['success'] = "ลบรายการสำเร็จ!";
        echo "<script> window.location.href='../../../index?page=category-list';</script>";
        exit;
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด! กรุณาลองอีกครั้ง";
        echo "<script> window.history.back()</script>";
        exit;
    }
}

function addCategory()
{
    global $conn;
    $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
    $uniqid = "category_" . $rand;
    $qP = "SELECT * FROM category WHERE category_unique = '$uniqid'";
    $rP =  mysqli_query($conn, $qP);
    $row =  mysqli_fetch_assoc($rP);

    if ($row) {
        $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
        $uniqid = "category_" . $rand;
    }

    $name = addslashes($_POST['categoryName']);

    if (empty($name)) {
        $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบถ้วน!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    $query = "INSERT INTO category (category_unique, category_name) VALUES ('$uniqid', '$name')";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!";
        echo "<script> window.history.back()</script>";
        exit;
    }

    $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ!";
    header("Location: ../../../index?page=category-list");
    exit;
}

function editCategory()
{
    global $conn;
    $categoryID =  addslashes($_POST['id']);
    $name = addslashes($_POST['categoryName']);

    if (empty($name)) {
        echo json_encode(array('error' => 'กรุณากรอกข้อมูลให้ครบถ้วน'));
        exit;
    }

    // Insert new user into database
    $query = "UPDATE category SET category_name='$name' WHERE category_unique = '$categoryID'";
    $result =  mysqli_query($conn, $query);
    if (!$result) {
        echo json_encode(array('error' => 'เกิดข้อผิดพลาด, ไม่สามารถเพิ่มข้อมูลได้!'));
        exit;
    }

    echo json_encode(array('success' => true));
    exit;
}

function getCategory($id)
{
    global $conn;
    // Get record from database
    $sql = "SELECT * FROM category WHERE category_unique = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    // Return data as JSON
    echo json_encode($data);
}
