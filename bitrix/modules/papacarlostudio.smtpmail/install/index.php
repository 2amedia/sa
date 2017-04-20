<?php
IncludeModuleLangFile(__FILE__);

class papacarlostudio_smtpmail extends CModule {
	var $MODULE_ID = 'papacarlostudio.smtpmail';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';
	
	function __construct() {
		$arModuleVersion = array();
		
		include(dirname(__FILE__) . '/version.php');
		
		$this->MODULE_VERSION = $arModuleVersion['VERSION'];
		$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		$this->MODULE_NAME = GetMessage('papacarlostudio.smtpmail_MODULE_NAME');
		$this->MODULE_DESCRIPTION = GetMessage('papacarlostudio.smtpmail_MODULE_DESC');
		
		$this->PARTNER_NAME = GetMessage('papacarlostudio.smtpmail_PARTNER_NAME');
		$this->PARTNER_URI = GetMessage('papacarlostudio.smtpmail_PARTNER_URI');
	}
	
	function InstallDB($arParams = array()) {
		global $DB;
		RegisterModuleDependences('main', 'OnBuildGlobalMenu', $this->MODULE_ID, 'CPapacarlostudioSmtpmail', 'OnBuildGlobalMenu');
		RegisterModuleDependences('main', 'OnPageStart', $this->MODULE_ID, 'CPapacarlostudioSmtpmail', 'CustomMail');
				
		return true;
	}
	
	function UnInstallDB($arParams = array()) {
		global $DB;
		UnRegisterModuleDependences('main', 'OnBuildGlobalMenu', $this->MODULE_ID, 'CPapacarlostudioSmtpmail', 'OnBuildGlobalMenu');
		UnRegisterModuleDependences('main', 'OnPageStart', $this->MODULE_ID, 'CPapacarlostudioSmtpmail', 'CustomMail');
		COption::SetOptionString($this->MODULE_ID, 'SMTP_ACTIVE', 'N');
		
		return true;
	}
	
	function InstallEvents() {
		return true;
	}
	
	function UnInstallEvents() {
		return true;
	}
	
	function InstallFiles($arParams = array()) {
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/admin')) {
			if ($dir = opendir($p)) {
				while (false !== $item = readdir($dir)) {
					if ($item == '..' || $item == '.' || $item == 'menu.php')
						continue;
					
					file_put_contents($file = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $this->MODULE_ID . '_' . $item,
					'<' . '? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/' . $this->MODULE_ID . '/admin/' . $item . '");?' . '>');
				}
				
				closedir($dir);
			}
		}
		
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$this->MODULE_ID.'/install/components')) {
			if ($dir = opendir($p)) {
				while (false !== $item = readdir($dir)) {
					if ($item == '..' || $item == '.')
						continue;
					
					CopyDirFiles($p . '/' . $item, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components/' . $item, $ReWrite = true, $Recursive = true);
				}
				
				closedir($dir);
			}
		}
		
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$this->MODULE_ID.'/css')) {
			if ($dir = opendir($p)) {
				while (false !== $item = readdir($dir)) {
					if ($item == '..' || $item == '.')
						continue;
					
					CopyDirFiles($p . '/' . $item, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/css/' . $this->MODULE_ID . '/' . $item, $ReWrite = true, $Recursive = true);
				}
				
				closedir($dir);
			}
		}
		
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$this->MODULE_ID.'/js')) {
			if ($dir = opendir($p)) {
				while (false !== $item = readdir($dir)) {
					if ($item == '..' || $item == '.')
						continue;
					
					CopyDirFiles($p . '/' . $item, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/js/' . $this->MODULE_ID . '/' . $item, $ReWrite = true, $Recursive = true);
				}
				
				closedir($dir);
			}
		}
		
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$this->MODULE_ID.'/images')) {
			if ($dir = opendir($p)) {
				while (false !== $item = readdir($dir)) {
					if ($item == '..' || $item == '.')
						continue;
					
					CopyDirFiles($p . '/' . $item, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/images/' . $this->MODULE_ID . '/' . $item, $ReWrite = true, $Recursive = true);
				}
				
				closedir($dir);
			}
		}
		
		return true;
	}
	
	function UnInstallFiles() {
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/admin')) {
			if ($dir = opendir($p)) {
				while (false !== $item = readdir($dir)) {
					if ($item == '..' || $item == '.')
						continue;
					
					unlink($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $this->MODULE_ID . '_' . $item);
				}
				
				closedir($dir);
			}
		}
		
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/install/components')) {
			if ($dir = opendir($p)) {
				while (false !== $item = readdir($dir)) {
					if ($item == '..' || $item == '.' || !is_dir($p0 = $p . '/' . $item))
						continue;
					
					$dir0 = opendir($p0);
					
					while (false !== $item0 = readdir($dir0)) {
						if ($item0 == '..' || $item0 == '.')
							continue;
						
						DeleteDirFilesEx('/bitrix/components/' . $item . '/' . $item0);
					}
					
					closedir($dir0);
				}
				
				closedir($dir);
			}
		}
		
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/js/' . $this->MODULE_ID)) {
			DeleteDirFilesEx('/bitrix/js/' . $this->MODULE_ID);
		}
		
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/css/' . $this->MODULE_ID)) {
			DeleteDirFilesEx('/bitrix/css/' . $this->MODULE_ID);
		}
		
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/images/' . $this->MODULE_ID)) {
			DeleteDirFilesEx('/bitrix/images/' . $this->MODULE_ID);
		}
		
		return true;
	}

	function DoInstall() {
		global $APPLICATION;
		$this->InstallFiles();
		$this->InstallDB();
		RegisterModule($this->MODULE_ID);
	}

	function DoUninstall() {
		global $APPLICATION;
		UnRegisterModule($this->MODULE_ID);
		$this->UnInstallDB();
		$this->UnInstallFiles();
	}
}
?>