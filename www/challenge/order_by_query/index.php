<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Order By Query');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle('Order By Query'))) {
	$chall = WC_Challenge::dummyChallenge('Order By Query', 7);
}

$chall->showHeader();

$chall->onCheckSolution();

GWF_Debug::setMailOnError(false);

# Mission
//$src_link = sprintf('<a href="orderbyquery.include">source of the view scripts</a> also as <a href="index.php?highlight=christmas">highlighted version</a>');
//htmlTitleBox(
//'Description', 
//'Your mission is to find out the Admins password. Please submit the md5 hash as solution.<br/>'.
//'You are given the '.$src_link.'.<br/>'.
//'<a href="index.php?by=3">Click here to see the script in action</a>.<br/>'.
//'<br/>'.
//'Good Luck.<br/>');

htmlTitleBox($chall->lang('title'), $chall->lang('info', array('orderbyquery.include', 'index.php?highlight=christmas', 'index.php?by=3')));

require_once __DIR__.'/secrets.php';
require_once 'orderbyquery.include';

if (false !== ($by = Common::getGet('by')))
{
	addslash2_sort($by, Common::getGet('dir', 'DESC'));
}
elseif (false !== Common::getGet('highlight')) {
	$msg = file_get_contents('challenge/order_by_query/orderbyquery.include');
	$msg = '[code=php title=orderbyquery.include]'.$msg.'[/code]';
	echo GWF_Box::box(GWF_Message::display($msg, true, true, true));
}

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
