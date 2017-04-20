<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Самсон: Производство детских площадок, картонных домиков и спортивно-игровых комплексов");
$APPLICATION->SetTitle("САМСОН - Производитель детских площадок, спортивных игровых комплексов. С нами надежно и безопасно!");
?> 
<div class="nc_list nc_text"> 
  <div class="nc_row"> 
    <div class="navigate"> 
      <p class="line_for_breadcrumbs"> 			
	  <span><a href="/" >Главная</a></span> 			<span> -&gt; </span> 			<span>Поиск</span> 		</p>
     <span> Поиск </span>
	 </div>
   
		<?$APPLICATION->IncludeComponent(
	"bitrix:search.page", 
	"search", 
	array(
		"RESTART" => "Y",
		"NO_WORD_LOGIC" => "N",
		"CHECK_DATES" => "Y",
		"USE_TITLE_RANK" => "Y",
		"DEFAULT_SORT" => "date",
		"FILTER_NAME" => "",
		"arrFILTER" => array(
			0 => "iblock_Catalogs",
		),
		"arrFILTER_iblock_Catalogs" => array(
			0 => "3",
		),
		"SHOW_WHERE" => "N",
		"SHOW_WHEN" => "N",
		"PAGE_RESULT_COUNT" => "10",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Результаты поиска",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"USE_LANGUAGE_GUESS" => "Y",
		"TAGS_SORT" => "NAME",
		"TAGS_PAGE_ELEMENTS" => "150",
		"TAGS_PERIOD" => "30",
		"TAGS_URL_SEARCH" => "/search/index.php",
		"TAGS_INHERIT" => "Y",
		"FONT_MAX" => "50",
		"FONT_MIN" => "10",
		"COLOR_NEW" => "000000",
		"COLOR_OLD" => "C8C8C8",
		"PERIOD_NEW_TAGS" => "",
		"SHOW_CHAIN" => "N",
		"COLOR_TYPE" => "Y",
		"WIDTH" => "100%",
		"USE_SUGGEST" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "search"
	),
	false
);?> 
  
  </div>
 </div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>