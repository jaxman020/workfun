<meta charset="UTF8">
<?php
error_reporting(0);
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$eid = $_POST['eid'];
$acc = $_POST['acc'];
$pwd = $_POST['pwd'];
$imei = $_POST['imei'];
$member->insert_a($eid,$acc,$pwd,$imei);//使用新增使用者函數
?>