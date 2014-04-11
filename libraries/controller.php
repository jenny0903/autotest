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
			$data['data'] = 'update user info success';
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
			$data['data'] = 'set avatar success';
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
			$data['data'] = "get avatar success";
		}else{
			$data['data'] = 'get avatar failed';
		}
		return Curl::JSON($data);
	}
	
	function get_album_info(){
		$url =  SERVER_DOMAIN."/album/".ALBUM_ID;
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'get album info failed';
		}
		return Curl::JSON($data);
	}

	function list_albums(){
		$url =  SERVER_DOMAIN."/album/".ALBUM_ID;
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'list albums failed';
		}
		return Curl::JSON($data);
	}
	
	function create_album(){
		$url =  SERVER_DOMAIN."/album";
		$post_data = array(
			"name" => Curl::guid(),
		);
		$result = Curl::postApi($url,$post_data);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'create album failed';
		}
		return Curl::JSON($data);
	}
	
	function update_album(){
		$url =  SERVER_DOMAIN."/album/".ALBUM_ID;
		$put_data = array(
			"name" => "album1nameupdate",
		);
		$result = Curl::putApi($url,$put_data);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'update album failed';
		}
		return Curl::JSON($data);
	}
	
	function del_album(){
		$createalbum = new Controller();
		$createalbum = Controller::create_album();
		$createalbum = json_decode($createalbum,true);	
		$album_id = $createalbum['data']['id'];	
		$url =  SERVER_DOMAIN."/album/".$album_id;
		$result = Curl::delApi($url);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = 'delete album success';
		}else{
			$data['data'] = 'delete album failed';
		}
		return Curl::JSON($data);
	}
	
	function get_file_list(){
		$url =  SERVER_DOMAIN."/album/items/".ALBUM_ID;
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'get file list failed';
		}
		return Curl::JSON($data);
	}
	
	function get_file_info(){
		$url =  SERVER_DOMAIN."/file/".FILE_ID;
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'get file info failed';
		}
		return Curl::JSON($data);
	}
	
	function create_file(){
	
	}
	
	function download_file(){
		$url =  SERVER_DOMAIN."/file/content/".FILE_ID;
		$result = Curl::getContentApi($url);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = 'download file success';
		}else{
			$data['data'] = 'download file failed';
		}
		return Curl::JSON($data);
	}
	
	function del_file(){
		$createfile = new Controller();
		$createfile = Controller::create_file();
		$createfile = json_decode($createfile,true);	
		$file_id = $createfile['data']['id'];	
		$url =  SERVER_DOMAIN."/file/".$file_id;
		$result = Curl::delApi($url);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = 'delete file success';
		}else{
			$data['data'] = 'delete file failed';
		}
		return Curl::JSON($data);
	}
	
	function copy_file(){
	
	}
}




?> 