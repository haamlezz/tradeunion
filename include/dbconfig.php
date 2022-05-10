<?php
//ສ້າງການເຊື່ອມຕໍ່ຖານຂໍ້ມູນ
$con = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$con->set_charset("utf8");
//ກວດສອບການເຊື່ອມຕໍ່ ຖ້າຫາກຜິດພາດໃຫ້ສະແດງຂໍ້ຜິດພາດ
if($con->connect_error){
    die('Database Connection failed: '. $con->connect_error);
}