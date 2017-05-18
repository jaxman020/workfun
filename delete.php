<meta charset="UTF8">
<?php
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$username = $_POST['eid'];
$member->delete_e($username);//使用刪除使用者函數
?>