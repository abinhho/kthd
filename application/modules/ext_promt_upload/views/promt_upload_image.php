<style type="text/css">
input.button_upload_image{padding:2px 5px;cursor:pointer}
.feed_image_upload{margin:0px 0;}
.feed_image_upload li{width:120px;height:150px;position:relative;display:inline-block;border:1px dashed #cccccc;margin:10px 5px 5px 0}

.feed_image_upload li .del,.feed_image_upload li img{position:absolute;top:0; bottom:0;left:0;right:0; margin:auto;}.feed_image_upload li .del{bottom:auto;left:auto;padding:5px 10px;background:#000;color:#fff;}
.feed_image_upload li img{max-width:120px;max-height:150px;width:auto;height:auto;}
.promt_upload_image{display:none;position:absolute;top:100px;left:0;right:0;margin:auto;background:#fff;width:400px;padding:10px 15px;border:1px solid #ccc;z-index:1002;font-size:12px;}

</style>
<script type="text/javascript">
$(document).ready(function(){
var abso=$(".promt_upload_image"),ADVANCE_UPLOAD="";
$("input[name='location']").click(function(){
	if($(this).attr('checked')=="checked"){ //alert($(this).attr("id"));
		$("input.location").hide();
		$("input."+$(this).attr("id")).show();
	}
});
var form_="#form_upload_image_advance";
var feed_upload_image=$(".feed_image_upload");
var temp_image=$("input[name='temp_image']");
ADVANCE_UPLOAD={
	
	reset_form:function()
	{
		$(form_).each (function(){
		  this.reset();
		});
		$(form_).find("input.location").hide();
		$(form_).find("input.file_com").show();
		$(form_).find(".loading").hide();
	}
	,hide_abso:function()
	{
		abso.fadeOut("fast");
		$(".dim_body").fadeOut("fast");
	}

};
unlink=function(opt){
		$("#temp_frame").attr({"src":"<?php echo base_url()?>/unlink.php?link="+opt.link});
		opt.this_.parents("li").remove();
		var val= temp_image.val();
		val=rm_add_coma(val,opt.name_image,",");
		temp_image.val(val);
		return false;
}
feed_back_upload_image_advance = function(D){
	if(D.ok==false)
	{
		$(form_).find(".loading").text(D.error);
	}
	else
	{
		feed_upload_image.append(D.app);
		var val= temp_image.val(); 
		val=add_coma(val,D.name_image,",");
		temp_image.val(val);
		
		ADVANCE_UPLOAD.reset_form();
		ADVANCE_UPLOAD.hide_abso();
	}
	
	}

$(".button_upload_image_advance").click(function(){
	ADVANCE_UPLOAD.reset_form();
	abso.css({top:$(document).scrollTop()+100+'px'}).show();
	$(".dim_body").show();
	$(".promt_upload_image .close").click(function(){
		ADVANCE_UPLOAD.hide_abso();
	});
});
abso.submit(function(){
	$(this).find(".loading").text("loading...").show();
});
});
</script>
<?php function show_image_upload($hinh_anh){ ?>
<input type="button" class="button_upload_image_advance" onclick=" return false;" value="Upload hình"><i class="gray mg_left_5"> Chấp nhận định dạng <b>.jpg, .jpeg, .png, .gif</b> và tối đa là <b>2M</b></i>
<input name="temp_image" type="hidden" value="<?php echo $hinh_anh;?>">
<div class="after feed_image_upload">
<?php
global $TB_string_array;
$lists=split(",",$hinh_anh);
$lists=$TB_string_array->remove_null_array($lists);
foreach($lists as $img)
{
	$temp="images/hinh_anh/".$img;
	if(file_exists($temp)){
		echo "<li><img src='".base_url()."/".$temp."' ><a href='#' onclick=\"return unlink({link:'".$temp."',name_image:'".$img."',this_:$(this)})\" class='del'>Xóa</a></li>";
	}
}
?>

</div>

<?php } 
function promt_abso_upload_image()
{
	global $TB_url;
	$this_dir=$TB_url->get_dir_apart("modules",dirname(__FILE__));
	
?>
<div class="promt_upload_image">
	<form action="<?php echo base_url()."/{$this_dir}/do_promt_upload_image.php"?>" target="temp_frame" id="form_upload_image_advance" enctype='multipart/form-data' method="POST">
		<h5 class="title">Upload hình ảnh <a class="close rfloat font_12">(X) Đóng</a></h5>
		<div class="after">
			<input type="radio" checked value="com" name="location" id="file_com"> <label for="file_com">Từ máy tính</label>
			<input type="radio" value="web" name="location" id="file_web" style="margin-left:20px;"> <label for="file_web">Từ web</label>
		</div>
		<div class="after mg_top_10">
			<input type="file" name="FILE_COM" class="file_com location input_file">
			<input type="text" name="FILE_WEB" class="file_web input_text hidden location"  style="width:300px;" placeholder="http://example.com/hinh.jpg">
		</div>
		<div class="after">
			<span class="pd_top_10 red lfloat loading">Loading...</span>
		</div>
		<div class="after mg_top_20">
			<span class="pd_top_10 gray lfloat">Kéo hình thả vào ô trên</span>
			<input type="submit" value="upload" class="button rfloat">
		</div>
	</form>
</div>
<?php } ?>



