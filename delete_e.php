<meta charset="UTF8">
<?php
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$emp_num = $_GET['emp_num'];
$member->delete_e($emp_num);//使用刪除使用者函數
?>