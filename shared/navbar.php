

<div class="row">
<div class="col-md-12">
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.php"><?php echo $strings["title"]; ?></a>
    </div>
	
	
	<ul class="nav navbar-nav">
			<!--<li><a href="notes">关于</a></li> -->
			<li><a href="team.php">团队</a></li>
			<!--<li><a href="segsearch.php">关键词</a></li>-->
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						操作
						<b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
					<li><a href="checkrepetition.php">查重</a></li>
					<li><a href="check.php">检查TMX</a></li>
					<li><a href="edit.php">编辑</a></li>
					<li><a href="upload.php">上传</a></li>
			<?php
			
			if($user_type ==1 )
				{
					echo '<li><a href="listfiles.php">审核</a></li>';
					//echo '<li><a href="wordmap.php">词图</a></li>';
				}
				elseif($user_type == 2)
				{
					echo '<li><a href="listfiles.php">审核状态</a></li>';
				}
			?>
			
				</ul>
			</li>
			
			<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    语种
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
					<li><a href="en">英语</a></li>
					<li><a href="jp">日语</a></li>
					<!--<li><a href="ko">韩语</a></li>-->
					<!--<li><a href="fr">法语</a></li>-->
					<!--<li><a href="es">西语</a></li>-->
					<!--<li><a href="ru">俄语</a></li>-->
					<!--<li><a href="it">意语</a></li>-->
					<!--<li><a href="de">德语</a></li>-->
					<!--<li><a href="th">泰语</a></li>-->
				</ul>
			</li>
	</ul>
		
	
	
	<ul class="nav navbar-nav navbar-right"> 
            <li><a href="user.php"><span class="glyphicon glyphicon-user"></span> 欢迎  <?php echo $login_session; ?> 登录！</a></li> 
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> 退出</a></li> 
    </ul> 
	
    </div>
    
</nav>
</div>
</div>