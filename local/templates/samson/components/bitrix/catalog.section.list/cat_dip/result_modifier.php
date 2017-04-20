<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["SECTIONS"] as &$arSection) {
            //прямо в циле получим список элементов раздела для формирования ссылки
            unset($element_code, $MenuLink, $novinka,$aciya,$picture,$name,$element);
            $arSelect = Array("ID", "NAME", "CODE", 'PROPERTY_NOVINKA','PROPERTY_ACIYA','DETAIL_PICTURE');
            $arFilter = Array("IBLOCK_ID" => $arSection["IBLOCK_ID"],
                "SECTION_ID" => $arSection["ID"],
                "ACTIVE_DATE" => "Y",
                "ACTIVE" => "Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while ($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                //если $arSect['UF_NO_USE_ELEMENTS'] то
                if ($arSection['PROPERTIES']['UF_NO_USE_ELEMENTS']) {
                    //формируем ссылку для меню с подраздела
                    $MenuLink = $arSection['SECTION_PAGE_URL'];
                }
                else {
                    //ссылки с элементов  подраздела!
                    $element_code = $arFields['CODE'];
                    //формируем ссылку для меню с последнего элемента
                    if (!empty($element_code)) $MenuLinkItem = $arSection['SECTION_PAGE_URL']  . $element_code . '.html';
                }

                //если в разделе найден товар с новинкой, то весь раздел будет новинкой!
                if ($arFields['PROPERTY_NOVINKA_VALUE']) $novinka = true;
                if ($arFields['PROPERTY_ACIYA_VALUE']) $aciya = true;

                //если нашли картинку раздела, то все ок
                if ($arSection['PICTURE']) {
                    $pictureSec = CFile::ResizeImageGet($arSection['PICTURE'], array('width' => 190, 'height' => 125), BX_RESIZE_IMAGE_EXACT);
                    $picture = $pictureSec['src'];
                    $MenuLink = $MenuLinkItem;
                }
                else {
                    //нет картинки раздела, беда
                    // посчитаем сколько элементов в разделе
                    $count = CIBlockSection::GetSectionElementsCount($arSection["ID"]);

                    if ($count == 1) {
                        $pictureFromItem = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width' => 190, 'height' => 125), BX_RESIZE_IMAGE_EXACT);
                        $picture = $pictureFromItem['src'];
                        $name = $arSection['NAME'];
 			$MenuLink = $MenuLinkItem;
                    }
                    if ($count > 1) {
                        $pictureFromItem = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width' => 190, 'height' => 125), BX_RESIZE_IMAGE_EXACT);
                        $picture = $pictureFromItem['src'];
                        if (!empty($element_code)) $MenuLinkItem = $arSection['SECTION_PAGE_URL']  . $element_code . '.html';
                        $MenuLink = $MenuLinkItem;
                        $element[] =  array(
                            'SECTION_PAGE_URL' => $MenuLink,
                            'PICTURE'=> $picture
                            );
                    }
                }
            }

    $sections[] =
                array(
                    "ID"=>$arSection['ID'],
                'NAME' => $arSection['NAME'],
                'SECTION_PAGE_URL' => $MenuLink,
                    'PICTURE'=> $picture,
                'DEPTH_LEVEL' => $arSection['DEPTH_LEVEL'],//уровень вложенност
                'NOVINKA' => $novinka, // Новинка,
                'ACIYA' =>$aciya, // Акция,
                    'ELEMENTS'=> $element
            );


    }
$arResult['NEW_SECTIONS'] = $sections;

$cp = $this->__component;
if (is_object($cp)) {
    $cp->SetResultCacheKeys(array(
        "NEW_SECTIONS",
    ));
}

