<?php
session_start();
$current_page = 'group';
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
                    <input readonly type="text" class="form-control" name="id" value="" id="groupId">
                </div>
                <div class="form-group mt-3 mb-3">
                    <label for="groupName">ຊື່ຈຸ</label>
                    <input require type="text" name="groupName" id="groupName" class="form-control">
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
                    $sql = "select groups.id, groups.group_name, (select count(*) from member where member.group_id = groups.id) as num_member from groups where col_id = ? ORDER BY groups.group_name;";
                    $rs = prepared_stm($con, $sql, [$_SESSION['college_id']], "i")->get_result();
                    while ($row = $rs->fetch_assoc()) {
                        $str = '
                                <tr>
                                    <td>' . $row['id'] . '</td>
                                    <td>' . $row['group_name'] . '</td>
                                    <td>' . $row['num_member'] . '</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm">ສະແດງ</a>
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


<?php
require __DIR__ . '/footer.php';
?>
<script>
    $('#groupName').keyup(()=>{
        if($('#groupName').val().length  > 0){
            $('#btnAction').prop('disabled',false)
        }else{
            $('#btnAction').prop('disabled',true)
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
                } else if(response == 2) {
                    Swal.fire({
                        title: "ບໍ່ສຳເລັດ",
                        position: "top-center",
                        icon: "warning",
                        text: "ເກີດຂໍ້ຜິດພາດ",
                        button: "ລອງໃໝ່",
                    }).then(() => {
                        location.reload();
                    });
                }else{
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
        $('#btnAction').prop('disabled',false)

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
                            }).then(()=>{
                                location.reload();
                            })
                        } else if(response == 2) {
                            Swal.fire({
                                title: "ບໍ່ສຳເລັດ",
                                position: "top-center",
                                icon: "warning",
                                text: "ເກີດຂໍ້ຜິດພາດ",
                                button: "ລອງໃໝ່",
                            }).then(() => {
                                location.reload();
                            });
                        }else{
                            location.reload();
                        }
                    }
                });
            }
        });
    }

    function doCancel(){
        $('#btnAction').prop('disabled',true)
        document.getElementById("doAction").setAttribute("value", "add");
        document.getElementById("btnAction").innerHTML = "ບັນທຶກ"
        document.getElementById("groupId").setAttribute("value", "");
        document.getElementById("groupName").setAttribute("value", "");
        document.getElementById("btnCancel").setAttribute("class", "btn btn-warning d-none");

    }
</script>