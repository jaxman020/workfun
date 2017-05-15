<meta charset="UTF8">
<?php 
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$username = $_POST['username'];
$password = $_POST['password'];
$member->login($username,$password);//使用登入函數

?>