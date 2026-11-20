<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'username' => function() { return GWF_User::getStaticOrGuest()->displayUsername(); },
    'phpgdo' => 'https://github.com/gizmore/phpgdo',
    'modules' => 'https://github.com/gizmore/phpgdo/blob/main/DOCS/GDO7_MODULES.md',
    'core' => 'https://github.com/gizmore/phpgdo/tree/main/GDO',
    'installation' => 'https://github.com/gizmore/phpgdo/blob/main/DOCS/GDO7_INSTALLATION.md',
    'computer' => 'http://localhost:80',
    'halloffame_url' => 'https://github.com/gizmore/phpgdo/blob/main/DOCS/GDO7_THX.md',
    'modules_url' => 'https://github.com/gizmore/phpgdo/blob/main/DOCS/GDO7_MODULES.md',
    'gwf3_url' => 'https://github.com/wechall-net/gwf3',
    'wechall_url' => 'https://github.com/wechall-net/gwf3/tree/master/core/module/WeChall',
), array(
    'challenge_after' => function($translations, $placeholders) {
        $values = array(
            '{halloffame_url}' => 'https://github.com/gizmore/phpgdo/blob/main/DOCS/GDO7_THX.md',
            '{modules_url}' => 'https://github.com/gizmore/phpgdo/blob/main/DOCS/GDO7_MODULES.md',
            '{gwf3_url}' => 'https://github.com/wechall-net/gwf3',
            '{wechall_url}' => 'https://github.com/wechall-net/gwf3/tree/master/core/module/WeChall',
        );
        return GWF_Box::box(strtr($translations['halloffame'], $values)).
            GWF_Box::box(strtr($translations['modules'], $values)).
            GWF_Box::box(strtr($translations['alternate'], $values)).
            "\n<!-- https://www.youtube.com/watch?v=DfN_ZMmiLQw -->\n";
    },
));
