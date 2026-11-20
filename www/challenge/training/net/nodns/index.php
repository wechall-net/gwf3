<?php
require_once dirname(__DIR__, 3).'/WCChallenge.php';
WCChallenge::run(__DIR__, array('url' => function() {
    $domain = require __DIR__.'/domain.php';
    return 'https://'.$domain.'/challenge/training/net/nodns/etc/hosts.php';
}));
