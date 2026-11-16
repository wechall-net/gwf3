<?php
require_once dirname(__DIR__, 3).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(), array(
    'request' => function($chall) {
        require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
        WC_CryptoChall::checkSolution(
            $chall,
            require __DIR__.'/secret.php',
            true,
            false
        );
        return array('handled' => true);
    },
));
