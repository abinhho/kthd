<div class="mod_questions">
<h6 class="title mg_top_10 title_bg">Câu hỏi hot</h6>
<ol class="hot_questions">
<?php foreach($items as $i => $row){
	$alias = (trim($row['alias']) != '') ? $row['alias'] : $row['tieu_de']; 
	$link = $this->lib_menu->make_link(array( "questions" => $row['catid'] ) , array($row['ID'] => $alias ) );
 ?>
<li><a title="<?php echo $row['tieu_de']; ?>" href="<?php echo $link; ?>"><?php echo $row['tieu_de']; ?></a> – <span class="gray"><?php echo $row['viewed_times'] ?> xem</span></li>
<?php } ?>
</ol>

</div>
