<?php
function add_tbeditor($name,$noi_dung) {
($noi_dung=="")?$noi_dung="&nbsp;":'';
?>
<script type="text/javascript"/>
var name_tbeditor="<?php echo $name?>";
var HOME_PATH = "<?php echo base_url('application/plugins')?>";
</script>
<script type="text/javascript" src="<?php echo base_url('application/plugins/tbeditor/tbeditor.js') ?>"/></script>
<link href='<?php echo base_url('application/plugins/tbeditor/tbeditor.css') ?>' rel='stylesheet'/>

<div id="box_editor">
			<div>
			<div id="editor_top" class="editor_top">
			<i class="show_hide_tool"></i>
			</div>
			<div id="editor_design">
			<iframe id="textbox" name="textbox"></iframe>
			<textarea class="auto" id="mode_html"><?php echo $noi_dung; ?></textarea>
			<textarea id="temp_nd" style="display:none;" name="<?php echo $name?>"><?php echo $noi_dung; ?></textarea>
			</div>
			<div class="resize">
				<!--a class="frame_design active">Design</a-->
				<!--a class="area_design">HTML</a-->
			</div>
			<div class="dim_resize" style="background:#ccc;display:block"></div>
			</div>
</div>
<?php } ?>
<?php include (dirname(__FILE__)."/special_char.php"); ?>
<div id="promt_editor_special_char">
<h6 class="top">Chọn ký tự đặc biệt<a class="close">Đóng</a></h6>
<span class="content after">
<div class="left">
<?php 
foreach($special_char as $char)
{
	echo "<span>{$char}</span>";
}
?>
</div>
<div class="right"></div>
</span>
</div>

<div id="promt_add_code">
<h6 class="top">Nhập code<a class="close">Đóng</a></h6>
<div class="content after">
<textarea placeholder="Nhập code...">
</textarea>
</div>
<div class="after"><input type="button" class="button rfloat done" value="Xong"/></div>
</div>
