<?php
session_start();
$current_page = "Login";
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
echo password_hash("spsvtv", PASSWORD_DEFAULT);
?>

<!--ຮູບ-->
<div class="col-md-4 offset-md-4 mb-4 mt-4">
  <div class="row">
    <div class="offset-2 col-3"><img class="img-fluid" src="image/private_ed_logo.png" alt="ສະມາຄົມການສຶກສາພາກເອກະຊົນ"></div>
    <div class="col-2"></div>
    <div class="col-3"><img class="img-fluid" src="image/trade_union_logo.png" alt="ສະມາຄົມການສຶກສາພາກເອກະຊົນ"></div>
  </div>
</div>



<!-- ສ້າງລ໊ອກອິນຟອມ -->
<div class="col-md-4 offset-md-4">

  <h1 class="text-center">ຟອມເຂົ້າສູ່ລະບົບ</h1>
  <?php
    if(isset($_SESSION['error_msg'])){
      echo $_SESSION['error_msg'];
      unset($_SESSION['error_msg']);
    }
  ?>
  <form action="login_process.php" method="post">
    <div class="mb-3">
      <label for="username" class="form-label">ບັນຊີຜູ້ໃຊ້</label>
      <input type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="ປ້ອນບັນຊີຜູ້ໃຊ້">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">ລະຫັດຜ່ານ</label>
      <input type="password" name="password" class="form-control" id="password" placeholder="ປ້ອນລະຫັດຜ່ານ">
    </div>
    <button type="submit" class="btn btn-primary col-md-6 offset-md-3">ເຂົ້າສູ່ລະບົບ</button>
    <a href="#" class="btn btn-link col-md-6 offset-md-3">ລົງຖະບຽນສະມາຊິກໃໝ່</a>
  </form>

</div>

<!-- ສ່ວນທ້າຍ -->
<div class="fixed-bottom alert alert-info text-center pt-3">
  <p>ສະມາຄົມການສຶກສາພາກເອກະຊົນ, ຫ້ອງການທີ່ ບ້ານ ບຶງຂະຫຍອງ <br>
  ເມືອງ ສີສັດຕະນາກ, ນະຄອນຫຼວງວຽງຈັນ<br>
  ໂທ 021 123 456
  </p>
</div>

<?php
require __DIR__ . '/footer.php';
?>