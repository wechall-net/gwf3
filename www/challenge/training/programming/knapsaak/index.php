<?php
require_once dirname(__DIR__, 3).'/WCChallenge.php';
require_once __DIR__.'/salesman.php';
WCChallenge::run(__DIR__, array(
    'count' => WCC_TR_CU_COUNT,
    'timeout' => WCC_TR_CU_TIMEOUT,
));
