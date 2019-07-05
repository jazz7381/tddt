<?php
// PHP code for getting dailymotion flv-path and more info.

//
// Author: Abdul Qabiz
// Jan 22, 2008
//

//Params:- Requires dailymotion video_id

// USAGE:-
// 1) For information
// http://server/dailymotion.php?video_id=<video_id>&redirect=true
// Above invocation would return:- 
// flv=<flvPath>&thumbnail=<previewURL>
// Example:-
// URL: http://server/dailymotion.php?video_id=x44ls3&redirect=false
//
// Result:-
// flv=http://www.dailymotion.com/get/15/320x240/flv/6933315.flv?key=69f63205c80b5b5d188a10e0b7656a421316ee3&previewURL=http://limelight-315.static.dailymotion.com/dyn/preview/320x240/6933315.jpg?20080122041
//

// 2) For redirection to flv i.e. video_id to flv
// http://server/dailymotion.php?video_id=<video_id>&redirect=true
// Above invocation would redirect to dailymotion flv URL

if (isset ($_GET ['video_id']) == FALSE)
{
	echo "video_id is required";
	exit;
}

// Requires dailymotion video_id
$url = 'http://www.dailymotion.com/swf/' . $_GET['video_id'];

if (isset($_GET['redirect']) == FALSE)
{
	$redirect = 'true';
}

//Start the Curl session
$session = curl_init($url);

// Don't return HTTP headers. Do return the contents of the call
curl_setopt($session, CURLOPT_HEADER, true);
curl_setopt($session, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');

//curl_setopt($session,CURLOPT_NOBODY, true);

curl_setopt($session, CURLOPT_FOLLOWLOCATION, false); 

//curl_setopt($ch, CURLOPT_TIMEOUT, 4); 
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// Make the call
$response = curl_exec($session);
$error = curl_error($session);
$result = array( 'header' => '',
                         'body' => '',
                         'curl_error' => '',
                         'http_code' => '',
                         'last_url' => '');
if ( $error != "" )
{
	$result['curl_error'] = $error;
}
else
{

       
	$header_size = curl_getinfo($session,CURLINFO_HEADER_SIZE);
        $result['header'] = substr($response, 0, $header_size);
        $result['body'] = substr( $response, $header_size );
        $result['http_code'] = curl_getinfo($session, CURLINFO_HTTP_CODE);
	$result['last_url'] = curl_getinfo($session, CURLINFO_EFFECTIVE_URL);

	list($header,  $result['header']) = explode("\n\n",  $result['header'], 2);

	$matches = array();
	preg_match('/Location:(.*?)\n/', $header, $matches);
	$urlInfo = parse_url(trim(array_pop($matches)));
	//$newUrl = $urlInfo['scheme'] . '://' . $urlInfo['host'] . $urlInfo['path'] . ($urlInfo['query']?'?'.$urlInfo['query']:'');
	parse_str($urlInfo['query'], $output);

	$flvURL = $output ['url'];
	$thumbnailURL = $output['previewURL'];

	if ($redirect == "true")
	{
		header ("Location: ". $flvURL, TRUE, 303);
	}
	else
	{
		echo sprintf ("flv=%s&thumbnail=%s", $flvURL, $thumbnailURL);
	}
	
	
}

curl_close($session);
?>
