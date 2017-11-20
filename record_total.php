<meta charset="UTF8">

<?php
session_start();
//連接資料庫
require_once("function.php");//引入函數庫
//$member = new member();
//$member->delete_b($board_id);//使用刪除使用者函數


require_once("config.inc.php");
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
            <a href="record.php" class="button button1">返回</a>
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
?>
