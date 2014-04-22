<?php
	//json_encode中文乱码问题修正
	function arrayRecursive(&$array){  
		foreach ($array as $key => $value) {  
			if (is_array($value)) {  
				arrayRecursive($array[$key]);//如果是数组就进行递归操作  
			} else {  
				if(is_string($value)){  
					$temp1= addslashes($value);
					$array[$key]= urlencode($temp1);//如果是字符串就urlencode  
				}else{  
					$array[$key] = $value;  
				}  
			}  
		}  
	}  
	function JSON($result) {  
		$array=$result;  
		arrayRecursive($array);//先将类型为字符串的数据进行 urlencode  
		$json = json_encode($array);//再将数组转成JSON  
		return urldecode($json);//最后将JSON字符串进行urldecode  
	}
	
	$scheme_str = $_POST['scheme'];
	$scheme_array = json_decode($scheme_str,true);
	
	// $con = mysql_connect("localhost","root","");
	$con = mysql_connect("10.32.1.6","root","root");
	if (!$con){
		$data['code'] = 0;
		$data['data'] = 'Could not connect: ' . mysql_error();
	}
	
	mysql_select_db("cliq_auto_test", $con);
	
	foreach($scheme_array as $key=>$value){
		$scheme_id = $scheme_array[$key]['select_id'];
		$result = mysql_query("UPDATE scheme SET `status` = 0 WHERE scheme_id = '$scheme_id'");
		if(mysql_affected_rows($con)>0){
			$return_data[] = Array(
				'id' => $scheme_id,
				'code' => 1
			);
		}else{
			$return_data[] = Array(
				'id' => $scheme_id,
				'code' => 0
			);
		}
	}
	mysql_close($con);
	
	echo JSON($return_data);
?>