<h2 class="title_view_questions">Danh sách link <a href="<?php echo base_url('backlink/user/'. $backlink['user_id']) ?>" class="right">Xem các link đã gửi của <?php echo $full_name ?></a></h2>
 <?php if($this->lib_auth->check_permission($backlink ['user_id'])){
    echo form_open_multipart($this->lib_url->getUrl());
        ?>
    <textarea class="area_link_lists" name="link_lists"><?php echo $backlink['link_lists'] ?></textarea>
    <input type="hidden" name="tokenid" value="<?php echo encode_me($backlink['user_id']); ?>" />
    <?php 
    echo form_submit('submit_user_backlink', 'Lưu lại',"class='button'");
    echo form_close();
    } else { ?>
    <div class="link_lists pd_10_0"><?php echo $backlink['link_lists'] ?></div>
<?php } ?>

