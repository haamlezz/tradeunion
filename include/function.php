<?php

//prepare statement
/**
 * @var connection $con
 * @var string $sql
 * @var array $params
 * @var array $types
 */
function prepared_stm($con, $sql, $params, $types=""){
    
    $types = $types ?: str_repeat("s", count($params));
    
    if($stm = $con->prepare($sql)){
        $stm->bind_param($types, ...$params);
        $stm->execute();
        return $stm;
    }else{
        return $con->error;
    }
}

/**
 * check login
 */
function islogin(){
    if(isset($_SESSION['login'])){
        if($_SESSION['login']){
            return true;
        }
    }

    return false;
}

function isAdmin(){
    if(isset($_SESSION['role'])){
        if($_SESSION['role'] == 1){
            return true;
        }
    }
    return false;
}

function isCommittee(){
    if(isset($_SESSION['role'])){
        if($_SESSION['role'] == 2){
            return true;
        }
    }
    return false;
}

function isMember(){
    if(isset($_SESSION['role'])){
        if($_SESSION['role'] == 3){
            return true;
        }
    }
    return false;
}

function isOwner($college_id){
    if(isset($_SESSION['college_id'])){
        if($_SESSION['college_id'] == $college_id){
            return true;
        }
    }
    return false;
}

function isExisted($con, $col, $table, $id){
    $sql = "SELECT $col FROM $table WHERE $col = ?";
    $rs = prepared_stm($con, $sql, [$id])->get_result();
    $row = $rs->fetch_assoc();
    if($rs->num_rows == 1){
        
        return true;
    }
    return false;
}

function restrictPage($location=null){
    if($location==null){
        echo '<div class="container"><div class="mt-3 alert alert-danger text-lg-center">ທ່ານບໍ່ມີສິດເຂົ້າໜ້ານີ້, <a href="index.php">ກັບໜ້າຫຼັກ</a></div></div>';
    }else{
        echo '<div class="container"><div class="mt-3 alert alert-danger text-lg-center">ທ່ານບໍ່ມີສິດເຂົ້າໜ້ານີ້, <a href="'.$location.'.php">ກັບໜ້າຫຼັກ</a></div></div>';
    }
    
    require 'footer.php';
    exit();
}

function notFoundPage(){
    echo '<div class="container"><div class="mt-3 alert alert-info text-lg-center">ບໍ່ພົບໜ້ານີ້, <a href="index.php">ກັບໜ້າຫຼັກ</a></div></div>';
    require 'footer.php';
    exit();
}

function noValidateField($value , $field=[]){
    foreach($field as $f){
        if($f == $value){
            return true;
        }
    }

    return false;
}


function dataListProvince($id){
    $provinces = [
        'ຄຳມ່ວນ',
        'ຈຳປາສັກ',
        'ສາລະວັນ',
        'ສະຫວັນນະເຂດ',
        'ຊຽງຂວາງ',
        'ໄຊຍະບູລີ',
        'ໄຊສົມບູນ',
        'ເຊກອງ',
        'ບໍລິຄຳໄຊ',
        'ບໍ່ແກ້ວ',
        'ຜົ້ງສາລີ',
        'ຫຼວງນໍ້າທາ',
        'ຫຼວງພະບາງ',
        'ວຽງຈັນ',
        'ອັດຕະປື',
        'ອຸດົມໄຊ',
        'ຫົວພັນ',
        'ນະຄອນຫຼວງວຽງຈັນ',
    ];
    echo '
    <datalist id="'.$id.'">';
        foreach($provinces as $p){
            echo '
                <option>'.$p.'</option>
            ';
        }
    echo '</datalist>';
}


function listMemberAutoComplete($con,$id){
    $sql = "SELECT CONCAT(member.firstname, ' ', member.lastname) AS fullname, member.mem_id AS id FROM member JOIN groups ON groups.id = member.group_id WHERE groups.col_id = ".$_SESSION['college_id'];

    $rs = mysqli_query($con, $sql);
    
    echo '<datalist id="'.$id.'">';
        while($row = mysqli_fetch_assoc($rs)){
            echo '
                <option value="'.$row['id'].'">'.$row['fullname'].'</option>
            ';
        }
    echo '</datalist>';
}


function getReport($page){
    $title = '';
    switch($page){
        case 'college': $title = 'ລາຍງານຂໍ້ມູນຮາກຖານພາກເອກະຊົນ';
        break;
        case 'member': $title = 'ລາຍງານສະມາຊິກ';
        break;
        case 'fee': $title = 'ລາຍງານເສຍຄ່າສະຕິ';
        break;
        case 'in': $title = 'ລາຍງານຍ້າຍເຂົ້າ';
        break;
        case 'out': $title = 'ລາຍງານຍ້າຍອອກ';
        break;
        case 'activity': $title = 'ລາຍງານການເຄື່ອນໄຫວ';
        break;
    }
    return $title;
}



function getReportQuery($page, $otherQuery=null){
    $sql = '';
    switch($page){
        case 'member': $sql = "
            SELECT 
            CONCAT(member.firstname, ' ', member.lastname) AS fullname, 
            CONCAT(member.h_village, ' ', member.h_district, ' ', member.h_province) AS hometown, 
            CONCAT(member.addr_village, ' ', member.addr_district, ' ', member.addr_province) AS current_address, 
            DATE_FORMAT(member.join_trade_union_date, '%d/%m/%Y') AS j_t_d, 
            groups.group_name , 
            member.role,
            member.gender
            FROM member 
            JOIN groups ON groups.id = member.group_id
            WHERE groups.col_id = ". $_SESSION['college_id'] ."  
            ";

            if($otherQuery!=null){
                $sql .= $otherQuery;
            }else{
                $sql .= " AND (YEAR(join_local) <= ". date('Y') . " AND member.status <> 2  )";
            }
            $sql .= " ORDER BY member.status ASC, fullname
            ;
            ";
        break;
        case 'fee': $sql = "
            SELECT 
            
            membership_fee.* , 
            CONCAT(member.firstname,' ',member.lastname) AS fullname ,
            member.gender , 
            yearly_fee.fee ,
            member.role, 
            (SELECT yearly_fee.year FROM yearly_fee WHERE yearly_fee.id = membership_fee.fee_id) AS membership_year 
            FROM member 
            JOIN membership_fee ON membership_fee.mem_id = member.mem_id 
            JOIN groups ON groups.id = member.group_id
            JOIN yearly_fee ON yearly_fee.id = membership_fee.fee_id 
            WHERE groups.col_id = ". $_SESSION['college_id'] . " 
            
            ";
            if($otherQuery != null){
                $sql .= $otherQuery;
            }else{
                $sql .= " AND (yearly_fee.year <= ". date('Y') ." AND member.status <> 2 )";
            }
            $sql .= " ORDER BY member.role ASC ";
        break;
        case 'in': $sql = "
            SELECT 
            CONCAT(member.firstname, ' ', member.lastname) AS fullname,
            DATE_FORMAT(member_in.issue_date, '%d/%m/%Y') AS i_d,
            member_in.doc_no,
            groups.group_name,
            member.gender,
            member.role
            FROM member
            JOIN groups ON groups.id = member.group_id 
            JOIN member_in ON member_in.mem_id = member.mem_id 
            WHERE groups.col_id = ".$_SESSION['college_id']." ";

            if($otherQuery != null){
                $sql .= $otherQuery;
            }else{
                $sql .= " 
                AND YEAR(member_in.issue_date) <= ".date('Y')." ";
            }

        break;
        case 'out': $sql = "
            SELECT 
            CONCAT(member.firstname, ' ', member.lastname) AS fullname,
            DATE_FORMAT(member_out.issue_date, '%d/%m/%Y') AS i_d,
            member_out.doc_no,
            member_out.latest_paid_year,
            groups.group_name,
            member.gender,
            member.role
            FROM member
            JOIN groups ON groups.id = member.group_id 
            JOIN member_out ON member_out.mem_id = member.mem_id 
            WHERE groups.col_id = ".$_SESSION['college_id']." ";

            if($otherQuery != null){
                $sql .= $otherQuery;
            }else{
                $sql .= " 
                AND YEAR(member_out.issue_date) <= ".date('Y')."
                ;";
            }
        break;
        case 'activity': $sql = "
            SELECT 
            activity.*,
            DATE_FORMAT(act_date,'%d/%m/%Y') AS a_d 
            FROM activity 
            WHERE activity.col_id = ".$_SESSION['college_id']." ";
            
            if($otherQuery != null){
                $sql .= $otherQuery;
            }else{
                $sql .= "
                    AND YEAR(act_date) <= ".date('Y')."
                    ";
            }
        break;
    }
    
    return $sql;
}

function getReportAllQuery($page, $otherQuery=null){
    $sql = '';
    switch($page){
        case 'college': $sql = "
            SELECT 
            college.col_name, 
            college.tel, 
            college.email, 
            CONCAT(college.col_village,', ',college.col_district,', ',college.col_province) AS col_address, 
            
            (SELECT COUNT(member.gender) from member JOIN groups ON groups.id = member.group_id WHERE groups.col_id = college.col_id AND member.status != 2) AS total_member, 
            (SELECT COUNT(member.gender) from member JOIN groups ON groups.id = member.group_id WHERE groups.col_id = college.col_id AND member.gender = 'ຍິງ' AND member.status != 2) AS female_member 
            from college
            ORDER BY total_member DESC;
            ";
        break;
        case 'member': $sql = "
            SELECT
            (SELECT college.col_name FROM college WHERE college.col_id = member.col_id) AS col_name,
            COUNT(mem_id) AS all_member,
            COUNT(CASE WHEN gender = 'ຍິງ' THEN 1 END) AS female,
            COUNT(CASE WHEN role = 3 THEN 1 END) AS student,
            COUNT(CASE WHEN role = 3 AND gender = 'ຍິງ' THEN 1 END) AS student_female
            FROM member 
            JOIN college ON college.col_id = member.col_id
            ";

            if($otherQuery != null){
                $sql .= $otherQuery;
            }else{
                $sql .= " 
                WHERE (YEAR(join_local) <= ". date('Y') ." AND member.status = 1 )
                ";
            }

            $sql .= "
                GROUP BY college.col_id
                ORDER BY college.col_id;
            ";
        break;
        case 'fee': $sql = "
            SELECT 
            (SELECT college.col_name FROM college WHERE college.col_id = groups.col_id) AS col_name,
            COUNT(member.mem_id) AS all_member,
            COUNT(CASE WHEN gender = 'ຍິງ' THEN 1 END) AS female,
            COUNT(CASE WHEN role <> 3 THEN 1 END) AS committee,
            COUNT(CASE WHEN role <> 3 AND gender = 'ຍິງ' THEN 1 END) AS committee_female,
            COUNT(CASE WHEN role = 3 THEN 1 END) AS student,
            COUNT(CASE WHEN role = 3 AND gender = 'ຍິງ' THEN 1 END) AS student_female,
            (SELECT COUNT(member.mem_id) FROM member JOIN groups ON groups.id = member.group_id WHERE groups.col_id = 1) - 
            COUNT(member.mem_id) AS not_pay
            FROM member
            LEFT JOIN membership_fee ON membership_fee.mem_id = member.mem_id
            LEFT JOIN groups ON  groups.id = member.group_id
            
            ";

                if($otherQuery != null){
                    $sql .= $otherQuery;
                }else{
                    $sql .= " 
                    WHERE YEAR(membership_fee.pay_date) <= '".date('Y')."'
                    ";
                }

            $sql .="
                GROUP BY groups.col_id
                ORDER BY groups.col_id;
            ";
        break;
        case 'in': $sql = "
            SELECT (SELECT college.col_name FROM college WHERE college.col_id = member_in.col_id) AS col_name,
            COUNT(gender) AS all_member,
            COUNT(CASE WHEN gender = 'ຍິງ' THEN 1 END) AS female,
            COUNT(CASE WHEN role <> 3 THEN 1 END) AS committee,
            COUNT(CASE WHEN role <> 3 AND gender = 'ຍິງ' THEN 1 END) AS committee_female,
            COUNT(CASE WHEN role = 3 THEN 1 END) AS student,
            COUNT(CASE WHEN role = 3 AND gender = 'ຍິງ' THEN 1 END) AS student_female
            FROM member
            JOIN member_in ON member.mem_id = member_in.mem_id
            ";

                if($otherQuery != null){
                    $sql .= $otherQuery;
                }else{
                    $sql .= " 
                    WHERE YEAR(member_in.issue_date) <= '".date('Y')."'
                    ";
                }

            $sql .=" GROUP BY member_in.col_id; ";

        break;
        case 'out': $sql = "
            SELECT (SELECT college.col_name FROM college WHERE college.col_id = member_out.col_id) AS col_name,
            COUNT(gender) AS all_member,
            COUNT(CASE WHEN gender = 'ຍິງ' THEN 1 END) AS female,
            COUNT(CASE WHEN role <> 3 THEN 1 END) AS committee,
            COUNT(CASE WHEN role <> 3 AND gender = 'ຍິງ' THEN 1 END) AS committee_female,
            COUNT(CASE WHEN role = 3 THEN 1 END) AS student,
            COUNT(CASE WHEN role = 3 AND gender = 'ຍິງ' THEN 1 END) AS student_female
            FROM member
            JOIN member_out ON member.mem_id = member_out.mem_id
            ";

                if($otherQuery != null){
                    $sql .= $otherQuery;
                }else{
                    $sql .= " 
                    WHERE YEAR(member_out.issue_date) <= ".date('Y')."
                    ";
                }

            $sql .=" GROUP BY member_out.col_id; ";
        break;
        case 'activity': $sql = "
            SELECT 
            activity.*,
            DATE_FORMAT(act_date,'%d/%m/%Y') AS a_d ,
            (SELECT col_name FROM college WHERE college.col_id = activity.col_id) AS col_name
            FROM activity 
            ";
            
            if($otherQuery != null){
                $sql .= $otherQuery;
            }else{
                $sql .= "
                    WHERE YEAR(act_date) <= ".date('Y')."
                    ";
            }
        break;
    }
    
    return $sql;
}

function showQuarter(){
    $str = '<div class="col-2">
    <select name="quarter" class="form-control">
        <option value="">ທຸກໄຕມາດ</option>
        <option '.(@$_GET['quarter']==1?'selected':'').' value="1">ໄຕມາດ 1</option>
        <option '.(@$_GET['quarter']==2?'selected':'').'  value="2">ໄຕມາດ 2</option>
        <option '.(@$_GET['quarter']==3?'selected':'').'  value="3">ໄຕມາດ 3</option>
        <option '.(@$_GET['quarter']==4?'selected':'').'  value="4">ໄຕມາດ 4</option>
    </select>
</div>';
return $str;
}


function encrypt_decrypt($action, $string) 
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'LaoTopCollege';
        $secret_iv = '5477269772039986';

        // $encrypt_method = getenv('encrypt_method');
        // $secret_key = getenv('secret_key');
        // $secret_iv = getenv('secret_iv');


        // hash
        $key = hash('sha256', $secret_key);    
        // iv - encrypt method AES-256-CBC expects 16 bytes 
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }