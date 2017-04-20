<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Товары для сада и дачи");
?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"sams_2017", 
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
		"COMPONENT_TEMPLATE" => "sams_2017",
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
		"SECTION_ID" => "109",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "UF_LINKED",
			1 => "",
		),
		"SEF_MODE" => "N",
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
);?>
    <p>Добро пожаловать на сайт!</p>

    <div>
      <p>Уважаемые Клиенты и Партнеры, мы рады приветствовать Вас на нашем сайте! В данном разделе каталога мы предлагаем малые архитектурные формы для сада и дачи (МАФ) от компании &quot;Самсон&quot;.</p>

      <p>Малые архитектурные формы (МАФ) &mdash; в ландшафтной архитектуре и садово-парковом искусстве: вспомогательные архитектурные сооружения, оборудование и художественно-декоративные элементы, обладающие собственными простыми функциями и дополняющие общую композицию архитектурного ансамбля застройки.</p>

      <p>Садовые лавки, скамейки, вазоны, перголы, столы, ограждения и элементы детской игровой площадки, песочницы, рукоходы, балансиры являются важной частью ландшафтного дизайна дачи, создают уют и законченность.&nbsp;
        <br />
       </p>

      <div>
        <p>В компании &quot;Самсон&quot; вы можете приобрести малые архитектурные формы в цвете детской площадки. Каждый товар раздела представлен в двух вариантах цвета.</p>

        <p>Отметим основные достоинства продукции производственной компании &laquo;Самсон&raquo;:
          <br />
         </p>
       </div>

      <ul>
        <li>натуральность - материалом для изготовления МАФ<strong>&nbsp;</strong>служит качественная северная древесина, которая является экологичной, долговечной и действительно красивой;</li>

        <li>надёжность - конструкция не расшатывается и не изменяет линейные размеры, все крепления прочны и закрыты декоративными элементами при необходимости;</li>

        <li>долговечное покрытие - состав&nbsp;системы грунт-лак&nbsp;выполняет одновременно защитную&nbsp;и эстетическую функции, сохраняет свои эксплуатационные характеристики на протяжении 5 -7 лет (гарантия производителя), отлично противостоит негативным воздействиям окружающей среды - влаге, палящим солнечным лучам, перепаду температур;</li>

        <li>простота монтажа - вы сможете самостоятельно установить все конструкции на своей территории, процесс не требует привлечения опытных специалистов, все элементы максимально подготовлены к монтажу, есть инструкция по сборке;</li>

        <li>разнообразие моделей - вы сможете подобрать модели, которые соответствуют вашим требованиям и материальным возможностям. </li>
       </ul>

      <p>Выбрать тот или иной вариант Вы можете, изучив представленные в нашей галерее фото. Уточнить условия сотрудничества и получить консультацию наших специалистов можно в телефонном режиме прямо сейчас. Звоните: <span __postbox-detected-content="__postbox-detected-date">+7</span> (985) 769-00-12.</p>
    </div>

    <p></p>

    <div style="text-align: justify; background-color: rgb(255, 255, 255); clear: both;"></div>

    <p></p>
   </div>
 </div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>