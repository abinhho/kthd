<div class="user_form">
<?php
echo form_open($this->lib_url->getUrl(), 'class="accept_enter"'); ?>

<h2 class="title_view_questions f_font1">Bạn đã có tài khoản? Đăng nhập ngay</h2>
<div class="contents">

<div class="like_tr after"><label>Email: </label>
<div class="td"><?php echo form_input('email',  set_value('email') , "class='input_text'"); ?></div>
</div>

<div class="like_tr after"><label>Mật khẩu: </label>
<div class="td"><?php echo form_password('password',"", "class='input_text'"); ?></div>
</div>

<div class="like_tr nobg after"><label></label>
<div class="td"><?php echo anchor('user/forgot',"Quên mật khẩu?", "class='underline'")?></div>
</div>

<div class="like_tr nobg after"><label></label>
<div class="td"><?php echo form_submit('submit_login', __("Login"),"class='button'"); ?></div>
</div>
</div>
 <?php 	echo form_close(); ?>
 
 <h5 class="font16 bold tright f_font1">Hoặc bạn có thể đăng nhập nhanh bằng tài khoản</h5>
 <div class="login_social tright">
 <a href="<?php echo $this->session->userdata('login_facebook_url') ?>" class="facebook" title="Đăng nhập bằng tài khoản Facebook"></a>
 <a href="<?php echo $this->session->userdata('login_google_url') ?>" class="google" title="Đăng nhập bằng tài khoản Google"></a>
 </div>
 </div>
