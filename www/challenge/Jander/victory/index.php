<?php
$solution = require('solution.php');
chdir('../../../');
define('GWF_PAGE_TITLE', 'Speed Your Way To VICtory');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/Jander/victory/index.php', $solution);
}
$chall->showHeader();
$chall->onCheckSolution();

$href = 'sywtv.wav';
echo GWF_Box::box($chall->lang('info', array($href)), $chall->lang('title'));

echo formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
