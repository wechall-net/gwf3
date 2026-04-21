<?php
$solution = require 'solution.php';
chdir("../../");
require_once("challenge/html_head.php");

if (!GWF_User::isAdminS()) {
	return;
}

$title = "Connect the Dots";
$score = 3;
$url = "challenge/connect_the_dots/index.php";
$creators = "galen";
$tags = 'Stegano,Training';

echo WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
