<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Детские домики и площадки для парков и дворов. Серия \"Хижина\"");
$APPLICATION->SetTitle('Детские домики и площадки для парков и дворов. Серия "Хижина"');
?> <?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?> 
<div class="nc_list nc_text"> 	 
  <div class="nc_row"> 		 
    <div class="navigate">
    	
    	<p class="line_for_breadcrumbs">
			<span><a href="/">Главная</a></span>
			<span> -> </span>
			<span><a href="/Netshop/domikiiploschadki/">Домики и площадки для парков и дворов</a></span>
			<span> -> </span>
			<span>Хижина</span>
		</p>
    	
    	<span style="color: rgb(128, 64, 0); ">Серия &quot;Хижина&quot;. Детские домики и площадки для парков и дворов.</span></div>
   <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"domikiiploschadki",
	Array(
		"IBLOCK_TYPE" => "Catalogs",
		"IBLOCK_ID" => "3",
		"SECTION_ID" => "48",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(0=>"",1=>"",),
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "N",
		"PAGE_ELEMENT_COUNT" => "30",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(0=>"",1=>"",),
		"SECTION_URL" => "#SITE_DIR#/Netshop/domikiiploschadki/shack/",
		"DETAIL_URL" => "#SITE_DIR#/Netshop/domikiiploschadki/shack/#CODE#.html",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"ADD_SECTIONS_CHAIN" => "N",
		"DISPLAY_COMPARE" => "N",
		"SET_TITLE" => "Y",
		"SET_STATUS_404" => "N",
		"CACHE_FILTER" => "N",
		"PRICE_CODE" => array(),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_PROPERTIES" => array(),
		"USE_PRODUCT_QUANTITY" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"AJAX_OPTION_ADDITIONAL" => ""
	)
);?> 	</div>
 </div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>