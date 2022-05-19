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
    <h2>ຈັດການຂໍ້ມູນຮາກຖານ</h2>

    <?php if (isAdmin()) : ?>
        <div style="margin-bottom: 30px;">
            <a href="college_add.php" class="btn btn-primary">ເພີ່ມຮາກຖານໃໝ່</a>
        </div>
    <?php endif; ?>


    <table id="example" class="table table-hover mt-5">
        <thead>
            <tr>
                <th class="col-1">ລະຫັດ</th>
                <th class="col-5">ຊື່ຮາກຖານ</th>
                <th class="col-3">ໂທ</th>
                <th class="col-3">ໂຕເລືອກ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT col_id,col_name,tel FROM college";
            $rs = $con->query($sql);
            while ($row = $rs->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . $row['col_id'] . '</td>
                        <td>' . $row['col_name'] . '</td>
                        <td>' . $row['tel'] . '</td>
                        <td>
                            <button onclick="getCollege(' . $row['col_id'] . ')" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                ສະແດງ
                            </button>';
                if (isAdmin() || $_SESSION['college_id'] == $row['col_id']) {
                    echo '                
                            <a href="college_add.php?college_id=' . $row['col_id'] . '" class="btn btn-success btn-sm">ແກ້ໄຂ</a>
                    ';
                }

                if (isAdmin()) {
                    echo '                
                            <a onclick="deleteCollege(' . $row['col_id'] . ')" href="#" class="btn btn-danger btn-sm">ລົບ</a>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ຂໍ້ມູນຮາກຖານ</h5>
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


    function getCollege(college_id) {

        $.ajax({
            url: "college_view.php",
            method: "post",
            data: {
                college_id: college_id
            },
            success: function(data) {
                $('#college_detail').html(data);
                $('#exampleModal').modal("show");
            }
        });
    }

    function deleteCollege(college_id) {

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
                    url: "college_delete.php",
                    method: "post",
                    data: {
                        college_id: college_id
                    },
                    success: function(data) {

                        Swal.fire("ສໍາເລັດ", "ຂໍ້ມູນຖືກລືບອອກຈາກຖານຂໍ້ມູນແລ້ວ", "success", {
                            button: "ຕົກລົງ",
                        }).then((data)=>{
                            location.reload();
                        });
                    }
                });
            }
        });



    }
</script>