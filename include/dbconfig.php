<?php

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);
$con->set_charset("utf8");

// //ສ້າງການເຊື່ອມຕໍ່ຖານຂໍ້ມູນ
// $con = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
// $con->set_charset("utf8");
// //ກວດສອບການເຊື່ອມຕໍ່ ຖ້າຫາກຜິດພາດໃຫ້ສະແດງຂໍ້ຜິດພາດ
// if($con->connect_error){
//     die('Database Connection failed: '. $con->connect_error);
// }

//mysql://baa1297f06529c:8b12aaab@us-cdbr-east-05.cleardb.net/heroku_174c0b283fa36b4?reconnect=true