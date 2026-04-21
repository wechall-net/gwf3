<?php
require_once __DIR__ . 'challenge.php';
chdir("../../../");
define('GWF_PAGE_TITLE', 'Towers of Hanoi');
require_once("challenge/html_head.php");

if (false === ($chall = WC_Challenge::getByTitle("Towers of Hanoi"))) {
	$chall = WC_Challenge::dummyChallenge("[Towers of Hanoi]");
}
$chall->showHeader();

if (isset($_GET['solution']))
{
	if (strtolower($_GET['solution']) === require __DIR__ . 'solution.php')
	{
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
	else {
		echo WC_HTML::error('err_wrong');
	}
}

echo GWF_Box::box($chall->lang('info'));

?>
<div style="margin: 10px 20px;">
	<applet code="Tower.class" archive="hanoi2.jar" width=800 height=450></applet>
</div>
<?php
echo $chall->copyrightFooter();
require_once 'challenge/html_foot.php';
?>
