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

        $feeid = $con->real_escape_string($_POST['feeid']);
        $paydate = date("Y-m-d");
        $id = $con->real_escape_string($_POST['id']);

        if(isset($_POST['pay_date'])){
            $paydate = $_POST['pay_date'];
        }
        
            $sql = "UPDATE membership_fee SET fee_id = ?, pay_date = ? WHERE id = ?";
            $data = [$feeid, $paydate, $id];
            prepared_stm($con, $sql, $data);

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

if($_GET && isset($_GET['id'])){
    $id = $con->real_escape_string($_GET['id']);

    $sql = "SELECT membership_fee.*, member.firstname, member.lastname FROM membership_fee JOIN member ON member.mem_id = membership_fee.mem_id WHERE membership_fee.id = ?";

    $rs = prepared_stm($con, $sql, [$id])->get_result();

    $membership_row = $rs->fetch_assoc();

}

echo @$message;
?>

<div class="container mt-3 mb-5">
    <h2>ປັບປຸງການຈ່າຍຄ່າສະຕິ</h2>

    <?= @$error; ?>

    <form method="post">
            <h3><?=$membership_row['firstname']?> <?=$membership_row['lastname']?></h3>
            <div class="col-4">
                <div class="form-group mt-3">
                    <label for="feeid">ຄ່າສະຕິ</label>
                    <select name="feeid" id="feeid" class="form-control">
                        <?php
                        $sql = "SELECT * from yearly_fee ORDER BY year DESC";
                        $rs = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($rs)) {
                            echo '
                                    <option value="' . $row['id'] .'"';
                            if(@$membership_row['fee_id'] == $row['id']){
                                echo ' selected ';
                            }
                            echo '>' . number_format($row['fee']) . ' ກີບ (ປີ ' . $row['year'] . ')</option>
                                ';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="pay_date">ວັນທີ</label>
                    <input value="<?= @$membership_row['pay_date']?>" class="form-control" type="date" name="pay_date" id="pay_date">
                </div>
                <?php
                if (isset($_GET['id'])) {
                    echo '<input type="hidden" name="id" value="' . $_GET['id'] . '">';
                    echo '<button name="do" value="edit" class="btn btn-primary mt-3">ບັນທຶກການປ່ຽນແປງ</button> &nbsp;';
                    echo '<a href="membership_fee.php" class="btn btn-warning mt-3">ຍົກເລີກ</a>';
                } else {
                    echo '<button name="do" value="add" class="btn btn-primary mt-3">ບັນທຶກ </button>';
                }
                ?>
            </div>
    </form>
</div>
<?php
require __DIR__ . '/footer.php';
?>

<script>
   
</script>