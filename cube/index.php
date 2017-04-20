<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Товары для сада и дачи");
?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"sams_2017",
	Array(
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
		"COMPATIBLE_MODE" => "N",
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
		"OFFERS_CART_PROPERTIES" => array(),
		"OFFERS_FIELD_CODE" => array(0=>"PREVIEW_PICTURE",1=>"DETAIL_PICTURE",2=>"",),
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => array(0=>"SKU_CHERT",1=>"SKU_DOP_PHOTO",2=>"SKU_POKR",3=>"SKU_COLOR",4=>"SKU_KOMPL",5=>"",),
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
		"PRICE_CODE" => array(0=>"roznica",),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array(0=>"ACTION",1=>"DOST",2=>"NEW",3=>"ADD_PHOTO_IN_DETAIL",4=>"MORE_PHOTO",5=>"",),
		"PROPERTY_CODE_MOBILE" => "",
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_CODE_PATH" => "",
		"SECTION_ID" => "222",
		"SECTION_ID_VARIABLE" => "",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(0=>"UF_LINKED",1=>"",),
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
	)
);?>
<p style="clear: both;">
	&nbsp;&nbsp;
</p>
<p>
	Добро пожаловать на сайт!
</p>
<div>
	<p>
		Уважаемые Клиенты и Партнеры, мы рады приветствовать Вас на нашем сайте! В данном разделе каталога мы предлагаем архитектурное направление 2016 года от компании Самсон - Садовый КУБ.
	</p>
	<p>
		Легкая и простая конструкция в современном стиле, в основу которой положена идея “единения с природой”. Линейное пространство, естественный свет и натуральные текстуры делают КУБ уютным и удобным.
	</p>
	<p>
		<img width="846" alt="Куб_Баннер5.jpg" src="/upload/medialibrary/f06/f06aa958b52da2d536b5e8d3ada586a4.jpg" title="Куб_Баннер5.jpg" border="0"> <br>
	</p>
	<p>
		<b>Что представляет собой КУБ? </b>
	</p>
	<p>
		КУБ - собственное пространство за пределами Вашего дома.
	</p>
	<p>
		<b>Что входит в стоимость КУБа? </b>
	</p>
	<p>
		Легковозводимый сборно-разборный <span style="font-weight: 700; font-style: normal;">каркас</span> с клееного бруса лиственницы (120х120мм, 120х85мм, 85х85мм) ,<span style="font-weight: 700; font-style: normal;"> обшитый внутри и снаружи</span> профилированным планкеном из массива лиственницы. Использованы оконные технологии защиты древесины - грунт и лак. Конструкция устанавливается на подготовленный Клиентом фундамент (винтовые сваи, регулируемые опоры и тп).
	</p>
	<p>
		Изюминкой КУБа является система раздвижного безрамного <span style="font-weight: 700; font-style: normal;">панорамного остекления</span> испанской марки Todo Cristal, которая позволяет создать плавный переход из помещения на террасу и в сад. Стекла выполнены из закаленного триплекса (10мм). В системе не используются подшипники, стекла скользят по нижнему алюминиевому профилю. Дверь оснащена замком.
	</p>
	<p>
		<b>Кровля</b> КУБа мягкая, водонепроницаемая, устойчива к температурным перепадам, легкая в монтаже.&nbsp;
	</p>
	<p>
		При желании <b>можно дополнительно </b><b>установить&nbsp;</b>водосточную систему, в<b>нешнее освещение</b> - два уличных светильника,&nbsp;<b>внутреннее освещение</b> - управляемый с планшета/смартфона светом Philips Hue (три лампы, Акция!) и встроенную аудиосистему (две потолочные колонки), также электрощит&nbsp;в нишу КУБа, вывести две розетки на 220 В, тумблер включения/выключения света, с<b>истему приточной вентиляции</b> - Бризер Тион О2 - умный микроклимат, компактный бризер позволяет проветривать комнату при закрытых окнах, подавая в дом очищенный, насыщенный кислородом воздух, приток воздуха со скоростью 120 м3/ч, очистка воздуха по медстандарту, подогрев воздуха с климат-контролем.
	</p>
	<p>
		<span><b>Как использовать КУБ?</b> <br>
 </span>
	</p>
	<p>
		КУБ - открывает широкие возможности по созданию уникального индивидуального интерьера для Вас.
	</p>
	<p>
		Игровой КУБ - Королевство фантазий! Позвольте ребенку оформить КУБ. Созданное им пространство станет местом творчества для юного исследователя, местом приема маленьких гостей. Родители довольны, что бои подушками не происходят в гостиной.
	</p>
	<p>
		Офис КУБ - Место располагающее к работе. КУБ позволит уединиться вдали от домочадцев, перечитать речь, подготовленную к утреннему выступлению. Тут вас никто не станет призывать к ответу за творческий беспорядок на столе.
	</p>
	<p>
		Барбекю КУБ - Наполнен друзьями все выходные! Встречи с близкими друзьями помогут ярко и весело провести время. Новый газовый мангал прекрасно устроился на веранде возле дартс-стенда. Еженедельные соревнования дополнят стэйки с овощами.
	</p>
	<p>
		Кино КУБ - Свой собственный кинотеатр на природе. Воспоминания о семейном просмотре полюбившихся фильмов, домашнего видео, навсегда останутся в памяти ваших детей. Куб станет местом хранения коллекций дисков, аппарат для попкорна приятно дополнит вечера в кругу семьи.
	</p>
	<p>
		Фитнес КУБ - Создает спортивное настроение! Дает возможность сочетать занятия в помещении и на свежем воздухе. Можете включить в КУБе любимую музыку или уроки видео-инструктора, не мешая домочадцам.
	</p>
	<p>
		Аква КУБ - У вас есть бассейн. Мы предлагаем КУБ-павильон с барной стойкой, мягкими диванами и теплым душем. Позволит удобно расположиться бабушке или няне, понаблюдать за малышами в воде.
	</p>
	<p>
		Хобби КУБ - В современном мире это называется арт-терапия. Чем увлечены Вы? Гончарным делом, изобразительным искусством, рукоделием? Изобретаете, моделируете, создаете? КУБ позволит Вам комфортно расположиться.
	</p>
	<p>
		Музыкальный КУБ - КУБ, в котором расположился домашний оркестр. Огромное количество музыкальной литературы. В музыке как и в спорте важно постоянство. Практикуйте свои навыки каждый день.
	</p>
	<p>
		Оранжерея КУБ - Наполнена ароматом цветов, краски - глаз не оторвать! Как мама это делает? Круглый год цветут, радуют, восхищают. Каждое утро на столе свежие цветы.
	</p>
	<p>
		<span>Бизнес КУБ - Многогранность применения: ярмарочные базары, торговые павильоны, спортивные прокатные шатры, детские игровые комнаты, летние кафе, остановки, причальные пункты, кассы, временные сооружения для проведения мероприятий города, рекламных компаний, офисы продаж и т.п. Приобретая КУБ Вы приобретаете новый бизнес! Реализуйте КУБ параллельно со своим товаром. Мы выплачиваем достойное агентское вознаграждение. <br>
 </span>
	</p>
	 Для получения&nbsp;подробной информации просим Вас обращаться к нашим менеджеру по телефону +7(985) 761 60 80 .<br>
 <br>
	 Производство: компания САМСОН. <br>
	 Гарантия на изделие: 3 года. <br>
	 Срок службы: 10 лет. <br>
 <br>
	 Для удобства получения информации мы организовали отдельное интернет пространство для КУБа: <a style="text-decoration: none;" href="http://www.samsoncube.ru" target="_blank"><span style="font-size: 14.6667px; font-family: Arial; color: #1155cc; font-variant: normal; text-decoration: underline; vertical-align: baseline;">www.samsoncube.ru</span></a>
	<p>
	</p>
	<div style="text-align: justify; background-color: #ffffff; clear: both;">
	</div>
	<p>
	</p>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>