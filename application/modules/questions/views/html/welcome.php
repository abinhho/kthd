<?php if(!$this->lib_auth->is_logged()): ?>
<div class="box_welcome">
    <h5>Chào mừng đến với Kiến Thức Hỏi Đáp</h5>
     – Chào mừng bạn đến với hệ thống đặt câu hỏi và trả lời mọi kiến thức trong cuộc sống. 
    <br/> – Để giải quyết thắc mắc của bạn nhanh nhất, hãy tham gia cùng chúng tôi.
	<br/> – Giải đáp thắc mắc trên <a href="http://m.kienthuchoidap.com">Phiên bản mobile</a>
    <a class="button_red rfloat" href="<?php echo base_url('user/login') ?>">>> Tham gia ngay</a>   
</div>

<?php endif; ?>