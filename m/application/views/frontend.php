<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
   	<title><?php echo $title; ?> - <?php echo NAME_PAGE?></title>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:domain" content="<?php echo $_SERVER['HTTP_HOST'] ?>"/>
    <?php 
    $og_icon = str_replace('m.','', $this->lib_url->full_base_url('assets/images/og_icon.png'));
     ?>
    
    <link rel="og_icon image_src" href="<?php echo $og_icon ?>">
    <meta name="og:type" content="website" />
    <meta name="og:image" content="<?php echo $og_icon ?>" />
    <meta name="og:title" content="<?php echo $title; ?>" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
    <?php if(strlen($description) < 40) $description .= ', '.SHORT_DESCRIPTION ?>
    
    <meta name="og:description" content="<?php echo $description?>" />
    <link rel="apple-touch-icon image_src" href="<?php echo $og_icon ?>" />
    <link href="<?php echo GOOGLE_PAGE ?>" rel="author" />
    
   	<meta name="description" content="<?php echo $description?>" />
	<meta name="keywords" content="<?php echo $keywords; ?>" />
    
    <?php $curr_url = str_replace('m.', '',$this->lib_url->getUrl(true)) ?>
    
    <meta name="og:url" content="<?php echo $curr_url ?>"/>
    <link rel="canonical" href="<?php echo $curr_url ?>" />
    
	<link type="image/x-icon" href="<?php echo base_url('favicon.ico')?>" rel="shortcut icon" />
	<?php echo $_styles; 
    $this->carabiner->display();
    ?>
	
	<script type="text/javascript"><?php echo GA_CODE; ?>
	
	(function() {
		var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
		po.src = "https://apis.google.com/js/plusone.js?publisherid=117681578036677367735";
		var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
	})();
	
    var base_url = '<?php echo base_url() ?>';
    var user_id = '<?php echo $this->session->userdata('ID') ?>';
    
    var alert_message = "<?php echo $this->lib_url->get_notice(); ?>";
     
    </script>
	
   	<?php echo $_scripts; ?>
</head>
<body <?php if(defined('BODY_STYLE')) echo BODY_STYLE;?>>
    
	<?php 
	$in_home_c = ($this->uri->segment(1) == "") ?  "in_home" : "";
	?>
        
        <div class="left_sidebar hidden">
        <?php echo Modules::run('menu/m_block_menu_top'); ?>
        </div>
        
		<div class="main_body after" itemscope itemtype="http://schema.org/Article">
		<link itemprop="image" href="<?php echo $this->lib_url->full_base_url('assets/images/og_icon.png') ?>" />
        
         <?php echo Modules::run('banner/block_banner'); ?>
        
	   	<?php echo $mainfile; ?> 	
        <?php echo $footer; ?>
	   	</div>
   	
  
   	
<?php echo $left_right_page;?>

<?php //$this->load->view("social_plugins/tool_right_page")?>
<iframe name = "temp_frame" src="" class="hidden"></iframe>
<div class="dim_body" id="dim_body"></div>


<div class="noti_absolute"><span class="close"></span><div class="content"></div><i class="close"></i><i class="arrow"></i></div>
<div class="tooltip_tag_abso"></div>

<div class="share_promt_abso">
<h4>Chia sẽ câu này</h4>
<input type="text"/>
<div class="bottom">
<a href="http://www.facebook.com/sharer.php?u=" target="_blank" class="fb soci"></a>
<a href="http://twitter.com/share?url="  target="_blank" class="twitter soci"></a>
<a href="https://plus.google.com/share?url="  target="_blank" class="google soci"></a>
</div>
<a class="close rfloat font_12 mg_top_10">Đóng</a>
</div>

<div class="comment_promt_abso">
<a class="close rfloat font_12 mg_top_10">Đóng</a>
<h5 class="title">Bình luận của bạn</h5>
<div class="content"><textarea></textarea></div>
<a class="button_a submit rfloat">Gửi đi</a>
</div>
<div class="t_title_abso"><span class="content"></span><i class="img"></i></div>
<div class="promt_front_end" id="promt_front_end"><i class="close"></i><div class="contents"></div></div>


</body>
</html>