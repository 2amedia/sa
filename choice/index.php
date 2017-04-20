<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("color", "dsk_color");
$APPLICATION->SetTitle("Детские деревянные площадки, детский игровой городок, домики для дачи");
?>
<? $APPLICATION->IncludeComponent(
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
		"SECTION_ID" => "221",
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
); ?>

 <div style="clear: both;">&nbsp;
      <p>Уважаемые Клиенты и Партнеры, мы рады приветствовать Вас на нашем сайте! В данном разделе каталога мы предлагаем детские спортивно-игровые комплексы для дома и улицы. Наша продукция предназначена для детей от 4 до 9 лет, создает условия, обеспечивающие физическое развитие ребенка, развивает координацию движений, преодоление страха высоты, ловкость и смелость, чувство коллективизма в массовых играх. </p>

      <p class="p1">Наши менеджеры выборочно обзванивают клиентов, собирают аналитическую информацию с целью улучшения качества продукта и обслуживания.</p>

      <p class="p1">На вопрос: &quot;Почему <b>Вы выбрали</b> и приобрели среди предложенного на рынке многообразия <b>спортивные игровые комплексы Компании &quot;САМСОН&quot;</b> ? Наши покупатели отвечают: </p>

      <p class="p1">&quot;&hellip;Помогали собирать друзьям, и решили приобрести себе. <b>Надежный</b>, включает все, что необходимо. Такой, как в был детстве…&quot;</p>

      <p class="p2" style="text-align: right;">Марина, Кемерово.</p>

      <p class="p1">&quot;…Анализировали отзывы покупателей в интернете, многие рекомендуют &quot;САМСОН&quot; : <b>безопасный</b> - как Volvo, <b>прослужит дольше остальных</b> - как Duracell ;) Очень рады приобретению…&quot;</p>

      <p class="p2" style="text-align: right;">Иван, Зеленоград.</p>

      <p class="p1">&quot;…А мне попался забавный отзыв дедушки-ветерана из Москвы, пишет, что купил комплекс &quot;САМСОН&quot; по рекомендации врача-физиотерапевта для выполнения ежедневных упражнений, спустя три года пришлось подкрутить распорные регулировочные болты, обратился с просьбой в компанию, подъехали, подкрутили. Сервис на высоте. Восхитительно! Наслаждаемся покупкой…&quot;</p>

      <p class="p2" style="text-align: right;">Ирина, Тюмень.</p>

      <p class="p1">&quot;…У нас <b>довольны</b> приобретением <b>и взрослые, и дети</b>. Яркий, разноцветный (красно-сине-желтый), замечательно вписался в интерьер детской. Теперь сынуля с дедом качают пресс, подтягиваются. Дедушка учит внука по канату подниматься, пока получается не очень. Между занятиями комплекс тоже не простаивает, он превращает трапецию в качели…&quot;</p>

      <p class="p2" style="text-align: right;">Ольга, Нижний Тагил.</p>

      <p class="p1">&quot;…Купила через сайт совместных покупок, нравится! Сомневалась стоит ли брать, т.к. второму ребенку 2,5 года. Рекомендовали приобрести к комплексу доску для жима, и использовать ее как защитный экран. Старший сын после занятия укрепляет доску и в распоряжении младшего остаются всего несколько нижних ступеней. Я выбрала вариант САМСОН 22, пока вместо сетки установили качели для малыша. Еще он любит кольца, может весь день болтаться на них…&quot;</p>

      <p class="p2" style="text-align: right;">Наталья, Ногинск.</p>

      <p></p>

      <p>
        <br />
       </p>

      <p>&quot;Спортивно-игровые металлические комплексы для дома Самсон&quot;</p>

      <p>Для гармоничного развития ребенка важно, чтобы каждый малыш имел свой собственный индивидуальный уголок &ndash; место для учебы, игр, творчества, спортивных занятий. Спортивные игровые комплексы на металлической основе, которые разрабатывает и производит наша компания, помогут вам в решении вопроса обустройства детской комнаты. Предлагаемые нами конструкции не только яркие и красивые, но и полностью безопасны для детей. В производстве используются прочные <b>материалы высокого качества</b>, которые способны выдерживать вес даже взрослого человека. Яркость комплексов обеспечена современными порошковыми красками на полимерной основе, характеризующимися экологичностью и высокой износостойкостью.</p>

      <p>Основой любого спортивно-игрового комплекса является шведская стенка, которая крепится либо к стене, либо враспор между потолком и полом. В большом ассортименте представлены дополнительные элементы: веревочные лестницы и качели, кольца и трапеции, доски для жима и баскетбольные корзины, маты, канаты и прочее.</p>

      <p>Преимущество наших комплексов состоит в том, что вы можете спроектировать его конструкцию таким образом, чтобы были учтены размеры и планировка комнаты, потребности и предпочтения ребенка, ваше собственное понимание практичности, надежности и красоты. Спортивному комплексу для дома обрадуются не только дети. Родители тоже смогут получить удовольствие и пользу как от совместных игр со своим малышом, так и от возможности проявлять физическую активность не покидая родные стены.</p>

      <p>Перечисленное выше оборудование детских спортивных игровых комплексов Вы можете приобрести или заказать в любом количестве в нашей компании, у представителей в регионах. Купить детский спортивно игровой комплекс для дома можно, связавшись с нашими менеджерами, которые готовы проконсультировать и оказать помощь в комплектовании спортивно-игрового уголка. Мы уже добились уважения и доверия наших клиентов, но продолжаем внимательно следить за качеством продукции, ведь от него зависит здоровье и полноценно счастливое детство наших детей!</p>

<!--
      <div style="width: 100%;">
        <p style="font-size: 25px;"><font color="#2f3192">Фотогалерея:</font></p>
       		<a id="bxid_371859" style="text-decoration: none; " rel="lightbox" href="/upload/iblock/3e6/3e62f5b7cac493a2f5fe819cf6a0b0d6.jpg" class="lightbox-enabled" ><img id="bxid_693454" src="/upload/iblock/005/00508c265a491f89528f8b1ba6eb6074.jpg" height="107px"  /></a>
        <p><a id="bxid_270966" >смотреть в фото-галерее...</a></p>
      </div>
      -->
 </div>
   </div>
 </div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
