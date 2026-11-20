<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'mime_url' => 'http://themimefiles.warchall.net',
    'source_url' => 'https://github.com/wechall-net/gwf3/tree/master/www/challenge/TheMimeFiles/www',
));
