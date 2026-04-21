<?php
$solution = require('solution.php');
chdir("../../../");
require_once("challenge/html_head.php");
$title = 'Speed Your Way To VICtory';
html_head("Install: $title");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$score = 6;
$url = "challenge/Jander/victory/index.php";
$creators = "Jander";
$tags = 'Encoding,Audio,Crypto';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
