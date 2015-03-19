<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends MX_Controller {
	
	
	public function __construct(){
       	parent::__construct();
      	$this->load->Model('Tags_model');
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
    
    public function show_all_items(){
		
        $this->config->set_item("active_menu", "tags");
        
		$this->config->set_item("body_layout", "body"); 
		$data = array();
		
        $title = "Tất cả danh mục và tag";
        $description = "Các tag được hiển thị theo chủ đề, tag giúp bạn đặt câu hỏi nhanh hơn và dể tìm kiếm hơn";
		$this->template->write("title", $title , true);
        $this->template->write("description", $description, true);
                
		$data['items'] = $this->Tags_model->show_all_items();
		$data['title'] =  $title;
        $data['description'] =  $description;
		
		$this->load->view("show_all_items",$data);
	}
    
	public function show_item($catid){
		
        $this->config->set_item("active_menu", "tags");
        
		$this->config->set_item("body_layout", "body"); 
		$data = array();
		
		$data += $this->Tags_model->show_item($catid);
		
        $this->template->write("title",$data['cata_name'], true);
        $this->template->write("description",$data['cata_name'], true);
        
		//$data['form_filter_seach'] =  modules::load('ext_filter');
		
		$this->load->view("show_item",$data);
	}
	
	   
	
	
	function ajax_search_tags() // not used
    {
        $data = array();
        $data['items'] = $this->Tags_model->auto_suggest_tags();
        //echo "asd";
        //print_r ( $data['items'] );
        $this->load->view("ajax/auto_suggest_tags", $data);
    }
    function ajax_checkbox_tags() // Select in form ask
    {
        $data = array();
        $catid = $this->input->post('catid');
        $tags_id = $this->input->post('tags_id');
        echo $this->lib_tags->show_checkbox_tags($catid, $tags_id);
        //$this->load->view("ajax/show_checkbox_items", $data);
    }
	
	
}
 
