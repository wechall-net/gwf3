<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::install(__DIR__, function() {
    require_once __DIR__.'/noothtable.php';
    if (false === GDO::table('noothtable')->createTable(true)) { die('ouch'); }
});
