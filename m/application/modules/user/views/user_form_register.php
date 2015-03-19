<?php echo validation_errors('<div class="error_messenger">',"</div>"); ?>
<?php if(!empty($error_messenger)) echo $error_messenger; ?>

<?php 
$html_message = $this->lib_url->get_notice('html_message');
if(!empty($html_message)) echo '<div class="error_messenger">'.$html_message.'</div>'; ?>

<div class="user_form">
<?php $style_input_larger = "style='width:300px'"; ?>

<?php 	echo form_open($this->lib_url->getUrl() , 'class="accept_enter"'); ?>
<a class="button rfloat mg_right_10" href="<?php echo base_url('user/login') ?>">Đăng nhập</a>
<h2 class="title_view_questions f_font1">Đăng ký tài khoản mới?</h2>
<span class="gray font12 block pd_10">Đăng ký tài khoản trong vòng 30s để sử dụng các chức năng nâng cao từ chúng tôi !</span>
<div class="contents">

<div class="like_tr after"><label>Tên của bạn<i class='red'>*</i> : </label>
<div class="td"><?php echo form_input('full_name',  set_value('full_name') , "class='input_text capitalize' maxlength='20' "); ?>
<p class="hint">EX: Francesc</p>
</div>
</div>

<div class="like_tr after"><label>Email<i class='red'>*</i> : </label>
<div class="td"><?php echo form_input('email',  set_value('email') , "class='input_text lowercase'"); ?>
</div>
</div>

<div class="like_tr after"><label>Mật khẩu mới<i class='red'>*</i> : </label>
<div class="td"><?php echo form_password('password','', "class='input_text'"); ?></div>
</div>

<div class="like_tr after"><label>Lặp lại mật khẩu<i class='red'>*</i> : </label>
<div class="td"><?php echo form_password('re_password','' , "class='input_text'"); ?></div>
</div>


<div class="like_tr nobg  after"><label></label>
<div class="td"><?php echo form_submit('submit_register',"Đăng ký hoàn tất","class='button'"); ?></div>
</div>

</div>

 <?php 	echo form_close(); ?>
 </div>

<h5 class="font16 pd_10">Hoặc bạn có thể đăng nhập nhanh bằng tài khoản</h5>
 <div class="login_social pd_10">
 <a href="<?php echo $this->session->userdata('login_facebook_url') ?>" class="facebook" title="Đăng nhập bằng tài khoản Facebook"></a>
 <a href="<?php echo $this->session->userdata('login_google_url') ?>" class="google" title="Đăng nhập bằng tài khoản Google"></a>
 </div>

<h5 class="font14 pd_10 color55">Bạn đồng ký đăng ký tài khoản có nghĩa bạn đã đồng ý với các <a href="#">điều khoản quy định</a> của chúng tôi</h5>