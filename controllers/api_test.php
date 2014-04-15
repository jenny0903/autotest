<?php
include_once('../controller.php');

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
			case 'u01':
				$result = update_user_info();
				break;
			case 'u02':
				$result = set_avatar();
				break;
			case 'u03':
				$result = get_avatar();
				break;
			case 'a01':
				$result = get_album_info();
				break;
			case 'a02':
				$result = list_albums();
				break;
			case 'a03':
				$result = create_album();
				break;
			case 'a04':
				$result = update_album();
				break;
			case 'a05':
				$result = del_album();
				break;
			case 'a06':
				$result = get_file_list();
				break;
			case 'a07':
				$result = get_member_list();
				break;
			case 'a08':
				$result = join_album();
				break;
			case 'a09':
				$result = leave_album();
				break;
			case 'a10':
				$result = set_member_role();
				break;
			case 'a11':
				$result = get_member_role();
				break;
			case 'a12':
				$result = get_album_activities();
				break;
			case 'f01':
				$result = get_file_info();
				break;
			case 'f02':
				$result = upload_file();
				break;
			case 'f03':
				$result = download_file();
				break;
			case 'f04':
				$result = del_file();
				break;
			case 'f05':
				$result = copy_file();
				break;
			case 'f06':
				$result = list_comment();
				break;
			case 'f07':
				$result = count_comment();
				break;
			case 'f08':
				$result = post_comment();
				break;
			case 'f09':
				$result = reply_comment();
				break;
			case 'f10':
				$result = del_comment();
				break;
			case 'f11':
				$result = list_like();
				break;
			case 'f12':
				$result = count_like();
				break;
			case 'f13':
				$result = post_like();
				break;
			case 'f14':
				$result = del_like();
				break;
			case 'f15':
				$result = like_flag();
				break;
			case 't01':
				$result = thumbnail();
				break;
			case 'l01':
				$result = link();
				break;
			case 'e01':
				$result = event();
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