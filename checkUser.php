<?php
session_start();
$current_page = 'college';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
//require __DIR__ . '/header.php';
if (!islogin()) {
    header('Location:login.php');
}

if ($_POST) {
    $sql = "SELECT username FROM member WHERE username = '".mysqli_real_escape_string($con, $_POST['username'])."'";
    $rs = mysqli_query($con, $sql);
    echo mysqli_num_rows($rs);
}
