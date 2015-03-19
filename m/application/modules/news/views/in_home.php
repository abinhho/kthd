<h2>Bài viết gần đây</h2>
<div class="mod_news in_home after">
<ul>
<?php foreach($items as $row){ 
	$link = $this->lib_menu->make_link(array($row['catid'] => "") , array($row['ID'] => $row['tieu_de']) );
 ?>
<li>
<a href="<?php echo $link; ?>"><?php echo $row['tieu_de']; ?></a></li>
<?php } ?>
</ul>
</div>
</a><span class="block"><a class="button_viewmore" href="<?php echo base_url('/58/tin-tuc.html'); ?>">Xem thêm</a></span>