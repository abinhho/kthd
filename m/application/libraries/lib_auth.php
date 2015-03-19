<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lib_auth {
	var $CI;
	var $permission_checked = array();
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
	}
	public function check_permission($topic_user_id = "")
	{
	   
	   $session_uid = $this->CI->session->userdata('ID');
		if($session_uid !=""){
		    
            $key = $session_uid.$topic_user_id; 
            
            if(isset($this->permission_checked[$key]))
            {
                return $this->permission_checked[$key];     
            }
            
            
			$topic_userdata = $this->topic_userdata($topic_user_id,'level,email');
			if(!count($topic_userdata)){
			     $this->permission_checked[$key] = true; return true;
			}
            
			if($this->CI->session->userdata("level")==2)
			{
				$this->permission_checked[$key] = true; return true;
			}
			else if($this->CI->session->userdata('level')==1)
			{
					
					if($session_uid == $topic_user_id || $topic_userdata['level'] == 0)
					{
					   $this->permission_checked[$key] = true; return true;
					}
					$this->permission_checked[$key] = false; return false;
			}
			else if($this->CI->session->userdata('level') == 0)
			{
				if($this->CI->session->userdata('email') == $topic_userdata['email'])
                {
                    $this->permission_checked[$key] = true; return true;
                }
				
				$this->permission_checked[$key] = false; return false;
				
			}
		}
		else return false;
	}
	public function topic_userdata($uid,$select = "ID,email,full_name,level,images"){
		$this->CI->db->select($select);
		$this->CI->db->where(array("ID"=>$uid));
		return $this->CI->db->get("mod_user")->row_array('mod_user');
	}
	function get_user_id_topic($db_table, $id)
	{
		$this->CI->db->select('user_id');
		$this->CI->db->where(array("ID"=>$id));
		$r = $this->CI->db->get($db_table)->row_array();
		return $r['user_id'];
	}
	public function is_logged_in_admin(){
			if($this->CI->session->userdata("level") == 2 ) 
				return true;
				return false;
	}
	
    public function is_logged(){ 
            if($this->CI->session->userdata("email") == "") 
                return false;
                return true;
    }
	
	public function logout()
	{
		foreach( $this->CI->session->all_userdata() as $key=>$value)
		{	
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity')
            $this->CI->session->unset_userdata($key);
		}
        //$this->CI->load->library('facebook');
        //$facebook = new Facebook(); $facebook->destroySession();

	}
	public function level_name($level)
	{
		$arr=array("User","Moderrate","Administrator");
		$level = ($level == "") ? $level = 0 : $level;
		return $arr[$level];
	}
	function info_by_id($id){ 
		$temp = $this->CI->db->where('ID', $id)->get('mod_user')->result();
		return $temp[0];
	}
    function check_permission_module($alias)
    {
        $permission = preg_split('/,/', $this->CI->session->userdata("permission"));
        $permission = (is_array($permission)) ? $permission : array();
        if(in_array($alias, $permission) || $this->CI->session->userdata("email") == "Administrator") return true; return false;
    }
} 