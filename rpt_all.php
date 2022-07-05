<?php
session_start();
if($_GET || isset($_GET['page'])):
$current_page = 'college';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
if (!islogin()) {header('Location:login.php');}
if(isMember())restrictPage();

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
            }else{
                echo 'ປີ '.date('Y');
            }

            if(isset($_GET['quarter']) AND $_GET['quarter']){
                echo ' ປະຈຳໄຕມາດ '.$_GET['quarter'];
            }
        ?>
        <br>
        ຂອງແຕ່ລະຮາກຖານ
    </h2>
<div class="text-end mb-3">
<button onclick="window.print();" class="btn btn-warning d-print-none text-end"><i class="fa-solid fa-print"></i> &nbsp; ສັ່ງພິມ</button>
</div>
<?php
    $count = 1;
    $total=$female = 0;

    if($page == 'college'){
        $rs = mysqli_query($con, getReportAllQuery($page));
        echo mysqli_error($con);
        echo '
        <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ລຳດັບ</th>
                        <th>ຮາກຖານ</th>
                        
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
                        <td>
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
    } else if($page == 'member' && isAdmin()){
        
        echo '
        <form action="rpt_all.php"><div class="mt-3 mb-3 d-print-none row g-3">
        ';
        //ເລືອກປີ
        $sql = "SELECT 
        YEAR(member.join_local) AS y
        FROM member
        GROUP BY YEAR(member.join_local)
        ORDER BY YEAR(member.join_local) DESC
        ;";

        $y_rs = mysqli_query($con, $sql);
        echo '<div class="col-1"><label class="col-form-label" for="year">ເລືອກປີ</label></div>';
        echo '<div class="col-2"><select class="form-control" id="year" name="year">';
        
        while($row = mysqli_fetch_assoc($y_rs)){
            echo '<option '.($row['y']==@$_GET['year']?'selected':'').' value="'.$row['y'].'">'.$row['y'].'</option>';
        }
        echo '</select></div>
        '.showQuarter().'
            <input type="hidden" name="page" value="'.$page.'"/>
            <div class="col-1"><input type="submit" value="ສະແດງຜົນ" class="btn btn-outline-success"></div>
            <div class="col-1"><a href="rpt_all.php?page=member" class="btn btn-outline-danger">ລ້າງຄ່າ</a></div>
        </div></form>';
        $year = null ;
        $quarter = null;
        $otherSql = null;
        
        $rs = mysqli_query($con, getReportAllQuery($page));

        if(isset($_GET['year'])  && isset($_GET['quarter'])){
            $year = mysqli_real_escape_string($con, $_GET['year']);
            $quarter = mysqli_real_escape_string($con, $_GET['quarter']);

            $otherSql = " WHERE YEAR(join_local) = '".$year ."' ";

            if($quarter == 1){
                $otherSql .= "
                AND (MONTH(join_local) >= 1 AND MONTH(join_local) <= 3)
                ";
            }else if($quarter == 2){
                $otherSql .= "
                AND (MONTH(join_local) >= 4 AND MONTH(join_local) <=  6)
                ";
            }else if($quarter == 3){
                $otherSql .= "
                AND (MONTH(join_local) >= 7 AND MONTH(join_local) <=  9)
                ";
            }else if($quarter == 4){
                $otherSql .= "
                AND (MONTH(join_local) >= 10 AND MONTH(join_local) <=  12)
                ";
            }else{
                $otherSql .= "
                AND (MONTH(join_local) >= 1 AND MONTH(join_local) <=  12)
                ";
            }

            $rs = mysqli_query($con, getReportAllQuery($page,$otherSql));
        }      

            echo mysqli_error($con);
            echo '
                <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <th>ລຳດັບ</th>
                    <th>ກຳມະບານຮາກຖານ</th>
                    <th>ສະມາຊິກທັງໝົດ</th>
                    <th>ເພດຍິງ</th>
                    <th>ນັກສຶກສາ</th>
                    <th>ເພດຍິງ</th>
                </thead>
            <tbody>
        ';
          
            while($row = mysqli_fetch_assoc($rs)){
                
                echo '
                    <tr>
                        <td>'.$count++.'</td>
                        <td>'.$row['col_name'].'</td>
                        <td class="text-center">'.$row['all_member'].' ສະຫາຍ</td>
                        <td class="text-center">'.$row['female'].'</td>
                        <td class="text-center">'.$row['student'].'</td>
                        <td class="text-center">'.$row['student_female'].'</td>
                    </tr>
                ';
            }
        
            echo '
                </tbody>
            </table>
            ';

    }else if($page == 'fee' && isAdmin()){
        
        echo '
        <form action="rpt_all.php"><div class="mt-3 mb-3 d-print-none row g-3">
        ';
        //ເລືອກປີ
        $sql = "SELECT 
        yearly_fee.year AS y
        FROM yearly_fee
        ORDER BY yearly_fee.year DESC
        ;";

        $y_rs = mysqli_query($con, $sql);
        echo '<div class="col-1"><label class="col-form-label" for="year">ເລືອກປີ</label></div>';
        echo '<div class="col-2"><select class="form-control" id="year" name="year">';
        while($row = mysqli_fetch_assoc($y_rs)){
            echo '<option '.($row['y']==@$_GET['year']?'selected':'').' value="'.$row['y'].'">'.$row['y'].'</option>';
        }
        echo '</select></div>
        '.showQuarter().'
            <input type="hidden" name="page" value="'.$page.'"/>
            <div class="col-1"><input type="submit" value="ສະແດງຜົນ" class="btn btn-outline-success"></div>
            <div class="col-1"><a href="rpt_all.php?page=fee" class="btn btn-outline-danger">ລ້າງຄ່າ</a></div>
        </div></form>';
        $year = null ;
        $quarter = null;
        $otherSql = null;
        
        $rs = mysqli_query($con, getReportAllQuery($page));

        if(isset($_GET['year'])  && $_GET['year'] != '' && $_GET['quarter'] != ''){
            $year = mysqli_real_escape_string($con, $_GET['year']);
            $quarter = mysqli_real_escape_string($con, $_GET['quarter']);

            $otherSql = " WHERE YEAR(membership_fee.pay_date) = '".$year ."'";

            if($quarter == 1){
                $otherSql .= "
                AND (MONTH(membership_fee.pay_date) >= 1 AND MONTH(membership_fee.pay_date) <= 3)
                ";
            }else if($quarter == 2){
                $otherSql .= "
                AND (MONTH(membership_fee.pay_date) >= 4 AND MONTH(membership_fee.pay_date) <=  6)
                ";
            }else if($quarter == 3){
                $otherSql .= "
                AND (MONTH(membership_fee.pay_date) >= 7 AND MONTH(membership_fee.pay_date) <=  9)
                ";
            }else if($quarter == 4){
                $otherSql .= "
                AND (MONTH(membership_fee.pay_date) >= 10 AND MONTH(membership_fee.pay_date) <=  12)
                ";
            }else{
                $otherSql .= "
                AND (MONTH(pay_date) >= 1 AND MONTH(pay_date) <=  12)
                ";
            }

            $rs = mysqli_query($con, getReportAllQuery($page,$otherSql));
            
        }      

        echo mysqli_error($con);
            echo '
                <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <th>ລຳດັບ</th>
                    <th>ກຳມະບານຮາກຖານ</th>
                    <th>ຊຳລະແລ້ວທັງໝົດ</th>
                    <th>ເພດຍິງ</th>
                    <th>ພະນັກງານ</th>
                    <th>ເພດຍິງ</th>
                    <th>ນັກສຶກສາ</th>
                    <th>ເພດຍິງ</th>
                    <th>ຍັງຄ້າງຊໍາລະ</th>
                </thead>
            <tbody>
        ';
          
            while($row = mysqli_fetch_assoc($rs)){
                
                echo '
                    <tr>
                        <td>'.$count++.'</td>
                        <td>'.$row['col_name'].'</td>
                        <td class="text-center">'.$row['all_member'].' ສະຫາຍ</td>
                        <td class="text-center">'.$row['female'].'</td>
                        <td class="text-center">'.$row['committee'].'</td>
                        <td class="text-center">'.$row['committee_female'].'</td>
                        <td class="text-center">'.$row['student'].'</td>
                        <td class="text-center">'.$row['student_female'].'</td>
                        <td class="text-center">'.$row['not_pay'].'</td>
                    </tr>
                ';
            }
        
            echo '
                </tbody>
            </table>
            ';

    }else if($page == 'in' && isAdmin()){
        echo '
        <form action="rpt_all.php"><div class="mt-3 mb-3 d-print-none row g-3">
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
        while($row = mysqli_fetch_assoc($y_rs)){
            echo '<option '.($row['y']==@$_GET['year']?'selected':'').' value="'.$row['y'].'">'.$row['y'].'</option>';
        }
        echo '</select></div>
        '.showQuarter().'
            <input type="hidden" name="page" value="'.$page.'"/>
            <div class="col-1"><input type="submit" value="ສະແດງຜົນ" class="btn btn-outline-success"></div>
            <div class="col-1"><a href="rpt_all.php?page=in" class="btn btn-outline-danger">ລ້າງຄ່າ</a></div>
        </div></form>';
        $year = null ;
        $quarter = null;
        $otherSql = null;
        
        $rs = mysqli_query($con, getReportAllQuery($page));

        if(isset($_GET['year'])  && $_GET['year'] != '' && $_GET['quarter'] != ''){
            $year = mysqli_real_escape_string($con, $_GET['year']);
            $quarter = mysqli_real_escape_string($con, $_GET['quarter']);

            $otherSql = " WHERE YEAR(member_in.issue_date) = '".$year ."'";

            if($quarter == 1){
                $otherSql .= "
                AND (MONTH(issue_date) >= 1 AND MONTH(issue_date) <= 3)
                ";
            }else if($quarter == 2){
                $otherSql .= "
                AND (MONTH(issue_date) >= 4 AND MONTH(issue_date) <=  6)
                ";
            }else if($quarter == 3){
                $otherSql .= "
                AND (MONTH(issue_date) >= 7 AND MONTH(issue_date) <=  9)
                ";
            }else if($quarter == 4){
                $otherSql .= "
                AND (MONTH(issue_date) >= 10 AND MONTH(issue_date) <=  12)
                ";
            }else{
                $otherSql .= "
                AND (MONTH(issue_date) >= 1 AND MONTH(issue_date) <=  12)
                ";
            }

            $rs = mysqli_query($con, getReportAllQuery($page,$otherSql));
            
        }      
            echo '
                <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <th>ລຳດັບ</th>
                    <th>ກຳມະບານຮາກຖານ</th>
                    <th>ຍ້າຍເຂົ້າທັງໝົດ</th>
                    <th>ເພດຍິງ</th>
                    <th>ພະນັກງານ</th>
                    <th>ເພດຍິງ</th>
                    <th>ນັກສຶກສາ</th>
                    <th>ເພດຍິງ</th>
                </thead>
            <tbody>
        ';
          
            while($row = mysqli_fetch_assoc($rs)){
                
                echo '
                    <tr>
                        <td>'.$count++.'</td>
                        <td>'.$row['col_name'].'</td>
                        <td class="text-center">'.$row['all_member'].' ສະຫາຍ</td>
                        <td class="text-center">'.$row['female'].'</td>
                        <td class="text-center">'.$row['committee'].'</td>
                        <td class="text-center">'.$row['committee_female'].'</td>
                        <td class="text-center">'.$row['student'].'</td>
                        <td class="text-center">'.$row['student_female'].'</td>
                    </tr>
                ';
            }
        
            echo '
                </tbody>
            </table>
            ';

    }else if($page == 'out' && isAdmin()){
        echo '
        <form action="rpt_all.php"><div class="mt-3 mb-3 d-print-none row g-3">
        ';
        //ເລືອກປີ
        $sql = "SELECT 
        YEAR(member_out.issue_date) AS y
        FROM member_out
        GROUP BY YEAR(member_out.issue_date)
        ORDER BY YEAR(member_out.issue_date) DESC
        ;";

        $y_rs = mysqli_query($con, $sql);
        echo '<div class="col-1"><label class="col-form-label" for="year">ເລືອກປີ</label></div>';
        echo '<div class="col-2"><select class="form-control" id="year" name="year">';
        while($row = mysqli_fetch_assoc($y_rs)){
            echo '<option '.($row['y']==@$_GET['year']?'selected':'').' value="'.$row['y'].'">'.$row['y'].'</option>';
        }
        echo '</select></div>
        '.showQuarter().'
            <input type="hidden" name="page" value="'.$page.'"/>
            <div class="col-1"><input type="submit" value="ສະແດງຜົນ" class="btn btn-outline-success"></div>
            <div class="col-1"><a href="rpt_all.php?page=out" class="btn btn-outline-danger">ລ້າງຄ່າ</a></div>
        </div></form>';
        $year = null ;
        $quarter = null;
        
        $rs = mysqli_query($con, getReportAllQuery($page));

        if(isset($_GET['year'])  && $_GET['year'] != '' && $_GET['quarter']){
            $year = mysqli_real_escape_string($con, $_GET['year']);
            $quarter = mysqli_real_escape_string($con, $_GET['quarter']);

            $otherSql = " WHERE YEAR(member_out.issue_date) = ".$year;

            if($quarter == 1){
                $otherSql .= "
                AND (MONTH(issue_date) >= 1 AND MONTH(issue_date) <= 3)
                ";
            }else if($quarter == 2){
                $otherSql .= "
                AND (MONTH(issue_date) >= 4 AND MONTH(issue_date) <=  6)
                ";
            }else if($quarter == 3){
                $otherSql .= "
                AND (MONTH(issue_date) >= 7 AND MONTH(issue_date) <=  9)
                ";
            }else if($quarter == 4){
                $otherSql .= "
                AND (MONTH(issue_date) >= 10 AND MONTH(issue_date) <=  12)
                ";
            }else{
                $otherSql .= "
                AND (MONTH(issue_date) >= 1 AND MONTH(issue_date) <=  12)
                ";
            }

            $rs = mysqli_query($con, getReportAllQuery($page,$otherSql));
        }       

            echo '
                <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <th>ລຳດັບ</th>
                    <th>ກຳມະບານຮາກຖານ</th>
                    <th>ຍ້າຍອອກທັງໝົດ</th>
                    <th>ເພດຍິງ</th>
                    <th>ພະນັກງານ</th>
                    <th>ເພດຍິງ</th>
                    <th>ນັກສຶກສາ</th>
                    <th>ເພດຍິງ</th>
                </thead>
            <tbody>
        ';
          
            while($row = mysqli_fetch_assoc($rs)){

                $sql = "SELECT COUNT(member_out.mem_id) FROM member_out WHERE member_out.col_id = 1 AND YEAR(issue_date) = 2022 AND MONTH(issue_date) >= 4 AND MONTH (issue_date) <= 6;";
                
                echo '
                    <tr>
                        <td>'.$count++.'</td>
                        <td>'.$row['col_name'].'</td>
                        <td class="text-center">'.$row['all_member'].' ສະຫາຍ</td>
                        <td class="text-center">'.$row['female'].'</td>
                        <td class="text-center">'.$row['committee'].'</td>
                        <td class="text-center">'.$row['committee_female'].'</td>
                        <td class="text-center">'.$row['student'].'</td>
                        <td class="text-center">'.$row['student_female'].'</td>
                    </tr>
                ';
            }
        
            echo '
                </tbody>
            </table>
            ';

    }else if($page == 'activity' && isAdmin()){
        echo '
        <form action="rpt_all.php"><div class="mt-3 mb-3 d-print-none row g-3">
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
            '.showQuarter().'
            <input type="hidden" name="page" value="'.$page.'"/>
            <div class="col-1"><input type="submit" value="ສະແດງຜົນ" class="btn btn-outline-success"></div>
            <div class="col-1"><a href="rpt_all.php?page=activity" class="btn btn-outline-danger">ລ້າງຄ່າ</a></div>
        </div></form>';
        $year = null ;
        $quarter = null;
        $otherSql = null;
        $sql_college = "SELECT college.col_id, college.col_name FROM college RIGHT JOIN activity ON college.col_id = activity.col_id ";
        
        $otherSql_college = " WHERE YEAR(act_date) = ".date('Y'). " ";

        if(isset($_GET['year'])  && $_GET['year'] != '' && $_GET['quarter']){
            $year = mysqli_real_escape_string($con, $_GET['year']);
            $quarter = mysqli_real_escape_string($con, $_GET['quarter']);

            $otherSql_college = " WHERE YEAR(act_date) = ".$year. " ";

            if($quarter == 1){
                $otherSql_college .= "
                AND (MONTH(act_date) >= 1 AND MONTH(act_date) <= 3)
                ";
            }else if($quarter == 2){
                $otherSql_college .= "
                AND (MONTH(act_date) >= 4 AND MONTH(act_date) <=  6)
                ";
            }else if($quarter == 3){
                $otherSql_college .= "
                AND (MONTH(act_date) >= 7 AND MONTH(act_date) <=  9)
                ";
            }else{
                $otherSql_college .= "
                AND (MONTH(act_date) >= 1 AND MONTH(act_date) <=  12)
                ";
            }
        }

        $rs_college = mysqli_query($con,$sql_college.$otherSql_college.' ORDER BY college.col_name ');
        echo mysqli_error($con);
        while($row_college = mysqli_fetch_assoc($rs_college)):



            $rs = mysqli_query($con, getReportAllQuery($page," WHERE col_id = ". $row_college['col_id']));

            if(isset($_GET['year'])  && $_GET['year'] != '' && $_GET['quarter']){
                $year = mysqli_real_escape_string($con, $_GET['year']);
                $quarter = mysqli_real_escape_string($con, $_GET['quarter']);
                if($quarter == 1){
                    $otherSql = "
                    AND (MONTH(act_date) >= 1 AND MONTH(act_date) <= 3)
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
                    AND (MONTH(act_date) >= 1 AND MONTH(act_date) <=  12)
                    ";
                }
                $rs = mysqli_query($con, getReportAllQuery($page, " WHERE YEAR(act_date) = $year " . $otherSql . " AND col_id = ". $row_college['col_id']. " "));
            }
            echo mysqli_error($con);
                echo '<div class="container">';
                echo '<u><h1>'.$row_college['col_name'].'</h1></u>';
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
        endwhile;
    }else {
        echo '<h2 class="alert alert-danger">ກະລຸນາເລືອກລາຍງານ</h2>';
    }

?>

    <p class="text-end d-none d-print-block mt-5">ປະທານສະຫະພັນກຳມະບານ<br>ການສຶກສາພາກເອກະຊົນ</p>
    <p></p>
    <p></p>
    <p></p>
    <p class="text-end d-none d-print-block mt-5">...........................................</p>

</div><!-- fluid -->
<?php
require __DIR__ . '/footer.php';
?>

<?php endif;?>