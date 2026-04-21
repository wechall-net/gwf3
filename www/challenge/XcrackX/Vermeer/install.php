<?php
$solution = require('solution.php');
chdir("../../../");
require_once("challenge/html_head.php");
$title = 'Vermeer';
html_head("Install: $title");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$score = 3;
$url = "challenge/XcrackX/Vermeer/index.php";
$creators = "XcrackX";
$tags = 'Logic,Image,Steganos';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, WC_Challenge::CASE_I);

require_once("challenge/html_foot.php");
?>
