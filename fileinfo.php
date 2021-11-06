<?php

session_start();

if (isset($_SESSION['login_user']) && !empty($_SESSION['login_user'])) {
    include "shared/lock.php";
}else{
   include "shared/config.php";
}
?>


<?php

include "shared/head.php";

?>
	
<?php

if (isset($_SESSION['login_user']) && !empty($_SESSION['login_user'])) {
	include "shared/navbar.php";
}
else
{
	include "shared/public_navbar.php";
}

?>

<?php

$id = $_GET["id"];

$sql = "
SELECT files.sourcefilename AS Sourcefilename, files.savefilepath AS Safefilepath, files.uploaduser AS Uploaduser, files.uploadtime AS Uploadtime, files.field AS Field, files.description AS Description

FROM tmdata 
INNER JOIN files
ON tmdata.file_id = files.id
WHERE tmdata.id = '{$id}'
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
				<td width='30%'>来源文件</td>
				<td width='70%'><?php echo $row["Sourcefilename"];?></td>
			</thead>
			<tr>
				<td width='30%'>下载地址</td>
				<td width='70%'><?php echo "<a href='".$row["Safefilepath"]."'>下载</a>" ;?></td>
			</tr>
			<tr>
				<td width='30%'>上传用户</td>
				<td width='70%'><?php echo $row["Uploaduser"];?></td>
			</tr>
			<tr>
				<td width='30%'>上传时间</td>
				<td width='70%'><?php echo $row["Uploadtime"];?></td>
			</tr>
			<tr>
				<td width='30%'>所属领域</td>
				<td width='70%'><?php echo $row["Field"];?></td>
			</tr>
			<tr>
				<td width='30%'>文件描述</td>
				<td width='70%'><?php echo $row["Description"];?></td>
			</tr>
		</table>
			
		</div>

		<div class="col-md-2">
		</div>		
	  </div>
   </div>
</div>