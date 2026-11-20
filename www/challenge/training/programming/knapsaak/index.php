<?php
require_once dirname(__DIR__, 3).'/WCChallenge.php';
require_once __DIR__.'/salesman.php';
WCChallenge::run(__DIR__, array(
    'problem' => 'problem.php',
    'answer' => 'answer.php',
    'count' => WCC_TR_CU_COUNT,
    'timeout' => WCC_TR_CU_TIMEOUT,
    'xkcd1' => 'http://xkcd.com/287/',
    'xkcd2' => 'http://xkcd.com/399/',
));
