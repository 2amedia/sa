<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//добираем данные по товарам с этим товаром покупают
if($arResult["PROPERTIES"]["BUY_WITH_THIS_PRODUC"]["VALUE"]) {

    $arFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $arResult["PROPERTIES"]["BUY_WITH_THIS_PRODUC"]["VALUE"], "ACTIVE" => "Y", "SECTION_GLOBAL_ACTIVE" => "Y");
    $dbItems = CIBlockElement::GetList(Array("NAME"=>"ASC"), $arFilter);

    while ($arItem = $dbItems->GetNext()) {
        $res = $arItem;
        $get_prd = GetCatalogProduct($res["ID"]);
        $get_prd_price = GetCatalogProductPriceList($get_prd["ID"]);
        $file = CFile::ResizeImageGet($res['DETAIL_PICTURE'], array('width' => 100, 'height' => 100));

        $arByWith[] = array(
            'name' => $res['NAME'],
            'url' => $res['DETAIL_PAGE_URL'],
            'img' => $file['src'],
            'price' => number_format($get_prd_price["0"]["PRICE"], 0, ',', ' ') . ' руб.'
        );
    }
    $arResult['BY_WHITH'] = $arByWith;
}

//кешируем

//получим процент скидки

if ($arResult['PRICES']['roznica']['DISCOUNT_VALUE'] > 0) {
    $price = CCatalogProduct::GetOptimalPrice($arResult["ID"], 1, array(2), "N", array(), 's1');
    $arResult['SALE'] = $price['DISCOUNT']['VALUE'];
}

//подготовим изображения с ватермарками

$fileID = $arResult["DETAIL_PICTURE"]['ID'];
$arFilter = Array(
    array("name" => "watermark", "position" => "topleft", "size"=>"real", "file"=>$_SERVER['DOCUMENT_ROOT']."/upload/watermark/800_600.png")
);
$arFilter_s = Array(
    array("name" => "watermark", "position" => "topleft", "size"=>"real", "file"=>$_SERVER['DOCUMENT_ROOT']."/upload/watermark/302_264.png")
);
$arFilter_ss = Array(
    array("name" => "watermark", "position" => "topleft", "size"=>"real", "file"=>$_SERVER['DOCUMENT_ROOT']."/upload/watermark/70_70.png")
);

$big = CFile::ResizeImageGet($fileID, array('width' => 800, 'height' => 600),BX_RESIZE_IMAGE_PROPORTIONAL_ALT,false,$arFilter);
$small = CFile::ResizeImageGet($fileID, array('width' =>320, 'height' => 240),BX_RESIZE_IMAGE_PROPORTIONAL_ALT,false,$arFilter_s);

$images[0] = array(
  'big' =>  $big['src'],
    'small' =>  $small['src'],
);

if($arResult["PROPERTIES"]["ADD_PHOTO_IN_DETAIL"]["VALUE"]) {
    foreach ($arResult["PROPERTIES"]["ADD_PHOTO_IN_DETAIL"]["VALUE"] as $value) {
        $big = CFile::ResizeImageGet($value, array('width' => 800, 'height' => 600), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, $arFilter);
        $small = CFile::ResizeImageGet($value, array('width' => 70, 'height' => 70), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true, $arFilter_ss);
        $images[] = array(
            'big' =>  $big['src'],
            'small' =>  $small['src'],
        );
    }
}

$arResult['IMAGES'] = $images;
// доберем варианты товаров

$arSelect = Array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "CATALOG_GROUP_1",'DETAIL_PAGE_URL');
$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$arResult["IBLOCK_SECTION_ID"]);
$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);

while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    if ($arResult['ID'] != $arFields['ID']) {
        $get_prd = GetCatalogProduct($arFields["ID"]);
        $get_prd_price = GetCatalogProductPriceList($get_prd["ID"]);
        $variant[] = array(
            'id' => $arFields['ID'],
            'name' => $arFields['NAME'],
            'url' => $arFields['DETAIL_PAGE_URL'],
            'price' => number_format($get_prd_price["0"]["PRICE"], 0, ',', ' ') . ' руб.'
        );
    };
}

$arResult['VARIANTS'] = $variant;


if(count($arResult['LINKED_ELEMENTS'])>0) {

    $arLinkedEls = $arResult['LINKED_ELEMENTS'];
    foreach ($arLinkedEls as $arLinkedEl){
        $arLinkedElIds[]= $arLinkedEl['ID'];
    }
    $arFilter = Array("ID" => $arLinkedElIds, "ACTIVE" => "Y");
    $dbItems = CIBlockElement::GetList(Array("PREVIEW_TEXT"=>"ASC"), $arFilter);
    while ($arItem = $dbItems->GetNext()) {
        $banner[]=$arItem['PREVIEW_TEXT'];
    }
}

$arResult['BANNER'] = $banner;

$cp = $this->__component;
if (is_object($cp)) {
    $cp->SetResultCacheKeys(array(
        "BY_WHITH",
        "SALE",
        "IMAGES",
        'VARIANTS',
        'BANNER'
    ));
}