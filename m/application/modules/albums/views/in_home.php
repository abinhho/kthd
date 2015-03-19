<h2>Các hình ảnh gần đây</h2>
<div class="mod_albums in_home after">
<ul>
<?php
$images = array(); 
foreach($items as $row){ 
    
    $t = preg_split('/,/', $row['images']);
    if(is_array($t))
    foreach($t as $img)
    {
        if($img!="")
        $images[] = $img;
    }
}

foreach($images as $i => $img){ 
    $hinh_anh = $this->lib_media->show_crop("albums" ,$img, 70, 70);
    if($i == 12) break;
 ?>
<li><a rel="lightbox" href="<?php echo base_url('/images/albums/'.$img)?>"> <img src="<?php echo $hinh_anh?>" /></a></li>
<?php } ?>
</ul>
</div>
</a><span class="block"><a class="button_viewmore" href="<?php echo base_url('/65/albums.html'); ?>">Xem thêm</a></span>