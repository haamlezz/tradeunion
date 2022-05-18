<?php
session_start();
$current_page = '';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
?>

<div class="container mt-3 mb-3">
    <div class="alert alert-info text-center">
        ບັນຊີນີ້ຍັງບໍ່ທັນຖືກເປີດໃຊ້ງານ, ໃຫ້ຕິດຕໍ່ຫາຄະນະກຳມະບານປະຈຳຮາກຖານ ເພື່ອເປີດໃຊ້ງານ <br>
        <a href="login.php">ເຂົ້າສູ່ລະບົບອີກຄັ້ງ</a>
    </div>
</div><!-- fluid -->
<?php
require __DIR__ . '/footer.php';
?>