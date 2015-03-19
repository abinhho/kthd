<?php 

$alias = (trim($alias) != '') ? $alias : $tieu_de; 
$link = $this->lib_menu->make_link(array('backlink' => '') , array($ID => $alias) );

//$hinh_anh = $this->lib_media->show_crop("questions" ,$images, 160, 120);
?>
<li class="after" itemscope itemtype="<?php echo $link;?>">
<div class="right relative">
    <h3><a class="title" target="_blank" href="<?php echo base_url('/backlink/click/'.$ID) ?>" title="<?php echo $tieu_de ?>"><?php echo $tieu_de ?></a></h3>
    <div class="desc">
    
        <?php if(isset($description)){ ?>
        <p class="text_desc">
        <?php echo $description ?>
        <a class="button_viewmore" href="<?php echo $link ?>">xem tiếp</a>
        </p>
        <?php } ?>
        <!--i class="sprites stat"></i-->
        
        <span class="color2"><?php echo $clicked?> click</span>
        <span class="gray"><?php echo $viewed_times?> lượt xem </span>
         – <span>đăng bởi <a   class="tooltip_userinfo" data-id="<?php echo $user_ID ?>" href="<?php echo base_url('user/'.$user_ID) ?>"><?php echo $user_full_name ?></a></span>
        – <span><?php echo $this->lib_date->ago($date_add)?> – <?php echo $this->lib_url->link2domain($url); ?>
        <?php if($date_add != $date_upd) echo ", cập nhật lại ". $this->lib_date->ago($date_upd) ?>
        </span>
    </div>
</div>
	
</li>