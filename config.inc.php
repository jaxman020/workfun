<?php
//建立資料庫連線
require_once('config.php');

$con = DB_TYPE .":host=".DB_HOSTNAME .";dbname=". DB_NAME . ";charset=". DB_CHARSET;

try{
    $db =new PDO($con, DB_USERNAME, DB_PASSWORD);
}catch (PDOException $e) {
    echo $e->getMessage();
}

?>