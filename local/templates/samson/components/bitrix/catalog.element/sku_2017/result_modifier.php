<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

foreach ($arResult['SKU_PROPS'] as $skuProperty)

{   $type_file = false;
	$table = $skuProperty['USER_TYPE_SETTINGS']['TABLE_NAME'];
	$rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter' => array('TABLE_NAME' => $table)));
	if (!($arData = $rsData->fetch()))
	{
		//($arData);
	}
	$hlblock = HL\HighloadBlockTable::getById($arData['ID'])->fetch();
	$entity = HL\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();

	foreach ($skuProperty['VALUES'] as $value) {
		$row = $entity_data_class::getById($value['ID'])->fetch();
		if (!empty($row))
		{
			$css = $row['UF_CSS'];
			$desc = $row['UF_DESCRIPTION'];
			if($row['UF_FILE']>0){
				$type_file = true;
			}
			$value['DESCRIPTION'] = $desc;
			$value['CSS'] = $css;
		}
		$newValues[] = $value;
	}
	$skuProperty['VALUES']= $newValues;
unset($newValues);
	if ($type_file) {
		$skuProperty['SHOW_MODE'] = 'PICT';
	}
	else {
		$skuProperty['SHOW_MODE'] = 'TEXT';
	}
	//($skuProperty);
	$newskuProperty[] = $skuProperty;
}

$arResult['SKU_PROPS']= $newskuProperty;

$uslugi = $arResult['PROPERTIES']['USLUGI']['VALUE'];
if(count($uslugi)>0) {
	$arSelect = Array('ID','NAME','PREVIEW_TEXT','PROPERTY_PER_PRICE');
	$arFilter = Array(
		"ID" => $uslugi
	);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	$i = 0;
	while ($ob = $res->GetNextElement())
	{
		$arFields['ITEMS'][$i] = $ob->GetFields();
		$arFields['ITEMS'][$i]['PRICE'] = CCatalogProduct::GetOptimalPrice($arFields['ITEMS'][$i]['ID'], 1, $USER->GetUserGroupArray());
		$i++;
	}

	foreach ($arFields['ITEMS'] as $arField)
	{
		$usluga = array(
		'ID'=> $arField['ID'],
		'NAME'=> $arField['NAME'],
		'DESCR'=> $arField['PREVIEW_TEXT'],
		'PRICE' => number_format($arField['PRICE']['DISCOUNT_PRICE'], 0, ' ', ' '),
		'PER_PRICE'=> $arField['PROPERTY_PER_PRICE_VALUE']
		);
		$arUslugi[]= $usluga;
	}
	unset($arFields,$arSelect);
	$arResult['USLUGI'] = $arUslugi;
};

$soputka = $arResult['PROPERTIES']['BUY_WITH_THIS_PRODUC']['VALUE'];
if (count($soputka) > 0)
{
	$arSelect = Array(
		'ID',
		'NAME',
		'PREVIEW_TEXT',
		'PREVIEW_PICTURE',
		'DETAIL_PAGE_URL'
	);
	$arFilter = Array(
		"ID" => $soputka
	);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	$i = 0;
	while ($ob = $res->GetNextElement())
	{
		$arFields['ITEMS'][$i] = $ob->GetFields();
		$arFields['ITEMS'][$i]['PRICE'] = CCatalogProduct::GetOptimalPrice($arFields['ITEMS'][$i]['ID'], 1, $USER->GetUserGroupArray());
		$i++;
	}

	foreach ($arFields['ITEMS'] as $arField)
	{
		$file = CFile::ResizeImageGet($arField['PREVIEW_PICTURE'], array(
			'width' => 70,
			'height' => 70
		), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		$soputkaT = array(
			'ID' => $arField['ID'],
			'NAME' => $arField['NAME'],
			'DESCR' => $arField['PREVIEW_TEXT'],
			'PRICE' => number_format($arField['PRICE']['DISCOUNT_PRICE'], 0, ' ', ' '),
			'URL'=>$arField['DETAIL_PAGE_URL'],
			'PIC'=> $file['src']
		);
		$arSoputka[] = $soputkaT;
	}
	unset($arFields);
	$arResult['SOPUTKA'] = $arSoputka;
};


if (!empty($arResult['OFFERS'])){
	foreach ($arResult['OFFERS'] as $key=>$offer)
	{
		$chert_values = $offer['PROPERTIES']['SKU_CHERT']['VALUE'];
		foreach ($chert_values as $chert){
			$file = CFile::GetFileArray($chert);
			$files[] = array(
				'ID'=> $chert,
				'SRC'=> $file['SRC'],
				'HEIGHT'=>$file['HEIGHT'],
				'WIDTH'=>$file['WIDTH']
			);
		}
		$arResult ['JS_OFFERS'][$key]['TEXT'] = $offer['DETAIL_TEXT'];
		$arResult ['JS_OFFERS'][$key]['CHERT']= $files;
		unset($files);
	}
}

//получим сертификаты
if(!empty($arResult['PROPERTIES']['SERT_IMAGES']['VALUE'])) {
	foreach ($arResult['PROPERTIES']['SERT_IMAGES']['VALUE'] as $val) {
		$sert_file = CFile::ResizeImageGet($val,array('width'=>1200, 'height'=>900),BX_RESIZE_IMAGE_PROPORTIONAL);
		//($sert_file);
		$serts[] = $sert_file['src'];
	}
}
$arResult['SERT'] = $serts;

unset($serts);

//получим чертеж элемента
if (!empty($arResult['PROPERTIES']['CHERT']['VALUE']))
{
	foreach ($arResult['PROPERTIES']['CHERT']['VALUE'] as $val)
	{
		$sert_file = CFile::ResizeImageGet ($val, array(
			'width' => 1200,
			'height' => 900
		), BX_RESIZE_IMAGE_PROPORTIONAL);
		($sert_file);
		$serts[] = $sert_file['src'];
	}
}

$arResult['CHERT'] = $serts;
unset($serts);

$cp = $this->__component;
if (is_object($cp))
{
	$cp->SetResultCacheKeys(array(
		'USLUGI',
		'SOPUTKA',
		'SERT',
		'CHERT'
	));
}
