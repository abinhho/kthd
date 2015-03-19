<?php 
$data_filter = array(
'title' => '<span class="gray">'.number_format($nRow).' – </span>'.$title
,'tabs' => 
    array('newest' => 'mới nhất'
    ,'oldest' => 'cũ nhất'
    ,'vote' => 'bình chọn'
    ,'answer' => 'trả lời nhiều'
    )
,'name_order' => 'sort'
,'hash' => ''
); ?>
<div class="mod_questions in_home after">

<?php $this->load->view('ext_filter/tab_questions', $data_filter);?>
<ul class="show_items">
<?php foreach($items as $row){ 
	$this->load->view("general_show_item", $row);
 ?>
<?php }  ?>
</ul>
<?php echo $split_page;?>
<br />
<?php $this->load->view('html/bottom_show_items');?>
</div>


