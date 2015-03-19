<?php 
//$this->carabiner->js('https://apis.google.com/js/plusone.js');
$this->carabiner->js('js/code/run_prettify.js');
 ?>
<!--script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script-->
<div class="mod_questions view_item">
<h1 class="title_view_questions f_font1" itemprop="name">
<a href="<?php echo $this->lib_url->getUrl() ?>" class="color00" title="<?php echo $tieu_de; ?>"><?php echo $tieu_de; ?></a>
</h1>

<!--div class="general after">
	
    <?php //$this->load->view("social_plugins/facebook_like_button"); ?>
    <a class="button_answer hover_opa" href="#form_answer">
    <span class="number"><?php echo $n_answers ?></span>
    <span class="text">Trả lời</span>
    </a>
</div-->

<?php echo $this->lib_adv->show_adv('body_1_detail', 0 , 'class=""', true); ?>

<div class="contents_view after">
    <?php 
    $active_up = in_array_to_active($this->session->userdata('ID'), $user_votes);
    $active_down = in_array_to_active($this->session->userdata('ID'), $user_votes_down);
    $active_bookmark = in_array_to_active($ID, $this->session->userdata('bookmarks') );
     ?>
<div class="after">
    
<div class="main_content question">
<div class="after">    
       <div class="nd" itemprop="description"><?php echo $noi_dung;?></div>
       <div class="tags_inline"><?php $show_tags_inline =  $this->lib_tags->show_tags($tags_id, true); echo  $show_tags_inline  ?></div>
       
       <?php
       
    $this_link = $this->lib_url->getUrl();
    $link_back = base64_encode($this->lib_url->getUrl());
    $html_edit = '';
    if($this->lib_auth->check_permission($user_id))
    {
            $html_edit .= "<span>|</span><a href='".base_url('questions/ask/'.encode_me($ID))."?return=".$link_back."'>chỉnh sửa</a> <span>|</span> ";
            $html_edit .= "<a href='".base_url('questions/del/'.encode_me($ID))."' class='del'>xóa</a>";
            
              $return  = base64_encode($this->lib_url->getUrl(true) );
            $html_edit .= " | <a t_title = 'Bật hoặc mở chức năng cho phép trả lời câu hỏi' href='".base_url('questions/set_closed/'.encode_me($ID))."?return=".$return."' >Mở/đóng trả lời</a>";
    }
    
       ?>
 
 
 
<div class="share_or_edit ">
<a href="<?php echo base_url('user/'.$user_ID) ?>"><?php echo $user_full_name ?></a>
<?php echo $html_edit; ?>

<span class="gray"> – đăng <?php echo $this->lib_date->ago($date_add) ?><span id = "date_of_aticle" class="hidden"><?php echo $date_add?></span>
<?php if($date_add != $date_edit) echo ", sửa ". $this->lib_date->ago($date_edit) ?>
</span>
</div>
</div>

<?php $this->load->view('item_comments', array(
       'item_comments' => $comments
       ,'type' => 'question'
       ,'id' => $ID
       ,'user_topic' => $user_id
       ));
?>
<br />
<?php $this->load->view("same_topic_by_tags") ; ?> 
<g:plusone size="medium"></g:plusone>
<?php $this->load->view('social_plugins/facebook_like_and_share_button'); ?>
</div>



</div>
    
    <?php if(count($answers)){
        
        foreach($answers as $i => $temp)
        {
            if($temp['exactly'])
            {
                $t = array($temp);
                unset($answers[$i]);
                array_unshift($answers, $temp);
                $answer = array_values($answers);
                break;
            }
        }
        
        $this->load->view('item_answers', array('item_answers' => $answers));
    } ?>
    
</div>
<?php 
if(!@$closed){

if(!$exactly){
$this_link = $this->lib_url->getUrl(true);
?>
<div class="clearfix box_welcome">
    <h5 class="font15">Bạn biết ai có thể trả lời câu hỏi này <?php if(count($answers)) echo "tốt hơn"; ?>, hãy chia sẻ câu trả lời này hoặc gửi qua 
    <a target="_blank" href="http://www.facebook.com/share.php?u=<?php echo $this_link ?>" rel="nofollow" t_title="Chia sẽ lên facebook" class="facebook">Facebook</a>
     hoặc <a  target="_blank" href="http://twitter.com/home?status=?u=<?php echo $this_link ?>" rel="nofollow" t_title="Chia sẽ lên Twitter" class="twitter">Twitter</a> hoặc 
    <a  target="_blank" href="https://plus.google.com/share?url=<?php echo $this_link ?>" rel="nofollow" t_title ="Chia sẽ lên Google+" class="google">Google+</a>
    </h5>
</div>
        <?php
    } ?>

<?php $this->load->view('form_answer', array('FID' => $ID, 'user_question_id' => $user_ID )); 
} else {
?>

<div class="clearfix form_answer_unlogin">
    <h5 class="font15">Câu hỏi hoặc bài viết này đã được đóng và không được phép đăng câu trả lời vì đã có câu trả lời chính xác nhất hoặc là bài viết chia sẻ. Tuy nhiên, bạn có thể bình luận cho câu này.</h5>
</div>

<?php } ?>

<br />
<?php $this->load->view('social_plugins/facebook_comment'); ?>
<h2 class="font15 pd_0_10 f_font1">Bạn chưa tìm thấy câu trả lời? Hãy thử tìm thêm trong các tag 
<?php echo  $show_tags_inline  ?>
 hoặc 
<a href="<?php echo base_url('questions/ask') ?>">đặt một câu hỏi</a>
</h2>


</div>



        
<div class="form_share_abso hidden">
<span class="block text_type"></span>
<input class="input_text" value="" />

<div class="social">
<a target="_blank" href="" rel="nofollow" t_title="Chia sẽ lên facebook" class="facebook"></a>
<a target="_blank" href="" rel="nofollow" t_title="Chia sẽ lên Twitter" class="twitter"></a>
<a target="_blank" href="" rel="nofollow" t_title ="Chia sẽ lên Google+" class="google"></a>
</div>
<a href="javascript:void(0)" class="rfloat mg_right_10" onclick="$('.form_share_abso').hide()">đóng</a>
</div> 