<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'DropDaBass');
require_once('challenge/html_head.php');
require GWF_CORE_PATH.'module/WeChall/solutionbox.php';

if (false === ($chall = WC_Challenge::getByTitle('DropDaBass'))) {
	$chall = WC_Challenge::dummyChallenge('DropDaBass', 4);
}
$chall->showHeader();

echo GWF_Box::box($chall->lang('info', array('dropdabass.zip')), $chall->lang('title'));


$chall->onCheckSolution();
formSolutionbox($chall);
echo $chall->copyrightFooter();

require_once 'challenge/html_foot.php';
?>