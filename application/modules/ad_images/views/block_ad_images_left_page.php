<?php if(count($items) > 0){ ?>
<div class="fixed_ad left_page" id="fixed_ad_left_page">
<?php  
foreach ($items as $row){
    
    echo "<a href = '{$row['hyperlink']}' title = '{$row['tieu_de']}'>";
    echo $this->lib_media->show($row['images'], $row['width'], $row['height'] , "alt='{$row['tieu_de']}'");
    echo "</a>";
}
?>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $("#fixed_ad_left_page").floatingFixed({pos:'left'});
});
</script>

<?php } ?>