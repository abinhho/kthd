<table class="feed" width="100%">
<caption>Danh sách các danh mục</caption>
<thead>
<tr>
<td>STT</td>
<td>Tiêu đề</td>
</tr>
</thead>
<tbody class="main_tbody">
<?php 
$i = 1;
$this->lib_url->this_module = "tags";
foreach($items as $row)
{
		//$link_edit=$TB_url->change_url_arr("",array("op"=>"add", "id"=>$row['ID']) );
		?>
		<tr>
        <td><?php echo $i ?></td>
		<td><a href="<?php echo $this->lib_url->change_url('', array('catid' => $row['ID'] )) ?>"><?php echo $row['tieu_de']; ?></a></td>
		</tr>
		<?php 
		$i++;
}
?>
</tbody>
</table>