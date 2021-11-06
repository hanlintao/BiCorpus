<?php

session_start();


include "shared/lock.php";

?>


<?php

include "shared/head.php";

?>
	
<?php


include "shared/navbar.php";


?>

<?php



$sql = "
SELECT * FROM users WHERE id = '{$user_id}'
";

mysqli_select_db($conn,DB_DATABASE); 
mysqli_query($conn,"set names utf8"); 
			
$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);



?>


<div class="container">
   <div class="row">
      <div class="col-md-12">
		<div class="col-md-2">
		</div>

		<div class="col-md-8">
			
		<table class='table table-bordered table-striped'>
			<thead>
				<td width='30%'>用户名</td>
				<td width='70%'><?php echo $row["username"];?></td>
			</thead>
			<tr>
				<td width='30%'>成果主页</td>
				<td width='70%'><?php echo "<a href='contribution.php?id=".$row["id"]."' target='_blank'>查看</a>" ;?></td>
			</tr>
			<tr>
				<td width='30%'>全名</td>
				<td width='70%'><?php echo $row["fullname"];?></td>
			</tr>
			<tr>
				<td width='30%'>单位</td>
				<td width='70%'><?php echo $row["university"];?></td>
			</tr>
			<tr>
				<td width='30%'>密码</td>
				<td width='70%'>******</td>
			</tr>
		</table>
			
		</div>

		<div class="col-md-2">
		</div>		
	  </div>
   </div>
</div>