<?php 

$alias = (trim($alias) != '') ? $alias : $tieu_de; 
$link = $this->lib_menu->make_link(array('questions' => $catid) , array($ID => $alias) );

$n_answers = ($n_answers == "") ? 0: $n_answers;
$ans_class= ($n_answers != 0) ? 'has_ans' : ''; 

//$hinh_anh = $this->lib_media->show_crop("questions" ,$images, 160, 120);
?>
<li class="after" itemscope itemtype="<?php echo $link;?>">

<div class="right relative">
    <h3><a class="title f_font1 <?php if($closed) echo 'closed' ?>" href="<?php echo $link ?>" title="<?php echo $tieu_de ?>"><?php echo $tieu_de ?></a></h3>
    <div class="desc">
    
        <?php if(isset($description)){ ?>
        <!--p class="text_desc">
        <?php //echo implode(' ', array_slice(explode(' ', $description), 0, 30))  ?>...
        </p-->
        <?php } ?>
        <!--i class="sprites stat"></i-->
         <?php if(!$closed){ ?>
        <a class="color1" href="<?php echo $link ?>#item_answers" title="<?php echo $tieu_de ?>"><strong><?php echo $n_answers?></strong> trả lời</a>
        <?php } ?>
        
        <span class="color2"><?php echo $n_votes?> điểm</span>
        
        <span class="gray"><?php echo $viewed_times?> lượt xem </span>
         – <span>đăng bởi <a   class="tooltip_userinfo" data-id="<?php echo $user_ID ?>" href="<?php echo base_url('user/'.$user_ID) ?>"><?php echo $user_full_name ?></a></span>
        – <span><?php echo $this->lib_date->ago($date_add)?>
        <?php if($date_add != $date_edit) echo ", sửa ". $this->lib_date->ago($date_edit) ?>
        </span>
        <?php if(!$closed){ ?>
        <a class="go2answer" rel="nofollow" href="<?php echo $link ?>#form-answer"><i class="sprites answer01"></i>trả lời</a>
        <?php } ?>  
    </div>
    <div class="tags_inline"><?php if(isset($cata_tieu_de)) echo ' – '. anchor('questions/'.$cata_alias.'/',$cata_tieu_de, 'class="font13" title="'.$cata_tieu_de.'"' ); ?>
    </div>
    <?php 
    if($this->lib_url->_GET('seo') == 1)
    {
        $this->load->view('social_plugins/share_seo_list', array('url'=> $link, 'tieu_de'=> $tieu_de,'description' => @$description) );
    }
     ?>
</div>
<?php if(@$exactly){
    ?>
    <i class="sprites exactly" t_title="Có câu trả lời độ chính xác cao" ></i>
    <?php
} ?>	
</li>