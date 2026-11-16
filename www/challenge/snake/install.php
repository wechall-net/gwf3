<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::install(__DIR__, function() {
    $_GET['installing'] = true;
    require_once __DIR__.'/CGI_Highscore.php';
    GDO::table('Snake_row')->createTable(true);
});
