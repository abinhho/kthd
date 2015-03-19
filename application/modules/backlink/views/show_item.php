<?php 
$data_filter = array(
'title' => $title
,'tabs' => 
    array('newest' => 'mới nhất'
    ,'oldest' => 'cũ nhất'
    ,'clicked' => 'Click nhiều'
    ,'viewed' => 'Xem nhiều'
    )
,'name_order' => 'sort'
,'hash' => ''
); ?>
<div class="mod_backlink after">
<div class="body_child_page">

<?php $this->load->view('ext_filter/tab_questions', $data_filter);?>
<ul class="show_items">
<?php foreach($items as $row){ 
	$this->load->view("general_show_item", $row);
 ?>
<?php }  ?>
</ul>
<?php echo $split_page;?>
<br />
<?php //$this->load->view('html/bottom_show_items');?>
</div>

<div class="child_right_page">
    <?php //echo $mod_user->block_login_small() ?>
    <div id="ui_user_login_small"></div>
    
    <?php echo $questions ->block_hot_questions() ?>

    
</div>



</div>


