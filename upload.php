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
	<div class="col-md-2">
	</div>
	<div class="col-md-8">
	
		<form role="form" method="POST" action="upload_file.php" enctype="multipart/form-data">
			<div class="form-group">
				<label>领域</label>
				<input type="text" class="form-control" name="field" placeholder="请输入双语文本的领域">
			</div>
			
			<div class="form-group">
				<label>文件说明</label>
				<textarea class="form-control" rows="3" name="description" ></textarea>
			</div>
			<div class="form-group">
				<label for="file">上传文件</label>
				<input type="file" name="file" id="file" />
			</div>
			
			<div class="form-group">
				
				<label>选择语言对</label>
		            <select class="form-control"  name="language">
						<option selected="" disabled="">语言对列表</option>
		               	<option value='1'>中英</option>
						<option value='2'>英中</option>
						<option value='3'>中法</option>
						<option value='4'>法中</option>
						<option value='5'>中日</option>
						<option value='6'>日中</option>
						<option value='7'>中韩</option>
						<option value='8'>韩中</option>
						<option value='9'>中西</option>
						<option value='10'>西中</option>
						<option value='11'>中俄</option>
						<option value='12'>俄中</option>
						<option value='13'>中意</option>
						<option value='14'>意中</option>
						<option value='15'>中德</option>
						<option value='16'>德中</option>
						<option value='17'>中泰</option>
						<option value='18'>泰中</option>
					</select>
			</div>
			
			<button type="submit" class="btn btn-default">提交</button>
		</form>	
	
	</div>

	<div class="col-md-2">
	</div>
</div>
</div>

</body>
</html>

