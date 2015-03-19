<?php
$lui="../../../";
include $lui."library/autoload.php";
$TB_image=new TB_image();
$TB_upload=new TB_upload();
$TB_string_array=new TB_string_array();
$dir_upload=$lui."images/hinh_anh/";
$temp="images/temp/";
$temp_dir=$lui.$temp;

if($_POST['location'] == "com")
{
	$name_image = $TB_upload->upload_image($temp_dir,$newfilename="",$w=600,$myfile="FILE_COM",$check_exist=false);
	if($name_image==-1)
	{
		$feed=array("ok" => false,"error" => "Lổi, định dạng không cho phép, vui lòng chỉ chọn ảnh dạng .jpg,.jpeg,.png,.gif");
	}
	elseif($name_image==-2)
	{
		$feed=array("ok" => false,"error" => "Lổi, kích thước ảnh quá lớn");
	}
	elseif($name_image==-3)
	{
		$feed=array("ok" => false,"error" => "Lổi, vui lòng chọn file để upload");
	}
	elseif($name_image=="")
	{
		$feed=array("ok" => false,"error" => "Lổi, vui lòng thử lại sau");
	}
	else
	{
		$feed=array("ok" => true,"name_image" =>$name_image
		,"app" =>"<li><img src='".HOME_PATH."/".$temp.$name_image."' ><a href='#' onclick=\"return unlink({link:'".$temp.$name_image."',name_image:'".$name_image."',this_:$(this)})\" class='del'>Xóa</a></li>"
		);
	}
	
}
else
{
	if($_POST['FILE_WEB']=="")
	{
		$feed=array("ok" => false,"error" => "Lổi, vui lòng nhập link hình ảnh");
	}
	else
	{ 
		if($TB_image->check_image($_POST['FILE_WEB']))
		{
			$name_image=$TB_upload->saved_img($temp_dir,@$_POST['FILE_WEB'],600,$crop=false);
			$feed=array("ok" => true,"name_image" =>$name_image
			,"app" =>"<li><img src='".HOME_PATH."/".$temp.$name_image."' ><a href='#' onclick=\"return unlink({link:'".$temp.$name_image."',name_image:'".$name_image."',this_:$(this)})\" class='del'>Xóa</a></li>"
			);
		}
		else
		{
			$feed=array("ok" => false,"error" => "Có lổi xãy ra, vui lòng thử lại");
		}
	}
	
}
?>

<script type="text/javascript">
parent.feed_back_upload_image_advance(<?php echo json_encode($feed); ?>);
</script>


