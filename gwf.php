<?php
$apikey = 'AIzaSyBnAo7i9XtYUAuD3vQot-PEL3EVhhQPk4w';
$cachefile = 'fonts.json';
$cachetime = 60 * 60;
// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    include($cachefile);
    exit;
}
ob_start(); // Start the output buffer

/* The code to get the google web fonts list goes here */
$ch = curl_init('https://www.googleapis.com/webfonts/v1/webfonts?key=' . $apikey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$content = curl_exec($ch);
echo $content;
curl_close($ch);

// Cache the output to a file
$fp = fopen($cachefile, 'w');
fwrite($fp, ob_get_contents());
fclose($fp);
ob_end_flush(); // Send the output to the browser
?>