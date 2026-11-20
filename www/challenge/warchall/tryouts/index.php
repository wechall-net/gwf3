<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'matrixman' => '<a href="/profile/matrixman">matrixman</a>',
    'home' => '<i>/home/level/matrixman/13_tryouts</i>',
    'war_url' => function() { return GWF_WEB_ROOT.'challenge/warchall/begins/index.php'; },
));
