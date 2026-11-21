<?php
chdir("../../../");
require_once("challenge/html_head.php");
define('GWF_PAGE_TITLE', 'Choose your Path');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}

$solution = require 'solution.php';
$score = 2;
$url = 'challenge/warchall/choose_your_path/index.php';
$creators = "Mart,Gizmore";
$tags = 'Linux,Exploit';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
