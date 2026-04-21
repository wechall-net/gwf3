<?php
final class WC_BaimForms
{
	private static $TRUSED = array('gizmore', 'baim', 'space');

	private $chall;
	public function __construct(WC_Challenge $chall)
	{
		$this->chall = $chall;
	}
	public function validate_username($m, $v) { return GWF_User::getByName($v) !== false ? false : GWF_HTML::lang('ERR_UNKNOWN_USER'); }
	public function validate_password($m, $v) {
		$PASSWORD = require_once __DIR__ . '/solution.php';
		return $v === $PASSWORD ? false : $this->chall->lang('err_password');
	}
	public static function hasPermission()
	{
		if (false === ($user = GWF_Session::getUser())) {
			return false;
		}
		return in_array(strtolower($user->getVar('user_name')), self::$TRUSED, true);
	}

	public function getFormAdmin(Module_WeChall $module)
	{
		$data = array();
		$data['username'] = array(GWF_Form::STRING, '', $module->lang('th_user_name'));
		if (!self::hasPermission()) {
			$data['password'] = array(GWF_Form::STRING, '', $module->lang('th_password'));
		}
		$data['btn'] = array(GWF_Form::SUBMIT, $this->chall->lang('btn_submit'));
		return new GWF_Form($this, $data);
	}

	public function executeFormAdmin(Module_WeChall $module)
	{
		if (false === ($user = GWF_User::getByName($_POST['username']))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		GWF_Module::getModule('Forum');
		$module->includeForums();
		$this->chall->onChallengeSolved($user->getID());
	}
}
?>
