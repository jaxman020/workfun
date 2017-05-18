<?php
    //error_reporting(0);
    session_start();
    require_once('function.php');
    global $db;
    $member = new member();
    $username = $_SESSION['username'];
?>

<html>
	<head>
		<title>上班打卡趣</title>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/init.js"></script>
        <script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/init.js"></script>	
        <script type="text/javascript">
            function getData(pageName)
            {
                var req=new XMLHttpRequest();
                req.open("get","http://127.0.0.1/workfun/workfun/"+pageName);
                req.onload=function(){
                    var featured=document.getElementById("featured");
                    featured.innerHTML=this.responseText;
                };
                req.send();
            }
        </script>
	</head>
	<body class="homepage">

		<!-- Header -->
		<div id="header">
			<div class="container"> 
				
				<!-- Logo -->
				<div id="logo">
					<h1><a href="main.php">上班打卡趣</a></h1>
				</div>
				
				<!-- Nav -->
				<nav id="nav">
					<ul>
						<li><a href="main.php">員工資料</a></li>
						<li><a href="left-sidebar.php">打卡紀錄</a></li>
						<li><a href="right-sidebar.php">薪資表</a></li>
						<li class="active"><a href="no-sidebar.php">公告管理</a></li>
					</ul>
				</nav>
			</div>
		</div>
		
		<!-- Footer -->
		<div id="featured">
			<div class="container">
			<span onclick="getData('EMPLOYEEtext.php');"><a class="button">新增</a></span>
                <span onclick="getData('deletetext.php');"><a class="button">刪除</a></span>
                <span onclick="getData('EMPLOYEEtext.php');"><a class="button">修改</a></span>
		<p>	
			<?php
                
                $member->select_b($username);
            ?>
		</p>
			
			</div>
		</div>

		
		
	</body>
</html>