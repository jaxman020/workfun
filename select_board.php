<?session_start();?>
<?php
    error_reporting(0);
    session_start();
    require_once('function.php');
    global $db;
    $member = new member();
    $manager_num = $_SESSION['manager_num'];
    if(!$_SESSION['LoginSuccess']) {
                //echo "<script>alert('請登入!');</script>";
                header("Location:login.php" );
                exit;
            }
?>
<!doctype html>

<html>
<head>
    
<title>上班打卡趣</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/stylel.css">
<link rel="stylesheet" href="css/default.css">
<script>
    function getData(pageName)
        {
            var req=new XMLHttpRequest();
            req.open("get","http://163.17.9.106/leotest3/"+pageName);
            req.onload=function(){
                var three=document.getElementById("three");
                three.innerHTML=this.responseText;
            };
            req.send();
        }
</script>

    
</head>
    
<body>
    <div id="wrapper">
        
        <div id="header">
            <div id="logo">
                &nbsp;&nbsp;&nbsp;&nbsp;<a href="manager.php" target="content" ><img src="images/main.jpg"></a>
				<h2><a>&nbsp;&nbsp;目前管理者：<?php $member->select_m($manager_num); ?></a></h2>
                <h3 id="e"><input name='delete' type='button' class='b2 button6' value='登出' onclick="if (window.confirm('確定要登出嗎?'))location.href='login.php'"></h3>
            </div>


            
        </div>
       
        <div id="menu">
			<ul>
				<li><a href="manager.php" target="content" ><img class="menu" src="images/phone-book.png">&nbsp;&nbsp;&nbsp;管理人員</a></li>
				<li><a href="employees.php" ><img class="menu" src="images/group.png">&nbsp;&nbsp;&nbsp;員工資料</a></li>
				<li><a href="record.php" target="content"><img class="menu" src="images/placeholder.png" >&nbsp;&nbsp;&nbsp;打卡紀錄</a></li>
				<li class="current_page_item"><a href="board.php" target="content"><img class="menu" src="images/push-pin.png" >&nbsp;&nbsp;&nbsp;公告管理</a></li>
				<li><a href="message.php" target="content"><img class="menu" src="images/email.png" >&nbsp;&nbsp;&nbsp;問題回報</a></li>
			</ul>
		</div>
        
        <div id="three"> 
            
            <section id="block">
            <span onclick="getData('insert_b_text.php');"><a class="button button1">新增公告</a></span>
			
			<form action="select_board.php" method="post">
            <input id="search" name="keyword" type="Text" placeholder="search..">
		    </form>
			

            </section>
            
            <section id="block2">
                
			<?php
			if(!isset($_POST['keyword'])){
					$_POST['keyword'] = $_SESSION['keyword'];
					}
    
					$_SESSION['keyword'] = $_POST['keyword'];
    				$keyword = $_SESSION['keyword'];
					
                $member->s_b($keyword);
            ?>
                  
            </section>


        
        </div>
    </div>
</body>
</html>