<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "samson:samson.menu.list",
    "",
    Array(
        "IBLOCK_TYPE" => "Catalogs",
        "IBLOCK_ID" => "3",
        "SECTION_ID" => "6",
        "LINK" => "/Netshop/zima/",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600"
    )
);
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);

