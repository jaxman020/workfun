<?php
if(isset($_POST['insert'])){
    require_once('config.php');

    $con = DB_TYPE .":host=".DB_HOSTNAME .";dbname=". DB_NAME . ";charset=". DB_CHARSET;

    try{
        $db =new PDO($con, DB_USERNAME, DB_PASSWORD);
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    
    $eid = $_POST['eid'];
    $acc = $_POST['acc'];
    $pwd = $_POST['pwd'];
    $imei = $_POST['imei'];
    
    $pdoquery = "INSERT INTO `account` (`eid`, `acc`, `pwd`, `imei`)VALUES (:eid, :acc, :pwd, :imei);";
    
    $pdoResult = $db->prepare($pdoquery);
    
    $pdoExec = $pdoResult->execute(array(":eid"=>$eid, ":acc"=>$acc, ":pwd"=>$pwd, ":imei"=>$imei));
    
    if($pdoExec)
    {
        echo 'ok';
    }else{
        echo 'no';
    }
}

?>


<meta charset="UTF8">
<html>
	<form action="tryinsert.php" method="POST">
        <div class=out1 style='text-align:center'>EID：<input type="text" name="eid"><p></div>
        <div class=out1 style='text-align:center'>帳號：<input type="text" name="acc"><p></div>
        <div class=out1 style='text-align:center'>密碼：<input type="text" name="pwd"><p></div>
        <div class=out1 style='text-align:center'>IMEI：<input type="text" name="imei"><p></div>
        <div class=out1 style='text-align:center'><input type="submit" name='insert' value="送出"></div>
    </form>
    <div id="featured">
		<div class="container">
            <a href="main.php" class="button">返回</a>
        </div>
    </div>
</html>