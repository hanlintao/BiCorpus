

<div class="row">
<div class="col-md-12">
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.php"><?php echo $strings["title"]."-".$code;?></a>
    </div>
	
	
	<ul class="nav navbar-nav">
			<li><a href="../index.php">主页</a></li>
            <li><a href="../edit.php">编辑</a></li>
            <li><a href="../upload.php">上传</a></li>
			<?php
			
			if($user_type ==1 )
				{
					echo '<li><a href="../listfiles.php">审核</a></li>';
				}
			?>
			<!--<li><a href="../notes">关于</a></li>-->
			<!--<li><a href="../volunteers.php">志愿者</a></li>-->
	</ul>
		
	
	
	<ul class="nav navbar-nav navbar-right"> 
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> 欢迎  <?php echo $login_session; ?> 登录！</a></li> 
            <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> 退出</a></li> 
    </ul> 
	
    </div>
    
</nav>
</div>
</div>