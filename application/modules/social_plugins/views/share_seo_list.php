<?php
$arr_link = array(
'https://www.google.com/bookmarks/mark?op=add&bkmk=' => 'Google'
,'https://www.facebook.com/sharer/sharer.php?u=' => 'facebook'
,'http://www.reddit.com/submit?url=' => 'reddit'
,'https://www.stumbleupon.com/submit?url=' => 'stumpon'
,'http://www.pinterest.com/pin/create/button/?media=' => 'Pinterest'
,'https://delicious.com/post?url=' => 'Delicious'
,'http://www.linkedin.com/shareArticle?mini=true&url=' => 'LinkedIn'
,'https://twitter.com/intent/tweet?url=' => 'Twitter'
,'http://www.tumblr.com/share?v=3&u=' => 'tumblr'
,'http://friendfeed.com/?url=' => 'friendfeed'
,'http://digg.com/submit?url=' => 'Digg'
,'http://linkhay.com/submit?link_url=' => 'linkhay'
,'https://www.blogger.com/blog-this.g?u=' => 'Blogger'
)
?>
<br />
<div class="share_hidden block font12">
<?php
$url = $this->lib_url->host().$url;

$tieu_de = urlencode($tieu_de);
$description = urlencode($description);

foreach($arr_link as $key => $name)
{

	$u = $key.urlencode($url);
	
	if($name == 'Blogger') $u = $u.'&n='.@$tieu_de.'&t='.@$description;
	elseif($name == 'Google') $u = $u.'&title='.@$tieu_de.'&annotation='.@$description;
	elseif($name == 'reddit' || $name == 'friendfeed') $u = $u.'&title='.@$tieu_de;
	elseif($name == 'Pinterest') $u = $u.'&description='.@$tieu_de.'&media='.$this->lib_url->host().'/assets/images/og_icon.png';
	elseif($name == 'Delicious') $u = $u.'&title='.@$tieu_de.'&notes='.@$description;
	elseif($name == 'LinkedIn') $u = $u.'&title='.@$tieu_de.'&summary='.@$description;
	elseif($name == 'Twitter') $u = $u.'&text='.@$tieu_de;
	elseif($name == 'tumblr') $u = $u.'&t='.@$tieu_de.'&s='.@$description;
	
	echo "<a href='".$u."' target='_blank'>".$name."</a> | ";
}
?>
</div>