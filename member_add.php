<?php
session_start();
$current_page = 'member';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
if (!islogin()) {
    header('Location:login.php');
}

if (!isAdmin() && !isCommittee() && !$_GET) {
    restrictPage();
}

require __DIR__ . '/menu.php';

$error = '';

/**
 * Add College
 */
$isValid=[];
$i=0;
    $firstname   = 
    $lastname    = 
    $gender      = 
    $username  = 
    $password     = 
    $hash_password = 
    $ethnic     = 
    $dob = $day = $month = $year =
    $h_village = 
    $h_district = 
    $h_province = 
    $addr_village = 
    $addr_district = 
    $addr_province = 
    $book_no = 
    $join_trade_union_date = 
    $join_party_date = 
    $join_local = 
    $join_women_union_date = $group_id = NULL;
    $role = 3;
    $status = 1;
    $col_id = $_SESSION['college_id'];
if ($_POST) {
    foreach ($_POST as $p=>$v) {
        if($p == 'password' && $_POST['do']=='edit'){
            break;
        }
        if(noValidateField($p, ['join_women_union_date', 'join_party_date', 'group_id', 'book_no', 'join_local'])){
            break;
        }
        if (ctype_space($v) || empty($v)) {
            $isValid[$p] = 'is-invalid';
            $error = '<div class="alert alert-info">ກະລຸນາຕື່ມຂໍ້ມູນໃຫ້ຄົບທຸກຫ້ອງ</div>';
            break;
        }
    }

    

    $firstname   = $con->real_escape_string($_POST['firstname']);
    $lastname    = $con->real_escape_string($_POST['lastname']);
    $gender      = $con->real_escape_string($_POST['gender']);
    $username  = $con->real_escape_string($_POST['username']);
    $password     = $_POST['password'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $ethnic     = $con->real_escape_string($_POST['ethnic']);
    $dob = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $h_village = $con->real_escape_string($_POST['h_village']);
    $h_district = $con->real_escape_string($_POST['h_district']);
    $h_province = $con->real_escape_string($_POST['h_province']);
    $addr_village = $con->real_escape_string($_POST['addr_village']);
    $addr_district = $con->real_escape_string($_POST['addr_district']);
    $addr_province = $con->real_escape_string($_POST['addr_province']);
    $book_no = $con->real_escape_string($_POST['book_no']);
    $join_trade_union_date = $con->real_escape_string($_POST['join_trade_union_date']);
    $group_id = $con->real_escape_string($_POST['group_id']);

    if(!$_POST['join_party_date']==''){
        $join_party_date = $con->real_escape_string($_POST['join_party_date']);
    }

    if(!$_POST['join_women_union_date']==''){
        $join_women_union_date = $con->real_escape_string($_POST['join_women_union_date']);
    }

    if(!$_POST['join_local'] == ''){
        $join_local = $con->real_escape_string($_POST['join_local']);
    }

    if($_SESSION['role']==1){
        $role = $con->real_escape_string($_POST['role']);
        $status = $con->real_escape_string($_POST['status']);
        $col_id = $con->real_escape_string($_POST['col_id']);
    }
    
    
    if ($_POST['do'] == 'add' && $error == '') {
        $data = [
            $username,
            $hash_password,
            $book_no,
            $firstname,
            $lastname,
            $gender,
            $ethnic,
            $dob,
            $h_village,
            $h_district,
            $h_province,
            $addr_village,
            $addr_district,
            $addr_province,
            $join_trade_union_date,
            $join_party_date,
            $join_women_union_date,
            $group_id,
            $join_local,
            $status,
            $role,
            $col_id
        ];

        

        

        $sql = "INSERT INTO member(
            username,
            password,
            book_no,
            firstname,
            lastname,
            gender,
            ethnic,
            dob,
            h_village,
            h_district,
            h_province,
            addr_village,
            addr_district,
            addr_province,
            join_trade_union_date,
            join_party_date,
            join_women_union_date,
            group_id,
            join_local,
            status,
            role,
            col_id
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $rs = prepared_stm($con, $sql, $data);
        echo $con->error;
        
        if ($rs->affected_rows == 1) {
            $message = '<script type="text/javascript">
            Swal.fire({
                        title:"ສຳເລັດ",
                        position: "top-center", 
                        icon: "success",
                        text: "ບັນທຶກຂໍ້ມູນສຳເລັດ",
                        button: "ຕົກລົງ",
                    }).then((data)=>{
                        // window.location.href = "member.php";
                    });
            </script>';
        } else {
            $message = '<script type="text/javascript">
            Swal.fire({
                title: "ບໍ່ສຳເລັດ",
                position: "top-center",
                icon: "warning",
                text: "ເກີດຂໍ້ຜິດພາດ",
                button: "ລອງໃໝ່",
            }).then(() => {
                //location.reload();
            });
            </script>';
        }
    } else if ($_POST['do'] == 'edit' && $error == '') {
        $mem_id   = $con->real_escape_string($_POST['member_id']); 
        
        $data = [
            $username,
            $book_no,
            $firstname,
            $lastname,
            $gender,
            $ethnic,
            $dob,
            $h_village,
            $h_district,
            $h_province,
            $addr_village,
            $addr_district,
            $addr_province,
            $join_trade_union_date,
            $join_party_date,
            $join_women_union_date,
            $group_id,
            $join_local,
        ];
        if($_SESSION['role']==1){
            array_push($data, $role);
            array_push($data, $status);
            array_push($data, $col_id);
        }
        $sql = "UPDATE member SET
            username = ?,
            book_no = ?,
            firstname = ?,
            lastname = ?,
            gender = ?,
            ethnic = ?,
            dob = ?,
            h_village = ?,
            h_district = ?,
            h_province = ?,
            addr_village = ?,
            addr_district = ?,
            addr_province = ?,
            join_trade_union_date = ?,
            join_party_date = ?,
            join_women_union_date = ?,
            group_id = ?,
            join_local=?
            ";
        if($_SESSION['role']==1){
            $sql.=" , role=?, status=?, col_id=? ";
        }

        if($_POST['password'] != null){
            $password = $con->real_escape_string($_POST['password']);
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            array_push($data, $hash_password);

            $sql .= ", password = ? ";
        }   


        $sql .= " WHERE mem_id = ".$mem_id;

        $rs = prepared_stm($con, $sql, $data);
        
        echo $con->error;
        
        if ($rs->affected_rows == 1 || $rs->affected_rows == 0) {
            $message = '<script type="text/javascript">
            Swal.fire({
                        title:"ສຳເລັດ",
                        position: "top-center",
                        icon: "success",
                        text: "ປັບປຸງຂໍ້ມູນສຳເລັດ",
                        button: "ຕົກລົງ",
                    }).then((data)=>{
                        window.location.href = "member.php";
                    });
            </script>';
        }else if($rs->errno == 1062){
            $message = '<script type="text/javascript">
            Swal.fire({
                title: "ຂໍ້ມູນຊໍ້າກັນ",
                position: "top-center",
                icon: "warning",
                text: "ບັນຊີຜູ້ໃຊ້ບໍ່ສາມາດຊໍ້າກັນໄດ້",
                button: "ລອງໃໝ່",
            }).then(() => {
                //location.reload();
            });
            </script>';
        }else if($rs->affected_row == -1){
            $message = '<script type="text/javascript">
            Swal.fire({
                title: "ບໍ່ສຳເລັດ",
                position: "top-center",
                icon: "warning",
                text: "ເກີດຂໍ້ຜິດພາດ",
                button: "ລອງໃໝ່",
            }).then(() => {
                //location.reload();
            });
            </script>';
        }
    }
}

if ($_GET) {
    
    if (!isExisted($con, 'mem_id', 'member', $_GET['member_id'])) {
        notFoundPage();
    }

    $sql = "SELECT *, 
            date_format(dob, '%d') as d, 
            date_format(dob, '%m') as m, 
            date_format(dob, '%Y') as y  
            FROM member ";
            

    if(isCommittee()){
        $sql.= " WHERE mem_id = ? AND member.col_id = ". $_SESSION['college_id'] ;
    }
    if(isAdmin()){
        $sql.= " WHERE mem_id = ?";
    }
    $rs = prepared_stm($con, $sql, [$_GET['member_id']])->get_result();
    if($rs->num_rows == 1):
    $row = $rs->fetch_assoc();
    $firstname   = $row['firstname'];
    $lastname    = $row['lastname'];
    $gender      = $row['gender'];
    $username  = $row['username'];
    $ethnic     = $row['ethnic'];
    $dob = $row['dob'];
    $h_village = $row['h_village'];
    $h_district = $row['h_district'];
    $h_province = $row['h_province'];
    $addr_village = $row['addr_village'];
    $addr_district = $row['addr_district'];
    $addr_province = $row['addr_province'];
    $book_no = $row['book_no'];
    $join_trade_union_date = $row['join_trade_union_date'];
    $join_party_date = $row['join_party_date'];
    $join_women_union_date = $row['join_women_union_date'];
    $group_id = $row['group_id'];
    $status = $row['status'];
    $role = $row['role'];
    $join_local = $row['join_local']; 
    
    else :

        $message = '<script type="text/javascript">
            Swal.fire({
                title: "ຜິດພາດ",
                position: "top-center",
                icon: "warning",
                text: "ບໍ່ສາມາດແກ້ໄຂສະມາຊິກຂອງຮາກຖານອື່ນໄດ້",
                button: "ລອງໃໝ່",
            }).then(() => {
                window.location.href= "member.php";
            });
            </script>';
            
    endif;
}

echo @$message;
?>

<div class="container mt-3 mb-5">
    <h2>ເພີ່ມຂໍ້ມູນສະມາຊິກ</h2>

    <?= @$error; ?>

    <form method="post">
        <hr class="mb-3">
        <div class="row mb-3">
            <div class="col-md-4">
                <h4 class="text-secondary">ຂໍ້ມູນພື້ນຖານ</h4>
            </div>
            <div class="col-md-8">
                <div class="form-group mb-2">
                    <label for="firstname">ຊື່</label>
                    <input required value="<?= @$firstname ?>" id="firstname" type="text" class="form-control <?= $isValid['firstname'] ?>" name="firstname" placeholder="ປ້ອນຊື່">
                </div>

                <div class="form-group mb-2">
                    <label for="lastname">ນາມສະກຸນ</label>
                    <input required value="<?= @$lastname ?>" id="lastname" type="text" class="form-control <?= @$isValid['lastname'] ?>" name="lastname" placeholder="ປ້ອນນາມສະກຸນ">
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label for="username">ຊື່ບັນຊີຜູ້ໃຊ້</label>
                            <input required value="<?= @$username ?>" id="username" type="text" class="form-control <?= @$isValid['username'] ?>" name="username" placeholder="ປ້ອນຊື່ບັນຊີຜູ້ໃຊ້">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="password">ລະຫັດຜ່ານ</label>
                            <input value="" <?php if(!isset($_GET['member_id'])){echo 'required';} ?> id="password" type="password" class="form-control <?= @$isValid['password'] ?>" name="password" placeholder="ປ້ອນລະຫັດຜ່ານ">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="gender">ເພດ</label>
                            <select required name="gender" id="gender" class="form-control <?= @$isValid['gender'] ?>">
                                <option value="">ເລືອກເພດ...</option>
                                <option value="ຊາຍ" <?= @$gender == 'ຊາຍ'? 'selected':'' ?>>ຊາຍ</option>
                                <option value="ຍິງ" <?= @$gender == 'ຍິງ'? 'selected':'' ?>>ຍິງ</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="ethnic">ຊົນເຜົ່າ</label>
                        <input required value="<?= @$ethnic ?>" require id="ethnic" type="text" class="form-control <?= @$isValid['ethnic'] ?>" name="ethnic" placeholder="ປ້ອນຊົນເຜົ່າ">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="gender">ວັນ ເດືອນ ປີເກີດ</label>
                                    <select class="form-control <?= @$isValid['day'] ?>" name="day" id="">
                                        <option value="">ເລືອກວັນ...</option>
                                        <?php

                                        for ($d = 1; $d <= 31; $d++) {
                                            echo '<option value="' . $d . '"';
                                            echo $d==@$row['d'] || $d==$day?'selected':'';
                                            echo '>' . $d . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="gender"> </label>
                                    <select class="form-control <?= @$isValid['month'] ?>" name="month" id="">
                                        <option value="">ເລືອກເດືອນ...</option>
                                        <?php
                                        for ($m = 1; $m <= 12; $m++) {
                                            echo '<option value="' . $m . '" ';
                                            echo $m==@$row['m'] || $m==$month ? 'selected':'';
                                            echo '>' . $m . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="gender"> </label>
                                    <select class="form-control <?= @$isValid['year'] ?>" name="year" id="">
                                        <option value="">ເລືອກປີ...</option>
                                        <?php
                                        for ($y = 1970; $y <= date("Y"); $y++) {
                                            echo '<option value="' . $y . '" ';
                                            echo  $y==@$row['y'] || $y==$year ? 'selected':'';
                                            echo '>' . $y . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 mt-2 ">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="h_village">ບ້ານເກີດ</label>
                            <input required value="<?= @$h_village ?>" require id="h_village" type="text" class="form-control <?= @$isValid['h_village'] ?>" name="h_village" placeholder="ປ້ອນບ້ານເກີດ">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="h_district">ເມືອງເກີດ</label>
                            <input required value="<?= @$h_district ?>" require id="h_district" type="text" class="form-control <?= @$isValid['h_district'] ?>" name="h_district" placeholder="ປ້ອນເມືອງເກີດ">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="h_province">ແຂວງເກີດ</label>
                            <input required value="<?= @$h_province ?>" list="h_province_list" require id="h_province" type="text" class="form-control <?= @$isValid['h_province'] ?>" name="h_province" placeholder="ປ້ອນແຂວງເກີດ">
                            <?php dataListProvince('h_province_list'); ?>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="addr_village">ບ້ານຢູ່ປະຈຸບັນ</label>
                            <input required value="<?= @$addr_village ?>" require id="addr_villege" type="text" class="form-control <?= @$isValid['addr_village'] ?>" name="addr_village" placeholder="ປ້ອນບ້ານຢູ່ປະຈຸບັນ">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="addr_district">ເມືອງ</label>
                            <input required value="<?= @$addr_district ?>" require id="addr_district" type="text" class="form-control <?= @$isValid['addr_district'] ?>" name="addr_district" placeholder="ປ້ອນເມືອງ">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="addr_province">ແຂວງ</label>
                            <input required value="<?= @$addr_province ?>" list="addr_province_list" require id="addr_province" type="text" class="form-control <?= @$isValid['addr_province'] ?>" name="addr_province" placeholder="ປ້ອນແຂວງ">
                            <?php dataListProvince('addr_province_list'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="mb-3 mt-3">

        <div class="row mb-3">
            <div class="col-4">
                <h4 class="text-secondary">ຂໍ້ມູນໃນອົງການຈັດຕັ້ງ</h4>
            </div>
            <div class="col-8">
                <?php
                    if($_SESSION['role'] == 1):
                ?>
                    <div class="form-group">
                        <label for="col_id">ຮາກຖານ</label>
                        <select class="form-control" name="col_id" id="col_id" required>
                            <option value="">ເລືອກຮາກຖານ...</option>
                            <?php
                                $sql_college = "SELECT college.col_id, college.col_name FROM college";
                                $rs_college = $con->query($sql_college);
                                while($row_college = $rs_college->fetch_assoc()){
                                    
                                    echo '
                                        <option '.($row_college['col_id']==@$col_id?'selected':'').' value="'.$row_college['col_id'].'">'.$row_college['col_name'].'</option>
                                    ';
                                }
                            ?>
                        </select>
                    </div>
                <?php
                    endif;
                ?>
                <div class="row mb-3 mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="join_trade_union_date">ວັນທີເຂົ້າກຳມະບານ</label>
                            <input value="<?= @$join_trade_union_date ?>" id="join_trade_union_date" type="date" class="form-control <?= @$isValid['join_trade_union_date'] ?>" name="join_trade_union_date" placeholder="ປ້ອນວັນທີເຂົ້າກຳມະບານ">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="join_party_date">ວັນທີເຂົ້າພັກ</label>
                            <input value="<?= @$join_party_date ?>" id="join_party_date" type="date" class="form-control" name="join_party_date" placeholder="ປ້ອນວັນທີເຂົ້າພັກ">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="join_women_union_date">ວັນທີເຂົ້າແມ່ຍິງ</label>
                            <input value="<?= @$join_women_union_date ?>" id="join_women_union_date" type="date" class="form-control" name="join_women_union_date" placeholder="ປ້ອນວັນທີເຂົ້າແມ່ຍິງ">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="book_no">ເລກທີປຶ້ມກຳມະບານ</label>
                            <input required value="<?= @$book_no ?>" id="book_no" type="text" class="form-control <?= @$isValid['book_id'] ?>" name="book_no" placeholder="ປ້ອນເລກທີປຶ້ມ">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="group">ຈຸທີ່ສັງກັດ</label>
                            <select required name="group_id" id="group" class="form-control <?= @$isValid['group'] ?>">
                                <option value="0">ເລືອກຈຸສັງກັດ</option>
                                <?php
                                $sql = "SELECT * FROM groups WHERE col_id = " . $_SESSION['college_id'] ." ORDER BY group_name";
                                $rs = mysqli_query($con, $sql);
                                while ($row2 = mysqli_fetch_array($rs)) {
                                    echo '<option value="' . $row2['id'] . '"';
                                    echo @$group_id==$row2['id']?'selected':'';
                                    echo '>' . $row2['group_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="join_local">ວັນທີຮັບເຂົ້າຮາກຖານ</label>
                            <input value="<?= @$join_local ?>" id="join_local" type="date" class="form-control <?= @$isValid['book_id'] ?>" name="join_local" placeholder="ປ້ອນວັນທີເຂົ້າຮາກຖານ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="mt-3 mb-3">
        
        <?php if(isset($_GET['member_id']) || isAdmin()){?>

            <div class="row">
                <div class="col-4">
                    <h4 class="text-secondary">ສະຖານະສະມາຊິກໃນ</h4>
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label for="status">ສະຖານະ</label>
                        <select required class="form-control" name="status" id="status">
                            <option value="">ເລືອກສະຖານະ...</option>
                            <option value="0" <?= @$status==0?'selected':''?>>ປິດໃຊ້ງານ</option>
                            <option value="1" <?= @$status==1?'selected':''?>>ອະນຸມັດໃຊ້ງານ</option>
                        </select>
                    </div>

                    <?php if(isAdmin()){?>
                    <div class="form-group mt-3">
                        <label for="role">ສິດຖິການເຂົ້າເຖິງ</label>
                        <select required class="form-control" name="role" id="role">
                            <option value="">ເລືອກສະຖານະ...</option>
                            <option value="1" <?= @$role==1?'selected':''?>>ຄະນະບໍລິຫານ</option>
                            <option value="2" <?= @$role==2?'selected':''?>>ຮາກຖານ</option>
                            <option value="3" <?= @$role==3?'selected':''?>>ສະມາຊິກທົ່ວໄປ</option>
                        </select>
                    </div>
                    <?php }?>
                </div>
            </div>

            <hr class="mt-3 mb-3">

        <?php }?>

        <?php
        if (isset($_GET['member_id'])) {
            echo '<input type="hidden" name="member_id" value="' . $_GET['member_id'] . '">';
            echo '<button name="do" value="edit" class="btn col-2 btn-primary mt-3">ບັນທຶກການປ່ຽນແປງ</button> &nbsp;';
        } else {
            echo '<button name="do" value="add" class="btn col-2 btn-primary mt-3">ບັນທຶກ</button> &nbsp;';
        }

        echo '<a href="member.php" class="btn col-1 btn-warning mt-3">ອອກ</a>';
        ?>

    </form>
</div>
<?php
require __DIR__ . '/footer.php';
?>


<script>
$('#h_province').autocomplete();
$('#addr_province').autocomplete();

function checkUserName(){
    
}


</script>