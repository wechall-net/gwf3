<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';

WCChallenge::run(__DIR__, array(
), array(
	'check' => function($answer, $chall) {
		$chall->onCheckSolution(md5(preg_replace('/[^a-z]/', '', strtolower($answer))));
		return array('handled' => true);
	},
));
