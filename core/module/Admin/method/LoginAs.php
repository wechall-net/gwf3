<?php

final class Admin_LoginAs extends GWF_Method
{
	##############
	### Method ###
	##############
	public function getUserGroups() { return GWF_Group::ADMIN; }
	public function execute(GWF_Module $module)
	{
		$nav = $this->_module->templateNav();
		
		if (false !== Common::getPost('login')) {
			return $nav.$this->onLoginAs($this->_module);
		}
		
		return $nav.$this->templateLoginAs($this->_module);
	}
	
	################
	### Login As ###
	################
	public function validate_username(Module_Admin $module, $arg) { return false; }
	
	public function getForm(Module_Admin $module)
	{
		$data = array(
			'username' => array(GWF_Form::STRING, Common::getGet('username', ''), $this->_module->lang('th_user_name')),
			'login' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_login'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templateLoginAs(Module_Admin $module)
	{
		$form = $this->getForm($this->_module);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_login_as')),
		);
		return $this->_module->template('login_as.tpl', $tVars);
	}
	
	public function onLoginAs(Module_Admin $module)
	{
		$form = $this->getForm($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templateLoginAs($this->_module);
		}
		
		if (false === ($user = GWF_User::getByName($form->getVar('username')))) {
			return GWF_HTML::lang('ERR_UNKNOWN_USER');
		}
		
		GWF_Session::onLogin($user);
		
		return $this->_module->message('msg_login_as', array($user->displayUsername()));
	}
	
		
}

?>