<?php
session_start();
$current_page = "Login";
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';

?>

<!--ຮູບ-->
<div class="col-md-4 offset-md-4 mb-4 mt-4">
  <div class="row">
    <div class="offset-2 col-3"><a href="login.php"><img class="img-fluid" src="image/private_ed_logo.png" alt="ສະມາຄົມການສຶກສາພາກເອກະຊົນ"></a></div>
    <div class="col-2"></div>
    <div class="col-3"><a href="login.php"><img class="img-fluid" src="image/trade_union_logo.png" alt="ສະມາຄົມການສຶກສາພາກເອກະຊົນ"></a></div>
  </div>
</div>

<!-- ສ້າງລ໊ອກອິນຟອມ -->
<div class="col-md-4 offset-md-4">
  <div class="container">


    <h1 class="text-center">ຟອມເຂົ້າສູ່ລະບົບ</h1>
    <?php
    if (isset($_SESSION['error_msg'])) {
      echo $_SESSION['error_msg'];
      unset($_SESSION['error_msg']);
    }
    ?>
    <form action="login_process.php" method="post">
      <div class="mb-3">
        <label for="username" class="form-label">ບັນຊີຜູ້ໃຊ້</label>
        <input type="text" required name="username" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="ປ້ອນບັນຊີຜູ້ໃຊ້">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">ລະຫັດຜ່ານ</label>
        <input type="password" required name="password" class="form-control" id="password" placeholder="ປ້ອນລະຫັດຜ່ານ">
      </div>

      <button type="submit" class="btn btn-primary col-12 mt-3">ເຂົ້າສູ່ລະບົບ</button>
    </form>
  </div>
</div>

<!-- ສ່ວນທ້າຍ -->
<div class="fixed-bottom bg-dark text-center text-white pt-2">
  <p>ສະມາຄົມການສຶກສາພາກເອກະຊົນ, ຫ້ອງການທີ່ ບ້ານ ບຶງຂະຫຍອງ <br>
    ເມືອງ ສີສັດຕະນາກ, ນະຄອນຫຼວງວຽງຈັນ<br>
  </p>
  <p class="text-center">
    <a href="tel:+8562098449644" class="text-white"><i class="fa fa-phone"></i> 020 98 449 644</a>
    &nbsp; | &nbsp;
    <a target="_blank" class="text-white" href="https://www.facebook.com/%E0%BA%AA%E0%BA%B0%E0%BA%AB%E0%BA%B0%E0%BA%9E%E0%BA%B1%E0%BA%99%E0%BA%81%E0%BA%B3%E0%BA%A1%E0%BA%B0%E0%BA%9A%E0%BA%B2%E0%BA%99%E0%BA%81%E0%BA%B2%E0%BA%99%E0%BA%AA%E0%BA%B6%E0%BA%81%E0%BA%AA%E0%BA%B2%E0%BA%9E%E0%BA%B2%E0%BA%81%E0%BB%80%E0%BA%AD%E0%BA%81%E0%BA%B0%E0%BA%8A%E0%BA%BB%E0%BA%99-%E0%BA%AA%E0%BA%81%E0%BA%81%E0%BA%AD-112925270894741/"><i class="fab fa-facebook-f"></i> ກຳມະບານ ສກອ</a>
    &nbsp; | &nbsp;
    <a target="_blank" class="text-white" href="https://wa.link/0w6mfb"><i class="fab fa-whatsapp"></i> WhatsApp</a>
  </p>
</div>

<?php
require __DIR__ . '/footer.php';
?>