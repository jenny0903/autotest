<?php
include_once('../libraries/controller.php');

$api = $_POST['api'];
$api =  json_decode($api,true);

$data = array();
$success = 0;
$fail = array();
$controller = new Controller();

foreach($api as $value){
	$api = $value['select_id'];
	$time = $value['test_time'];
	
	for($i = 0; $i < $time; $i++){
		switch($api){
			case 'u01':
				$result = $controller->update_user_info();
				break;
			case 'u02':
				$result = $controller->set_avatar();
				break;
			case 'u03':
				$result = $controller->get_avatar();
				break;
			case 'a01':
				$result = $controller->get_album_info();
				break;
			case 'a02':
				$result = $controller->list_albums();
				break;
			case 'a03':
				$result = $controller->create_album();
				break;
			case 'a04':
				$result = $controller->update_album();
				break;
			case 'a05':
				$result = $controller->del_album();
				break;
			case 'a06':
				$result = $controller->get_file_list();
				break;
			case 'a07':
				$result = $controller->get_member_list();
				break;
			case 'a08':
				$result = $controller->join_album();
				break;
			case 'a09':
				$result = $controller->leave_album();
				break;
			case 'a10':
				$result = $controller->set_member_role();
				break;
			case 'a11':
				$result = $controller->get_member_role();
				break;
			case 'a12':
				$result = $controller->get_album_activities();
				break;
			case 'f01':
				$result = $controller->get_file_info();
				break;
			case 'f02':
				$result = $controller->upload_file();
				break;
			case 'f03':
				$result = $controller->download_file();
				break;
			case 'f04':
				$result = $controller->del_file();
				break;
			case 'f05':
				$result = $controller->copy_file();
				break;
			case 'f06':
				$result = $controller->list_comment();
				break;
			case 'f07':
				$result = $controller->count_comment();
				break;
			case 'f08':
				$result = $controller->post_comment();
				break;
			case 'f09':
				$result = $controller->reply_comment();
				break;
			case 'f10':
				$result = $controller->del_comment();
				break;
			case 'f11':
				$result = $controller->list_like();
				break;
			case 'f12':
				$result = $controller->count_like();
				break;
			case 'f13':
				$result = $controller->post_like();
				break;
			case 'f14':
				$result = $controller->del_like();
				break;
			case 'f15':
				$result = $controller->like_flag();
				break;
			case 't01':
				$result = $controller->thumbnail();
				break;
			case 'l01':
				$result = $controller->link();
				break;
			case 'e01':
				$result = $controller->event();
				break;
		}
		$code = $result['code'];
		if($code == 200){
			// $data['code']['success'] += 1; 
			$success++; 
		}else{
			$fail[] = array(
				"obj_id" => ($i+1),
				"obj_code" => $code,
				"obj_data" => $result['data']
			);
		}
	}
	$data[] = array(
		"id" => $api,
		"api_code" => array(
			"success" => $success,
			"fail" => $fail
		)
	);
	$success = 0;
	$fail = array();
}

echo Curl::JSON($data);

?> 