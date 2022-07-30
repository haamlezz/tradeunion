<?php
session_start();
$current_page = "Login";
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
//require_once __DIR__ . '/header.php';

if ($_POST) {

    $username = mysqli_real_escape_string($con, $_POST['username']);

    $password = $_POST['password'];

    $sql = "SELECT 
            username, 
            member.role, 
            group_id, 
            member.password, 
            member.status, 
            member.col_id,
            member.mem_id
            FROM member 
            WHERE username = '$username'";
    
    $rs = $con->query($sql);
    // echo $con->error;
    
    if ($rs->num_rows == 0) {
        $_SESSION['error_msg'] = '<div class="alert alert-danger">ຊື່ບັນຊີ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ, ກະລຸນາລອງໃໝ່ອີກຄັ້ງ</div>';
        header('Location:login.php');
    } else {
        unset($_SESSION['login_attemp']);
        $row = $rs->fetch_assoc();
        if ($row['status'] == 0) {
            header('Location:not_active.php');
        } else {

            if (password_verify($password, $row['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $row['role'];
                $_SESSION['member_id'] = $row['mem_id'];

                //KEY ENCRYPT
                $_SESSION['ciphering']='AES-128-CTR';
                $_SESSION['encryption_iv']='5477269772039986';
                $_SESSION['encryption_key']=';ymtpkw]]k;{mHv[';

                // $sql = "SELECT groups.col_id, college.col_id as college_id FROM groups JOIN college ON groups.col_id = college.col_id WHERE groups.id = ?";
                // $rs2 = prepared_stm($con, $sql, [$row['group_id']], "i")->get_result();
                // $row2 = $rs2->fetch_assoc();
                $_SESSION['college_id'] = $row['col_id'];

                $_SESSION['error_msg'] = null;

                if ($row['role'] == 3) {
                    header('Location:member_section.php');
                } else {
                    header('Location:index.php');
                }
            } else {
                if (isset($_SESSION['login_attempt'])) {
                    $_SESSION['login_attempt'] += 1;
                    if ($_SESSION['login_attempt'] >= 3) {
                        // echo '<div class="alert alert-info text-center">
                        //     ທ່ານໃສ່ລະຫັດຜິດຫຼາຍຄັ້ງ ກະລຸນາລໍຖ້າ 10 ວິນາທີ
                        // </div>';
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
    }
}




//require __DIR__ . '/footer.php';
