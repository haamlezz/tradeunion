<?php
session_start();
$current_page = 'home';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
if (!islogin()) {
    header('Location:login.php');
}
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/menu.php';


?>

<div class="container mt-3">
    <?php
    $sql = "SELECT CONCAT(member.firstname, ' ', member.lastname) AS fullname, member.gender FROM member WHERE username = '" . $_SESSION['username'] . "'";
    $rs = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($rs);
    ?>
    <div class="text-center mb-3" style="font-size: 20px;">ສະບາຍດີ, <b>ສະຫາຍ <?= ($row['gender']=='ຍິງ'?'ນາງ ':'') ?> <?= $row['fullname']; ?></b></div>
    
        <?php
            $sql="SELECT id AS c_g FROM groups WHERE col_id = ".$_SESSION['college_id'];
            $rs = $con->query($sql);            
            if($rs->num_rows == 0){
                echo '<div class="alert alert-danger">ຮາກຖານນີ້ຍັງບໍ່ທັນມີຈຸ <a href="group.php">ເພີ່ມຈຸ</a></div>';
            }

            $sql="SELECT group_id FROM member WHERE mem_id = ".$_SESSION['member_id'] ." AND group_id = 0";
            $rs = $con->query($sql);            
            if($rs->num_rows == 1){
                echo '<div class="alert alert-danger">ຂໍ້ມູນທ່ານ <a href="member_add.php?member_id='. $_SESSION['member_id'] .'&#group">ກະລຸນາເລືອກຈຸສັງກັດ</a></div>';
            }
        ?>
    

    <h2 class="text-center text-primary">ລະບົບຈັດການສະມາຊິກກຳມະບານ ຂອງສະມາຄົມການສຶກສາພາກເອກະຊົນ</h2>
    <h3 class="text-center text-secondary">Trade Union Membership Management System of Private Education Association</h3>

    <div class="row mt-5">
        <div class="col-2 offset-3">
            <img src="image/private_ed_logo.png" alt="" class="img-fluid">
        </div>
        <div class="col-2"></div>
        <div class="col-2">
            <img src="image/trade_union_logo.png" alt="" class="img-fluid">
        </div>
    </div>
    <p></p>
    <div class="text-secondary">
        <p class="text-center mt-5">
            ສະມາຄົມການສຶກສາພາກເອກະຊົນ
        </p>
        <p class="text-center">
            ບ້ານ ບຶງຂະຫຍອງ &nbsp; ເມືອງ ສີສັດຕະນາກ &nbsp; ນະຄອນຫຼວງວຽງຈັນ
        </p>
        <p class="text-center">
            <a href="tel:+8562098449644"><i class="fa fa-phone"></i> 020 98 449 644</a> 
            &nbsp; | &nbsp;
            <a target="_blank" href="https://www.facebook.com/%E0%BA%AA%E0%BA%B0%E0%BA%AB%E0%BA%B0%E0%BA%9E%E0%BA%B1%E0%BA%99%E0%BA%81%E0%BA%B3%E0%BA%A1%E0%BA%B0%E0%BA%9A%E0%BA%B2%E0%BA%99%E0%BA%81%E0%BA%B2%E0%BA%99%E0%BA%AA%E0%BA%B6%E0%BA%81%E0%BA%AA%E0%BA%B2%E0%BA%9E%E0%BA%B2%E0%BA%81%E0%BB%80%E0%BA%AD%E0%BA%81%E0%BA%B0%E0%BA%8A%E0%BA%BB%E0%BA%99-%E0%BA%AA%E0%BA%81%E0%BA%81%E0%BA%AD-112925270894741/"><i class="fab fa-facebook-f"></i> ກຳມະບານ ສກອ</a> 
            &nbsp; | &nbsp;
            <a target="_blank" href="https://wa.link/0w6mfb"><i class="fab fa-whatsapp"></i> WhatsApp</a>
        </p>
    </div>
</div>


<?php
require __DIR__ . '/footer.php';
?>