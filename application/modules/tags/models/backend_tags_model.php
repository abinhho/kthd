<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Backend_tags_model extends CI_Model{
	
	var $db_table = "mod_tags";
	var $upload_folder = "images/tags";
	public function __construct(){
        parent::__construct();
               
        $this->load->library("lib_upload");
        $this->lib_upload->config_image['upload_path'] = $this->upload_folder;
                       
    }
    public function index(){
    	
    }
    public function show_item($catid){
    
    	//$this->lib_db->get_find_in_set();
    	//$this->lib_db->create_query_search();
    	$r = array();	
        $r['items'] = $this->db->get_where($this->db_table, array('FID' => $catid )) -> result_array();
        $this->lib_db->order_by();
	    $this->lib_pagination->db_limit();
        
    	//$r['items'] = $this->lib_db->get_join_lang($this->db_table, $id = "" ,$lang = "" , $select_a , $select_b)
    	
    	//$this->lib_db->get_find_in_set();
		//$this->lib_db->create_query_search();
    	
        $this->db->select("ID");
    	$conf['nRow'] = $this->db->get_where($this->db_table, array('FID' => $catid ))
    	->num_rows();
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
    	
    	
   		/*echo $this->db->last_query();*/
   		
    	
   		
   		
    	//$this->db->stop_cache();
    	/*$this->lib_db->get_find_in_set();*/
    	
    	
    	return $r;
    }
    public function data_edit($id){
    	
    	$data = array();
    	
    	$this->db->where(array("ID" =>$id ));
    	$data = $this->db->get($this->db_table)->row_array();
    	return $data;
    }
    function get_name_cata()
    {
        $t = $this->db->get_where('mod_sitemap', array('ID' => $_GET['catid'])) -> row_array();
        return $t['tieu_de'];
    }
    public function list_catagory(){
    	
    	$this->db->distinct();
    	$this->db->select('catagory');
    	$temps = $this->db->get($this->db_table)->result_array();
    	
    	$temp = array();
    	foreach ($temps as $r)
    	{
    		$temp[$r['catagory']] = $r['catagory'];
    	}
    	
    	return $temp;
    	
    }
    public function do_edit(&$data , $id = ""){
    	
    	$db_data = array
    	(
	    	"tieu_de" => $this->input->post('tieu_de')
    		,"noi_dung" => $this->input->post('noi_dung')
            ,"n_used" => $this->input->post('n_used')
            ,"trong_luong" => $this->input->post('trong_luong')
    	);
    	
        $db_data['alias'] = $this->input->post('alias');
        if(trim($db_data['alias']) == '')
        {
            $db_data['alias'] = $this->lib_alias->convert2Alias($this->input->post('tieu_de'));
        }
        
        
    	if($id)
    	{
    		$this->db->where("ID",$id);	
    		$this->db->update($this->db_table , $db_data);
       	}
    	else {
    	   $db_data["FID"] = $this->input->post('catid');
           $this->db->insert($this->db_table , $db_data);
    	}
        
    	//$this->lib_url->reload("Cập nhật thành công...");
    	
    }
    
    function catagory()
    {
        $r = array();
        $r['items'] = $this->db->where("parent_id", 65 ) -> get('mod_sitemap') ->result_array();
        return $r;
    }
    
    public function copy($id)
    {
    	$newid= $this->lib_db->dup($this->db_table, $id);
    	$this->lib_db->dup_lang($this->db_table, $id, $newid);
    	
    	$this->db->select("images");
    	$r = $this->db->where("ID", $newid ) -> get($this->db_table) ->row_array();
    	$img = $r['images'];
    	
    	if($img != "")
    	{
			$newimg = array(); 
			$imgs =preg_split("/,/" , $img);
			{
				foreach($imgs as $file)
				{
					$newfile = time()*rand()."-".$file;
	
					if (copy($this->upload_folder.'/'.$file, $this->upload_folder.'/'.$newfile) ) {
	                        $newimg[] = $newfile;
	                 }
	                    else echo "failed to copy $file...\n";
	 
				}
			}
			
			$db_data =array( "images" => implode("," , $newimg) );
			
			$this->db->where("ID", $newid);
			$this->db->update($this->db_table, $db_data);
    	}
    	
    }
    
    
	public function del_multi()
    {
    	$list = $this->input->post('multi_select');
    	foreach ($list as $id)
    	{
    		$this->del($id);
    	}
    }
    public function del($id)
    {
    	//$this->lib_db->del_images($this->db_table, $id);
    	//$this->lib_db->del_data_lang($this->db_table, $id);
    	
    	$this->db->where("ID",$id);
    	$this->db->delete($this->db_table);
    }
}