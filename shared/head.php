<?php

include "resource.php";

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

<script src="https://cdn.bootcss.com/jeditable.js/2.0.15/jquery.jeditable.min.js"></script>

<script src="https://cdn.bootcss.com/jeditable.js/2.0.15/jquery.jeditable.autogrow.min.js"></script>

<script src="js/jquery.autogrowtextarea.min.js"></script>	

<script src="js/echarts.min.js"></script>
<script src="js/echarts-wordcloud.min.js"></script>

<link href="js/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>



	<style>

	.editarea textarea 
	{

		height: 110px; 
		width: 10px; 
		overflow: hidden; 
		min-height: 2em; 
		margin: 0px;
	}

	.editarea button {
    display: inline-block;
    border: none;
    padding: 1rem 2rem;
    margin: 0;
    text-decoration: none;
    background: #0069ed;
    color: #ffffff;
    font-family: sans-serif;
    font-size: 1rem;
    cursor: pointer;
    text-align: center;
    transition: background 250ms ease-in-out, 
                transform 150ms ease;
    -webkit-appearance: none;
    -moz-appearance: none;
}

.editarea button:hover,
.editarea button:focus {
    background: #0053ba;
}

.editarea button:focus {
    outline: 1px solid #fff;
    outline-offset: -4px;
}

button:active {
    transform: scale(0.99);
}
	</style>

<style>
    #progress {
      width: 100%;
      border: 1px solid #aaa;
      height: 20px;
    }
    #progress .bar {
      background-color: #5cb85c;
      height: 20px;
    }
  </style>
<script type="text/javascript"> 
    var userAgent = navigator.userAgent.toLowerCase(); 
    var platform; 
    if(userAgent == null || userAgent == ''){
        platform = 'WEB' ;
		location.href = "localhost/index.php";
    }else{
         if(userAgent.indexOf("android") != -1 ){
             platform = 'ANDROID';
             location.href = "localhost/mobileindex.php";
         }else if(userAgent.indexOf("ios") != -1 || userAgent.indexOf("iphone") != -1){
             platform = 'IOS';
             location.href = "localhost/mobileindex.php";
         }else if(userAgent.indexOf("windows phone") != -1 ){
             platform = 'WP';
             location.href = "localhost/mobileindex.php";
         }
  }
</script>

<title><?php echo $string["title"]; ?></title>
</head>
<body>