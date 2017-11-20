<meta charset="UTF8">
<html>
	<form action="insert_e.php" method="POST">
        <div class=out1 style='text-align:center'>員工編號：<input type="text" name="emp_num"><p></div>
        <div class=out1 style='text-align:center'>名字：<input type="text" name="emp_name"><p></div>
        <div class=out1 style='text-align:center'>身分證字號：<input type="text" name="emp_idnum"><p></div>
        <div class=out1 style='text-align:center'>電話：<input type="text" name="emp_phone"><p></div>
        <div class=out1 style='text-align:center'>IMEI：<input type="text" name="emp_imei"><p></div>
        <div class=out1 style='text-align:center'>辦公室：<select name="office_num">
                                                             <option value="0101">0101</option>
                                                             <option value="0102">0102</option>
                                                             <option value="0103">0103</option>
                                                             <option value="0104">0104</option>
                                                             <option value="0105">0105</option>
                                                        </select><p></div>
        <div class=out1 style='text-align:center'><input type="submit" value="送出"></div>
    </form>

    <a href="employees.php" class="button button1">返回</a>
    
</html>