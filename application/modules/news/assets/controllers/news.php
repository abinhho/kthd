<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends MX_Controller {
	
	
	public function __construct(){
       	parent::__construct();
      	$this->load->Model('News_model');
      	$this->load->library('lib_pagination');
      	$this->lang->load('static');
      	    
      	$this->module = $this->router->fetch_module(); 	
       	//$this->lib_media->media_folder = base_url().'images/'.$this->router->fetch_module();
    
	}
	public function index($catid, $viewid)
	{
		$this->session->set_userdata('flashdata', $this->lib_url->getUrl());
		if(empty($viewid))
		$this->show_item($catid);
		else {
			$this->view_item($viewid);
		}
	}
	public function show_item($catid){
		
		$this->config->set_item("body_layout", "body_right"); 
		$data = array();
		
		$data = $this->lib_menu->meta_by_catid($catid);
		
		$this->template->write("title",$data['title'], true);
        $this->template->write("description",$data['description'], true);
                
		$data += $this->News_model->show_item($catid);
		//$data['form_filter_seach'] =  modules::load('ext_filter');
		
		$this->load->view("show_item",$data);
	}
	
	   
	function view_item($catid)
	{
		$this->config->set_item("body_layout", "body_right"); 
		$data = array();
		
		$data += $this->News_model->view_item($catid);
		
        $this->template->write("title",$data['tieu_de'], true);
        $this->template->write("description",$data['description'], true);
        
        $data['full_name'] = $this->lib_auth->info_by_id($data['user_id'])->full_name;
        
        $data['items_same_topic'] = $this->News_model->same_topic($catid);
        
        $this->load->view("view_item",$data);
        
        $this->load->model('stat/stat_model')->increment_viewed_times($this->module, $catid);
	}
	
	function block_latest_news()
	{
		$data = array();
		$data['items'] = $this->News_model->block_latest_news();
		$this->load->view("block_latest_news",$data);
	}
	function block_most_read_news()
	{
		$data = array();
		$data['items'] = $this->News_model->block_most_read_news();
		$this->load->view("block_most_read_news",$data);
	}
	
	function in_home()
	{
		$data = array();
		$data['items'] = $this->News_model->in_home();
		$this->load->view("in_home",$data);
	}
	
}
 
