<?php
final class PasswordForgot_Change extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^change_password/([0-9]+)/([0-9A-Za-z]+)$ index.php?mo=PasswordForgot&me=Change&token=$2&userid=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		# Check token
		if (false === ($token = Common::getGet('token'))) {
			return $this->_module->error('err_no_token');
		}
		if (false === ($userid = Common::getGet('userid'))) {
			return $this->_module->error('err_no_token');
		}
		
		require_once GWF_CORE_PATH.'module/Account/GWF_AccountChange.php';
		if (false === ($ac = GWF_AccountChange::checkToken($userid, $token, 'pass'))) {
			return $this->_module->error('err_no_token');
		}
		
		# Do stuff
		if (false !== (Common::getPost('change'))) {
			return $this->onChangePass($this->_module, $ac);
		}
		return $this->templateChange($this->_module, $ac);
	}
	
	private function getForm(Module_PasswordForgot $module)
	{
		$data = array(
			'password' => array(GWF_Form::PASSWORD, '', $this->_module->lang('th_password')),
			'password2' => array(GWF_Form::PASSWORD, '', $this->_module->lang('th_password2')),
			'change' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_change'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateChange(Module_PasswordForgot $module, GWF_AccountChange $ac)
	{
		$form = $this->getForm($this->_module);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('title_change')),
			'username' => $ac->getUser()->displayUsername(),
		);
		return $this->_module->templatePHP('change.php', $tVars);
	}
	
	public function validate_password2(Module_PasswordForgot $module, $password) { return false; }
	public function validate_password(Module_PasswordForgot $module, $password)
	{
		if (!GWF_Validator::isValidPassword($password)) {
			return $this->_module->lang('err_weak_pass', array( 8));
		} elseif (Common::getPost('password2', '') !== $password) {
			return $this->_module->lang('err_pass_retype');
		} else {
			return false;
		}
	}
	
	private function onChangePass(Module_PasswordForgot $module, GWF_AccountChange $ac)
	{
		$form = $this->getForm($this->_module);
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors.$this->templateChange($this->_module, $ac);
		}
		
		$user = $ac->getUser();
		$password = $form->getVar('password');
		
		GWF_Hook::call(GWF_Hook::CHANGE_PASSWD, $user, array($password, ''));
		
		$ac->delete();
		
		if (false === $user->saveVar('user_password', GWF_Password::hashPasswordS($password)))
		{
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}

		return $this->_module->message('msg_pass_changed');
	}
}

?>