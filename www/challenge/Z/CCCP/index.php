<?php
$solution = require 'solution.php';
chdir('../../../');
define('GWF_PAGE_TITLE', 'CCCP');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');

if (false === ($chall = WC_Challenge::getByTitle('Credit Card Challenge Pwned!'))) {
	$chall = WC_Challenge::dummyChallenge('Credit Card Challenge Pwned!', 7, GWF_WEB_ROOT.'/challenge/Z/CCCP/index.php', $solution);
}
$chall->showHeader();

$chall->onCheckSolution();

if (Common::getGet('highlight')) {
	cccp_highlight_source();
} 

else {
	# Print Mission
	echo GWF_Box::box($chall->lang('index_info'), $chall->lang('index_title'));
}

function cccp_highlight_source()
{
	$msg = file_get_contents('challenge/Z/CCCP/query.include');
	$msg = '[code=php title=query.include]'.$msg.'[/code]';
	echo GWF_Box::box(GWF_Message::display($msg));
}

formSolutionbox($chall);

//echo '<div style="margin: 8px;">Many Thanks to <a href="'.GWF_WEB_ROOT.'profile/mego">mego</a> and <a href="'.GWF_WEB_ROOT.'profile/Vampire">Vampire</a> for their effort in BetaTesting</div>';
echo '<div style="margin: 8px;">'.$chall->lang('thanks', array('<a href="'.GWF_WEB_ROOT.'profile/mego">mego</a>', '<a href="'.GWF_WEB_ROOT.'profile/Vampire">Vampire</a>')).'</div>';

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
