<?php if(count($items_same_topic)): ?>
<div class="mod_questions block_white small_items">
    <h6 class="title mg_top_10 title_bg">Liên quan</h6>
    <div class="contents_bg font13">
        <ul>
        <?php foreach($items_same_topic as $row){
                $alias = (trim($row['alias']) != '') ? $row['alias'] : $row['tieu_de']; 
                $link = $this->lib_menu->make_link(array( "questions" => $row['catid'] ) , array($row['ID'] => $alias ) );
         ?>
          <li><a href="<?php echo $link; ?>" title = "<?php echo $row['tieu_de']; ?>"><?php echo $row['tieu_de']; ?></a>  
                <span class="font12 color44">–  <span class="gray"> <?php echo $row['n_answers'] ?> trả lời</span></span></li>

        <?php } ?>
        </ul>
    </div>
</div>
<a href="<?php echo base_url('questions')?>" class="gray font12">Xem thêm câu hỏi khác</a>
<?php endif; ?>