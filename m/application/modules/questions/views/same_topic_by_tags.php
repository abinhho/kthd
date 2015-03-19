<?php if(count($items_same_by_tags)): ?>
<div class="mod_questions small_items by_tags">
<ul>
<?php 

foreach($items_same_by_tags as $row){
    
    $alias = (trim($row['alias']) != '') ? $row['alias'] : $row['tieu_de']; 
	$link = $this->lib_menu->make_link(array( "questions" => $row['catid'] ) , array($row['ID'] => $alias ) );
 ?>
  <li><a href="<?php echo $link; ?>" title = "<?php echo $row['tieu_de']; ?>"><?php echo $row['tieu_de']; ?></a> 
        <span class="font12 color44">– <span class="gray"><?php echo $row['viewed_times'] ?> lượt xem</span></span></li>
        
<?php } ?>
</ul>
</div>

<?php endif; ?>