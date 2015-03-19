<?php $hinh_anh = $this->lib_media->show_crop("spage" ,$images, 296, 130); ?>
<div class="mod_spage in_home after">
<h2 class="title">Giới thiệu về chúng tôi</h2>

<div class="contents">
<img src="<?php echo $hinh_anh?>" alt="<?php echo $tieu_de?>" />
<?php echo $description;

$link = base_url('spage/'.$this->lib_alias->convert2Alias($tieu_de).'-'.$ID.'.html' );
?>
</div>
</a><span class="block"><a class="button_viewmore" href="<?php echo $link; ?>">Xem thêm</a></span>
</div>
