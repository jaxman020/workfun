<html >
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>E-mail</title>
<style>
.mail .container{
 width:400px; 
}
.mail{
 font-family:微軟正黑體;
 font-size:22px;
}
</style>
</head>

<body>
<div class="mail">
    <div class="container">
        <div class="header" style="text-align:center; font-size:24px; padding:30px 0">
        問題回報
        </div>
    <form id="msg" name="msg" method="post" action="MailTo:s0919651111@gmail.com">
      
      <div class="">
        <label for="subject">信件主旨</label>
        <input type="text" class="form-control" id="subject" name="subject" placeholder="輸入主旨">
      </div>
      <div class="form-group">
        <label for="content">信件內容</label>
        <textarea class="form-control" id="content" name="content" rows="5"></textarea>
      </div>
      <div align="right">
	   <a href="no-sidebar.php" class="btn btn-default">返回</a>
	   &nbsp;&nbsp;
	   <button type="submit" class="btn btn-default" >寄出</button>
      </div>
	  
    </form>
    </div>
</div>
</body>
</html>

