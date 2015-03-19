<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Backlink_model extends CI_Model{
	
	var $db_table = "mod_backlink";
	var $upload_folder = "images/backlink";
    var $db_select_user = "u.ID as user_ID,u.full_name as user_full_name,u.score as user_score,u.images as user_images,
                u.n_questions as user_n_questions,u.n_answers as user_n_answers,u.level as user_level";
	public function __construct(){
        parent::__construct();    
                   
    }
    public function index(){
    	
    }
   
    public function same_topic($catid){
        
        $select_a = "ID,date_upd";
        $select_b = "tieu_de";
        
     
        return $this->lib_db->get_join_lang($this->db_table, $id = "" ,$lang = "" , $select_a , $select_b)
        ->result_array();
       
    }
    function click($id)
    {
        $this->lib_db->increment_row("mod_backlink", "clicked", array("ID"=> $id));
        $this->db->select('url');
        $r = $this->db->get_where('mod_backlink', array('ID'=> $id))->row_array();
        if(!count($r)) redirect('');
        redirect($r['url']);
    }
    
    function show_item()
    {
        $r = array();
        $limit = ($this->lib_url->_GET('page') == "" ) ? 1 : $this->lib_url->_GET('page');
        
        $limit = $this->config->item('pagination_length') * ($limit - 1) . ',' . $limit * $this->config->item('pagination_length');
        
    	$query = $this->db->query('
        SELECT p.*,'.$this->db_select_user.'
            FROM mod_backlink p
            
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            
            WHERE 1 '. $this->get_sort() .'
            
        LIMIT '.$limit);
     	
        //return $query -> result_array();
        
        $r['items'] = $query -> result_array();
    	
    	//echo $this->db->last_query();
        $this->db->select('ID');
    	$r['nRow'] = $conf['nRow'] =  $this->db->where('user_id', $uid)->get('mod_backlink') -> num_rows();
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
        return $r;
    }
    
    
    function show_item_by_user($uid)
    {
        $r = array();
        $limit = ($this->lib_url->_GET('page') == "" ) ? 1 : $this->lib_url->_GET('page');
        
        $limit = $this->config->item('pagination_length') * ($limit - 1) . ',' . $limit * $this->config->item('pagination_length');
        
    	$query = $this->db->query('
         SELECT p.*,'.$this->db_select_user.'
            FROM mod_backlink p
            
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            
            WHERE p.user_id = \''.$uid.'\' '. $this->get_sort() .'
        
        LIMIT '.$limit);
     	
        //return $query -> result_array();
        
        $r['items'] = $query -> result_array();
    	
    	//echo $this->db->last_query();
        $this->db->select('ID');
    	$r['nRow'] = $conf['nRow'] =  $this->db->where('user_id', $uid)->get('mod_backlink') -> num_rows();
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
        return $r;
    }
    
    private function get_sort($sort_name = 'sort', $default = 'newest')
    { 
        $sort = $this->lib_url->_GET($sort_name);
        $default_asc = ($default == 'newest') ? 'DESC' : 'ASC';
        if($sort == '' || $sort == $default) return 'ORDER BY p.ID '.$default_asc;
        if($sort == 'oldest') return 'ORDER BY p.ID ASC';
        if($sort == 'clicked') return 'ORDER BY p.clicked DESC';
        if($sort == 'viewed') return 'ORDER BY p.viewed_times ASC';
        
    }
    
    public function view_item($id){
    	
    	$data = array();
    	$select_a = "ID,body_layout";
        $select_b = "tieu_de,description,noi_dung";
        
    	return $data += $this->lib_db->get_join_lang($this->db_table, array($this->db_table.".ID" => $id) ,
    	$lang = $this->session->userdata('lang') , $select_a , $select_b)
        ->row_array();
    }
	
	public function get_block($catagory){
    	
    	$data = array();
    	$select_a = "ID";
        $select_b = "noi_dung";
        
    	return $data += $this->lib_db->get_join_lang($this->db_table, array($this->db_table.".catagory" => $catagory) ,
    	$lang = $this->session->userdata('lang') , $select_a , $select_b)
        ->row_array();
    }
    
	public function in_home(){
        
        $select_a = "ID,date_upd,images";
        $select_b = "tieu_de,description,noi_dung";
       // $this->db->limit(1);
		//$this->db->order_by("ID", "ASC");
        return $this->lib_db->get_join_lang($this->db_table , array($this->db_table.".ID" => '1') , $this->session->userdata('lang') , $select_a , $select_b)
        ->row_array();
       
    }
    
}