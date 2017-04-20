<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");
?>
<?
// https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblockelement/getlist.php
$arOrder = Array("SORT" => "ASC");
$arGroupBy = false;
$arNavStartParams = false;
$arSelect = Array(
	"ID",
	"IBLOCK_ID",
	"NAME",
	"DATE_ACTIVE_FROM",
	"PROPERTY_*",
	"IBLOCK_SECTION_ID"
);
$arFilter = Array(
	"IBLOCK_ID" => IntVal (),
	"ACTIVE_DATE" => "Y",
	"ACTIVE" => "Y"
);
$res = CIBlockElement::GetList ($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelect);
while ($ob = $res->GetNextElement ())
{
	$arFields = $ob->GetFields ();
	$elements[$arFields['ID']] = $arFields;
	$arProps = $ob->GetProperties ();
	$elements[$arFields['ID']]['PROPERTIES'] = $arProps;
}

unset($arOrder, $arGroupBy, $arNavStartParams, $arSelect, $arFilter, $res, $ob, $arFields, $arProps);

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
