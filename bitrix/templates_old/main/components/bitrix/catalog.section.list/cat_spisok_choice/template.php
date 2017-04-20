<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"];
foreach($arResult["SECTIONS"] as $arSection):
	
	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
?>
   <? if($arSection["ID"] == '2') { ?>
   <h6 class="spisok_cena_metal"><a style="text-decoration:none" href="/Netshop/choice/metalstreet/"><?=$arSection["NAME"]?></a></h6><br/>
			
		<? } else { ?>
			 <h6 class="spisok_cena_metal"><?=$arSection["NAME"]?></a></h6><br/>
		<? } ?>
        




<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "cat_spisok_choice2", Array(
	"IBLOCK_TYPE" => "Catalogs",	// Тип инфоблока
	"IBLOCK_ID" => "3",	// Инфоблок
	"SECTION_ID" => $arSection["ID"],	// ID раздела
	"SECTION_CODE" => "",	// Код раздела
	"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
	"COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
	"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
	"SECTION_FIELDS" => "DETAIL_PICTURE",	// Поля разделов
	"SECTION_USER_FIELDS" => "",	// Свойства разделов
	"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
	"CACHE_TYPE" => "N",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_GROUPS" => "N",	// Учитывать права доступа
	),
	false
);?> 


<?endforeach?>
