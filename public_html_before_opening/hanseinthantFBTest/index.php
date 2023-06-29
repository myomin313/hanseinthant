<?php
$access_token = "EAAFog2xX2P8BAH0EipcgOy9YeeAHBMG9ZBiq9YADNk8yPgwlahpw0ii6KGQsCB89RSWQ1cdnI8a9JdgZCZAlZCB9I6sMuBQVQFfNWzEQQbXYAaSzKuL1Up4bQNrZCmvknIozUQmbAp7zlx5lDPBNFZBaFfURj7xvNGimZCN9lqjT9wEQAps5gCo";
$verify_token = "fb_time_bot";
$hub_verify_token = null;

if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}


if ($hub_verify_token === $verify_token) {
    echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);
// Get the Senders Graph ID
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
// Get the returned message
$message = $input['entry'][0]['messaging'][0]['message']['text'];
$url = 'https://graph.facebook.com/v4.0/me/messages?access_token='.$access_token;
//Initiate cURL.
$ch = curl_init($url);
//The JSON data.
$jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
    }, 
    "message":{
        "text":"Why not every one work?"
    }
}';

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//Execute the request but first check if the message is not empty.
if(!empty($input['entry'][0]['messaging'][0]['message'])){
  $result = curl_exec($ch);
}


?>