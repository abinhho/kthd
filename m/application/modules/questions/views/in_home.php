<?php $this->load->view('html/welcome'); ?>
<div id="" class="filter_tab_question notab after">
<h1 class="f_font1"><a  href="<?php echo base_url('questions') ?>/" rel="nofollow"><?php echo $title ?></a></h1>
</div> 
<div class="mod_questions in_home after">


<?php //echo $this->lib_adv->show_adv('body_1_home', 0 , 'class=""', true); ?>
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