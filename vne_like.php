<?php
$commentId = $_GET['commentId'];
$articleId = $_GET['articleId'];//echo $articleId; echo $commentId;
$nLike = $_GET['nLike'];
for ($i = 0; $i <= $nLike; $i++) {
	$tokenKey = uniqid() . uniqid();
	$cookieAid = uniqid() . uniqid();
	$url = 'http://interactions.vnexpress.net/index/liketoggle?callback=jQuery17109007991217076778_1426556712539&commentid='
		.$commentId. '&status=1&article_id=' .$articleId. '&objecttype=1&cookie_aid='. $cookieAid .'&userid=&token_key='
		.$tokenKey. '&_=14265563785868';
	echo file_get_contents($url);
	echo '<br />';
}
//http://kienthuchoidap.com/vne_like.php?nLike=1000&commentId=10822843&articleId=3158286
?>