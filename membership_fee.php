<?php
session_start();
$current_page = 'member';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
if (!islogin()) {header('Location:login.php');}
require_once __DIR__ . '/menu.php';
?>

<div class="container mt-3">
    <h2>ຈັດການຂໍ້ມູນການເສຍຄ່າສະຕິ</h2>

    <?php if (isAdmin() || isCommittee()) : ?>
        <div class="mt-3" style="margin-bottom: 30px;">
            <a href="membership_fee_add.php" class="btn btn-primary">ເພີ່ມຂໍ້ມູນໃໝ່</a>
        </div>
    <?php endif; ?>

    <table id="example" class="table table-hover mt-5">
        <thead>
            <tr>
                <th class="col-1">ລະຫັດ</th>
                <th class="col-4">ຊື່-ນາມສະກຸນ</th>
                <th class="col-2">ວັນທີຊຳລະ</th>
                <th class="col-2">ປະຈຳປີ</th>
                <th class="col-3">ໂຕເລືອກ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT membership_fee.id AS p_id, date_format(membership_fee.pay_date, '%d/%m/%Y') AS p_date, member.firstname, member.lastname, (SELECT yearly_fee.year FROM yearly_fee WHERE yearly_fee.id = membership_fee.fee_id) AS p_year FROM member JOIN membership_fee ON member.mem_id = membership_fee.mem_id JOIN groups ON member.group_id = groups.id WHERE groups.col_id = ". $_SESSION['college_id'] ;
            $rs = $con->query($sql);
            echo $con->error;
            while ( $row = $rs->fetch_assoc() ) {
               echo '<tr>';
                echo '<td>'.$row['p_id'].'</td>';
                echo '<td>'.$row['firstname'].' '.$row['lastname'].'</td>';
                echo '<td>'.$row['p_date'].'</td>';
                echo '<td>'.$row['p_year'].'</td>';
                echo '<td>
                <a class="btn btn-success btn-sm" href="membership_fee_edit.php?id='.$row['p_id'].'">ແກ້ໄຂ</a>
                <a class="btn btn-danger btn-sm" href="#" onclick="deleteMembershipFee(' . $row['p_id'] . ')">ລົບ</a>
            </td>';
               echo '</tr>';
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
                <h5 class="modal-title" id="exampleModalLabel">ຂໍ້ມູນສະມາຊິກ</h5>
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


    function getMember(member_id) {

        $.ajax({
            url: "member_view.php",
            method: "post",
            data: {
                member_id: member_id
            },
            success: function(data) {
                $('#college_detail').html(data);
                $('#exampleModal').modal("show");
            }
        });
    }

    function deleteMembershipFee(id) {

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
                    url: "membership_fee_delete.php",
                    method: "post",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        console.log(data);
                        if(data == 1){
                            Swal.fire("ສຳເລັດ", "ຂໍ້ມູນຖືກລຶບແລ້ວ", "success", {
                                position: "top-center", 
                                button: "ຕົກລົງ",
                        }).then(()=>{
                            window.location.href = "membership_fee.php";
                        });
                    }else{
                        Swal.fire("ບໍ່ສຳເລັດ", "ທ່ານບໍ່ສາມາດລຶບຂໍ້ມູນທ່ານເອງໄດ້", "warning", {
                                icon: "warning",
                                position: "top-center", 
                                button: "ຕົກລົງ",
                        });
                    }
                    }
                });
            }
        });



    }
</script>