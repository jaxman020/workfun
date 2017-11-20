<meta charset="UTF8">
<html>
	<form action="insert_b.php" method="POST">
        <div class=out1 style='text-align:center'>公告編號：<input type="text" name="board_id"><p></div>
        <div class=out1 style='text-align:center'>辦公室編號：<input type="text" name="office_num"><p></div>
        <div class=out1 style='text-align:center'>公告時間：<input type="datetime-local" name="board_time"><p></div>
        <div class=out1 style='text-align:center'>內容：<textarea name="board_content"></textarea><p></div>
        <div class=out1 style='text-align:center'><input type="submit" value="送出"></div>
    </form>
  
    <a href="board.php" class="button button1">返回</a>
    
</html>