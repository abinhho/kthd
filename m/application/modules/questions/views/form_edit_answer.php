<?php echo validation_errors('<div class="error_messenger">',"</div>"); ?>
<?php if(!empty($error_messenger)) echo "<div class='error_messenger'>".$error_messenger."</div>"; ?>


<?php 
$back_url=base64_decode($this->lib_url->_GET('return'));
?>
<h1 class="title_view_questions f_font1"><?php echo $question['tieu_de'];?>
<a class="right mg_top_5" href="<?php echo $back_url ?>">Quay lại câu hỏi</a>
</h1>
<form action="" name="" style="width: 680px;" id="form_answer" enctype='multipart/form-data' method="POST" class="form_bg mod_questions relative">
<input type="hidden" value="<?php echo $question['ID'] ?>" name="question_id" />
<?php $this->load->view('html/hint_right_editor');?>
<div class="content" id="resize_topic">
        <div class="content">
		<div class="nd"><?php echo $question['noi_dung']; ?></div>
        </div>
</div>

<br/>
<h1 class="title_view_questions font18 f_font1">Chỉnh sửa câu trả lời</h1>

<input type="hidden" name="back_url" value="<?php echo $back_url?>" />

<div class="error_messenger hidden error_noi_dung">Vui lòng nhập nội dung câu hỏi. Ít nhất 25 ký tự</div>
<textarea class="area_mobile" id="#cke_noi_dung" name="noi_dung"></textarea>
<?php 
//echo init_ckeditor(); 
//echo form_frontend_ckeditor('noi_dung' , $answer['noi_dung']); ?>
<br />
<div class="rfloat after mg_top_10">
		<input type="hidden" value="<?php echo $answer['ID'] ?>" name="id" />
		<input type="submit" name="submit_answer" id="newpost" class="button mg_top_10 rfloat" value="Lưu câu trả lời" />
		<a href="<?php echo $back_url?>" class="rfloat pd_15">Quay lại câu hỏi</a>
</div>
<i class="mg_top_20"><i>Đăng câu trả lời phải đúng với <a target="_blank" href="<?php echo base_url('spage/quy-dinh-dang-va-tra-loi-cau-hoi-22.html') ?>">Quy định đăng bài</a></i></i>

</form>



<script type="text/javascript">
	$(document).ready(function(){
		$("#resize_topic").resize_topic({}); 
	});
</script>