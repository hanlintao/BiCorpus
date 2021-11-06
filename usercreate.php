<?php

session_start();

include "shared/lock.php";

if($user_type != 1)
{
	header("Location: index.php");
}
?>

<?php

include "shared/head.php";

?>
	
<?php

include "shared/navbar.php";

?>

<div class="container-fluid">

<div class="row">
    <div class="col-md-12">
		<div class="col-md-3">
		</div>

		<div class="col-md-6">
<?php

function text_filter($content)
{
    // 将特殊字符转换为 HTML 实体
    $content = htmlspecialchars($content);
    // 转义元字符集
    $content = quotemeta($content);

    // 自定义过滤字符串,可以根据业务需求进行扩展
    $content = preg_replace('/\'/', "\'", $content);
	
	$content = preg_replace('/\n/', "<br />", $content);
	
	$content = preg_replace('/^\s+/', "", $content);
    
    // . 不进行转换
    //$content = preg_replace('/\\\./', ".", $content);

    return $content;
}

$username = text_filter($_POST["username"]);
$fullname = text_filter($_POST["fullname"]);
$university = text_filter($_POST["university"]);
$password = text_filter($_POST["password"]);
$type = text_filter($_POST["type"]);


mysqli_select_db($conn,DB_DATABASE); //连接数据库

$insert = "INSERT INTO users (username, fullname, university, password, type) VALUES ('{$username}', '{$fullname}', '{$university}','{$password}','{$type}')";

$result = mysqli_query($conn,$insert);

if($result)
{
	echo '<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		已成功添加新用户。
  		</div>';
}
else
{
	echo '<div class="alert alert-success alert-dismissible">
    		<button type="button" class="close" data-dismiss="alert">&times;</button>
    		新用户添加失败，请返回重试。
  		</div>';
}

?>

		
		</div>

		<div class="col-md-3">
		</div>		
	</div>
</div>

</div>

		


</body>
</html>
