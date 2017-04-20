<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arResult = array('result' => false);

function add2cart($id, $q,$props,$sessid)
{
	$res = false;
	if (CModule::IncludeModule('catalog') && check_bitrix_sessid())
	{
		$productId = intval($id);
		$quantity = intval($q);
		$quantity = $quantity > 0 ? $quantity : 1;
		
		$basket = \Bitrix\Sale\Basket::loadItemsForFUser (\Bitrix\Sale\Fuser::getId (), Bitrix\Main\Context::getCurrent ()->getSite ());
		
		if ($item = $basket->getExistsItem ('catalog', $productId))
		{
			$item->setField ('QUANTITY', $item->getQuantity () + $quantity);
		}
		else
		{
			$item = $basket->createItem ('catalog', $productId);
			$item->setFields ([
				'QUANTITY' => $quantity,
				'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency (),
				'LID' => \Bitrix\Main\Context::getCurrent ()->getSite (),
				'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
			]);
		}
		
		if ($props)
		{
			$item->getPropertyCollection ()->setProperty ($props);
		}
		
		if ($basket->save ()) {
			$res = true;
		}
	}
	return array('result' => $res);
}

function changeCart($id, $q)
{
	if (CModule::IncludeModule('sale'))
	{
		$id = intval($id);
		$q = intval($q);
		$res = false;

		if ($id > 0)
			$res = CSaleBasket::Update($id, array('QUANTITY' => $q));
		return array('result' => $res);
	}
}


switch ($_REQUEST['action'])
{
	case 'add':
		$arResult = add2cart($_REQUEST['id'],$_REQUEST['q'], [],$_REQUEST['sessid']);
		break;
	case 'addmore':
	{
		$productId = $_REQUEST['id'];
		$set_ids= explode (',', $_REQUEST["set_ids"]);
		$props = array();
		$parentID = $_REQUEST['parent_id'];
		
/*		нужно
		
		1) создать список свойств товара
		2) добавить данный товар в корзинку  и показать совйства
		3) если отмеченно, то добавить в корзинку товар с ценной и id
		
		*/

		 if ($parentID>0)
		 {

			 //получили список услуг
			 $arOrder = Array("SORT" => "ASC");
			 $arGroupBy = false;
			 $arNavStartParams = false;
			 $arSelect = Array(
				 "ID",
				 "IBLOCK_ID",
			 );
			 $arFilter = Array(
				 "IBLOCK_ID" => [
					 3,
					 10
				 ],
				 "ACTIVE_DATE" => "Y",
				 "ACTIVE" => "Y",
				 "ID"=> $parentID
			 );
			 $res = CIBlockElement::GetList ($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelect);
			 while ($ob = $res->GetNextElement ())
			 {
				 $arFields = $ob->GetFields ();
				 $elements[$arFields['ID']] = $arFields;
				 $arProps = $ob->GetProperties ([],['CODE'=>'USLUGI']);
				 $elements[$arFields['ID']]['PROPERTIES'] = $arProps;
				 $uslugi = $arProps['USLUGI']['VALUE'];
			 }
			 unset($arOrder, $arGroupBy, $arNavStartParams, $arSelect, $arFilter, $res, $ob, $arFields, $arProps, $elements);
			 
			 
			 //если есть услуги
			 
			 if (is_array($uslugi)) {
				 // получили подмассив доступных услуг и их цены
				 $arOrder = Array("SORT" => "ASC");
				 $arGroupBy = false;
				 $arNavStartParams = false;
				 $arSelect = Array(
					 "ID",
					 "IBLOCK_ID",
					 "NAME",
					 "PROPERTY_PER_PRICE",
				 );
				 $arFilter = Array(
					 "IBLOCK_ID" => IntVal (11),
					 "ACTIVE_DATE" => "Y",
					 "ACTIVE" => "Y",
					 'ID'=> $uslugi
				 );
				 $res = CIBlockElement::GetList ($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelect);
				 while ($ob = $res->GetNextElement ())
				 {
					 $arFields = $ob->GetFields ();
					 $arProps = $ob->GetProperties ();
					 $elements[$arFields['ID']] = [
					 	'ID'=> $arFields['ID'],
						'NAME'=> $arFields['NAME'],
						'PERSENT'=> $arProps['PER_PRICE']['VALUE']
					 ];
				 }
				
				 unset($arOrder, $arGroupBy, $arNavStartParams, $arSelect, $arFilter, $res, $ob, $arFields, $arProps);
				
				 foreach ($elements as $key=>$element)
				 {
				 	if(!intval($element['PERSENT'])>0){
						$ar_price = GetCatalogProductPrice ($element['ID'], 1);
						$elements[$key]['PRICE'] =round($ar_price['PRICE']);
					}
					
					else {
						$ar_price = GetCatalogProductPrice ($productId, 1);
						//dump($ar_price);
						$elements[$key]['PRICE'] = round (IntVal($ar_price['PRICE'])* IntVal($element['PERSENT'])/100);
					}
				 }
				 
				 
				 //положим товар в корзину со свойствами
				 foreach ($elements as $element)
				 {
					 $props[] = [
					 	'NAME'=> $element['NAME'],
						'VALUE'=>$element['PRICE']
					 ];
				}
				
			 }
		 
		 }
		
		 //добавление в корзинку
		$arResult = add2cart ($productId, $_REQUEST['q'], $props,$_REQUEST['sessid']);
		
		
		if (is_array($set_ids))
		{
			foreach ($set_ids as $itemID)
			{
				if (intval($itemID))
				{
					$arResult = add2cart($itemID, 1,[], $_REQUEST['sessid']);
				}
			}
		}

		$set_ids_percent = explode (',', $_REQUEST["set_ids_percent"]);

		foreach ($set_ids_percent as $item)
		{
			$item = explode(':', $item);
			$productId = $item[0];
			$price = $item[1];
			$quantity = 1;
			$res = CIBlockElement::GetByID($productId);
			if ($ar_res = $res->GetNext ())
			{
				$name = $ar_res['NAME'];
			}

			// магия

			$basket = \Bitrix\Sale\Basket::loadItemsForFUser (\Bitrix\Sale\Fuser::getId (), \Bitrix\Main\Context::getCurrent ()->getSite ());

			if ($item = $basket->getExistsItem ('catalog', $productId))
			{
				$item->setField ('QUANTITY', $item->getQuantity () + $quantity);
			}
			else
			{

				//Добавление товара
				$item = $basket->createItem ('catalog', $productId);
				$item->setFields ([
					'QUANTITY' => $quantity,
					'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency (),
					'LID' => \Bitrix\Main\Context::getCurrent ()->getSite (),
					'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
					'PRICE' => $price,
					'CUSTOM_PRICE' => 'Y',
					'IGNORE_CALLBACK_FUNC' => 'Y',
					'NAME'=> $name
				]);
			}

//Сохранение изменений
			$basket->save ();

		}
	
	}
		break;
	case 'change':
		$arResult = changeCart($_REQUEST['id'], $_REQUEST['q']);
		break;
	case 'delete':
		$arResult = changeCart($_REQUEST['id'], 0);
	default:
		break;
}

header('Content-type: application/json');
echo json_encode($arResult);
?>
