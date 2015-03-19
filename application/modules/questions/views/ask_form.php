<?php echo validation_errors('<div class="error_messenger">',"</div>"); ?>
<?php if(!empty($error_messenger)) echo "<div class='error_messenger'>".$error_messenger."</div>"; ?>
 



<?php
echo init_ckeditor(); 
$back_url=base64_decode($this->lib_url->_GET('return'));
?>
<h1 class="title_view_questions f_font1">Chỉnh sửa, thêm bài viết

<?php if(!empty($back_url)) { ?><a class="right mg_top_5" href="<?php echo $back_url ?>">Quay lại câu hỏi</a> <?php } ?>
</h1>
<form action="" style="width: 680px;margin-top:20px" name="" id="form_ask_question" enctype='multipart/form-data' method="POST" class="form_bg mod_questions relative">
<?php $this->load->view('html/hint_right');?>

<h2 class="font16 f_font1 des_after_title">Nếu bạn không tìm thấy câu trả lời, hãy thử đánh vài từ khóa vào ô dưới đây, nếu vẫn không tìm thấy, hãy đặt một câu hỏi.</h2>

<table width="100%" cellspacing="0" cellpadding="0">

	<tr>
		<td width="75px" colspan="2" height="40px"><strong>Tiêu đề câu hỏi<i class="red">*</i>: </strong></td>
	</tr>
    	<tr>
		<td colspan="2">
         <div class="error_messenger hidden error_tieu_de">Vui lòng nhập tiêu đề, tối thiểu 15 ký tự</div>
        <input autocomplete="off" class="input_text input_question_suggest_upload" id="ask_tieu_de" value="<?php echo @$tieu_de; ?>" maxlength="255" name="ask[tieu_de]" placeholder="Tên câu hỏi của bạn???" style="width: 98%;" />
        
       
        
        </td>
	</tr>
	
	<tr>
		<td class="pd_bottom_10" colspan="2"><div class="inner_question_suggest_upload"></div>
		</td>
	</tr>
	
    <!--tr>
		<td height="40px"><label class="label_1 mg_right_10 font_14">Hình ảnh: </label></td>
		<td><?php 
        //$this->load->view('ext_promt_upload/promt_upload_image', array('hinh_anh' => @$images) );
      //  show_image_upload(@$hinh_anh); ?></td>
	</tr-->
    
	<tr class="nda">
		<td class="pd_bottom_10" colspan="2">
        <div class="error_messenger hidden error_noi_dung">Vui lòng nhập nội dung câu hỏi. Ít nhất 25 ký tự</div>
        <?php //add_tbeditor("noi_dung",@$noi_dung); 
        echo form_frontend_ckeditor('noi_dung' , @$noi_dung);
        ?>
        <br />
		</td>
	</tr>
	
    <tr>
		<td colspan="2" height="20px"><strong class="label_1 font_14">Lựa chọn danh mục: </strong></td>
	</tr>
    
      <tr><td colspan="2" height="40px">
        <div class="error_messenger hidden error_catid">Vui lòng chọn 1 danh mục.</div>
        <select autocomplete="off" name="ask[catid]" class="select" id="select_ask_catid">
        <option value="">Chọn danh mục - - - - - - </option>
        <?php 
            foreach ($catagories as $row)
            {
                $selected = ($row['ID'] == @$catid) ? 'selected' : '';
                ?>
                <option <?php echo $selected ?> value="<?php echo $row['ID'] ?>"><?php echo $row['tieu_de'] ?></option>        
                <?php
            }
            ?>
        </select>
        <span class="gray pd_left_10"> <- Vui lòng lựa chọn danh mục trước khi chọn tag</span>
        </td>
	</tr>
	
	<tr>
		<td colspan="2" height="40px"><strong class="mg_bottom_10">Tags<i class="red">*</i>: </strong>
        <i class="gray">Ít nhất 1 tag và tối đa là 5</i>
        <div class="error_messenger hidden error_tags">Vui lòng chọn ít nhất 1 tag.</div>
        </td>
	</tr>
	<tr>
		<td colspan="2">
        <input type="hidden" name="old_tags_id" value="<?php echo @$tags_id ?>" />
        <input type="hidden" name="old_catid" value="<?php echo @$catid ?>" />
		<input type="hidden" class="append_span_id" id="tags_id" autocomplete="off" name="ask[tags_id]" value="<?php echo @$tags_id ?>" />
		<input type="hidden" class="append_span" name="tags" value="" />
		<div class="input_tag after" id="append_info_tags">
			<span class="append_span">
                <?php echo $this->lib_tags->show_tags_in_form(@$tags_id)?>
            </span>
			<!--input type="text" maxlength="40" class="accept_13 input_suggest" /-->
		</div>
        <div class='div_checkbox_tags after'><?php echo $this->lib_tags->show_checkbox_tags(@$catid, @$tags_id) ?></div>
        <br />
        
        
        
		<h3>Nếu không tìm thấy tag bạn cần, hãy thử <a href="#" onclick="alert('Bạn chưa thể thực hiện chức năng này'); return false;">Thêm tag mới</a></h3>
		<br/>
		</td>
	</tr>
	
	<tr>
		<td align="right" class="bor_top" colspan="2">
        
		<input type="submit" name="submit_ask" id="newpost" autocomplete="off" class="button rfloat mg_top_10 block" 
        onclick="submit_form({form:'form_ask_question',target:'',action:''})" value="Thực hiện" />
        <?php if(!empty($back_url)) { ?><a class="rfloat pd_15" href="<?php echo $back_url ?>">Quay lại câu hỏi</a> <?php } ?>	
		<span class="mg_top_20 lfloat"><i>Đăng câu trả lời phải đúng với <a class="color_a" target="_blank" href="<?php echo base_url('spage/quy-dinh-dang-va-tra-loi-cau-hoi-22.html') ?>">Quy định đăng bài</a></i></span>
		</td>
	</tr>
</table>

</form>
<br/>

<script type="text/javascript">
$(document).ready(function(){ 
    $("#form_ask_question").submit(function(e){
        
        $("#ask_tieu_de").my_validate({
            divshow:'.error_tieu_de'
            ,length: 15
            ,form:e
        });
        
         $("#cke_noi_dung").my_validate({
            divshow:'.error_noi_dung'
            ,length: 25
            ,form:e
            ,type: 'editor'
        });
        $("#select_ask_catid").my_validate({
            divshow:'.error_catid'
            ,form:e
        });
        $("#tags_id").my_validate({
            divshow:'.error_tags'
            ,form:e
        });
        
        
       
    });
});
</script>