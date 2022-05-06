<?php
session_start();
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';

sleep(1);


if ($_POST) {

    $username = filter_input(INPUT_POST, 'username');

    $password = filter_input(INPUT_POST, 'password');

    $sql = "SELECT username, member.role, group_id, member.password FROM member WHERE username = ?";
    
    $rs = prepared_stm($con, $sql, [$username])->get_result();
    
    $row = $rs->fetch_assoc();
    print_r($row);
    if ($rs->num_rows == 1 && password_verify($password, $row['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role'];

        $sql = "SELECT groups.col_id, college.col_id as college_id FROM groups JOIN college ON groups.col_id = college.col_id WHERE groups.id = ?";
        $rs2 = prepared_stm($con, $sql, [$row['group_id']],"i")->get_result();
        $row2 = $rs2->fetch_assoc();
        $_SESSION['college_id'] = $row2['college_id'];

        $_SESSION['error_msg'] = null;
        header('Location:index.php');
    } else {
        if (isset($_SESSION['login_attempt'])) {
            $_SESSION['login_attempt'] += 1;
            if ($_SESSION['login_attempt'] >= 3) {
                echo '<div class="alert alert-info text-center">
                        ທ່ານໃສ່ລະຫັດຜິດຫຼາຍຄັ້ງ ກະລຸນາລໍຖ້າ 10 ວິນາທີ
                    </div>';
                sleep(10);
                $_SESSION['login_attempt'] = 0;
            }
        } else {
            $_SESSION['login_attempt'] = 1;
        }

        $_SESSION['error_msg'] = '<div class="alert alert-danger">ຊື່ບັນຊີ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ, ກະລຸນາລອງໃໝ່ອີກຄັ້ງ</div>';
        header('Location:login.php');
    }
}




require __DIR__ . '/footer.php';
