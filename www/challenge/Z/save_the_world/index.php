<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'Save the World');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle('Save the World'))) {
	$chall = WC_Challenge::dummyChallenge('Save the World');
}
$chall->showHeader();
$chall->onCheckSolution();
echo GWF_Box::box($chall->lang('info'));
?>
<div class="box box_c">
	<p>The solution is the last 20 digits of the symmetric key(m)</p>
	<?php
	formSolutionbox($chall);
	?>
</div>
<?php
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
