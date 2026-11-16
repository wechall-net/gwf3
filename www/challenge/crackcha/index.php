<?php
require_once __DIR__.'/crackcha.php';
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'time' => function() { return GWF_Time::humanDuration(WCC_CRACKCHA_TIME); },
    'need' => WCC_CRACKCHA_NEED,
));
