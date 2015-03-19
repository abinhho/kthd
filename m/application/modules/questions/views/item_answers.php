<?php 
$data_filter = array(
'title' => count($item_answers) . ' trả lời'
,'tabs' => 
    array('newest' => 'mới nhất'
    ,'oldest' => 'cũ nhất'
    ,'vote' => 'bình chọn nhiều '
    )
,'name_order' => 'answersort'
,'hash' => 'item_answers'
,'heading_tag' => 'h2'
); 
$this->load->view('ext_filter/tab_questions', $data_filter);
//print_r ($item_answers); exit;
?>
<?php foreach($item_answers as $row) {
     
    $active_up = in_array_to_active($this->session->userdata('ID'), $row['user_votes']);
    $active_down = in_array_to_active($this->session->userdata('ID'), $row['user_votes_down']);
    
    ?>
<div class="contents_view answer after" id="answer<?php echo $row['ID'] ?>">    
     
       
       <div class="main_content">    
       <div class="nd after"><?php echo $row['noi_dung'];?>
       
       <?php       
       $this_link = $this->lib_url->getUrl();
       $t = preg_split('/#/',$this_link); 
       $this_link = $t[0].'#answer'.$row['ID'];
       
       $html_edit = '';
       $link_back = base64_encode($this_link);
       if($this->lib_auth->check_permission($row['user_id']) && !$row['exactly'])
       { 
            
            $html_edit .= "<span>|</span><a href='".base_url('questions/edit-answer/'.encode_me($row['ID']))."?return=".$link_back."'>chỉnh sửa</a> <span>|</span> ";
            $html_edit .= "<a href='".base_url('questions/del-answer/'.encode_me($row['ID']))."' class='del'>xóa</a>";
       }
       if($this->session->userdata('level') >0 )
       {
            $return  = base64_encode($this->lib_url->getUrl(true) . '#answer'.$row['ID'] );
            $html_edit .= " | <a href='".base_url('questions/set_exactly/'.encode_me($row['ID']))."?return=".$return."' >Duyệt/hủy duyệt</a>";
       }
       
        ?>
      
        
<div class="share_or_edit">
<a href="<?php echo base_url('user/'.$row['user_ID']) ?>"><?php echo $row['user_full_name'] ?></a>
<?php echo $html_edit; ?>

<span class="gray"> – đăng <?php echo $this->lib_date->ago($row['date_add']) ?>
<?php if($row['date_add'] != $row['date_edit']) echo ", sửa ". $this->lib_date->ago($row['date_edit']) ?>
</span>
</div>
        
 </div> 
       <?php $this->load->view('item_comments', array(
       'item_comments' => $row['comment']
        ,'type' => 'answer'
       ,'id' => $row['ID']
       ,'exactly' => $row['exactly']
       ,'user_topic' => $row['user_id']
       )); 

       
       ?>
       

       
       
       </div>
</div>
<?php } ?>
<br />

