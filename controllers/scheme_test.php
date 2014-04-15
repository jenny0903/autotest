<?php
include_once('../libraries/controller.php');

$con = mysql_connect("10.32.1.6","root","root");
if (!$con){
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("cliq_auto_test", $con);

$api_success = 0;
$api_fail = array();
$api_num = 0;
$time_success = 0;
$time_code = array();
$sch_success = 0;
$sch_code = array();
$schemes = $_POST['scheme'];
$controller = new Controller();

$schemes = json_decode($schemes,true);
foreach($schemes as $value01){
	$scheme_id = $value01['select_id'];
	$sch_time = $value01['test_time'];
	//取方案
	$sql01 = "SELECT * FROM scheme WHERE scheme_id='$scheme_id'";
	$result01 = mysql_query($sql01);
	$sch_success = 0;
	$sch_code = array();
	if(mysql_num_rows($result01) > 0){
		//循环执行方案
		$api_num = 0;
		$time_success = 0;
		$time_code = array();
		for($j=0; $j<$sch_time ; $j++){
			//遍历方案，获取api		
			while($row = mysql_fetch_array($result01)){
				$api_success = 0;
				$api_fail = array();
				$api_num++;
				$api = $row['api_id'];
				$api_time = $row['api_time'];
				//循环执行api
				for($i=0; $i<$api_time; $i++){
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
					//保存该次api的单次结果
					if($code == 200){
						$api_success++; 
					}else{
						$api_fail[] = array(
							"obj_id" => ($i+1),
							"obj_code" => $code,
							"obj_data" => $result['data']
						);
					}
					//保存执行api的结果
					// $api_code[] = array(
							// "success" => $api_success,
							// "fail" => $api_fail
					// );					
				}
				$time_code[] = array(
						"api_id" => $api,
						"api_code" => array(
							"success" => $api_success,
							"fail" => $api_fail
						)		
					);
				if($api_success == $api_time ){
					$time_success++;
				}
			}
			//保存执行方案的单次结果
			$sch_code[] = array(
				"time" => ($j+1),
				"time_code" => $time_code
			);
			if($time_success == $api_num ){
				$sch_success++;
			}
		}
		//保存方案的执行结果		
		$data[] = array(
			"id" => $scheme_id,
			"sch_code" => $sch_code,
			"success" => $sch_success,
			"fail" => ($sch_time - $sch_success)
		);
	}
}
echo Curl::JSON($data);

?> 