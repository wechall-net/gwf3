<?php
$solution = require 'solution.php';
chdir("../../../");
require_once("challenge/html_head.php");
html_head("[WeChall] Install Stegano Woman");

if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("You need to be admin");
}

$title = "Stegano Woman";
$score = 3;
$url = "challenge/Z/stegano_woman/index.php";
$creators = "Z";
$tags = 'Stegano';

echo WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");

?>
