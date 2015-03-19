<?php
$style_input_small = "style='width:250px'";
$style_input_50 = "style='width:50px'";
$style_input_larger = "style='width:600px'";
$style_textarea = "style='width:600px;height:50px'";

$this->lib_form->input_tr_inline = false;

?>

<table width="100%">
<tbody>
<?php echo $this->lib_form->form_input_tr('tieu_de' , @$tieu_de , $style_input_small , "Tên tags") ; ?>
<?php echo $this->lib_form->form_input_tr('alias' , @$alias , $style_input_small , "Alias") ; ?>
<?php echo $this->lib_form->form_input_tr('n_used' , @$n_used , $style_input_50 , "Used") ; ?>
<?php echo $this->lib_form->form_textarea_tr('noi_dung' , @$noi_dung  , $style_textarea , "Mô tả") ; ?>
<?php echo $this->lib_form->form_input_tr('trong_luong',@$trong_luong , $style_input_50 , "Trọng lượng") ; ?>

</tbody>  
</table>

<?php 
echo form_hidden('catid', $catid);
echo form_close(); ?>