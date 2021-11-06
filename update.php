<?php

session_start();

include "shared/lock.php";

if($user_type > 2)
{
	header("Location: login.php");
}
?>


<?php

include "shared/head.php";

?>
	
<?php

include "shared/navbar.php";

?>

<div class="container">
   <div class="row">
      <div class="col-md-12">
		<div class="col-md-4">
		</div>

		<div class="col-md-4">
				
		</div>

		<div class="col-md-4">
		</div>		
	  </div>
   </div>
   
   <div class="row">
      <div class="col-md-12">
		<div class="col-md-1">
		</div>

		<div class="col-md-10">
<div class="container">
   <div class="row">
      <div class="col-md-12">
		<div class="col-md-2">
		</div>

		<div class="col-md-8">
		
		<?php
		
		$id = $_POST["id"];
		$source_content = mysqli_real_escape_string($conn,$_POST["source_content"]);  
		$target_content = mysqli_real_escape_string($conn,$_POST["target_content"]);  
		
		mysqli_select_db($conn,DB_DATABASE); //连接数据库
		
		mysqli_query($conn,"set names utf8"); //防止出现中文乱码的情况
			 
		$sql = "UPDATE `tmdata` SET `source_content` = '{$source_content}', `target_content` = '{$target_content}' WHERE `id` = {$id}";
					
		$update = mysqli_query($conn,$sql);  
		
		if(!$update)  
			{  
				echo "<div class='alert alert-success'>无法更新翻译单元".mysqli_error($conn)."</div>";  
			}  
			else  
			{  
				echo "<div class='alert alert-success'>翻译单元更新成功！</div>";	
				echo "<a type='btn' class='btn btn-primary'href='edit.php'>查看数据</a>";
			}  
		
		mysqli_close($conn);  
		?>
		</div>

		<div class="col-md-2">
		</div>		
	  
	  </div>
    
   </div>

</div>
</body>
</html>