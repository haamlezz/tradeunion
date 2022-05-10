<?php
session_start();
$current_page = 'yearly_fee';
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
    <h2>ຈັດການຂໍ້ມູນຄ່າສະຕິປະຈຳປີ</h2>

    <div class="row">
        <div class="col-md-4" style="border-right:thin #333333 solid;">
            <form action="" method="post">
                <div class="form-group mt-3">
                    <label for="feeid">ລະຫັດ</label>
                    <input readonly type="text" class="form-control" name="feeid" value="" id="feeid">
                </div>
                <div class="form-group mt-3 mb-3">
                    <label for="year">ປີ</label>
                    <input required value="" type="text" name="year" id="year" class="form-control" placeholder="ປ້ອນປີ">
                </div>
                <div class="form-group mt-3 mb-3">
                    <label for="fee">ຄ່າສະຕິ</label>
                    <input required value="" type="text" name="fee" id="fee" class="form-control" placeholder="ປ້ອນຄ່າສະຕິ">
                </div>
                <input type="hidden" name="do" value="add" id="doAction">
                <button id="btnAction" type="button" class="btn btn-primary" onclick="doProcess()">ບັນທຶກ</button>
                <button id="btnCancel" type="button" class="btn btn-warning d-none" onclick="doCancel()">ຍົກເລີກ</button>
            </form>
        </div>
        <div class="col-md-8">
            <table id="example" class="table table-hover mt-5">
                <thead>
                    <tr>
                        <th class="col-1">ລະຫັດ</th>
                        <th class="col-4">ປີ</th>
                        <th class="col-3">ຄ່າສະຕິ</th>
                        <th class="col-4">ໂຕເລືອກ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM yearly_fee";
                    $rs = mysqli_query($con, $sql);
                    while ($row = $rs->fetch_assoc()) {
                        $str = '
                                <tr>
                                    <td>' . $row['id'] . '</td>
                                    <td>' . $row['year'];
                        $str .= '</td>
                                    <td>' . $row['fee'] . '</td>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="#" onclick="editYearlyFee(' . $row['id'] . ',' . $row['year'] . ','.$row['fee'].')">ແກ້ໄຂ</a>
                                        <a class="btn btn-danger btn-sm" href="#" onclick="deleteYearlyFee(' . $row['id'] . ')">ລົບ</a>
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

        /*ແຍກຈຸດຫຼັກພັນ ....*/
        // $('#fee').priceFormat({
        //     prefix: '',
        //     suffix: ' ກີບ',
        //     thounsandsSeparator: ',',
        //     centsLimit: 0
        // });
    });

    function doProcess() {
        var doAction = document.getElementById("doAction").value;
        var feeid = document.getElementById("feeid").value;
        var year = document.getElementById("year").value;
        var fee = document.getElementById("fee").value;

        $.ajax({
            url: "yearly_fee_process.php",
            method: "post",
            data: {
                doAction: doAction,
                feeid: feeid,
                year: year,
                fee: fee
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
                    //location.reload();
                }

            }
        });
    }

    function editYearlyFee(id, year, fee) {
        document.getElementById("doAction").setAttribute("value", "edit");
        document.getElementById("btnAction").innerHTML = "ປັບປຸງ"
        document.getElementById("feeid").setAttribute("value", id);
        document.getElementById("year").setAttribute("value", year);
        document.getElementById("fee").setAttribute("value", fee);
        document.getElementById("btnCancel").setAttribute("class", "btn btn-warning");
    }

    function deleteYearlyFee(id) {
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