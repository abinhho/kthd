<div class="block_menu_top after">
<div class="contents_980">
    <div class="line_1 after">
        <a class="logo lfloat" href="<?php echo base_url() ?>"><img src="<?php echo base_url('assets/images/kienthuchoidap_logo.png') ?>" /></a>
        <?php $this->load->view('questions/html/form_search_top'); ?>
        <ul class="head_account">
        <?php echo substr(substr($html_menu, 4), 0, -5) ?>
        <?php $this->load->view('user/block_header_account'); ?>
        <a href="<?php echo base_url('/questions/ask')?>" style="margin-top: 6px;" class="button_green rfloat"><i class="fa fa-question-circle"></i> Đặt câu hỏi</a>
        </ul>
    </div>
    <!--div class="line_2 menu_after_top after">
        <ul><li class="<?php echo active_menu('home') ?>"><a href="<?php echo base_url()?>">Trang chủ</a></li>
        <ul><li class="<?php echo active_menu('questions') ?>"><a title="Câu hỏi mới" href="<?php echo base_url('/questions')?>">Câu hỏi mới</a></li>
        <li class="<?php  echo active_menu('unanswers') ?>"><a title="Câu hỏi chưa trả lời" href="<?php echo base_url('/questions/unanswers')?>">Chưa trả lời</a></li>
        <li class="<?php echo active_menu('catagory_tags') ?>"><a href="<?php echo base_url('/tags')?>/" rel="nofollow">Chủ đề, tags</a>
            <?php 
            //echo $this->lib_menu->menu_frontend_sitemap(65, 'questions'); ?>
        </li>
        <li class="<?php echo active_menu('user') ?>"><a href="<?php echo base_url('/user')?>/">Thành viên</a></li>
        <a href="<?php echo base_url('/questions/ask')?>" style="margin-top: 6px;" class="button_green rfloat">+ Đặt câu hỏi</a>
        </ul>
    </div-->
</div>
</div>