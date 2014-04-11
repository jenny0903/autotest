<?php
define("SERVER_DOMAIN","http://10.32.1.5:8081/1.0");
define("CLIQ_TOKEN","Authorization: Bearer 0721-fa49e94d-415f-4615-b7a9-f014493bd90a");
define("USER_ID","0721-6e1aa49d-3cd0-497d-9f45-a8106c88230c");
define("ALBUM_ID","0721-f9b4a73a-4ca5-428e-97eb-f68a17f8d3fe");
define("FILE_ID","0721-1e38565d-f702-4497-ac79-a4cf625fc668");
define("COMMENT_ID","0721-fda48a6d-4cf3-41b7-aee3-cce5418fcdbc");

class Curl{
	static $cookie = CLIQ_TOKEN;
	
	public static function setCookie($cookie){
		 self::$cookie = $cookie;
	}
	
	public static function getCookie(){
		return  self::$cookie;
	}

	public static function getContentApi($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址  	
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在  	
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容 
		curl_setopt($curl, CURLOPT_TIMEOUT, 120);// 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
		curl_setopt($curl, CURLOPT_HTTPHEADER, Array(self::getCookie()));//$this->getCookie
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
		$data = array(
		 "info_code" => $info["http_code"],
		 "result" => ""
		);
		return($data);
	}

	public static function getApi($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址                
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在    		
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容 
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);// 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
		curl_setopt($curl, CURLOPT_HTTPHEADER, Array(self::getCookie()));//$this->getCookie
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
		$result_array = json_decode($result,true);
		$data = array(
		 "info_code" => $info["http_code"],
		 "result" => $result_array
		);
		return($data);
	}

	public static function putApi($url,$put_data = '',$size = ''){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);                 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在   
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT"); // 发送一个常规的Put请求
		// $aHeader[] = $this->getCookie(); 
		$aHeader[] = self::getCookie();
// echo  self::$cookie;
// exit;
		if($size != ''){
			$aHeader[] = 'Content-Range:bytes 0-'.$size.'/'.$size;
		}
// var_dump($aHeader);
// exit;
		curl_setopt($curl, CURLOPT_HTTPHEADER, $aHeader);
		$put_data = $put_data ? json_encode($put_data) : ''; 
// var_dump($put_data);
// exit;
		curl_setopt($curl, CURLOPT_POSTFIELDS, $put_data); 	// Put提交的数据包	
		curl_setopt($curl, CURLOPT_HEADER, 0); 
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
		$result_array = json_decode($result,true);
		$data = array(
		 "info_code" => $info["http_code"],
		 "result" => $result_array
		);
// var_dump($data);
// exit;
		return($data);
	}

	public static function postApi($url,$post_data = '',$size = ''){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);                  
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);   
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);       
		curl_setopt($curl, CURLOPT_POST, 1); 
		$aHeader[] = self::getCookie(); 
		if($size != ''){
			$aHeader[] = 'Content-Range:bytes 0-'.$size.'/'.$size;
		}	
		curl_setopt($curl, CURLOPT_HTTPHEADER, $aHeader);
		$post_data = $post_data ? json_encode($post_data) : ''; 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);     
		curl_setopt($curl, CURLOPT_HEADER, 0);     
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);    
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
		$result_array = json_decode($result,true);
		$data = array(
		 "info_code" => $info["http_code"],
		 "result" => $result_array
		);
		return($data);
	}

	public static function delApi($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);                 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在  
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");  // 发送一个常规的Delete请求 
		curl_setopt($curl, CURLOPT_HTTPHEADER, Array(self::getCookie()));	
		curl_setopt($curl, CURLOPT_HEADER, 0); 
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
		$result_array = json_decode($result,true);
		$data = array(
		 "info_code" => $info["http_code"],
		 "result" => $result_array
		);
		return($data);
	}
	
	//json_encode中文乱码问题修正
	public static function arrayRecursive(&$array){  
		foreach ($array as $key => $value) {  
			if (is_array($value)) {  
				self::arrayRecursive($array[$key]);//如果是数组就进行递归操作  
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
	public static function JSON($result) {  
		$array = $result;  
		self::arrayRecursive($array);//先将类型为字符串的数据进行 urlencode  
		$json = json_encode($array);//再将数组转成JSON  
		return urldecode($json);//最后将JSON字符串进行urldecode  
	}
	
	//生成唯一id
	public static function guid(){
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
	
}
	


?>