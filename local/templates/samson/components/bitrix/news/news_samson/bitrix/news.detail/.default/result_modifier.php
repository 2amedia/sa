<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arParams["DISPLAY_PREV_NEXT_NAV"] != "N") 
{
    if(!CModule::IncludeModule("iblock"))
    {
        ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
        return;
    }
    
    $arResult["PREV_NEXT_NAV"] = array();

    //SELECT
    $arSelect = array(
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "NAME",
        "ACTIVE_FROM",
        "DETAIL_PAGE_URL",
    );
    
    //WHERE
    $arFilter = array (
        "IBLOCK_ID" => $arResult["IBLOCK_ID"],
        "IBLOCK_LID" => SITE_ID,
        "ACTIVE" => "Y",
        "CHECK_PERMISSIONS" => "Y",
    );
    
    if($arParams["CHECK_DATES"])
        $arFilter["ACTIVE_DATE"] = "Y";
    
    //ORDER BY
    $arSort = array(
        $arParams["SORT_BY1"]=>$arParams["SORT_ORDER1"],
        $arParams["SORT_BY2"]=>$arParams["SORT_ORDER2"],
    );
    if(!array_key_exists("ID", $arSort))
        $arSort["ID"] = "DESC";
    
    $rsElement = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
    $rsElement->SetUrlTemplates($arParams["DETAIL_URL"]);
    
    $arResult["PREV_NEXT_NAV"]["PREV_ITEM"] = false;
    $arResult["PREV_NEXT_NAV"]["NEXT_ITEM"] = false;
    $nextIsLast = false;
    while($obElement = $rsElement->GetNextElement())
    {
        $arItem = $obElement->GetFields();
    
        if(strlen($arItem["ACTIVE_FROM"])>0)
            $arItem["DISPLAY_ACTIVE_FROM"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arItem["ACTIVE_FROM"], CSite::GetDateFormat()));
        else
            $arItem["DISPLAY_ACTIVE_FROM"] = "";
    
        if ($arItem["ID"] == $arResult["ID"]) {
            $arResult["PREV_NEXT_NAV"]["PREV_ITEM"]=$arPrevItem;
            $nextIsLast = true; //next iteration will be last
        }
        else if ($nextIsLast) {
            $arResult["PREV_NEXT_NAV"]["NEXT_ITEM"] = $arItem;
            break;
        }
        else $arPrevItem = $arItem;
    }
}
?>