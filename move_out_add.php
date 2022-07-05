<?php
session_start();
$current_page = 'move';
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

if ($_GET && !isAdmin() && !isCommittee()) {
    restrictPage();
}

require __DIR__ . '/menu.php';

$error = '';
$message = '';

/**
 * Add College
 */
if ($_POST) {
    foreach ($_POST as $p) {
        if (ctype_space($p) || empty($p)) {
            $error = '<div class="alert alert-info">ກະລຸນາຕື່ມຂໍ້ມູນໃຫ້ຄົບທຸກຫ້ອງ</div>';
            break;
        }
    }

    $member = $con->real_escape_string($_POST['member']);
    $doc_no = $con->real_escape_string($_POST['doc_no']);
    $issue_date = $con->real_escape_string($_POST['issue_date']);

    $member_r = explode(" ", $member);

    if (count($member_r) != 2) {
        $error = '<div class="alert alert-warning">ກະລຸນາພິມຊື່ໃຫ້ຖືກຕ້ອງ</div>';
    }

    if ($error == '') {
        $sql = "SELECT mem_id FROM member WHERE firstname = ? AND lastname = ?";

        $rs = prepared_stm($con, $sql, $member_r)->get_result();

        if ($rs->num_rows != 1) {
            $message = '<script type="text/javascript">
            Swal.fire({
                title: "ບໍ່ພົບຂໍ້ມູນສະມາຊິກ",
                position: "top-center",
                icon: "warning",
                text: "ກະລຸນາພິມຊື່ຄືນໃໝ່ໃຫ້ຖືກຕ້ອງ",
                button: "ລອງໃໝ່",
            })
            </script>';
        } else {
            $row = $rs->fetch_assoc();
            $mem_id = $row['mem_id'];

            $sql0 = "SELECT MAX(DATE_FORMAT(pay_date, '%Y')) AS latest_year FROM membership_fee WHERE mem_id = $mem_id";
            $rs0 = mysqli_query($con, $sql0);
            $row0 = mysqli_fetch_assoc($rs0);

            $latest_year = $row0['latest_year'];

            switch ($_POST['do']) {
                case 'add':
                    
                    $sql_insert = "INSERT INTO member_out (col_id, mem_id, doc_no, issue_date, latest_paid_year) VALUES(?,?,?,?,?)";
                    $data_insert = [$_SESSION['college_id'], $mem_id, $doc_no, $issue_date, $latest_year];
                    $rs_insert = prepared_stm($con, $sql_insert, $data_insert );
                    if($rs_insert->errno == 1048){
                        $message = '<script type="text/javascript">
                            Swal.fire({
                                title: "ຜິດພາດ",
                                position: "top-center",
                                icon: "warning",
                                text: "ຜູ້ກ່ຽວຍັງບໍ່ທັນຊຳລະຄ່າສະຕິ",
                                button: "ລອງໃໝ່",
                            })
                            </script>';
                    }
                    if ($rs_insert->affected_rows == 1) {

                        $sql = "UPDATE member SET member.status=2 WHERE mem_id=?";
                        $rs = prepared_stm($con, $sql, [$mem_id]);

                        $message = '<script type="text/javascript">
                            Swal.fire({
                                        title:"ສຳເລັດ",
                                        position: "top-center",
                                        icon: "success",
                                        text: "ບັນທຶກຂໍ້ມູນສຳເລັດ",
                                        button: "ຕົກລົງ",
                                    }).then((data)=>{
                                        window.location.href = "move_out.php";
                                    });
                            </script>';
                    }
                    break;

                case 'edit':
                    $sql = "UPDATE member_out SET doc_no=?, issue_date=?, mem_id=? WHERE id=?";
                    $rs = prepared_stm($con, $sql, [$doc_no, $issue_date, $mem_id, $_POST['id']]);
                    
                    if ($rs->affected_rows == 1) {
                        $message = '<script type="text/javascript">
                            Swal.fire({
                                        title:"ສຳເລັດ",
                                        position: "top-center",
                                        icon: "success",
                                        text: "ບັນທຶກຂໍ້ມູນສຳເລັດ",
                                        button: "ຕົກລົງ",
                                    }).then((data)=>{
                                        window.location.href = "move_out.php";
                                    });
                            </script>';
                    } else {
                        $message = '<script type="text/javascript">
                            Swal.fire({
                                title: "ຜິດພາດ",
                                position: "top-center",
                                icon: "warning",
                                text: "ມີບາງຢ່າງຜິດພາດ",
                                button: "ລອງໃໝ່",
                            }).then((data)=>{
                                window.location.href = "move_out.php";
                            });
                            </script>';
                    }
            }
        }
    }
}

if ($_GET && isset($_GET['id'])) {
    if (!isExisted($con, 'id', 'member_out', $_GET['id'])) {
        notFoundPage();
    }

    $sql = "SELECT member_out.*, CONCAT(member.firstname, ' ', member.lastname) AS fullname FROM member_out JOIN member ON member.mem_id = member_out.mem_id WHERE id = ?";
    $rs = prepared_stm($con, $sql, [$_GET['id']])->get_result();
    $row = $rs->fetch_assoc();

    $member = $row['fullname'];
    $doc_no = $row['doc_no'];
    $issue_date = $row['issue_date'];
}

echo @$message;
?>

<div class="container mt-3 mb-5">
    <h2>ເພີ່ມຂໍ້ມູນການຍ້າຍອອກ</h2>

    <?= @$error; ?>
    <form method="post">
        <div class="row mt5">
            <div class="col-4">
                <div class="form-group">
                    <label for="mem_id">ສະມາຊິກ</label>
                    <input value="<?= @$member ?>" required list="list-member" type="text" name="member" id="member" class="form-control" placeholder="ປ້ອນຊື່ສະມາຊິກ..." autocomplete="off">
                    <?php listMemberAutoComplete($con, 'list-member'); ?>
                    <datalist id="list-example">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="doc_no">ເລກທີເອກະສານ</label>
                    <input value="<?= @$doc_no ?>" required type="text" name="doc_no" id="doc_no" class="form-control" placeholder="ປ້ອນເລກທີເອກະສານ">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="issue_date">ວັນທີອອກເອກະສານ</label>
                    <input value="<?= @$issue_date ?>" required type="date" name="issue_date" id="issue_date" class="form-control" placeholder="ປ້ອນວັນທີເອກະສານ">
                </div>
            </div>

        </div>
        <?php
        if (isset($_GET['id'])) {
            echo '<input type="hidden" name="id" value="' . $_GET['id'] . '">';
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
    $('#member').autocomplete();
</script>