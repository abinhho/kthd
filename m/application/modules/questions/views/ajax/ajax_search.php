<?php 
if(count($items) == 0) exit;
?>
<h5 class="font14 title_view_questions f_font1">Các câu được đề xuất giống với câu của bạn.</h5>
<div class="mod_questions small_items">
<ul>
<?php foreach($items as $row){
    $alias = (trim($row['alias']) != '') ? $row['alias'] : $row['tieu_de']; 
	$link = $this->lib_menu->make_link(array( "questions" => $row['catid'] ) , array($row['ID'] => $alias ) );
 ?>
<li><a href="<?php echo $link; ?>"><?php echo $row['tieu_de']; ?></a> - <span class="gray"><?php echo $row['n_answers'] ?> trả lời</span></li>
<?php } ?>
</ul>
</div>