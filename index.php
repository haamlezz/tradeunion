<?php
session_start();
$current_page='home';
require_once __DIR__.'/include/define.php';
require_once __DIR__.'/include/function.php';
require_once __DIR__.'/include/dbconfig.php';
require_once __DIR__.'/header.php';
require_once __DIR__.'/menu.php';
if(!islogin()){header('Location:login.php');}
?>

<div class="container mt-3">
    Hi! <?= $_SESSION['username'];?>
    <h2>ໜ້າຫຼັກ</h2>

</div>


<?php
require __DIR__.'/footer.php';
?>