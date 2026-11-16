<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::install(__DIR__, function() {
    require_once __DIR__.'/WC_Crackcha.php';
    if (false === GDO::table('WC_Crackcha')->createTable(true)) { die('Can not install crackcha table'); }
});
