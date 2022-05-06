<?php
session_start();
$current_page = 'college';
require_once __DIR__.'/include/define.php';
require_once __DIR__.'/include/function.php';
require_once __DIR__.'/include/dbconfig.php';
//require __DIR__ . '/header.php';
if (!islogin()) {
    header('Location:login.php');
}
if (!isAdmin()){
    restrictPage();
}
if($_POST){
    $sql = "DELETE FROM college WHERE col_id = ?";
    $rs = prepared_stm($con, $sql, [$_POST['college_id']], 'i');
}
