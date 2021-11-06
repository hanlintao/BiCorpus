<?php

session_start();

include "shared/lock.php";

if($user_type > 2)
{
	header("Location: index.php");
}
?>

<?php

mysqli_select_db($conn,DB_DATABASE);
mysqli_query($conn, "set names 'utf8'");

?>

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

//用户发来的数据格式：id=所在单元格div的id，即stutid，value就是这个div中新的值

$fileid = $_POST["id"];
$comments = text_filter($_POST["value"]);

//$references = str_replace("\r\n","<br />",$reference);

//撰写一个更新语句

$sql_update_comments = "UPDATE files SET `comments` ='{$comments}' WHERE `id` = '{$fileid}'";

$update = mysqli_query($conn,$sql_update_comments);

if(!$update)
{
	echo "保存失败";
}
else{
	echo stripcslashes($comments);
}


?>