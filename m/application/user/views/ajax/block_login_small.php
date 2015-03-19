 <div class="block_login_small">
    
    <span class="block">Tham gia ngay để được giải đáp những thắc mắc nhanh nhất.</span>
    <a href="<?php echo base_url('user/login') ?>" >Đăng ký</a> hoặc
    <a href="<?php echo base_url('user/login') ?>" >đăng nhập</a> ngay.
    
    <strong class="block">Đăng nhập bằng tài khoản</strong>
     <div class="login_social tcenter">
     <a href="<?php echo $this->session->userdata('login_facebook_url') ?>" class="facebook" title="Đăng nhập bằng tài khoản Facebook"></a>
     <a href="<?php echo $this->session->userdata('login_google_url') ?>" class="google" title="Đăng nhập bằng tài khoản Google"></a>
     </div>
    
 </div>