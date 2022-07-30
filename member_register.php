<?php
session_start();
$current_page = 'member';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
$error = '';
$enc = $con->real_escape_string($_GET['c']);
$col_id = encrypt_decrypt('decrypt',$enc);

$enc_name = $con->real_escape_string($_GET['n']);


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
    $join_women_union_date = $group_id = NULL;
    $role = 3;
    $status = 0;
if ($_POST) {
    foreach ($_POST as $p=>$v) {
        if($p == 'password' && $_POST['do']=='edit'){
            break;
        }
        if(noValidateField($p, ['join_women_union_date', 'join_party_date', 'group_id'])){
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
    $join_local = $con->real_escape_string($_POST['join_local']);
    $join_trade_union_date = $con->real_escape_string($_POST['join_trade_union_date']);
    $group_id = $con->real_escape_string($_POST['group_id']);

    if(!$_POST['join_party_date']==''){
        $join_party_date = $con->real_escape_string($_POST['join_party_date']);
    }

    if(!$_POST['join_women_union_date']==''){
        $join_women_union_date = $con->real_escape_string($_POST['join_women_union_date']);
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
            $col_id,
            $status,
            $role
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
            col_id,
            status,
            role
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $rs = prepared_stm($con, $sql, $data);
        
        if ($rs->affected_rows == 1) {
            $message = '<script type="text/javascript">
            Swal.fire({
                        title:"ສຳເລັດ",
                        position: "top-center", 
                        icon: "success",
                        text: "ຕິດຕໍ່ຄະນະປະຈຳຮາກຖານ ເພື່ອເປີດນຳໃຊ້",
                        button: "ຕົກລົງ",
                    }).then((data)=>{
                        window.location.href = "login.php";
                    });
            </script>';
        } else if ($con->errno == 1062){
            $message = '<script type="text/javascript">
            Swal.fire({
                title: "ຂໍ້ມູນຜູ້ໃຊ້ຊໍ້າກັນ",
                position: "top-center",
                icon: "warning",
                text: "ປ່ຽນຂໍ້ມູນຜູ້ໃຊ້ໃໝ່",
                button: "ລອງໃໝ່",
            }).then(() => {
                //location.reload();
            });
            </script>';
            $isValid['username'] = 'is-invalid';
        
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
    }
}

echo @$message;
?>

<div class="container mt-3 mb-5">

    <h2>ລົງທະບຽນສະມາຊິກກຳມະບານ <?= encrypt_decrypt('decrypt', $enc_name ) ?></h2>

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
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="username">ຊື່ບັນຊີຜູ້ໃຊ້</label>
                            <input onkeyup="checkUser(this.value)" required value="<?= @$username ?>" id="username" type="text" class="form-control <?= @$isValid['username'] ?>" name="username" placeholder="ປ້ອນຊື່ບັນຊີຜູ້ໃຊ້">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">ລະຫັດຜ່ານ</label>
                            <input value="" <?php if(!isset($_GET['member_id'])){echo 'required';} ?> id="password" type="password" class="form-control <?= @$isValid['password'] ?>" name="password" placeholder="ປ້ອນລະຫັດຜ່ານ">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender">ເພດ</label>
                            <select required name="gender" id="gender" class="form-control <?= @$isValid['gender'] ?>">
                                <option value="">ເລືອກເພດ...</option>
                                <option value="ຊາຍ" <?= @$gender == 'ຊາຍ'? 'selected':'' ?>>ຊາຍ</option>
                                <option value="ຍິງ" <?= @$gender == 'ຍິງ'? 'selected':'' ?>>ຍິງ</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="ethnic">ຊົນເຜົ່າ</label>
                        <input required value="<?= @$ethnic ?>" require id="ethnic" type="text" class="form-control <?= @$isValid['ethnic'] ?>" name="ethnic" placeholder="ປ້ອນຊົນເຜົ່າ">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-4">
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
                            <div class="col-md-4">
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
                            <div class="col-md-4">
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
            <div class="col-md-4">
                <h4 class="text-secondary">ຂໍ້ມູນໃນອົງການຈັດຕັ້ງ</h4>
            </div>
            <div class="col-md-8">
                <div class="row mb-3 mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="join_trade_union_date">ວັນທີເຂົ້າກຳມະບານ</label>
                            <input value="<?= @$join_trade_union_date ?>" required id="join_trade_union_date" type="date" class="form-control <?= @$isValid['join_trade_union_date'] ?>" name="join_trade_union_date" placeholder="ປ້ອນວັນທີເຂົ້າກຳມະບານ">
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
                            <input value="<?= @$join_women_union_date ?>" require id="join_women_union_date" type="date" class="form-control" name="join_women_union_date" placeholder="ປ້ອນວັນທີເຂົ້າແມ່ຍິງ">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="book_no">ເລກທີປຶ້ມກຳມະບານ</label>
                            <input value="<?= @$book_no ?>" required id="book_no" type="text" class="form-control <?= @$isValid['book_id'] ?>" name="book_no" placeholder="ປ້ອນເລກທີປຶ້ມ">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="group">ຈຸທີ່ສັງກັດ</label>
                            <select name="group_id" id="group" class="form-control <?= @$isValid['group'] ?>">
                                <option value="0">ເລືອກຈຸສັງກັດ</option>
                                <?php
                                $sql = "SELECT * FROM groups WHERE col_id = " . $col_id;
                                $rs = mysqli_query($con, $sql);
                                while ($row2 = mysqli_fetch_array($rs)) {
                                    echo '<option value="' . $row2['id'] . '"';
                                    echo '>' . $row2['group_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="join_local">ວັນທີຮັບເຂົ້າຮາກຖານ</label>
                            <input value="<?= @$join_local ?>" required id="join_local" type="date" class="form-control <?= @$isValid['book_id'] ?>" name="join_local" placeholder="ປ້ອນວັນທີເຂົ້າຮາກຖານ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <hr class="mt-3 mb-3">

            <button name="do" value="add" class="btn col-xl-3 col-md-6 col-12 btn-primary mt-3">ບັນທຶກ</button>

    </form>
</div>
<?php
require __DIR__ . '/footer.php';
?>

<script>

$('#username').keypress(function(ew) {
        var ew = event.which;
        if (ew == 32) {
            return true;
        }
        if (48 <= ew && ew <= 57)
            return true;
        if (65 <= ew && ew <= 90)
            return true;
        if (97 <= ew && ew <= 122)
            return true;
        return false;
    });

    function checkUser(value){
        console.log(value);
        $.ajax({
            url: "checkUser.php",
            method: "post",
            data: {
                username: value,
            },
            success: function(data) {
                console.log(data);
                if(data == 1){
                    document.getElementById('username').setAttribute('class','form-control is-invalid');
                }else{
                    document.getElementById('username').setAttribute('class','form-control');
                }
                
            }
        });
    }
</script>