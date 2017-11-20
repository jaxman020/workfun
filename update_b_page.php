
<?php
    error_reporting(0);
    session_start();
    require_once('function.php');
    global $db;
    $member = new member();
    $manager_num = $_SESSION['manager_num'];
    $board_id = $_GET['board_id'];
?>
<html>
    <link rel="stylesheet" href="css/stylel.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
.container{
 width:290px;
  
}
.mail{
 font-family:微軟正黑體;
 font-size:22px;
}
</style>
    <?php
        $member->select_bu($board_id);
    ?>
	
    <a href="board.php" class="button button1">返回</a>

</html>