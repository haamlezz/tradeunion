<?php
session_start();
$current_page = 'college';
require_once __DIR__.'/include/define.php';
require_once __DIR__.'/include/function.php';
require_once __DIR__.'/include/dbconfig.php';
if (!islogin()) {header('Location:login.php');}
if($_POST){
    $group_id = $con->real_escape_string($_POST['group_id']);
    $sql = "SELECT mem_id, firstname, lastname FROM member WHERE group_id = ?";
    $rs = prepared_stm($con, $sql, [$group_id])->get_result();
    if($rs->num_rows == 0){
        echo '<div class="alert alert-warning">ຍັງບໍ່ທັນມີສະມາຊິກ</div>';
    }
    $str = '<ul>';
    while($row = $rs->fetch_assoc()){
        $str .= '
        <li><a href="member_add.php?member_id='.$row['mem_id'].'">'.$row['firstname'].' '.$row['lastname'].'</a></li>
        ';
    }
    $str .= '</ul>';
    echo $str;
}
