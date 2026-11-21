<?php
$solution = require 'solution.php';
chdir('../../');
define('GWF_PAGE_TITLE', 'Brainfucked');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 5, 'challenge/brainfucked/index.php', $solution);
}
$chall->showHeader();

$chall->onCheckSolution();

$hinttext = $chall->lang('hint');
$hintcode = 'var f=document.createElement("script"); f.setAttribute("type","text/javascript"); f.setAttribute("src", "sourcecode.php"); document.getElementsByTagName("head")[0].appendChild(f);';
$hintcode = str_replace('"', '\'', $hintcode);
$hintlink = sprintf('<a href="#" onclick="%1$s">%2$s</a>', $hintcode, $hinttext); 
echo GWF_Box::box($chall->lang('info', array($hintlink)), $chall->lang('title'));

require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
