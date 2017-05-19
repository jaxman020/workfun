<meta charset="UTF8">
<?php
error_reporting(0);
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
$member = new member();
$eid = $_POST['eid'];
$ename = $_POST['ename'];
$sex = $_POST['sex'];
$bir = $_POST['bir'];
$phone = $_POST['phone'];
$idnum = $_POST['idnum'];
$pos = $_POST['pos'];
$add = $_POST['add'];
$email = $_POST['email'];
$did = $_POST['did'];
$member->insert_e($eid,$ename,$sex,$bir,$phone,$idnum,$pos,$add,$email,did);//使用新增使用者函數
?>