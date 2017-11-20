<meta charset="UTF8">
<?php
error_reporting(0);
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$manager_num = $_POST['manager_num'];
$manager_name = $_POST['manager_name'];
$manager_idnum = $_POST['manager_idnum'];
$manager_phone = $_POST['manager_phone'];
$manager_imei = $_POST['manager_imei'];
$member->update_m($manager_num, $manager_name, $manager_idnum, $manager_phone, $manager_imei);//使用更新使用者函數
?>