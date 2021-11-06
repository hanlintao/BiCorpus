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

if(!isset($_POST['text']))
{
$_POST['text']=$testStr = $result="";
}

?>
<div class="container">
<div class="row">
		
		
			<!--以下是左边的-->
		<div class="col-md-4">

			<form action = "" method = "post" role="search">
			
				<div class="form-group">
					<textarea class="form-control" rows="20" name ="text"><?php echo $_POST["text"]; ?></textarea>
				</div>
				
				<button type="submit" name="check" class="btn btn-default">
					开始查重
				</button>
			
							
			</form>
		</div>

<div class="col-md-8">

<?php
	if(isset($_POST['check'])){
		
		$sens = trim($_POST["text"]);
		
		$sens = preg_replace("/\n*\r*/u",'',$sens);
		//$sens = str_replace(array("\r", "\n", "\r\n"),'<!!>',$sens);
		$sens = str_replace(PHP_EOL,'<!!>',$sens);
		//$sens = str_replace("·",'',$sens);
		//$sens = str_replace("，",'<!!>',$sens);
		$sens = str_replace("。",'。<!!>',$sens);
		$sens = str_replace("。<!!>）",'。）<!!>',$sens);
		$sens = str_replace("？",'？<!!>',$sens);
		//$sens = str_replace("、",'<!!>',$sens);
		//$sens = str_replace(array("\r", "\n", "\r\n"),'<!!>',$sens);
		$sens = str_replace("……",'……<!!>',$sens);
		//$sens = str_replace("：",'<!!>',$sens);
		//$sens = str_replace("——",'<!!>',$sens);
		//$sens = str_replace("—",'<!!>',$sens);
		//$sens = str_replace("“",'',$sens);
		//$sens = str_replace("”",'',$sens);
		$sens = str_replace("！",'！<!!>',$sens);
		
		
		//$sens = str_replace("；",'<!!>',$sens);

		$keywords = preg_split("/[<!!>]+/", $sens);
		$keywords = array_filter($keywords);
		$sum = "";
		//var_dump($keywords);
		//$counted = array_count_values($keywords);
		
		
		
		echo "
							
							<table class=\"table table-bordered\">
								
								<thead>
								<tr>
									<th width= '10%'>序号</th>
									<th width= '65%'>句子</th>
									<th width= '20%'>查重结果</th>
								</tr>
								</thead>
								<tbody>
							";
		$id = 1;
		foreach ($keywords as $key=>$sword)
		{
			$sword = str_replace("“",'',$sword);
			$sword = str_replace("”",'',$sword);
			$sword = str_replace("＂",'',$sword);
			if(!$sword)
			{
				unset( $keywords[$key] );
			}
			else
			{
				
				echo "<tr><td>";
				echo $id;
				echo "</td><td>";
			$sword = preg_replace("/\s+/u",'',$sword);
				echo $sword;
			
			echo "</td><td>";
			
			$sword = preg_replace("/\s+/u",'',$sword);
			$sql = "SELECT * FROM tmdata WHERE source_content LIKE '%{$sword}%' OR target_content LIKE '%{$sword}%'";
		
			mysqli_query($conn,"set names utf8"); 
		
			$result = mysqli_query($conn,$sql);
		
			if(mysqli_num_rows($result) > 0) {
				
				echo "<a type='button' class='btn btn-danger' href='index.php?query=".$sword."' target='_blank'>查看相似</a>";
				
			}
			else{
				echo "<a type='button' class='btn btn-default' href='index.php?query=".$sword."' target='_blank'>无相似</a>";
			}
			
			
			echo "</td></tr>";
			
			$id=$id+1;
			}
			
		}
		
		echo "
							</tbody></table></div>
							";

	}
	else
		{
			echo "	<div class='alert alert-info'>请在左侧粘贴一段中文文本。</div>";
		}
?>

</div>
</div>
</div>

</body>
</html>

