<?php
session_start();
$current_page = 'college';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
if (!islogin()) {
    header('Location:login.php');
}
require __DIR__ . '/menu.php';
?>

<div class="container mt-3">
    <h2>ຈັດການຂໍ້ມູນຈຸ</h2>

    <div class="row">
        <div class="col-md-4" style="border-right:thin #333333 solid;">
            <form action="" method="post">
                <div class="form-group mt-3">
                    <label for="groupId">ລະຫັດ</label>
                    <input readonly type="text" class="form-control" name="id" value="" id="groupId" placeholder="ລະຫັດຈຸ (ບໍ່ຈຳເປັນປ້ອນ)">
                </div>
                <div class="form-group mt-3 mb-3">
                    <label for="groupName">ຊື່ຈຸ</label>
                    <input required type="text" name="groupName" id="groupName" class="form-control" placeholder="ປ້ອນຊື່ຈຸ" value="">
                </div>

                <input type="hidden" name="do" value="add" id="doAction">
                <button disabled="" id="btnAction" type="button" class="btn btn-primary" onclick="doProcess()">ບັນທຶກ</button>
                <button id="btnCancel" type="button" class="btn btn-warning d-none" onclick="doCancel()">ຍົກເລີກ</button>
            </form>
        </div>
        <div class="col-md-8">
            <table id="example" class="table table-hover mt-5">
                <thead>
                    <tr>
                        <th class="col-1">ລະຫັດ</th>
                        <th class="col-4">ຊື່ຈຸ</th>
                        <th class="col-3">ຈຳນວນສະມາຊິກ</th>
                        <th class="col-4">ໂຕເລືອກ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT 
                            (SELECT college.col_name FROM college WHERE college.col_id = groups.col_id) AS c_name,
                            groups.id, 
                            groups.group_name, 
                            (select count(*) FROM member WHERE member.group_id = groups.id) AS num_member 
                            FROM groups  WHERE col_id = " . $_SESSION['college_id'];
                        
                    $rs = mysqli_query($con, $sql);
                    while ($row = $rs->fetch_assoc()) {
                        $str = '
                                <tr>
                                    <td>' . $row['id'] . '</td>
                                    <td>' . $row['group_name'].'</td>
                                    <td>' . $row['num_member'] . '</td>
                                    <td>
                                        <button onclick="getMembers(' . $row['id'] . ')" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            ສະແດງ
                                        </button>
                                        <a class="btn btn-success btn-sm" href="#" onclick="editGroup(' . $row['id'] . ',\'' . $row['group_name'] . '\')">ແກ້ໄຂ</a>
                                        <a class="btn btn-danger btn-sm" href="#" onclick="deleteGroup(' . $row['id'] . ')">ລົບ</a>
                                    </td>
                                </tr>
                            ';
                        echo $str;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
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

    function getMembers(group_id) {

        $.ajax({
            url: "group_view.php",
            method: "post",
            data: {
                group_id: group_id
            },
            success: function(data) {
                $('#college_detail').html(data);
                $('#exampleModal').modal("show");
            }
        });
    }


    $('#groupName').keyup(() => {
        if ($('#groupName').val().length > 0) {
            $('#btnAction').prop('disabled', false)
        } else {
            $('#btnAction').prop('disabled', true)
        }
    })

    function doProcess() {
        var doAction = document.getElementById("doAction").value;
        var groupId = document.getElementById("groupId").value;
        var groupName = document.getElementById("groupName").value;

        $.ajax({
            url: "group-process.php",
            method: "post",
            data: {
                groupId: groupId,
                doAction: doAction,
                groupName: groupName
            },
            success: function(response) {
                console.log(response)
                if (response == 1) {
                    Swal.fire({
                        title: "ສຳເລັດ",
                        position: "top-center",
                        icon: "success",
                        text: "ບັນທຶກຂໍ້ມູນສຳເລັດ",
                        button: "ຕົກລົງ",
                    }).then(() => {
                        location.reload();
                    });
                } else if (response == 2) {
                    Swal.fire({
                        title: "ບໍ່ສຳເລັດ",
                        position: "top-center",
                        icon: "warning",
                        text: "ເກີດຂໍ້ຜິດພາດ",
                        button: "ລອງໃໝ່",
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    location.reload();
                }

            }
        });
    }

    function editGroup(id, groupName) {
        document.getElementById("doAction").setAttribute("value", "edit");
        document.getElementById("btnAction").innerHTML = "ປັບປຸງ"
        document.getElementById("groupId").setAttribute("value", id);
        document.getElementById("groupName").setAttribute("value", groupName);
        document.getElementById("btnCancel").setAttribute("class", "btn btn-warning");
        $('#btnAction').prop('disabled', false)

    }

    function deleteGroup(id) {
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
                $.ajax({
                    url: "group-process.php",
                    method: "post",
                    data: {
                        groupId: id,
                        doAction: 'delete'
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == 0) {
                            Swal.fire("ສໍາເລັດ", "ຂໍ້ມູນຖືກລືບອອກຈາກຖານຂໍ້ມູນແລ້ວ", "success", {
                                button: "ຕົກລົງ",
                            }).then(() => {
                                location.reload();
                            })
                        } else if (response == 2) {
                            Swal.fire({
                                title: "ບໍ່ສຳເລັດ",
                                position: "top-center",
                                icon: "warning",
                                text: "ເກີດຂໍ້ຜິດພາດ",
                                button: "ລອງໃໝ່",
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            location.reload();
                        }
                    }
                });
            }
        });
    }

    function doCancel() {
        $('#btnAction').prop('disabled', true)
        document.getElementById("doAction").setAttribute("value", "add");
        document.getElementById("btnAction").innerHTML = "ບັນທຶກ"
        document.getElementById("groupId").setAttribute("value", "");
        document.getElementById("groupName").setAttribute("value", "");
        document.getElementById("btnCancel").setAttribute("class", "btn btn-warning d-none");

    }
</script>