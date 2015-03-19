<?php $hash_ = (@$hash == '') ? '' : '#'.@$hash; ?>

<div class="filter_tab_question after" id="<?php echo @$hash ?>">
<?php if(!isset($heading_tag)){ ?>
<h1 class="f_font1" itemprop="name"><?php echo $title; ?></h1>
<?php }
else { ?>
<h2 class="f_font1"><?php echo $title; ?></h2> 
<?php }  ?>

<div class="right">
<?php 

foreach($tabs as $key => $val){
    
    $link_tab = $this->lib_url->change_url('', array($name_order=> $key) ). $hash_;
    $cl_active = ($this->lib_url->_GET($name_order) == $key || ($this->lib_url->_GET($name_order) == '' && $key == 'newest') ) ? 'class="active"' : '';
    ?>
    <a rel="nofollow" href="<?php echo $link_tab ?>" <?php echo $cl_active ?> ><?php echo $val?></a>
    <?php    
}
?>
</div>
</div>