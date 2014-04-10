<?php
define("SERVER_DOMAIN","http://10.32.1.5:8081/1.0");

class Curl{
	var $cookie;
	
	public function init($cookie){
		$this->cookie = $cookie;
	}
	
	public function getCookie(){
		return  $this->cookie;
	}

	public function getContentApi($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址  	
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在  	
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容 
		curl_setopt($curl, CURLOPT_TIMEOUT, 120);// 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
		curl_setopt($curl, CURLOPT_HTTPHEADER, Array($this->getCookie()));//$this->getCookie
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
		$data = array(
		 "info_code" => $info["http_code"],
		 "result" => ""
		);
		return($data);
	}

	public function getApi($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址                
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在    		
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容 
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);// 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
		curl_setopt($curl, CURLOPT_HTTPHEADER, Array($this->getCookie()));//$this->getCookie
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

	public function putApi($url,$put_data = '',$size = ''){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);                 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在   
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT"); // 发送一个常规的Put请求
		$aHeader[] = $this->getCookie(); 
		$aHeader[] = 'Content-Range:bytes 0-'.$size.'/'.$size;
		curl_setopt($curl, CURLOPT_HTTPHEADER, $aHeader);
		$put_data = $put_data ? json_encode($put_data) : ''; 
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
		return($data);
	}

	public function postApi($url,$post_data = '',$is_file = 0,$size = ''){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);                  
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);   
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);       
		curl_setopt($curl, CURLOPT_POST, 1); 
		if($is_file == 1){
			$aHeader[] = 'Content-Range:bytes 0-'.$size.'/'.$size;
		}
		$aHeader[] = $this->getCookie(); 		
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

	public function deleteApi($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);                 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在  
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");  // 发送一个常规的Delete请求 
		curl_setopt($curl, CURLOPT_HTTPHEADER, Array($this->getCookie()));	
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
	
	function JSON($result) {  
		$array=$result;  
		arrayRecursive($array);//先将类型为字符串的数据进行 urlencode  
		$json = json_encode($array);//再将数组转成JSON  
		return urldecode($json);//最后将JSON字符串进行urldecode  
	}
	
}
	


?>