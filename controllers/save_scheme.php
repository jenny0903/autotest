<?php
	//生成唯一id
	function guid(){
		if (function_exists('com_create_guid')){
			return com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);
			$uuid = substr($charid, 0, 8).$hyphen
					.substr($charid, 8, 4).$hyphen
					.substr($charid,12, 4).$hyphen
					.substr($charid,16, 4).$hyphen
					.substr($charid,20,12);
			return $uuid;
		}
	}

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
	
	$scheme_id = guid();
	$scheme_name = $scheme_array['package_name'];
	$scheme_content = $scheme_array['package_content'];
	
	// $con = mysql_connect("localhost","root","");
	$con = mysql_connect("10.32.1.6","root","root");
	if (!$con){
		$data['code'] = 0;
		$data['data'] = 'Could not connect: ' . mysql_error();
	}
	
	mysql_select_db("cliq_auto_test", $con);
	
	$api_num = count($scheme_content);
	$api_success = 0;
	
	foreach($scheme_content as $key=>$value){
		$api_id = $value['select_id'];
		$api_time = $value['test_time'];
		
		$sql = "INSERT INTO scheme (scheme_id, scheme_name, api_id, api_time, status) VALUES('$scheme_id','$scheme_name','$api_id','$api_time',1)";
		$result = mysql_query($sql);	

		if(mysql_affected_rows($con)==1){
			$api_success++;
		}
	}
	
	if($api_success == $api_num){
		$data['code'] = 1;
		$data['data'] = 'save scheme success';
	}else{
		$data['code'] = 0;
		$data['data'] = 'save scheme failed';
	}
	
	mysql_close($con);
	
	echo JSON($data);
?>