<?php  ഀ
if($_GET['url'] != ""){ഀ
$url = $_GET['url']  ഀ
$ch = @curl_init();  ഀ
curl_setopt($ch, CURLOPT_URL, $url);  ഀ
$head[] = "Connection: keep-alive";  ഀ
$head[] = "Keep-Alive: 300";  ഀ
$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";  ഀ
$head[] = "Accept-Language: en-us,en;q=0.5";  ഀ
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');  ഀ
curl_setopt($ch, CURLOPT_HTTPHEADER, $head);  ഀ
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  ഀ
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  ഀ
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  ഀ
curl_setopt($ch, CURLOPT_TIMEOUT, 60);  ഀ
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);  ഀ
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  ഀ
curl_setopt($ch, CURLOPT_HTTPHEADER, array(  ഀ
'Expect:'  ഀ
));  ഀ
$page = curl_exec($ch);  ഀ
curl_close($ch);  ഀ
return $page;  ഀ
}  ഀ
if(isset($_POST)){  ഀ
$urls = explode(",",$_POST['video']);  ഀ
$count = count($urls);  ഀ
if($urls['0'] == NULL){$count = 0;}  ഀ
if($count != 0 ){  ഀ
foreach($urls as $url){  ഀ
$string= onbox(trim($url));  ഀ
preg_match("#<iframe.*src='(.*)'.*>#imsU", $string, $onbox);  ഀ
$string2 = onbox($onbox[1]);  ഀ
preg_match("#file: '(.*)'#imsU", $string2, $link_video);  ഀ
$link_video = str_replace("8080", "8181", $link_video);  ഀ
$link_video = str_replace("203.190.170.158", "203.190.170.44", $link_video);  ഀ
$link_video = str_replace("203.190.170.159", "203.190.170.45", $link_video);  ഀ
echo $link_video[1]."<br />";  ഀ
}  ഀ
ഀ
}  ഀ
} ഀ
 ഀ
?>  ഀ
