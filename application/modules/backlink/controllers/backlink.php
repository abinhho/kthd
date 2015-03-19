<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backlink extends MX_Controller {
    
    
    var $description = ', Tạo hàng loạt backlink miễn phí, chất lượng, tăng pagerank cho website bạn và được nhiều khách hàng biết đến';
    var $title = 'Tạo backlink miễn phí và nhanh nhất';
    public function __construct(){
        parent::__construct();
        $this->load->Model('Backlink_model');
        $this->load->library('lib_pagination');
        $this->lang->load('static');
        //$this->lib_media->media_folder = base_url().'images/'.$this->router->fetch_module();
    
    
    }
    public function index($catid, $viewid)
    {
       
    }
    public function click($id)
    {
       $this->Backlink_model->click($id);
    }
    
    function show_item()
    {
        $data = array();
        $this->config->set_item("body_layout", "body");
        $this->config->set_item("active_menu", "backlink");
        $this->session->set_userdata('flashdata', $this->lib_url->getUrl());
        
        $data['title'] = 'Các link của '. $t['full_name'];
        $data['description'] = $t['about']. $this->description; 
        $this->template->write("title", $this->title, true);
        $this->template->write("description", $this->description, true);
        
        $data += $this->Backlink_model->show_item($uid);
        
        $data['questions'] = $this->load->module('questions');
        
        $this->load->view("show_item",$data);
    }
    function show_item_by_user($uid)
    {
        $data = array();
        $this->config->set_item("body_layout", "body");
        $this->config->set_item("active_menu", "backlink");
        $this->session->set_userdata('flashdata', $this->lib_url->getUrl());
        $t = $this->lib_auth->topic_userdata($uid);
        $data['title'] = 'Các link của '. $t['full_name'];
        $data['description'] = $t['about']. $this->description;
        
        $this->template->write("title",$data['title'], true);
        $this->template->write("description",$data['description'], true);
         
        $data += $this->Backlink_model->show_item_by_user($uid);
        
        $data['questions'] = $this->load->module('questions');
        
        $this->load->view("show_item",$data);
    }
 
       
    function view_item($catid)
    {
    	
        $data = array();
        
        $data += $this->Backlink_model->view_item($catid);
        
		$this->config->set_item('body_layout', $data['body_layout']);
		
        $this->template->write("title",$data['tieu_de'], true);
        $this->template->write("description",$data['description'], true);
         $this->load->model('stat/stat_model')->increment_viewed_times($this->module, $id);
       /* $data['items_same_topic'] = $this->Backlink_model->same_topic($catid);*/
        
        $this->load->view("view_item",$data);
    }
    
    function in_home()
    {
    	$data = array();
		$data += $this->Backlink_model->in_home();
		$this->load->view("in_home",$data);
    }
	
	function block_spage_html_1()
	{
		$data = array();
		$data += $this->Backlink_model->get_block('block_spage_html_1');
		$this->load->view("block_spage_html_1",$data);
	}
	function block_spage_html_2()
	{
		$data = array();
		$data += $this->Backlink_model->get_block('block_spage_html_2');
		$this->load->view("block_spage_html_2",$data);
	}
	function block_spage_html_3()
	{
		$data = array();
		$data += $this->Backlink_model->get_block('block_spage_html_3');
		$this->load->view("block_spage_html_3",$data);
	}
    
}
 
