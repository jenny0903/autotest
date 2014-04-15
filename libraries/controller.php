<?php
include_once('curl.php');

class Controller{
/*--user--*/
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
		return $data;
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
		return $data;
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
		return $data;
	}
/*--album--*/	
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
		return $data;
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
		return $data;
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
		return $data;
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
		return $data;
	}
	
	function del_album(){
		$createalbum = new Controller();
		$createalbum = Controller::create_album();
		// $createalbum = json_decode($createalbum,true);	
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
		return $data;
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
		return $data;
	}
	
/*--member--*/	
	function get_member_list(){
		//curl -kis "http://10.32.1.5:8081/1.0/member/49013874-7880-44c2-abba-93608f9b1597" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24"
		$url = SERVER_DOMAIN."/member/".ALBUM_ID;
		
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'get member list failed';
		}
		return $data;
	}
	
	function join_album(){
		$url1 =  SERVER_DOMAIN."/album";
		$post_data1 = array(
			"name" => Curl::guid(),
		);
		$result1 = Curl::postApi($url1,$post_data1);
		$code1 = $result1['info_code'];
		
		if($code1 == 200){
			$album_invite_code = $result1['result']['invite_code'];
			// curl -kis "http://10.32.1.5:8081/1.0/join/VDFyHGaoX" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24" -X PUT -d '{"user_id":"9630a858-6695-4eb9-9bed-eb4d75324d3d"}'
			$url2 =  SERVER_DOMAIN."/join/".$album_invite_code;
			$put_data2 = array(
				"user_id" => USER_ID2
			);
			$result2 = Curl::putApi($url2,$put_data2,'',2);
			$code2 = $result2['info_code'];
			$data['code'] = $code2;
			if($code2 == 200){
				$data['data'] = $result2['result'];
			}else{
				$data['data'] = 'join album failed';
			}
		}else{
			$data['code'] = $code ;
			$data['data'] = 'create album failed';
		}
		return $data;
	}
	
	function leave_album(){
		$url1 =  SERVER_DOMAIN."/album";
		$post_data1 = array(
			"name" => Curl::guid(),
		);
		$result1 = Curl::postApi($url1,$post_data1);
		$code1 = $result1['info_code'];
		
		if($code1 == 200){
			$album_invite_code = $result1['result']['invite_code'];
			$album_id = $result1['result']['id'];
			// curl -kis "http://10.32.1.5:8081/1.0/join/VDFyHGaoX" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24" -X PUT -d '{"user_id":"9630a858-6695-4eb9-9bed-eb4d75324d3d"}'
			$url2 =  SERVER_DOMAIN."/join/".$album_invite_code;
			$put_data2 = array(
				"user_id" => USER_ID2
			);
			$result2 = Curl::putApi($url2,$put_data2,'',2);
			$code2 = $result2['info_code'];
			if($code2 == 200){
				// curl -kis "http://10.32.1.5:8081/1.0/member/49013874-7880-44c2-abba-93608f9b1597?uid=9630a858-6695-4eb9-9bed-eb4d75324d3d" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24" -X DELETE
				$url3 =  SERVER_DOMAIN."/member/".$album_id.'?uid='.USER_ID2;
				$result3 = Curl::delApi($url3,2);
				$code3 = $result3['info_code'];
				$data['code'] = $code3;
				if($code3==200){
					$data['data'] = 'leave album success';
				}else{
					$data['data'] = 'leave album failed';
				}
			}else{
				$data['code'] = $code2;
				$data['data'] = 'join album failed';
			}
		}else{
			$data['code'] = $code;
			$data['data'] = 'create album failed';
		}
		return $data;
	}
	
	function set_member_role(){
		$url1 =  SERVER_DOMAIN."/album";
		$post_data1 = array(
			"name" => Curl::guid(),
		);
		$result1 = Curl::postApi($url1,$post_data1);
		$code1 = $result1['info_code'];
		
		if($code1 == 200){
			$album_invite_code = $result1['result']['invite_code'];
			$album_id = $result1['result']['id'];
			// curl -kis "http://10.32.1.5:8081/1.0/join/VDFyHGaoX" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24" -X PUT -d '{"user_id":"9630a858-6695-4eb9-9bed-eb4d75324d3d"}'
			$url2 =  SERVER_DOMAIN."/join/".$album_invite_code;
			$put_data2 = array(
				"user_id" => USER_ID2
			);
			$result2 = Curl::putApi($url2,$put_data2,'',2);
			$code2 = $result2['info_code'];
			if($code2 == 200){
				// curl -kis "http://10.32.1.5:8081/1.0/member" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24" -X PUT -d '{"user_id":"eaa01355-e2cb-497f-8c5d-da43d76bb80f","album_id":"907fa5c5-2931-4d3c-8b09-cfbe6ed7c7e1","role":"owner"}'
				
				$url3 =  SERVER_DOMAIN."/member";
				$put_data3 = array(
					"user_id" => USER_ID2,
					"album_id" => $album_id,
					"role" => "owner"
				);
				$result3 = Curl::putApi($url3,$put_data3,'',1);
				$code3 = $result3['info_code'];
				$data['code'] = $code3;
				if($code3==200){
					$data['data'] = 'set member role success';
				}else{
					$data['data'] = 'set member role failed';
				}
			}else{
				$data['code'] = $code2;
				$data['data'] = 'join album failed';
			}
		}else{
			$data['code'] = $code;
			$data['data'] = 'create album failed';
		}
		return $data;
	}
	
	function get_member_role(){
		// curl -kis "http://10.32.1.5:8081/1.0/member/49013874-7880-44c2-abba-93608f9b1597?uid=9630a858-6695-4eb9-9bed-eb4d75324d3d" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24"
		$url = SERVER_DOMAIN."/member/".ALBUM_ID."?uid=".USER_ID;
		
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'get member role failed';
		}
		return $data;
	}
	
	function get_album_activities(){
		// $url = $this->Curl_model->getUrl()."/album/activity/".$albumid."?uid=".$userid;
		// $api_data = $this->Curl_model->getApi($url);
		
		$url = SERVER_DOMAIN."/album/activity/".ALBUM_ID."?uid=".USER_ID;
		
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'get album activities failed';
		}
		return $data;
	}
/*--file--*/	
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
		return $data;
	}
	
	function upload_file(){
		// $op = fopen("../test.jpg",'a');
		// $value = "1234567890";// 写入的信息
		// fwrite($op,$value);
		// fclose($op);		
		$url = SERVER_DOMAIN."/file";	
		$name_unique = Curl::guid();
		$put_data_upload = file_get_contents("../test.jpg");
		$digest = md5($put_data_upload);
		$size  = filesize("../test.jpg");
		$batch_id = Curl::guid();
		$post_data_create = array(
				"album" => ALBUM_ID,
				"title" => "test.jpg",
				"name" => $name_unique ,//保证name的唯一性
				"size" => $size,
				"digest" => $digest,
				"mime_type" => "image/jpg",
				"batch_id" => $batch_id,
				"seq_num" => 1

			);
		$create_result = Curl::postApi($url,$post_data_create);
		$code_create = $create_result['info_code'];
		$result_create = $create_result['result'];
		if($code_create == 200){
			$status = $result_create['status'];
			if($status == 'active'){
				$data['code'] = 200 ;
				$data['data'] = 'file has been uploaded';
			}elseif($status == 'uploading'){
				$fileid = $result_create['id'];
				$url = SERVER_DOMAIN."/file/content/".$fileid;
				$upload_result = Curl::putApi($url,file_get_contents("../test.jpg"),$size);
				$code_upload = $upload_result['info_code'];
				$result_upload = $upload_result['result'];
				$data['code'] = $code_upload ;
				if($code_upload == 200){
					$data['data'] = $result_upload;
					$op = fopen("../test.jpg",'a');
					$value = "1234567890";// 写入的信息
					fwrite($op,$value);
					fclose($op);
				}else{
					$data['data'] = 'upload file failed';
				}
			}
			
		}
		return $data;
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
		return $data;
	}
	
	function del_file(){
		$uploadfile = new Controller();
		$uploadfile = Controller::upload_file();
		// $uploadfile = json_decode($uploadfile,true);	
		$file_id = $uploadfile['data']['id'];	
		$url =  SERVER_DOMAIN."/file/".$file_id;
		$result = Curl::delApi($url);
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = 'delete file success';
		}else{
			$data['data'] = 'delete file failed';
		}
		return $data;
	}
	
	function copy_file(){
		$url = SERVER_DOMAIN."/file/copy";
		$post_data = array(
			"source" => FILE_ID,
			"name" => "test.jpg",
			"target_album" => ALBUM_ID
		);
		$result = Curl::postApi($url,$post_data); 
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = 'copy file success';
		}else{
			$data['data'] = 'copy file failed';
		}
		return $data;
	}
	
/*--comment--*/
	function list_comment(){
		// $url = $this->Curl_model->getUrl()."/file/comment/".$fileid."?pos=".$pos."&limit=".$limit;
		// $api_data = $this->Curl_model->getApi($url);
		
		$url = SERVER_DOMAIN."/file/comment/".FILE_ID;
		
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'list comment failed';
		}
		return $data;
	}
	
	function count_comment(){
		// $url = $this->Curl_model->getUrl()."/file/comment/count/".$fileid;
		// $api_data = $this->Curl_model->getApi($url);  
		
		$url = SERVER_DOMAIN."/file/comment/count/".FILE_ID;
		
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'count comment failed';
		}
		return $data;
	}
	
	function post_comment(){
		// if($reply){
			// $post_data = array(
				// "msg" => $msg,
				// "reply_to_user" => $reply
			// );
		// }else{
			// $post_data = array(
				// "msg" => $msg
			// );
		// }
		// $url = $this->Curl_model->getUrl()."/file/comment/".$fileid;
		// $api_data = $this->Curl_model->postApi($url,$post_data); 
		
		$url = SERVER_DOMAIN."/file/comment/".FILE_ID;
		$post_data = array(
			"msg" => 'beautiful'
		);
		$result = Curl::postApi($url,$post_data,'',2);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'post comment failed';
		}
		return $data;
	}
	
	function reply_comment(){
		// if($reply){
			// $post_data = array(
				// "msg" => $msg,
				// "reply_to_user" => $reply
			// );
		// }else{
			// $post_data = array(
				// "msg" => $msg
			// );
		// }
		// $url = $this->Curl_model->getUrl()."/file/comment/".$fileid;
		// $api_data = $this->Curl_model->postApi($url,$post_data);
		
		$url = SERVER_DOMAIN."/file/comment/".FILE_ID;
		$post_data = array(
			"msg" => 'reply beautiful',
			"reply_to_user" => USER_ID2
		);
		$result = Curl::postApi($url,$post_data);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'reply comment failed';
		}
		return $data;
	}
	
	function del_comment(){
		$url1 = SERVER_DOMAIN."/file/comment/".FILE_ID;
		$post_data1 = array(
			"msg" => 'beautiful'
		);
		$result1 = Curl::postApi($url1,$post_data1);
		$code1 = $result1['info_code'];
		if($code1 == 200){
			$comment_id = $result1['result']['id'];
					
			// $url = $this->Curl_model->getUrl()."/file/comment/".$commentid;
			// $api_data = $this->Curl_model->deleteApi($url);  
			
			$url2 =  SERVER_DOMAIN."/file/comment/".$comment_id;
			$result2 = Curl::delApi($url2);
			$code2 = $result2['info_code'];
			$data['code'] = $code2;
			if($code2==200){
				$data['data'] = 'delete comment success';
			}else{
				$data['data'] = 'delete comment failed';
			}
		}else{
			$data['code'] = $code1;
			$data['data'] = 'post comment failed';
		}
		return $data;
	}
	
/*--like--*/	
	function list_like(){
		// GET /file/like/{file_id}?pos={x}&limit={n}
		// curl -kis "http://10.32.1.5:8081/1.0/file/like/33592fef-8db1-4d9d-a5db-47cf8a481039" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24"
		
		$url = SERVER_DOMAIN."/file/like/".FILE_ID;
		
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'list like failed';
		}
		return $data;
	}
	
	function count_like(){
		// GET /file/like/count/{file_id}

		// curl -kis "http://10.32.1.5:8081/1.0/file/like/count/33592fef-8db1-4d9d-a5db-47cf8a481039" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24"
		
		$url = SERVER_DOMAIN."/file/like/count/".FILE_ID;
		
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'count like failed';
		}
		return $data;
	}
	
	function post_like(){
		// POST /user

		// curl -kis "http://10.32.1.5:8081/1.0/user" -X POST -d '{"name":"jane","email":"jane@test.com","password":"123456"}'
		
		$url1 = SERVER_DOMAIN."/user";
		$temp_code = Curl::guid();
		$name = 'test'.$temp_code;
		$email = $name . '@test.com';
		$post_data1 = array(
			"name" => $name,
			"email" => $email,
			"password" => '000000'
		);
		$result1 = Curl::loginApi($url1,$post_data1);
		$code1 = $result1['info_code'];
		if($code1 == 200){
			// POST /user/oauth2/access_token

			// curl -kis "http://10.32.1.5:8081/1.0/user/oauth2/access_token" -X POST -d '{"email":"jane@test.com","password":"123456","device":"web"}'

			$url2 = SERVER_DOMAIN."/user/oauth2/access_token";
			$post_data2 = array(
				"email" => $email,
				"password" => '000000',
				"device" => 'web'
			);
			$result2 = Curl::loginApi($url2,$post_data2);
			$code2 = $result2['info_code'];
			
			if($code2 == 200){
				$token = $result2['result']['access_token'];
				$cookie = "Authorization: Bearer ".$token;
				
				
				// GET /user/me
			
				// curl -kis "http://10.32.1.5:8081/1.0/user/me" -H "Authorization: Bearer 04e45caf-e861-40da-ad78-b4e7f14687d9"
				
				// {"id":"d380399e-adac-4ccb-af3f-a5dff12f95d4","name":"1655?珑?,"email_verified":false,"mobile_verified":false,"create_time":"2014-02-21T07:19:20.073Z","mod_time":"2014-02-21T07:19:20.073Z","quota":{"max_num_albums":20}}
				
				$url3 = SERVER_DOMAIN."/user/me";
				
				$curl3 = curl_init();
				curl_setopt($curl3, CURLOPT_URL, $url3); // 要访问的地址                
				curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
				curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在    		
				curl_setopt($curl3, CURLOPT_HEADER, 0); // 显示返回的Header区域内容 
				curl_setopt($curl3, CURLOPT_TIMEOUT, 30);// 设置超时限制防止死循环
				curl_setopt($curl3, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
				curl_setopt($curl3, CURLOPT_HTTPHEADER, Array($cookie));//$this->getCookie
				$api_result3 = curl_exec($curl3);
				$info3 = curl_getinfo($curl3);
				curl_close($curl3);
				$result_array3 = json_decode($api_result3,true);
				$code3 = $info3["http_code"];
				
				if($code3 == 200){
				
					$uid = $result_array3['id'];
					
					// curl -kis "http://10.32.1.5:8081/1.0/join/VDFyHGaoX" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24" -X PUT -d '{"user_id":"9630a858-6695-4eb9-9bed-eb4d75324d3d"}'
					
					$put_data4 = Array(
						"user_id" => $uid
					);
					
					$url4 = SERVER_DOMAIN."/join/".ALBUM_INVITE_CODE;
					
					$curl4 = curl_init();
					curl_setopt($curl4, CURLOPT_URL, $url4);                 
					curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
					curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在   
					curl_setopt($curl4, CURLOPT_CUSTOMREQUEST, "PUT"); // 发送一个常规的Put请求
					$aHeader[] = $cookie;
					curl_setopt($curl4, CURLOPT_HTTPHEADER, $aHeader);
					$put_data4 = json_encode($put_data4); 
					curl_setopt($curl4, CURLOPT_POSTFIELDS, $put_data4); 	// Put提交的数据包	
					curl_setopt($curl4, CURLOPT_HEADER, 0); 
					curl_setopt($curl4, CURLOPT_TIMEOUT, 30);
					curl_setopt($curl4, CURLOPT_RETURNTRANSFER, 1);
					$api_result4 = curl_exec($curl4);
					$info4 = curl_getinfo($curl4);
					curl_close($curl4);
					$result_array4 = json_decode($api_result4,true);
					$code4 = $info4["http_code"];

					if($code4 == 200){
						// POST /file/like/{file_id}

						// curl -kis "http://10.32.1.5:8081/1.0/file/like/33592fef-8db1-4d9d-a5db-47cf8a481039" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24" -X POST
						
						$url5 = SERVER_DOMAIN."/file/like/".FILE_ID;
						
							
						$curl5 = curl_init();
						curl_setopt($curl5, CURLOPT_URL, $url5);                  
						curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, FALSE);   
						curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, FALSE);       
						curl_setopt($curl5, CURLOPT_POST, 1); 
						$aHeader[] = $cookie;
						curl_setopt($curl5, CURLOPT_HTTPHEADER, $aHeader);
						$post_data5 = ''; 
						curl_setopt($curl5, CURLOPT_POSTFIELDS, $post_data5);
						curl_setopt($curl5, CURLOPT_TIMEOUT, 30);     
						curl_setopt($curl5, CURLOPT_HEADER, 0);     
						curl_setopt($curl5, CURLOPT_RETURNTRANSFER, 1);    
						$api_result5 = curl_exec($curl5);
						$info5 = curl_getinfo($curl5);
						curl_close($curl5);
						$result_array5 = json_decode($api_result5,true);
						$code5 = $info5["http_code"];
						$data['code'] = $code5;
						if($code5==200){
							$data['data'] = 'like a file success';
						}else{
							$data['data'] = 'like a file failed';
						}
					}else{
						$data['code'] = $code4;
						$data['data'] = 'join album failed';
					}	
				}else{
					$data['code'] = $code3;
					$data['data'] = 'get uid failed';
				}
			}else{
				$data['code'] = $code2;
				$data['data'] = 'login failed';
			}
		}else{
			$data['code'] = $code1;
			$data['data'] = 'register a new user failed';
		}
		return $data;
	}
	
	function del_like(){
		// POST /user

		// curl -kis "http://10.32.1.5:8081/1.0/user" -X POST -d '{"name":"jane","email":"jane@test.com","password":"123456"}'
		
		$url1 = SERVER_DOMAIN."/user";
		$temp_code = Curl::guid();
		$name = 'test'.$temp_code;
		$email = $name . '@test.com';
		$post_data1 = array(
			"name" => $name,
			"email" => $email,
			"password" => '000000'
		);
		$result1 = Curl::loginApi($url1,$post_data1);
		$code1 = $result1['info_code'];
		if($code1 == 200){
			// POST /user/oauth2/access_token

			// curl -kis "http://10.32.1.5:8081/1.0/user/oauth2/access_token" -X POST -d '{"email":"jane@test.com","password":"123456","device":"web"}'

			$url2 = SERVER_DOMAIN."/user/oauth2/access_token";
			$post_data2 = array(
				"email" => $email,
				"password" => '000000',
				"device" => 'web'
			);
			$result2 = Curl::loginApi($url2,$post_data2);
			$code2 = $result2['info_code'];
			
			if($code2 == 200){
				$token = $result2['result']['access_token'];
				$cookie = "Authorization: Bearer ".$token;
				
				
				// GET /user/me
			
				// curl -kis "http://10.32.1.5:8081/1.0/user/me" -H "Authorization: Bearer 04e45caf-e861-40da-ad78-b4e7f14687d9"
				
				// {"id":"d380399e-adac-4ccb-af3f-a5dff12f95d4","name":"1655?珑?,"email_verified":false,"mobile_verified":false,"create_time":"2014-02-21T07:19:20.073Z","mod_time":"2014-02-21T07:19:20.073Z","quota":{"max_num_albums":20}}
				
				$url3 = SERVER_DOMAIN."/user/me";
				
				$curl3 = curl_init();
				curl_setopt($curl3, CURLOPT_URL, $url3); // 要访问的地址                
				curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
				curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在    		
				curl_setopt($curl3, CURLOPT_HEADER, 0); // 显示返回的Header区域内容 
				curl_setopt($curl3, CURLOPT_TIMEOUT, 30);// 设置超时限制防止死循环
				curl_setopt($curl3, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
				curl_setopt($curl3, CURLOPT_HTTPHEADER, Array($cookie));//$this->getCookie
				$api_result3 = curl_exec($curl3);
				$info3 = curl_getinfo($curl3);
				curl_close($curl3);
				$result_array3 = json_decode($api_result3,true);
				$code3 = $info3["http_code"];
				
				if($code3 == 200){
				
					$uid = $result_array3['id'];
					
					// curl -kis "http://10.32.1.5:8081/1.0/join/VDFyHGaoX" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24" -X PUT -d '{"user_id":"9630a858-6695-4eb9-9bed-eb4d75324d3d"}'
					
					$put_data4 = Array(
						"user_id" => $uid
					);
					
					$url4 = SERVER_DOMAIN."/join/".ALBUM_INVITE_CODE;
					
					$curl4 = curl_init();
					curl_setopt($curl4, CURLOPT_URL, $url4);                 
					curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
					curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在   
					curl_setopt($curl4, CURLOPT_CUSTOMREQUEST, "PUT"); // 发送一个常规的Put请求
					$aHeader[] = $cookie;
					curl_setopt($curl4, CURLOPT_HTTPHEADER, $aHeader);
					$put_data4 = json_encode($put_data4); 
					curl_setopt($curl4, CURLOPT_POSTFIELDS, $put_data4); 	// Put提交的数据包	
					curl_setopt($curl4, CURLOPT_HEADER, 0); 
					curl_setopt($curl4, CURLOPT_TIMEOUT, 30);
					curl_setopt($curl4, CURLOPT_RETURNTRANSFER, 1);
					$api_result4 = curl_exec($curl4);
					$info4 = curl_getinfo($curl4);
					curl_close($curl4);
					$result_array4 = json_decode($api_result4,true);
					$code4 = $info4["http_code"];

					if($code4 == 200){
						// POST /file/like/{file_id}

						// curl -kis "http://10.32.1.5:8081/1.0/file/like/33592fef-8db1-4d9d-a5db-47cf8a481039" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24" -X POST
						
						$url5 = SERVER_DOMAIN."/file/like/".FILE_ID;
						
							
						$curl5 = curl_init();
						curl_setopt($curl5, CURLOPT_URL, $url5);                  
						curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, FALSE);   
						curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, FALSE);       
						curl_setopt($curl5, CURLOPT_POST, 1); 
						$aHeader[] = $cookie;
						curl_setopt($curl5, CURLOPT_HTTPHEADER, $aHeader);
						$post_data5 = ''; 
						curl_setopt($curl5, CURLOPT_POSTFIELDS, $post_data5);
						curl_setopt($curl5, CURLOPT_TIMEOUT, 30);     
						curl_setopt($curl5, CURLOPT_HEADER, 0);     
						curl_setopt($curl5, CURLOPT_RETURNTRANSFER, 1);    
						$api_result5 = curl_exec($curl5);
						$info5 = curl_getinfo($curl5);
						curl_close($curl5);
						$result_array5 = json_decode($api_result5,true);
						$code5 = $info5["http_code"];
						if($code5==200){
							// DELETE /file/like/{file_id}

							// curl -kis "http://10.32.1.5:8081/1.0/file/like/33592fef-8db1-4d9d-a5db-47cf8a481039" -H "Authorization: Bearer 49624099-21c7-4a1c-a7df-63b664566e24" -X DELETE
							
							$url6 = SERVER_DOMAIN."/file/like/".FILE_ID;
							
							$curl6 = curl_init();
							curl_setopt($curl6, CURLOPT_URL, $url6);                 
							curl_setopt($curl6, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查     
							curl_setopt($curl6, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在  
							curl_setopt($curl6, CURLOPT_CUSTOMREQUEST, "DELETE");  // 发送一个常规的Delete请求 
							curl_setopt($curl6, CURLOPT_HTTPHEADER, Array($cookie));	
							curl_setopt($curl6, CURLOPT_HEADER, 0); 
							curl_setopt($curl6, CURLOPT_TIMEOUT, 30);
							curl_setopt($curl6, CURLOPT_RETURNTRANSFER, 1);
							$api_result6 = curl_exec($curl6);
							$info6 = curl_getinfo($curl6);
							curl_close($curl6);
							$result_array6 = json_decode($api_result6,true);
							$code6 = $info6["http_code"];
							$data['code'] = $code6;
							if($code6 ==200){
								$data['data'] = 'dislike a file success';
							}else{
								$data['data'] = 'dislike a file failed';
							}
						}else{
							$data['code'] = $code5;
							$data['data'] = 'like a file failed';
						}
					}else{
						$data['code'] = $code4;
						$data['data'] = 'join album failed';
					}	
				}else{
					$data['code'] = $code3;
					$data['data'] = 'get uid failed';
				}
			}else{
				$data['code'] = $code2;
				$data['data'] = 'login failed';
			}
		}else{
			$data['code'] = $code1;
			$data['data'] = 'register a new user failed';
		}
		return $data;
	}
	
	function like_flag(){
		// GET /file/like/{file_id}?user_id={user_id}

		// curl -kis "http://10.32.1.5:8081/1.0/file/like/a1e318d5-a878-4c35-86cf-b7b19f65ec64" -H "Authorization: Bearer dc387898-5d74-40cb-8eb4-896d92ece532"
		
		$url = SERVER_DOMAIN."/file/like/".FILE_ID.'?uid='.USER_ID;
		
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		if($code == 200 || $code ==204){
			$data['code'] = 200;
			$data['data'] = 'get like flag success';
		}else{
			$data['code'] = $code;
			$data['data'] = 'get like flag failed';
		}
		return $data;
	}
	
/*--thumbnail--*/	
	function thumbnail(){
		$url = SERVER_DOMAIN."/thumb/".FILE_ID."?dim=318x236";
		$result = Curl::getContentApi($url); 
		$code = $result['info_code'];
		$data['code'] = $code ;
		if($code == 200){
			$data['data'] = 'get thumbnail success';
		}else{
			$data['data'] = 'get thumbnail failed';
		}
		return $data;
	}
	
/*--link--*/	
	function link(){
		// curl -kis "http://10.32.1.5:8081/1.0/link/fVd26Mmu2"
		
		$url = SERVER_DOMAIN."/link/".ALBUM_LINK;
		
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'access by link failed';
		}
		return $data;
	}
	
/*--event--*/	
	function event(){
		// GET /event

		// curl -kis "http://10.32.1.5:8081/1.0/event" -H "Authorization: Bearer f90eccb5-44a1-4e13-8995-68906ccc5647"
		
		$url = SERVER_DOMAIN."/event";
		
		$result = Curl::getApi($url);
		$code = $result['info_code'];
		$data['code'] = $code;
		if($code == 200){
			$data['data'] = $result['result'];
		}else{
			$data['data'] = 'get event list failed';
		}
		return $data;
	}
}

?> 