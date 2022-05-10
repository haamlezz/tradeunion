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
    $sql0 = "SELECT username, role FROM member WHERE mem_id = ?";
    $rs0 = prepared_stm($con, $sql0, [$_POST['member_id']])->get_result();
    $row0 = $rs0->fetch_assoc();

    if($row0['username'] == $_SESSION['username']){
        echo 1;
    } else if ($row0['role'] == 1){
        echo 2;
    } else {
        echo 3;
        $sql = "DELETE FROM member WHERE id = ?";
        $rs = prepared_stm($con, $sql, [$_POST['activity_id'], $_SESSION['college_id']]);
    }
}
