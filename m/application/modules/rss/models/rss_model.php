<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rss_model extends CI_Model{
	
	var $lang;
	var $db_table = "";
	var $upload_folder = "images/questions";
	var $db_select_show_item;
	public function __construct(){
        parent::__construct();
        
        $this->lang = $this->session->userdata('lang');
        
        $this->db_table = ($this->lib_url->_GET('m') == '') ? 'mod_questions' : $this->lib_url->_GET('m');
        
        $this->db_select_show_item = "ID,alias,date_edit,catid,images";         
    }
    public function index(){
    	
    }
    public function show_item(){
    	
        
    	$this->db->limit(50);
        $this->db->order_by('ID','DESC');
    	$r['items'] = $this->db->get_where($this->db_table)
    	->result_array();
    	
    	return $r;
    }
    public function load_conf(){
    	$data = $this->db->get('com_configs')->row_array();
    	return $data + $this->lib_db->get_join_lang("com_configs", $id = "" ,$lang = "" , $select_a = "*" , $select_b = "")
    	->row_array();
    	 
    }
}