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

<div class="mod_questions form_seach_inpage">
<h2 class="font18 f_font1 mg_bottom_10">Tìm kiếm:</h2>
<?php 
echo form_open('questions/create_search', 'id=form_search onsubmit=" if(this.q.value == \'\' ) return false; "  class="accept_enter"');
echo form_input('q', str_replace("+"," ",$this->lib_url->_GET('q')) , "placeholder = 'từ khóa tìm kiếm' class='q'");
echo form_submit('submit','Tìm kiếm', "class='submit button'");
echo form_close(); ?>
</div>


<div class="left_child_page">
    <div class="question_count">
        <span class="block number"><?php echo number_format($nRow) ?></span>
        <span class="color33">câu hỏi</span>
    </div>
</div>

    
<div class="body_child_page">

    <?php $this->load->view('ext_filter/tab_questions', $data_filter);?>
    <ul class="show_items">
    <?php foreach($items as $row){ 


    $link = $this->lib_menu->make_link(array('questions' => $row['catid']) , array($row['ID'] =>  $row['tieu_de']) );

    $n_answers = ( $row['n_answers'] == "") ? 0: $row['n_answers'];
    $ans_class= ($row['n_answers'] != 0) ? 'has_ans' : ''; 

    //$hinh_anh = $this->lib_media->show_crop("questions" ,$images, 160, 120);
    ?>
    <li class="after" itemscope itemtype="<?php echo $link;?>">

    <a class="title f_font1" href="<?php echo $link ?>"><?php echo $row['tieu_de'] ?></a>
    <div class="desc font13"><?php echo $row['description'] ?></div>

    <div class="rfloat font13 mg_top_10">
        <span class="gray"><i class="sprites question opa"></i><?php echo $this->lib_date->ago($row['date_add'])?></span> - 
        <a href="<?php echo base_url('user/'.$row['user_ID']) ?>"><?php echo $row['user_full_name'] ?></a>
    </div>

    </li>



    <?php }  ?>
    </ul>
    <?php echo $split_page;?>
    <br />
    <?php $this->load->view('html/bottom_show_items');?>
</div>

<div class="child_right_page">    
    <?php $this->load->module('questions')->block_hot_questions() ?>    
</div>



</div>


