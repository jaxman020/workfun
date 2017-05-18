<?php

require_once("config.inc.php");

class member
{
    var $login;
    var $login_sql;
    var $login_row;
    var $select_b;
    var $select_r;
    var $table;
    var $select_sql;
    var $update;
    var $update_sql;
    var $delete_u;
    var $delete_sql;
    var $delete_e;
    var $detlete_row;
    var $getuser;
    var $getuser_sql;
    var $getuser_row;
    var $insert;
    
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
            echo"<span style=\"color:red;\">錯誤！使用者名稱不能為空！</span>";
			echo'<meta http-equiv="refresh" content="2; url=login.html">';
        }
        elseif($password == null)
        {
            echo"<span style=\"color:red;\">錯誤！密碼不能為空！</span>";
			echo'<meta http-equiv="refresh" content="2; url=login.html">';
        }
        elseif($username != $this -> login_row['acc'] or $password != $this -> login_row['pwd'])
        {
            echo"<span style=\"color:red;\">錯誤！查無使用者或密碼錯誤！</span>";
			echo'<meta http-equiv="refresh" content="2; url=login.html">';
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
                echo'<meta http-equiv="refresh" content="2; url=login.html">';
            }
        }
    }
    
    function select_e($username)
    {
		global $db;
        $stat = $db->prepare("select * from employee ;");
        $stat->bindParam(':username',$username);
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
        $stat->bindParam(':username',$username);
        $stat->execute();
        echo "<table style='border: solid 3px black;'><tr><th>EID</th><th style='border: solid 3px black;'>DID</th><th style='border: solid 3px black;'>RID</th>
        <th style='border: solid 3px black;'>上班</th><th style='border: solid 3px black;'>下班</th></tr>";
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
        echo "<tr><th style='border: solid 3px black;'>". $row["eid"]. 
             "</th><th style='border: solid 3px black;'>". $row["did"]. 
             "</th><th style='border: solid 3px black;'>". $row["rid"].   
             "</th><th style='border: solid 3px black;'>". $row["F1"].
             "</th><th style='border: solid 3px black;'>". $row["F2"]."</th></tr>";}  
    }
    
    function select_b($username) 
    {
        global $db;
        $stat = $db->prepare("select * from board;");
        $stat->bindParam(':username',$username);
        $stat->execute();
        echo "<table style='border: solid 3px black;'><tr><th>日期</th><th style='border: solid 3px black;'>公告</th></tr>";
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
        echo 
            "<tr><th style='border: solid 3px black;'>". $row["date"]. 
            "</th><th style='border: solid 3px black;'>".$row["txt"]. "</th></tr>";}
    }
    /*function insert($username, $password) {
        global $db;
        $stat = $db->prepare("INSERT INTO account('acc','pwd') VALUES (':username',':password');");
        $stat->bindParam(':username',$username);
        $stat->bindParam(':password',$password);

        $stat->execute();
    }*/
    
    function delete_e($username) 
    {
        global $db;
        if($_SESSION['LoginSuccess']== true)
		{
            $stat =$db->prepare("DELETE FROM employee WHERE eid=:username;");
            $stat->bindParam(':username', $username);
            if($username == null)
            {
                echo"<span style=\"color:red;\">錯誤！不能為空！</span>";
            }
            
            elseif($stat->execute())
                {
                    echo"<span style=\"color:green;\">刪除成功！</span>";
                    echo'<meta http-equiv="refresh" content="2; url=main.php">';
                }
            else
                {
                    echo"<span style=\"color:red;\">刪除失敗！</span>";
                    echo'<meta http-equiv="refresh" content="2; url=main.php">';
                }
        }
    }
    
}
?>
