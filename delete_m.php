<meta charset="UTF8">
<?php
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$manager_num = $_GET['manager_num'];
$member->delete_m($manager_num);//使用刪除使用者函數
?>