<?php
$solution = require 'solution.php';
chdir("../../");
require_once("challenge/html_head.php");
html_head("Install This cookie is a lie Challenge");

if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "The Cookie is a lie";
$score = 7;
$url = "challenge/cookie_is_a_lie/index.php";
$creators = "Z";

htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>
