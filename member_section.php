<?php
session_start();
$current_page='home';
require_once __DIR__.'/include/define.php';
require_once __DIR__.'/include/function.php';
require_once __DIR__.'/include/dbconfig.php';
if(!islogin()){header('Location:login.php');}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="image/favicon.png" type="image/png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/brands.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <script defer src="js/all.js"></script>
    <title>ລະບົບຈັດການຂໍ້ມູນສະມາຊິກກຳມະບານ ສກອ</title>
</head>
<body style="height: 100%;">
<?php
$username = $_SESSION['username'];
if($_GET){
    $username = $con->real_escape_string($_GET['username']);
}
$sql = "SELECT * FROM college WHERE col_id = ". $_SESSION['college_id'] ;
$rs = mysqli_query($con, $sql);
if(!$rs){
    echo '<div class="mt-3 text-center">';
    echo '<b><a href="logout.php">ກັບຄືນ</a></b>';
    echo '</div>';
    echo '</body></html>';
    exit;
}
?>
<div class="container mt-3"  style="height: 100%;">
    <div class="row">
        <div class="col-3 text-center">
            <img src="image/trade_union_logo.png" alt="" class="img-fluid" width="100">
            <h6 class="mt-3">
                ສະຫະພັນກຳມະບານ<br>
                ສະມາຄົມການສຶກສາ<br>
                ພາກເອກະຊົນ
            </h6>
            <?php
                
                $row = mysqli_fetch_assoc($rs);
                echo '<p class="text-center mt-3 mb-5">
                    <b>'.$row['col_name'].'</b><br>
                    '.$row['col_village'].'<br>
                    '.$row['col_district'].'<br>
                    '.$row['col_province'].'<br>
                    '.$row['tel'].'<br>
                    '.$row['email'].'<br>
                </p>';
            ?>

            <button onclick="window.print();" class="col-12 mb-3 btn btn-warning d-print-none"><i class="fa-solid fa-print"></i> &nbsp; ສັ່ງພິມ</button>

            <?php 
                if($_GET){
                    echo '<button onclick="window.close();"  class="btn btn-danger col-12 d-print-none"><i class="fa fa-window-close" aria-hidden="true"></i> &nbsp; ປິດໜ້ານີ້</button>';
                }else{
                    echo '<a href="logout.php" class="btn btn-danger col-12 d-print-none">ອອກລະບົບ</a>';
                }
            ?>
            

        </div>
        <div class="col-8 offset-1">
            <?php

                $sql = "
                        SELECT member.mem_id, 
                        CONCAT(member.firstname,' ',member.lastname) AS fullname ,
                        member.gender,
                        (SELECT groups.group_name FROM groups WHERE groups.id = member.group_id) AS group_name,
                        DATE_FORMAT(member.join_local, '%d/%m/%Y') AS j_l,
                        DATE_FORMAT(member.join_trade_union_date, '%d/%m/%Y') AS j_t,
                        DATE_FORMAT(member.join_party_date, '%d/%m/%Y') AS j_p,
                        DATE_FORMAT(member.join_women_union_date, '%d/%m/%Y') AS j_w,
                        (SELECT DATE_FORMAT(member_in.issue_date,'%d/%m/%Y') FROM member_in WHERE member_in.mem_id = member.mem_id) AS in_date,
                        (SELECT DATE_FORMAT(member_out.issue_date,'%d/%m/%Y') FROM member_out WHERE member_out.mem_id = member.mem_id) AS out_date,
                        (SELECT college.col_name FROM college WHERE college.col_id = groups.col_id) AS col_name
                        FROM member 
                        JOIN groups ON groups.id = member.group_id 
                        WHERE username = '" .$username.
                        "'";
                
                $rs = mysqli_query($con, $sql);
                if($rs->num_rows == 0){
                    echo '<div class="mt-4 alert alert-danger text-center">ບັນຊີນີ້ຍັງບໍ່ທັນໄດ້ຮັບການອານຸມັດໃຊ້ງານ</div>';
                    require __DIR__.'/footer.php';
                    exit;
                }
                $row = mysqli_fetch_assoc($rs);
                $mem_id = $row['mem_id'];
                
            ?>
            <br>
            <small class="text-secondary">ຊື່ ນາມສະກຸນ</small>
            <h4>ສະຫາຍ <?= ($row['gender']=='ຍິງ'?'ນາງ ':'') ?> <?= $row['fullname'] ?></h4>

                <hr>

            <div class="row">
                <div class="col-6 p-1">
                    <div class="bg-info p-3 bg-gradient" style="border-radius: 25px;">
                    <small class="text-white">ສັງກັດຮາກຖານ</small>
                    <h6><?= $row['col_name'] ?></h6>
                    (<?= $row['group_name'] ?>) - ທີ <?= $row['j_l'] ?>
                    </div>
                </div>

                <div class="col-6 p-1">
                    <div class="bg-warning p-3 bg-gradient" style="border-radius: 25px;">
                    <small class="text-white">ຂໍ້ມູນຍົກຍ້າຍ</small>
                    <h6>ເຂົ້າ: <?= ($row['in_date']==''?'ບໍ່ມີຂໍ້ມູນ':$row['in_date']) ?></h6>
                    <h6>ອອກ: <?= ($row['out_date']==''?'ບໍ່ມີຂໍ້ມູນ':$row['out_date']) ?></h6>
                    </div>
                </div>

            </div>

            <h5  class="mt-5">ວັນທີເຂົ້າຮ່ວມອົງການຈັດຕັ້ງ</h5>

            <ul>
                <li>ພັກປະຊາຊົນປະຕິວັດລາວ: <b><?= $row['j_p'] ?></b></li>
                <li>ສະຫະພັນກຳມະບານລາວ: <b><?= $row['j_t'] ?></b></li>
                <?php 
                    if($row['gender']=='ຍິງ') {
                        echo '<li>ສະຫະພັນແມ່ຍິງ: <b>' .$row['j_w'].'</b></li>';
                    }
                ?>
                
            </ul>
            
            <h5  class="mt-5">ການຊຳລະຄ່າສະຕິ</h5>
            <?php
                $sql = "SELECT 
                DATE_FORMAT(membership_fee.pay_date,'%d/%m/%Y') AS pd, 
                yearly_fee.fee 
                FROM membership_fee 
                JOIN yearly_fee ON membership_fee.fee_id = yearly_fee.id 
                WHERE mem_id = $mem_id";

                $rs = mysqli_query($con, $sql);
                
                if(mysqli_num_rows($rs)==0){
                    echo '<p>ບໍ່ມີຂໍ້ມູນ</p>';
                }else{
                    echo '
                        <table class="table table-striped table-bordered">
                            <tr class="table-dark">
                                <td>ວັນທີຊຳລະ</td>
                                <td>ຍອດຊຳລະ</td>
                            </tr>
                    ';
                    while($row = mysqli_fetch_assoc($rs)){
                        echo '
                            <tr>
                                <td>'.$row['pd'].'</td>
                                <td>'.number_format($row['fee']).'</td>
                            </tr>
                        ';
                    }
                    echo '
                        </table>
                    ';
                }
            ?>
        </div>
    </div>
</div>
<?php
require __DIR__.'/footer.php';
?>