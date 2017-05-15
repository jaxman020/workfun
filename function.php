<?php
/**
 *changken會員系統專用函數庫
 *簡介:為促進程式開發人員方便開發，changken特別製作專用函數庫。
 *作者:changken 
 *使用方式:請將函數直接複製即可。注意！一定要引入此函數庫，不然不能使用！
 *函數:reg()、login()、update()、delete_u()、logout()、getUserinfoBn()
 *版本:v1.2
 */
require_once("config.inc.php");

class member
{
    var $login;
    var $login_sal;
    var $login_row;
    var $select_e;
    var $select_sql;
    var $update;
    var $update_sql;
    var $delete_u;
    var $delete_sql;
    var $getuser;
    var $getuser_sql;
    var $getuser_row;
    
    //登入函數
    function login($username, $password){
        global $db;
        $this->login_sql="SELECT * FROM `account` WHERE `acc`=:username AND `pwd`=:password;";
		$this->login = $db->prepare($this->login_sql);
		$this->login->bindParam(":username", $username);
        $this->login->bindParam(":password", $password);
		$this->login->execute();
		$this->login_row = $this->login->fetch();
        if($username == null){
            echo"<span style=\"color:red;\">錯誤！使用者名稱不能為空！</span>";
			echo'<meta http-equiv="refresh" content="2; url=login.html">';
        }
        elseif($password == null){
            echo"<span style=\"color:red;\">錯誤！密碼不能為空！</span>";
			echo'<meta http-equiv="refresh" content="2; url=login.html">';
        }
        elseif($username != $this -> login_row['acc'] or $password != $this -> login_row['pwd']){
            echo"<span style=\"color:red;\">錯誤！查無使用者或密碼錯誤！</span>";
			echo'<meta http-equiv="refresh" content="2; url=login.html">';
        }
        else{
            if($username = $this -> login_row['acc']){
                echo"<span style=\"color:green;\">登入成功！</span>";
                $_SESSION['LoginSuccess'] = true;
                echo'<meta http-equiv="refresh" content="2; url=main.php">';
                $_SESSION['username']=$username;
            }
            else{
                echo"<span style=\"color:red;\">登入失敗！</span>";
                echo'<meta http-equiv="refresh" content="2; url=login.html">';
            }
        }
    }
    
    function getUserinfoBn($username)
	{
		global $db;
		$this->getuser_sql = "SELECT * FROM `account` WHERE `username`= :username;";
		$this->getuser = $db->prepare($this->getuser_sql);
		$this->getuser->bindParam(":username",$username);
		$this->getuser->execute();
		$this->getuser_row= $this->getuser->fetch();
		return  $this->getuser_row;
	}
    
    function select_e($username) {
        global $db;
        $stat = $db->prepare("select * from employee join account on employee.eid=account.eid where account.acc= :username;");
        $stat->bindParam(':username',$username);
        $stat->execute();
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
            echo "id : ". $row["eid"]. " Name : ". $row["ename"]. " sex : " . $row["sex"]. " bir : ". $row["bir"]." phone : ". $row["phone"]." idnum : ". $row["idnum"]." pos : ". $row["pos"]." add : ". $row["add"]. " email : ". $row["email"]." did : ". $row["did"]."<br>";
        }
            /*$stmt = $db->prepare($this, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
              $data = $row[0] . "\t" . $row[1] . "\t" . $row[2] . "\n";
              print $data;*/
    }
}
?>