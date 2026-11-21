<?php
chdir("../../../");
require_once("challenge/html_head.php");
define('GWF_PAGE_TITLE', 'Babbage and Coldplay');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$solution = require 'solution.php';
$score = 3;
$url = "challenge/ludde/babbage_and_coldplay/index.php";
$creators = "ludde";
$tags = 'Audio,Math,Stegano';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
