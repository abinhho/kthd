<div class="mod_tags show_items after">

<?php 
$data_filter = array(
'title' => $cata_name
,'tabs' => 
    array('newest' => 'Mới nhất'
    ,'oldest' => 'cũ nhất'
    ,'vote' => 'sử dụng nhiều'
    )
,'name_order' => 'tagsort'
,'hash' => 'item_tags'
); 
$this->load->view('ext_filter/tab_questions', $data_filter);

 ?>

<span class="block f_font1 font15 bold pd_10 color55" style="margin: 10px 0 20px;">Tất cả các tag trong <?php echo $cata_name; ?> 
<a class="rfloat f_normal pd_10 font14" rel="nofollow" href="<?php echo base_url('tags') ?>">Quay lại danh mục</a>
</span>
<ul class="after">
<?php foreach($items['items'] as $r){
    ?>
        <li>
       
        <a class="each_tag" title="<?php echo $r['tieu_de'] ?>" href="<?php echo base_url('tags/'.$r['cata_alias'].'/'.$r['alias']) ?>/"><?php echo $r['tieu_de'] ?></a>
		<span class="gray"> x <?php echo $r['n_used'] ?></span>
        </li>
        <?php    
} ?>

</ul>
</div>
<?php echo $items['split_page'];?>