<?php
session_start();
$current_page='home';
require_once __DIR__.'/include/define.php';
require_once __DIR__.'/include/function.php';
require_once __DIR__.'/include/dbconfig.php';
require_once __DIR__.'/header.php';
if(!islogin()){header('Location:login.php');}
?>

<div class="container mt-3">
    
    <div class="row">
        <div class="col-md-2 pe-5">
            <img src="image/trade_union_logo.png" alt="" class="img-fluid">
        </div>
        <div class="col-md-8">
            <?php
                $sql = "SELECT CONCAT(member.firstname,' ',member.lastname) AS fullname ,
                        groups.group_name,
                        (SELECT college.col_name FROM college WHERE college.col_id = groups.col_id) AS col_name
                        FROM member 
                        JOIN groups ON member.group_id = groups.id
                        WHERE username = '" .$_SESSION['username']."'";

                $rs = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($rs);

                print_r($row);
            ?>
            <br>
            <small class="text-secondary">ຊື່ ນາມສະກຸນ</small>
            <h1><?= $row['fullname'] ?></h1>

                <hr>

            <small class="text-secondary">ສັງກັດຮາກຖານ</small>
            <h2><?= $row['col_name'] ?> - <?= $row['group_name'] ?></h2>

            <?php
                $sql = "SELECT membership_fee.pay_date, yearly_fee.fee FROM membership_fee JOIN "
            ?>

        </div>
    </div>

</div>


<?php
require __DIR__.'/footer.php';
?>