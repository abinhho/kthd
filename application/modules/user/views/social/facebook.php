<?php
require_once (dirname(__FILE__)."/src/facebook.php");
$facebook = new Facebook(array(
'appId' => APP_FACEBOOK_ID,
'secret' => APP_FACEBOOK_SECRET,
'fileUpload' => false // optional
));

// Get User ID

$facebook->setAccessToken($initMe["accessToken"]);
$user = @$facebook->getUser(); 


if ($user && $TB_user->get("ID")=="") {


	//$TB_session->set(array("url_fb_logout" => @$facebook->getLogoutUrl() ));

	
	$user_profile = @$facebook->api('/me');
	//echo 'Xin chào '.@$user_profile['email'];
	$email = @$user_profile['email'];
	
	
	//print_r ($user_profile);
	$pass=$DB->get_data_row("user","password",array("email" =>$email )); 
	$ID=$DB->get_data_row("user","ID",array("email" =>$email ));
	if($ID=="")
	{
		$TB_upload = new TB_upload();
	
		$sex=$user_profile['gender'];($sex=="male")?$sex="Nữ":$sex="Nam";
		$ngay_sinh=@split("/",$user_profile['birthday']);
		
		$user_profile['picture']="https://graph.facebook.com/".$user. "/picture?type=large";
		$hinh_anh=$TB_upload->saved_img("images/user/",$user_profile['picture'],120);
		
		$data=array(
		"ho_ten" => $user_profile['name']
		,"gioi_tinh" => $sex
		,"ngay_sinh" => $ngay_sinh[2]."-".$ngay_sinh[1]."-".$ngay_sinh[0]
		,"email" => $user_profile['email']
		,"thoi_gian" =>$TB_date_time->get()
		,"hinh_anh" =>$hinh_anh
		);
		
		//print_r ($data);
		$uid=$DB->insert_array("user",$data);
		$data['ID']=$uid;
		
		$TB_user->set($data);
		header("Location:".HOME_PATH."/user");
	}
	else
	{
		$row=$DB->fetch_row("SELECT * FROM user WHERE email= '{$email}'");
		$row=$row[0];
		$data=array(
			"ho_ten" => $row['ho_ten']
			,"email" => $row['email']
			,"ID" => $row['ID']
			,"level" => $row['level']
		);
		$TB_user->set($data);
		//print_r ($data);
	}
	
	

} else {
	
	$login_facebook_url = @$facebook->getLoginUrl( array('scope' => 'email,read_stream,user_birthday' ));
	$TB_session->set(array("url_fb_login" => $login_facebook_url));
}

?>
