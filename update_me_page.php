<meta charset="UTF8">
<?php
    error_reporting(0);
    session_start();
    require_once('function.php');
    global $db;
    $member = new member();
    $manager_num = $_SESSION['manager_num'];
    $message_id = $_GET['message_id'];
?>
<html>
    <link rel="stylesheet" href="css/stylel.css">

    <?php
        $member->select_meu($message_id);
    ?>
	
    <a href="message.php" class="button button1">返回</a>

</html>