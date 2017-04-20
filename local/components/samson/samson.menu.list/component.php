<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!isset($arParams["CACHE_TIME"])) {
    $arParams["CACHE_TIME"] = 3600;
}

if ($arParams["IBLOCK_ID"] < 1) {
    ShowError("IBLOCK_ID IS NOT DEFINED");
    return false;
}
if (!CModule::IncludeModule("iblock")) {
    ShowError("IBLOCK_MODULE_NOT_INSTALLED");
    return false;
}

if ($this->startResultCache($arParams["CACHE_TIME"])) {
    $rsParentSection = CIBlockSection::GetByID($arParams["SECTION_ID"]);
    if ($arParentSection = $rsParentSection->GetNext()) {
        $arSelect = Array("ID", "NAME", "CODE", 'DEPTH_LEVEL','UF_NO_USE_ELEMENTS');
        $arFilter = array(
            'IBLOCK_ID' => $arParentSection['IBLOCK_ID'],
            '>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],
            '<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],
            '>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL'],
            "ACTIVE" => "Y"
        );
        // выберет потомков
        $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'), $arFilter, false, $arSelect, false);
        while ($arSect = $rsSect->GetNext()) {
            //прямо в циле получим список элементов раздела для формирования ссылки
            unset($element_code, $MenuLink, $novinka,$aciya);
            $arSelect = Array("ID", "NAME", "CODE", 'PROPERTY_NOVINKA','PROPERTY_ACIYA','DETAIL_PAGE_URL');
            $arFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "SECTION_ID" => $arSect["ID"],
                "ACTIVE_DATE" => "Y",
                "ACTIVE" => "Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while ($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                //если $arSect['UF_NO_USE_ELEMENTS'] то
                if ($arSect['UF_NO_USE_ELEMENTS']) {
                    //формируем ссылку для меню с подраздела
                   $MenuLink = $arParams['LINK'] . $arSect['CODE'] . '/';
                }
                else {
                    //ссылка только с последнего из элемнтов подраздела!
                    $element_code = $arFields['DETAIL_PAGE_URL'];
                    //формируем ссылку для меню с последнего элемента
                    if (!empty($element_code)) $MenuLink = $element_code;
                }

                //если в разделе найден товар с новинкой, то весь раздел будет новинкой!
                if ($arFields['PROPERTY_NOVINKA_VALUE']) $novinka = true;
                if ($arFields['PROPERTY_ACIYA_VALUE']) $aciya = true;
            }

            //формирование ссылок меню
            $arResult[] = array(
                'NAME' => $arSect['NAME'],
                'LINK' => $MenuLink,
                'DOP' => "/" . $arSect['CODE'] . "/", //доп. ссылка или массив ссылок для подсветки меню
                'DEPTH_LEVEL' => $arSect['DEPTH_LEVEL'],//уровень вложенност
                'IS_PARENT' => 'N', //является ли родителем
                'NOVINKA' => $novinka, // параметр меню Новинка,
                'ACIYA' =>$aciya // параметр меню Акция,
            );
        }
    }

    $this->endResultCache();
}
    $aMenuLinksNew = array();
    $menuIndex = 0;
    $previousDepthLevel = 1;
    foreach ($arResult as $arSection) {
        if ($menuIndex > 0)
            $aMenuLinksNew[$menuIndex - 1][3]["IS_PARENT"] = $arSection["DEPTH_LEVEL"] > $previousDepthLevel;
        $previousDepthLevel = $arSection["DEPTH_LEVEL"];

        $aMenuLinksNew[$menuIndex++] = array(
            $arSection["NAME"],
            $arSection["LINK"],
            $arSection["DOP"],
            array(
                "FROM_IBLOCK" => true,
                "IS_PARENT" => false,
               "DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"]-1,
                "NOVINKA"=>$arSection['NOVINKA'],
                "ACIYA"=>$arSection['ACIYA']
            ),
        );
    }


    return $aMenuLinksNew
        ;?>
