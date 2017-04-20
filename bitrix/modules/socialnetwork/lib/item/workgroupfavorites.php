<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage socialnetwork
 * @copyright 2001-2012 Bitrix
 */
namespace Bitrix\Socialnetwork\Item;

use Bitrix\Main\Localization\Loc;
use Bitrix\Socialnetwork\WorkgroupFavoritesTable;

Loc::loadMessages(__FILE__);

class WorkgroupFavorites
{
	public static function set($params)
	{
		global $USER;

		$groupId = (isset($params["GROUP_ID"]) ? intval($params["GROUP_ID"]) : false);
		$userId = (isset($params["USER_ID"]) ? intval($params["USER_ID"]) : $USER->getId());
		$value = (isset($params["VALUE"]) && in_array($params["VALUE"], array('Y', 'N')) ? $params["VALUE"] : false);

		if (
			intval($groupId) <= 0
			|| intval($userId) <= 0
			|| !$value
		)
		{
			throw new \Exception(Loc::getMessage('SOCIALNETWORK_ITEM_WORKGROUPFAVORITES_ERROR_NO_DATA'));
		}

		if (!($group = \CSocNetGroup::getByID($groupId, true)))
		{
			throw new \Exception(Loc::getMessage('SOCIALNETWORK_ITEM_WORKGROUPFAVORITES_ERROR_NO_ACCESS'));
		}

		if ($value == 'Y')
		{
			return WorkgroupFavoritesTable::set(array(
				'GROUP_ID' => $groupId,
				'USER_ID' => $userId
			));
		}
		else
		{
			return self::delete(array(
				'GROUP_ID' => $groupId,
				'USER_ID' => $userId
			));
		}
	}

	public static function delete($params)
	{
		global $CACHE_MANAGER, $USER;

		$groupId = (isset($params["GROUP_ID"]) ? intval($params["GROUP_ID"]) : false);
		$userId = (isset($params["USER_ID"]) ? intval($params["USER_ID"]) : $USER->getId());

		if (
			intval($groupId) <= 0
			|| intval($userId) <= 0
		)
		{
			return false;
		}

		$res = WorkgroupFavoritesTable::delete(array(
			'GROUP_ID' => $groupId,
			'USER_ID' => $userId
		));

		if (
			$res
			&& defined("BX_COMP_MANAGED_CACHE")
		)
		{
			$CACHE_MANAGER->ClearByTag("sonet_group_favorites_U".$userId);
		}

		return $res;
	}
}
