<meta charset="UTF8">
<?php
error_reporting(0);
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$board_id = $_POST['board_id'];
$office_num = $_POST['office_num'];
$board_time = $_POST['board_time'];
$board_content = $_POST['board_content'];
$member->update_b($board_id, $office_num, $board_time, $board_content);//使用更新使用者函數
?>