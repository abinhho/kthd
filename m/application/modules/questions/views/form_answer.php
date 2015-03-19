<h5 class="font18 pd_10 f_font1" id="form-answer">Trả lời câu hỏi này</h5>
<?php if($this->lib_auth->check_permission()) : ?>

<form action="<?php echo base_url('questions/save-answer/') ?>" name="" id="form_answer" enctype='multipart/form-data' method="POST" class="form_bg pd_10 mod_questions form_ans after">
<div class="after"> 
    
    <div class="error_messenger hidden error_noi_dung">Vui lòng nhập nội dung câu hỏi. Ít nhất 25 ký tự</div>
    
	<?php 
		//add_tbeditor("noi_dung",""); 
		//$this->load->view('_editor/_editor', array('noi_dung'=> ''));
         
        echo init_ckeditor(); 
        //echo form_frontend_ckeditor('noi_dung' , '');
		?>
		<textarea class="area_mobile" id="#cke_noi_dung" name="noi_dung"></textarea>
		<?php
		$submit= "onclick=\"submit_form({form:'form_answer',action:'". base_url('questions/save-answer/') ."'})\"";
	?>
	
	<div class="rfloat after mg_top_10">
		<input type="hidden" value="<?php echo @$FID ?>" name="fid" />
        <input type="hidden" value="<?php echo @$user_question_id ?>" name="user_question_id" />
        <input type="hidden" value="<?php echo @$tieu_de ?>" name="title_question" />
        
        <?php $notes_data = $user_question_id.';'.'answer'.';'.$this->lib_url->getUrl(true).';'.@$tieu_de ?>
        <input type="hidden" value="<?php echo @encode_me($notes_data) ?>" name="notes_data" />
        
		<input type="submit" id="newpost" name="submit_answer" class="button mg_top_10 rfloat"  value="Gửi câu trả lời" />
	</div>
</div>
<i class="mg_top_20 rfloat"><i>Đăng câu trả lời phải đúng với <a  target="_blank" href="<?php echo base_url('spage/quy-dinh-dang-va-tra-loi-cau-hoi-22.html') ?>">Quy định đăng bài</a></i></i>
</form>

<?php else : ?>

<div class="form_answer_unlogin">
    <a href="<?php echo base_url('user/login') ?>">Đăng nhập</a> để trả lời câu hỏi này hoặc 
    <a href="<?php echo base_url('user/login') ?>">Đăng ký</a> một tài khoản miễn phí 
    <a class="button_red mg_left_10 " href = "<?php echo base_url('user/login') ?>" >Tham gia ngay >></a>
</div>

<?php endif; ?>