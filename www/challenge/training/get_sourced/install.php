<?php
chdir("../../../");
require_once("challenge/html_head.php");

if (!GWF_User::isAdminS()) {
	return;
}

$title = "Training: Get Sourced";
$solution = require 'solution.php';
$score = 1;
$url = "challenge/training/get_sourced/index.php";
$creators = "Gizmore";
$tags = 'Training';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
