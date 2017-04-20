<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$price = 0;
$quantity = 0;
$arProducts = array();
foreach ($arResult["ITEMS"] as $arItem)
{
	if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y")
	{
		$price += $arItem["PRICE"] * $arItem["QUANTITY"];
		$quantity += $arItem["QUANTITY"];

		$arProducts[] = $arItem['PRODUCT_ID'];
	}
}
$arResult['PRICE'] = $price;
$arResult['PRICE_FORMATED'] = CurrencyFormat($price, 'RUB');
$arResult['QUANTITY'] = $quantity;

if (sizeof($arProducts) && CModule::IncludeModule('iblock'))
{
	$res = CIBlockElement::GetList(array(), array('ID' => $arProducts), false, false, array('ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE'));
	while ($ar = $res->Fetch())
	{
		if ($ar['PREVIEW_PICTURE'] > 0)
			$img = $ar['PREVIEW_PICTURE'];
		elseif ($ar['DETAIL_PICTURE'] > 0)
			$img = $ar['DETAIL_PICTURE'];
		
		if ($img)
			$arResult['PICTURES'][$ar['ID']] = CFile::ResizeImageGet($img, array('width' => 65, 'height' => 65));
	}
}
?>
