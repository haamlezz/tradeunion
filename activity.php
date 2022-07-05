<?php
session_start();
$current_page = 'college';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
if (!islogin()) {header('Location:login.php');}
require_once __DIR__ . '/menu.php';

?>

<div class="container mt-3">
    <h2>ຈັດການຂໍ້ມູນການເຄື່ອນໄຫວ</h2>

    <?php if (isAdmin() || isCommittee()) : ?>
        <div class="mt-3" style="margin-bottom: 30px;">
            <a href="activity_add.php" class="btn btn-primary">ເພີ່ມການເຄື່ອນໄຫວ</a>
        </div>
    <?php endif; ?>


    <table id="example" class="table table-hover mt-5">
        <thead>
            <tr>
                <th class="col-1">ລະຫັດ</th>
                <th class="col-5">ຫົວຂໍ້</th>
                <th class="col-3">ວັນທີ</th>
                <th class="col-3">ໂຕເລືອກ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id,act_title,date_format(act_date,'%d/%m/%Y') as act_date,col_id FROM activity WHERE col_id = ".$_SESSION['college_id'];
            $rs = $con->query($sql);
            while ($row = $rs->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . $row['id'] . '</td>
                        <td><a href="#" class="text-primary" onclick="getActivity(' . $row['id'] . ')">' . $row['act_title'] . '</a>';
                echo        '<td>' . $row['act_date'] . '</td>
                        <td>
                            <button onclick="getActivity(' . $row['id'] . ')" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                ສະແດງ
                            </button>';
                if ($_SESSION['college_id'] == $row['col_id']) {
                    echo '                
                            <a href="activity_add.php?activity_id=' . $row['id'] . '" class="btn btn-success btn-sm">ແກ້ໄຂ</a>
                            <a onclick="deleteActivity(' . $row['id'] . ')" href="#" class="btn btn-danger btn-sm">ລົບ</a>
                    ';
                }

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