<?php 
$link = $this->lib_menu->make_link(array($catid => "") , array($ID => $tieu_de) );
$hinh_anh = $this->lib_media->show_crop("albums" ,$images, 200, 200); 
?>
<li class="after" itemscope itemtype="<?php echo $link;?>">
	<?php if($images){ ?>
	<div class="large_img_shadow"><a href="<?php echo $link; ?>"><img border="0" class="main"  alt="<?php echo $tieu_de; ?>" src="<?php echo $hinh_anh ; ?>"></a></div>
	<?php } ?>
    
	<div class="right">
    <a title="<?php echo $tieu_de; ?>" class="hover_color block" href="<?php echo $link; ?>">
		<?php echo $tieu_de; ?></a><span class="gray"><?php  echo $this->lib_date->ago($date_upd); ?></span>
		
			<a class="view_more italic main_color" href="<?php echo $link; ?>">Xem chi tiết</a>
		
	</div>
</li>