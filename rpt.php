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
    <div class="d-none d-print-block"  style="font-size: 12px;">    
        <p class="d-flex justify-content-between">
            <span>ສະຫະພັນກຳມະບານ ກະຊວງສຶກສາທິການ ແລະ ກິລາ<br>
            ສະຫະພັນກຳມະບານ ການສຶກສາພາກເອກະຊົນ<br>
            <?php
                $sql = "SELECT col_name FROM college WHERE col_id = ".$_SESSION['college_id']."; ";
                $rs = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($rs);
                echo $row['col_name'];
            ?>
        </span>

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

    if($page == 'member'){
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
        ORDER BY YEAR(join_local) DESC
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
            <tr class="table-success text-center h4">
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
        WHERE col_id = ". $_SESSION['college_id'] ."
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
            $rs = mysqli_query($con, getReportQuery($page, " AND YEAR(member_in.issue_date) = $year "));
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
        echo '
        <form action="rpt.php">
        <div class="mt-3 mb-3 d-print-none row g-3">
        ';
        //ເລືອກປີ
        $sql = "SELECT 
        YEAR(member_out.issue_date) AS y
        FROM member_out
        WHERE col_id = ". $_SESSION['college_id'] ."
        GROUP BY YEAR(member_out.issue_date)
        ORDER BY YEAR(member_out.issue_date) DESC
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
            $rs = mysqli_query($con, getReportQuery($page, " AND YEAR(member_out.issue_date) = $year "));
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
                    <th>ຈ່າຍຄ່າສະຕິຄັ້ງສຸດ</th>
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
                        <td>ປີ '.$row['latest_paid_year'].'</td>
                    </tr>
                ';
            }
        
            echo '
                <tr class="table-success text-center h4">
                    <td colspan="7">
                        ລວມ '.mysqli_num_rows($rs).' ສະຫາຍ (ເປັນຍິງ '.$female.' ສະຫາຍ)
                    </td>
                </tr>
                </tbody>
            </table>
            ';

    }else if($page == 'activity'){
        echo '
        <form action="rpt.php">
        <div class="mt-3 mb-3 d-print-none row g-3">
        ';
        //ເລືອກປີ
        $sql = "SELECT 
        YEAR(activity.act_date) AS y
        FROM activity
        GROUP BY YEAR(activity.act_date)
        ORDER BY YEAR(activity.act_date) DESC
        ;";

        $y_rs = mysqli_query($con, $sql);
        echo '<div class="col-1"><label class="col-form-label" for="year">ເລືອກປີ</label></div>';
        echo '<div class="col-2"><select class="form-control" id="year" name="year">';
        while($row = mysqli_fetch_assoc($y_rs)){
            echo '<option '.($row['y']==@$_GET['year']?'selected':'').' value="'.$row['y'].'">'.$row['y'].'</option>';
        }
        echo '</select>
        </div>
            <div class="col-2">
                <select name="quarter" class="form-control">
                    <option '.(@$_GET['quarter']==1?'selected':'').' value="1">ໄຕມາດ 1</option>
                    <option '.(@$_GET['quarter']==2?'selected':'').'  value="2">ໄຕມາດ 2</option>
                    <option '.(@$_GET['quarter']==3?'selected':'').'  value="3">ໄຕມາດ 3</option>
                    <option '.(@$_GET['quarter']==4?'selected':'').'  value="4">ໄຕມາດ 4</option>
                </select>
            </div>
            <input type="hidden" name="page" value="'.$page.'"/>
            <div class="col-2"><input type="submit" value="ສະແດງຜົນ" class="btn btn-outline-success"></div>
        </div></form>';
        $year = null ;
        $quarter = null;
        $otherSql = null;
        $rs = mysqli_query($con, getReportQuery($page));
        if(isset($_GET['year'])  && $_GET['year'] != '' && $_GET['quarter']){
            $year = mysqli_real_escape_string($con, $_GET['year']);
            $quarter = mysqli_real_escape_string($con, $_GET['quarter']);
            if($quarter == 1){
                $otherSql = "
                 AND MONTH(act_date) >= 1 OR MONTH(act_date) <= 3
                ";
            }else if($quarter == 2){
                $otherSql = "
                 AND (MONTH(act_date) >= 4 AND MONTH(act_date) <=  6)
                ";
            }else if($quarter == 3){
                $otherSql = "
                 AND (MONTH(act_date) >= 7 AND MONTH(act_date) <=  9)
                ";
            }else{
                $otherSql = "
                 AND (MONTH(act_date) >= 10 AND MONTH(act_date) <=  12)
                ";
            }
            $rs = mysqli_query($con, getReportQuery($page, " AND YEAR(act_date) = $year " . $otherSql));
        }
            echo '<div class="container">';
            while($row = mysqli_fetch_assoc($rs)){
                echo '
                    <div class="mb-3">
                        <h2>'.$row['act_title'].'</h2>
                        <p class="text-secondary" >ທີ່: '.$row['act_location'].' &nbsp;&nbsp;&nbsp;
                        ວັນທີ: '.$row['a_d'].'</p>
                        <div style="padding-left:20px;">
                            '.$row['act_detail'].'
                        </div>
                    </div>
                    
                ';
            }
            echo '</div>';
    }else {
        echo '<h2>ກະລຸນາເລືອກລາຍງານ</h2>';
    }

?>

    <p class="text-end d-none d-print-block mt-5">ປະທານສະຫະພັນກຳມະບານຮາຖານ</p>
    <p></p>
    <p></p>
    <p></p>
    <p class="text-end d-none d-print-block mt-5">................................................</p>

</div><!-- fluid -->
<?php
require __DIR__ . '/footer.php';
?>


<?php endif;?>