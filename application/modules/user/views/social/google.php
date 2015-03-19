<?php
require_once (dirname(dirname(__FILE__))."/LightOpenID.php");
$openid = new LightOpenID(HOME_PATH);

if ($openid->mode) {
    if ($openid->mode == 'cancel') {
        //echo "User has canceled authentication !";
    }
	elseif($TB_user->get("ID")=="") {
	
        $data = $openid->getAttributes();
        $email = $data['contact/email'];
        $first = $data['namePerson/first'];
        $last = $data['namePerson/last'];
		
		$pass=$DB->get_data_row("user","password",array("email" =>$email )); 
		$ID=$DB->get_data_row("user","ID",array("email" =>$email ));
		if($ID=="")
		{
			$data=array(
			"ho_ten" => $first." ".$last
			,"email" => $email
			,"thoi_gian" =>$TB_date_time->get()
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
        
		//print_r ($data);
    } 
} else {
   // echo "Go to index page to log in.";
}

$openid->identity = 'https://www.google.com/accounts/o8/id';
$openid->required = array(
	'namePerson/first',
	'namePerson/last',
	'contact/email',
	'namePerson/friendly',
    'contact/email',
    'namePerson',
    'birthDate',
    'person/gender',
    'contact/postalCode/home',
    'contact/country/home',
    'pref/language',
    'pref/timezone'
);
$openid->returnUrl = HOME_PATH;

$TB_session->set(array("url_google_login" => $openid->authUrl() ) );

