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
        $feeid = $con->real_escape_string($_POST['feeid']);
        $paydate = date("Y-m-d");
        if(isset($_POST['pay_date'])){
            $paydate = $_POST['pay_date'];
        }
        

        foreach ($_POST['mem_id'] as $m) {
            $sql = "INSERT INTO membership_fee (mem_id, fee_id, pay_date) VALUE(?,?,?)";
            $data = [$m, $feeid, $paydate];
            prepared_stm($con, $sql, $data);
        }

        $message = '<script type="text/javascript">
        Swal.fire({
            title: "ສຳເລັດ",
            position: "top-center",
            icon: "success",
            text: "ບັນທຶກຂໍ້ມູນສຳເລັດ",
            button: "ຕົກລົງ",
        }).then((data)=>{
            window.location.href = "membership_fee.php";
        });
        </script>';
    }
}

echo @$message;
?>

<div class="container mt-3 mb-5">
    <h2>ເພີ່ມຂໍ້ມູນການເສຍຄ່າສະຕິປະຈຳປີ</h2>

    <?= @$error; ?>

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

                        $sql = "SELECT member.mem_id, member.firstname, member.lastname FROM member JOIN groups ON groups.id = member.group_id WHERE groups.col_id = " . $_SESSION['college_id'];
                        $rs = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($rs)) {
                            $sql1 = "SELECT count(membership_fee.id) AS match_id FROM membership_fee JOIN yearly_fee ON membership_fee.fee_id = yearly_fee.id WHERE mem_id = " . $row['mem_id'] . " AND yearly_fee.year = $current_year";
                            $rs1 = mysqli_query($con, $sql1);
                            echo mysqli_error($con);
                            $row1 = mysqli_fetch_assoc($rs1);
                            if ($row1['match_id'] == 0) {
                                echo '
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="mem_id[]" value="' . $row['mem_id'] . '"></td>
                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                                </tr>
                            ';
                            }
                            //if($row['mem_id'] == )
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-4 offset-1">
                <div class="form-group">
                    <label for="group_id">ຈຸ</label>
                    <select name="group_id" id="group_id" class="form-control">
                        <option value="*">ສະແດງທັງໝົດ</option>
                        <?php
                        $sql = "SELECT * from groups WHERE col_id = " . $_SESSION['college_id'];
                        $rs = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($rs)) {
                            echo '
                                    <option value="' . $row['id'] . '">' . $row['group_name'] . '</option>
                                ';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="feeid">ຄ່າສະຕິ</label>
                    <select name="feeid" id="feeid" class="form-control">
                        <?php
                        $sql = "SELECT * from yearly_fee ORDER BY year DESC";
                        $rs = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($rs)) {
                            echo '
                                    <option value="' . $row['id'] . '">' . number_format($row['fee']) . ' ກີບ (ປີ ' . $row['year'] . ')</option>
                                ';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="pay_date">ວັນທີ</label>
                    <input class="form-control" type="date" name="pay_date" id="pay_date">
                </div>
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
    $("#group_id").change(function() {
        var id = $(this).find("option:selected").attr("value");
        var fee_id = $("#feeid").find("option:selected").attr("value");
        $.ajax({
            url: "membership_fee_update_list.php",
            method: "post",
            data: {
                id: id,
                fee_id: fee_id,
            },
            success: function(response) {
                //$("#memberList").html = response;
                document.getElementById("memberList").innerHTML = response;
            }
        });
    });


    $("#feeid").change(function() {
        var id = $("#group_id").find("option:selected").attr("value");
        var fee_id = $(this).find("option:selected").attr("value");
        $.ajax({
            url: "membership_fee_update_list.php",
            method: "post",
            data: {
                id: id,
                fee_id: fee_id,
            },
            success: function(response) {
                //$("#memberList").html = response;
                document.getElementById("memberList").innerHTML = response;
            }
        });
    });

    $("window").ready(function() {
        var id = $("#group_id").find("option:selected").attr("value");
        var fee_id = $("#feeid").find("option:selected").attr("value");
        $.ajax({
            url: "membership_fee_update_list.php",
            method: "post",
            data: {
                id: id,
                fee_id: fee_id,
            },
            success: function(response) {
                //$("#memberList").html = response;
                document.getElementById("memberList").innerHTML = response;
            }
        });
    });


    $("body").on("click","#triggerCheck",function() {
        var state = $(this).prop("checked");
        if (state == true) {
            $("tbody").find("input:checkbox").prop("checked", true);
        } else {
            $("tbody").find("input:checkbox").prop("checked", false);
        }
    });
</script>