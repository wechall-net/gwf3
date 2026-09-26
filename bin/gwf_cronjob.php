<?php
# May not call by browser. In theory this file is accessible in some setups.
if (isset($_SERVER['REMOTE_ADDR']))
{
	die('FATAL: Cronjob is called by www.');
}

# Change dir to $GWF3/www
if (chdir(__DIR__ . '/../www') === false)
{
	die('FATAL: Could not chdir to $GWF3/www');
}

# Switch to non HTML output
$_GET['ajax'] = 1;

# Include config
require_once 'protected/config.php'; # <-- You may need to change this path.

# Include core
require_once '../gwf3.class.php';

# Init
$gwf = new GWF3(getcwd(), array(
	'bootstrap' => true,
	'website_init' => true,
	'autoload_modules' => false,
	'load_module' => false,
	'load_config' => false,
	'start_debug' => true,
	'get_user' => false,
	'do_logging' => true,
	'log_request' => false,
	'blocking' => false,
	'no_session' => true,
	'store_last_url' => false,
	'ignore_user_abort' => false,
));

# Call cronjobs
GWF_ModuleLoader::cronjobs();
?>
