<?php
session_start();
$current_page = 'move';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
if (!islogin()) {header('Location:login.php');}
require_once __DIR__ . '/menu.php';

?>

<div class="container mt-3">
    <h2>ຈັດການຂໍ້ມູນຍ້າຍເຂົ້າ</h2>

    <?php if (isAdmin() || isCommittee()) : ?>
        <div class="mt-3" style="margin-bottom: 30px;">
            <a href="move_in_add.php" class="btn btn-primary">ເພີ່ມຂໍ້ມູນຍ້າຍເຂົ້າ</a>
        </div>
    <?php endif; ?>


    <table id="example" class="table table-hover mt-5">
        <thead>
            <tr>
                <th class="col-1">ລະຫັດ</th>
                <th class="col-4">ຊື່ ນາມສະກຸນ</th>
                <th class="col-2">ເລກທີເອກະສານ</th>
                <th class="col-2">ວັນທີອອກເອກະສານ</th>
                <th class="col-3">ໂຕເລືອກ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT member_in.*, date_format(issue_date, '%d/%m/%Y') AS i_date FROM member_in JOIN member ON member.mem_id = member_in.mem_id WHERE member_in.col_id = ".$_SESSION['college_id'];
            $rs = $con->query($sql);
            echo $con->error;
            while ($row = $rs->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . $row['id'] . '</td>
                        
                        <td>'.$row['firstname'].' '.$row['lastname'].'</td>

                        <td>'.$row['doc_no'].'</td>

                        <td>'.$row['issue_date'].'</td>
                        ';
                        

                echo '</td>
                </tr>';
            }
            ?>
        </tbody>
    </table>
</div><!-- container-->


<!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ຂໍ້ມູນການເຄື່ອນໄຫວ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="college_detail">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ປິດ</button>
            </div>
        </div>
    </div>
</div>


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


    function getActivity(activity_id) {

        $.ajax({
            url: "activity_view.php",
            method: "post",
            data: {
                activity_id: activity_id
            },
            success: function(data) {
                $('#college_detail').html(data);
                $('#exampleModal').modal("show");
            }
        });
    }

    function deleteActivity(activity_id) {

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
                    url: "activity_delete.php",
                    method: "post",
                    data: {
                        activity_id: activity_id
                    },
                    success: function(data) {
                        console.log(data)
                        Swal.fire("ສໍາເລັດ", "ຂໍ້ມູນຖືກລືບອອກຈາກຖານຂໍ້ມູນແລ້ວ", "success", {
                            button: "ຕົກລົງ",
                        }).then(()=>{
                            location.reload();
                        });
                    }
                });
            }
        });



    }
</script>