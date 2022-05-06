<?php
session_start();
require_once __DIR__.'/include/define.php';
require_once __DIR__.'/include/function.php';
require_once __DIR__.'/include/dbconfig.php';
if (!islogin()) {header('Location:login.php');}

if($_POST){
    $college_id = $con->real_escape_string($_POST['college_id']);
    $sql = "SELECT * FROM college WHERE col_id = ?";
    $rs = prepared_stm($con, $sql, [$college_id])->get_result();
    $row = $rs->fetch_assoc();
    $str = '
        <h3>'.$row['col_name'].'</h3>
        <p><i class="fas fa-phone"></i> &nbsp; '.$row['tel'].'</p>
        <p><i class="fas fa-envelope"></i> &nbsp; <a target="_blank" href="mailto:'.$row['email'].'">'.$row['email'].'</a></p>
        <p>
        <i class="fas fa-map-marker"></i> &nbsp; 
        '.$row['col_village'].',
        '.$row['col_district'].',
        '.$row['col_province'].',
        </p>
    ';
    echo $str;
}
