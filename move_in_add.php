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

            $sql = "INSERT INTO member_in (col_id, mem_id, doc_no, issue_date) VALUES(?,?,?,?)";

            $rs = prepared_stm($con, $sql, [$_SESSION['college_id'], $mem_id, $doc_no, $issue_date]);
            
            if ($rs->affected_rows == 1) {
                $message = '<script type="text/javascript">
                    Swal.fire({
                                title:"ສຳເລັດ",
                                position: "top-center",
                                icon: "success",
                                text: "ບັນທຶກຂໍ້ມູນສຳເລັດ",
                                button: "ຕົກລົງ",
                            }).then((data)=>{
                                window.location.href = "move_in.php";
                            });
                    </script>';
            }else{
                echo 'wrong';
            }
        }
    }
}


//     if ($_POST['do'] == 'add' && $error == '') {

//         $data = [$act_title, $act_date, $act_location, $act_detail, $total_member_join, $_SESSION['college_id']];

//         $sql = "INSERT INTO activity(act_title, act_date, act_location, act_detail, total_member_join, col_id) VALUES (?,?,?,?,?,?)";

//         $rs = prepared_stm($con, $sql, $data);

//         if ($rs->affected_rows == 1) {
//             
//         } else {
//             
//         }
//     } else if ($_POST['do'] == 'edit' && $error == '') {
//         $activity_id   = $con->real_escape_string($_POST['activity_id']);
//         $data = [$act_title, $act_date, $act_location, $act_detail, $total_member_join, $activity_id, $_SESSION['college_id']];
//         $sql = "UPDATE activity SET act_title=?,act_date=?, act_location=?, act_detail=?, total_member_join=? WHERE id=? AND col_id=? ";
//         $rs = prepared_stm($con, $sql, $data);
//         if ($rs->affected_rows == 1) {
//             $message = '<script type="text/javascript">
//             Swal.fire({
//                         title:"ສຳເລັດ",
//                         position: "top-center",
//                         icon: "success",
//                         text: "ປັບປຸງຂໍ້ມູນສຳເລັດ",
//                         button: "ຕົກລົງ",
//                     }).then((data)=>{
//                         window.location.href = "activity.php";
//                     });
//             </script>';
//         }
//     }
// }

// if ($_GET && isset($_GET['activity_id'])) {
//     if (!isExisted($con, 'id', 'activity', $_GET['activity_id'])) {
//         notFoundPage();
//     }


//     if (!isOwner($_GET['activity_id'])) {
//         restrictPage();
//     }

//     $sql = "SELECT * FROM activity WHERE id = ? AND col_id = ?";
//     $rs = prepared_stm($con, $sql, [$_GET['activity_id'], $_SESSION['college_id']])->get_result();
//     $row = $rs->fetch_assoc();

//     $act_title   = $row['act_title'];
//     $act_location    = $row['act_location'];
//     $act_date  = $row['act_date'];
//     $act_detail     = $row['act_detail'];
//     $total_member_join    = $row['total_member_join'];
// }

echo @$message;
?>

<div class="container mt-3 mb-5">
    <h2>ເພີ່ມຂໍ້ມູນການຍ້າຍເຂົ້າ</h2>

    <?= @$error; ?>

    <form method="post">

        <div class="row mt5">
            <div class="col-4">
                <div class="form-group">
                    <label for="mem_id">ສະມາຊິກ</label>
                    <input value="<?= @$member ?>" required list="list-member" type="text" name="member" id="member" class="form-control" placeholder="ປ້ອນຊື່ນັກສຶກສາ..." autocomplete="off">
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
    $('#member').autocomplete();
</script>