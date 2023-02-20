<?php

session_start();

include "shared/lock.php";

if($user_type > 2)
{
	header("Location: login.php");
}
?>

<?php

//从数据库中获取与当前句子最相关的

function ChatGPT($prompt) {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/completions");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"model\": \"text-davinci-003\",
        \"prompt\": \"" . $prompt . "\",
        \"max_tokens\": 500,
        \"top_p\": 1,
        \"stop\": \"\"
    }");
    curl_setopt($ch, CURLOPT_POST, 1);

    $headers = array();

    $headers[] = "Content-Type: application/json";

    $headers[] = "Authorization: Bearer "."********"; //请在这里输入您自己的Openai Key

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    

    $result = curl_exec($ch);

    $info = curl_getinfo($ch);

    $httpCode = $info['http_code'];

    if (curl_error($ch)) {

        $response_text = curl_error($ch);

    } else {
        
        $response_obj = json_decode($result);

        $response_text = $response_obj->choices[0]->text;
    }

    curl_close ($ch);
    
    return $response_text;
}

echo ChatGPT($_POST['prompt']);


?>