<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tags_model extends CI_Model{
	
	var $db_table = "mod_tags";
	var $upload_folder = "images/tags";
	public function __construct(){
        parent::__construct();
               
        $this->load->library("lib_upload");
        $this->lib_upload->config_image['upload_path'] = $this->upload_folder;
                       
    }
    public function index(){
    	
    }
    public function show_all_items(){
    	
    	$data = $this->db->get_where("mod_sitemap", array("parent_id" => 65)) -> result_array();
        foreach ($data as $i => $row)
        {
            $data[$i]['tags'] = $this->get_tags($row['ID'], 10);
        }
    	return $data;
    }
    
    public function show_item($catid){
    	
        $data = array();
    	$temp = $this->db->get_where("mod_sitemap", array("ID" => $catid)) -> row_array();
        $data['cata_name'] = $temp['tieu_de'];
        $data['cata_id'] = $temp['ID'];
        $data['items'] = $this->get_tags($temp['ID']);
        
    	return $data;
    }
    
    function get_tags($FID, $limit_param = "")
    {
        $r = array();
        if($limit_param == ""){
            $limit = ($this->lib_url->_GET('page') == "" ) ? 1 : $this->lib_url->_GET('page');
            $limit = $this->config->item('pagination_length') * ($limit - 1) . ',' . $this->config->item('pagination_length');
        }
        else $limit = $limit_param;
        
    	$query = $this->db->query('
        SELECT t.n_used,t.tieu_de,t.alias,t.ID,t.FID,b.alias as cata_alias
            FROM mod_tags t
            JOIN mod_sitemap b ON t.FID = b.ID
            WHERE t.FID = \''.$FID.'\'
            '.$this->get_sort().'
        LIMIT '.$limit);
     	
        //return $query -> result_array();
        
        $r['items'] = $query -> result_array();
    	//echo $this->db->last_query();
        $this->db->select('ID');
    	$r['nRow'] = $conf['nRow'] =  $this->db->where('FID', $FID)->get('mod_tags') -> num_rows();
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
    	return $r;
    }
    
    function get_sort($sort_name = 'tagsort')
    {
        $sort = $this->lib_url->_GET($sort_name);
        if($sort == '' || $sort == 'newest') return 'ORDER BY t.ID DESC';
        if($sort == 'oldest') return 'ORDER BY t.ID ASC';
        if($sort == 'used') return 'ORDER BY t.n_used DESC';
    }
 
    
    function auto_suggest_tags()
    {
        $showed = $_GET['showed'];
        $catid = $_GET['catid'];
        $limit = $_GET['limit'];
        $key = trim($_GET['key']);
        
        $showed = ($showed == "") ? "" : "ID NOT IN (". $showed .") AND ";
        
        $this->db->select("*");
        $this->lib_db->create_query_search('tieu_de,alias' , $key);
        $this->db->where($showed . "FID = '".$catid."' ");
        
        $this->db->limit($limit); 
        //echo  $this->db->last_query();
        return $this->db->get($this->db_table) -> result_array();
                
        
    }
}