<?php
/**
 * Lang file handling
 * @author gizmore
 */
final class GWF_LangTrans
{
	private $base_path = '';
	private $trans = array();
	
	/**
	 * Get the browser ISO.
	 * @return string
	 */
	public static function getBrowserISO()
	{
		return GWF_Language::getCurrentISO();
	}
	
	##############
	### Public ###
	##############
	
	/**
	 * Construct a langfile for a basepath.
	 * @param string $path
	 */
	public function __construct($path)
	{
		$this->base_path = $path;
		$this->loadLanguage(self::getBrowserISO());
	}
	
	/**
	 * Get the whole lang file for an iso and basefile.
	 * @param null|string $iso
	 * @return array
	 */
	public function getTrans($iso=NULL)
	{
		if ($iso === NULL) { $iso = self::getBrowserISO(); }
		$this->loadLanguage($iso);
		return $this->trans[$iso];
	}
	
	/**
	 * Translate an item for the browser ISO.
	 * @param string $key
	 * @param null|array $args
	 */
	public function lang($key, $args=NULL)
	{
		return $this->translate(self::getBrowserISO(), $key, $args);
	}
	
	/**
	 * Translate an key1[key2] for the browser ISO.
	 * @deprecated
	 * @param string $key
	 * @param null|array $args
	 */
	public function langA($var, $key, $args=NULL)
	{
		$back = $this->lang($var);
		return (is_array($back) && array_key_exists($key, $back)) ? $this->replaceArgs($back[$key], $args) : $back.'['.$key.']';
	}
	
	/**
	 * Get the translation for a user.
	 * A user can have two languages set, and there is browser lang as third fallback;
	 * Enter description here ...
	 * @param GWF_User $user
	 * @param unknown_type $key
	 * @param unknown_type $args
	 */
	public function langUser(GWF_User $user, $key, $args)
	{
		// Primary
		$iso1 = $user->getVar('user_langid');
		if (false !== $this->loadLanguage($iso1))
		{
			return $this->translate($iso1, $key, $args);
		}
		
		// Secondary
		$iso2 = $user->getVar('user_langid2');
		if (false !== $this->loadLanguage($iso2))
		{
			return $this->translate($iso2, $key, $args);
		}
		
		// Browser
		return $this->translate(self::getBrowserISO(), $key, $args);
	}
	
	/**
	 * Get the translation for an ISO Language.
	 * @param string $iso
	 * @param string $key
	 * @param null|array $args
	 * @return string|array
	 */
	public function langISO($iso, $key, $args=NULL)
	{
		if (false === $this->loadLanguage($iso))
		{
			return $this->translate(GWF_DEFAULT_LANG, $key, $args);
		}
		return $this->translate($iso, $key, $args);
	}
	
	/**
	 * Get the translation for the admin language.
	 * @deprecated
	 * @param string $key
	 * @param null|array $args
	 * @return string|array
	 */
	public function langAdmin($key, $args=NULL)
	{
		if (false === $this->loadLanguage(GWF_LANG_ADMIN))
		{
			return $this->translate(GWF_DEFAULT_LANG, $key, $args);
		}
		return $this->translate(GWF_LANG_ADMIN, $key, $args);
	}
	
	###############
	### Private ###
	###############
	
	/**
	 * Translate an item.
	 * @param string $iso
	 * @param string $key
	 * @param null|array $args
	 * @return string|array
	 */
	private function translate($iso, $key, $args=NULL)
	{
		if (!isset($this->trans[$iso][$key]))
		{
			return htmlspecialchars($key).(is_array($args) ? ': '.implode(',', $args) : '');
		}
		
		return $this->replaceArgs($this->trans[$iso][$key], $args);
	}
	
	/**
	 * Replace the item with values.
	 * @param string $back
	 * @param null|array $args
	 */
	private function replaceArgs($back, $args)
	{
		return $args === NULL ? $back : vsprintf($back, $args);
	}
	
	/**
	 * Load a language for this basefile by ISO.+
	 * TODO: Optimize more for speed.
	 * @param string $iso
	 * @return boolean
	 */
	private function loadLanguage($iso)
	{
		if (isset($this->trans[$iso]))
		{
			return true;
		}
		
		$path1 = $this->base_path.'_'.$iso.'.php';
		if (Common::isFile($path1))
		{
			$path = $path1;
			$success = true;
		}
		elseif (isset($this->trans[GWF_DEFAULT_LANG]))
		{
			$this->trans[$iso] = $this->trans[GWF_DEFAULT_LANG];
			return false;
		}
		else
		{
			$path = $this->base_path.'_'.GWF_DEFAULT_LANG.'.php';
			$success = false;
		}


		// Have success path?
		if (!$success) //&& (!Common::isFile($path)) )
		{
//			$path = GWF_PATH.$path;
			if (!Common::isFile($path))
			{
				die(sprintf('A language file is completely missing: %s', htmlspecialchars($path)));
			}
		}
		
		require $path;
		$this->trans[$iso] = $lang;
		return $success;
	}
}
?>