<?php
include_once('curl.php');

$url = SERVER_DOMAIN."/user"; 

$post_data = array(
	"name" => "test",
	"email" => "auto@test.com",
	"password" => "test"
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