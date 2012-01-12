<?php

final class Admin_Install extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 
			sprintf('RewriteRule ^%s/install_all$ index.php?mo=Admin&me=Install&all=true'.PHP_EOL, Module_Admin::ADMIN_URL_NAME).
			sprintf('RewriteRule ^%s/install/([a-zA-Z]+)$ index.php?mo=Admin&me=Install&module=$1&drop=0'.PHP_EOL, Module_Admin::ADMIN_URL_NAME).
			sprintf('RewriteRule ^%s/wipe/([a-zA-Z]+)$ index.php?mo=Admin&me=Install&module=$1&drop=1'.PHP_EOL, Module_Admin::ADMIN_URL_NAME);
	}
	
	public function execute(GWF_Module $module)
	{
		$nav = $this->_module->templateNav();
		
		if ('true' === Common::getGetString('all')) {
			return $nav.$this->onInstallAll($this->_module);
		}
		if (false !== Common::getPost('install')) {
			return $nav.$this->onInstallModuleSafe($this->_module, false);
		}
		if (false !== Common::getPost('reinstall')) {
			return $nav.$this->onTemplateReinstall($this->_module, true);
		}
		if (false !== Common::getPost('reinstall2')) {
			return $nav.$this->onInstallModuleSafe($this->_module, true);
		}
		if (false !== Common::getPost('resetvars2')) {
			return $nav.$this->onResetModule($this->_module);
		}
		if (false !== Common::getPost('delete')) {
			return $nav.$this->onTemplateReinstall($this->_module, false);
		}
		if (false !== Common::getPost('delete2')) {
			return $nav.$this->onDeleteModule($this->_module);
		}
		
		if (false !== ($this->_modulename = Common::getGetString('module'))) {
			return $nav.$this->onInstall($this->_module, $modulename, false);
		}
		
		return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
	}
	
	public function formInstall(Module_Admin $module, GWF_Module $mod)
	{
		$data = array(
			'modulename' => array(GWF_Form::HIDDEN, $mod->display('module_name')),
			'install' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_install'), $this->_module->lang('th_install')),
			'reinstall' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_reinstall'), $this->_module->lang('th_reinstall')),
			'delete' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_delete')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_modulename(Module_Admin $m, $arg) { return false; }
	
	public function formReInstall(Module_Admin $module, GWF_Module $mod)
	{
		$data = array(
			'modulename' => array(GWF_Form::HIDDEN, $mod->display('module_name')),
			'install' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_install'), $this->_module->lang('th_install')),
			'resetvars2' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_defaults'), $this->_module->lang('th_reset')),
			'reinstall2' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_reinstall'), $this->_module->lang('th_reinstall')),
			'delete2' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_delete'), $this->_module->lang('th_delete')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function onTemplateReinstall(Module_Admin $module, $dropTable)
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $this->_module->error('err_module', array(htmlspecialchars($arg)));
		}
		
		$form = $this->formReInstall($this->_module, $post_module);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_reinstall', array($post_module->display('module_name')), GWF_WEB_ROOT.Module_Admin::ADMIN_URL_NAME.'/install/'.$post_module->urlencode('module_name'))),
		);
		return $this->_module->template('install.tpl', $tVars);
	}
	
	
	public function onResetModule(Module_Admin $module)
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $this->_module->error('err_module', htmlspecialchars($arg)).$this->onTemplateReinstall($this->_module, false);
		}
		$form = $this->formReInstall($this->_module, $post_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->onTemplateReinstall($this->_module, false);
		}
		if (false === GDO::table('GWF_ModuleVar')->deleteWhere('mv_mid='.$post_module->getID())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		$post_module->loadVars();
		return
			$this->_module->message('msg_defaults').
			$this->onInstall($this->_module, $post_module->getName(), false);
	}
			
	public function onInstallModuleSafe(Module_Admin $module, $dropTable)
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $this->_module->error('err_module', htmlspecialchars($arg)).$this->onTemplateReinstall($this->_module, false);
		}
		$form = $this->formReInstall($this->_module, $post_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->onTemplateReinstall($this->_module, false);
		}
		return $this->onInstall($this->_module, $form->getVar('modulename'), $dropTable);
	}
	
	public function onInstall(Module_Admin $module, $modulename, $dropTable)
	{
		if (false === ($this->_modules = GWF_ModuleLoader::loadModulesFS())) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array(GWF_HTML::display($this->_modulename)));
		}
		if (!isset($this->_modules[$modulename])) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array(GWF_HTML::display($this->_modulename)));
		}
		$install = $modules[$modulename];
		$install instanceof GWF_Module;
		
		$errors = GWF_ModuleLoader::installModule($install, $dropTable);
		
		if ($errors !== '') {
			return $errors.$this->_module->error('err_install').$this->_module->requestMethodB('Modules');
		}
		
//		if (false === ($install->saveOption(GWF_Module::ENABLED, true))) {
//			return 
//				GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).
//				$this->_module->message('err_install').$this->_module->requestMethodB('Modules');
//		}
		
		GWF_ModuleLoader::installHTAccess($this->_modules);
		
		$msg = $dropTable === true ? 'msg_wipe' : 'msg_install';
		
		return 
			$this->_module->message($msg, array(GWF_HTML::display($this->_modulename))).
			$this->_module->message('msg_installed', array(Module_Admin::getEditURL($this->_modulename), GWF_HTML::display($this->_modulename)));
	}

	public function onInstallAll(Module_Admin $module)
	{
		$back = '';
		$modules = GWF_ModuleLoader::loadModulesFS();
		foreach ($this->_modules as $m)
		{
			$m instanceof GWF_Module;
			$back .= GWF_ModuleLoader::installModule($m, false);
		}
		
		GWF_ModuleLoader::installHTAccess($this->_modules);
		
		return $this->_module->message('msg_install_all', array($this->_module->getMethodURL('Modules'))).$back;
	}
	
	public function onDeleteModule(Module_Admin $module)
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $this->_module->error('err_module', htmlspecialchars($arg)).$this->onTemplateReinstall($this->_module, false);
		}
		$form = $this->formReInstall($this->_module, $post_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->onTemplateReinstall($this->_module, false);
		}
		
		if (0 == ($mid = $post_module->getID())) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__)).$this->onTemplateReinstall($this->_module, false);
		}
		
		if (false === GDO::table('GWF_Module')->deleteWhere("module_id={$mid}")) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->onTemplateReinstall($this->_module, false);
		}
		
		if (false === GDO::table('GWF_ModuleVar')->deleteWhere("mv_mid={$mid}")) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->onTemplateReinstall($this->_module, false);
		}
		
		return $this->_module->message('msg_mod_del');
	}
}


?>