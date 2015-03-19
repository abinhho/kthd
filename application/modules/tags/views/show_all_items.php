<div class="mod_tags show_items all after">
<h1 class="title_view_questions f_font1"><?php echo $title; ?></h1>
<span class="block f_font1 font15 bold" style="margin: 10px 0 20px;"><?php echo $description ?></span>
<div class="bound_ul">
<?php  foreach($items as $row){
    
    $link_more = base_url('tags/catagory/'.$row['ID']);
    ?>
    <ul>
    <h3 class="title_view_questions font16 f_font1"><a href="<?php echo $link_more ?>"><?php echo $row['tieu_de'] ?></a></h3>
    <?php 
    foreach ($row['tags']['items'] as $r)
    {
        ?>
        <li>
       
        <a class="each_tag" title="<?php echo $r['tieu_de'] ?>" href="<?php echo base_url('tags/'.$r['cata_alias'].'/'.$r['alias']) ?>/"><?php echo $r['tieu_de'] ?>
        </a>
        <span class="gray"> x <?php echo $r['n_used'] ?></span>
        </li>
        <?php
    }
     ?>
    <div class="pd_top_10 block clearfix"><a href="<?php echo $link_more ?>" class="font12 ">>> xem thêm</a></div>
    </ul>
    
    <?php
    
} ?>
</div>
</div>