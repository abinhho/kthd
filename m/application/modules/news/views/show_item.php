<div class="mod_news block_white show_news_item after">
<h1 class="title"><i class='color_ccc font12'>Chuyên mục:</i> <?php echo $title; ?></h1>

<div class="contents_bg after">
<?php $this->load->view("ext_filter/filter_topic"); ?>
<ul>
<?php foreach ($items as $row) { 
    $this->load->view("general_show_item", $row);
} ?>
</ul>
</div>
<?php echo $split_page;?>
</div>