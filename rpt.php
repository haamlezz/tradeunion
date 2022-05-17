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
$page = $_GET['page'];
?>

<div class="container-fluid mt-3 mb-3">
    <center><img class="d-none d-print-block" width="60" src="image/emblem_of_laos.png" alt="ກາກຳມະບານ" srcset=""></center>
    <p class="text-center d-none d-print-block">
        ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ
        <br>
        ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ
    </p>
    <div class="d-none d-print-block">    
        <p class="d-flex justify-content-between">
            <span>ສະຫະພັນກຳມະບານ ກະຊວງສຶກສາທິການ ແລະ ກິລາ<br>
            ສະຫະພັນກຳມະບານ ການສຶກສາພາກເອກະຊົນ</span>

            <span class="text-end">
                <br>ເລກທີ........./ກບ.ສກອ<br>
                <?php 
                    $month = ['',
                        'ມັງກອນ','ກຸມພາ','ມີນາ','ເມສາ','ພຶດສະພາ','ມິຖຸນາ','ກໍລະກົດ','ສິງຫາ',
                        'ກັນຍາ','ຕຸລາ','ພະຈິງ','ທັນວາ',
                    ]
                ?>
                ນະຄອນຫຼວງວຽງຈັນ, ວັນທີ <?= date('d').'/'.$month[date('n')].'/'.date('Y'); ?>
            </span>
        </p>
    </div>
    <h2 class="text-center">
        <?= getReport($page) ?>
        <?php
            if(isset($_GET['year']) AND $_GET['year']!=''){
                echo 'ປີ '.$_GET['year'];
            }else if(@$_GET['year']){
                echo 'ປີ '.date('Y');
            }
        ?>
    </h2>
<div class="text-end mb-3">
<button onclick="window.print();" class="btn btn-warning d-print-none text-end"><i class="fa-solid fa-print"></i> &nbsp; ສັ່ງພິມ</button>
</div>
<?php
    $count = 1;
    $total=$female = 0;

    if($page == 'college'){
        $rs = mysqli_query($con, getReportQuery($page));
        echo mysqli_error($con);
        echo '
        <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ລຳດັບ</th>
                        <th>ຮາກຖານ</th>
                        <th>ປະທານ ກມບ ຮາກຖານ</th>
                        <th>ສະມາຊິກກຳມະບານ</th>
                        <th>ທີ່ຢູ່ ຕິດຕໍ່</th>
                    </tr>
                </thead>
                <tbody>
                ';
            while($row = mysqli_fetch_assoc($rs)){
                echo '
                    <tr>
                        <td>'.$count++.'</td>
                        <td>'.$row['col_name'].'</td>
                        <td>'.$row['president'].'<td>
                            ທັງໝົດ: '.$row['total_member'].' ສະຫາຍ
                            <br>
                            ເປັນຍິງ: '.$row['female_member'].'ສະຫາຍ
                        </td>
                        <td>
                            '.$row['col_address'].'<br>
                            '.$row['tel'].'<br>
                            '.$row['email'].'
                        </td>
                    </tr>
                ';
            }
        echo '
                </tbody>
        </table>
        ';
    } else if($page == 'member'){
        echo '
        <form action="rpt.php?page=member">
        <div class="mt-3 mb-3 d-print-none row g-3">
        ';
        //ເລືອກປີ
        $sql = "SELECT 
        DATE_FORMAT(join_local, '%Y') AS y 
        FROM member 
        JOIN groups ON groups.id = member.group_id
        WHERE groups.col_id = ". $_SESSION['college_id'] ."
        GROUP BY YEAR(join_local)
        ;";

        $y_rs = mysqli_query($con, $sql);
        echo '<div class="col-1"><label class="col-form-label" for="year">ເລືອກປີ</label></div>';
        echo '<div class="col-2"><select class="form-control" id="year" name="year">';
        echo '<option value="">ເລືອກປີ...</option>';
        while($row = mysqli_fetch_assoc($y_rs)){
            echo '<option '.($row['y']==@$_GET['year']?'selected':'').' value="'.$row['y'].'">'.$row['y'].'</option>';
        }
        echo '</select></div>
            <input type="hidden" name="page" value="member"/>
            <div class="col-2"><input type="submit" value="ສະແດງຜົນ" class="btn btn-outline-success"></div>
        </div></form>';
        $year = null ;
        $rs = mysqli_query($con, getReportQuery($page));
        if(isset($_GET['year'])  && $_GET['year'] != ''){
            $year = mysqli_real_escape_string($con, $_GET['year']);
            $rs = mysqli_query($con, getReportQuery($page, "AND YEAR(join_local) = $year"));
        }
        
            echo '
                <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <th>ລຳດັບ</th>
                    <th>ເພດ</th>
                    <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th>ສະຖານະພາບ</th>
                    <th>ວ.ດ.ປ ເຂົ້າ ກ.ມ.ບ</th>
                    <th>ເກີດທີ່</th>
                    <th>ທີ່ຢູ່ປະຈຸບັນ</th>
                </thead>
            <tbody>
        ';
        
        while($row = mysqli_fetch_assoc($rs)){
            if($row['gender']=='ຍິງ')$female++;
            echo '
                <tr>
                    <td>'.$count++.'</td>
                    <td>'.$row['gender'].'</td>
                    <td>'.$row['fullname'].'</td>
                    <td>
                        '. ($row['role']<=2?'ພະນັກງານ':'ນັກສຶກສາ') .'
                    </td>
                    <td>'.$row['j_t_d'].'</td>
                    <td>'.$row['hometown'].'</td>
                    <td>'.$row['current_address'].'</td>
                </tr>';
        }

        echo '
            <tr class="text-success text-center h4">
                <td colspan="7">ທັງໝົດ '. mysqli_num_rows($rs) .' ສະຫາຍ (ເປັນຍິງ '.$female.' ສະຫາຍ)</td>
            </tr>
        ';

        echo '
            </tbody>
            </table>
            ';
    }else if($page == 'fee'){
        echo '
        <form action="rpt.php">
        <div class="mt-3 mb-3 d-print-none row g-3">
        ';
        //ເລືອກປີ
        $sql = "SELECT 
        yearly_fee.year AS y
        FROM yearly_fee
        GROUP BY yearly_fee.year
        ORDER BY yearly_fee.year DESC
        ;";

        $y_rs = mysqli_query($con, $sql);
        echo '<div class="col-1"><label class="col-form-label" for="year">ເລືອກປີ</label></div>';
        echo '<div class="col-2"><select class="form-control" id="year" name="year">';
        echo '<option value="">ເລືອກປີ...</option>';
        while($row = mysqli_fetch_assoc($y_rs)){
            echo '<option '.($row['y']==@$_GET['year']?'selected':'').' value="'.$row['y'].'">'.$row['y'].'</option>';
        }
        echo '</select></div>
            <input type="hidden" name="page" value="'.$page.'"/>
            <div class="col-2"><input type="submit" value="ສະແດງຜົນ" class="btn btn-outline-success"></div>
        </div></form>';
        $year = null ;
        $rs = mysqli_query($con, getReportQuery($page));
        if(isset($_GET['year'])  && $_GET['year'] != ''){
            $year = mysqli_real_escape_string($con, $_GET['year']);
            $rs = mysqli_query($con, getReportQuery($page, " AND yearly_fee.year= $year "));
        }


            echo '
                <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <th>ລຳດັບ</th>
                    <th>ເພດ</th>
                    <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th>ສະຖານະພາບ</th>
                    <th>ວັນທີຊຳລະ</th>
                    <th>ຈຳນວນເງິນ</th>
                </thead>
            <tbody>
        ';
          
            while($row = mysqli_fetch_assoc($rs)){
                $total += $row['fee'];
                if($row['gender']=='ຍິງ'){$female++;}
                echo '
                    <tr>
                        <td>'.$count++.'</td>
                        <td>'.$row['gender'].'</td>
                        <td>'.$row['fullname'].'</td>
                        <td>
                            '. ($row['role']<=2?'ພະນັກງານ':'ນັກສຶກສາ') .'
                        </td>
                        <td>'.$row['pay_date'].'</td>
                        <td class="text-end">'.number_format($row['fee']).'</td>
                    </tr>
                ';
            }
        
            echo '
                <tr class="table-success h4">
                    <td colspan="3">
                        ຊຳລະແລ້ວ '.mysqli_num_rows($rs).' ສະຫາຍ (ເປັນຍິງ '.$female.' ສະຫາຍ)
                    </td>
                    <td colspan="2" class="text-end">ລວມທັງໝົດ</td>
                    <td class="text-end">'.number_format($total).'</td>
                </tr>
                </tbody>
            </table>
            ';

            
            $sql_female = "
            SELECT member.mem_id
                FROM member 
                JOIN groups ON groups.id = member.group_id
                WHERE member.mem_id NOT IN 
                    (
                    SELECT membership_fee.mem_id 
                    FROM membership_fee 
                    JOIN yearly_fee ON yearly_fee.id = membership_fee.fee_id
            ";
            
            
            if(isset($_GET['year'])  && $_GET['year'] != ''){
                $year = mysqli_real_escape_string($con, $_GET['year']);
                $sql_female .= " WHERE yearly_fee.year = ".$year;
            }else{
                $sql_female .= " WHERE yearly_fee.year = ".date('Y');
            }

            $sql_female .= ")
                AND 
                groups.col_id = ".$_SESSION['college_id']."
                ";

                $sql_female .= " 
                AND member.gender = 'ຍິງ' 
            ";

            $rs_female = mysqli_query($con,$sql_female);
            

            


            $sql = "
            SELECT member.mem_id, CONCAT( member.firstname , ' ', member.lastname) AS fullname, member.gender  
                FROM member 
                JOIN groups ON groups.id = member.group_id
                WHERE member.mem_id NOT IN 
                    (
                    SELECT membership_fee.mem_id 
                    FROM membership_fee 
                    JOIN yearly_fee ON yearly_fee.id = membership_fee.fee_id
                    ";

                    if(isset($_GET['year'])  && $_GET['year'] != ''){
                        $year = mysqli_real_escape_string($con, $_GET['year']);
                        $sql .= " WHERE yearly_fee.year = ".$year;
                    }else{
                        $sql .= " WHERE yearly_fee.year = ".date('Y');
                    }

            $sql .= ")
                AND 
                groups.col_id = ".$_SESSION['college_id']."
                ;";

            
            
            $rs = mysqli_query($con, $sql);


            echo '<hr class="mt-3 mb-3">';
            echo '<h4>ບໍ່ທັນຊຳລະ ມີ '.mysqli_num_rows($rs).' ສະຫາຍ (ເປັນຍິງ '.mysqli_num_rows($rs_female).' ສະຫາຍ)</h4>';
            echo '<ol>';
            while($row=mysqli_fetch_assoc($rs)){
                echo '<li>ສະຫາຍ '.($row['gender']=='ຍິງ'?'ນາງ':'').' '.$row['fullname'].'</li>';
            }
            echo '</ol>';

    }else if($page == 'in'){
        echo '
        <form action="rpt.php">
        <div class="mt-3 mb-3 d-print-none row g-3">
        ';
        //ເລືອກປີ
        $sql = "SELECT 
        YEAR(member_in.issue_date) AS y
        FROM member_in
        GROUP BY YEAR(member_in.issue_date)
        ORDER BY YEAR(member_in.issue_date) DESC
        ;";

        $y_rs = mysqli_query($con, $sql);
        echo '<div class="col-1"><label class="col-form-label" for="year">ເລືອກປີ</label></div>';
        echo '<div class="col-2"><select class="form-control" id="year" name="year">';
        echo '<option value="">ເລືອກປີ...</option>';
        while($row = mysqli_fetch_assoc($y_rs)){
            echo '<option '.($row['y']==@$_GET['year']?'selected':'').' value="'.$row['y'].'">'.$row['y'].'</option>';
        }
        echo '</select></div>
            <input type="hidden" name="page" value="'.$page.'"/>
            <div class="col-2"><input type="submit" value="ສະແດງຜົນ" class="btn btn-outline-success"></div>
        </div></form>';
        $year = null ;
        $rs = mysqli_query($con, getReportQuery($page));
        if(isset($_GET['year'])  && $_GET['year'] != ''){
            $year = mysqli_real_escape_string($con, $_GET['year']);
            $rs = mysqli_query($con, getReportQuery($page, " AND yearly_fee.year= $year "));
        }

            echo '
                <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <th>ລຳດັບ</th>
                    <th>ເພດ</th>
                    <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th>ສະຖານະພາບ</th>
                    <th>ເລກທີເອກະສານ</th>
                    <th>ລົງວັນທີ</th>
                </thead>
            <tbody>
        ';
          
            while($row = mysqli_fetch_assoc($rs)){
                if($row['gender']=='ຍິງ'){$female++;}
                echo '
                    <tr>
                        <td>'.$count++.'</td>
                        <td>'.$row['gender'].'</td>
                        <td>'.$row['fullname'].'</td>
                        <td>
                            '. ($row['role']<=2?'ພະນັກງານ':'ນັກສຶກສາ') .'
                        </td>
                        <td>'.$row['doc_no'].'</td>
                        <td>'.$row['i_d'].'</td>
                    </tr>
                ';
            }
        
            echo '
                <tr class="table-success text-center h4">
                    <td colspan="6">
                        ລວມ '.mysqli_num_rows($rs).' ສະຫາຍ (ເປັນຍິງ '.$female.' ສະຫາຍ)
                    </td>
                </tr>
                </tbody>
            </table>
            ';

    }else if($page == 'out'){

    }else if($page == 'activity'){

    }else {
        echo '<h2>ກະລຸນາເລືອກລາຍງານ</h2>';
    }

?>

</div><!-- fluid -->
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