<?php
# Highlighter Plain
if (isset($_GET['show']) && $_GET['show'] === 'source') {
    header('Content-Type: text/plain; charset=utf8;');
    echo file_get_contents(__FILE__);
    die();
}

# Change dir to web root to print the website header
require_once dirname(__DIR__, 4).'/WCChallenge.php';

###############################
### Here is your exploit :) ###
###############################
$code = '$filename = \'pages/\'.(isset($_GET["file"])?$_GET["file"]:"welcome").\'.html\';';
$code_emulate_pnb = '$filename = Common::substrUntil($filename, "\\0");'; # Emulate Poison Null Byte for PHP>=5.3.4
$code2 = 'include $filename;';
### End of exploit ###

WCChallenge::run(dirname(__DIR__), array(
    'code' => function() use ($code, $code2) {
        return GWF_Message::display('[PHP]'.$code.PHP_EOL.$code2.'[/PHP]');
    },
    'minus' => function() {
        $minus = GWF_User::getByName('minus');
        return false === $minus ? '' : $minus->displayProfileLink();
    },
), array(
    'challenge_after' => function($translations, $placeholders) use ($code, $code2, $code_emulate_pnb) {
        return trainingPhpLfiAfter($code, $code2, $code_emulate_pnb, $translations, $placeholders);
    },
));

# Execute the vulnerable script and show the result.
function trainingPhpLfiAfter($code, $code2, $code_emulate_pnb, $translations, $placeholders) {
    # Highlighter BBCode
    if (isset($_GET['highlight']) && $_GET['highlight'] === 'christmas') {
        return WCChallenge::sourceCode(__FILE__);
    }

    # Execute the code, using eval.
    GWF_Debug::setDieOnError(false);
    GWF_Debug::setMailOnError(false);
    ob_start();
    eval($code.$code_emulate_pnb); # Eval the first line.

    $output = '<div class="box">'.PHP_EOL;
    $title = $translations['example_title'];
    $output .= '<div class="box_t">'.htmlspecialchars($title).' ('.htmlspecialchars($filename).')</div>'.PHP_EOL;
    $output .= '<div class="box_c">'.PHP_EOL;
    if (lfiIsSafeDir($filename) === true) { eval($code2); } # Eval the second line, when safe.
    else { $output .= GWF_HTML::error('LFI', $translations['err_basedir'], false); }
    $output .= ob_get_clean();
    $output .= '</div>'.PHP_EOL.'</div>'.PHP_EOL;
    GWF_Debug::setMailOnError(true);
    GWF_Debug::setDieOnError(true);
    $minus = isset($placeholders['minus']) ? $placeholders['minus'] : '';
    if (is_callable($minus)) {
        $minus = call_user_func($minus);
    }
    $credits = str_replace('{minus}', $minus, $translations['credits']);
    $output .= GWF_Box::box($credits);
    return $output;
}

# Safety first.
function lfiIsSafeDir($filename) {
    return in_array(dirname($filename), array('pages', 'pages/../..', 'pages/..'), true);
}
