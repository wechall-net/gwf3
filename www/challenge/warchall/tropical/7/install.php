<?php
chdir("../../../../");
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Training: Warchall - 7 Tropical Fruits');
html_head("Install: ".GWF_PAGE_TITLE);
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$solution = require 'solution.php';
$score = 7;
$url = "challenge/warchall/tropical/7/index.php";
$creators = "tropic";
$tags = 'Realistic,Linux,Shell';
WC_Challenge::installChallenge(GWF_PAGE_TITLE, $solution, $score, $url, $creators, $tags, true);
require_once('challenge/html_foot.php');
?>
