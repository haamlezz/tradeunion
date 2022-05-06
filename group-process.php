<?php
session_start();
$current_page='group';
require_once __DIR__.'/include/define.php';
require_once __DIR__.'/include/function.php';
require_once __DIR__.'/include/dbconfig.php';
if(!islogin()){header('Location:login.php');}

if($_POST){
    switch($_POST['doAction']){
        case 'add':
            if(!empty($_POST['groupName'])){
                $data = [$_POST ['groupName'], $_SESSION['college_id']];
                $sql = "INSERT INTO groups (group_name, col_id) VALUES (?,?)";
                $rs = prepared_stm($con, $sql, $data, 'ss' );
                echo $rs->affected_rows;
            }
            else{
                echo 2;
            }
            break;

        case 'edit': 
            if(!empty($_POST['groupId'])){
                $data=[$_POST['groupName'],$_POST['groupId'], $_SESSION['college_id']];
                $sql = "UPDATE groups SET group_name = ? WHERE id = ? AND col_id = ?";
                $rs = prepared_stm($con, $sql, $data, "sii");
                echo $rs->affected_rows;
            }else{
                echo 2;
            }
            break;

        case 'delete':
            if(!empty($_POST['groupId'])){
                $sql = "DELETE FROM groups WHERE id = ? AND col_id = ?";
                $rs = prepared_stm($con, $sql, [$_POST['groupId'],$_SESSION['college_id']], 'ii');
                echo $rs->affected_rows;
            }else{
                echo 2;
            }
            break;
    }
}