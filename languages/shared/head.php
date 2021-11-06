<?php 

include "../shared/resource.php";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- 新 Bootstrap 核心 CSS 文件 -->
<link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
 
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
 
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script type="text/javascript"> 
    var userAgent = navigator.userAgent.toLowerCase(); 
    var platform; 
	
	var code = <?php echo "'".$folder."'";?>
	
    if(userAgent == null || userAgent == ''){
        platform = 'WEB' ;
		location.href = "localhost"+code+"/index.php";
    }else{
         if(userAgent.indexOf("android") != -1 ){
             platform = 'ANDROID';
             location.href = "localhost"+code+"/mobileindex.php";
         }else if(userAgent.indexOf("ios") != -1 || userAgent.indexOf("iphone") != -1){
             platform = 'IOS';
             location.href = "localhost"+code+"/mobileindex.php";
         }else if(userAgent.indexOf("windows phone") != -1 ){
             platform = 'WP';
             location.href = "localhost"+code+"/mobileindex.php";
         }
  }
</script>

<title><?php echo $strings["title"]."-".$code;?></title>
</head>
<body>