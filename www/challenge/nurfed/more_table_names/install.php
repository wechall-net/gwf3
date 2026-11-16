<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::install(__DIR__, function() {
    # See secret.php for more install!!!!
    $secret = require __DIR__.'/secret.php';
    return $secret['flag'];
});
?>
