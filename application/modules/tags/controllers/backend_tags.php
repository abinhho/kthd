<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend_tags extends MX_Controller {
	
	var $_GET_id;
	var $module_alias = "tags";
	public $title = "Quản lý bài viết";
	public function __construct(){
       	parent::__construct();
      	$this->load->Model('Backend_tags_model');
      	$this->load->library('lib_pagination');
      	$this->lang->load('static');
      	$this->load->library('form_validation');
      	
      	$this->module = $this->router->fetch_module();
      	
       	//$this->lib_media->media_folder = base_url().'images/'.$this->router->fetch_module();
       	
       	$this->_GET_id = $this->lib_url->_GET('id');
	}
	public function index()
	{
	   if(!isset($_GET['catid']))
       $this->show_catagory();
       else
	   $this->show_item($_GET['catid']);
	}
	public function show_item($catid){
		
		$data = array();
		
		$this->template->write('title', "Quản lý các tags" , true);
		
		$submit = $this->input->post('submit');
		if($submit)
		{
			$this->form_validation->set_message('required', 'Bạn phải chọn ít nhất một mục');
			$this->form_validation->set_rules('multi_select[]', '', 'required');
			
			if($this->form_validation->run())
			{
				$this->Backend_tags_model->del_multi();
			}		
		}
				
		$data = $this->Backend_tags_model->show_item($catid);
        $data['catagory'] =$this->Backend_tags_model->get_name_cata(); 
        //print_r ($data);
		//$data['form_filter_seach'] =  modules::load('ext_filter');
		
		$this->load->view("backend_show_item",$data);
	}
    function show_catagory()
    {
        $data = $this->Backend_tags_model -> catagory();
        $this->load->view("backend_catagory", $data);
    }
	public function del(){
		
		$this->Backend_tags_model -> del($this->_GET_id);
		$this->lib_url->redirect_to_back();
	}
	public function edit($id = "", $catid = ""){
		
        $this->_GET_id = $id;
		
		$this->load->library(array(
		'form_validation'
		,'lib_form'
		)
		);
		
		$data = array();
		$submit = $this->input->post('submit');
		if($submit)
		{
			$this->form_validation->set_rules('tieu_de', 'Tên tags', 'trim|required');
            //$this->form_validation->set_rules('noi_dung', 'Mô tả tags', 'trim|required');
			//$this->form_validation->set_rules('alias', 'Alias', 'trim|required');
			if($this->form_validation->run())
			{
				$this->Backend_tags_model->do_edit($data, $this->_GET_id);
				$this->load->view("iframe/promt_feed" , array("messenger" => "Thành công"));
				
				return 0;
			}
			else {
				$this->load->view("iframe/promt_feed");
				return 0;
			}
			
		}

		
		$data += ($this->_GET_id != "") ? $this->Backend_tags_model->data_edit($this->_GET_id) : array() ;
		$data['catid'] = $catid;
		$this->load->view("backend_promt",$data);
		

		
	}
	public function copy(){
		
		$this->Backend_tags_model->copy($this->_GET_id);
		$this->lib_url->redirect_to_back();
	}
	
    public function system_clean()
    {
        echo modules::run('ext_system_clean','tags');
    }
    
    public function templates()
    {
        echo modules::run('ext_templates', $this->module);
    }
    public function blocks()
    {
        echo modules::run('com_blocks/backend_com_blocks/blocks_each_module', "tags");

    }
    
  
}
 
