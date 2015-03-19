<?php if($this->session->userdata("email")=="")
{
?>

<!--li><a class="button" href="<?php echo base_url("user/login") ?>" >Đăng ký</a></li-->

<li><a class="button" href="<?php echo base_url("user/login") ?>" >Đăng nhập</a></li>

<?php }
else
{
 ?>
<li><b><a class="button" href="<?php echo base_url("user/".$this->session->userdata("ID")); ?>"><?php echo $this->session->userdata("full_name");?></a></b></li>
<!--li class="user_notes"><a href="#" class="sprites"></a>
<b class="number">0</b>
<ul class="notes_abso_intop">
<i class="sprites arrow_top"></i>
<span class="block top">THÔNG BÁO GẦN ĐÂY <a class="right" href="<?php echo base_url('user/'.$this->session->userdata('ID').'?usertab=notes#user_tab') ?>" rel="nofollow">Xem tất cả</a></span>
<div class="contents_notes"><span class="no_result loading">LOADING...</span></div>
</ul>
</li-->
<li><a class="button" href="<?php echo base_url("user/logout"); ?>">Thoát</a></li> 
 <?php } // print_r ($this->cart->contents()) ; ?>
<li><a href="<?php echo base_url('/questions/ask')?>" class="button green rfloat">+ Đặt câu hỏi</a></li>