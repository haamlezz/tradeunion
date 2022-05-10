<?php
session_start();
$current_page='college';
require_once __DIR__.'/include/define.php';
require_once __DIR__.'/include/function.php';
require_once __DIR__.'/include/dbconfig.php';
if(!islogin()){header('Location:login.php');}

if($_POST){
    switch($_POST['doAction']){
        case 'add':
            if(!empty($_POST['year']) && !empty($_POST['fee'])){
                $fee = str_replace(",", "", $_POST['fee']);
                $fee = str_replace("ກີບ", "", $fee);
                $data = [$_POST ['year'], $fee];
                $sql = "INSERT INTO yearly_fee (year, fee) VALUES (?,?)";
                $rs = prepared_stm($con, $sql, $data );
                echo $rs->affected_rows;
            }
            else{
                echo 2;
            }
            break;

        case 'edit': 
            if(!empty($_POST['feeid']) && !empty($_POST['year']) && !empty($_POST['fee'])){
                $data=[$_POST['year'],$_POST['fee'], $_POST['feeid']];
                $sql = "UPDATE yearly_fee SET year = ?, fee = ? WHERE id = ?";
                $rs = prepared_stm($con, $sql, $data);
                echo $rs->affected_rows;
            }else{
                echo 2;
            }
            break;

        case 'delete':
            if(!empty($_POST['feeid'])){
                $sql = "DELETE FROM fee WHERE id = ?";
                $rs = prepared_stm($con, $sql, [$_POST['feeid']]);
                echo $rs->affected_rows;
            }else{
                echo 2;
            }
            break;
    }
}