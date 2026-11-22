<?php
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'World of Wonders');

html_head('Install: '.GWF_PAGE_TITLE);

if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin !');
}


$title = GWF_PAGE_TITLE;
$solution = require 'solution.php';
$score = 7;
$url = 'challenge/world_of_wonders/index.php';
$creators = 'Gizmore';
$tags = 'Fun,Stegano';
$verbose = true;
$options = WC_Challenge::CASE_I|WC_Challenge::NO_SPACES|WC_Challenge::HASHED_PASSWORD;

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, $verbose, $options);

require_once('challenge/html_foot.php');
