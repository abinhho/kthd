<?php if($this->session->userdata("email")=="")
{
?>

<li><a href="<?php echo base_url("user/login") ?>" ><i class="fa fa-share"></i> Đăng ký</a></li>

<li><a href="<?php echo base_url("user/login") ?>" ><i class="fa fa-sign-in"></i> Đăng nhập</a></li>

<?php }
else
{
    $user_thumb = $this->lib_media->show_crop("user" ,$this->session->userdata("images"), 25, 25);
    $username = $this->session->userdata("full_name");
 ?>
<li class="user">
    <a href="<?php echo base_url("user/".$this->session->userdata("ID")); ?>" title="<?php echo $username ?>">
        <img src="<?php echo $user_thumb ?>" />
        <b><?php echo $username ?></b>
    </a>
</li>
<li class="user_notes"><a href="#" title="Thông báo"><i class="fa fa-bell-o"></i> Thông báo</a>
    <b class="number">12</b>
    <ul class="notes_abso_intop">
        <i class="sprites arrow_top"></i>
        <span class="block top">THÔNG BÁO GẦN ĐÂY 
            <a class="right font12" href="<?php echo base_url('user/'.$this->session->userdata('ID').'?usertab=notes#user_tab') ?>" rel="nofollow">Xem tất cả</a>
        </span>
        <div class="contents_notes"><span class="no_result loading">LOADING...</span></div>
    </ul>
</li>

 <?php if($this->session->userdata("level") == 2){ ?>
<li><a href="<?php echo base_url("admin"); ?>" target="_blank"><i class="fa fa-cogs"></i></a></li>
<?php } ?>

<li><a href="<?php echo base_url("user/logout"); ?>"><i class="fa fa-sign-out"></i> Thoát</a></li> 
 <?php } // print_r ($this->cart->contents()) ; ?>
