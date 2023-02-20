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
			
			
				<!--以下是左边的-->
			<div class="col-md-4">
				
				<div class="form-group">
					<textarea class="form-control" rows="10" id="prompt" name ="prompt"><?php echo $_POST["prompt"]; ?></textarea>
				</div>
					
				<button type="submit" name="ask" id = "chatapi" class="btn btn-default">
					提问
				</button>
				
			</div>

			<div class="col-md-8">
				<pre id = "result">
				<pre>
			</div>
	</div>
</div>

</body>

<script>


$("#chatapi").click(async function(){

	//清空当前的页面
	var responseResult = document.getElementById("result");

	responseResult.innerHTML = "";

	function printMessage(message){

	  var responseText = document.getElementById("result");

	  var index = 0;

	  var interval = setInterval(function() {

		responseText.innerHTML += message[index];

		index++;

		if(index >= message.length){

		  clearInterval(interval);

		}
	  },150);
	}

	await printMessage("回答生成中...请耐心等待...");

    //获取用户的prompt

	var prompt = $("textarea[name=prompt]").val();

    prompt = prompt.replace(/^\s*|\s*$/g,"");

    document.querySelector('#chatapi').innerHTML = "思考中...";

	//调用API
    $.post('chatapi.php', {

		prompt: prompt,

  	}, (response) => {
	  
		document.querySelector('#chatapi').innerHTML = "提问";

		//console.log(response);
		
		//document.getElementById("result").innerHTML = "AI无法回答此问题，请检查问题中是否有多余的换行或非法字符，并刷新当前页面。";
		
		text = response.replace(/^\s*|\s*$/g,"");
		
		//逐行输出

		var responseText = document.getElementById("result");
		
		responseText.innerHTML="";
		
		var index = 0;
		
		var interval = setInterval(function() {
		
			responseText.innerHTML += text[index];
			
			index++;
			
			if(index >= text.length) {
				
				clearInterval(interval);

			}
		
		},50);

	})  

});  

</script>
</html>

