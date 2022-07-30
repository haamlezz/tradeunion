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
    if (!isset($_POST['mem_id'])) {
        $message = '<script type="text/javascript">
        Swal.fire({
            title: "ບໍ່ສຳເລັດ",
            position: "top-center",
            icon: "warning",
            text: "ທ່ານຍັງບໍ່ທັນໄດ້ເລືອກສະມາຊິກ",
            button: "ລອງໃໝ່",
        })
        </script>';
    } else {
        print_r($_POST);
        $count = 1;
        foreach ($_POST['mem_id'] as $m) {

            $sql0 = "SELECT MAX(DATE_FORMAT(pay_date, '%Y')) AS latest_year FROM membership_fee WHERE mem_id = $m";
            $rs0 = mysqli_query($con, $sql0);
            $row0 = mysqli_fetch_assoc($rs0);

            $latest_year = $row0['latest_year'];

            $doc_no = $count++ .'-'. date('dmy').'/ກມບ';
            
            $sql_insert = "INSERT INTO member_out (col_id, mem_id, doc_no, issue_date, latest_paid_year) VALUES(?,?,?,CURDATE(),?)";
            $data_insert = [$_SESSION['college_id'], $m, $doc_no, $latest_year];
            $rs_insert = prepared_stm($con, $sql_insert, $data_insert );
            echo $con->error;
                if ($rs_insert->errno == 1048) {
                    $error = '<script type="text/javascript">
                Swal.fire({
                    title: "ບໍ່ສຳເລັດ",
                    position: "top-center",
                    icon: "warning",
                    text: "ມີບາງຄົນຍັງບໍ່ທັນເສຍຄ່າສະຕິ",
                    button: "ລອງໃໝ່",
                })
                </script>';
            return;
                }   
        }
    }

    if ($error == '') {
        $message = '<script type="text/javascript">
                Swal.fire({
                    title: "ສຳເລັດ",
                    position: "top-center",
                    icon: "success",
                    text: "ບັນທຶກຂໍ້ມູນສຳເລັດ",
                    button: "ຕົກລົງ",
                }).then((data)=>{
                    // window.location.href = "membership_fee.php";
                });
        </script>';
    }
}

?>

<div class="container mt-3 mb-5">
    <h2>ເພີ່ມຂໍ້ມູນການຍ້າຍອອກ</h2>

    <?= @$error; ?>
    <?= @$message; ?>
    <form method="post">

        <div class="row mt-5">
            <div class="col-7" id="memberList">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-3"><input type="checkbox" name="triggerCheck" id="triggerCheck"> <label for="triggerCheck">ເລືອກທັງໝົດ</label></th>
                            <th>ລາຍຊື່ສະມາຊິກ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $current_year = date("Y");

                        $sql = "SELECT member.mem_id, member.firstname, member.lastname FROM member WHERE col_id = " . $_SESSION['college_id'] ." AND mem_id NOT IN (SELECT member_out.mem_id FROM member_out WHERE member_out.mem_id = member.mem_id)";
                        $rs = mysqli_query($con, $sql);
                        echo mysqli_error($con);
                        while ($row = mysqli_fetch_assoc($rs)) {

                            echo '
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="mem_id[]" value="' . $row['mem_id'] . '"></td>
                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                                </tr>
                            ';

                            //if($row['mem_id'] == )
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-4 offset-1">
                <?php
                if (isset($_GET['activity_id'])) {
                    echo '<input type="hidden" name="activity_id" value="' . $_GET['activity_id'] . '">';
                    echo '<button name="do" value="edit" class="btn btn-primary mt-3">ບັນທຶກການປ່ຽນແປງ</button> &nbsp;';
                    echo '<a href="activity.php" class="btn col-1 btn-warning mt-3">ຍົກເລີກ</a>';
                } else {
                    echo '<button name="do" value="add" class="btn btn-primary mt-3">ບັນທຶກ </button>';
                }
                ?>
            </div>
        </div>



    </form>
</div>
<?php
require __DIR__ . '/footer.php';
?>

<script>
    $("body").on("click", "#triggerCheck", function() {
        var state = $(this).prop("checked");
        if (state == true) {
            $("tbody").find("input:checkbox").prop("checked", true);
        } else {
            $("tbody").find("input:checkbox").prop("checked", false);
        }
    });
</script>