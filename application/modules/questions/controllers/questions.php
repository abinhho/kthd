<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questions extends MX_Controller {
	
	var $catid = "";
    var $mod_user = null;
	public function __construct(){
       	parent::__construct();
      	$this->load->Model('Questions_model');
      	$this->load->library('lib_pagination');
        $this->load->library('lib_cache');
      	$this->lang->load('static');
  	    $this->load->library('form_validation');
      	$this->module = $this->router->fetch_module(); 	
       	//$this->lib_media->media_folder = base_url().'images/'.$this->router->fetch_module();
        //$this->mod_user = $this->load->module('user');
    
	}
	public function index($catid, $viewid)
	{
		if(empty($viewid))
		$this->show_item($catid);
		else {
			$this->view_item($viewid);
		}
	}
	public function show_item($catid = ""){ 
	   $this->config->set_item("body_layout", "body");
	   $this->session->set_userdata('flashdata', $this->lib_url->getUrl());
       
       $this->catid = $catid;
       
       if(!is_numeric($catid))
       {
            $catid = $this->lib_menu->catid_by_alias($catid);
            $this->config->set_item("active_menu", "catagory_tags");
       }
       else
       $this->config->set_item("active_menu", "questions");
		
		
		$data = array();
	
        if(trim($catid) != 65)
		$data = $this->lib_menu->meta_by_catid($catid);
        else {
            $data['title'] = 'Câu hỏi mới';
            $data['description'] = SHORT_DESCRIPTION;   
        }
		
		$this->template->write("title",$data['title'], true);
        $this->template->write("description",$data['description'], true);
        $this->template->write("keywords",str_replace(' ',',',$data['title']), true);
                
		$data += $this->Questions_model->show_item($catid); 
        $data['catid'] = $catid;
		//$data['form_filter_seach'] =  modules::load('ext_filter');
		
        //$data['mod_user'] = $this->mod_user;
		
        $this->load->view("show_item",$data);
	}
    function block_hot_questions()
    {
        $data = array();
        $data['items'] = $this->Questions_model->block_hot_questions($this->catid);
        $this->load->view("block_hot_questions",$data);
    }
    public function show_item_by_tag($alias){
	   $this->session->set_userdata('flashdata', $this->lib_url->getUrl());
       
       $data = array();   
       
       $this->config->set_item("active_menu", "catagory_tags");
	   $this->config->set_item("body_layout", "body");
	   
       $tag_info = $this->lib_tags->tag_info_by_alias($alias);// print_r ($tag_info) ; exit;
        
       $data['title'] = $tag_info['tieu_de'].' | '. $tag_info['cata_tieu_de'];
       $data['description'] = $tag_info['noi_dung'];   
       $this->template->write("keywords",str_replace(' ',',',$data['title']), true);
	   
		
		$this->template->write("title",$data['title'], true);
        $this->template->write("description",(trim($tag_info['noi_dung']) == '') ? $data['title'] : $tag_info['noi_dung'], true);
                
        $data['tag_description'] = $data['description'] ;
		$data += $this->Questions_model->show_item_by_tag($tag_info['ID']);
		//$data['form_filter_seach'] =  modules::load('ext_filter');
		//$data['mod_user'] = $this->mod_user;
		$this->load->view("show_item_by_tag",$data);
	}
    
    
    public function unanswers($catid){
        $this->config->set_item("body_layout", "body"); 
		$this->session->set_userdata('flashdata', $this->lib_url->getUrl());
        $this->config->set_item("active_menu", "unanswers");
		
		$data = array();
		
        if($catid != "")
		$data = $this->lib_menu->meta_by_catid($catid);
        else {
            $data['title'] = 'Câu hỏi chưa trả lời';
            $data['description'] = SHORT_DESCRIPTION." các câu hỏi chưa trả lời";   
        }
		
        $this->template->write("keywords",str_replace(' ',',',$data['title']), true);
        
		$this->template->write("title",$data['title'], true);
        $this->template->write("description",$data['description'], true);
                
		$data += $this->Questions_model->show_item($catid , $unanswer = true);
		//$data['form_filter_seach'] =  modules::load('ext_filter');
		//$data['mod_user'] = $this->mod_user;
		$this->load->view("show_item",$data);
    }
	
	
	   
	function view_item($id)
	{
	   
        $this->session->set_userdata('flashdata', $this->lib_url->getUrl());
		$this->config->set_item("body_layout", "body");
        
        $this->config->set_item("active_menu", "catagory_tags"); 
        $this->load->model('stat/stat_model')->increment_viewed_times($this->module, $id);
        
		$data = array();
		
        if(!$this->lib_cache->check_cache_json(__METHOD__, $id, $data) )
        {
            $data += $this->Questions_model->view_item($id);
		    
            $data['items_same_topic'] = $this->Questions_model->same_topic($data['catid'], $viewed = $id);
            $data['items_same_by_tags'] = $this->Questions_model->same_item_by_tags($data['tags_id'], $viewed = $id);
            //print_r ($data); exit;
            //$data['mod_user'] = $this->mod_user;    
            
            $this->lib_cache->cache_json($data);
        }
        
        if(count($data['answers']) ) $data['description'] = $data['description']. ' – ['.count($data['answers']).' trả lời]' ; 
        
		$this->template->write("title",$data['tieu_de'], true);
        $this->template->write("description",$data['description'], true);
        $this->template->write("keywords",str_replace(' ',',',$data['tieu_de']), true);
        //$data['user_topic'] = $this->lib_auth->info_by_id($data['user_id']);
		//print_r ($data); exit;
        $this->load->view("view_item",$data);
        
        
	}
    
    function ask($id = "", $error = "")
    {
        if($id=="")
        $this->session->set_userdata('flashdata', $this->lib_url->getUrl());
        
        
        
        if(!$this->session->userdata('ID'))
        $this->lib_url->redirect_save_flashdata('user/login', "Bạn phải đăng nhập để đăng câu hỏi");
        else
        if(!$this->lib_auth->check_permission($id))
        redirect('');
        
        $this->config->set_item("active_menu", "ask");
        $this->config->set_item("body_layout", "body"); 
           
   	    $submit = $this->input->post('submit_ask');
		if($submit)
		{
			//$this->form_validation->set_message('required', 'Bạn phải chọn ít nhất một mục');
           
            $this->form_validation->set_rules('ask[tieu_de]', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('noi_dung', 'Nội dung', 'required');
            $this->form_validation->set_rules('ask[tags_id]', 'Tag', 'required');
			$this->form_validation->set_rules('ask[catid]', 'Danh mục', 'required');
            if($this->form_validation->run())
			{
				$this->Questions_model->save_ask($id);
			}	
            
        }
        $data = array();
        $data += $this->Questions_model->get_data_edit('', $id);
        
        $data += $this->Questions_model->catagory(); 
        $data['error'] = $error;
        $this->load->view("ask_form", $data);
    }
    
    function del($id)
    {
        if(!$this->lib_auth->check_permission($id))
        redirect('');
        if($this->Questions_model->del($id))
        {
             $this->lib_url->redirect('', "Câu hỏi đã được xóa thành công");
        }
        else
        {
            $this->view_item($id, $error = "Câu hỏi này đã có câu trả lời chính xác, bạn không thể xóa");
        }
    }
    
    function save_answer($id = "")
    {
        $submit = $this->input->post('submit_answer');
		if($submit)
		{ 
		    $this->form_validation->set_rules('noi_dung', 'Nội dung' , 'required');
            if($this->form_validation->run())
			{
				$this->Questions_model->save_answer($id);
			}	
        }
        else {
            //redirect('');
        }
    }
    
    
    
    function edit_answer($id)
    {
        $id = decode_me($id); 
        if(!$this->lib_auth->check_permission($this->lib_auth->get_user_id_topic('mod_questions_answer', $id) ))
        redirect('');
        
        $this->config->set_item("active_menu", "question");
        $this->config->set_item("body_layout", "body"); 
        $data = array();
        
        $this->save_answer($id);
        
        $data['answer'] = $this->Questions_model->get_data_edit('_answer', $id);
        $data['question'] = $this->Questions_model->get_data_edit('', $data['answer']['FID'] );
        $this->load->view("form_edit_answer", $data);
    }
    
    function del_answer($id)
    {
        $this->Questions_model->del_answer($id);
        $this->lib_url->redirect_to_back('', 'Xóa thành công');
    }
    
    
    
	
	function block_latest_questions()
	{
		$data = array();
		$data['items'] = $this->Questions_model->block_latest_questions();
		$this->load->view("block_latest_questions",$data);
	}
	function block_most_read_questions()
	{
		$data = array();
		$data['items'] = $this->Questions_model->block_most_read_questions();
		$this->load->view("block_most_read_questions",$data);
	}
	
	function in_home()
	{
	   $catid = 65;
       $this->config->set_item("body_layout", "body");
	   $this->session->set_userdata('flashdata', $this->lib_url->getUrl());
       
       $this->catid = $catid;
       
       if(!is_numeric($catid))
       {
            $catid = $this->lib_menu->catid_by_alias($catid);
            $this->config->set_item("active_menu", "catagory_tags");
       }
       else
       $this->config->set_item("active_menu", "questions");
		
		
		$data = array();
	
        if(trim($catid) != 65)
		$data = $this->lib_menu->meta_by_catid($catid);
        else {
            $data['title'] = 'Câu hỏi mới';
            $data['description'] = SHORT_DESCRIPTION;   
        }
		
		$this->template->write("title",$data['title'], true);
        $this->template->write("description",$data['description'], true);
        $this->template->write("keywords",str_replace(' ',',',$data['title']), true);
                
		$data += $this->Questions_model->show_item($catid); 
        $data['catid'] = $catid;
		//$data['form_filter_seach'] =  modules::load('ext_filter');
		
        //$data['mod_user'] = $this->mod_user;
		
        $this->load->view("show_item",$data);
	    /*$this->config->set_item("body_layout", "body");
        $this->config->set_item("active_menu", "home");
		$data = array();
        $data['title'] = 'Câu hỏi mới nhất theo chủ đề';
		$data['items'] = $this->Questions_model->in_home();
        //$data['mod_user'] = $this->mod_user;
		$this->load->view("in_home",$data);
        */
	}
    
    function ajax_search()
    {
        $data = array();
        $data['items'] = $this->Questions_model->ajax_search();
        $this->load->view("ajax/ajax_search", $data);
    }
    function ajax_vote_bookmark()
    {
        $data = array();
        $val = $this->input->post('val');
        $type = $this->input->post('type');
        
        if(!$this->lib_auth->check_permission())
        {
            $data['ok'] = -1;
            echo json_encode($data);    
            return;   
        }
        
        if($type == 'vote_up')
        {
            $data += $this->Questions_model->vote($val, 'vote_up');   
        }
        elseif($type == 'vote_down')
        {
            $data += $this->Questions_model->vote($val, 'vote_down');   
        }
        elseif($type == 'bookmark')
        {
            $data += $this->Questions_model->bookmark($val);  
        }
        
        $data['type'] = $type;
        $data['score_id'] = $val;
        $data['ok'] = 1;
        echo json_encode($data);
        
    }
    
    function search()
    {
        $this->session->set_userdata('flashdata', $this->lib_url->getUrl());
    	$this->config->set_item('body_layout', 'body');
    	
    	$this->template->write("title", str_replace('+',' ', $this->lib_url->_GET('q')), true);
        $data = array();       
        $data += $this->Questions_model->search();
        //$data['form_filter_seach'] =  modules::load('ext_filter');
        $data['title'] = $data['nRow']. " kết quả tìm thấy";
        $this->load->view("show_item_search",$data);
    }
    
    function create_search()
    {
    	$this->load->library('lib_convert');
    	
    	$url = 'search/';
    	$q = trim($this->input->post('q'));
    	$catid = $this->input->post('catid');
    	
    	$arr = array(
    	   //,"sid_location" => $sid_location
    	   //,"catid" => $catid
    	   "q" => $this->lib_convert -> create_keysearch($q)
    	); 
    	$url = $this->lib_url->change_url($url, $arr);
    	redirect($url);
    }
    
	function ajax_comment()
    {
        $val = $this->input->post('val');
        $type = $this->input->post('type');
        $data = array();
        //$data['val'] = $val;
        $data['type'] = $type;
        
        if($this->Questions_model->save_comment())
        {
            $user_id = $this->session->userdata('ID');
            $full_name = $this->session->userdata('full_name');
            
            $data['ok'] = true;
            $data['html'] = '
            <li>'.$val.' - '.anchor('user/'. $user_id , $full_name).'
            <span class="gray"> · 1 giây trước</span>
            </li>
            ';
        }
        else
        {
            $data['ok'] = -1;
        } 
        
        echo json_encode($data);
        
    }
    function set_exactly($id_answer)
    {
        $level = $this->session->userdata('level');
        if($level < 1 )
        {
            redirect(); return false;
        }    
        $this->Questions_model->set_exactly($id_answer);
        $this->lib_url->redirect( base64_decode($this->lib_url->_GET('return')) , 'Thành công');
    }
    function set_closed($id)
    { 
        $this->Questions_model->set_closed($id);
        $this->lib_url->redirect( base64_decode($this->lib_url->_GET('return')) , 'Thành công');
    }
    
    function ajax_del_comment()
    {
        $id = $this->input->post('id');
        $question_id = $this->input->post('question_id');
        $data = array();
        $data['ok'] = $this->Questions_model->del_comment_byid($id, $question_id);
        echo json_encode($data);
    }
}
 
