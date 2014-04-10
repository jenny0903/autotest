<?php
include_once('curl.php');

$url = SERVER_DOMAIN."/user/oauth2/access_token"; 

$post_data = array(
	"email" => "auto@test.com",
	"password" => "test",
	"device" => "web"
);

$result = Curl::postApi($url,$post_data);

$code = $result['info_code'];

if($code == 200){
	$data['code'] = 1;
	$data['data'] = '';
}else{
	$data['code'] = 0;
	$data['data'] = '';
}

?> 