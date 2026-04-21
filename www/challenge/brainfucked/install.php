<?php
$solution = require 'solution.php';
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Brainfucked');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$score = 5;
$url = 'challenge/brainfucked/index.php';
$creators = 'Gizmore';
$tags = 'Special';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
