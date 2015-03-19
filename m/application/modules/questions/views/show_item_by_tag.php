<?php 
$data_filter = array(
'title' => $title
,'tabs' => 
    array('newest' => 'mới nhất'
    ,'oldest' => 'cũ nhất'
    ,'vote' => 'bình chọn'
    ,'answer' => 'trả lời nhiều'
    )
,'name_order' => 'sort'
,'hash' => ''
); 
$this->load->view('ext_filter/tab_questions', $data_filter);?>
<div class="mod_questions after">

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