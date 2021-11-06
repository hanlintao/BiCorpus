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
		<div class="col-md-1">
		</div>

		<div class="col-md-10">

<?php

$id=$_GET["id"];

mysqli_select_db($conn,DB_DATABASE); //连接数据库

mysqli_query($conn,"set names utf8"); //防止出现中文乱码的情况

 //选择数据表中的字段
   
$sql = "SELECT * FROM tmdata WHERE id={$id}";

mysqli_query($conn,"set names utf8"); //防止出现中文乱码的情况

$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$source_content = $row["source_content"];

$target_content = $row["target_content"];

?>
<div class="container">
   <div class="row">
      <div class="col-md-12">
		<div class="col-md-2">
		</div>

		<div class="col-md-8">
			<form method="POST" action="update.php" > 
				<div class="input-group">
					<span class="input-group-addon">原文</span>
					
					<textarea class="form-control" rows="3" name="source_content" ><?php echo $source_content; ?></textarea>
				</div>					
				<br>
				<div class="input-group">
					<span class="input-group-addon">译文</span>
					<textarea class="form-control" rows="3" name="target_content" ><?php echo $target_content; ?></textarea>
				</div>	
				<br>
				<div class="input-group">
					<input type="hidden"  name="id" value ="<?php echo $id; ?>" >
				</div>						

				<div class="input-group">
					<button class="btn btn-primary" type="submit">更新</button>
				</div>					
			</form>		
		</div>

		<div class="col-md-2">
		</div>		
	  
	  </div>
    
   </div>

</div>		


</body>
</html>