<?php $this->load->view('html/welcome'); ?>
<div id="" class="filter_tab_question notab after">
<h1 class="f_font1"><?php echo $title ?></h1>
<div class="right">
    <a class="active" title="<?php echo $title ?>" href="<?php echo base_url('questions') ?>/" rel="nofollow">xem tất cả câu hỏi</a>
</div>
</div> 
<div class="mod_questions in_home after">

<div class="body_child_page">
<?php echo $this->lib_adv->show_adv('body_1_home', 0 , 'class=""', true); ?>
<?php foreach($items as $row){ 
	?>
    <h2 class="cata_items_in_home"><a title="<?php echo $row['tieu_de'] ?>" href="<?php echo base_url('questions/'.$row['alias']) ?>/"><?php echo $row['tieu_de'] ?></a>
    <a class="right" href="<?php echo base_url('questions/'.$row['alias']) ?>/" rel="nofollow">xem thêm</a>
    </h2>
    <ul class="show_items">
    <?php
    foreach($row['questions'] as $questions)
    { 
        unset($questions['description']);
        $this->load->view("general_show_item", $questions);
    }
    ?>
    </ul>
<?php } ?>
<br />
<?php $this->load->view('html/bottom_show_items');?>
</div>

<div class="child_right_page">
     <?php //echo $mod_user->block_login_small() ?>
     <div id="ui_user_login_small"></div>
    <?php echo $this->lib_adv->show_adv('right_col', 0 , 'class="mg_10_0"', true); ?>
    <div class="bags_catagory">
    <h6 class="title color44 title_bg">Theo chủ đề</h6>
    <?php echo $this->lib_menu->menu_frontend_sitemap(65, 'questions'); ?>
    </div>
    
    <?php $this->load->module('questions')->block_hot_questions() ?>

    
</div>



</div>