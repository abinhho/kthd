<br />
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
,'heading_tag' => 'h3'
); 
$this->load->view('ext_filter/tab_questions', $data_filter);
//print_r ($item_answers); exit;
?>
<?php foreach($item_answers as $i => $row) {
     
    $active_up = in_array_to_active($this->session->userdata('ID'), $row['user_votes']);
    $active_down = in_array_to_active($this->session->userdata('ID'), $row['user_votes_down']);
    $user_thumb = $this->lib_media->show_crop("user" ,$row['user_images'], 20, 20);
    $lastClass = (($i+1) == count($item_answers)) ? 'last' : '';
    ?>
<div class="contents_view answer <?php echo $lastClass ?> after" id="answer<?php echo $row['ID'] ?>">
    <a href="<?php echo base_url('user/'.$row['user_ID']) ?>" class="img_user">
        <img data-original="<?php echo $user_thumb ?>" width="20" height="20" class="lazy" title="<?php echo $row['user_full_name'] ?>" />
    </a>
    <a class="tooltip_userinfo bold" data-id="<?php echo $user_ID ?>" href="<?php echo base_url('user/'.$row['user_ID']) ?>"><?php echo $row['user_full_name'] ?></a>
    <span class="gray font12"> – đăng <?php echo $this->lib_date->ago($row['date_add']) ?>
        <?php if($row['date_add'] != $row['date_edit']) echo ", sửa ". $this->lib_date->ago($row['date_edit']) ?>
    </span>
    <span class="rfloat gray font12">#<?php echo ($i+1) ?></span>
    <div class="main_content after mg_top_10">    
        <div class="nd text_desc after"><?php echo str_replace('<p>&nbsp;</p>', '', trim($row['noi_dung']));?></div>
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
      
    <div class="after relative">
        <div class="vote_tool lfloat tcenter">
            <input type="hidden" name="_id_" value="answer_<?php echo $row['ID'] ?>" />
            <div class="bound_vote button_s1">
            <a href="javascript:void(0);" class=" <?php echo $active_up ?> sprites block votes vote_up" t_title_1="+1 bình chọn cho câu này"></a>
            <span class="block votes_of_acticle bold" id="answer_<?php echo $row['ID'] ?>"><?php echo $row['n_votes'] ?></span>
            </div>
            <a href="javascript:void(0);" class=" <?php echo $active_down ?> sprites hover_opa block votes vote_down" t_title_1="-1 bình chọn cho câu này"></a>
            <?php if($row['exactly']){ ?>
            <span class="sprites exactly" t_title_1="Câu trả lời này đã được duyệt"></span>
            <?php } ?>
       </div>
        <div class="share_or_edit">
            <a href="javascript:void(0)" onclick="return share_topic($(this),'answer', '<?php echo  $row['ID'] ?>' , '<?php echo $this_link ?>' )" t_title = "Chia sẻ ngay">
                <i class="fa fa-share-alt"></i> chia sẻ</a>
            <?php echo $html_edit; ?>
        </div>
    </div>    
        
 </div> 
       <?php
       $this->load->view('item_comments', array(
       'item_comments' => $row['comment']
        ,'type' => 'answer'
       ,'id' => $row['ID']
       ,'exactly' => $row['exactly']
       ,'user_topic' => $row['user_id']
       )); 

       
       ?>
       

       
       
</div>
<?php } ?>
<br />

