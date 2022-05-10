<?php
session_start();
$current_page='college';
require_once __DIR__.'/include/define.php';
require_once __DIR__.'/include/function.php';
require_once __DIR__.'/include/dbconfig.php';
if(!islogin()){header('Location:login.php');}

if(isAdmin()|| isCommittee()){


$sql = "SELECT CONCAT(member.firstname, ' ', member.lastname) AS label, member.mem_id AS value FROM member JOIN groups ON groups.id = member.group_id WHERE groups.col_id = ".$_SESSION['college_id'];

$rs = mysqli_query($con, $sql);

$json = [];

while ($row = mysqli_fetch_assoc($rs)){
    $json[] = $row;
}

echo json_encode($json);
}