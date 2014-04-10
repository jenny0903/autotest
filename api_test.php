<?php
include_once('curl.php');

$api = $_POST['api'];

$api =  json_decode($api,true);

$data = array();
$success = 0;
$fail = array();
foreach($api as $value){
	$api = $value['select_id'];
	$time = $value['test_time'];
	
	for(var i = 0; i < $time; i++){
		switch($api){
			case 1:
				$result = getuserinfo($uid,$token);
				break;
			case 2:
				break;
		}
		$code = $result['code'];
		if($code == 200){
			// $data['code']['success'] += 1; 
			$success++; 
		}else{
			$fail[] = array(
				"object_id" => i,
				"object_code" => $code,
				"object_data" => $result['data']
			);
		}
	}
	$data[] = array(
		"success" => $success,
		"fail" => $fail
	);
	$success = 0;
	$fail = array();
}

echo JSON($data);

?> 