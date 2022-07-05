<?php
session_start();
$current_page = 'college';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
if (!islogin()) {
    header('Location:login.php');
}

if(isMember()){
    restrictPage();
}

require __DIR__ . '/menu.php';

if(!isAdmin() && !$_GET){
    
    restrictPage();
}

if($_GET){
    if(isCommittee()){
        if(!isOwner($_GET['college_id'])){
            restrictPage();
        }
    }

    if(!isAdmin() AND !isCommittee()){   
        restrictPage();
    }
}

/**
 * Add College
 */
if ($_POST) {
    $college_name   = $con->real_escape_string($_POST['college_name']);
    $college_tel    = $con->real_escape_string($_POST['college_tel']);
    $college_email  = $con->real_escape_string($_POST['college_email']);
    $college_village     = $con->real_escape_string($_POST['college_village']);
    $college_district    = $con->real_escape_string($_POST['college_district']);
    $college_province    = $con->real_escape_string($_POST['college_province']);

    if ($_POST['do'] == 'add') {
        $data = [$college_name, $college_tel, $college_email, $college_village, $college_district, $college_province];

        $sql = "INSERT INTO college(col_name, tel, email, col_village, col_district, col_province) VALUES (?,?,?,?,?,?)";

        $rs = prepared_stm($con, $sql, $data, 'ssssss');

        if ($rs->affected_rows == 1) {
            $message = '<script type="text/javascript">
            Swal.fire({
                        title:"ສຳເລັດ",
                        position: "top-center",
                        icon: "success",
                        text: "ບັນທຶກຂໍ້ມູນສຳເລັດ",
                        button: "ຕົກລົງ",
                    }).then((data)=>{
                        window.location.href = "college.php";
                    });

            </script>';
        }
    } else if ($_POST['do'] == 'edit') {
        
        $college_id   = $con->real_escape_string($_POST['college_id']);
        // $local_president = $con->real_escape_string($_POST['president']);
        $local_president = '';
        $data = [$college_name, $college_tel, $college_email, $college_village, $college_district, $college_province, $local_president, $college_id];
        $sql = "UPDATE college SET col_name=?,tel=?, email=?, col_village=?, col_district=?, col_province=?, local_president=? WHERE col_id=? ";
        $rs = prepared_stm($con, $sql, $data, 'ssssssii');
        
        if($rs->affected_rows >= 0){
            $message = '<script type="text/javascript">
            Swal.fire({
                        title:"ສຳເລັດ",
                        position: "top-center",
                        icon: "success",
                        text: "ປັບປຸງຂໍ້ມູນສຳເລັດ",
                        button: "ຕົກລົງ",
                    }).then((data)=>{
                        window.location.href = "college.php";
                    });

            </script>';
        }
    }
}

if ($_GET) {
    if(!isExisted($con, 'col_id', 'college', $_GET['college_id'])){
        notFoundPage();
    } 

    $sql = "SELECT * FROM college WHERE col_id = ?";
        $rs = prepared_stm($con, $sql, [$_GET['college_id']])->get_result();
        $row = $rs->fetch_assoc();

        $college_name   = $row['col_name'];
        $college_tel    = $row['tel'];
        $college_email  = $row['email'];
        $college_village     = $row['col_village'];
        $college_district    = $row['col_district'];
        $college_province    = $row['col_province'];
        // $local_president     = $row['local_president'];
}

echo @$message;

?>

<div class="container mt-3">
    <h2>ເພີ່ມຂໍ້ມູນຮາກຖານ</h2>

    <form method="post">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="collegeName">ຊື່ຮາກຖານ</label>
                    <input value="<?= @$college_name ?>" required id="collegeName" type="text" class="form-control" name="college_name" placeholder="ປ້ອນຊື່ຮາກຖານ">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="collegeTel">ເບີໂທ</label>
                    <input value="<?= @$college_tel ?>" required id="collegeTel" type="text" class="form-control" name="college_tel" placeholder="ປ້ອນເບີໂທ">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="collegeEmail">ອີເມລ</label>
                    <input value="<?= @$college_email ?>" id="collegeEmail" type="email" class="form-control" name="college_email" placeholder="ປ້ອນອີເມລ">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="collegeVillage">ທີ່ຕັ້ງ</label>
                    <input value="<?= @$college_village ?>" required id="collegeVillage" type="text" class="form-control" name="college_village" placeholder="ບ້ານ">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="collegeDistrict"> </label>
                    <input value="<?= @$college_district ?>" autocomplete="off" required id="collegeDistrict" type="text" class="form-control" name="college_district" placeholder="ເມືອງ">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="collegeProvince"> </label>
                    <input value="<?= @$college_province ?>" autocomplete="off" list="addr_province_list" required id="collegeProvince" type="text" class="form-control" name="college_province" placeholder="ແຂວງ">
                    <?php dataListProvince('addr_province_list'); ?>
                </div>
            </div>
        </div>

        <hr class="mt-3 mb-3">

        <!-- <div class="row mb-3"> -->
            <!-- <div class="col-md-4">
                <h4 class="text-secondary">ປະທານກຳມະບານຮາກຖານ</h4>
            </div> -->

            <!-- <div class="col-md-8">
                <div class="form-group">
                        <?php
                            // $sql = "SELECT member.mem_id, CONCAT(member.firstname,' ',member.lastname) AS fullname FROM member WHERE member.col_id = ? AND member.role <> 3";
                            // $rs = prepared_stm($con, $sql, [@$_GET['college_id']])->get_result() ;
                            // if($rs->num_rows == 0){
                            //     echo 'ຍັງບໍ່ທັນມີສະມາຊິກ';
                            // }else{
                            //     echo '<label for="presedent">ປະທານ</label>';
                            //     echo '<select name="president" id="president" class="form-control">';
                            //     echo '<option value="">ເລືອກປະທານຮາກຖານ</option>';
                            //     while($row = $rs->fetch_assoc()){
                            //         echo '
                            //             <option '.($local_president==$row['mem_id']?'selected':'').' value="'.$row['mem_id'].'">'.$row['fullname'].'</option>
                            //         ';
                            //     }

                            //     echo '</select>';
                            // }
                        ?>
                    
                    
                </div>
            </div> -->
        <!-- </div> -->
        <?php
        if (isset($_GET['college_id'])) {
            echo '<input type="hidden" name="college_id" value="' . $_GET['college_id'] . '">';
            echo '<button name="do" value="edit" class="btn col-2 btn-primary mt-3">ບັນທຶກການປ່ຽນແປງ</button> &nbsp;';
            echo '<a href="college.php" class="btn col-1 btn-warning mt-3">ຍົກເລີກ</a>';
        } else {
            echo '<button name="do" value="add" class="btn col-2 btn-primary mt-3">ບັນທຶກ</button>';
        }
        ?>

    </form>



</div>

<?php



require __DIR__ . '/footer.php';
?>