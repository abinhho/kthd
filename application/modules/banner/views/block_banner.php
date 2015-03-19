<div class="mod_banner after">
<div class="contents after">
    <div class="logo">
        <a href="<?php echo base_url(); ?>" title="<?php echo SHORT_DESCRIPTION?>"><?php echo $this->lib_media->show($images, $width, $height); ?></a>
    </div>
    <div class="menu_banner">
        <ul><li class="<?php echo active_menu('questions') ?>"><a href="<?php echo base_url('/questions')?>">Câu hỏi mới</a></li>
        <li class="<?php echo active_menu('unanswers') ?>"><a href="<?php echo base_url('/questions/unanswers')?>">Chưa trả lời</a></li>
        <li class="<?php echo active_menu('catagory') ?>"><a href="javascript:void(0)" rel="nofollow">Chủ đề</a>
            <?php 
            echo $this->lib_menu->menu_frontend_sitemap(65, 'questions'); ?>
        </li>
        <li class="<?php echo active_menu('tags') ?>"><a href="<?php echo base_url('/tags')?>">Tags</a></li>
        <li class="<?php echo active_menu('user') ?>"><a href="<?php echo base_url('/user')?>">Thành viên</a></li>
        <a href="<?php echo base_url('/questions/ask')?>" style="margin-top: -5px;" class="button_green rfloat">+ Đặt câu hỏi</a>
        </ul>
    
    </div>
</div>
</div>
