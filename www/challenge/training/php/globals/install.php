<?php
require_once dirname(__DIR__, 3).'/WCChallenge.php';
WCChallenge::install(__DIR__, function() { require_once __DIR__.'/installdb.php'; return install_challenge(); });
