<table width="100%" cellspacing="0" cellpadding="0">
<tr>
    <td width="50%"  class="pd_right_10" valign="top">
    <?php $link_more = $this->lib_url->change_url('', array('usertab'=>'question')) ?>
    <h4 class="title_view_questions font16 f_font1"><?php echo $question['nRow'] ?> <span class="gray">câu hỏi</span>
    <a class="right" rel="nofollow" href="<?php echo $link_more ?>">xem thêm</a>
    </h4>
    <?php if($question['nRow']){ ?>
    <div class="mod_questions small_items font14">
        <ul>
        <?php foreach($question['items'] as $i => $row){
        	$link = $this->lib_menu->make_link(array( "questions" => $row['catid'] ) , array($row['ID'] => $row['tieu_de']) );
         ?>
        
          <li><a href="<?php echo $link; ?>"><?php echo $row['tieu_de']; ?></a> 
        <span class="font12 color44"> – <?php echo $row['n_answers'] ?> <span class="gray">trả lời</span>, <?php echo $row['n_votes'] ?> <span class="gray">điểm</span></span></li>
        
        <?php if($i == 10) break; } ?>
        </ul>
    </div>
    <a rel="nofollow" class="rfloat mg_top_10" href="<?php echo $link_more ?>">>> xem thêm</a>
    
    <?php } else { ?>
    <span class="gray">Chưa có câu hỏi nào</span>
    <?php } ?>
    </td>
    <td  class="pd_left_10" valign="top">
    <?php $link_more = $this->lib_url->change_url('', array('usertab'=>'answer')) ?>
        <h4 class="title_view_questions font16 f_font1"><?php echo $answer['nRow'] ?> <span class="gray">trả lời</span>
        <a class="right" rel="nofollow" href="<?php echo $link_more ?>">xem thêm</a>
        </h4>
        <?php if($answer['nRow']){ ?>
        <div class="mod_questions small_items font14">
            <ul>
            <?php foreach($answer['items'] as $i => $row){
            	$link = $this->lib_menu->make_link(array( "questions" => $row['catid'] ) , array($row['ID'] => $row['tieu_de']) );
             ?>
             <li><a href="<?php echo $link; ?>"><?php echo $row['tieu_de']; ?></a> 
        <span class="font12 color44"> – <?php echo $row['n_answers'] ?> <span class="gray">trả lời</span>, <?php echo $row['n_votes'] ?> <span class="gray">điểm</span></span></li>
        
            <?php if($i == 10) break; } ?>
            </ul>
        </div>
        <a rel="nofollow" class="rfloat mg_top_10" href="<?php echo $link_more ?>">>> xem thêm</a>
        
        <?php } else { ?>
        <span class="gray">Chưa có câu hỏi nào</span>
        <?php } ?>
        
    </td>
</tr>    



<tr>
     <td width="50%"  class="pd_right_10" valign="top">
     <br /><br />
        <?php $link_more = $this->lib_url->change_url('', array('usertab'=>'bookmark')) ?>
        <h4 class="title_view_questions font16 f_font1"><?php echo $bookmark['nRow'] ?> <span class="gray">câu hỏi đánh dấu </span>
        <a class="right" rel="nofollow" href="<?php echo $link_more ?>">xem thêm</a>
        </h4>
        <?php if($bookmark['nRow']){ ?>
        <div class="mod_questions small_items font14">
            <ul>
            <?php foreach($bookmark['items'] as $i => $row){
            	$link = $this->lib_menu->make_link(array( "questions" => $row['catid'] ) , array($row['ID'] => $row['tieu_de']) );
             ?>
            
              <li><a href="<?php echo $link; ?>"><?php echo $row['tieu_de']; ?></a> 
        <span class="font12 color44"> – <?php echo $row['n_answers'] ?> <span class="gray">trả lời</span>, <?php echo $row['n_votes'] ?> <span class="gray">điểm</span></span></li>
            
            <?php if($i == 10) break; } ?>
            </ul>
        </div>
        <a rel="nofollow" class="rfloat mg_top_10" href="<?php echo $link_more ?>">>> xem thêm</a>
        
        <?php } else { ?>
        <span class="gray">Chưa có câu hỏi nào</span>
        <?php } ?>
    </td>
    <td valign="top" class="pd_left_10" >
    <?php if($this->lib_auth->check_permission($user_id_topic)){ ?>
     <br /><br />
        <?php $link_more = $this->lib_url->change_url('', array('usertab'=>'notes')) ?>
        <h4 class="title_view_questions font16 f_font1"><span class="gray">Thông báo </span>
        <a class="right" rel="nofollow" href="<?php echo $link_more ?>">xem thêm</a>
        </h4>
        
        <?php if($notes['nRow']){ ?>
        <div class="mod_questions small_items font14">
            <ul>
            <?php foreach($notes['items'] as $i => $row){ ?>
            
            <li><?php echo anchor('user/'.$row['user_id_from'], $row['full_name']) ?>
            <?php echo $row['action_name'] ?> <?php echo anchor($row['link'], $row['tieu_de']) ?>
             – <span class="gray font12"><?php echo $this->lib_date->ago($row['date_upd']) ?></span>
            </li> 
            
            <?php if($i == 10) break; } ?>
            </ul>
        </div>
        <a rel="nofollow" class="rfloat mg_top_10" href="<?php echo $link_more ?>">>> xem thêm</a>
        
        <?php } else { ?>
        <span class="gray">Chưa có câu thông báo nào!</span>
        <?php } ?>
        
        <?php } ?>
    </td>
</tr>  

</table>