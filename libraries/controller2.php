<?php
include_once('curl.php');
class Controller2{
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
		return Curl::JSON($data);
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
		return Curl::JSON($data);
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
		return Curl::JSON($data);
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
		return Curl::JSON($data);
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
		return Curl::JSON($data);
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
		return Curl::JSON($data);
	}
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
		return Curl::JSON($data);
	}
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
		return Curl::JSON($data);
	}
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
		return Curl::JSON($data);
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
		return Curl::JSON($data);
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
		return Curl::JSON($data);
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
		return Curl::JSON($data);
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
		return Curl::JSON($data);
	}

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
		return Curl::JSON($data);
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
		return Curl::JSON($data);
	}
	function post_like(){
	}
	function del_like(){
	}
	function like_flag(){
	}
}
?>