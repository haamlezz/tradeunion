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
        echo $con->error;
        $stm->execute();
        
        return $stm;
    }else{
        echo $con->error;
        return 0;
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