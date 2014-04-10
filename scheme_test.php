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
// $schemes = $_POST['scheme'];

// $schemes = json_decode($schemes,true);
// foreach($schemes as $value01){
	// $scheme_id = $value['scheme'];
	// $sch_time = $value['test_time'];
	$scheme = "EBCFF6A0-742F-7AB0-32DE-90175D1B51E4";
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
							case 1:
								$result = getuserinfo($uid,$token);
								break;
							case 2:
								break;
						}			
						$code = $result['code'];
						//保存该次api的单次结果
						if($code == 200){
							// $data['code']['success'] += 1; 
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