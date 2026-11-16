<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array('warchall' => function() { return GWF_WEB_ROOT.'challenge/warchall/begins'; }));
