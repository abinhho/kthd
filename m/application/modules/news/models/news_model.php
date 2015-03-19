<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_model extends CI_Model{
	
	var $db_table = "mod_news";
	var $upload_folder = "images/news";
	public function __construct(){
        parent::__construct();
               
        $this->load->library("lib_upload");
        $this->lib_upload->config_image['upload_path'] = $this->upload_folder;
                       
    }
    public function index(){
    	
    }
    public function show_item($catid){
    	
    	$select_a = "ID,date_upd,active,user_id,viewed_times,catid,images";
    	$select_b = "tieu_de,description";
    	
    	$this->lib_db->get_find_in_set($catid);
    	/*$this->lib_db->create_query_search();*/
    	    	
    	$this->lib_db->order_by();
    	$this->lib_pagination->db_limit();
    	$r['items'] = $this->lib_db->get_join_lang($this->db_table, $id = "" ,$lang = "" , $select_a , $select_b)
    	->result_array();
    	
    	/*echo $this->db->last_query();*/
    	
    	$this->lib_db->get_find_in_set($catid);
		/*$this->lib_db->create_query_search();*/
    	
    	$r['nRow'] = $conf['nRow'] = $this->lib_db->get_join_lang($this->db_table, $id = "" ,$lang = "" , $select_a , $select_b)
    	->num_rows();
    	
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
    	
    	
   		/*echo $this->db->last_query();*/
   		
    	
   		
   		
    	//$this->db->stop_cache();
    	/*$this->lib_db->get_find_in_set();*/
    	
    	
    	return $r;
    }
    
    public function same_topic($catid){
        
        $select_a = "ID,date_upd,active,user_id,viewed_times,catid";
        $select_b = "tieu_de";
        $this->db->limit(8);
     	
        return $this->lib_db->get_join_lang($this->db_table, $id = "" ,$lang = "" , $select_a , $select_b)
        ->result_array();
       
    }
    
    public function block_latest_news(){
        
        $select_a = "ID,date_upd,active,user_id,viewed_times,catid,images";
        $select_b = "tieu_de";
        $this->db->limit(5);
     	$this->db->order_by($this->db_table.".ID", "DESC");
        return $this->lib_db->get_join_lang($this->db_table, $id = "" ,$lang = "" , $select_a , $select_b)
        ->result_array();
       
    }
	public function block_most_read_news(){
        
        $select_a = "ID,date_upd,catid,active,user_id,viewed_times,catid,images";
        $select_b = "tieu_de";
        $this->db->limit(4);
     	$this->db->order_by($this->db_table.".viewed_times", "DESC");
        return $this->lib_db->get_join_lang($this->db_table, $id = "" ,$lang = "" , $select_a , $select_b)
        ->result_array();
       
    }
    
    public function view_item($id){
    	
    	$data = array();
    	$select_a = "ID,date_upd,catid,active,user_id,viewed_times,catid,active_comment";
        $select_b = "tieu_de,description,noi_dung";
        
    	return $data += $this->lib_db->get_join_lang($this->db_table, array($this->db_table.".ID" => $id) ,
    	$lang = $this->session->userdata('lang') , $select_a , $select_b)
        ->row_array();
    }
}