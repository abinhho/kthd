<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Questions_model extends CI_Model{
	
	var $db_table = "mod_questions";
	var $upload_folder = "images/questions";
    var $select_show_item = "p.ID,p.exactly,p.date_add,p.date_edit,p.description,p.active,p.n_answers,p.user_id,p.viewed_times,p.catid,p.tieu_de,p.alias,p.n_votes,p.user_votes,p.tags_id,p.closed";
    var $select_show_item_small = "p.ID,p.exactly,p.date_add,p.date_edit,p.active,p.n_answers,p.viewed_times,p.catid,p.alias,p.tieu_de,p.n_votes,p.closed";
    
    var $db_select_user = "u.ID as user_ID,u.full_name as user_full_name,u.score as user_score,u.images as user_images,
                u.n_questions as user_n_questions,u.n_answers as user_n_answers,u.level as user_level";
    var $cache_method = 'Questions::view_item';
	var $emails = 'thanhbinhbk88@gmail.com';
	public function __construct(){
        parent::__construct();
               
        $this->load->library("lib_upload");
        $this->lib_upload->config_image['upload_path'] = $this->upload_folder;
                       
    }
    public function index(){
    	
    }
    public function show_item($catid, $unanswer = false){
    	
        $limit = ($this->lib_url->_GET('page') == "" ) ? 1 : $this->lib_url->_GET('page');
        
        $limit = $this->config->item('pagination_length') * ($limit - 1) . ',' .$this->config->item('pagination_length');
        
        $unanswer = ($unanswer) ? ' WHERE p.n_answers = 0 AND p.closed = 0' : '';
        
    	$query = $this->db->query('
        SELECT '.$this->select_show_item.','.$this->db_select_user.', c.alias as cata_alias,c.tieu_de as cata_tieu_de
            FROM '.$this->db_table.' p
            
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            
            LEFT JOIN mod_sitemap c 
            ON p.catid = c.ID
            
            '.$unanswer.'
         '. $this->lib_db->get_find_in_set($catid, ' WHERE ') .' '.$this->get_sort().' LIMIT '.$limit);
     	
        //return $query -> result_array();
        
      
    	/*$this->lib_db->create_query_search();*/
    	    	
    	//$this->lib_db->order_by();
    	//$this->lib_pagination->db_limit();
    	//$this->db->select($this->select_show_item);
        $r['items'] = $query -> result_array();
    	
        /*foreach($r['items'] as $i => $row)
        {
            $r['items'][$i]['tags_info'] = $this->get_tag_info($row['tags_id']);
        }*/
        
        
    	//echo $this->db->last_query();
    	
    	
		/*$this->lib_db->create_query_search();*/
        
        $query = $this->db->query('
        SELECT p.ID,p.user_id,'.$this->db_select_user.'
            FROM '.$this->db_table.' p
            
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            
            '.$unanswer.'
            
         '. $this->lib_db->get_find_in_set($catid, ' WHERE ') );
        
        
    	$r['nRow'] = $conf['nRow'] =  $query -> num_rows();
    	
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
    	
    	
   		//echo $this->db->last_query();
   		
    	//$this->db->stop_cache();
    	/*$this->lib_db->get_find_in_set();*/
    	
    	
    	return $r;
    }
    
      public function search(){
    	
        $limit = ($this->lib_url->_GET('page') == "" ) ? 1 : $this->lib_url->_GET('page');
        
        $limit = $this->config->item('pagination_length') * ($limit - 1) . ',' .$this->config->item('pagination_length');
        
        $query_where_search =  $this->lib_db->create_query_search('p.tieu_de','', true);
        
        $query_where_search = (trim($query_where_search) == "") ? '' : ' WHERE '.$query_where_search;
        
    	$query = $this->db->query('
        SELECT '.$this->select_show_item.','.$this->db_select_user.'
            FROM '.$this->db_table.' p
            
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            
            '.$query_where_search.'
            
         '.$this->get_sort().' LIMIT '.$limit);
        
        $r['items'] = $query -> result_array();
    	
        
        $query = $this->db->query('
        SELECT p.ID,p.user_id,'.$this->db_select_user.'
            FROM '.$this->db_table.' p
            
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            '.$query_where_search.'
            ');
        
        
    	$r['nRow'] = $conf['nRow'] =  $query -> num_rows();
    	
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
    	
    	
    	return $r;
    }
    
    
    public function show_item_by_tag($tag_id){
    	
        $limit = ($this->lib_url->_GET('page') == "" ) ? 1 : $this->lib_url->_GET('page');
        
        $limit = $this->config->item('pagination_length') * ($limit - 1) . ',' . $this->config->item('pagination_length');
        
    	$query = $this->db->query("
        SELECT ".$this->select_show_item.",".$this->db_select_user."
            FROM ".$this->db_table." p
            
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            
            WHERE FIND_IN_SET(".$tag_id.",p.tags_id) 
            
         ".$this->get_sort()." LIMIT ".$limit);
     	
        //return $query -> result_array();

        $r['items'] = $query -> result_array();
    	
        
        $query = $this->db->query(" SELECT p.ID 
        FROM ".$this->db_table." p
            
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            
            WHERE FIND_IN_SET(".$tag_id.",p.tags_id) 
          "  
         );
        
        
    	$r['nRow'] = $conf['nRow'] =  $query -> num_rows();
    	
    	$r['split_page'] = $this->lib_pagination->split_page($conf);
    	
    	
    	
    	return $r;
    }
    
    
    function save_ask($id = "")
    {
        $id = decode_me ($id);
        $this->load->library('lib_convert');
        $user_id = $this->session->userdata('ID');
        if(empty($user_id)) redirect('user/login');
        
   	    $db_data =  $this->input->post('ask');
        $tieu_de = trim($db_data['tieu_de']);
        
        if(substr($tieu_de, -1,1) != '?') $tieu_de = $tieu_de.'?';
        
        
        $db_data['tieu_de'] = $this->lib_convert->ucfirst($tieu_de);
        $db_data['noi_dung'] = trim($this->input->post('noi_dung'));
        $db_data['description'] = implode(' ', array_slice(explode(' ', strip_tags(trim(html_entity_decode($db_data['noi_dung'], ENT_QUOTES, 'UTF-8'), " \t\n\r\0\x0B\xc2\xa0"))), 0, 50));
    	//$db_data['catid'] = $this->input->post('catid');
        $db_data['user_id'] = $user_id;
    	
        
        
        $this->lib_cache->clear_cache_json($this->cache_method,$id);    
        
        $db_data['date_edit'] = $this->lib_date->get();   
    	if($id)
    	{
    	    unset($db_data['user_id']);
    		$this->db->where("ID",$id);	
    		$this->db->update($this->db_table , $db_data);
            // thong ke lai so lan su dung tag
            $this->lib_stat_question->down_stat_tags($this->input->post('old_tags_id'));
            $this->lib_stat_question->up_stat_tags($db_data['tags_id']);
            $this->lib_stat_question->re_stat_n_questions_user($user_id);
            $this->lib_stat_question->re_stat_catagory($db_data['catid']);
            
            $this->lib_url->redirect(base64_decode($this->lib_url->_GET('return')),"Cập nhật thành công");	
       	}
    	else {
            
            $db_data['date_add'] = $this->lib_date->get();
    		
            $alias = $this->lib_alias->convert2Alias($db_data['tieu_de']);
            $db_data['alias'] = $alias;
            
            $this->db->insert($this->db_table , $db_data);
            $insert_id = $this->db->insert_id(); 
            if($insert_id == 0) return;
            // thong ke lai so lan su dung tag
            $this->lib_stat_question->up_stat_tags($db_data['tags_id']);
            
            $this->lib_stat_question->re_stat_n_questions_user($user_id); 
            $this->lib_stat_question->re_stat_catagory($db_data['catid']);
            
            
			$link = 'questions/'.$db_data['catid'].'/'.$alias.'-'.$insert_id.'.html';
			
			$this->send_email_ask($this->lib_url->host().'/'. $link, $db_data['tieu_de']);
			
            $this->lib_url->redirect($link ,"Cập nhật thành công");	
    		//$id = $this->db->insert_id();	
    	}
        
    	
    	//$this->lib_url->redirect('/user/'.$this->session->userdata('ID').'?usertab=question',"Bạn đã cập nhật thành công...");
    }
    
    function set_exactly($id_answer)
    {
        $id_answer = decode_me($id_answer);
        
        $this->db->select('exactly,FID');
        $r = $this->db->get_where($this->db_table.'_answer',  array('ID'=>$id_answer)) ->row_array();
        $val = ($r['exactly'] == 0) ? 1:0;
        $this->db->update($this->db_table.'_answer', array('exactly' => $val ), array('ID'=>$id_answer));
       
        $this->db->update($this->db_table, array('exactly' => $val ), array('ID'=>$r['FID']));
        
        $this->lib_cache->clear_cache_json($this->cache_method,$r['FID']);  
    }
    function set_closed($id)
    {
        $id = decode_me($id);
        $this->db->select('closed');
        $r = $this->db->get_where($this->db_table,  array('ID'=>$id)) ->row_array();
        $val = ($r['closed'] == 0) ? 1:0;
        
        $this->db->update($this->db_table, array('closed' => $val ), array('ID'=>$id));
         
        $this->lib_cache->clear_cache_json($this->cache_method, $id);  
    }
	
	function send_email_ask($link_to, $title )
    {
        
        $html = '<b>'. $this->session->userdata('full_name') .'</b> hỏi '.anchor($link_to, $title). '. 
        <br/><br/>Click vào <b>'.anchor($link_to, 'ĐÂY').'</b> để xem chi tiết.
        
        ';
        
        $mess = array("to" => $this->emails, 'subject' => 
        $this->session->userdata('full_name'). ' - ' .  $title ." - Kienthuchoidap.com", 'message' => $html 
        );
        
	    Modules::run('emails/send', $mess);
	    
    }
    
    function send_email_answer($link_to_answer)
    {
        $this->db->select('email');
        $r = $this->db->where('ID', $this->input->post('user_question_id'))->get('mod_user')->row_array();
        if(!count($r)) return;
        
        $email_to = $r['email'];
        
        $html = '<b>'. $this->session->userdata('full_name') .'</b> đã trả lời câu hỏi '.anchor($link_to_answer, $this->input->post('title_question')). ' của bạn. 
        <br/><br/>Click vào <b>'.anchor($link_to_answer, 'ĐÂY').'</b> để xem chi tiết.
        
        ';
        
        $mess = array("to" => $email_to. ','. $this->emails, 'subject' => 
        $this->session->userdata('full_name'). " đã trả lời câu hỏi của bạn - Kienthuchoidap.com", 'message' => $html 
        );
        
	    Modules::run('emails/send', $mess);
	    
    }
    
    function save_answer($id = "")
    {
        $id = decode_me ($id);
        $user_id = $this->session->userdata('ID');
        if(empty($user_id)) redirect('user/login');
        
        $db_data['noi_dung'] = $this->input->post('noi_dung');
        
    	//$images  = $this->input->post('images');
    	//$db_data['images'] =  $this->lib_media->remove_file_not_exist_in_list($this->db_table,$images);
    	 //print_r ($db_data); exit;
        
          
        
        $db_data['date_edit'] = $this->lib_date->get();
    	if($id)
    	{
            
            $this->lib_cache->clear_cache_json($this->cache_method,$this->input->post('question_id'));
            
            $db_data['user_edit'] = $user_id;
            unset($db_data['user_id']);
            
    		$this->db->where("ID",$id);	
    		$this->db->update($this->db_table."_answer" , $db_data);
            
             // thong ke lai so lan su dung tag
            $this->lib_stat_question->re_stat_answer($this->input->post('question_id'));
            $this->lib_stat_question->re_stat_n_answers_user($user_id);
            
            $this->lib_url->redirect(base64_decode($this->lib_url->_GET('return')),"Cập nhật thành công");
    	    //$this->lib_url->reload("Cập nhật thành công");	
       	}
    	else {
            $db_data['date_add'] = $this->lib_date->get();
            
            $db_data['FID'] = $this->input->post('fid');
            $db_data['user_id'] = $user_id;
    		$this->db->insert($this->db_table."_answer" , $db_data);
            $insert_id = $this->db->insert_id();
            
            $this->lib_cache->clear_cache_json($this->cache_method, $db_data['FID']);
            
            $this->save_user_notes($this->input->post('notes_data'), $insert_id, $action_name = "đã trả lời");
            
             // -1 n answers from user 
           /*  $this->db->where("ID",$user_id);	
            $this->db->set('n_answers', 'n_answers + 1', FALSE);
            $this->db->update('mod_user');
            
            // -1 answers from question
           $this->db->where("ID",$this->input->post('fid'));	
            $this->db->set('n_answers', 'n_answers + 1', FALSE);
            $this->db->update($this->db_table);
            */
            $this->lib_stat_question->re_stat_answer($db_data['FID']);
            $this->lib_stat_question->re_stat_n_answers_user($user_id);
            
            $link2back = $this->lib_url->link_back().'#answer'.$insert_id;
            
            // Send mail to user
            $this->send_email_answer($link2back);
            
   			$this->lib_url->redirect($link2back , 'Cập nhật thành công');
    	}
    	
    	//$this->lib_url->redirect('/user/'.$this->session->userdata('ID').'?usertab=question',"Bạn đã cập nhật thành công...");
    }
    
    function get_user_id($id, $table = "")
    {
        $this->db->select("user_id");
        $this->db->limit(1);
        $r = $this->db->get_where($this->db_table.$table, array('ID' => $id )) -> row_array();
        return $r['user_id'];
    }
    function question_id_by_answer($answer_id)
    {
        $this->db->select("FID");
        $this->db->limit(1);
        $r = $this->db->get_where($this->db_table.'_answer', array('ID' => $answer_id )) -> row_array();
        return @$r['FID'];
    }
    
    function del($id)
    {
        $id = decode_me($id);
        // get user id
       // $this->db->select("user_id");
        //$this->db->limit(1);
        //$r = $this->db->get_where($this->db_table, array('ID' => $id )) -> row_array();
        $user_id = $this->get_user_id($id, "");
        
        $this->lib_cache->clear_cache_json($this->cache_method,$id);
        
        $this->db->select("ID");
        $this->db->limit(1);
        $n = $this->db->get_where($this->db_table."_answer", array('FID' => $id, 'exactly' => 1 )) -> num_rows();
        if($n >= 1)
        {
            return false;
        }
        else
        {
            
            
            $this->db->select("user_id,catid,tags_id");
            $r = $this->db->get_where($this->db_table, array('ID' => $id )) -> row_array();
            
           $this->lib_stat_question->down_stat_tags($r['tags_id']);
            
            // Xoa cau hoi
            $this->db->where("ID",$id);	
            $this->db->delete($this->db_table);
            // Giam 1 cau hoi cua user
            /*$this->db->where("ID",$user_id);	
            $this->db->set('n_questions', 'n_questions + 1', FALSE);
            $this->db->update('mod_user');
            */
            $this->lib_stat_question->re_stat_n_questions_user($r['user_id']);
            
            $this->lib_stat_question->re_stat_catagory($this->input->post('old_catid')); 
            $this->lib_stat_question->re_stat_catagory($r['catid']);
            // lay danh sach user trong cau tra loi
            $this->db->select("user_id");
            $r = $this->db->get_where($this->db_table."_answer", array('FID' => $id )) -> result_array();
            
            foreach($r as $row)
            {
                $this->lib_stat_question->re_stat_n_answers_user($row['user_id']);    
            }
            
            // Xoa cau tra loi
            $this->db->where("FID",$id);	
            $this->db->delete($this->db_table."_answer");
            
            $this->del_comment($id, 'question');
            
            return true;    
        }
        
        
    }
    function del_answer($id)
    {
        $id = decode_me($id);
        $user_id = $this->get_user_id($id, "_answer");
        
        // lay id cua cau hoi
        $question_id = $this->question_id_by_answer($id);
        $this->lib_cache->clear_cache_json($this->cache_method,$question_id);
        
        $this->db->where("ID",$id);	
        $this->db->delete($this->db_table."_answer");
        
        $this->lib_stat_question->re_stat_n_answers_user($user_id);

        // -1 answers from question
        $this->lib_stat_question->re_stat_answer($question_id);
        
        $this->del_comment($id, 'answer'); 
         
         
    }
   
    function catagory()
    {
        $r = array();
        $r['catagories'] = $this->db->where("parent_id", 65 ) -> get('mod_sitemap') ->result_array();
        return $r;
    }
    
  
    
    public function block_hot_questions($catid){
        
          $query = $this->db->query('
        SELECT '.$this->select_show_item.','.$this->db_select_user.'
            FROM '.$this->db_table.' p
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            
            ORDER BY p.viewed_times DESC
            
          LIMIT 15 ');
     	
        return $query -> result_array();
       
    }
    
    public function block_latest_questions(){
        
        $select_a = "ID,date_upd,active,user_id,viewed_times,catid,images";
        $select_b = "tieu_de";
        $this->db->limit(5);
     	$this->db->order_by($this->db_table.".ID", "DESC");
        return $this->lib_db->get_join_lang($this->db_table, $id = "" ,$lang = "" , $select_a , $select_b)
        ->result_array();
       
    }
    function get_sort($sort_name = 'sort', $default = 'newest')
    { 
        $sort = $this->lib_url->_GET($sort_name);
        $default_asc = ($default == 'newest') ? 'DESC' : 'ASC';
        if($sort == '' || $sort == $default) return 'ORDER BY p.ID '.$default_asc;
        if($sort == 'oldest') return 'ORDER BY p.ID ASC';
        if($sort == 'answer') return 'ORDER BY p.n_answers DESC';
        if($sort == 'unanswer') return 'ORDER BY p.n_answers ASC';
        if($sort == 'vote') return 'ORDER BY p.n_votes DESC';
        
        
    }
    public function each_in_home($catid){
     
        $query = $this->db->query("
        SELECT ".$this->select_show_item.",".$this->db_select_user."
            FROM ".$this->db_table." p
             
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            
            WHERE catid = '".$catid."'
         ORDER BY ID DESC LIMIT 6   
         ");
     	
        $r = $query -> result_array();
        /*foreach($r as $i => $row)
        {
            $r[$i]['tags_info'] = $this->lib_tags->get_tag_info($row['tags_id']);
        }*/
        
        return $r;
       
    }
    function in_home()
    {
        $data = array();
        $this->db->select('ID,tieu_de,alias,n_used');
        $data += $this->db->where('parent_id', 65) -> get('mod_sitemap')->result_array();
        foreach($data as $key => $cata)
        {
            $data[$key]['questions'] = $this->each_in_home($cata['ID']);
        }
        return $data;
    }
    
	public function block_most_read_questions(){
        
        $select_a = "ID,date_upd,catid,active,user_id,viewed_times,catid,images";
        $select_b = "tieu_de";
        $this->db->limit(4);
     	$this->db->order_by($this->db_table.".viewed_times", "DESC");
        return $this->lib_db->get_join_lang($this->db_table, $id = "" ,$lang = "" , $select_a , $select_b)
        ->result_array();
       
    }
    
    public function get_data_edit($type, $id){
        $id = decode_me($id);
        $this->db->limit(1);
    	return $this->db->get_where($this->db_table.$type, array('ID'=> $id)) -> row_array();
    }
    
    public function view_item($id){
    	
    	//$data =  $this->db->get_where($this->db_table, array('ID'=> $id)) -> row_array();
        
        $query = $this->db->query('
         SELECT p.*,'.$this->db_select_user.'
            FROM '.$this->db_table.' p            
            
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID

            WHERE p.ID = '.$id.'
            LIMIT 1
            ');
     	
        $data = $query -> row_array();
        
        
        if(!is_array($data) || count($data) == 0) redirect('page-not-found.html');
        $data['comments'] = $this->get_comment('question', $id);
        $data['answers'] = $this->get_answer($id);
        return $data;
    }
    
     public function same_item_by_tags($tags_id, $viewed = ''){
    	
        $query = $this->db->query("
        SELECT ".$this->select_show_item_small.','.$this->db_select_user."
            FROM ".$this->db_table." p
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            WHERE ".$this->lib_db->custom_find_in_set($tags_id, 'p.tags_id')."
            
            AND p.ID <> ".$viewed." 
            
         ORDER BY rand() LIMIT 4");
         
         return $query -> result_array();
       
    }
    public function same_topic($catid, $viewed = ''){ 
        
        $query = $this->db->query('
        SELECT '.$this->select_show_item_small.','.$this->db_select_user.'
            FROM '.$this->db_table.' p
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            WHERE p.catid = \''.$catid.'\'
            AND p.ID <> '.$viewed.'
            
         ORDER BY p.ID DESC LIMIT 10 ');
     	
        return $query -> result_array();
       
    }
    
    public function get_answer($id)
    {        
         $query = $this->db->query('
         SELECT p.*,'.$this->db_select_user.'
            FROM '.$this->db_table.'_answer p            
            
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            
            
            WHERE p.FID = '.$id.'
            
            '.$this->get_sort('answersort') );
     	
        $arrs = $query -> result_array();
        
        if(!is_array($arrs) || count($arrs) == 0) return array();
        
        foreach($arrs as $i => $row)
        {
            $arrs[$i]['comment'] = $this->get_comment('answer', $row['ID']);
        }
        return $arrs;
        
    }
    public function get_comment($type, $id)
    {
        //$arrs = $this->db->get_where($this->db_table .'_comment' , array("type" => $type , "FID" => $id) )->result_array();
        
        $query = $this->db->query('
         SELECT p.*,'.$this->db_select_user.'
            FROM '.$this->db_table.'_comment p            
            
            LEFT JOIN mod_user u 
            ON p.user_id = u.ID
            
            WHERE p.FID = '.$id.' AND p.type = \''.$type.'\' 
            ORDER BY p.ID ASC
            ' );
     	//print $this->db->last_query();
        $arrs = $query -> result_array();
        
        if(!is_array($arrs) || count($arrs) == 0) return array();    
        return $arrs;    
    }
    
    function ajax_search()
    {
        //$showed = $_GET['showed'];
        //$catid = $_GET['catid'];
        $limit = $_GET['limit'];
        $key = trim($_GET['key']);
        
        $this->db->select("*");
        $this->lib_db->create_query_search('tieu_de,alias' , $key);
        //$this->db->where("FID = '".$catid."' ");
        
        $this->db->limit($limit); 
        //echo  $this->db->last_query();
        return $this->db->get($this->db_table) -> result_array();
                
        
    }
    private function get_user_votes($db_table, $id, $col = 'user_votes')
    {
        $this->db->select($col); 
        $r = $this->db->get_where($this->db_table.$db_table, array('ID' => $id)) -> row_array();
        return $r;
    }
   
    private function remove_from_list($list, $val)
    {
        foreach($list as $i => $v)
        {
            if($val == $v || $v == "")
            unset($list[$i]);
        }
        return array_values($list);// 1,4,5     // 2,66
    }
   
    function vote($val, $type = 'vote_up')
    {
        $data = array();
        
        $temp = preg_split('/_/', $val);
        $user_id = $this->session->userdata('ID');
        
        $after_fix = ($temp[0] == 'questions') ? '' : '_answer';
       
        $r = $this->get_user_votes($after_fix, $temp[1], 'user_votes,user_votes_down,user_id');
       
        $user_votes = $r['user_votes'];
        $user_votes_down = $r['user_votes_down'];
        
        $own_user_id =  $r['user_id'];
       
        
        $list_user_voted = preg_split('/,/', $user_votes); 
        $list_user_voted_down = preg_split('/,/', $user_votes_down);
        
        $list_user_voted = $this->remove_from_list($list_user_voted, '');
        $list_user_voted_down = $this->remove_from_list($list_user_voted_down, '');
        
        //print_r ($user_votes);
        //return; 
            if($type == 'vote_up')
            {
                if(in_array($user_id, $list_user_voted))
                {
                    $list_user_voted = $this->remove_from_list($list_user_voted, $user_id);
                    $list_user_voted_down = $this->remove_from_list($list_user_voted_down, $user_id);
                    $data['active'] = false;
                }
                else
                {
                    $list_user_voted[] = $user_id;
                    $list_user_voted_down = $this->remove_from_list($list_user_voted_down, $user_id);
                    $data['active'] = true;
                }
            }
            else if($type == 'vote_down')
            {
                if(in_array($user_id, $list_user_voted_down))
                {
                    $list_user_voted = $this->remove_from_list($list_user_voted, $user_id);
                    $list_user_voted_down = $this->remove_from_list($list_user_voted_down, $user_id);
                    $data['active'] = false;
                }
                else
                {
                    $list_user_voted_down[] = $user_id;
                    $list_user_voted = $this->remove_from_list($list_user_voted, $user_id);
                    $data['active'] = true;
                }
            }
        
        $n_votes = count($list_user_voted) - count($list_user_voted_down);
        
        
        // Cap nhat lai thong tin vao db
        $db_data = array(
        'n_votes' => $n_votes
        ,'user_votes' => implode(',', $list_user_voted)
        ,'user_votes_down' => implode(',', $list_user_voted_down)
        );	
        //print_r ($list_user_voted);
        
        $question_id = ($after_fix != '') ? $this->question_id_by_answer($temp[1]) : $temp[1] ;
        
        $this->lib_cache->clear_cache_json($this->cache_method, $question_id);
        
        $this->db->where("ID", $temp[1] );
        $this->db->update($this->db_table.$after_fix, $db_data);
        $data['n_votes'] =  $n_votes;
        
        
        $this->lib_stat_question->re_stat_user_score($own_user_id);
        
        return $data;
    }
    function bookmark($val)
    {
        $data = array();
        
        $temp = preg_split('/_/', $val);
        $user_id = $this->session->userdata('ID');
       
        $this->db->select('bookmarks'); 
        $r = $this->db->get_where('mod_user', array('ID' => $user_id)) -> row_array();
        
        $bookmarks = preg_split('/,/', $r['bookmarks']);
        
        $bookmarks = $this->remove_from_list($bookmarks, '');
        
        $this->lib_cache->clear_cache_json($this->cache_method, $temp[1]);
        
        if(in_array($temp[1], $bookmarks))
        {
            $bookmarks = $this->remove_from_list($bookmarks, $temp[1]);
            $data['active'] = false;
        }
        else
        {
            $bookmarks[] = $temp[1];
            $data['active'] = true;
        }
        
        $str_bookmark = implode(',', $bookmarks);
        $this->session->set_userdata('bookmarks', $str_bookmark);
        
        $db_data = array(
        'bookmarks' => $str_bookmark
        );	
        //print_r ($list_user_voted);
        
        $this->db->where("ID", $user_id );
        $this->db->update('mod_user', $db_data);
        
        return $data;
    }
    function save_comment()
    {
        $this->load->library('lib_convert');
        $val = $this->input->post('val');
        
        $type = $this->input->post('type');
        if(trim($val) == "") return -1;
        $type = preg_split('/_/', $type);
        
        $question_id = ($type[0] == 'answer') ? $this->question_id_by_answer($type[1]): $type[1]; 
        $this->lib_cache->clear_cache_json($this->cache_method, $question_id);
        
        
        $db_data = array(
        'type' => $type[0]
        ,'FID' => $type[1]
        ,'noi_dung' => $this->lib_convert->ucfirst(trim($val))
        ,'user_id' => $this->session->userdata('ID')
        );
       	$this->db->insert($this->db_table."_comment" , $db_data);
        $insert_id = $this->db->insert_id();
        
        $this->save_user_notes($this->input->post('notes_data'), $insert_id, $action_name = "đã bình luận");
        
        return $insert_id;
        
    }
    function save_user_notes($notes_data, $insert_id, $action_name = 'đã trả lời')
    {
        $notes_data = decode_me($notes_data); 
        $notes_data = preg_split('/;/', $notes_data);
        
        $hash_id = ($action_name == 'đã trả lời') ? 'answer'.$insert_id : 'icomment'.$insert_id;
        
        $db_data = array(
            'user_id_from' => $this->session->userdata('ID')
            ,'user_id_to' => $notes_data[0]
            ,'tieu_de' => $notes_data[3]
            ,'action_name' => ($notes_data[1] == 'question') ? $action_name.' câu hỏi' : $action_name.' trả lời trong '
            ,'link' => $notes_data[2].'#'.$hash_id
        );
        $this->db->insert('mod_user_notes', $db_data);
    }
    function del_comment($id, $type)
    {
        
        if(!$this->lib_auth->check_permission()) return false;
        
        if($type == 'answer'){
            $this->db->where(array('FID'=>$id, 'type'=> $type) );	
            $this->db->delete($this->db_table.'_comment');    
        }
        else
        {
            $this->db->select("ID");
            $rows = $this->db->get_where($this->db_table.'_answer', array('FID' => $id )) -> result_array();
            // Xoa binh luan cua cau tra loi
            foreach($rows as $rows)
            {
                $this->db->where(array('FID'=>$rows['ID'], 'type'=> 'answer') );	
                $this->db->delete($this->db_table.'_comment');   
            }
            // Xoa binh luan cua cau hoi
            $this->db->where(array('FID'=>$id, 'type'=> 'question') );	
            $this->db->delete($this->db_table.'_comment');  
        }
        
        return true;
    }
    function del_comment_byid($id, $question_id = '')
    { 
        $id = decode_me($id);
        if(!$this->lib_auth->check_permission()) return false;
         
        $this->lib_cache->clear_cache_json($this->cache_method, $question_id);
        $this->db->where(array('ID'=>$id) );	
        $this->db->delete($this->db_table.'_comment');    
        return true;
    }
}



