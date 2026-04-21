<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Zebra');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/Hirsch/Zebra/index.php', 'saFFari');
}
$chall->showHeader();

if (!hirsch_zebra_egg($chall)) {
	$chall->onCheckSolution();
}

$title = $chall->lang('title');
echo GWF_Box::box($chall->lang('info'), $title);

$path = 'zebra.png';
$image = sprintf('<img src="%s" width="120" height="60" alt="%s" title="%s" style="padding-left:100px;" />', $path, $title, $title).PHP_EOL;
echo '<div class="fl">'.GWF_Box::box(str_repeat( str_repeat('&nbsp;', 42).'<br/>',4) ).'</div>';
echo '<div><br/>'.$image.'</div>';
echo '<div class="cb"></div>';
//echo GWF_Box::box($image);#, $chall->lang('img_title'));

formSolutionbox($chall, 14);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');

function hirsch_zebra_egg(WC_Challenge $chall)
{
	$eggs = array(
		'africa' => 'in Africa.',
		'zoo' => 'back in the Zoo.',
		'zebra' => 'a zebra.',
		'trunk' => 'in the trunk.',
		'city' => 'in New York.',
		'here' => 'right here, you found it! \\o/ ',
		'there' => 'right there, you found it! \\o/ ',
		'home' => 'returning home.',
		'hirsch' => 'a Hirsch in disguise.',
		'meme' => 'a Mammal.',
		'lol' => 'laughing.',
		'internet' => 'an internet. You won a Zebra ... and ... ',
	);
	
	if ('' !== ($answer = Common::getPostString('answer')))
	{
		$answer = strtolower($answer);
		foreach ($eggs as $egg => $txt)
		{
			if (strpos($answer, $egg) !== false)
			{
				echo GWF_HTML::message('Zebra', $chall->lang('msg_egg', array(htmlspecialchars($txt))));
				return true;
			}
		}
	}
	return false;
}
?>