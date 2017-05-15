<!DOCTYPE HTML>
<html>
	<head>
		<title>上班打卡趣</title>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/init.js"></script>
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
						<li class="active"><a href="right-sidebar.php">薪資表</a></li>
						<li><a href="no-sidebar.php">公告管理</a></li>
					</ul>
				</nav>
			</div>
		</div>
		
		<!-- Footer -->
		<div id="featured">
			<div class="container">
			<a href="#" class="button">新增</a>
			<a href="#" class="button">刪除</a>
			<a href="#" class="button">修改</a>
		<p>	
			<?php
                $member->select($username);
            ?>
		</p>
			
			</div>
		</div>

	</body>
</html>