<div class="item_comments clearfix" id="item_comments_<?php echo $type.'_'.$id  ?>"><ul>
<?php 
$i = 0;
foreach($item_comments as $row) { 
    $hidden = ($i>=5) ? 'style="display:none"' : '';
    ?>
   
   <li <?php echo $hidden ?> id="icomment<?php echo $row['ID'] ?>"><?php echo $row['noi_dung'] ?> 
    – <?php echo anchor('user/'.$row['user_id'], $row['user_full_name'], 'data-id="'.$row['user_id'].'" class="tooltip_userinfo"') ?>
    <span class="gray"> <?php echo $this->lib_date->ago($row['date_upd']) ?></span>
   
   <?php if($this->lib_auth->check_permission($row['user_id'])){ ?>
   <i class="sprites close" question-id="<?php echo $ID ?>" onclick="return del_comment('<?php echo encode_me($row['ID']) ?>', $(this) )" t_title="Xóa bình luận này"></i>
   <?php } ?>
   </li>
   
<?php $i++; } ?>
</ul>

<?php if($i > 5) {?>

<a href="#" onclick="return show_more_comment($(this));" class="view_more">xem thêm <?php echo count($item_comments)-5 ?> bình luận </a>
<?php } ?>

</div>




<div class="tool_comment">
<input type="hidden" name="_comment_" value="<?php echo $type.'_'.$id ?>" />
<a href="javascript:void(0)" id="comment_topic" t_title = "Bình luận"><i class="sprites comment"></i>viết bình luận</a>
</div>


<div class="form_comment hidden after" id="comment_<?php echo $type.'_'.$id ?>">
    <?php $notes_data = $user_topic.';'.$type.';'.$this->lib_url->getUrl(true).';'.$tieu_de ?>
    
    <textarea id="count_down_char" notes_data = "<?php echo encode_me($notes_data) ?>"  maxlength="250" class="area" name = "comment-<?php echo $type.'-'.$id ?>"></textarea>
    <span class="lfloat gray">Nhập bình luận của bạn ở đây (ít nhất 5 ký tự).</span>
    
    <input type="button" class="button" value="Binh luận" />
    <span class="rfloat">Số ký tự còn lại <samp id="count_down_number">250</samp></span>
</div>