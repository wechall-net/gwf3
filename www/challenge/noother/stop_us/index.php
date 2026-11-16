<?php
if (isset($_GET['show']) && is_string($_GET['show'])) {
    if ($_GET['show'] === 'source') {
        header('Content-Type: text/plain; charset=UTF-8;');
        die(file_get_contents('nootherdomain.php'));
    }
    if ($_GET['show'] === 'noothtable') {
        header('Content-Type: text/plain; charset=UTF-8;');
        die(file_get_contents('noothtable.php'));
    }
}
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'test' => 'index.php?show=source',
    'source' => 'index.php?show=source',
    'highlight' => 'index.php?highlight=christmas',
    'table' => 'index.php?show=noothtable',
    'table_highlight' => 'index.php?highlight=noothtable',
    'jjk' => 'jjk',
    'dloser' => 'dloser',
), array(
    'challenge_after' => function() {
        if (false === ($file = Common::getGetString('highlight', false))) {
            return '';
        }
        $file = $file === 'noothtable' ? 'noothtable.php' : 'nootherdomain.php';
        return GWF_Box::box(WCChallenge::sourceCode(__DIR__.'/'.$file, 'php', $file));
    },
));
