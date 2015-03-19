<?php 
if(count($items) == 0) exit;
?>
<ul>
<?php
foreach($items as $row)
{
    ?>
    <li>
    <a class="tag_name each_tag" tag_name="<?php echo $row['tieu_de'] ?>" tag_id="<?php echo $row['ID'] ?>"><?php echo $row['tieu_de'] ?></a> 
     <span class="gray">x <?php echo $row['n_used'] ?></span>
     <i class="close"></i>
    </li>
    <?php
}
 ?>
</ul>