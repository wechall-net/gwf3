<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array('home' => 'http://rfi.warchall.net', 'warchall' => function() { return GWF_WEB_ROOT.'challenge/warchall/begins/index.php'; }));
