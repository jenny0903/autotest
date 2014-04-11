<?php
include_once('curl.php');

class Controller{
	function update_user_info(){
		$url = SERVER_DOMAIN."/user/me";//PUT /user/{user_id}未实现
		$put_data = array(
			"name" => "tomnameupdate"
		);
		$result = Curl::putApi($url,$put_data);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = '';
		}else{
			$data['data'] = 'update user info failed';
		}
		return Curl::JSON($data);
	}

	function set_avatar(){
		$url =  SERVER_DOMAIN."/user/avatar";
		$put_data =  file_get_contents("../test.jpg");
		$size  = filesize("../test.jpg");
		$result = Curl::putApi($url,$put_data,$size);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = '';
		}else{
			$data['data'] = 'set avatar failed';
		}
		return Curl::JSON($data);
	}
	
	function get_avatar(){
		$url =  SERVER_DOMAIN."/user/avatar/".USER_ID;
		$result = Curl::getContentApi($url);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = '';
		}else{
			$data['data'] = 'get avatar failed';
		}
		return Curl::JSON($data);
	}


}




?> 