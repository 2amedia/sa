<?
namespace AAM;

use Bitrix\Sale\Helpers;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Main\SystemException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Sale\Shipment;

Loc::loadMessages (__FILE__);

class PEKDeliveryHandler extends \Bitrix\Sale\Delivery\Services\Base
{
	protected static $isCalculatePriceImmediately = true;
	protected static $whetherAdminExtraServicesShow = false;
	protected static $canHasProfiles = false;
	
	public function __construct (array $initParams)
	{
		parent::__construct ($initParams);
	}
	
	public static function getClassTitle ()
	{
		return 'Свой обработчик ПЭК';
	}
	
	public static function getClassDescription ()
	{
		return 'Обработчик ПЭК для SAMSON';
	}
	
	public function isCalculatePriceImmediately ()
	{
		return self::$isCalculatePriceImmediately;
	}
	
	public static function whetherAdminExtraServicesShow ()
	{
		return self::$whetherAdminExtraServicesShow;
	}
	
	public static function canHasProfiles ()
	{
		return self::$canHasProfiles;
	}
	
	protected function getConfigStructure ($siteId = false)
	{
		$shopLocationId = \CSaleHelper::getShopLocationId ($siteId);
		$arShopLocation = \CSaleHelper::getLocationByIdHitCached ($shopLocationId);
		
		$locString = strlen ($arShopLocation["COUNTRY_NAME_LANG"]) > 0 ? $arShopLocation["COUNTRY_NAME_LANG"] : "";
		$locString .= (strlen ($arShopLocation["REGION_NAME_LANG"]) > 0 ? (strlen ($locString) > 0 ? ", " : "") . $arShopLocation["REGION_NAME_LANG"] : "");
		$locString .= (strlen ($arShopLocation["CITY_NAME_LANG"]) > 0 ? (strlen ($locString) > 0 ? ", " : "") . $arShopLocation["CITY_NAME_LANG"] : "");
		$locDelivery = mapLocation ($shopLocationId);
		$result = array(
			'MAIN' => array(
				'TITLE' => 'Основные',
				'DESCRIPTION' => 'Основные настройки',
				'ITEMS' => array(
					'API_KEY' => array(
						'TYPE' => 'STRING',
						'NAME' => 'Ключ API',
					),
					"CITY" => array(
						"TYPE" => 'DELIVERY_READ_ONLY',
						"NAME" => 'Местоположение магазина<br> из модуля Интернет-магазин',
						"DEFAULT" => $locString
					)
				)
			)
		);
		return $result;
	}
	
	protected static function mapLocation2 ($internalLocationId)
	{
		if (intval ($internalLocationId) <= 0)
		{
			return array();
		}
		
		static $result = array();
		
		if (!isset($result[$internalLocationId]))
		{
			$result[$internalLocationId] = array();
			
			$internalLocation = \CSaleHelper::getLocationByIdHitCached ($internalLocationId);
			$externalId = \Location::getExternalId ($internalLocationId);
			
			if (strlen ($externalId) > 0)
			{
				$result[$internalLocationId] = array(
					$externalId => !empty($internalLocation["CITY_NAME_LANG"]) ? $internalLocation["CITY_NAME_LANG"] : ""
				);
			}
		}
		
		return $result[$internalLocationId];
	}
	
	
	protected function prepare_request_to_api (\Bitrix\Sale\Shipment $shipment = null)
	{
		$order = $shipment->getCollection ()->getOrder (); // заказ
		$basket = $order->getBasket ();
		foreach ($basket as $basketItem)
		{
			$measureCoeff = 1000;
			$item_param['DIMENSIONS'] = unserialize ($basketItem->getField ('DIMENSIONS'));
			$item_param['WIDTH'] = round ($item_param['DIMENSIONS']['WIDTH'] / $measureCoeff, 2);
			$item_param['HEIGHT'] = round ($item_param['DIMENSIONS']['HEIGHT'] / $measureCoeff, 2);
			$item_param['LENGTH'] = round ($item_param['DIMENSIONS']['LENGTH'] / $measureCoeff, 2);
			$item_param['VOLUME'] = floatval (\CSaleDeliveryHelper::calcItemVolume ($item_param) / (pow ($measureCoeff, 3)));
			$item_param['WEIGHT'] = round ($basketItem->getField ('WEIGHT') / $measureCoeff, 2);
			unset ($item_param['DIMENSIONS']);
			$qty = $basketItem->getQuantity ();
			if ($qty > 1)
			{
				$i = 1;
				while ($i <= $qty)
				{
					$items[] = $item_param;
					$i++;
				}
			}
			else
			{
				$items[] = $item_param;
			}
		}
		
		$packsCount = count ($items);
		$itemsStr = '';
		for ($i = 0; $i < $packsCount; $i++)
		{
			$item = $items[$i];
			$itemsStr .= 'places[' . $i . '][]=' . strval ($item['WIDTH']) . '&places[' . $i . '][]=' . strval ($item['LENGTH']) . '&places[' . $i . '][]=' . strval ($item['HEIGHT']) . '&places[' . $i . '][]=' . strval ($item['VOLUME']) . '&places[' . $i . '][]=' . strval ($item["WEIGHT"]) . '&places[' . $i . '][]=' . '0' . '&places[' . $i . '][]=' . '0';
		}
		
		//$locationCode = $props->getDeliveryLocation ()->getValue (); // местоположение
		//dump($locationCode);
		
		$req_string = $itemsStr . '&take[town]=' . $this->arConfig["CITY_DELIVERY"]["VALUE"] . '&take[tent]=0' . '&take[gidro]=0' . '&take[speed]=0' . '&take[moscow]=0' . '&deliver[town]=' . $locationTo . '&deliver[tent]=0' . '&delideliver[gidro]=0' . '&deliver[speed]=0' . '&deliver[moscow]=0' . '&plombir=0' . '&strah=0' . '&ashan=0' . '&night=0' . '&pal=0';
		
		return $req_string;
	}
	
	protected function calculateConcrete (\Bitrix\Sale\Shipment $shipment = null)
	{
		
		$result = new \Bitrix\Sale\Delivery\CalculationResult();
		$result->setDeliveryPrice (roundEx (500, SALE_VALUE_PRECISION));
		$result->setPeriodDescription ('4-7 days');
		
		return $result;
	}
	
	public function isCompatible (\Bitrix\Sale\Shipment $shipment)
	{
		$calcResult = self::calculateConcrete ($shipment);
		return $calcResult->isSuccess ();
	}
}
