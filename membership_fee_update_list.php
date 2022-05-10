<?php
session_start();
$current_page = 'activity';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
//require __DIR__ . '/header.php';
if (!islogin()) {
    header('Location:login.php');
}
if (isMember()) {
    restrictPage();
}
if ($_POST) {
    echo '
    <table class="table table-hover">
    <thead>
        <tr>
        <th class="col-3"><input type="checkbox" name="triggerCheck" id="triggerCheck"> <label for="triggerCheck">ເລືອກທັງໝົດ</label></th>
            <th>ລາຍຊື່ສະມາຊິກ</th>
        </tr>
    </thead>
    <tbody>
    ';
    $id = $con->real_escape_string($_POST['id']);
    $fee_id = $con->real_escape_string($_POST['fee_id']);
    $current_year = date("Y");
    @$sql = "SELECT member.mem_id, member.firstname, member.lastname FROM member JOIN groups ON groups.id = member.group_id WHERE member.group_id = $id AND groups.col_id = ".$_SESSION['college_id'];
    if($id == "*"){
        $sql = "SELECT member.mem_id, member.firstname, member.lastname FROM member JOIN groups ON groups.id = member.group_id WHERE groups.col_id = ".$_SESSION['college_id']; 
    }
    $rs = mysqli_query($con, $sql);
    
    while($row = mysqli_fetch_assoc($rs)){
        $sql1 = "SELECT count(membership_fee.id) AS match_id FROM membership_fee JOIN yearly_fee ON membership_fee.fee_id = yearly_fee.id WHERE mem_id = ".$row['mem_id']." AND fee_id = $fee_id";
        $rs1 = mysqli_query($con, $sql1);
        $row1 = mysqli_fetch_assoc($rs1);
        if($row1['match_id'] == 0){
            echo '
            <tr>
                <td class="text-center"><input type="checkbox" name="mem_id[]" value="'.$row['mem_id'].'"></td>
                <td>'.$row['firstname'].' '.$row['lastname'].'</td>
            </tr>
        ';
        }
        //if($row['mem_id'] == )
        
    }
    echo '</tbody></table>';
}
