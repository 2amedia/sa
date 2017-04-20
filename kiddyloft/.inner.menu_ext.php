<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "samson:samson.menu.list",
    "",
    Array(
        "IBLOCK_TYPE" => "Catalogs", // тип
        "IBLOCK_ID" => "3",// id инфоблока
        "SECTION_ID" => "238", //id раздела
        "LINK" => "/Netshop/kiddiloft/", // путь откуда достраивать ссылки (где лежит файл)
        "CACHE_TYPE" => "A", // автокеширование
        "CACHE_TIME" => "3600" //кеш на 1 час
    )
);
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt); // достраиваем массив с ссылками

