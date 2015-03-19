<?php $hash_ = (@$hash == '') ? '' : '#'.@$hash; ?>

<div class="filter_tab_question after" id="<?php echo @$hash ?>">
<?php if(!isset($heading_tag)){ ?>
<h1 class="f_font1" itemprop="name"><?php echo $title; ?></h1>
<?php }
else { ?>
<<?php echo $heading_tag ?> class="f_font1"><?php echo $title; ?></<?php echo $heading_tag ?>> 
<?php }  ?>

<div class="right">
<li>
    <i class="fa fa-ellipsis-h"></i>
    <ul>
        <h6 class="title">Lọc theo</h6>
        <?php 
        foreach($tabs as $key => $val){
            
            $link_tab = $this->lib_url->change_url('', array($name_order=> $key) ). $hash_;
            $cl_active = ($this->lib_url->_GET($name_order) == $key || ($this->lib_url->_GET($name_order) == '' && $key == 'newest') ) ? 'class="active"' : '';
            ?>
            <li><a rel="nofollow" href="<?php echo $link_tab ?>" <?php echo $cl_active ?> ><?php echo $val?></a></li>
            <?php    
        }
        ?>   
    </ul>
</li>
</div>
</div>