<?php
$solution = require 'solution.php';
chdir("../../../");
require_once("challenge/html_head.php");
html_head("Install Simply Red");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Simply Red";
$score = 3;
$url = "challenge/anto/simply_red/index.php";
$creators = "anto";
$tags = 'Image,Stegano';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
