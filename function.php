<?php

require_once("config.inc.php");

class member
{
    var $login;
    var $login_sql;
    var $login_row;
    var $select_e;
    var $select_r;
    var $select_a;
    var $select_b;
    var $insert_e;
    var $insert_a;
    var $delete_e;
    
    //登入函數
    function login($username, $password) 
    {
        global $db;
        $this->login_sql="SELECT * FROM `account` WHERE `acc`=:username AND `pwd`=:password;";
		$this->login = $db->prepare($this->login_sql);
		$this->login->bindParam(":username", $username);
        $this->login->bindParam(":password", $password);
		$this->login->execute();
		$this->login_row = $this->login->fetch();
        if($username == null)
        {
            echo"<script>alert('錯誤！使用者名稱不能為空！')</script>";
            echo "<script>history.go(-1);</script>";
        }
        elseif($password == null)
        {
            echo"<script>alert('錯誤！密碼不能為空！')</script>";
            echo "<script>history.go(-1);</script>";
        }
        elseif($username != $this -> login_row['acc'] or $password != $this -> login_row['pwd'])
        {
            echo"<span style=\"color:red;\">錯誤！查無使用者或密碼錯誤！</span>";
			echo "<script>history.go(-1);</script>";
        }
        else{
            if($username = $this -> login_row['acc'])
            {
                echo"<span style=\"color:green;\">登入成功！</span>";
                $_SESSION['LoginSuccess'] = true;
                echo'<meta http-equiv="refresh" content="2; url=main.php">';
                $_SESSION['username']=$username;
            }
            else
            {
                echo"<span style=\"color:red;\">登入失敗！</span>";
                echo "<script>history.go(-1);</script>";
            }
        }
    }
    
    function select_e()
    {
		global $db;
        $stat = $db->prepare("select * from employee;");
        $stat->execute();
        echo "<table style='border: solid 3px black;'><tr><th>EID</th><th style='border: solid 3px black;'>名字</th><th style='border: solid 3px black;'>性別</th>
        <th style='border: solid 3px black;'>生日</th><th style='border: solid 3px black;'>電話</th><th style='border: solid 3px black;'>身分證字號</th>
        <th style='border: solid 3px black;'>職稱</th><th style='border: solid 3px black;'>住址</th><th style='border: solid 3px black;'>電子郵件</th>
        <th style='border: solid 3px black;'>DID</th></tr>";
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><th style='border: solid 3px black;'>". $row["eid"]. 
                 "</th><th style='border: solid 3px black;'>". $row["ename"]. 
                 "</th><th style='border: solid 3px black;'>". $row["sex"]. 
                 "</th><th style='border: solid 3px black;'>". $row["bir"].
                 "</th><th style='border: solid 3px black;'>". $row["phone"].
                 "</th><th style='border: solid 3px black;'>". $row["idnum"].
                 "</th><th style='border: solid 3px black;'>". $row["pos"].
                 "</th><th style='border: solid 3px black;'>". $row["add"]. 
                 "</th><th style='border: solid 3px black;'>". $row["email"].
                 "</th><th style='border: solid 3px black;'>". $row["did"]."</th></tr>";}
	}
    
    function select_r($username) 
    {
        global $db;
        $stat = $db->prepare("select * from record;");
        $stat->execute();
        echo "<table style='border: solid 3px black;'><tr><th>EID</th>
                <th style='border: solid 3px black;'>DID</th>
                <th style='border: solid 3px black;'>RID</th>
                <th style='border: solid 3px black;'>上班</th>
                <th style='border: solid 3px black;'>下班</th></tr>";
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
        echo "<tr><th style='border: solid 3px black;'>". $row["eid"]. 
             "</th><th style='border: solid 3px black;'>". $row["did"]. 
             "</th><th style='border: solid 3px black;'>". $row["rid"].   
             "</th><th style='border: solid 3px black;'>". $row["F1"].
             "</th><th style='border: solid 3px black;'>". $row["F2"]."</th></tr>";}  
    }
    
    function select_a($username) 
    {
        global $db;
        $stat = $db->prepare("select * from account ");
        $stat->bindParam(':username',$username);
        $stat->execute();
        echo "<table style='border: solid 3px black;'><tr><th>EID</th>
        <th style='border: solid 3px black;'>帳號</th>
        <th style='border: solid 3px black;'>密碼</th>
        <th style='border: solid 3px black;'>IMEI</th></tr>";
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><th style='border: solid 3px black;'>". $row["eid"]. 
                 "</th><th style='border: solid 3px black;'>". $row["acc"]. 
                 "</th><th style='border: solid 3px black;'>". $row["pwd"].
                 "</th><th style='border: solid 3px black;'>". $row["IMEI"]."</th></tr>";}
    }
    
    function select_b() 
    {
        global $db;
        $stat = $db->prepare("select * from board;");
        $stat->execute();
        echo "<table style='border: solid 3px black;'><tr><th>日期</th>
        <th style='border: solid 3px black;'>公告</th></tr>";
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
        echo 
            "<tr><th style='border: solid 3px black;'>". $row["date"]. 
            "</th><th style='border: solid 3px black;'>".$row["txt"]. "</th></tr>";}
    }
    function insert_e($eid, $ename, $sex, $bir, $phone, $idnum, $pos, $add, $email, $did) {
        global $db;
        $stat = $db->prepare("INSERT INTO employee(eid, ename, sex, bir, phone, idnum, pos, add, email, did) VALUES (':eid',':ename',':sex',':bir',':phone',':idnum',':pos',':add',':email',':did');");
        $stat->bindParam(':eid',$eid);
        $stat->bindParam(':ename',$ename);
        $stat->bindParam(':sex',$sex);
        $stat->bindParam(':bir',$bir);
        $stat->bindParam(':phone',$phone);
        $stat->bindParam(':idnum',$idnum);
        $stat->bindParam(':pos',$pos);
        $stat->bindParam(':add',$add);
        $stat->bindParam(':email',$email);
        $stat->bindParam(':did',$did);
        if($stat->execute())
        {
            echo"<span style=\"color:green;\">新增成功！</span>";
            echo "<script>history.go(-1);</script>";
        }
        else
        {
            echo"<script>alert('新增失敗！');</script>";
            echo "<script>history.go(-1);</script>";
        }
    }
    
    function insert_a($eid, $acc, $pwd, $imei) {
        global $db;
        $stat = $db->prepare("INSERT INTO `account`(`eid`, `acc`, `pwd`, `IMEI`) VALUES (:eid, :acc, :pwd, :imei);");
        $stat->bindParam(':eid',$eid);
        $stat->bindParam(':acc',$acc);
        $stat->bindParam(':pwd',$pwd);
        $stat->bindParam(':imei',$imei);
        if($stat->execute())
        {
            echo"<span style=\"color:green;\">新增成功！</span>";
            echo "<script>history.go(-1);</script>";
        }
        else
        {
            echo"<script>alert('新增失敗！');</script>";
            echo "<script>history.go(-1);</script>";
        }
    }
    
    function delete_e($eid) 
    {
        global $db;
        if($_SESSION['LoginSuccess']== true)
		{
            $stat =$db->prepare("DELETE FROM employee WHERE eid=:eid;");
            $stat->bindParam(':eid', $eid);
            if($eid == null)
            {
                echo"<span style=\"color:red;\">錯誤！不能為空！</span>";
                echo "<script>history.go(-1);</script>";
                
            }
            
            elseif($stat->execute())
                {
                    echo"<span style=\"color:green;\">刪除成功！</span>";
                    echo "<script>history.go(-1);</script>";
                }
            else
                {
                    echo"<span style=\"color:red;\">刪除失敗！</span>";
                    echo "<script>history.go(-1);</script>";
                }
        }
    }
    
}
?>