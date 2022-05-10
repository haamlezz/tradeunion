<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="image/private_ed_logo.png" class="img-fluid" width="40" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      
        <li class="nav-item">
          <a class="nav-link <?= $current_page=='home'?'active':''; ?>" aria-current="page" href="index.php">ໜ້າຫຼັກ</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= $current_page=='college'?'active':''; ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ຮາກຖານ
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="college.php">ຂໍ້ມູນຮາກຖານ</a></li>
            <li><a class="dropdown-item" href="activity.php">ຂໍ້ມູນການເຄື່ອນໄຫວ</a></li>
            <li><a class="dropdown-item" href="group.php">ຂໍ້ມູນຈຸ</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= $current_page=='member'?'active':''; ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ສະມາຊິກ
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="member.php">ຂໍ້ມູນສະມາຊິກ</a></li>
            <li><a class="dropdown-item" href="membership_fee.php">ຂໍ້ມູນການເສຍຄ່າສະຕິ</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= $current_page=='move'?'active':''; ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ຍົກຍ້າຍ
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="move_in.php">ຂໍ້ມູນຍ້າຍເຂົ້າ</a></li>
            <li><a class="dropdown-item" href="#">ຂໍ້ມູນຍ້າຍອອກ</a></li>
          </ul>
        </li>
        
        <?php if($_SESSION['role']==1):?>
        <li class="nav-item">
          <a class="nav-link <?= $current_page=='yearly_fee'?'active':''; ?>" href="yearly_fee.php">ຄ່າສະຕິປະຈຳປີ</a>
        </li>
        <?php endif;?>

        <li class="nav-item">
          <a class="nav-link" href="logout.php">ອອກລະບົບ</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="ຄົ້ນຫາ..." aria-label="Search">
        <button class="btn btn-success" type="submit">ຄົ້ນຫາ</button>
      </form>
    </div>
  </div>
</nav>