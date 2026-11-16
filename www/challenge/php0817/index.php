<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'code' => function() { return WCChallenge::sourceCode(__DIR__.'/php0817.include'); },
), array(
    'challenge_after' => function($translations) {
        $chall = WC_Challenge::getByTitle('PHP 0817');
        $which = Common::getGetString('which', '');
        if (strpos($which, '/') !== false) {
            return GWF_HTML::error('PHP 0817', $translations['err_security']);
        }
        GWF_Debug::setMailOnError(false);
        ob_start();
        require __DIR__.'/php0817.include';
        $output = ob_get_clean();
        GWF_Debug::setMailOnError(true);
        return '<div class="box box_c">'.$output.'</div>';
    },
));
