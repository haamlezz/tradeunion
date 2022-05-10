<?php
session_start();
$current_page = 'member';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
if (!islogin()) {
    header('Location:login.php');
}
if ($_POST) {
    $member_id = $con->real_escape_string($_POST['member_id']);
    $sql = "SELECT member.*, date_format(join_trade_union_date, '%d/%m/%Y') AS jtd, date_format(join_party_date, '%d/%m/%Y') AS jpd,date_format(join_women_union_date, '%d/%m/%Y') AS jwd, col_name, group_name FROM member JOIN groups ON member.group_id = groups.id JOIN college ON groups.col_id = college.col_id WHERE mem_id = ? ";
    $rs = prepared_stm($con, $sql, [$member_id])->get_result();
    $row = $rs->fetch_assoc();
    $jpd = $row['jpd'];
    if($row['jpd']==null){
        $jpd = 'ບໍ່ໄດ້ເປັນສະມາຊິກ';
    }

    $jwd = $row['jwd'];
    if($row['jwd']==null){
        $jwd = 'ບໍ່ໄດ້ເປັນສະມາຊິກ';
    }
    $str = '
        <h3>' . $row['firstname'] . ' ' . $row['lastname'] . '</h3>
        <div class="row">
        <div class="col-4">
            <i class="fas fa-map-marker"></i> ຮາກຖານ: <br/> <span class="h3">' . $row['col_name'] . '</span>
        </div>

        <div class="col-4">
            <i class="fas fa-user-group"></i> ສັງກັດ: <br/> <span class="h3"> ' . $row['group_name'] . '</span>
        </div>

        <div class="col-4">
            <i class="fas fa-calendar-days"></i> ເຂົ້າກຳມະບານ: <br/> <span class="h3"> ' . $row['jtd'] . '</span>
        </div>
        </div>
        
        <hr class="mb-2 mt-2">

        <div class="row">
            <div class="col-6" style="border-right: solid grey thin;">
                <h4>ຂໍ້ມູນສ່ວນໂຕ</h4>
                <div class="row">
                    <div class="col-3"><p class="text-secondary">ບ້ານເກີດທີ່:</p></div>
                    <div class="col-9">
                    <p>
                    ບ້ານ '.$row['h_village'].'<br>
                    ເມືອງ '.$row['h_district'].'<br>
                    ແຂວງ '.$row['h_province'].'<br>
                        </p>    
                    </div>
                </div>

                <div class="row">
                    <div class="col-3"><p class="text-secondary">ປະຈຸບັນຢູ່ທີ່:</p></div>
                    <div class="col-9">
                    <p>
                    ບ້ານ '.$row['addr_village'].'<br>
                    ເມືອງ '.$row['addr_district'].'<br>
                    ແຂວງ '.$row['addr_province'].'<br>
                </p>  
                    </div>
                </div>
                
                
                
                
            </div>
            <div class="col-6">
                <h4>ຂໍ້ມູນອື່ນໆ</h4>
                <div class="row">
                    <div class="col-3"><p class="text-secondary">ວັນທີເຂົ້າພັກ:</p></div>
                    <div class="col-9">
                    <p >'.$jpd.'</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3"><p class="text-secondary">ວັນທີເຂົ້າແມ່ຍິງ:</p></div>
                    <div class="col-9">
                    <p >'.$jwd.'</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-3"><p class="text-secondary">ເລກທີປຶ້ມ:</p></div>
                    <div class="col-9">
                    <p>'.$row['book_no'].'</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-3"><p class="text-secondary">ສະຖານະ:</p></div>
                    <div class="col-9">                    
                    <p>'.$row['status']='0'?'ປິດໃຊ້ງານ':'ອະນຸມັດໃຊ້ງານ'.'</p>
                    </div>
                </div>
                
                
            </div>
        </div>
        
    ';
    echo $str;
}
