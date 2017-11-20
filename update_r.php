<meta charset="UTF8">
<?php
error_reporting(0);
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$record_id = $_POST['record_id'];
$emp_num = $_POST['emp_num'];
$office_num = $_POST['office_num'];
$record_time = $_POST['record_time'];
$record_status = $_POST['record_status'];
$imei = $_POST['imei'];
$member->update_r($record_id, $emp_num, $office_num, $record_time, $record_status, $imei);//使用更新使用者函數
?>