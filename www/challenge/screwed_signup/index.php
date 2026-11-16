<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
), array(
    'challenge_after' => function($translations, $placeholders) {
        $highlight = array('src' => 'screwed_signup.include', 'Login' => 'login.php', 'Register' => 'register.php');
        $key = Common::getGet('hl');
        $links = '<div class="box box_c"><div style="margin: 4px;"><a href="'.$placeholders['register_file'].'">'.$translations['btn_register'].'</a></div><div style="margin: 4px;"><a href="'.$placeholders['login_file'].'">'.$translations['btn_login'].'</a></div></div>';
        if (!isset($highlight[$key])) {
            return $links;
        }
        $file = $highlight[$key];
        return GWF_Box::box(WCChallenge::sourceCode(__DIR__.'/'.$file, 'php', $file)).
            $links;
    },
));
