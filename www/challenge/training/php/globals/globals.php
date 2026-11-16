<?php
require_once dirname(__DIR__, 3).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(), array(
    'challenge_after' => 'trainingPhpGlobalsAfter',
));

function trainingPhpGlobalsAfter()
{
    $chall = WC_Challenge::getByTitle('Training: Register Globals');

    GWF_Debug::setDieOnError(false);
    GWF_Debug::setMailOnError(false);

    # EMULATE REGISTER GLOBALS = ON
    foreach ($_GET as $k => $v) { $$k = $v; }

    $output = '';

    # Send request?
    if (isset($_POST['password']) && isset($_POST['username']) && is_string($_POST['password']) && is_string($_POST['username']))
    {
        $uname = GDO::escape($_POST['username']);
        $pass = md5($_POST['password']);
        $query = "SELECT level FROM ".GWF_TABLE_PREFIX."wc_chall_reg_glob WHERE username='$uname' AND password='$pass'";
        $db = gdo_db();
        if (false === ($row = $db->queryFirst($query))) {
            $output .= GWF_HTML::error('Register Globals', $chall->trans('err_failed'));
        } else {
            # Login success
            $login = array($_POST['username'], (int)$row['level']);
        }
    }

    if (isset($login))
    {
        $output .= GWF_HTML::message('Register Globals', $chall->trans('msg_welcome_back', array(htmlspecialchars($login[0]), htmlspecialchars($login[1]))));
        if (strtolower($login[0]) === 'admin') {
            $chall->onChallengeSolved(GWF_Session::getUserID());
        }
    }
    else
    {
        $output .= '<form action="globals.php" method="post">'.PHP_EOL;
        $output .= '<table>'.PHP_EOL;
        $output .= '<tr><td>'.$chall->trans('th_username').':</td><td><input type="text" name="username" value="" /></td></tr>'.PHP_EOL;
        $output .= '<tr><td>'.$chall->trans('th_password').':</td><td><input type="password" name="password" value="" /></td></tr>'.PHP_EOL;
        $output .= '<tr><td></td><td><input type="submit" name="send" value="'.$chall->trans('btn_send').'" /></td></tr>'.PHP_EOL;
        $output .= '</table>'.PHP_EOL;
        $output .= '</form>'.PHP_EOL;
    }

    # EMULATE REGISTER GLOBALS = OFF
    foreach ($_GET as $k => $v) { unset($$k); }

    GWF_Debug::setMailOnError(true);
    GWF_Debug::setDieOnError(true);
    return $output;
}
