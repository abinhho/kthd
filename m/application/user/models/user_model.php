<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model{
	var $mod_name =''; 
	private $db_table = "mod_user";
    var $upload_folder = "images/user";
	public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->mod_name = $this->router->fetch_module();
        $this->load->library("lib_upload"); 
        $this->lib_upload->config_upload['upload_path'] = $this->upload_folder;
    }
    public function index(){
    	
    }
    public function check_login($email, $password){
    	$arr_where = array(
    	"email" => $email,
    	"password" => md5($password)
    	);
    	$this->db->select('ID,email,full_name,images,level,address,phone,website,permission,password,bookmarks');
    	$query = $this->db->get_where($this->db_table, $arr_where);
    	if($query->num_rows() > 0){
    		
    		$userdata = $query->row_array();
            $this->update_last_connect($userdata['ID']);
    		$this->session->set_userdata($userdata);
    		return true;
    	}
    	else {
    		return false;
    	}
    }
    
    public function show_item(){
    	
        $limit = ($this->lib_url->_GET('page') == "" ) ? 1 : $this->lib_url->_GET('page');
        
        $limit = $this->config->item('pagination_length') * ($limit - 1) . ',' . $this->config->item('pagination_length');
        
        
    	$query = $this->db->query('
        SELECT * 
            FROM '.$this->db_table.' u 
        '.$this->get_sort().' LIMIT '.$limit);
     
        $r['items'] = $query -> result_array();
    	
    	//echo $this->db->last_query();
    	
    	
		/*$this->lib_db->create_query_search();*/
        
        $query = $this->db->query('
        SELECT ID 
            FROM '.$this->db_table.' u 
        ');
        
        
    	$r['nRow'] = $conf['nRow'] =  $query -> num_rows();
    	
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
    	return $r;
    }
    
    function get_sort($sort_name = 'usersort')
    {
        $sort = $this->lib_url->_GET($sort_name);
        if($sort == '' || $sort == 'newest') return 'ORDER BY u.ID DESC';
        if($sort == 'oldest') return 'ORDER BY u.ID ASC';
        if($sort == 'score') return 'ORDER BY u.score DESC';
        if($sort == 'answer') return 'ORDER BY u.n_answers DESC';
        if($sort == 'question') return 'ORDER BY u.n_questions DESC';
        
        
    }
    
    public function do_register(&$data){
        
        
        if(!$this->lib_db->check_unique($this->db_table, array("email" => $this->input->post("email") ) , $this->input->post('old_email')  ))
        {
            $data["error_messenger"] = "<div class='error_messenger'>- Lỗi. Email đã tồn tại</div>";
            return false;
        }
        
        $db_data = array
        (
            "email" => $this->input->post('email')
            ,"full_name" => $this->input->post('full_name')
            ,"password" => md5($this->input->post('password'))
            
            ,"address" => $this->input->post('address')
            ,"phone" => $this->input->post('phone')
            ,"date_add" => $this->lib_date->get()
            ,"last_connect" => $this->lib_date->get()
            
        );
        
        $this->db->insert($this->db_table , $db_data);
		
		$this->check_login($this->input->post('email') , $this->input->post('password'));
        $this->lib_url->redirect_flashdata();
    }
    
    function update_login_social($data)
    { 
        if(count($data) == 0) return;
        
        $this->db->select("ID");
        $n = $this->db->get_where($this->db_table, array('email' => $data['email'] )) -> num_rows();
        if($n == 0)
        {
            if(!empty($data['images'])){ 
                $images = $this->lib_upload->saved_img($this->upload_folder, $data['images'], 128, 128, true);
                if(!empty($images))
                $data['images'] = $images;
            }
            $data['date_add'] = $this->lib_date->get();
            $this->db->insert($this->db_table, $data);
            
        }
        
        
        $this->db->select('ID,email,full_name,images,level,address,phone,website,permission,password,bookmarks');
    	$query = $this->db->get_where($this->db_table, array('email' => $data['email'] ));
        
        $userdata = $query->row_array();
        
        $this->update_last_connect($userdata['ID']);
        
   		$this->session->set_userdata($userdata);   
        $this->lib_url->redirect_flashdata();
    }
    function update_last_connect($id)
    {
        $this->db->where('ID', $id);
        $this->db->update($this->db_table, array("last_connect" => $this->lib_date->get() ));
    }
    
    public function data_edit($id){
        $this->db->where(array("ID" =>$id ));
        $data = $this->db->get($this->db_table)->row_array();
        
        if(count($data) <= 0) redirect('page-not-found.html');
        
        $data['question'] = $this->get_question($data['ID']);
        $data['answer'] = $this->get_answer($data['ID']);
        $data['bookmark'] = $this->get_bookmark($data['bookmarks']);
        
        $data['notes'] = $this->get_notes($data['ID']);
        return $data;
    }
    
    function get_notes($uid)
    {
        //$user_id = $this->session->userdata('ID');
        
        $limit = ($this->lib_url->_GET('page') == "" ) ? 1 : $this->lib_url->_GET('page');
        
        $limit = $this->config->item('pagination_length') * ($limit - 1) . ',' . $limit * $this->config->item('pagination_length');
        
        $sql = "SELECT p.user_id_from,p.tieu_de,p.link,p.action_name,p.viewed,p.date_upd,p.ID as p_ID,u.ID,u.full_name
            FROM mod_user_notes p, mod_user u
            WHERE p.user_id_to = ".$uid."  AND p.user_id_from = u.ID";
        
    	$query = $this->db->query($sql.' LIMIT '. $limit);
     	$r['items'] = $query -> result_array();
        
        $this->db->select('ID');
    	$r['nRow'] = $conf['nRow'] =  $this->db->where('user_id_to', $uid)->get('mod_user_notes') -> num_rows();
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
        return $r;
    }
    
    function get_question($uid)
    {
        $limit = ($this->lib_url->_GET('page') == "" ) ? 1 : $this->lib_url->_GET('page');
        
        $limit = $this->config->item('pagination_length') * ($limit - 1) . ',' . $limit * $this->config->item('pagination_length');
        
    	$query = $this->db->query('
        SELECT p.n_votes,p.tieu_de,p.ID,p.catid,p.date_upd,p.n_answers,p.exactly
            FROM mod_questions p
            WHERE p.user_id = \''.$uid.'\'
            
        LIMIT '.$limit);
     	
        //return $query -> result_array();
        
        $r['items'] = $query -> result_array();
    	
    	//echo $this->db->last_query();
        $this->db->select('ID');
    	$r['nRow'] = $conf['nRow'] =  $this->db->where('user_id', $uid)->get('mod_questions') -> num_rows();
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
    	return $r;
    }
    function get_answer($uid)
    {
        $limit = ($this->lib_url->_GET('page') == "" ) ? 1 : $this->lib_url->_GET('page');
        
        $limit = $this->config->item('pagination_length') * ($limit - 1) . ',' . $limit * $this->config->item('pagination_length');
        
    	$query = $this->db->query('
        SELECT p.n_votes,p.tieu_de,p.ID,p.catid,p.date_upd,a.user_id as a_uid,p.n_answers,p.exactly
            FROM mod_questions p, mod_questions_answer a
            WHERE a.user_id = \''.$uid.'\' AND p.ID = a.FID
            
        LIMIT '.$limit);
     	
        //return $query -> result_array();
        
        $r['items'] = $query -> result_array();
    	
    	//echo $this->db->last_query();
        $this->db->select('ID');
    	$r['nRow'] = $conf['nRow'] =  $this->db->where('user_id', $uid)->get('mod_questions_answer') -> num_rows();
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
    	return $r;
    }
    function get_bookmark($ids)
    {
        $r = array(
        'nRow' => 0
        ,'items' => array()
        ,'split_page' => $this->lib_pagination->split_page(array('nRow'=>0))
        );
        if(trim($ids) == '') {
            return $r;
        }
        $limit = ($this->lib_url->_GET('page') == "" ) ? 1 : $this->lib_url->_GET('page');
        
        $limit = $this->config->item('pagination_length') * ($limit - 1) . ',' . $limit * $this->config->item('pagination_length');
        
        $sql = "SELECT p.n_votes,p.tieu_de,p.ID,p.catid,p.date_upd,p.n_answers,p.exactly
            FROM mod_questions p
            WHERE p.ID IN(".$ids.")";
        
    	$query = $this->db->query($sql. "          
        LIMIT ".$limit);
     	
        //return $query -> result_array();
        
        $r['items'] = $query -> result_array();
        
    	
    	//echo $this->db->last_query();
    	$r['nRow'] = $conf['nRow'] =  $this->db->query($sql) -> num_rows();
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
        
    	return $r;
    }
    
    public function do_edit(&$data , $id){
        
        if(!empty($_FILES['userfile']['tmp_name'])){
            
            $img = $this->lib_upload->upload_image($this->upload_folder, 'userfile'  , 128);// echo $img; exit;
            if(strlen($img) > 3){
                
                $image_data = $img;
                @unlink($this->upload_folder .'/'. $this->input->post('old_images'));   
            }
            else {
                $data["error_messenger"] = $this->lib_upload->display_errors;
                return false;
            }   
        }
        
        //if(!$this->lib_db->check_unique($this->db_table, array("email" => $this->input->post("email") ) , $this->input->post('old_email')  ))
        //{
        //    $data["error_messenger"] = "Email đã tồn tại";
         //   return false;
        //}
        $db_data = $this->input->post('user');
        
        $old_password = $this->input->post('old_password');
        $password = $this->input->post('password');
        
        if($old_password == $password)
        unset($db_data['password']);
        else $db_data['password'] = md5($password);
        
        unset($db_data['level']);
        $db_data['birthday'] = $this->input->post('year')."-".$this->input->post('month')."-".$this->input->post('date');
       
        if(isset($image_data))
        $db_data['images'] = $image_data;
        
        
        $this->db->where("ID",$id); 
        $this->db->update($this->db_table , $db_data);
        return true;
    }
    function ajax_tooltip_info()
    {
        $uid = $this->input->post('id');
        $this->db->limit(1);
     	return $this->db->get_where('mod_user', array('ID'=>$uid)) -> row_array();
    }
    function ajax_user_notes($user_id)
    {
        $sql = "SELECT p.user_id_from,p.tieu_de,p.link,p.action_name,p.viewed,p.date_upd,p.ID as p_ID,u.ID,u.full_name
            FROM mod_user_notes p, mod_user u
            WHERE p.user_id_to = ".$user_id." AND p.viewed = 0 AND p.user_id_from = u.ID LIMIT 0,50";
        
    	$query = $this->db->query($sql);
        $r = array();
     	return $query -> result_array();
    }
    function ajax_set_viewed_user_notes()
    {
        $ids = $this->input->post('ids');
        if(trim($ids) == '') return;
        
        $this->db->where('ID IN('.$ids.') ');
        $this->db->update('mod_user_notes', array("viewed" => 1) );
    }
    function ajax_del_user_notes()
    {
        $val = $this->input->post('val');
        $val = decode_me($val);
        $val = preg_split('/;/', $val);
        
        $ids = $val[0];
        $uid = $val[1];
        
        if(trim($ids) == 'all')
        {
            $this->db->where('user_id_to', $uid ) ;
            $this->db->delete('mod_user_notes');
            echo json_encode(array('feed'=> 'all'));
            return ;
        }
        
        $this->db->where('ID IN('.$ids.') ');
        $this->db->delete('mod_user_notes');
        echo json_encode(array('feed'=> ''));
    }
    
    function check_forgot_code()
    {
    	$fgc = $this->lib_url->_GET('forgot_code');
    	if($fgc != "")
    	{
    		$n = $this->db->get_where($this->db_table, array('forgot_code'=> $fgc) )-> num_rows();
    		if($n>0) return true; return false;
    	}
    	return false;
    }
    function do_reset_password()
    {
    	$db_data = array(
        'password' => md5($this->input->post('password')) 
    	,"forgot_code" => ""
    	);
    	
        $fgc = $this->lib_url->_GET('forgot_code');
        $this->db->update($this->db_table, $db_data, array('forgot_code' => $fgc));
        $this->lib_url->redirect('user/login','Password has been reset');
    }
    private function check_exist_email($email)
    {
    	$r = $this->db->get_where($this->db_table, array("email" => $email ))->num_rows();
    	if($r>0) return true; return false;
    }
    public function do_forgot(&$data){
    	
    	$this->load->library('lib_string');
    	$forgor_code = $this->lib_string->random_string('60');
    	
        $email_to = $this->input->post('email');
        
        $link = $this->lib_url->host('').base_url('user/resetpss/?forgot_code='.$forgor_code );
        
        $mess = array("to" => $email_to, 'subject' => "Quên mật khẩu - Kienthuchoidap.com", 'message' => 
        "Bạn quên hoặc mất mật khẩu trên http://kienthuchoidap.com?. <br/><br/>
        Click vào link dưới đây hoặc copy link dán vào trình duyệt của bạn để lấy lại mật khẩu: <br/>
        ".$link);
        
        if($this->check_exist_email($email_to)){
        	
            $this->db->update($this->db_table, array('forgot_code' => $forgor_code), array('email'=> $email_to));
	        if(Modules::run('emails/send', $mess))
	        $data['error_messenger'] = "<p class='green_note'>".$this->lang->line('noti_success_send_email')."</p>";	
        }
        else 
        {
        	$data['error_messenger'] = "<p class='red_note'>".$this->lang->line('email_not_exist')."</p>";
        }
        
    }
}