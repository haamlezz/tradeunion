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
    <h2>ຈັດການຂໍ້ມູນສະມາຊິກ</h2>

    <?php if (isAdmin() || isCommittee()) : ?>
        <div class="mt-3" style="margin-bottom: 30px;">
            <a href="member_add.php" class="btn btn-primary">ເພີ່ມສະມາຊິກໃໝ່</a>
        </div>
    <?php endif; ?>


    <table id="example" class="table table-hover mt-5">
        <thead>
            <tr>
                <th class="col-1">ລະຫັດ</th>
                <th class="col-4">ຊື່-ນາມສະກຸນ</th>
                <th class="col-1">ເພດ</th>
                <th class="col-2">ສັງກັດ</th>
                <th class="col-3">ໂຕເລືອກ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT mem_id, firstname, lastname, gender, username, role, (SELECT groups.group_name FROM groups WHERE groups.id = member.group_id) AS g_name, status FROM member JOIN groups ON groups.id = member.group_id WHERE groups.col_id = ". $_SESSION['college_id'].";";
        
            $rs = $con->query($sql);
            echo $con->error;
            while ( $row = $rs->fetch_assoc() ) {
                echo '
                    <tr>
                        <td>' . $row['mem_id'] . '</td>
                        <td>' 
                        . $row['firstname'] . ' ' .$row['lastname']. 
                        ' &nbsp; &nbsp; ';

                        switch ($row['role']){
                            case 1: echo '<span class="badge bg-primary">ຄະນະບໍລິຫານ</span>';
                            break;
                            case 2: echo '<span class="badge bg-warning">ຮາກຖານ</span>';
                        }
                echo   '</td>
                        <td>' . $row['gender'] . '</td>
                        <td>' . $row['g_name'] . '</td>
                        <td>
                            <button onclick="getMember(' . $row['mem_id'] . ')" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                ສະແດງ
                            </button>';
                
                    echo '                
                            <a href="member_add.php?member_id=' . $row['mem_id'] . '" class="btn btn-success btn-sm">ແກ້ໄຂ</a>
                    ';
                    if( $row['username']!=$_SESSION['username']){
                        if($row['role'] != 1 || isAdmin()){
                            echo '<a onclick="deleteMember(' . $row['mem_id'] . ')" href="#" class="btn btn-danger btn-sm">ລົບ</a>';
                        }
                    }
                    

                    //<a onclick="deleteMember(' . $row['mem_id'] . ')" href="#" class="btn btn-danger btn-sm">ລົບ</a>

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

    function deleteMember(member_id) {

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
                    url: "member_delete.php",
                    method: "post",
                    data: {
                        member_id: member_id
                    },
                    success: function(data) {
                        if(data == 1){
                            Swal.fire("ບໍ່ສຳເລັດ", "ທ່ານບໍ່ສາມາດລຶບຂໍ້ມູນທ່ານເອງໄດ້", "success", {
                                icon: "warning",
                                position: "top-center", 
                                button: "ຕົກລົງ",
                        });
                    }else if(data == 2){
                        Swal.fire("ບໍ່ສຳເລັດ", "ທ່ານບໍ່ສາມາດລຶບຂໍ້ມູນທ່ານເອງໄດ້", "success", {
                                icon: "warning",
                                position: "top-center", 
                                button: "ຕົກລົງ",
                        });
                    }else{
                        Swal.fire("ສໍາເລັດ", "ຂໍ້ມູນຖືກລືບອອກຈາກຖານຂໍ້ມູນແລ້ວ", "success", {
                            button: "ຕົກລົງ",
                        }).then(()=>{
                            location.reload();
                        });
                    }
                        
                    }
                });
            }
        });



    }
</script>