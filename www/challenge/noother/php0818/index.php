<?php
if (isset($_GET['show']) && is_string($_GET['show']))
{
    header('Content-Type: text/plain; charset=UTF-8;');
    die(file_get_contents(__DIR__.'/php0818.php'));
}
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'source' => 'index.php?show=source',
    'highlight' => 'index.php?highlight=christmas',
    'live' => 'php0818.php',
), array(
    'challenge_after' => function() {
        if (!isset($_GET['highlight'])) { return ''; }
        return GWF_Box::box(WCChallenge::sourceCode(__DIR__.'/php0818.php', 'php', 'PHP0818'));
    },
));
