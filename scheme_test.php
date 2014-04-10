<?php
include_once('curl.php');

$con = mysql_connect("10.32.1.6","root","root");
if (!$con){
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("cliq_auto_test", $con);

$sch_flag = 0;

// $schemes = $_POST['scheme'];

// $schemes = json_decode($schemes,true);
// foreach($schemes as $value01){
	// $scheme = $value['scheme'];
	// $time = $value['test_time'];
	$scheme = "EBCFF6A0-742F-7AB0-32DE-90175D1B51E4";
	
	$sql01 = "SELECT * FROM scheme WHERE scheme_id='$scheme'";
	
	$result01 = mysql_query($sql01);

	if(mysql_num_rows($result01) > 0){
		// foreach(mysql_fetch_array($result01) as $value02){
			// echo $value02['api_id'].'**'.$value02['api_time'];
			// exit;
		// }
		// while($row = mysql_fetch_array($result01)){
			// echo $row['api_id'].'**'.$row['api_time'];
		// }
		while($row = mysql_fetch_assoc($result01)){
		   $scheme_tmp_array[] = $row;
		}
		echo "<pre>";
		var_dump($scheme_tmp_array);
		exit;
	}
// }


// $data = array();
// $sch_success = 0;
// $sch_fail = array();
// foreach($schemes as $value){
	// $scheme = $value['scheme'];
	// $time = $value['test_time'];
	
	// for(var i = 0; i < $time; i++){
		// switch($api){
			// case 1:
				// $result = getuserinfo($uid,$token);
				// break;
			// case 2:
				// break;
		// }
		// $code = $result['code'];
		// if($code == 200){
			// $data['code']['success'] += 1; 
			// $success++; 
		// }else{
			// $fail[] = array(
				// "object_id" => i,
				// "object_code" => $code,
				// "object_data" => $result['data']
			// );
		// }
	// }
	// $data[] = array(
		// "success" => $success,
		// "fail" => $fail
	// );
	// $success = 0;
	// $fail = array();
// }

// echo JSON($data);

?> 