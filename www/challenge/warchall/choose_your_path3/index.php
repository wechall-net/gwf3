<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array('source' => function() {
    if (Common::getGetString('highlight') !== 'christmas') { return ''; }
    $source = file_get_contents('challenge/warchall/choose_your_path3/warchall/charp3.c');
    return GWF_Message::display('[code lang=C title=choose_your_path3.c]'. $source . '[/code]');
}));
