<?php
$con = mysql_connect("10.32.1.6","root","root");
if (!$con){
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("cliq_auto_test", $con);

$sch_flag = 0;
$api_success = 0;
$api_fail = array();
$api_code = array();
$sch_success = array();
$sch_code = array();
$time_code = array();
$schemes = $_POST['scheme'];

$schemes = json_decode($schemes,true);
foreach($schemes as $value01){
	$scheme_id = $value['scheme'];
	$sch_time = $value['test_time'];
	//取方案
	$sql01 = "SELECT * FROM scheme WHERE scheme_id='$scheme_id'";
	
	$result01 = mysql_query($sql01);

	if(mysql_num_rows($result01) > 0){
		//循环执行方案
		for(var j=0; j<$sch_time ; j++){
			//遍历方案，获取api
			while($row = mysql_fetch_array($result01)){
				// echo $row['api_id'].'**'.$row['api_time'];
				$api = $row['api_id'];
				$api_time = $row['api_time'];

					//循环执行api
					for(var i=0; i<$api_time; i++){
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
						//保存该次api的单次结果
						if($code == 200){
							$api_success++; 
						}else{
							$api_fail[] = array(
								"object_id" => i,
								"object_code" => $code,
								"object_data" => $result['data']
							);
						}
						
					}
					//保存执行api的结果
					$api_code[] = array(
							"success" => $api_success,
							"fail" => $api_fail
					);
					if($api_success != $api_time ){
						$time_code[] = array(
							"api_id" => $api,
							"api_code" => $api_code
						);
					}else{
						$sch_success++;
					}
					//api中介参数置0
					$api_success = 0;
					$api_fail = array();
			}

			//保存执行方案的单次结果
			if($sch_success != $sch_time ){
				$sch_code[] = array(
					"time" => j,
					"time_code" => $time_code
				);
			}else{
				$success++;
			}
		}
		//保存方案的执行结果
		$data = array(
			"id" => $scheme,
			"sch_code" => $sch_code,
			"success" => $success,
			"fail" => ($sch_time - $success)
		);
	}
// }


?> 