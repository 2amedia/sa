<?php
class CPapacarlostudioSmtpmail {
	const MODULE_ID = 'papacarlostudio.smtpmail';
	public static $sites = array();
	
	public static function OnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu) {
		if ($GLOBALS['APPLICATION']->GetGroupRight('main') < 'R')
			return;
		
		$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/css/' . self::MODULE_ID . '/style.css');
		
		$aMenu = array(
			'parent_menu' => 'global_menu_services',
			'section' => self::MODULE_ID,
			'sort' => 50,
			'text' => GetMessage(self::MODULE_ID . '_MENU_TITLE'),
			'title' => GetMessage(self::MODULE_ID . '_MENU_TITLE'),
			'url' => self::MODULE_ID . '_settings.php?SITE_ID=' . self::getCurSite(),
			'icon' => 'papacarlostudio-smtpmail-icon',
			'page_icon' => '',
			'items_id' => self::MODULE_ID . '_items',
			'more_url' => array(),
			'items' => array()
		);
		
		if (file_exists($path = dirname(dirname(dirname(__FILE__))) . '/admin')) {
			if ($dir = opendir($path)) {
				$arFiles = array();
				
				while(false !== $item = readdir($dir)) {
					if (in_array($item, array('.', '..', 'menu.php')))
						continue;
					
					if (!file_exists($file = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . self::MODULE_ID . '_' . $item))
						file_put_contents($file, '<' . '? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/' . self::MODULE_ID . '/admin/' . $item . '");?' . '>');
					
					$arFiles[] = $item;
				}
				
				sort($arFiles);
				
				foreach($arFiles as $item) {
					$name = GetMessage(self::MODULE_ID . '_' . strtoupper(str_replace('.php', '', $item)) . '_MENU_TITLE');
					$more_url = array();
					
					foreach (self::$sites as $domain => $siteId) {
						$aMenu['items'][] = array(
							'text' => $name . ' [' . $domain . ']',
							'url' => self::MODULE_ID . '_' . $item . '?SITE_ID=' . $siteId,
							'module_id' => self::MODULE_ID,
							'more_url' => $more_url,
							'title' => $name
						);
					}
				}
			}
		}
		
		$aModuleMenu[] = $aMenu;
	}
	
	public static function CustomMail() {
		return true;
	}
	
	public static function getCurSite() {
		if (!sizeof(self::$sites)) {
			$rsSites = CSite::GetList($by = 'sort', $order = 'desc');
			
			while ($site = $rsSites->Fetch()) {
				self::$sites[strtolower(trim($site['SERVER_NAME']))] = $site['ID'];
			}
		}
		
		if (isset(self::$sites[strtolower(trim($_SERVER['SERVER_NAME']))])) {
			return self::$sites[strtolower(trim($_SERVER['SERVER_NAME']))];
		} else {
			return '';
		}
	}
}
?>