<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'The Nap');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle("The Nap"))) {
	$chall = WC_Challenge::dummyChallenge('The Nap', 0, 'challenge/the_nap');
}
$chall->showHeader();
$chall->onCheckSolution();
echo GWF_Box::box($chall->lang('info', array('codebook.jpg')), $chall->lang('title'));
echo $chall->copyrightFooter();
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
