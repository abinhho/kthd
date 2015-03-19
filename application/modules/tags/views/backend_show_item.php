<?php echo validation_errors('<div class="error_messenger">',"</div>"); ?>

<?php echo form_open($this->lib_url->getUrl()); ?>
<?php $js_add = 'onclick="return open_promt({title:\'Thêm tags mới\', url:\''.base_url('tags/backend_tags/edit/0/'.$_GET['catid']).'\'})"'; ?>
<table class="feed" width="100%">
<caption>Danh sách tags trong - - - -  <span class="font16">"<?php echo $catagory ?>"</span>- - - -  <?php echo anchor("#", "+ Thêm tags", $js_add); ?></caption>
<thead>
<tr>
<td><input type='checkbox' onclick="select_all_check_box($(this),'main_tbody')"></td>
<td><?php echo $this->lib_url->change_order_col("tieu_de","Tiêu đề")?></td>
<td><?php echo $this->lib_url->change_order_col("date_upd","Cập nhật cuối")?></td>
<td><?php echo $this->lib_url->change_order_col("active","Trạng thái")?></td>
<td width="140px" align="center">Hành động</td>
</tr>
</thead>
<tbody class="main_tbody">
<?php 
$i = 1;
$this->lib_url->this_module = "tags";
foreach($items as $row)
{
		//$link_edit=$TB_url->change_url_arr("",array("op"=>"add", "id"=>$row['ID']) );
        $js = 'onclick="return open_promt({title:\'Chỉnh sửa tags\', url:\''.base_url('tags/backend_tags/edit/'.$row['ID']).'\'})"';
		?>
		<tr>
		<td><?php echo form_checkbox('multi_select[]', $row['ID'], false)?></td>
		<td><?php echo $row['tieu_de']; ?></td>
		<td><?php echo $this->lib_date->ago($row['date_upd']) ; ?></td>
		<td><?php echo status_topic($row['active']) ; ?></td>
		<td align="center">
			<a class="edit" <?php echo $js; ?>>Sửa</a>
			<?php echo $this->lib_url->backend_link_del($row['ID']); ?>
		</td>
		</tr>
		<?php 
		$i++;
}
?>
</tbody>
</table>
<br/>
<?php echo form_submit('submit', "Xóa mục đã chọn"); ?>
<br/><br/>
<?php echo form_close(); ?>
<?php echo $split_page; ?>