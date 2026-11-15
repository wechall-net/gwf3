<?php

use Symfony\Component\Yaml\Yaml;

final class WCChallenge
{
    private static $constantPlaceholders = array(
        'GWF_WEB_ROOT',
    );
    private static $definitionCache = array();
    private static $translationCache = array();
    private static $userPlaceholderCache = array();

    public static function sourceCode($file, $language = 'php', $title = null)
    {
        $isPhp = strtolower($language) === 'php';
        $tag = $isPhp ? 'php' : 'code lang='.$language;
        if ($title !== null)
        {
            $tag .= ' title='.$title;
        }
        return GWF_Message::display('['.$tag.']'.file_get_contents($file).'[/'.($isPhp ? 'php' : 'code').']');
    }

    public static function redirectToIndex()
    {
        header('Location: index.php');
        exit;
    }

    public static function showSource($file)
    {
        if (!is_file($file))
        {
            http_response_code(404);
            exit;
        }
        header('Content-Type: text/plain; charset=UTF-8');
        readfile($file);
        exit;
    }

    private static function sourceEntry(array $definition, $name)
    {
        if (!isset($definition['source_code']) || !is_array($definition['source_code']))
        {
            return null;
        }
        $sources = $definition['source_code'];
        if (!isset($sources[$name]))
        {
            return null;
        }
        $entry = is_string($sources[$name]) ? array('file' => $sources[$name]) : $sources[$name];
        return is_array($entry) && isset($entry['file']) ? $entry : null;
    }

    private static function requestedSource(array $definition)
    {
        $name = false;
        $raw = false;
        if (isset($_GET['show']) && is_string($_GET['show']))
        {
            $name = $_GET['show'] === 'source' ? 'source' : $_GET['show'];
            $raw = true;
        }
        elseif (isset($_GET['highlight']) && is_string($_GET['highlight']))
        {
            $name = $_GET['highlight'];
        }
        if ($name === false)
        {
            return null;
        }
        $entry = self::sourceEntry($definition, $name);
        if ($entry === null && $name !== 'source')
        {
            $entry = self::sourceEntry($definition, 'source');
        }
        if ($entry === null && isset($definition['source_code']['default']))
        {
            $entry = is_string($definition['source_code']['default'])
                ? array('file' => $definition['source_code']['default'])
                : $definition['source_code']['default'];
        }
        if ($entry === null)
        {
            return null;
        }
        $raw = $raw && (!isset($entry['direct']) || $entry['direct']);
        return array($entry, $raw);
    }

    private static function sourcePath($challengeDir, array $entry)
    {
        $root = realpath($challengeDir);
        $path = realpath($challengeDir . '/' . $entry['file']);
        if ($path === false)
        {
            return false;
        }
        if (strpos($path, $root . DIRECTORY_SEPARATOR) !== 0)
        {
            throw new RuntimeException('Source path is outside the challenge directory');
        }
        return $path;
    }

    private static function sourceButtons(array $definition, $challengePath, $challengeDir, $sourceRequest)
    {
        if (isset($definition['source_buttons']) && !$definition['source_buttons'])
        {
            if ($sourceRequest !== null && !$sourceRequest[1])
            {
                $entry = $sourceRequest[0];
                $title = isset($entry['title']) ? $entry['title'] : $entry['file'];
                $language = isset($entry['language']) ? $entry['language'] : 'php';
                $sourcePath = self::sourcePath($challengeDir, $entry);
                if ($sourcePath === false)
                {
                    return GWF_HTML::error('Source code', 'The requested source file is not available.', false);
                }
                return GWF_Box::box(
                    self::sourceHint() . self::sourceCode($sourcePath, $language, $title),
                    $title
                );
            }
            return '';
        }
        if (!isset($definition['source_code']) || !is_array($definition['source_code']))
        {
            return '';
        }

        $buttons = array();
        $baseUrl = isset($definition['url'])
            ? GWF_WEB_ROOT.ltrim($definition['url'], '/')
            : GWF_WEB_ROOT.'challenge/'.implode('/', array_map('rawurlencode', explode('/', $challengePath))).'/index.php';
        foreach ($definition['source_code'] as $name => $source)
        {
            if ($name === 'default')
            {
                continue;
            }
            $entry = is_string($source) ? array('file' => $source) : $source;
            if (!is_array($entry) || !isset($entry['file']))
            {
                continue;
            }
            $title = isset($entry['title']) ? $entry['title'] : $name;
            $separator = strpos($baseUrl, '?') === false ? '?' : '&';
            $linkHighlight = $baseUrl.$separator.'highlight='.rawurlencode($name);
            $buttons[] = GWF_Button::generic($title.' (highlight)', $linkHighlight);
            if (!isset($entry['direct']) || $entry['direct'])
            {
                $linkRaw = $baseUrl.$separator.'show='.rawurlencode($name);
                $buttons[] = GWF_Button::generic($title.' (raw)', $linkRaw);
            }
        }

        if (!$buttons)
        {
            return '';
        }

        $content = self::sourceHint() . GWF_Button::wrap(implode(PHP_EOL, $buttons));
        if ($sourceRequest !== null && !$sourceRequest[1])
        {
            $entry = $sourceRequest[0];
            $title = isset($entry['title']) ? $entry['title'] : $entry['file'];
            $language = isset($entry['language']) ? $entry['language'] : 'php';
            $sourcePath = self::sourcePath($challengeDir, $entry);
            if ($sourcePath === false)
            {
                return GWF_HTML::error('Source code', 'The requested source file is not available.', false);
            }
            $content .= self::sourceCode($sourcePath, $language, $title);
        }
        return GWF_Box::box($content, 'Source code');
    }

    private static function sourceHint()
    {
        return '<p class="wc_source_hint">'.WC_HTML::lang('source_code_hint').'</p>'.PHP_EOL;
    }

    public static function trans($challenge, $key, array $placeholders = array())
    {
        $challengeDir = self::challengeDirectory($challenge);
        $definition = is_file($challengeDir . '/challenge.yaml') ? self::loadDefinition($challengeDir) : array();
        $translations = self::translations($definition, $challengeDir);
        $templateKey = isset($translations[$key . '_html']) ? $key . '_html' : $key;
        $template = isset($translations[$templateKey]) && is_string($translations[$templateKey]) ? $translations[$templateKey] : '';
        preg_match_all('/\{([a-z][a-z0-9_]*)\}/i', $template, $matches);
        $names = array_values(array_unique($matches[1]));
        $normalized = array();
        foreach ($placeholders as $name => $value)
        {
            $normalized[is_int($name) ? (isset($names[$name]) ? $names[$name] : 'arg' . ($name + 1)) : $name] = $value;
        }
        return self::text($translations, $key, $challengeDir, $normalized);
    }

    public static function run($challengeDir, array $placeholders = array(), array $callbacks = array())
    {
        $definition = self::loadDefinition($challengeDir);
        $placeholders = array_merge(
            array(
                'GWF_WEB_ROOT' => function() { return GWF_WEB_ROOT; },
                'username' => function() {
                    $user = GWF_User::getStaticOrGuest();
                    return $user->isGuest() ? 'hacker' : $user->displayUsername();
                },
            ),
            isset($definition['placeholders']) && is_array($definition['placeholders']) ? $definition['placeholders'] : array(),
            $placeholders
        );
        $wwwDir = dirname(__DIR__);
        $challengePath = self::challengePath($challengeDir, $wwwDir);

        $sourceRequest = self::requestedSource($definition);
        if ($sourceRequest !== null && $sourceRequest[1])
        {
            $sourcePath = self::sourcePath($challengeDir, $sourceRequest[0]);
            if ($sourcePath === false)
            {
                http_response_code(404);
                echo GWF_HTML::error('Source code', 'The requested source file is not available.', false);
                return;
            }
            self::showSource($sourcePath);
        }

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
                isset($definition['url']) ? $definition['url'] : 'challenge/' . $challengePath . '/index.php',
                false,
                self::solutionOptions($definition['solution']),
                $definition['creators'],
                $definition['tags']
            );
        }

        $translations = self::translations($definition, $challengeDir);
        if (isset($callbacks['before_header']))
        {
            $result = call_user_func($callbacks['before_header'], $chall, $definition, $translations, $placeholders);
            if ($result !== null)
            {
                echo $result;
                return;
            }
        }
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
            elseif ($definition['solution'] === false && !isset($callbacks['render']) && (!isset($definition['solution_box']) || $definition['solution_box']))
            {
                $chall->onCheckSolution();
            }
            else
            {
                if ((string)$chall->getID() === '0' && is_array($definition['solution']))
                {
                    $dummySolution = self::readSolution($definition['solution'], $challengeDir);
                    $caseInsensitive = isset($definition['solution']['case_sensitive']) && !$definition['solution']['case_sensitive'];
                    $chall->setSolution($dummySolution, $caseInsensitive);
                }
                if (is_array($definition['solution']) && isset($definition['solution']['type']) && $definition['solution']['type'] === 'hash')
                {
                    $algorithm = isset($definition['solution']['algorithm']) ? $definition['solution']['algorithm'] : 'md5';
                    if (!in_array($algorithm, hash_algos(), true))
                    {
                        throw new RuntimeException('Unknown hash algorithm: ' . $algorithm);
                    }
                    $answer = hash($algorithm, $answer);
                    $expectedHash = self::readSolution($definition['solution'], $challengeDir);
                    $answer = strtoupper((string)$expectedHash) === (string)$expectedHash ? strtoupper($answer) : strtolower($answer);
                }
                $chall->onCheckSolution($answer);
            }
        }

        foreach (array('challenge_pre_content', 'challenge_post_content') as $contentPlaceholder)
        {
            if (!array_key_exists($contentPlaceholder, $placeholders))
            {
                $placeholders[$contentPlaceholder] = '';
            }
            elseif (is_callable($placeholders[$contentPlaceholder]))
            {
                $placeholders[$contentPlaceholder] = call_user_func($placeholders[$contentPlaceholder], $translations, $placeholders);
            }
        }
        $info = self::replacePlaceholders('{challenge_pre_content}', $placeholders);
        $info .= self::text($translations, 'info', $challengeDir, $placeholders, $translations);
        $info .= self::replacePlaceholders('{challenge_post_content}', $placeholders);
        $boxTitle = isset($translations['title']) ? self::text($translations, 'title', $challengeDir, $placeholders, $translations) : $definition['title'];
        if (isset($translations['subtitle']))
        {
            $boxTitle .= ' - ' . self::text($translations, 'subtitle', $challengeDir, $placeholders, $translations);
        }
        if (!isset($definition['info_box']) || $definition['info_box'])
        {
            echo GWF_Box::box($info, $boxTitle);
        }
        echo self::sourceButtons($definition, $challengePath, $challengeDir, $sourceRequest);
        if (isset($callbacks['challenge_after']))
        {
            echo call_user_func($callbacks['challenge_after'], $translations, $placeholders);
        }
        if (isset($translations['credits_html']) || isset($translations['credits']))
        {
            $creditsTitle = isset($translations['credits_title']) ? self::text($translations, 'credits_title', $challengeDir, $placeholders) : '';
            echo GWF_Box::box(
                self::text($translations, 'credits', $challengeDir, $placeholders),
                $creditsTitle
            );
        }
        if (isset($translations['disclaimer_html']) || isset($translations['disclaimer']))
        {
            $disclaimerTitle = isset($translations['disc_title']) ? self::text($translations, 'disc_title', $challengeDir, $placeholders) : '';
            echo GWF_Box::box(
                self::text($translations, 'disclaimer', $challengeDir, $placeholders),
                $disclaimerTitle
            );
        }
        if (isset($callbacks['render']))
        {
            $rendered = call_user_func($callbacks['render'], $chall, $definition, $translations);
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
        if (isset($callbacks['after_footer']))
        {
            echo call_user_func($callbacks['after_footer'], $translations, $placeholders);
        }
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
        $options = self::solutionOptions($definition['solution']);
        if (is_array($callbackSolution) && isset($callbackSolution['options']))
        {
            $options = $callbackSolution['options'];
        }
        WC_Challenge::installChallenge(
            $definition['title'],
            $solution,
            $definition['score'],
            isset($definition['url']) ? $definition['url'] : 'challenge/' . $challengePath . '/index.php',
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
        $cacheKey = realpath($file);
        if (isset(self::$definitionCache[$cacheKey]))
        {
            return self::$definitionCache[$cacheKey];
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
        self::$definitionCache[$cacheKey] = $definition;
        return self::$definitionCache[$cacheKey];
    }

    private static function challengeDirectory($challenge)
    {
        if (!defined('GWF_WWW_PATH'))
        {
            throw new RuntimeException('GWF_WWW_PATH is not defined');
        }
        $root = realpath(GWF_WWW_PATH);
        $path = realpath(GWF_WWW_PATH . ltrim((string)$challenge->getVar('chall_url'), '/'));
        if ($path === false || strpos($path, $root . DIRECTORY_SEPARATOR) !== 0)
        {
            throw new RuntimeException('Challenge path is invalid');
        }
        return dirname($path);
    }

    private static function solutionOptions($solution)
    {
        if (!is_array($solution))
        {
            return 0;
        }
        $options = 0;
        if (isset($solution['case_sensitive']) && !$solution['case_sensitive'])
        {
            $options |= WC_Challenge::CHALL_CASE_I;
        }
        if (!empty($solution['no_spaces']))
        {
            $options |= WC_Challenge::CHALL_NO_SPACES;
        }
        if (!empty($solution['hashed_password']))
        {
            $options |= WC_Challenge::CHALL_HASHED_PW;
        }
        return $options;
    }

    private static function translations(array $definition, $challengeDir)
    {
        $cacheKey = realpath($challengeDir);
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
        GWF_HTML::init();
        $iso = GWF_Language::getCurrentISO();
        if (isset(self::$translationCache[$cacheKey]) && array_key_exists($iso, self::$translationCache[$cacheKey]))
        {
            return self::$translationCache[$cacheKey][$iso];
        }
        $english = isset($translations['en']) ? $translations['en'] : array();
        if ($iso === 'en' || !isset($translations[$iso]))
        {
            return self::$translationCache[$cacheKey][$iso] = $english;
        }
        return self::$translationCache[$cacheKey][$iso] = array_merge($english, $translations[$iso]);
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

    private static function text(array $translations, $key, $challengeDir, array $placeholders = array(), array $context = array())
    {
        $htmlKey = $key . '_html';
        if (isset($translations[$htmlKey]))
        {
            $html = self::replacePlaceholders(self::renderSourcePlaceholders($translations[$htmlKey], $challengeDir), $placeholders, $context);
            return self::renderLegacyBBCode($html);
        }
        if (!isset($translations[$key]))
        {
            return '';
        }
        $text = html_entity_decode((string)$translations[$key], ENT_QUOTES, 'UTF-8');
        return self::replacePlaceholders(nl2br(htmlspecialchars($text, ENT_QUOTES, 'UTF-8')), $placeholders, $context);
    }

    private static function replacePlaceholders($text, array $placeholders, array $context = array())
    {
        $text = preg_replace_callback('/\{user:([^}]+)\}/', function($matches) {
            $name = trim($matches[1]);
            if (!array_key_exists($name, self::$userPlaceholderCache))
            {
                self::$userPlaceholderCache[$name] = GWF_User::getByName($name);
            }
            $user = self::$userPlaceholderCache[$name];
            if (!$user)
            {
                return htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            }
            return '<a href="'.htmlspecialchars($user->getProfileHREF(), ENT_QUOTES, 'UTF-8').'">'
                .htmlspecialchars($user->getVar('user_name'), ENT_QUOTES, 'UTF-8').'</a>';
        }, $text);
        $values = array();
        foreach ($placeholders as $name => $value)
        {
            if (is_callable($value))
            {
                $value = call_user_func($value, $context);
            }
            $value = preg_replace_callback('/\{([A-Z][A-Z0-9_]*)\}/', function($matches) {
                if (in_array($matches[1], self::$constantPlaceholders, true) && defined($matches[1]))
                {
                    return (string)constant($matches[1]);
                }
                return $matches[0];
            }, (string)$value);
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
        return preg_replace_callback('/\{\{source:([^}|]+)(?:\|([^}]+))?\}\}/', function($matches) use ($challengeDir) {
            $relativePath = trim($matches[1]);
            $root = realpath($challengeDir);
            $path = realpath($challengeDir . '/' . $relativePath);
            if ($path === false || strpos($path, $root . DIRECTORY_SEPARATOR) !== 0)
            {
                throw new RuntimeException('Source path is outside the challenge directory');
            }
            $language = isset($matches[2]) && trim($matches[2]) !== ''
                ? trim($matches[2])
                : strtolower(pathinfo($path, PATHINFO_EXTENSION));
            return self::sourceCode($path, $language, $relativePath);
        }, (string)$text);
    }

    private static function renderLegacyBBCode($text)
    {
        $text = preg_replace_callback('/\[(?:code(?:=[^\s\]]+)?(?:\s+title=([^\]]+))?|php)\](.*?)\[\/(?:code|php)\]/is', function($matches) {
            $title = isset($matches[1]) ? ' data-title="'.htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8').'"' : '';
            return '<pre class="code"'.$title.'>'.htmlspecialchars($matches[2], ENT_QUOTES, 'UTF-8').'</pre>';
        }, (string)$text);
        $text = preg_replace_callback('/\[url=([^\]]+)\](.*?)\[\/url\]/is', function($matches) {
            return '<a href="'.htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8').'">'.$matches[2].'</a>';
        }, $text);
        return str_replace(array('[i]', '[/i]', '[b]', '[/b]'), array('<i>', '</i>', '<b>', '</b>'), $text);
    }

    private static function readSolution(array $solution, $challengeDir)
    {
        $type = isset($solution['type']) ? $solution['type'] : 'plaintext';
        if ($type === 'global')
        {
            $definition = self::loadDefinition($challengeDir);
            $file = dirname(__DIR__) . '/../solutions.yaml';
            if (!is_file($file))
            {
                throw new RuntimeException('Global solutions file is missing');
            }
            $catalog = Yaml::parseFile($file);
            foreach ((array)$catalog as $entry)
            {
                if (is_array($entry) && isset($entry['title']) && $entry['title'] === $definition['title'])
                {
                    if (!array_key_exists('solution', $entry) || $entry['solution'] === false || $entry['solution'] === null || $entry['solution'] === 'None')
                    {
                        throw new RuntimeException('Global solution is missing: ' . $definition['title']);
                    }
                    return (string)$entry['solution'];
                }
            }
            throw new RuntimeException('Global solution is missing: ' . $definition['title']);
        }
        if ($type === 'plaintext')
        {
            if (!array_key_exists('value', $solution))
            {
                throw new RuntimeException('Plaintext solution needs value');
            }
            return (string)$solution['value'];
        }
        if ($type === 'hash' && array_key_exists('value', $solution))
        {
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
