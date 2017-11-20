<meta charset="UTF8">
<?php
error_reporting(0);
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$message_id = $_POST['message_id'];
$emp_num = $_POST['emp_num'];
$emp_name = $_POST['emp_name'];
$emp_imei = $_POST['emp_imei'];
$message_content = $_POST['message_content'];
$message_time = $_POST['essage_time'];
$message_email = $_POST['message_email'];
$member->update_me($message_id, $emp_num, $emp_name, $emp_imei, $message_content, $message_time, $message_email);//使用更新使用者函數
?>