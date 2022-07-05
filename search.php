<?php
session_start();
$current_page = 'home';
require_once __DIR__ . '/include/define.php';
require_once __DIR__ . '/include/function.php';
require_once __DIR__ . '/include/dbconfig.php';
require_once __DIR__ . '/header.php';
if (!islogin()) {
    header('Location:login.php');
}

if (isMember()) restrictPage();


require_once __DIR__ . '/menu.php';
if ($_GET) :
?>

    <div class="container mt-3">
        <h2 class="mb-3">ຜົນການຄົ້ນຫາ</h2>
        <?php

        $search = mysqli_real_escape_string($con, $_GET['search']);

        $sql = "SELECT 
                member.mem_id, 
                member.username, 
                member.role,
                CONCAT(member.firstname,' ', member.lastname) AS fullname, 
                (SELECT group_name FROM groups WHERE groups.id = member.group_id) AS g_name,
                (SELECT college.col_name FROM  college WHERE groups.col_id = college.col_id) AS c_name
                FROM member 
                JOIN groups ON member.group_id = groups.id
                WHERE (member.firstname LIKE '%" . $search . "%' OR member.lastname LIKE '%" . $search . "%' OR member.username LIKE '%" . $search . "%')
                ";
        if (isCommittee()) {
            $sql .= " AND (member.col_id = " . $_SESSION['college_id'] . ") ";
        }

        $rs = $con->query($sql);

        echo $con->error;
        

        if ($rs->num_rows == 0) {
            echo '<div class="alert alert-warning">ບໍ່ພົບຂໍ້ມູນທີ່ຄົ້ນຫາ</div>';
        } else {
            echo '<h5 class="text-secondary mb-3">ພົບ ' . $rs->num_rows . ' ຂໍ້ມູນ</h5>';
            echo '<table class="table table-hover">';
            echo '<tr>
                <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                <th>ຮາກຖານ</th>
                <th>ສັງກັດ</th>
                <th>ດຳເນີນການ</th>
            </tr>';
            while ($row = $rs->fetch_assoc()) {
                echo '
                    <tr>
                        
                        <td>' . $row['fullname']. '&nbsp; &nbsp;';

                        switch ($row['role']) {
                            case 1:
                                echo '<span class="badge bg-primary">ຄະນະບໍລິຫານ</span>';
                                break;
                            case 2:
                                echo '<span class="badge bg-warning">ຮາກຖານ</span>';
                        }
                        
                echo    '</td>';
                if(isAdmin()){
                    echo '<td>'.$row['c_name'].'</td>';
                }
                echo    '<td>' . $row['g_name'] . '</td>
                        <td>';
                if ($row['role'] != 1) {
                    echo '      <a class="btn btn-primary btn-sm" href="member_add.php?member_id=' . $row['mem_id'] . '"><i class="fa fa-pencil"></i> ແກ້ໄຂ</a>';
                }
                echo '      <a class="btn btn-warning btn-sm" target="_blank" href="member_section.php?username=' . $row['username'] . '"><i class="fas fa-eye"></i> ສະແດງ</a>
                        </td>
                    </tr>
                ';
            }
            echo '</table>';
        }
        ?>
    </div>


<?php
endif;
require __DIR__ . '/footer.php';
?>