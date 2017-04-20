<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Зимние детские горки от производителя Самсон");
?> 

<?$APPLICATION->IncludeComponent(
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
		"SECTION_ID" => "6",
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
<p style="clear: both;">&nbsp;&nbsp;</p>
 
<p>Уважаемые Клиенты и Партнеры, мы рады приветствовать Вас на нашем сайте! В данном разделе каталога мы предлагаем <font>продукцию для зимних развлечений</font>. Наша продукция предназначена для детей от 4 до 9 лет, создает условия, обеспечивающие физическое развитие ребенка, развивает координацию движений, преодоление страха высоты, ловкость и смелость, чувство коллективизма в массовых играх. </p>
 
<p><font><span style="text-align: justify; background-color: rgb(255, 255, 255);">Мы хотим, чтобы Ваш город (ваш двор, ваш поселок, ваш парк ....) был нарядным, красивым, веселым и праздничным для встречи Нового Года, для проведения Рождественских каникул, зимнего досуга на свежем воздухе. Благоустраивая территорию к проведению праздника предлагаем Вам обратить внимание на новый вид продукции компании &quot;Самсон&quot; - детские зимнии горки ледяные деревянные для катания на санках и других приспособлениях, неведомых старшему поколению, снегокатах, сноутьюбах, боб-санках, снегомобилях, сноуботах, пневмосанках.</span> 
    <br style="text-align: justify; background-color: rgb(255, 255, 255);" />
   </font></p>
 
<p><b>Преимущества детских деревянных горок &quot;Самсон&quot; для зимних развлечений: Просто налей воды!</b></p>
 
<p> <font> 1. <b>Клееный брус, а не массив древесины.</b> В производстве детские деревянные горки для зимних развлечений мы используем клееный брус из сосны северных регионов страны (Карелия, Коми). Особые природно-климатические условия Севера, многочисленные озера и каменные гряды, бескрайние девственные леса, постоянно продуваемые холодным ветром с Белого моря, требуют особой стойкости и большой жизненной энергии. Благодаря современным технологиям изделия из клееного бруса не дают усадки и не деформируются.</font></p>
 <font> 
  <p> <font> 2. <b>Лак, а не только пропитка.</b> Как мы защищаем древесину? Под защитой древесины понимают меры, которые помогут предотвратить или замедлить ее разрушение. Наш выбор - система для наружных отделок (полупрозрачный лак - грунтовка), представляющая собой специализированные водные дисперсии акриловых смол последнего поколения, способная растягиваться после сушки на 200% без разрыва плёнки. Суперэластичная, имеющая повышенную морозостойкость до -50&deg;С, что актуально для российского климата, и способная защитить от УФ - излучения. К тому же, она содержит специальные фунгицидные добавки (противогрибковая защита) разрешенные к применению в России и странах ЕС. AQUARIS ЛКМ RENNER Италия (система для наружных отделок, имеет международные сертификаты качества, гарантия свыше пяти лет). AQUA PRIMER - AQUATOP 2600 TEKNOS Финляндия (система для наружных отделок, имеет международные сертификаты качества, гарантия свыше семи лет).</font></p>
 <font> 
    <p> <font> 3. <b>Сборно-разборная конструкция, а не гвозди.</b> Наши детские деревянные горки - это сборно-разборная конструкция с подробной инструкцией по сборке модели. При установке конструкция не требует бетонирования. Отметим, что при установке сборно-разборной конструкции, подразумевается временной, не требуется разрешения автоинспекции. Установка осуществляется на любую ровную, свободную от насаждений поверхность, не портит брусчатку, асфальт, грунт, не требует бетонирования. </font></p>
   <font> 
      <p> <font> 4. <b>Заводское производство.</b> Наши модели произведены по утвержденному ТУ, соответствуют ГОСТ РФ. Высокое качество изделий обеспечивает итальянский станочный парк и сплоченный опытный коллектив.</font></p>
     <font> 
        <p> <font> 5. <b>Удобная транспортировка.</b> Упаковываем в гофрокартонные короба, места не длиннее 3-х м, не тяжелее 30 кг, учитываем удобство транспортировки в регионы. Думаем о клиентах.</font></p>
       </font></font></font></font> 
<p style="color: rgb(112, 128, 144); font-size: 16px;">Подготовка к эксплуатации зимней горки!</p>
 			 			 
<ul> 
  <li>Заливать горку рекомендуется под вечер, при значительной минусовой температуре, чтобы утром нанести финишный слой воды и начинать кататься. </li>
 
  <li>Перед тем как заливать деревянную горку водой, необходимо облепить ее снегом.</li>
 
  <li>Выкат готовой горки можно продолжить далеко вперед, чтобы длина ее значительно увеличилась, для этого нужно выпилить из снега большие кирпичи и продлить скат на необходимую длину. </li>
 
  <li>Если заливаете горку используя шланг, наденьте на него распыляющую насадку. </li>
 
  <li> Разбрызгивайте воду на поверхность ската, борта, выкат деревянной горки.</li>
 
  <li>Лестница должна оставаться без снега, если на нее попал снег, уберите его лопатой, в целях безопасности. </li>
 </ul>
 
<!-- <div style="width: 100%;"> 	 	 
                <p style="font-size: 25px;"><font color="#2f3192">Фотогалерея:</font></p>
               		<a id="bxid_673284" style="text-decoration: none; " rel="lightbox" href="/upload/iblock/558/558f34e38c4d93e60f03fc8442b032e8.JPG" class="lightbox-enabled" > 			<img id="bxid_543938" src="/upload/iblock/9f2/9f2d5f5df9071e76fa05c9dc62d2830d.JPG" height="107px"  />&nbsp;&nbsp;&nbsp; 		</a> 		 		<a id="bxid_709621" style="text-decoration: none; " rel="lightbox" href="/upload/iblock/d25/d253830b24e513a7eec672e094688719.JPG" class="lightbox-enabled" > 			<img id="bxid_669742" src="/upload/iblock/78e/78e1520fb244887a669dd9b224ac8b5d.JPG" height="107px"  />&nbsp;&nbsp;&nbsp; 		</a> 		 		<a id="bxid_953681" style="text-decoration: none; " rel="lightbox" href="/upload/iblock/4a9/4a91f190e539d44fd23942943ab64710.JPG" class="lightbox-enabled" > 			<img id="bxid_755611" src="/upload/iblock/841/8416d2cd81efb7a066fbd22a0c084de2.JPG" height="107px"  />&nbsp;&nbsp;&nbsp; 		</a> 
                <p><a id="bxid_853035" href="/Netshop/galery/galery_170.html" >смотреть в фото-галерее...</a></p>
    </div> -->
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>