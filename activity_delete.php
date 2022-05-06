<?php
session_start();
$current_page = 'activity';
require_once __DIR__.'/include/define.php';
require_once __DIR__.'/include/function.php';
require_once __DIR__.'/include/dbconfig.php';
//require __DIR__ . '/header.php';
if (!islogin()) {
    header('Location:login.php');
}
if (isMember()){
    restrictPage();
}
if($_POST){
    $sql = "DELETE FROM activity WHERE id = ? AND col_id = ?";
    $rs = prepared_stm($con, $sql, [$_POST['activity_id'], $_SESSION['college_id']]);
}
