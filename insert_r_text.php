<meta charset="UTF8">
<html>
	<form action="insert_r.php" method="POST">
        <div class=out1 style='text-align:center'>打卡編號：<input type="text" name="record_id"><p></div>
        <div class=out1 style='text-align:center'>員工編號：<input type="text" name="emp_num"><p></div>
        <div class=out1 style='text-align:center'>辦公室編號：<select name="office_num">
                                                                 <option value="0101">0101</option>
                                                                 <option value="0102">0102</option>
                                                                 <option value="0103">0103</option>
                                                                 <option value="0104">0104</option>
                                                                 <option value="0105">0105</option>
                                                            </select><p></div>
        <div class=out1 style='text-align:center'>打卡時間：<input type="datetime-local" name="record_time"><p></div>
        <div class=out1 style='text-align:center'>上班/下班：<input type="text" name="record_status"><p></div>
        <div class=out1 style='text-align:center'>IMEI：<input type="text" name="imei"><p></div>
        <div class=out1 style='text-align:center'><input type="submit" value="送出"></div>
    </form>
  
    <a href="record.php" class="button button1">返回</a>
    
</html>