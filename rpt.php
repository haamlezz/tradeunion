<?php
session_start();
if($_GET || isset($_GET['page'])):
$current_page = 'college';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
if (!islogin()) {header('Location:login.php');}
require_once __DIR__ . '/menu.php';
?>

<div class="container mt-3">
    <h2><?= getReport($_GET['page']) ?></h2>
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

<?php endif;?>