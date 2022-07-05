<?php
session_start();
$current_page = 'activity';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
if (!islogin()) {
    header('Location:login.php');
}

if (isMember() && !$_GET) {
    restrictPage();
}

if($_GET && !isAdmin() && !isCommittee()){
    restrictPage();
}


require __DIR__ . '/menu.php';

$error = '';

/**
 * Add College
 */
if ($_POST) {
    $act_title   = $con->real_escape_string($_POST['act_title']);
    $act_date    = $con->real_escape_string($_POST['act_date']);
    $act_location  = $con->real_escape_string($_POST['act_location']);
    $act_detail     = $_POST['act_detail'];
    $total_member_join     = $con->real_escape_string($_POST['total_member_join']);

    foreach($_POST as $p){
        if(ctype_space($p) || empty($p)){
            $error = '<div class="alert alert-info">ກະລຸນາຕື່ມຂໍ້ມູນໃຫ້ຄົບທຸກຫ້ອງ</div>';
            break;
        }
    }


    if ($_POST['do'] == 'add' && $error == '') {
        
        $data = [$act_title, $act_date, $act_location, $act_detail, $total_member_join, $_SESSION['college_id']];

        $sql = "INSERT INTO activity(act_title, act_date, act_location, act_detail, total_member_join, col_id) VALUES (?,?,?,?,?,?)";

        $rs = prepared_stm($con, $sql, $data);

        if ($rs->affected_rows == 1) {
            $message = '<script type="text/javascript">
            Swal.fire({
                        title:"ສຳເລັດ",
                        position: "top-center",
                        icon: "success",
                        text: "ບັນທຶກຂໍ້ມູນສຳເລັດ",
                        button: "ຕົກລົງ",
                    }).then((data)=>{
                        window.location.href = "activity.php";
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
                location.reload();
            });
            </script>';
        }
    } else if ($_POST['do'] == 'edit' && $error == '') {
        $activity_id   = $con->real_escape_string($_POST['activity_id']);
        $data = [$act_title, $act_date, $act_location, $act_detail, $total_member_join, $activity_id, $_SESSION['college_id']];
        $sql = "UPDATE activity SET act_title=?,act_date=?, act_location=?, act_detail=?, total_member_join=? WHERE id=? AND col_id=? ";
        $rs = prepared_stm($con, $sql, $data);
        if ($rs->affected_rows == 1) {
            $message = '<script type="text/javascript">
            Swal.fire({
                        title:"ສຳເລັດ",
                        position: "top-center",
                        icon: "success",
                        text: "ປັບປຸງຂໍ້ມູນສຳເລັດ",
                        button: "ຕົກລົງ",
                    }).then((data)=>{
                        window.location.href = "activity.php";
                    });
            </script>';
        }
    }
}

if ($_GET && isset($_GET['activity_id'])) {
    if(!isExisted($con, 'id', 'activity', $_GET['activity_id'])){
        notFoundPage();
    }


    $sql = "SELECT * FROM activity WHERE id = ? AND col_id = ?";
        $rs = prepared_stm($con, $sql, [$_GET['activity_id'], $_SESSION['college_id']])->get_result();
        $row = $rs->fetch_assoc();

        $act_title   = $row['act_title'];
        $act_location    = $row['act_location'];
        $act_date  = $row['act_date'];
        $act_detail     = $row['act_detail'];
        $total_member_join    = $row['total_member_join'];
        
        if(!isOwner($row['col_id']))restrictPage();
}

echo @$message;
?>

<div class="container mt-3 mb-5">
    <h2>ເພີ່ມຂໍ້ມູນຮາກຖານ</h2>

    <?= @$error; ?>

    <form method="post">

        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <label for="act_title">ຫົວຂໍ້</label>
                    <input required value="<?= @$act_title ?>" require id="act_title" type="text" class="form-control" name="act_title" placeholder="ປ້ອນຫົວຂໍ້ການເຄື່ອນໄຫວ">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="act_date">ວັນທີເຄື່ອນໄຫວ</label>
                    <input required value="<?= @$act_date ?>" require id="act_date" type="date" class="form-control" name="act_date" placeholder="ປ້ອນ ເດືອນ/ວັນ/ປີ">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-9">
                <div class="form-group">
                    <label for="act_location">ສະຖານທີ່ປະກອບສ່ວນການເຄື່ອນໄຫວ</label>
                    <input required value="<?= @$act_location ?>" require id="act_location" type="text" class="form-control" name="act_location" placeholder="ປ້ອນສະຖານທີ່">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="total_member_join">ຈຳນວນສະມາຊິກທີ່ເຂົ້າຮ່ວມ</label>
                    <input required value="<?= @$total_member_join ?>" require id="total_member_join" type="number" class="form-control" name="total_member_join" placeholder="ປ້ອນຈຳນວນສະມາຊິກເຂົ້າຮ່ວມ">
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="act_detail">ລາຍລະອຽດການເຄື່ອນໄຫວ</label>
            <textarea name="act_detail" id="act_detail" cols="30" rows="10" class="form-control"><?= @$act_detail ?></textarea>
        </div>
        <?php
        if (isset($_GET['activity_id'])) {
            echo '<input type="hidden" name="activity_id" value="' . $_GET['activity_id'] . '">';
            echo '<button name="do" value="edit" class="btn col-2 btn-primary mt-3">ບັນທຶກການປ່ຽນແປງ</button> &nbsp;';
            echo '<a href="activity.php" class="btn col-1 btn-warning mt-3">ຍົກເລີກ</a>';
        } else {
            echo '<button name="do" value="add" class="btn col-2 btn-primary mt-3">ບັນທຶກ</button>';
        }
        ?>

    </form>
</div>
<?php
require __DIR__ . '/footer.php';
?>

<script>
    tinymce.init({
        selector: 'textarea', // change this value according to your HTML
        plugins: 'a_tinymce_plugin',
        a_plugin_option: true,
        a_configuration_option: 400
    });
</script>