<?php 
//$this->carabiner->js('https://apis.google.com/js/plusone.js');
$this->carabiner->js('js/code/run_prettify.js');
 ?>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<div class="mod_questions view_item">
<div class="left_child_page">
    <h6 class="title">Thông tin</h6>
    <?php 
    $this->load->view('user/html/full_user_info', 
        array('w'=> 40, 'h'=>40
        ,'bg' => 'user_ask'
        ,'date_add' => $date_upd
        ,'itemprop' => 'itemprop = "author"'
     )); 
    ?>
    <div class="bags_catagory top_right clearfix mg_top_10">
    <?php echo $this->lib_menu->menu_by_ids($catid); ?>
    </div>
    <h6 class="title">Tags</h6>
    <div class="tags_block"><?php echo $this->lib_tags->show_tags($tags_id, false); ?></div>
    <h6 class="title">Thống kê</h6>
    <div class="gray font12">
        <span class="block mg_top_5">Đăng: <strong class="rfloat"><?php  echo $this->lib_date->ago($date_add); ?></strong></span>
        <?php if($date_add != $date_edit){ ?>
        <span class="block mg_top_5">Đã sửa: <strong class="rfloat"><?php  echo $this->lib_date->ago($date_edit); ?></strong></span>
        <?php } ?>
       <span class="block mg_top_5">Lượt xem: <strong  class="rfloat" style="margin-left: 13px;"><?php echo $viewed_times ?></strong></span>

    </div>
    <h6 class="title" style="margin-top: 10px;">Chia sẻ câu này</h6>
    <div style="margin-top: 10px;">
        <div class="fb-like" style="margin-top: 6px;" data-href="<?php echo $this->lib_url->getUrl(); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
        <div class="mg_top_10"><g:plusone size="medium"></g:plusone></div>
    </div>
</div>

<div class="body_child_page">
    <h1 class="title_view_questions f_font1" itemprop="name">
        <a href="<?php echo $this->lib_url->getUrl() ?>" title="<?php echo $tieu_de; ?>"><?php echo $tieu_de; ?></a>
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
               <div class="nd text_desc" itemprop="description"><?php echo str_replace('<p>&nbsp;</p>', '', trim($noi_dung));;?></div>
               <?php $show_tags_inline =  $this->lib_tags->show_tags($tags_id, true); //echo  $show_tags_inline  ?>
               <!--div class="tags_inline"></div-->

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


        <div class="after relative">
            <div class="vote_tool tcenter lfloat after">
                <input type="hidden" name="_id_" value="questions_<?php echo $ID ?>" />
                <div class="bound_vote button_s1">
                    <a href="javascript:void(0)" class=" <?php echo $active_up ?> sprites votes vote_up" t_title_1="+1 bình chọn cho câu này"></a>
                    <span class="font15 bold votes_of_acticle" id="questions_<?php echo $ID ?>"><?php echo $n_votes ?></span>
                </div>
                <a href="javascript:void(0)" class=" <?php echo $active_down ?> sprites block votes vote_down" t_title_1="-1 bình chọn cho câu này"></a>
                <a href="javascript:void(0)" class="sprites  <?php echo $active_bookmark ?>  block bookmark" id="bookmark_<?php echo $ID ?>" t_title_1="Đánh dấu"></a>
            </div>
            <div class="share_or_edit">
                <a href="javascript:void(0)" onclick="return share_topic($(this),'questions', '<?php echo $ID ?>', '<?php echo $this_link ?>' )" t_title = "Chia sẻ ngay"><i class="fa fa-share-alt"></i> chia sẻ</a>
                <i class="dot">•</i>
                <a href="#form_answer" title = "Trả lời câu hỏi này">trả lời</a>
                <?php echo $html_edit; ?>
        
                <span class="gray"> – đăng <?php echo $this->lib_date->ago($date_add) ?><span id = "date_of_aticle" class="hidden"><?php echo $date_add?></span>
                <?php if($date_add != $date_edit) echo ", sửa ". $this->lib_date->ago($date_edit) ?>
                </span>
            </div>
        </div>
               
        </div>
        <?php //$this->load->view("same_topic_by_tags") ; ?> 
        <?php //$this->load->view('social_plugins/facebook_like_and_share_button'); ?>
        </div>
</div>
<?php 
$this->load->view('item_comments', array(
   'item_comments' => $comments
   ,'type' => 'question'
   ,'id' => $ID
   ,'user_topic' => $user_id
));
?>
    
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
<h2 class="font15 line_h2 f_font1">Bạn chưa tìm thấy câu trả lời? Hãy thử tìm thêm trong các tag 
<?php echo  $show_tags_inline  ?>
 hoặc 
<a href="<?php echo base_url('questions/ask') ?>">đặt một câu hỏi</a>
</h2>



</div>



<div class="child_right_page color55">
     <?php //echo $mod_user->block_login_small() ?>
    <div id="ui_user_login_small"></div>    
    <?php //echo $this->lib_adv->show_adv('right_col', 0 , 'class="mg_10_0"', true); ?>
    
    <?php $this->load->view("same_topic", $items_same_topic) ; ?>
    <?php //$this->load->module('questions')->block_hot_questions() ?>
</div>

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
