<?php
chdir("../../../");
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Training: Warchall - The Beginning');
html_head("Install: ".GWF_PAGE_TITLE);
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$solution = require 'solution.php';
$score = 2;
$url = "challenge/warchall/begins/index.php";
$creators = "gizmore,noother,bsdhell,livinskull,jjk,kwisatz";
$tags = 'Realistic,Linux,Shell';

WC_Challenge::installChallenge(GWF_PAGE_TITLE, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
?>
