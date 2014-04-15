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
	
	// $con = mysql_connect("localhost","root","");
	$con = mysql_connect("10.32.1.6","root","root");
	if (!$con){
		$data['code'] = 0;
		$data['data'] = 'Could not connect: ' . mysql_error();
	}
	
	mysql_select_db("cliq_auto_test", $con);
	
	$result = mysql_query("SELECT * FROM scheme WHERE `status` = 1 ORDER BY scheme_id");
	if(mysql_num_rows($result)==0){
		$scheme_array = Array();
		$data['code'] = 1;
		$data['data'] = $scheme_array;
	}else if((mysql_num_rows($result)>0)){
		while($row = mysql_fetch_assoc($result))
		{
			$scheme_tmp_array[] = $row;
		}
		// var_dump($scheme_tmp_array);
		// exit;
		$temp_scheme_content = Array();
		foreach($scheme_tmp_array as $key=>$value){
			if($key == 0){
				$old_scheme = $scheme_tmp_array[0]['scheme_id'];
				$old_scheme_name = $scheme_tmp_array[0]['scheme_name'];
			}else{
				$old_scheme = $scheme_tmp_array[$key-1]['scheme_id'];
				$old_scheme_name = $scheme_tmp_array[$key-1]['scheme_name'];
			}
			$new_scheme = $scheme_tmp_array[$key]['scheme_id'];
			if($new_scheme == $old_scheme){
				$temp_scheme_content[] = $scheme_tmp_array[$key];
			}else{
				$return_scheme_content[] = Array(
					'scheme_id' => $old_scheme,
					'scheme_name' => $old_scheme_name,
					'scheme_obj' => $temp_scheme_content
				);
				$temp_scheme_content = Array();
				$temp_scheme_content[] = $scheme_tmp_array[$key];
			}
		}
		$return_scheme_content[] = Array(
			'scheme_id' => $old_scheme,
			'scheme_name' => $old_scheme_name,
			'scheme_obj' => $temp_scheme_content
		);
		$temp_scheme_content = Array();
		
		$data['code'] = 1;
		$data['data'] = $return_scheme_content;
	}else{
		$data['code'] = 0;
		$data['data'] = 'get scheme error';
	}
	
	echo JSON($data);
?>