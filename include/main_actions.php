<div class="main-menu"> <a href="/akcii/" class="red" > Акции
    <br />
  и скидки! <img src="<?= SITE_TEMPLATE_PATH ?>/img/main_menu_icon1.png" alt="Акции и скидки!"  /> </a> <a href="/Netshop/video/" class="green" > Смотреть
    <br />
  видео <img src="<?= SITE_TEMPLATE_PATH ?>/img/main_menu_icon2.png" alt="Смотреть видео"  /> </a> <a href="/derevostreet/tasmaniya2017.html" class="blue" > Лидер
    <br />
  продаж <img src="<?= SITE_TEMPLATE_PATH ?>/img/main_menu_icon3.png" alt="Лидер продаж"  /> </a> <a href="/Netshop/galery/" class="orange" > Фото
    <br />
  галерея <img src="<?= SITE_TEMPLATE_PATH ?>/img/main_menu_icon4.png" alt="Фото галерея"  /> </a> </div>
 
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"slider_top_product",
	Array(
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "Catalogs",
		"IBLOCK_ID" => "3",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(),
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"ADD_SECTIONS_CHAIN" => "N",
		"DISPLAY_COMPARE" => "N",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"PAGE_ELEMENT_COUNT" => "",
		"LINE_ELEMENT_COUNT" => "",
		"PROPERTY_CODE" => array("POPULAR"),
		"OFFERS_LIMIT" => "5",
		"PRICE_CODE" => array("roznica"),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "N",
		"PRODUCT_PROPERTIES" => array(),
		"USE_PRODUCT_QUANTITY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"CONVERT_CURRENCY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N"
	),
false,
Array(
	'HIDE_ICONS' => 'Y'
)
);?>