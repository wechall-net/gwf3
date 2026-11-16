<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';

WCChallenge::run(__DIR__, array(
	'href' => 'babbage_and_coldplay.mp3',
), array(
	'check' => function($answer, $chall) {
		$chall->onCheckSolution(md5(preg_replace('/[^a-z]/', '', strtolower($answer))));
		return array('handled' => true);
	},
));
