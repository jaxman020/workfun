<html>
<?php

require_once("config.inc.php");

class member
{
    var $login;
    var $login_sql;
    var $login_row;
    var $select_e;
    var $select_r;
    var $select_m;
    var $select_b;
	var $select_q;
    var $insert_e;
    var $insert_a;
    var $delete_e;
    
    //登入函數
    function login($manager_num, $password) 
    {
        $_SESSION['LoginSuccess'] = false;
        
        global $db;
        $this->login_sql="SELECT * FROM `manager` WHERE `manager_num`=:manager_num AND `manager_idnum`=:password;";
		$this->login = $db->prepare($this->login_sql);
		$this->login->bindParam(":manager_num", $manager_num);
        $this->login->bindParam(":password", $password);
		$this->login->execute();
		$this->login_row = $this->login->fetch();
        if($manager_num == null)
        {
            echo "<script>alert('錯誤！使用者名稱不能為空！')</script>";
            echo "<script>history.go(-1);</script>";
        }
        elseif($password == null)
        {
            echo "<script>alert('錯誤！密碼不能為空！')</script>";
            echo "<script>history.go(-1);</script>";
        }
        elseif($manager_num != $this -> login_row['manager_num'] or $password != $this -> login_row['manager_idnum'])
        {
            echo "<span style=\"color:red;\">錯誤！查無使用者或密碼錯誤！</span>";
			echo "<script>history.go(-1);</script>";
        }
        else{
            if($manager_num = $this -> login_row['manager_num'])
            {
                $_SESSION['manager_num']=$manager_num;
                $_SESSION['LoginSuccess'] = true;
                echo "<span style=\"color:green;\">登入成功！</span>";
                echo '<meta http-equiv="refresh" content="2; url=manager.php">';
            }
            else
            {
                echo "<span style=\"color:red;\">登入失敗！</span>";
                echo "<script>history.go(-1);</script>";
            }
        }
    }
    
    function select_m($manager_num) 
    {
        global $db;
        $stat = $db->prepare("select `manager_num`, `manager_name` from manager where `manager_num` =:manager_num;");
        $stat->bindParam(':manager_num',$manager_num);
        $stat->execute();
        
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            $row[manager_num]
			&nbsp;&nbsp;
            $row[manager_name]
                    
EOF;
        }
    }
    
    function select_ma() 
    {
        global $db;
        $stat = $db->prepare("select * from manager;");
        $rows = $stat->fetchAll();
        $data_nums = count($rows); //統計總比數
        $per = 10; //每頁顯示項目數量
        $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page=1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page-1)*$per; //每一頁開始的資料序號
        $stat = $db->prepare('select * from manager LIMIT '.$start.', '.$per);
        $stat->execute();
        $stat->execute();
        
        echo <<<EOF
            <table align='center'>
                <thead>
                    <tr>
                        <th align='center' valign='center'>管理員編號</th>
                        <th align='center' valign='center'>姓名</th>
                        <th align='center' valign='center'>身分證字號</th>
                        <th align='center' valign='center'>電話</th>
						<th align='center' valign='center'>IMEI</th>
						<th align='center' valign='center'>修改/刪除</th>
                    </tr>
                </thead>
            </table>
EOF;
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <table align='center'>
                <tbody>
                    <tr>
                        <td align='center' valign='center'><input type='hidden' id='manager_num' value='$row[manager_num]'>$row[manager_num]</td>
                        <td align='center' valign='center'><input type='hidden' id='manager_name' value='$row[manager_name]'>$row[manager_name]</td>
                        <td align='center' valign='center'><input type='hidden' id='manager_idnum' value='$row[manager_idnum]'>$row[manager_idnum]</td>
                        <td align='center' valign='center'><input type='hidden' id='manager_phone' value='$row[manager_phone]'>$row[manager_phone]</td>
                        <td align='center' valign='center'><input type='hidden' id='manager_imei' value='$row[manager_imei]'>$row[manager_imei]</td>
                        <td align='center' valign='center'>
						<input name='update' type="image" class=menu src="images/cogwheel.png"  onclick="location.href='update_m_page.php?manager_num=$row[manager_num]'">
						&nbsp;
                        <input name='delete' type="image" class=menu src="images/cancel.png"  onclick="if (window.confirm('確定刪除?'))location.href='delete_m.php?manager_num=$row[manager_num]'">
                        
                        </td>
                    </tr>
                </tbody>
            </table>
EOF;
        }
echo <<<EOF
    <div class="pages" align="center">
EOF;
    //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁<br><br>';
    
    if ($page!=1){
        echo "<a href=?page=".($page-1).">上一頁</a>&nbsp;";
        }
    echo "";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if( $page-4 < $i && $i < $page+4 ){
        if ($i != $page) {
            echo "<a href=?page=".$i." >".$i."</a> ";
        }
        else {
            echo "<a href=?page=".$i." class='on' >".$i."</a> ";
        }
        }
    }
    if ($page!=$pages){
        echo "<a href=\"?page=".($page+1)."\">下一頁</a>";
    }
    
echo <<<EOF
    </div>
EOF;
    }
	function s_ma($keyword) 
    {
        global $db;
        $stat = $db->prepare("select * from manager;");
        $rows = $stat->fetchAll();
        $data_nums = count($rows); //統計總比數
        $per = 10; //每頁顯示項目數量
        $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page=1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page-1)*$per; //每一頁開始的資料序號
        $stat = $db->prepare('select * from manager where (manager_num like "%'.$keyword.'%" or manager_name like "%'.$keyword.'%" or manager_idnum like "%'.$keyword.'%" or manager_phone like "'.$keyword.'" or manager_imei like "'.$keyword.'") LIMIT '.$start.', '.$per);
        $stat->execute();
        $stat->execute();
        
        echo <<<EOF
            <table align='center'>
                <thead>
                    <tr>
                        <th align='center' valign='center'>管理員編號</th>
                        <th align='center' valign='center'>姓名</th>
                        <th align='center' valign='center'>身分證字號</th>
                        <th align='center' valign='center'>電話</th>
						<th align='center' valign='center'>IMEI</th>
						<th align='center' valign='center'>修改/刪除</th>
                    </tr>
                </thead>
            </table>
EOF;
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <table align='center'>
                <tbody>
                    <tr>
                        <td align='center' valign='center'><input type='hidden' id='manager_num' value='$row[manager_num]'>$row[manager_num]</td>
                        <td align='center' valign='center'><input type='hidden' id='manager_name' value='$row[manager_name]'>$row[manager_name]</td>
                        <td align='center' valign='center'><input type='hidden' id='manager_idnum' value='$row[manager_idnum]'>$row[manager_idnum]</td>
                        <td align='center' valign='center'><input type='hidden' id='manager_phone' value='$row[manager_phone]'>$row[manager_phone]</td>
                        <td align='center' valign='center'><input type='hidden' id='manager_imei' value='$row[manager_imei]'>$row[manager_imei]</td>
                        <td align='center' valign='center'>
						<input name='update' type="image" class=menu src="images/cogwheel.png"  onclick="location.href='update_m_page.php?manager_num=$row[manager_num]'">
						&nbsp;
                        <input name='delete' type="image" class=menu src="images/cancel.png"  onclick="if (window.confirm('確定刪除?'))location.href='delete_m.php?manager_num=$row[manager_num]'">
                        
                        </td>
                    </tr>
                </tbody>
            </table>
EOF;
        }
echo <<<EOF
    <div class="pages" align="center">
EOF;
    //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁<br><br>';
    
    if ($page!=1){
        echo "<a href=?page=".($page-1).">上一頁</a>&nbsp;";
        }
    echo "";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if( $page-4 < $i && $i < $page+4 ){
        if ($i != $page) {
            echo "<a href=?page=".$i." >".$i."</a> ";
        }
        else {
            echo "<a href=?page=".$i." class='on' >".$i."</a> ";
        }
        }
    }
    if ($page!=$pages){
        echo "<a href=\"?page=".($page+1)."\">下一頁</a>";
    }
    
echo <<<EOF
    </div>
EOF;
    }
    
    function select_mu($manager_num)
    {
		global $db;
        $stat = $db->prepare("select * from `manager` where `manager_num`= :manager_num;");
        $stat->bindParam(':manager_num', $manager_num);
        $stat->execute();
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <form action="update_m.php" method="POST">
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">員工編號：<input type="text" class="form-control" name="manager_num" value='$row[manager_num]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">名字：<input type="text" class="form-control" name="manager_name" value='$row[manager_name]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">身分證字號：<input type="text" class="form-control" name="manager_idnum" value='$row[manager_idnum]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">電話：<input type="text" class="form-control" name="manager_phone" value='$row[manager_phone]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">IMEI：<input type="text" class="form-control" name="manager_imei" value='$row[manager_imei]'><p></div>
                <div class="container" style="text-align:center; font-size:10px; padding:0px 0"><input type="submit" class="btn btn-default" value="送出">&nbsp;<input class="btn btn-default" type="reset"></div>
            </form>
EOF;
        }
	}
        
    function select_e()
    {
		global $db;
        $stat = $db->prepare("select * from employees;");
        $stat->execute();
        $rows = $stat->fetchAll();
        $data_nums = count($rows); //統計總比數
        $per = 12; //每頁顯示項目數量
        $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page=1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page-1)*$per; //每一頁開始的資料序號
        $stat = $db->prepare('select * from employees LIMIT '.$start.', '.$per);
        $stat->execute();
echo <<<EOF
            <table align='center'>
                <thead>
                    <tr>
                        <th align='center' valign='center'>員工編號</th>
                        <th align='center' valign='center'>姓名</th>
                        <th align='center' valign='center'>身分證字號</th>
                        <th align='center' valign='center'>電話</th>
						<th align='center' valign='center'>IMEI</th>
						<th align='center' valign='center'>辦公室編號</th>
						<th align='center' valign='center'>修改/刪除</th>
                    </tr>
                </thead>
            </table>
EOF;
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <table align='center'>
                <tbody>
                    <tr>
                        <td align='center' valign='center'><input type='hidden' id='emp_num' value='$row[emp_num]'>$row[emp_num]</td>
                        <td align='center' valign='center'><input type='hidden' id='emp_name' value='$row[emp_name]'>$row[emp_name]</td>
                        <td align='center' valign='center'><input type='hidden' id='emp_idnum' value='$row[emp_idnum]'>$row[emp_idnum]</td>
                        <td align='center' valign='center'><input type='hidden' id='emp_phone' value='$row[emp_phone]'>$row[emp_phone]</td>
                        <td align='center' valign='center'><input type='hidden' id='emp_imei' value='$row[emp_imei]'>$row[emp_imei]</td>
                        <td align='center' valign='center'><input type='hidden' id='office_num' value='$row[office_num]'>$row[office_num]</td>
                        <td align='center' valign='center'>
						<input name='update' type="image" class=menu src="images/cogwheel.png"  onclick="location.href='update_e_page.php?emp_num=$row[emp_num]'">
						&nbsp;
                        <input name='delete' type="image" class=menu src="images/cancel.png"  onclick="if (window.confirm('確定刪除?'))location.href='delete_e.php?emp_num=$row[emp_num]'">
                        
                        </td>
                    </tr>
                </tbody>
            </table>
EOF;
        }
echo <<<EOF
    <div class="pages" align="center">
EOF;
    //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁<br><br>';
    
    if ($page!=1){
        echo "<a href=?page=".($page-1).">上一頁</a>&nbsp;";
        }
    echo "";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if( $page-4 < $i && $i < $page+4 ){
        if ($i != $page) {
            echo "<a href=?page=".$i." >".$i."</a> ";
        }
        else {
            echo "<a href=?page=".$i." class='on' >".$i."</a> ";
        }
        }
    }
    if ($page!=$pages){
        echo "<a href=\"?page=".($page+1)."\">下一頁</a>";
    }
    
echo <<<EOF
    </div>
EOF;
    }
	function s_e($keyword)
    {
		global $db;
        $stat = $db->prepare("select * from employees;");
        $stat->execute();
        $rows = $stat->fetchAll();
        $data_nums = count($rows); //統計總比數
        $per = 12; //每頁顯示項目數量
        $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page=1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page-1)*$per; //每一頁開始的資料序號
        $stat = $db->prepare('select * from employees where (emp_num like "%'.$keyword.'%" or emp_name like "%'.$keyword.'%" or emp_idnum like "%'.$keyword.'%" or emp_phone like "'.$keyword.'" or emp_imei like "'.$keyword.'") LIMIT '.$start.', '.$per);
        $stat->execute();
echo <<<EOF
            <table align='center'>
                <thead>
                    <tr>
                        <th align='center' valign='center'>員工編號</th>
                        <th align='center' valign='center'>姓名</th>
                        <th align='center' valign='center'>身分證字號</th>
                        <th align='center' valign='center'>電話</th>
						<th align='center' valign='center'>IMEI</th>
						<th align='center' valign='center'>辦公室編號</th>
						<th align='center' valign='center'>修改/刪除</th>
                    </tr>
                </thead>
            </table>
EOF;
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <table align='center'>
                <tbody>
                    <tr>
                        <td align='center' valign='center'><input type='hidden' id='emp_num' value='$row[emp_num]'>$row[emp_num]</td>
                        <td align='center' valign='center'><input type='hidden' id='emp_name' value='$row[emp_name]'>$row[emp_name]</td>
                        <td align='center' valign='center'><input type='hidden' id='emp_idnum' value='$row[emp_idnum]'>$row[emp_idnum]</td>
                        <td align='center' valign='center'><input type='hidden' id='emp_phone' value='$row[emp_phone]'>$row[emp_phone]</td>
                        <td align='center' valign='center'><input type='hidden' id='emp_imei' value='$row[emp_imei]'>$row[emp_imei]</td>
                        <td align='center' valign='center'><input type='hidden' id='office_num' value='$row[office_num]'>$row[office_num]</td>
                        <td align='center' valign='center'>
						<input name='update' type="image" class=menu src="images/cogwheel.png"  onclick="location.href='update_e_page.php?emp_num=$row[emp_num]'">
						&nbsp;
                        <input name='delete' type="image" class=menu src="images/cancel.png"  onclick="if (window.confirm('確定刪除?'))location.href='delete_e.php?emp_num=$row[emp_num]'">
                        
                        </td>
                    </tr>
                </tbody>
            </table>
EOF;
        }
echo <<<EOF
    <div class="pages" align="center">
EOF;
    //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁<br><br>';
    
    if ($page!=1){
        echo "<a href=?page=".($page-1).">上一頁</a>&nbsp;";
        }
    echo "";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if( $page-4 < $i && $i < $page+4 ){
        if ($i != $page) {
            echo "<a href=?page=".$i." >".$i."</a> ";
        }
        else {
            echo "<a href=?page=".$i." class='on' >".$i."</a> ";
        }
        }
    }
    if ($page!=$pages){
        echo "<a href=\"?page=".($page+1)."\">下一頁</a>";
    }
    
echo <<<EOF
    </div>
EOF;
    }
    
    function select_eu($emp_num)
    {
		global $db;
        $stat = $db->prepare("select * from employees where `emp_num`= :emp_num;");
        $stat->bindParam(':emp_num',$emp_num);
        $stat->execute();
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <form action="update_e.php" method="POST">
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">員工編號：<input type="text" class="form-control" name="emp_num" value='$row[emp_num]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">名字：<input type="text" class="form-control" name="emp_name" value='$row[emp_name]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">身分證字號：<input type="text" class="form-control" name="emp_idnum" value='$row[emp_idnum]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">電話：<input type="text" class="form-control" name="emp_phone" value='$row[emp_phone]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">IMEI：<input type="text" class="form-control" name="emp_imei" value='$row[emp_imei]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">辦公室：<select class="form-control" name="office_num">
                                                                     <option value="0101">0101</option>
                                                                     <option value="0102">0102</option>
                                                                     <option value="0103">0103</option>
                                                                     <option value="0104">0104</option>
                                                                     <option value="0105">0105</option>
                                                                </select><p></div>
                
				<div class="container" style="text-align:center; font-size:10px; padding:10px 0"><input type="submit" class="btn btn-default" value="送出">&nbsp;&nbsp;&nbsp;&nbsp;<input class="btn btn-default" type="reset"></div>
            </form>
EOF;
        }
	}
    
    function select_r() 
    {
        global $db;
        $stat = $db->prepare("select * from record;");
        $stat->execute();
        $rows = $stat->fetchAll();
        $data_nums = count($rows); //統計總比數
        $per = 12; //每頁顯示項目數量
        $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page=1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page-1)*$per; //每一頁開始的資料序號
        $stat = $db->prepare('select * from record LIMIT '.$start.', '.$per);
        $stat->execute();
echo <<<EOF
            <table align='center'>
                <thead>
                    <tr>
                        <th  align='center' valign='center'>打卡編號</th>
                        <th  align='center' valign='center'>員工編號</th>
                        <th  align='center' valign='center'>辦公室編號</th>
                        <th  align='center' valign='center'>打卡時間</th>
                        <th  align='center' valign='center'>上班/下班</th>
                        <th  align='center' valign='center'>修改/刪除</th>
                    </tr>
                </thead>
            </table>
EOF;
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <table align='center'>
                <tbody>
                    <tr>
                        <td align='center' valign='center'>$row[record_id]</td> 
                        <td align='center' valign='center'>$row[emp_num]</td>
                        <td align='center' valign='center'>$row[office_num]</td>
                        <td align='center' valign='center'>$row[record_time]</td>
                        <td align='center' valign='center'>$row[record_status]</td>
                        <td align='center' valign='center'>
                        <input name='update' type="image" class=menu src="images/cogwheel.png"  onclick="location.href='update_r_page.php?record_id=$row[record_id]'">
						&nbsp;
                        <input name='delete' type="image" class=menu src="images/cancel.png"  onclick="if (window.confirm('確定刪除?'))location.href='delete_r.php?record_id=$row[record_id]'">
                        </td>       
                    </tr>	
                </tbody>
            </table>
EOF;
        }
echo <<<EOF
            <div class="pages" align="center">
EOF;
           //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁<br><br>';
    
    if ($page!=1){
        echo "<a href=?page=".($page-1).">上一頁</a>&nbsp;";
        }
    echo "";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if( $page-4 < $i && $i < $page+4 ){
        if ($i != $page) {
            echo "<a href=?page=".$i." >".$i."</a> ";
        }
        else {
            echo "<a href=?page=".$i." class='on' >".$i."</a> ";
        }
        }
    }
    if ($page!=$pages){
        echo "<a href=\"?page=".($page+1)."\">下一頁</a>";
    }
    
echo <<<EOF
            </div>
EOF;
    }
	function s_r($keyword) 
    {
        global $db;
        $stat = $db->prepare("select * from record;");
        $stat->execute();
        $rows = $stat->fetchAll();
        $data_nums = count($rows); //統計總比數
        $per = 12; //每頁顯示項目數量
        $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page=1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page-1)*$per; //每一頁開始的資料序號
        $stat = $db->prepare('select * from record where(record_id like "%'.$keyword.'%" or emp_num like "%'.$keyword.'%" or office_num like "%'.$keyword.'%" or record_time like "%'.$keyword.'%" or record_status like "%'.$keyword.'%") LIMIT '.$start.', '.$per);
        $stat->execute();
echo <<<EOF
            <table align='center'>
                <thead>
                    <tr>
                        <th  align='center' valign='center'>打卡編號</th>
                        <th  align='center' valign='center'>員工編號</th>
                        <th  align='center' valign='center'>辦公室編號</th>
                        <th  align='center' valign='center'>打卡時間</th>
                        <th  align='center' valign='center'>上班/下班</th>
                        <th  align='center' valign='center'>修改/刪除</th>
                    </tr>
                </thead>
            </table>
EOF;
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <table align='center'>
                <tbody>
                    <tr>
                        <td align='center' valign='center'>$row[record_id]</td> 
                        <td align='center' valign='center'>$row[emp_num]</td>
                        <td align='center' valign='center'>$row[office_num]</td>
                        <td align='center' valign='center'>$row[record_time]</td>
                        <td align='center' valign='center'>$row[record_status]</td>
                        <td align='center' valign='center'>
                        <input name='update' type="image" class=menu src="images/cogwheel.png"  onclick="location.href='update_r_page.php?record_id=$row[record_id]'">
						&nbsp;
                        <input name='delete' type="image" class=menu src="images/cancel.png"  onclick="if (window.confirm('確定刪除?'))location.href='delete_r.php?record_id=$row[record_id]'">
                        </td>       
                    </tr>	
                </tbody>
            </table>
EOF;
        }
echo <<<EOF
            <div class="pages" align="center">
EOF;
           //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁<br><br>';
    
    if ($page!=1){
        echo "<a href=?page=".($page-1).">上一頁</a>&nbsp;";
        }
    echo "";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if( $page-4 < $i && $i < $page+4 ){
        if ($i != $page) {
            echo "<a href=?page=".$i." >".$i."</a> ";
        }
        else {
            echo "<a href=?page=".$i." class='on' >".$i."</a> ";
        }
        }
    }
    if ($page!=$pages){
        echo "<a href=\"?page=".($page+1)."\">下一頁</a>";
    }
    
echo <<<EOF
            </div>
EOF;
    }
    
    function select_ru($record_id)
    {
		global $db;
        $stat = $db->prepare("select * from record where `record_id`= :record_id;");
        $stat->bindParam(':record_id',$record_id);
        $stat->execute();
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
            $row[record_time]= str_replace(' ', 'T', $row[record_time]);
echo <<<EOF
            <form action="update_r.php" method="POST">
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">打卡編號：<input type="text" class="form-control" name="record_id" value='$row[record_id]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">員工編號：<input type="text" class="form-control" name="emp_num" value='$row[emp_num]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">辦公室編號：<input type="text" class="form-control" name="office_num" value='$row[office_num]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">打卡時間：<input type="datetime-local" class="form-control" name="record_time" value='$row[record_time]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">上班/下班：<input type="text" class="form-control" name="record_status" value='$row[record_status]'><p></div>
                <div align="right" style="text-align:center; font-size:10px; padding:10px 0"><input type="submit" class="btn btn-default" value="送出">&nbsp;&nbsp;&nbsp;&nbsp;<input class="btn btn-default" type="reset"></div>
            </form>
EOF;
        }
	}
    
    function select_b() 
    {
        global $db;
        $stat = $db->prepare("select * from board;");
        $stat->execute();
        $rows = $stat->fetchAll();
        $data_nums = count($rows); //統計總比數
        $per = 12; //每頁顯示項目數量
        $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page=1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page-1)*$per; //每一頁開始的資料序號
        $stat = $db->prepare('select * from board LIMIT '.$start.', '.$per);
        $stat->execute();
echo <<<EOF
            <table align='center'>
                <thead>
                    <tr>
                        <th  align='center' valign='center'>公告編號</th>
                        <th  align='center' valign='center'>辦公室編號</th>
                        <th  align='center' valign='center'>公告時間</th>
                        <th  align='center' valign='center'>內容</th>
                        <th  align='center' valign='center'>修改/刪除</th>
                    </tr>
                </thead>
            </table>
EOF;
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <table align='center'>
                <tbody>					  
                    <tr>
                        <td align='center' valign='center' >$row[board_id]</td> 
                        <td align='center' valign='center'>$row[office_num]</td>
                        <td align='center' valign='center'>$row[board_time]</td>
                        <td align='center' valign='center'>$row[board_content]</td>
                        <td align='center' valign='center'>
                        <input name='update' type="image" class=menu src="images/cogwheel.png"  onclick="location.href='update_b_page.php?board_id=$row[board_id]'">
						&nbsp;
                        <input name='delete' type="image" class=menu src="images/cancel.png"  onclick="if (window.confirm('確定刪除?'))location.href='delete_b.php?board_id=$row[board_id]'">
                        </td>       
                    </tr>	
                </tbody>
            </table>
EOF;
        }
echo <<<EOF
    <div class="pages" align="center">
EOF;
    //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁<br><br>';
    
    if ($page!=1){
        echo "<a href=?page=".($page-1).">上一頁</a>&nbsp;";
        }
    echo "";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if( $page-4 < $i && $i < $page+4 ){
        if ($i != $page) {
            echo "<a href=?page=".$i." >".$i."</a> ";
        }
        else {
            echo "<a href=?page=".$i." class='on' >".$i."</a> ";
        }
        }
    }
    if ($page!=$pages){
        echo "<a href=\"?page=".($page+1)."\">下一頁</a>";
    }
    
echo <<<EOF
    </div>
EOF;
    }
	function s_b($keyword) 
    {
        global $db;
        $stat = $db->prepare("select * from board;");
        $stat->execute();
        $rows = $stat->fetchAll();
        $data_nums = count($rows); //統計總比數
        $per = 12; //每頁顯示項目數量
        $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page=1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page-1)*$per; //每一頁開始的資料序號
        $stat = $db->prepare('select * from board where(board_id like "%'.$keyword.'%" or office_num like "%'.$keyword.'%" or board_time like "%'.$keyword.'%" or board_content like "%'.$keyword.'%") LIMIT '.$start.', '.$per);
        $stat->execute();
echo <<<EOF
            <table align='center'>
                <thead>
                    <tr>
                        <th  align='center' valign='center'>公告編號</th>
                        <th  align='center' valign='center'>辦公室編號</th>
                        <th  align='center' valign='center'>公告時間</th>
                        <th  align='center' valign='center'>內容</th>
                        <th  align='center' valign='center'>修改/刪除</th>
                    </tr>
                </thead>
            </table>
EOF;
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <table align='center'>
                <tbody>					  
                    <tr>
                        <td align='center' valign='center' >$row[board_id]</td> 
                        <td align='center' valign='center'>$row[office_num]</td>
                        <td align='center' valign='center'>$row[board_time]</td>
                        <td align='center' valign='center'>$row[board_content]</td>
                        <td align='center' valign='center'>
                        <input name='update' type="image" class=menu src="images/cogwheel.png"  onclick="location.href='update_b_page.php?board_id=$row[board_id]'">
						&nbsp;
                        <input name='delete' type="image" class=menu src="images/cancel.png"  onclick="if (window.confirm('確定刪除?'))location.href='delete_b.php?board_id=$row[board_id]'">
                        </td>       
                    </tr>	
                </tbody>
            </table>
EOF;
        }
echo <<<EOF
    <div class="pages" align="center">
EOF;
    //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁<br><br>';
    
    if ($page!=1){
        echo "<a href=?page=".($page-1).">上一頁</a>&nbsp;";
        }
    echo "";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if( $page-4 < $i && $i < $page+4 ){
        if ($i != $page) {
            echo "<a href=?page=".$i." >".$i."</a> ";
        }
        else {
            echo "<a href=?page=".$i." class='on' >".$i."</a> ";
        }
        }
    }
    if ($page!=$pages){
        echo "<a href=\"?page=".($page+1)."\">下一頁</a>";
    }
    
echo <<<EOF
    </div>
EOF;
    }
    
    function select_bu($board_id)
    {
		global $db;
        $stat = $db->prepare("select * from board where `board_id`= :board_id;");
        $stat->bindParam(':board_id',$board_id);
        $stat->execute();
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
            $row[board_time]= str_replace(' ', 'T', $row[board_time]);
echo <<<EOF
            <form action="update_b.php" method="POST">
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">公告編號：<input type="text" class="form-control" name="board_id" value='$row[board_id]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">辦公室編號：<input type="text" class="form-control" name="office_num" value='$row[office_num]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">公告時間：<input type="datetime-local" class="form-control" name="board_time" value='$row[board_time]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">內容：<textarea class="form-control" name="board_content">$row[board_content]</textarea><p></div>
                <div class="container" style="text-align:center; font-size:10px; padding:10px 0"><input type="submit" class="btn btn-default" value="送出">&nbsp;&nbsp;&nbsp;&nbsp;<input class="btn btn-default" type="reset"></div>
            </form>
EOF;
        }
	}
    
    function select_me() 
    {
        global $db;
        $stat = $db->prepare("select * from message;");
        $stat->execute();
        $rows = $stat->fetchAll();
        $data_nums = count($rows); //統計總比數
        $per = 12; //每頁顯示項目數量
        $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page=1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page-1)*$per; //每一頁開始的資料序號
        $stat = $db->prepare('select * from message LIMIT '.$start.', '.$per);
        $stat->execute();
echo <<<EOF
            <table align='center'>
                <thead>
                    <tr>
                        <th  align='center' valign='center'>問題編號</th>
                        <th  align='center' valign='center'>員工編號</th>
                        <th  align='center' valign='center'>姓名</th>
                        
                        <th  align='center' valign='center'>回報內容</th>
                        <th  align='center' valign='center'>回報時間</th>
                        <th  align='center' valign='center'>EMAIL</th>
                        <th  align='center' valign='center'>回復/刪除</th>
                    </tr>
                </thead>
            </table>
EOF;
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <table align='center'>
                <tbody>
                    <tr>
                        <td align='center' valign='center'>$row[message_id]</td> 
                        <td align='center' valign='center'>$row[emp_num]</td>
                        <td align='center' valign='center'>$row[emp_name]</td>
                        
                        <td align='center' valign='center'>$row[message_content]</td>
                        <td align='center' valign='center'>$row[message_time]</td>
                        <td align='center' valign='center'>$row[message_email]</td>
                        <td align='center' valign='center'>
						
						<input name='update' type="image" class=menu src="images/mail.png"  onclick="location.href='mailto:$row[message_email]'">
						&nbsp;
                        <input name='delete' type="image" class=menu src="images/cancel.png"  onclick="if (window.confirm('確定刪除?'))location.href='delete_me.php?message_id=$row[message_id]'">       
                    </tr>	
                </tbody>
            </table>
EOF;
        }
echo <<<EOF
    <div class="pages" align="center">
EOF;
    //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁<br><br>';
    
    if ($page!=1){
        echo "<a href=?page=".($page-1).">上一頁</a>&nbsp;";
        }
    echo "";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if( $page-4 < $i && $i < $page+4 ){
        if ($i != $page) {
            echo "<a href=?page=".$i." >".$i."</a> ";
        }
        else {
            echo "<a href=?page=".$i." class='on' >".$i."</a> ";
        }
        }
    }
    if ($page!=$pages){
        echo "<a href=\"?page=".($page+1)."\">下一頁</a>";
    }
    
echo <<<EOF
    </div>
EOF;
    }
	function s_me($keyword) 
    {
        global $db;
        $stat = $db->prepare("select * from message;");
        $stat->execute();
        $rows = $stat->fetchAll();
        $data_nums = count($rows); //統計總比數
        $per = 12; //每頁顯示項目數量
        $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page=1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page-1)*$per; //每一頁開始的資料序號
        $stat = $db->prepare('select * from message where(message_id like "%'.$keyword.'%" or emp_num like "%'.$keyword.'%" or emp_name like "%'.$keyword.'%" or message_content like "%'.$keyword.'%"or message_time like "%'.$keyword.'%"or message_email like "%'.$keyword.'%") LIMIT '.$start.', '.$per);
        $stat->execute();
echo <<<EOF
            <table align='center'>
                <thead>
                    <tr>
                        <th  align='center' valign='center'>問題編號</th>
                        <th  align='center' valign='center'>員工編號</th>
                        <th  align='center' valign='center'>姓名</th>
                        
                        <th  align='center' valign='center'>回報內容</th>
                        <th  align='center' valign='center'>回報時間</th>
                        <th  align='center' valign='center'>EMAIL</th>
                        <th  align='center' valign='center'>回復/刪除</th>
                    </tr>
                </thead>
            </table>
EOF;
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
echo <<<EOF
            <table align='center'>
                <tbody>
                    <tr>
                        <td align='center' valign='center'>$row[message_id]</td> 
                        <td align='center' valign='center'>$row[emp_num]</td>
                        <td align='center' valign='center'>$row[emp_name]</td>
                        
                        <td align='center' valign='center'>$row[message_content]</td>
                        <td align='center' valign='center'>$row[message_time]</td>
                        <td align='center' valign='center'>$row[message_email]</td>
                        <td align='center' valign='center'>
						
						<input name='update' type="image" class=menu src="images/mail.png"  onclick="location.href='mailto:$row[message_email]'">
						&nbsp;
                        <input name='delete' type="image" class=menu src="images/cancel.png"  onclick="if (window.confirm('確定刪除?'))location.href='delete_me.php?message_id=$row[message_id]'">       
                    </tr>	
                </tbody>
            </table>
EOF;
        }
echo <<<EOF
    <div class="pages" align="center">
EOF;
    //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁<br><br>';
    
    if ($page!=1){
        echo "<a href=?page=".($page-1).">上一頁</a>&nbsp;";
        }
    echo "";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if( $page-4 < $i && $i < $page+4 ){
        if ($i != $page) {
            echo "<a href=?page=".$i." >".$i."</a> ";
        }
        else {
            echo "<a href=?page=".$i." class='on' >".$i."</a> ";
        }
        }
    }
    if ($page!=$pages){
        echo "<a href=\"?page=".($page+1)."\">下一頁</a>";
    }
    
echo <<<EOF
    </div>
EOF;
    }
    
    function select_meu($message_id)
    {
		global $db;
        $stat = $db->prepare("select * from message where `message_id`= :message_id;");
        $stat->bindParam(':message_id',$message_id);
        $stat->execute();
        while($row = $stat->fetch(PDO::FETCH_ASSOC)){
            $row[message_time]= str_replace(' ', 'T', $row[message_time]);
echo <<<EOF
            <form action="update_me.php" method="POST">
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">問題編號：<input type="text" class="form-control" name="message_id" value='$row[message_id]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">員工編號：<input type="text" class="form-control" name="emp_num" value='$row[emp_num]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">姓名：<input type="text" class="form-control" name="emp_name" value='$row[emp_name]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">IMEI：<input type="text" class="form-control" name="emp_imei" value='$row[emp_imei]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">回報內容：<input type="text" class="form-control" name="message_content" value='$row[message_content]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">回報時間：<input type="datetime-local" class="form-control" name="message_time" value='$row[message_time]'><p></div>
                <div class="container" style="text-align:center; font-size:18px; padding:0px 0">EMAIL：<input type="text" class="form-control" name="message_email" value='$row[message_email]'><p></div>
                <div align="right" style="text-align:center; font-size:10px; padding:10px 0"><input type="submit" class="btn btn-default" value="送出">&nbsp;&nbsp;&nbsp;&nbsp;<input class="btn btn-default" type="reset"></div>
            </form>
EOF;
        }
	}
    
    function insert_e($emp_num,$emp_name,$emp_idnum,$emp_phone,$emp_imei,$office_num) {
        global $db;
        $stat = $db->prepare("INSERT INTO `employees`(`emp_num`, `emp_name`, `emp_idnum`, `emp_phone`, `emp_imei`, `office_num`) VALUES (:emp_num, :emp_name, :emp_idnum, :emp_phone, :emp_imei, :office_num);");
        $stat->bindParam(':emp_num', $emp_num);
        $stat->bindParam(':emp_name', $emp_name);
        $stat->bindParam(':emp_idnum', $emp_idnum);
        $stat->bindParam(':emp_phone', $emp_phone);
        $stat->bindParam(':emp_imei', $emp_imei);
        $stat->bindParam(':office_num',$office_num);
        if($stat->execute())
        {
            echo "<span style=\"color:green;\">新增成功！</span>";
            echo "<script>history.go(-1);</script>";
        }
        else
        {
            echo "<script>alert('新增失敗！');</script>";
            echo "<script>history.go(-1);</script>";
        }
	}
    
    function insert_m($manager_num, $manager_name, $manager_idnum, $manager_phone, $manager_imei) {
        global $db;
        $stat = $db->prepare("INSERT INTO `manager` (`manager_num`, `manager_name`, `manager_idnum`, `manager_phone`,`manager_imei`) VALUES (:manager_num, :manager_name, :manager_idnum, :manager_phone, :manager_imei);");
        $pdoExec = $stat->execute(array(":manager_num"=>$manager_num, ":manager_name"=>$manager_name, ":manager_idnum"=>$manager_idnum, ":manager_phone"=>$manager_phone, ":manager_imei"=>$manager_imei));
    
        if($pdoExec)
        {
            echo "<span style=\"color:green;\">新增成功！</span>";
            echo "<script>history.go(-1);</script>";
        }
        else
        {
            echo "<script>alert('新增失敗！');</script>";
            echo "<script>history.go(-1);</script>";
        }
    }
    
    function insert_r($record_id, $emp_num, $office_num, $record_time, $record_status, $imei) {
        global $db;
        $stat = $db->prepare("INSERT INTO `record`(`emp_num`, `office_num`, `record_time`, `record_status`, `imei`) VALUES (:emp_num, :office_num, :record_time, :record_status, :imei);");
        $stat->bindParam(':emp_num', $emp_num);
        $stat->bindParam(':office_num', $office_num);
        $stat->bindParam(':record_time', $record_time);
        $stat->bindParam(':record_status', $record_status);
        $stat->bindParam(':imei',$imei);
        if($stat->execute())
        {
            echo "<span style=\"color:green;\">新增成功！</span>";
            echo "<script>history.go(-1);</script>";
        }
        else
        {
            echo "<script>alert('新增失敗！');</script>";
            echo "<script>history.go(-1);</script>";
        }
	}
    
    function insert_b($board_id,$office_num,$board_time,$board_content) {
        global $db;
        $stat = $db->prepare("INSERT INTO `board`(`board_id`, `office_num`, `board_time`, `board_content`) VALUES (:board_id, :office_num, :board_time, :board_content);");
        $stat->bindParam(':board_id', $board_id);
        $stat->bindParam(':office_num', $office_num);
        $stat->bindParam(':board_time', $board_time);
        $stat->bindParam(':board_content', $board_content);
        if($stat->execute())
        {
            echo "<span style=\"color:green;\">新增成功！</span>";
            echo "<script>history.go(-1);</script>";
        }
        else
        {
            echo "<script>alert('新增失敗！');</script>";
            echo "<script>history.go(-1);</script>";
        }
	}
    
    function delete_e($emp_num) 
    {
        global $db;
        if($_SESSION['LoginSuccess']== true)
		{
            $stat =$db->prepare("DELETE FROM employees WHERE emp_num= :emp_num;");
            $stat->bindParam(':emp_num', $emp_num);
            if($emp_num == null)
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
        else{
            echo "<span style=\"color:red;\">未登入！</span>";
            echo "<script>history.go(-1);</script>";
        }
    }
    
    function delete_m($manager_num) 
    {
        global $db;
        if($_SESSION['LoginSuccess']== true)
		{
            $stat =$db->prepare("DELETE FROM manager WHERE manager_num= :manager_num;");
            $stat->bindParam(':manager_num', $manager_num);
            if($manager_num == null)
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
        else{
            echo "<span style=\"color:red;\">未登入！</span>";
            echo "<script>history.go(-1);</script>";
        }
    }
    
    function delete_r($record_id) 
    {
        global $db;
        if($_SESSION['LoginSuccess']== true)
		{
            $stat =$db->prepare("DELETE FROM record WHERE record_id= :record_id;");
            $stat->bindParam(':record_id', $record_id);
            if($record_id == null)
            {
                echo "<span style=\"color:red;\">錯誤！不能為空！</span>";
                echo "<script>history.go(-1);</script>";
                
            }
            
            elseif($stat->execute())
                {
                    echo "<span style=\"color:green;\">刪除成功！</span>";
                    echo "<script>history.go(-1);</script>";
                }
            else
                {
                    echo "<span style=\"color:red;\">刪除失敗！</span>";
                    echo "<script>history.go(-1);</script>";
                }
        }
        else{
            echo "<span style=\"color:red;\">未登入！</span>";
            echo "<script>history.go(-1);</script>";
        }
    }
    
    function delete_b($board_id) 
    {
        global $db;
        if($_SESSION['LoginSuccess']== true)
		{
            $stat =$db->prepare("DELETE FROM board WHERE board_id= :board_id;");
            $stat->bindParam(':board_id', $board_id);
            if($board_id == null)
            {
                echo "<span style=\"color:red;\">錯誤！不能為空！</span>";
                echo "<script>history.go(-1);</script>";
                
            }
            
            elseif($stat->execute())
                {
                    echo "<span style=\"color:green;\">刪除成功！</span>";
                    echo "<script>history.go(-1);</script>";
                }
            else
                {
                    echo "<span style=\"color:red;\">刪除失敗！</span>";
                    echo "<script>history.go(-1);</script>";
                }
        }
        else{
            echo "<span style=\"color:red;\">未登入！</span>";
            echo "<script>history.go(-1);</script>";
        }
    }
    
    function delete_me($message_id) 
    {
        global $db;
        if($_SESSION['LoginSuccess']== true)
		{
            $stat =$db->prepare("DELETE FROM message WHERE message_id= :message_id;");
            $stat->bindParam(':message_id', $message_id);
            if($message_id == null)
            {
                echo "<span style=\"color:red;\">錯誤！不能為空！</span>";
                echo "<script>history.go(-1);</script>";
                
            }
            
            elseif($stat->execute())
                {
                    echo "<span style=\"color:green;\">刪除成功！</span>";
                    echo "<script>history.go(-1);</script>";
                }
            else
                {
                    echo "<span style=\"color:red;\">刪除失敗！</span>";
                    echo "<script>history.go(-1);</script>";
                }
        }
        else{
            echo "<span style=\"color:red;\">未登入！</span>";
            echo "<script>history.go(-1);</script>";
        }
    }
	
    function update_m($manager_num, $manager_name, $manager_idnum, $manager_phone, $manager_imei){
        global $db;
        $stat = $db->prepare("UPDATE `manager` set `manager_name`= :manager_name, `manager_idnum` = :manager_idnum, `manager_phone` = :manager_phone, `manager_imei` = :manager_imei where `manager_num`= :manager_num;");
        $stat->bindParam(':manager_num', $manager_num);
        $stat->bindParam(':manager_name', $manager_name);
        $stat->bindParam(':manager_idnum', $manager_idnum);
        $stat->bindParam(':manager_phone', $manager_phone);
        $stat->bindParam(':manager_imei', $manager_imei);
        
        if($stat->execute())
		{
			echo "<span style=\"color:green;\">更新成功！</span>";
			echo '<meta http-equiv="refresh" content="2; url=manager.php">';
		}
		else
		{
			echo "<span style=\"color:red;\">更新失敗！</span>";
			echo '<meta http-equiv="refresh" content="2; url=manager.php">';
		}
    }
    
    function update_e($emp_num, $emp_name, $emp_idnum, $emp_phone, $emp_imei, $office_num){
        global $db;
        $stat = $db->prepare("UPDATE `employees` set `emp_name` = :emp_name, `emp_idnum` = :emp_idnum, `emp_phone` = :emp_phone, `emp_imei`= :emp_imei, `office_num` = :office_num where `emp_num`= :emp_num;");
        $stat->bindParam(':emp_num', $emp_num);
        $stat->bindParam(':emp_name', $emp_name);
        $stat->bindParam(':emp_idnum', $emp_idnum);
        $stat->bindParam(':emp_phone', $emp_phone);
        $stat->bindParam(':emp_imei', $emp_imei);
        $stat->bindParam(':office_num',$office_num);
        
        if($stat->execute())
		{
			echo "<span style=\"color:green;\">更新成功！</span>";
			echo '<meta http-equiv="refresh" content="2; url=employees.php">';
		}
		else
		{
			echo "<span style=\"color:red;\">更新失敗！</span>";
			echo '<meta http-equiv="refresh" content="2; url=employees.php">';
		}
    }
    
    function update_r($record_id, $emp_num, $office_num, $record_time, $record_status, $imei){
        global $db;
        $stat = $db->prepare("UPDATE `record` set `emp_num` = :emp_num, `office_num` = :office_num, `record_time`= :record_time, `record_status` = :record_status, `imei` = :imei where `record_id`= :record_id;");
        $stat->bindParam(':record_id', $record_id);
        $stat->bindParam(':emp_num', $emp_num);
        $stat->bindParam(':office_num', $office_num);
        $stat->bindParam(':record_time', $record_time);
        $stat->bindParam(':record_status', $record_status);
        $stat->bindParam(':imei',$imei);
        
        if($stat->execute())
		{
			echo "<span style=\"color:green;\">更新成功！</span>";
			echo '<meta http-equiv="refresh" content="2; url=record.php">';
		}
		else
		{
			echo "<span style=\"color:red;\">更新失敗！</span>";
			echo '<meta http-equiv="refresh" content="2; url=record.php">';
		}
    }
    
    function update_b($board_id, $office_num, $board_time, $board_content){
        global $db;
        $stat = $db->prepare("UPDATE `board` set `office_num` = :office_num, `board_time`= :board_time, `board_content` = :board_content where `board_id` = :board_id;");
        $stat->bindParam(':board_id', $board_id);
        $stat->bindParam(':office_num', $office_num);
        $stat->bindParam(':board_time', $board_time);
        $stat->bindParam(':board_content', $board_content);
        
        if($stat->execute())
		{
			echo "<span style=\"color:green;\">更新成功！</span>";
			echo '<meta http-equiv="refresh" content="2; url=board.php">';
		}
		else
		{
			echo "<span style=\"color:red;\">更新失敗！</span>";
			echo '<meta http-equiv="refresh" content="2; url=board.php">';
		}
    }
    
    function update_me($message_id, $emp_num, $emp_name, $emp_imei, $message_content, $message_time, $message_email){
        global $db;
        $stat = $db->prepare("UPDATE `message` set `emp_num` = :emp_num, `emp_name`= :emp_name, `emp_imei` = :emp_imei, `message_content` = :message_content, `message_time` = :message_time, `message_email` = :message_email where `message_id`= :message_id;");
        $stat->bindParam(':message_id', $message_id);
        $stat->bindParam(':emp_num', $emp_num);
        $stat->bindParam(':emp_name', $emp_name);
        $stat->bindParam(':emp_imei', $emp_imei);
        $stat->bindParam(':message_content', $message_content);
        $stat->bindParam(':message_time', $message_time);
        $stat->bindParam(':message_email', $message_email);
        
        if($stat->execute())
		{
			echo "<span style=\"color:green;\">更新成功！</span>";
			echo '<meta http-equiv="refresh" content="2; url=message.php">';
		}
		else
		{
			echo "<span style=\"color:red;\">更新失敗！</span>";
			echo '<meta http-equiv="refresh" content="2; url=message.php">';
		}
    }
}
?>