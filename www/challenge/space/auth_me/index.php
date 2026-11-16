<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'conf' => 'find_me/apache.conf',
    'httpd' => 'https://authme.wechall.net/challenge/space/auth_me/www/index.php',
));
