<?php
require_once dirname(__DIR__).'/WCChallenge.php';
$files = array('code.php', 'insecure.inc.php', 'SERIAL_LoginForm.php', 'SERIAL_LogoutForm.php', 'SERIAL_Solution.php', 'SERIAL_User.php');
$placeholders = array();
foreach ($files as $i => $file) {
    $placeholders['a'.($i + 1)] = '<a href="index.php?show='.$file.'">'.$file.'</a>';
}
$placeholders['code'] = 'index.php?highlight=code.php';
WCChallenge::run(__DIR__, $placeholders);
