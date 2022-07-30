<?php
session_start();
$current_page = 'college';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
//require __DIR__ . '/header.php';
if (!islogin()) {
    header('Location:login.php');
}
if (!isAdmin()) {
    restrictPage();
}
if ($_POST) {
    echo '<option value="0">ເລືອກຈຸສັງກັດ</option>';
    $sql = "SELECT * FROM groups WHERE col_id = ".@$_POST['col_id']." ORDER BY group_name";
    $rs = mysqli_query($con, $sql);
    if($rs){
        if (mysqli_num_rows($rs) > 0) {
            while ($row2 = mysqli_fetch_array($rs)) {
                echo '<option value="' . $row2['id'] . '"';
                echo @$_POST['group_id'] == $row2['id'] ? 'selected' : '';
                echo '>' . $row2['group_name'] . '</option>';
            }
        }
    }
    
}
