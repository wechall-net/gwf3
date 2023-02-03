<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'CGX: Binary Encoding BE');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/coding_ala_giz/02_04_still_binary/index.php', false);
}
$chall->showHeader();

function generateSolution()
{
	if (!($sol = GWF_Session::get('cag02')))
	{
		$sol = GWF_Random::randomKey(8, '01');
		GWF_Session::set('cag02', $sol);
	}
	return $sol;
}
$user = GWF_User::getStaticOrGuest();
$problem = generateSolution();
$problem = strrev($problem);
$solution = bindec($problem);

if (isset($_POST['answer']))
{
	if (false !== ($error = $chall->isAnswerBlocked($user)))
	{
		echo $error;
	}
	elseif ((string)$_POST['answer'] === (string)$solution)
	{
		$chall->onChallengeSolved($user->getID());
	}
	else
	{
		echo WC_HTML::error('err_wrong');
	}
}

echo GWF_Box::box($chall->lang('info', [$problem]), $chall->lang('title'));

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
