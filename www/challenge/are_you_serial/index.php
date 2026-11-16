<?php
require_once dirname(__DIR__).'/WCChallenge.php';
$files = array('code.php', 'insecure.inc.php', 'SERIAL_LoginForm.php', 'SERIAL_LogoutForm.php', 'SERIAL_Solution.php', 'SERIAL_User.php');
$placeholders = array();
foreach ($files as $i => $file) {
    $placeholders['a'.($i + 1)] = '<a href="index.php?ShowSource='.$file.'">'.$file.'</a>';
}
$placeholders['code'] = 'index.php?ShowSource=code.php';
$placeholders['challenge_trailer'] = function() use ($files) {
    $file = Common::getGetString('ShowSource', '');
    if (!in_array($file, $files, true)) {
        return '';
    }
    return WCChallenge::sourceCode(__DIR__.'/'.$file, 'php', $file);
};
$challengeAfter = $placeholders['challenge_trailer'];
unset($placeholders['challenge_trailer']);
WCChallenge::run(__DIR__, $placeholders, array(
    'challenge_after' => $challengeAfter,
));
