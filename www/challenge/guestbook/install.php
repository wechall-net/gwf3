<?php
chdir("../../");
require_once("challenge/html_head.php");
html_head("Install No Escape");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

require_once __DIR__.'/secrets.php';

require_once 'gbook.include';

gbook_createTables();
gbook_insertRows();

$title = 'The Guestbook';
$solution = require_once __DIR__.'/solution.php';
$score = 4;
$url = "challenge/guestbook/index.php";
$creators = "Gizmore";
$tags = 'Exploit,PHP,MySQL';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
