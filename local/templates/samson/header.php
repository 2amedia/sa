<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID ?>">
<head>
    <title><? $APPLICATION->ShowTitle() ?></title>
    <?
    //Тут мета-теги
    $APPLICATION->ShowMeta("robots", false, false);
    $APPLICATION->ShowMeta("keywords", false, false);
    $APPLICATION->ShowMeta("description", false, false);
    ?>

    <link href="/favicon.ico" rel="icon" type="image/x-icon">
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <meta name="viewport" content="width=1200">
    <?
    //Тут стили шаблона сайта
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/assets/bootstrap/css/bootstrap.css');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/assets/owl-carousel/owl.carousel.css');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/assets/owl-carousel/owl.theme.css');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/assets/magnific.popup/magnific-popup.css');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/assets/brazzers-carousel/jQuery.Brazzers-Carousel.css');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/colors.css');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/assets/css/font-awesome.css');
    $APPLICATION->SetAdditionalCSS (SITE_TEMPLATE_PATH . '/assets/jquery.bxslider.css');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/lending.css');
    //Тут выводим стили
    $APPLICATION->ShowCSS(true, false);?>

    <? CJSCore::Init();

    //Тут скрипты
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/assets/jquery/jquery-3.1.0.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/assets/bootstrap/js/bootstrap.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/assets/magnific.popup/magnific.popup.min.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/assets/owl-carousel/owl.carousel.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/assets/brazzers-carousel/jQuery.Brazzers-Carousel.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/assets/mask.js');
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/assets/jquery.bxslider.js');

    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/script.js');
    //Тут выводим скрипты
    $APPLICATION->ShowHeadStrings();
    $APPLICATION->ShowHeadScripts();
    ?>

</head>
<body>
<div id="panel">
    <? $APPLICATION->ShowPanel() ?>
</div>
<!--------------start header-------------->
<header>
    <div class="container">
        <div class="row">
            <!--logo start-->
            <div class="col-xs-3 col-md-3" id="logo">
                <a href="/"><img id="logo-img" style=" margin:0" src="/images/logo-2016.jpg" class="img-responsive"></a>
            </div>
            <!--logo end-->
            <!--info slogan start-->
            <div class="col-xs-6 col-md-6" id="info">
                <? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/slogan.php",
                    "EDIT_TEMPLATE" => ""
                ),
                    false
                ); ?>
            </div>
            <!--info logo end-->
            <div class="col-xs-3 col-md-3">
                <!--контакты начало-->
                <? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/cont.php",
                    "EDIT_TEMPLATE" => ""
                ),
                    false
                ); ?>
                <!--контакты конец-->
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row mb-20">
        <!--top menu start-->
        <div class="col-xs-9 col-md-9">
            <? $APPLICATION->IncludeComponent("bitrix:menu", "top", array(
                "ROOT_MENU_TYPE" => "top",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_TIME" => "36000",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => array(),
                "MAX_LEVEL" => "1",
                "CHILD_MENU_TYPE" => "left",
                "USE_EXT" => "N",
                "DELAY" => "N",
                "ALLOW_MULTI_SELECT" => "N"
            ),
                false
            ); ?>
        </div>
        <!--top menu end-->

        <!--    корзина-->
        <div class="col-xs-3 col-md-3">
            <? $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "small_basket", Array(
                "PATH_TO_BASKET" => "/personal/basket/",    // Страница корзины
                "PATH_TO_ORDER" => "/personal/order/",    // Страница оформления заказа
                'AJAX_MODE' => 'Y',
                'AJAX_OPTION_JUMP' => 'N',
                'AJAX_OPTION_HISTORY' => 'N',
                'SHOW_CART' => $_REQUEST['show_cart']
            ),
                false
            ); ?>
        </div>
        <!--    конец корзины-->
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-3">

            <div class="left_menu">
                <div class="caption"><a href="/"> Детские деревянные игровые площадки для дачи и дома</a></div>
                <!-- /.caption -->
                <div class="lev_one <?if (CSite::InDir('/derevostreet/')) echo 'uncollapsed'?>">
                    <div class="block_link">
                        <a href="/derevostreet/">
                            <span>САМСОН</span>
                            РОССИЯ, ПОКРЫТИЕ ЛАК/ГРУНТ,
                            БРУС/МАССИВ
                        </a>
                        <span class="toggle_element"></span>
                    </div>
                    <?//тут выводим подразделы с товарами?>
                    <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "left_menu_with_subsection", Array(
                            "IBLOCK_TYPE" => "Catalogs",	// Тип инфоблока
                            "IBLOCK_ID" => "3",	// Инфоблок
                            "SECTION_ID" => "2",	// ID раздела
                            "SECTION_CODE" => "",	// Код раздела
                            "SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
                            "COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
                            "TOP_DEPTH" => "3",	// Максимальная отображаемая глубина разделов
                            "SECTION_FIELDS" => "DETAIL_PICTURE",	// Поля разделов
                            "SECTION_USER_FIELDS" => "",	// Свойства разделов
                            "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
                            "CACHE_TYPE" => "N",	// Тип кеширования
                            "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                            "CACHE_GROUPS" => "N",	// Учитывать права доступа
                            "INCLUDE_SUBSECTIONS"=>'Y'
                        )
                        );?>
                </div>

              <?php /*?>  <div class="lev_one">
                    <div class="block_link">
                        <a >
                            <span>СИБИРИКА</span>
                            РОССИЯ, ПОКРЫТИЕ МАСЛО, БРУС/МАССИВ
                        </a>
                    </div>
                </div><?php */?>
                 <div class="lev_one <? if (CSite::InDir('/sibirika/')) echo 'uncollapsed' ?>">
                    <div class="block_link">
                        <a href="/sibirika/">
                            <span>СИБИРИКА</span>
                           РОССИЯ, ПОКРЫТИЕ МАСЛО, БРУС/МАССИВ
                        </a>
                        <span class="toggle_element"></span>
                    </div>
	                <? $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"sams_left_menu",
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket/",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "sams_left_menu",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"CUSTOM_FILTER" => "",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "asc",
		"ENLARGE_PRODUCT" => "STRICT",
		"ENLARGE_PROP" => "-",
		"FILE_404" => "",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "L",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "Catalogs",
		"INCLUDE_SUBSECTIONS" => "A",
		"LABEL_PROP" => "",
		"LABEL_PROP_MOBILE" => "",
		"LABEL_PROP_POSITION" => "top-left",
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "SKU_CHERT",
			1 => "SKU_DOP_PHOTO",
			2 => "SKU_POKR",
			3 => "SKU_COLOR",
			4 => "SKU_KOMPL",
			5 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "asc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => "",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "1000",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "roznica",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array(
			0 => "ACTION",
			1 => "DOST",
			2 => "NEW",
			3 => "ADD_PHOTO_IN_DETAIL",
			4 => "MORE_PHOTO",
			5 => "",
		),
		"PROPERTY_CODE_MOBILE" => "",
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_CODE_PATH" => "",
		"SECTION_ID" => "289",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "UF_LINKED",
			1 => "",
		),
		"SEF_MODE" => "Y",
		"SEF_RULE" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SHOW_ALL_WO_SECTION" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "Y",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y"
	),
	false
); ?>
                </div>

                <?php /*?><div class="lev_one">
                    <div class="block_link">
                        <a href="">
                            <span>ЭЛЕМЕНТ</span>
                            РОССИЯ, БЕЗ ПОКРЫТИЯ, БРУС/МАССИВ
                        </a>
                    </div>
                </div><?php */?><?php /*?>
                 <div class="lev_one <? if (CSite::InDir('/element/')) echo 'uncollapsed' ?>">
                    <div class="block_link">
                        <a href="/element/">
                            <span>ЭЛЕМЕНТ</span>
                            РОССИЯ, БЕЗ ПОКРЫТИЯ, БРУС/МАССИВ
                        </a>
                        <span class="toggle_element"></span>
                    </div>
	                <? $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"sams_left_menu",
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket/",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "sams_left_menu",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"CUSTOM_FILTER" => "",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "asc",
		"ENLARGE_PRODUCT" => "STRICT",
		"ENLARGE_PROP" => "-",
		"FILE_404" => "",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "L",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "Catalogs",
		"INCLUDE_SUBSECTIONS" => "A",
		"LABEL_PROP" => "",
		"LABEL_PROP_MOBILE" => "",
		"LABEL_PROP_POSITION" => "top-left",
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "SKU_CHERT",
			1 => "SKU_DOP_PHOTO",
			2 => "SKU_POKR",
			3 => "SKU_COLOR",
			4 => "SKU_KOMPL",
			5 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "asc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => "",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "1000",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "roznica",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array(
			0 => "ACTION",
			1 => "DOST",
			2 => "NEW",
			3 => "ADD_PHOTO_IN_DETAIL",
			4 => "MORE_PHOTO",
			5 => "",
		),
		"PROPERTY_CODE_MOBILE" => "",
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_CODE_PATH" => "",
		"SECTION_ID" => "290",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "UF_LINKED",
			1 => "",
		),
		"SEF_MODE" => "Y",
		"SEF_RULE" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SHOW_ALL_WO_SECTION" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "Y",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y"
	),
	false
); ?>
                </div><?php */?>

              <?php /*?>  <div class="lev_one">
                    <div class="block_link">
                        <a >
                            <span>BLUE RABBIT</span>
                            БЕЛЬГИЯ, ИМПРЕГНАЦИЯ, БРУС/МАССИВ
                        </a>
                    </div>
                </div><?php */?>

                <div class="lev_one <? if (CSite::InDir('/kiddyloft/')) echo 'uncollapsed' ?>">
                    <div class="block_link">
                        <a href="/kiddyloft/">
                            <span>ИГРОВАЯ КРОВАТЬ-ЧЕРДАК</span>
                            РОССИЯ, БЕЗ ПОКРЫТИЯ, МАССИВ
                        </a>
                        <span class="toggle_element"></span>
                    </div>
	                <? //тут выводим подразделы с товарами?>
	                <? $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "left_menu_with_subsection", Array(
		                "IBLOCK_TYPE" => "Catalogs",
		                // Тип инфоблока
		                "IBLOCK_ID" => "3",
		                // Инфоблок
		                "SECTION_ID" => "238",
		                // ID раздела
		                "SECTION_CODE" => "",
		                // Код раздела
		                "SECTION_URL" => "",
		                // URL, ведущий на страницу с содержимым раздела
		                "COUNT_ELEMENTS" => "N",
		                // Показывать количество элементов в разделе
		                "TOP_DEPTH" => "3",
		                // Максимальная отображаемая глубина разделов
		                "SECTION_FIELDS" => "DETAIL_PICTURE",
		                // Поля разделов
		                "SECTION_USER_FIELDS" => "",
		                // Свойства разделов
		                "ADD_SECTIONS_CHAIN" => "N",
		                // Включать раздел в цепочку навигации
		                "CACHE_TYPE" => "N",
		                // Тип кеширования
		                "CACHE_TIME" => "36000000",
		                // Время кеширования (сек.)
		                "CACHE_GROUPS" => "N",
		                // Учитывать права доступа
		                "INCLUDE_SUBSECTIONS" => 'Y'
	                )); ?>
                </div>

                <div class="lev_one <? if (CSite::InDir('/dop/')) echo 'uncollapsed' ?>">
                    <div class="block_link">
                        <a href="/dop/">
                            <span>АКСЕССУАРЫ</span>
                            РОССИЯ, БЕЛЬГИЯ КБТ
                        </a>
                        <span class="toggle_element"></span>
                    </div>
                    <?//тут выводим подразделы с товарами?>
                    <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "left_menu_with_subsection", Array(
                            "IBLOCK_TYPE" => "Catalogs",	// Тип инфоблока
                            "IBLOCK_ID" => "3",	// Инфоблок
                            "SECTION_ID" => "3",	// ID раздела
                            "SECTION_CODE" => "",	// Код раздела
                            "SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
                            "COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
                            "TOP_DEPTH" => "3",	// Максимальная отображаемая глубина разделов
                            "SECTION_FIELDS" => "DETAIL_PICTURE",	// Поля разделов
                            "SECTION_USER_FIELDS" => "",	// Свойства разделов
                            "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
                            "CACHE_TYPE" => "N",	// Тип кеширования
                            "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                            "CACHE_GROUPS" => "N",	// Учитывать права доступа
                            "INCLUDE_SUBSECTIONS"=>'Y'
                        )
                        );?>
	                <?php /*?><? $APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"sams_left_menu", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket/",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "sams_left_menu",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"CUSTOM_FILTER" => "",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "name",
		"ELEMENT_SORT_FIELD2" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "asc",
		"ENLARGE_PRODUCT" => "STRICT",
		"ENLARGE_PROP" => "-",
		"FILE_404" => "",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "L",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "Catalogs",
		"INCLUDE_SUBSECTIONS" => "A",
		"LABEL_PROP" => "",
		"LABEL_PROP_MOBILE" => "",
		"LABEL_PROP_POSITION" => "top-left",
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "SKU_CHERT",
			1 => "SKU_DOP_PHOTO",
			2 => "SKU_POKR",
			3 => "SKU_COLOR",
			4 => "SKU_KOMPL",
			5 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "asc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => "",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "1000",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "roznica",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array(
			0 => "ACTION",
			1 => "DOST",
			2 => "NEW",
			3 => "ADD_PHOTO_IN_DETAIL",
			4 => "MORE_PHOTO",
			5 => "",
		),
		"PROPERTY_CODE_MOBILE" => "",
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_CODE_PATH" => "",
		"SECTION_ID" => "3",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "UF_LINKED",
			1 => "",
		),
		"SEF_MODE" => "Y",
		"SEF_RULE" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SHOW_ALL_WO_SECTION" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "Y",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y"
	),
	false
); ?><?php */?>
                </div>

                <div class="lev_one <? if (CSite::InDir('/zima/')) echo 'uncollapsed' ?>">
                    <div class="block_link">
                        <a href="/zima/">
                            <span>ЗИМНИЕ ГОРКИ</span>
                            РОССИЯ, БЕЗ ПОКРЫТИЯ/ЛАК/МАСЛО, БРУС/МАССИВ
                        </a>
                        <span class="toggle_element"></span>
                    </div>
	                <? //тут выводим подразделы с товарами?>
	                <? $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "left_menu_with_subsection", Array(
		                "IBLOCK_TYPE" => "Catalogs",
		                // Тип инфоблока
		                "IBLOCK_ID" => "3",
		                // Инфоблок
		                "SECTION_ID" => "6",
		                // ID раздела
		                "SECTION_CODE" => "",
		                // Код раздела
		                "SECTION_URL" => "",
		                // URL, ведущий на страницу с содержимым раздела
		                "COUNT_ELEMENTS" => "N",
		                // Показывать количество элементов в разделе
		                "TOP_DEPTH" => "3",
		                // Максимальная отображаемая глубина разделов
		                "SECTION_FIELDS" => "DETAIL_PICTURE",
		                // Поля разделов
		                "SECTION_USER_FIELDS" => "",
		                // Свойства разделов
		                "ADD_SECTIONS_CHAIN" => "N",
		                // Включать раздел в цепочку навигации
		                "CACHE_TYPE" => "N",
		                // Тип кеширования
		                "CACHE_TIME" => "36000000",
		                // Время кеширования (сек.)
		                "CACHE_GROUPS" => "N",
		                // Учитывать права доступа
		                "INCLUDE_SUBSECTIONS" => 'Y'
	                )); ?>
                </div>

                <div class="lev_one <? if (CSite::InDir('/sad/')) echo 'uncollapsed' ?>">
                    <div class="block_link">
                        <a href="/sad/">
                            <span>САДОВАЯ МЕБЕЛЬ</span>
                            РОССИЯ, ПОКРЫТИЕ ЛАК/ГРУНТ,
                            БРУС/МАССИВ
                        </a>
                        <span class="toggle_element"></span>
                    </div>
	                <? $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"sams_left_menu",
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket/",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "sams_left_menu",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"CUSTOM_FILTER" => "",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "shows",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "asc",
		"ENLARGE_PRODUCT" => "STRICT",
		"ENLARGE_PROP" => "-",
		"FILE_404" => "",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "L",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "Catalogs",
		"INCLUDE_SUBSECTIONS" => "N",
		"LABEL_PROP" => "",
		"LABEL_PROP_MOBILE" => "",
		"LABEL_PROP_POSITION" => "top-left",
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "SKU_CHERT",
			1 => "SKU_DOP_PHOTO",
			2 => "SKU_POKR",
			3 => "SKU_COLOR",
			4 => "SKU_KOMPL",
			5 => "",
		),
		"OFFERS_SORT_FIELD" => "shows",
		"OFFERS_SORT_FIELD2" => "shows",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "asc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => "",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "1000",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "roznica",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array(
			0 => "ACTION",
			1 => "DOST",
			2 => "NEW",
			3 => "ADD_PHOTO_IN_DETAIL",
			4 => "MORE_PHOTO",
			5 => "",
		),
		"PROPERTY_CODE_MOBILE" => "",
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_CODE_PATH" => "",
		"SECTION_ID" => "109",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "UF_LINKED",
			1 => "",
		),
		"SEF_MODE" => "Y",
		"SEF_RULE" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SHOW_ALL_WO_SECTION" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "Y",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y"
	),
	false
); ?>
                </div>


                <div class="lev_one <? if (CSite::InDir('/choice/')) echo 'uncollapsed' ?>">
                    <div class="caption"><a href="/choice/">Детские металлические спортивно-игровые комплексы для дома и
                            улицы
                            (ДСК, УДСК)</a>
                    </div>
	                <? if (CSite::InDir ('/choice/')){?>
			        <? //тут выводим подразделы с товарами?>
			        <? $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "left_menu_with_subsection", Array(
				        "IBLOCK_TYPE" => "Catalogs",
				        // Тип инфоблока
				        "IBLOCK_ID" => "3",
				        // Инфоблок
				        "SECTION_ID" => "221",
				        // ID раздела
				        "SECTION_CODE" => "",
				        // Код раздела
				        "SECTION_URL" => "",
				        // URL, ведущий на страницу с содержимым раздела
				        "COUNT_ELEMENTS" => "N",
				        // Показывать количество элементов в разделе
				        "TOP_DEPTH" => "3",
				        // Максимальная отображаемая глубина разделов
				        "SECTION_FIELDS" => "DETAIL_PICTURE",
				        // Поля разделов
				        "SECTION_USER_FIELDS" => "",
				        // Свойства разделов
				        "ADD_SECTIONS_CHAIN" => "N",
				        // Включать раздел в цепочку навигации
				        "CACHE_TYPE" => "N",
				        // Тип кеширования
				        "CACHE_TIME" => "36000000",
				        // Время кеширования (сек.)
				        "CACHE_GROUPS" => "N",
				        // Учитывать права доступа
				        "INCLUDE_SUBSECTIONS" => 'Y'
			        )); ?>
                    <?}?>
                </div>
                <div class="lev_one <? if (CSite::InDir ('/cube/')) echo 'uncollapsed' ?>">
                    <div class="caption"><a href="/cube/">Садовый КУБ Самсон</a>
                    </div>
		            <? if (CSite::InDir ('/cube/'))
		            { ?>
			            <? //тут выводим подразделы с товарами?>
			            <? $APPLICATION->IncludeComponent ("bitrix:catalog.section", "sams_left_menu", array(
				            "ACTION_VARIABLE" => "action",
				            "ADD_PICT_PROP" => "-",
				            "ADD_PROPERTIES_TO_BASKET" => "Y",
				            "ADD_SECTIONS_CHAIN" => "N",
				            "ADD_TO_BASKET_ACTION" => "ADD",
				            "AJAX_MODE" => "N",
				            "AJAX_OPTION_ADDITIONAL" => "",
				            "AJAX_OPTION_HISTORY" => "N",
				            "AJAX_OPTION_JUMP" => "N",
				            "AJAX_OPTION_STYLE" => "Y",
				            "BACKGROUND_IMAGE" => "-",
				            "BASKET_URL" => "/personal/basket/",
				            "BROWSER_TITLE" => "-",
				            "CACHE_FILTER" => "N",
				            "CACHE_GROUPS" => "Y",
				            "CACHE_TIME" => "36000000",
				            "CACHE_TYPE" => "A",
				            "COMPATIBLE_MODE" => "Y",
				            "COMPONENT_TEMPLATE" => "sams_left_menu",
				            "CONVERT_CURRENCY" => "Y",
				            "CURRENCY_ID" => "RUB",
				            "CUSTOM_FILTER" => "",
				            "DETAIL_URL" => "",
				            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
				            "DISCOUNT_PERCENT_POSITION" => "bottom-right",
				            "DISPLAY_BOTTOM_PAGER" => "Y",
				            "DISPLAY_TOP_PAGER" => "N",
				            "ELEMENT_SORT_FIELD" => "name",
				            "ELEMENT_SORT_FIELD2" => "shows",
				            "ELEMENT_SORT_ORDER" => "asc",
				            "ELEMENT_SORT_ORDER2" => "asc",
				            "ENLARGE_PRODUCT" => "STRICT",
				            "ENLARGE_PROP" => "-",
				            "FILE_404" => "",
				            "FILTER_NAME" => "arrFilter",
				            "HIDE_NOT_AVAILABLE" => "L",
				            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
				            "IBLOCK_ID" => "3",
				            "IBLOCK_TYPE" => "Catalogs",
				            "INCLUDE_SUBSECTIONS" => "N",
				            "LABEL_PROP" => "",
				            "LABEL_PROP_MOBILE" => "",
				            "LABEL_PROP_POSITION" => "top-left",
				            "LAZY_LOAD" => "N",
				            "LINE_ELEMENT_COUNT" => "3",
				            "LOAD_ON_SCROLL" => "N",
				            "MESSAGE_404" => "",
				            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
				            "MESS_BTN_BUY" => "Купить",
				            "MESS_BTN_DETAIL" => "Подробнее",
				            "MESS_BTN_SUBSCRIBE" => "Подписаться",
				            "MESS_NOT_AVAILABLE" => "Нет в наличии",
				            "META_DESCRIPTION" => "-",
				            "META_KEYWORDS" => "-",
				            "OFFERS_CART_PROPERTIES" => array(),
				            "OFFERS_FIELD_CODE" => array(
					            0 => "",
					            1 => "",
				            ),
				            "OFFERS_LIMIT" => "0",
				            "OFFERS_PROPERTY_CODE" => array(
					            0 => "SKU_CHERT",
					            1 => "SKU_DOP_PHOTO",
					            2 => "SKU_POKR",
					            3 => "SKU_COLOR",
					            4 => "SKU_KOMPL",
					            5 => "",
				            ),
				            "OFFERS_SORT_FIELD" => "shows",
				            "OFFERS_SORT_FIELD2" => "shows",
				            "OFFERS_SORT_ORDER" => "asc",
				            "OFFERS_SORT_ORDER2" => "asc",
				            "OFFER_ADD_PICT_PROP" => "-",
				            "OFFER_TREE_PROPS" => "",
				            "PAGER_BASE_LINK_ENABLE" => "N",
				            "PAGER_DESC_NUMBERING" => "N",
				            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				            "PAGER_SHOW_ALL" => "N",
				            "PAGER_SHOW_ALWAYS" => "N",
				            "PAGER_TEMPLATE" => ".default",
				            "PAGER_TITLE" => "Товары",
				            "PAGE_ELEMENT_COUNT" => "1000",
				            "PARTIAL_PRODUCT_PROPERTIES" => "N",
				            "PRICE_CODE" => array(
					            0 => "roznica",
				            ),
				            "PRICE_VAT_INCLUDE" => "Y",
				            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
				            "PRODUCT_DISPLAY_MODE" => "Y",
				            "PRODUCT_ID_VARIABLE" => "id",
				            "PRODUCT_PROPERTIES" => array(),
				            "PRODUCT_PROPS_VARIABLE" => "prop",
				            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
				            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
				            "PRODUCT_SUBSCRIPTION" => "Y",
				            "PROPERTY_CODE" => array(
					            0 => "ACTION",
					            1 => "DOST",
					            2 => "NEW",
					            3 => "ADD_PHOTO_IN_DETAIL",
					            4 => "MORE_PHOTO",
					            5 => "",
				            ),
				            "PROPERTY_CODE_MOBILE" => "",
				            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
				            "RCM_TYPE" => "personal",
				            "SECTION_CODE" => "",
				            "SECTION_CODE_PATH" => "",
				            "SECTION_ID" => "222",
				            "SECTION_ID_VARIABLE" => "SECTION_ID",
				            "SECTION_URL" => "",
				            "SECTION_USER_FIELDS" => array(
					            0 => "UF_LINKED",
					            1 => "",
				            ),
				            "SEF_MODE" => "Y",
				            "SEF_RULE" => "",
				            "SET_BROWSER_TITLE" => "Y",
				            "SET_LAST_MODIFIED" => "N",
				            "SET_META_DESCRIPTION" => "Y",
				            "SET_META_KEYWORDS" => "Y",
				            "SET_STATUS_404" => "Y",
				            "SET_TITLE" => "Y",
				            "SHOW_404" => "Y",
				            "SHOW_ALL_WO_SECTION" => "N",
				            "SHOW_CLOSE_POPUP" => "N",
				            "SHOW_DISCOUNT_PERCENT" => "Y",
				            "SHOW_FROM_SECTION" => "N",
				            "SHOW_MAX_QUANTITY" => "N",
				            "SHOW_OLD_PRICE" => "Y",
				            "SHOW_PRICE_COUNT" => "1",
				            "SHOW_SLIDER" => "Y",
				            "SLIDER_INTERVAL" => "3000",
				            "SLIDER_PROGRESS" => "Y",
				            "TEMPLATE_THEME" => "blue",
				            "USE_ENHANCED_ECOMMERCE" => "N",
				            "USE_MAIN_ELEMENT_SECTION" => "N",
				            "USE_PRICE_COUNT" => "N",
				            "USE_PRODUCT_QUANTITY" => "Y"
			            ), false); ?>
		            <? } ?>
                </div>
            </div>

            <div id="search_block">
	            <? $APPLICATION->IncludeComponent ("bitrix:search.form", "samson_search", Array(
		            "USE_SUGGEST" => "N",
		            // Показывать подсказку с поисковыми фразами
		            "PAGE" => "#SITE_DIR#search/index.php",
		            // Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
	            ), false); ?>
            </div>
            <!-- /#search_block -->
	        <? $APPLICATION->IncludeComponent(
	"bitrix:menu",
	"left_2017",
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "inner",
		"COMPONENT_TEMPLATE" => "left_2017",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "N",
		"ROOT_MENU_TYPE" => "left",
		"USE_EXT" => "Y"
	),
	false
); ?>



            <!--news start-->
            <? $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"left_news", 
	array(
		"IBLOCK_TYPE" => "Dop",
		"IBLOCK_ID" => "2",
		"NEWS_COUNT" => "3",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "360000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "left_news",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
); ?><a style="	color: #999; padding-left:75px" href="/news/">Все новости</a><br>
												<br>
            <!-- news end-->

            <div id="contakts">
                <? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/cont_left.php",
                    "EDIT_TEMPLATE" => ""
                ),
                    false
                ); ?>
            </div>
        </div>

        <!--left menu end-->

        <div class="col-xs-9 <?=$APPLICATION->GetProperty('color')?>" id="work">

            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "sect",
                    "AREA_FILE_SUFFIX" => "inc_header",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => ""
                )
            );?>

            <? $APPLICATION->ShowNavChain(); ?>
            <!-------------end header-------------->
