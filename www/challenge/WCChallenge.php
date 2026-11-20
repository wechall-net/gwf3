<?php

use Symfony\Component\Yaml\Yaml;

final class WCChallenge
{
    public static function run($challengeDir, array $placeholders = array(), array $callbacks = array())
    {
        $definition = self::loadDefinition($challengeDir);
        $placeholders = array_merge(
            isset($definition['placeholders']) && is_array($definition['placeholders']) ? $definition['placeholders'] : array(),
            $placeholders
        );
        $wwwDir = dirname(__DIR__);
        $challengePath = self::challengePath($challengeDir, $wwwDir);

        define('GWF_PAGE_TITLE', $definition['title']);
        chdir($wwwDir);
        require_once 'challenge/html_head.php';
        require_once GWF_CORE_PATH . 'module/WeChall/solutionbox.php';

        $chall = WC_Challenge::getByTitle($definition['title']);
        if (false === $chall)
        {
            $chall = WC_Challenge::dummyChallenge(
                $definition['title'],
                $definition['score'],
                'challenge/' . $challengePath . '/index.php',
                false,
                0,
                $definition['creators'],
                $definition['tags']
            );
        }

        $translations = self::translations($definition, $challengeDir);
        $chall->showHeader();

        $handled = false;
        $hasSubmission = isset($_POST['answer']) || isset($_POST['submit']) || isset($_POST['solve']) || isset($_POST['try']) || isset($_POST['go']);
        if ($hasSubmission && isset($callbacks['request']))
        {
            $result = call_user_func($callbacks['request'], $chall, $definition, $translations);
            if ($result !== null)
            {
                self::displayCheckResult($result, $chall, $definition);
                $handled = true;
            }
        }
        if ($hasSubmission && !$handled)
        {
            $answer = isset($_POST['answer']) && is_string($_POST['answer']) ? $_POST['answer'] : '';
            if (isset($callbacks['check']))
            {
                $result = call_user_func($callbacks['check'], $answer, $chall, $definition);
                if ($result !== null)
                {
                    self::displayCheckResult($result, $chall, $definition);
                    $handled = true;
                }
            }
            elseif ($definition['solution'] === false)
            {
                $chall->onCheckSolution();
            }
            elseif (self::matches($answer, $definition['solution'], $challengeDir))
            {
                $chall->onChallengeSolved(GWF_Session::getUserID());
            }
            else
            {
                echo WC_HTML::error('err_wrong');
            }
        }

        if (array_key_exists('challenge_trailer', $placeholders))
        {
            if (is_callable($placeholders['challenge_trailer']))
            {
                $placeholders['challenge_trailer'] = call_user_func($placeholders['challenge_trailer'], $translations, $placeholders);
            }
        }
        $info = self::text($translations, 'info', $challengeDir, $placeholders);
        if (array_key_exists('challenge_trailer', $placeholders))
        {
            $info .= self::replacePlaceholders('{challenge_end}', $placeholders);
        }
        echo GWF_Box::box($info, self::text($translations, 'title', $challengeDir, $placeholders));
        if (isset($callbacks['challenge_after']))
        {
            echo call_user_func($callbacks['challenge_after'], $translations, $placeholders);
        }
        if (isset($translations['credits_html']) || isset($translations['credits']))
        {
            echo GWF_Box::box(
                self::text($translations, 'credits', $challengeDir, $placeholders),
                self::text($translations, 'credits_title', $challengeDir, $placeholders)
            );
        }
        if (isset($translations['disclaimer_html']) || isset($translations['disclaimer']))
        {
            echo GWF_Box::box(
                self::text($translations, 'disclaimer', $challengeDir, $placeholders),
                self::text($translations, 'disc_title', $challengeDir, $placeholders)
            );
        }
        if (isset($callbacks['render']))
        {
            $rendered = call_user_func($callbacks['render'], $chall, $definition);
            if ($rendered !== null)
            {
                echo $rendered;
            }
        }
        $maxlength = isset($definition['input_maxlength']) ? $definition['input_maxlength'] : 0;
        if (!isset($definition['solution_box']) || $definition['solution_box'])
        {
            formSolutionbox($chall, $maxlength);
        }
        if (!empty($definition['warchall_ads']))
        {
            require 'challenge/warchall/ads.php';
        }
        echo $chall->copyrightFooter();
        require_once 'challenge/html_foot.php';
    }

    private static function displayCheckResult($result, $chall, array $definition)
    {
        if (is_array($result) && !empty($result['handled']))
        {
            return;
        }
        if ($result === true || (is_array($result) && !empty($result['solved'])))
        {
            $chall->onChallengeSolved(GWF_Session::getUserID());
            return;
        }
        if (is_array($result) && array_key_exists('response', $result))
        {
            echo $result['response'];
        }
        if (is_array($result) && isset($result['error']))
        {
            echo GWF_HTML::error($definition['title'], $result['error']);
        }
        elseif ($result === false || $result === array())
        {
            echo WC_HTML::error('err_wrong');
        }
    }

    public static function install($challengeDir, $beforeChallengeInstall = null)
    {
        $definition = self::loadDefinition($challengeDir);
        $wwwDir = dirname(__DIR__);
        $challengePath = self::challengePath($challengeDir, $wwwDir);

        chdir($wwwDir);
        define('GWF_PAGE_TITLE', $definition['title']);
        require_once 'challenge/html_head.php';

        if (!GWF_User::isAdminS())
        {
            return htmlSendToLogin('Better be admin!');
        }

        $callbackSolution = null;
        if ($beforeChallengeInstall !== null)
        {
            if (!is_callable($beforeChallengeInstall))
            {
                throw new InvalidArgumentException('Install callback is not callable');
            }
            $callbackSolution = call_user_func($beforeChallengeInstall);
            if (is_array($callbackSolution) && !empty($callbackSolution['skip_install']))
            {
                require_once 'challenge/html_foot.php';
                return;
            }
        }

        $solution = $definition['solution'] === false ? false : self::readSolution($definition['solution'], $challengeDir);
        if ($callbackSolution !== null)
        {
            $solution = is_array($callbackSolution) && array_key_exists('solution', $callbackSolution) ? $callbackSolution['solution'] : $callbackSolution;
        }
        $options = 0;
        if (is_array($definition['solution']) && isset($definition['solution']['case_sensitive']) && !$definition['solution']['case_sensitive'])
        {
            $options = WC_Challenge::CHALL_CASE_I;
        }
        if (is_array($callbackSolution) && isset($callbackSolution['options']))
        {
            $options = $callbackSolution['options'];
        }
        WC_Challenge::installChallenge(
            $definition['title'],
            $solution,
            $definition['score'],
            'challenge/' . $challengePath . '/index.php',
            implode(',', $definition['creators']),
            implode(',', $definition['tags']),
            true,
            $options
        );
        require_once 'challenge/html_foot.php';
    }

    private static function loadDefinition($challengeDir)
    {
        $file = $challengeDir . '/challenge.yaml';
        if (!is_file($file))
        {
            throw new RuntimeException('Missing challenge.yaml');
        }
        $autoload = dirname(dirname(__DIR__)) . '/vendor/autoload.php';
        if (!is_file($autoload))
        {
            throw new RuntimeException('Composer dependencies are not installed');
        }
        require_once $autoload;
        $definition = Yaml::parseFile($file);
        foreach (array('title', 'score', 'solution') as $key)
        {
            if (!isset($definition[$key]))
            {
                throw new RuntimeException('Missing challenge field: ' . $key);
            }
        }
        $definition += array('creators' => array(), 'tags' => array());
        return $definition;
    }

    private static function translations(array $definition, $challengeDir)
    {
        $translations = isset($definition['translations']) ? $definition['translations'] : array();
        if (!$translations)
        {
            $translations = self::legacyTranslations($challengeDir);
        }
        foreach ($translations as $iso => $translation)
        {
            if (is_string($translation))
            {
                $path = realpath($challengeDir . '/' . $translation);
                if ($path === false || strpos($path, realpath($challengeDir) . DIRECTORY_SEPARATOR) !== 0)
                {
                    throw new RuntimeException('Translation path is outside the challenge directory');
                }
                $translations[$iso] = Yaml::parseFile($path);
            }
        }
        $iso = GWF_Language::getCurrentISO();
        $english = isset($translations['en']) ? $translations['en'] : array();
        if ($iso === 'en' || !isset($translations[$iso]))
        {
            return $english;
        }
        return array_merge($english, $translations[$iso]);
    }

    private static function legacyTranslations($challengeDir)
    {
        $translations = array();
        foreach (glob($challengeDir . '/lang/chall_*.php') as $file)
        {
            $iso = basename($file, '.php');
            $iso = substr($iso, strlen('chall_'));
            $lang = array();
            require $file;
            if (isset($lang) && is_array($lang))
            {
                $translations[$iso] = $lang;
            }
        }
        return $translations;
    }

    private static function text(array $translations, $key, $challengeDir, array $placeholders = array())
    {
        $htmlKey = $key . '_html';
        if (isset($translations[$htmlKey]))
        {
            return self::replacePlaceholders(self::renderSourcePlaceholders($translations[$htmlKey], $challengeDir), $placeholders);
        }
        if (!isset($translations[$key]))
        {
            return htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
        }
        return self::replacePlaceholders(nl2br(htmlspecialchars((string)$translations[$key], ENT_QUOTES, 'UTF-8')), $placeholders);
    }

    private static function replacePlaceholders($text, array $placeholders)
    {
        $values = array();
        foreach ($placeholders as $name => $value)
        {
            if (is_callable($value))
            {
                $value = call_user_func($value);
            }
            $values[] = $value;
            $text = str_replace('{' . $name . '}', (string)$value, $text);
        }
        if ($values && preg_match('/%(?:[0-9]+\$)?s/', $text))
        {
            $formatted = @vsprintf($text, $values);
            if ($formatted !== false)
            {
                $text = $formatted;
            }
        }
        return $text;
    }

    private static function renderSourcePlaceholders($text, $challengeDir)
    {
        return preg_replace_callback('/\{\{source:([^}]+)\}\}/', function($matches) use ($challengeDir) {
            $relativePath = trim($matches[1]);
            $root = realpath($challengeDir);
            $path = realpath($challengeDir . '/' . $relativePath);
            if ($path === false || strpos($path, $root . DIRECTORY_SEPARATOR) !== 0)
            {
                throw new RuntimeException('Source path is outside the challenge directory');
            }
            $source = file_get_contents($path);
            $title = htmlspecialchars($relativePath, ENT_QUOTES, 'UTF-8');
            $language = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $tag = $language === 'php' ? 'php title=' . $title : 'code title=' . $title;
            return GWF_Message::display('[' . $tag . ']' . htmlspecialchars($source, ENT_QUOTES, 'UTF-8') . '[/' . ($language === 'php' ? 'php' : 'code') . ']');
        }, (string)$text);
    }

    private static function matches($answer, array $solution, $challengeDir)
    {
        if (isset($solution['type']) && $solution['type'] === 'hash')
        {
            $expected = self::readSolution($solution, $challengeDir);
            $algorithm = isset($solution['algorithm']) ? $solution['algorithm'] : 'md5';
            if (!in_array($algorithm, hash_algos(), true))
            {
                throw new RuntimeException('Unknown hash algorithm: ' . $algorithm);
            }
            if (!empty($solution['trim']))
            {
                $answer = trim($answer);
            }
            return hash_equals(strtolower((string)$expected), strtolower(hash($algorithm, $answer)));
        }
        $expected = self::readSolution($solution, $challengeDir);
        if (!empty($solution['trim']))
        {
            $answer = trim($answer);
            $expected = trim($expected);
        }
        if (isset($solution['case_sensitive']) && !$solution['case_sensitive'])
        {
            return hash_equals(strtolower($answer), strtolower($expected));
        }
        return hash_equals((string)$expected, (string)$answer);
    }

    private static function readSolution(array $solution, $challengeDir)
    {
        $type = isset($solution['type']) ? $solution['type'] : 'plaintext';
        if ($type === 'plaintext')
        {
            if (!array_key_exists('value', $solution))
            {
                throw new RuntimeException('Plaintext solution needs value');
            }
            return (string)$solution['value'];
        }
        if (!isset($solution['path']))
        {
            throw new RuntimeException($type . ' solution needs path');
        }
        $path = realpath($challengeDir . '/' . $solution['path']);
        if ($path === false || strpos($path, realpath($challengeDir) . DIRECTORY_SEPARATOR) !== 0)
        {
            throw new RuntimeException('Solution path is outside the challenge directory');
        }
        if ($type === 'file')
        {
            return file_get_contents($path);
        }
        if ($type === 'require')
        {
            $value = require $path;
            if (isset($solution['extract']))
            {
                foreach ((array)$solution['extract'] as $key)
                {
                    if (!is_array($value) || !array_key_exists($key, $value))
                    {
                        throw new RuntimeException('Required solution has no extract key: ' . $key);
                    }
                    $value = $value[$key];
                }
            }
            if (!is_scalar($value))
            {
                throw new RuntimeException('Required solution must return a scalar or define solution.extract');
            }
            return (string)$value;
        }
        throw new RuntimeException('Unknown solution type: ' . $type);
    }

    private static function challengePath($challengeDir, $wwwDir)
    {
        $root = realpath($wwwDir . '/challenge');
        return str_replace('\\', '/', substr(realpath($challengeDir), strlen($root) + 1));
    }
}
