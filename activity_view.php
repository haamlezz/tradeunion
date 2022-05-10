<?php
session_start();
$current_page = 'college';
require_once __DIR__.'/include/define.php';
require_once __DIR__.'/include/function.php';
require_once __DIR__.'/include/dbconfig.php';
if (!islogin()) {header('Location:login.php');}
if($_POST){
    $activity_id = $con->real_escape_string($_POST['activity_id']);
    $sql = "SELECT * FROM activity WHERE id = ? AND col_id = ?";
    $rs = prepared_stm($con, $sql, [$activity_id, $_SESSION['college_id']])->get_result();
    $row = $rs->fetch_assoc();
    $str = '
        <h3>'.$row['act_title'].'</h3>
        <div class="row">
            <div class="col-4"><i class="fas fa-calendar"></i> &nbsp;'.$row['act_date'].'</div>
            <div class="col-4"><i class="fas fa-map-marker"></i> &nbsp;'.$row['act_location'].'</div>
            <div class="col-4"><i class="fas fa-users"></i> &nbsp;'.$row['total_member_join'].' ຄົນ</div>
        </div>
        <hr>
        <div>
            '.$row['act_detail'].'
        </div>
    ';
    echo $str;
}
