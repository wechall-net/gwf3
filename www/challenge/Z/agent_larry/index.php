<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'Agent Larry');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle("Agent Larry"))) {
	$chall = WC_Challenge::dummyChallenge('Agent Larry');
}
$chall->showHeader();
$chall->onCheckSolution();

# Is it legal, Z? ;)
$oracle_href = 'oradlls.zip';

echo GWF_Box::box(
	$chall->lang('info', array('dump.pcap', 'database.rar', $oracle_href, 'example.txt')),
	$chall->lang('title')
);

formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
