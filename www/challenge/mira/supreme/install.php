<?php
$secret = require 'secret.php';
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "Supreme");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$score = 3;
$url = 'challenge/mira/supreme/index.php';
$creators = 'gizmore,mira';
$tags = 'Cracking,Special';

WC_Challenge::installChallenge($title, $secret, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
