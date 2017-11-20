<meta charset="UTF8">
<?php
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$record_id = $_GET['record_id'];
$member->delete_r($record_id);//使用刪除使用者函數
?>