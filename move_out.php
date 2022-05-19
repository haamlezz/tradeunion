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
if(isMember()) restrictPage();
require_once __DIR__ . '/menu.php';

?>

<div class="container mt-3">
    <h2>ຈັດການຂໍ້ມູນຍ້າຍອອກ</h2>

    <?php if (isAdmin() || isCommittee()) : ?>
        <div class="mt-3" style="margin-bottom: 30px;">
            <a href="move_out_add.php" class="btn btn-primary">ເພີ່ມຂໍ້ມູນຍ້າຍອອກ</a>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
    <table id="example" class="table table-hover mt-5">
        <thead>
            <tr>
                <th class="col-1">ລະຫັດ</th>
                <th class="col-3">ຊື່ ນາມສະກຸນ</th>
                <th class="col-2">ເລກທີເອກະສານ</th>
                <th class="col-2">ວັນທີອອກເອກະສານ</th>
                <th class="col-2">ຄ່າສະຕິຫຼ້າສຸດ</th>
                <th class="col-2">ໂຕເລືອກ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT member_out.*, CONCAT(member.firstname, ' ', member.lastname) AS fullname, date_format(issue_date, '%d/%m/%Y') AS i_date FROM member_out JOIN member ON member.mem_id = member_out.mem_id WHERE member_out.col_id = " . $_SESSION['college_id'];
            $rs = $con->query($sql);
            echo $con->error;
            while ($row = $rs->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . $row['id'] . '</td>
                        
                        <td>' . $row['fullname'] . '</td>

                        <td>' . $row['doc_no'] . '</td>

                        <td>' . $row['i_date'] . '</td>
                        
                        <td>'. $row['latest_paid_year'] .'</td>
                        ';

                echo '<td>';
                if ($_SESSION['college_id'] == $row['col_id']) {
                    echo '                
                            <a href="move_out_add.php?id=' . $row['id'] . '" class="btn btn-success btn-sm">ແກ້ໄຂ</a>
                            <a onclick="deleteMoveOut(' . $row['id'] . ')" href="#" class="btn btn-danger btn-sm">ລົບ</a>
                    ';
                }

                echo '</td>
                </tr>';
            }
            ?>
        </tbody>
    </table>
    </div>
</div><!-- container-->


<?php
require __DIR__ . '/footer.php';
?>

<script>
    $(document).ready(function() {
        $('#example').DataTable();

        // /*ແຍກຈຸດຫຼັກພັນ ....*/
        // $('#incentive').priceFormat({
        //     prefix: '',
        //     suffix: ' ກີບ',
        //     thounsandsSeparator: ',',
        //     centsLimit: 0
        // });
    });

    function deleteMoveOut(id) {

        Swal.fire({
            title: "ຕ້ອງການລືບແທ້ ຫຼື ບໍ່?",
            text: "ທ່ານຈະບໍ່ສາມາດກູ້ຂໍ້ມູນຄືນໄດ້!",
            icon: "warning",
            showDenyButton: true,
            confirmButtonText: 'ຕົກລົງ',
            denyButtonText: 'ບໍ່',
            dangerMode: true,
            buttons: ['ຍົກເລີກ', 'ຕົກລົງ']
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                console.log("delete")
                $.ajax({
                    url: "move_out_delete.php",
                    method: "post",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        console.log(data)
                        Swal.fire("ສໍາເລັດ", "ຂໍ້ມູນຖືກລືບອອກຈາກຖານຂໍ້ມູນແລ້ວ", "success", {
                            button: "ຕົກລົງ",
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });



    }
</script>