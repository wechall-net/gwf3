<?php
$solution = require('solution.php');
chdir("../../../");
require_once("challenge/html_head.php");
$title = 'Zebra';
html_head("Install: $title");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$score = 3;
$url = "challenge/Hirsch/Zebra/index.php";
$creators = "hirsch";
$tags = 'Training,Encoding,Stegano';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
