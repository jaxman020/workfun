<meta charset="UTF8">
<?php
error_reporting(0);
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$emp_num = $_POST['emp_num'];
$emp_name = $_POST['emp_name'];
$emp_idnum = $_POST['emp_idnum'];
$emp_phone = $_POST['emp_phone'];
$emp_imei = $_POST['emp_imei'];
$office_num = $_POST['office_num'];
$member->update_e($emp_num, $emp_name, $emp_idnum, $emp_phone, $emp_imei, $office_num);//使用更新使用者函數
?>