<?php 
$data_filter = array(
'title' => $title
,'tabs' => 
    array('newest' => 'mới nhất'
    ,'oldest' => 'cũ nhất'
    ,'vote' => 'bình chọn'
    ,'answer' => 'trả lời nhiều'
    ,'unanswer' => 'chưa trả lời'
    )
,'name_order' => 'sort'
,'hash' => ''
); ?>
<div class="mod_questions after">
    <div class="left_child_page">
        <div class="question_count">
            <span class="block number"><?php echo number_format($nRow) ?></span>
            <span class="color33">câu hỏi</span>
        </div>
        <div class="bags_catagory">
            <h6 class="title color44">Theo chủ đề</h6>
            <?php echo $this->lib_menu->menu_frontend_sitemap(65, 'questions'); ?>
        </div>
    </div>

    <div class="body_child_page">
    <?php $this->load->view('ext_filter/tab_questions', $data_filter);?>
    <?php if(!empty($tag_description)){ ?><h2 class="f_font1 desc_tags"><?php echo $tag_description ?></h2> <?php } ?>
    
    <ul class="show_items">
    <?php foreach($items as $row){ 
    	$this->load->view("general_show_item", $row);
     ?>
    <?php } ?>
    </ul>
    <?php echo $split_page;?>
    <br />
    <?php $this->load->view('html/bottom_show_items');?>
    </div>



<div class="child_right_page">    
    <?php $hot_tags =  $this->lib_tags->show_hot_tags(@$catid); 
    if($hot_tags != ""){ ?>
        <h6 class="title color44">Tag nổi bật</h6>
        <div class="tags_block">
        <?php echo $hot_tags ?>
        </div>
    <?php } ?>
    
    <?php //echo $this->lib_adv->show_adv('right_col', 0 , 'class="mg_10_0"'); ?>
    
    <?php $this->load->module('questions')->block_hot_questions() ?>

    
</div>



</div>