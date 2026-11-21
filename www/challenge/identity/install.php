<?php
chdir("../../");
require_once("challenge/html_head.php");
$title = 'Identity';
html_head("Install: $title");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = require 'solution.php';
$score = 4;
$url = "challenge/identity/index.php";
$creators = "gizmore";
$tags = 'Realistic,Research';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
