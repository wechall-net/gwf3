<?php
chdir('../../../../');
require_once("challenge/html_head.php");
define('GWF_PAGE_TITLE', 'Training: Caterpillar');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin!");
}

$solution = require 'solution.php';
$score = 2;
$url = 'challenge/training/stegano/caterpillar/index.php';
$creators = "Gizmore";
$tags = 'Stegano';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
