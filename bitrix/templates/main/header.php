<!DOCTYPE HTML>
<html lang="ru-RU">
	<head> 
		<meta name="yandex-verification" content="5be335d276d1de8e">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="SHORTCUT ICON" href="/favicon.ico" type="image/x-icon"> 
		
		<title><?$APPLICATION->ShowTitle();?></title>
		<script type="text/javascript" src="/js/jquery-1.6.4.min.js"></script>

		<?$APPLICATION->ShowHead();?>
		<script type="text/javascript" src="/js/jquery.fancybox.js"></script>
		<script type="text/javascript" src="/js/jquery.pngFix.pack.js"></script>
		<script type="text/javascript" src="/js/jquery.metadata.js"></script>
		<script type="text/javascript" src="/js/jquery.lightbox.js"></script>
		<link rel="stylesheet" type="text/css" href="/js/lightbox.css">
		<link rel="stylesheet" type="text/css" href="/js/fancy.css">
		<link rel="stylesheet" type="text/css" href="/js/coin-slider-styles.css">
		<script type="text/javascript" src="/js/main_page.js"></script>	
		<script type="text/javascript" src="/js/script.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'] . '/js/script.js')?>"></script>
        <script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>

<script type="text/javascript">$(document).ready(function(){
$(window).scroll(function () {if ($(this).scrollTop() > 0) {$('#scroller').fadeIn();} else {$('#scroller').fadeOut();}});
$('#scroller').click(function () {$('body,html').animate({scrollTop: 0}, 400); return false;});
});

</script>
       <!--<script type="text/javascript">
sitePath = "/";
sflakesMax = 64;
sflakesMaxActive = 64;
svMaxX = 3;
svMaxY = 3;
ssnowStick = 1;
sfollowMouse = 1;
</script> Снег
<script type="text/javascript" src="/snow/snow.js"></script> -->
		<link type="text/css" rel="stylesheet" media="screen" href="/js/jquery.lightbox.css" id="lightbox-stylesheet-lightbox">
        

	</head> 
   
   
<?php /*?><? 
global $USER; 
if ($USER->IsAuthorized()) { ?>
<style>
	div { -moz-user-select: all; -webkit-user-select: all; -ms-user-select: all; -o-user-select: all; user-select: all; } 
</style>
	<body > 
<?}else{?>
<style>
div { -moz-user-select: none; -webkit-user-select: none; -ms-user-select: none; -o-user-select: none; user-select: none; } 
</style>
	<body > 
	<script>
     
var message="Правый клик запрещен!";
      function clickIE4(){
      if (event.button==2){
      alert(message);
      return false;
      }
      }
function clickNS4(e){
      if (document.layers||document.getElementById&&!document.all){
      if (e.which==2||e.which==3){
      alert(message);
      return false;
      }
      }
      }
if (document.layers){
      document.captureEvents(Event.MOUSEDOWN);
      document.onmousedown=clickNS4;
      }
      else if (document.all&&!document.getElementById){
      document.onmousedown=clickIE4;
      }
document.oncontextmenu=new Function("alert(message);return false")

      </script>
<?}?><?php */?>



<!-- Снег end -->

		<?$APPLICATION->ShowPanel();?>
		
		<div id="bbb" style="position:absolute;left:425px;width:450px;top:250px;border:1px solid #999;padding:35px;color:#666;background:#FFF;display: none;z-index:5;">
			<div style="font-size:22px;color:#666">Товар добавлен в корзину<br><br></div>
			<table width="100%">
				<tbody>
					<tr>
						<td style="text-align:left;">
							<div class="but_l">&nbsp;</div><div class="but"><a href="/" onClick="$(&quot;#bbb&quot;).fadeOut(500);return false">&#8592; Продолжить покупки</a></div><div class="but_r">&nbsp;</div>
						</td>
						<td style="text-align:right;">
		 					<div class="but_l">&nbsp;</div>
		 					<div class="but"><a id="frame2" onClick="$(&quot;#bbb&quot;).fadeOut(100)" href="/personal/basket/">Оформить заказ &#8594;</a></div><div class="but_r">&nbsp;</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="reg" style="display:none;position:absolute;left:850px;top:80px;border:1px solid #999;padding:15px;color:#666;background:#FFF"></div>
		
		<table	width="1024" align="center" >
			<tbody>
				<tr>
					<td class="padding_column"></td>
					<td align="center"> 
						<table align="center" style="margin-right:15px" class="gtable" id="nt" border="0"> 
							<tbody>
								<tr> 
									<td class="lefttd" style="text-align: center;">
										<a  href="/"><img style="width:300px" align="left"  src="/images/logo-osen2016.png" ></a>	
									</td> 
									<td>
										<table border="0" width="100%" valign="bottom">
											<tbody>
												<tr>
													<td>
														<?$APPLICATION->IncludeComponent("bitrix:menu", "topmenu", array(
															"ROOT_MENU_TYPE" => "top",
															"MENU_CACHE_TYPE" => "Y",
															"MENU_CACHE_TIME" => "9600",
															"MENU_CACHE_USE_GROUPS" => "Y",
															"MENU_CACHE_GET_VARS" => array(
															),
															"MAX_LEVEL" => "1",
															"CHILD_MENU_TYPE" => "left",
															"USE_EXT" => "N",
															"DELAY" => "N",
															"ALLOW_MULTI_SELECT" => "N"
															),
															false
														);?>
													</td>
												</tr>
                                                <tr>
                                               
											</tbody>
										</table> 	
									</td> 		
								</tr> 
								<tr class="change_height"> 
									<td class="lefttd" rowspan="2" align="center" valign="top" style="vertical-align:top;">
										<div style="color:#263b81;font-size:12px;text-align:center;">
											<i>
												<div style="color:#27397D;font-size:22px;text-align:center;vertical-align:top;"><span style="font-size:13px;vertical-align:top;"></span> +7 (985) 769-00-12</div>
												<?php /*?><div style="color:#27397D;font-size:22px;text-align:center;vertical-align:top;"><span style="font-size:13px;vertical-align:top;"></span>+7 (495) 979-09-83</div><?php */?>
												<div style="color:#27397d;text-align:right;vertical-align:top;margin-right:45px;" class="all_contacts"><span style="font-size:13px;vertical-align:top;">info@samson.bz</span></div>
                                                <?php /*?><div style="color:#27397d;font-size:20px;text-align:right;vertical-align:top;margin-right:45px;" class="all_contacts"><span style="font-size:13px;vertical-align:top;">c 8 до 17 (обед с 12 до 13)</span></div><?php */?>
                                                
												<div style="color:#27397d;font-size:22px;text-align:right;vertical-align:top;margin-right:45px;" class="all_contacts"><span style="font-size:13px;vertical-align:top;"><a href="/kontakts/" style="color:#27397D;">Все контакты</a></span></div>
											</i>
										</div>
										<div align="left" style="padding-top:0px;">
<!--											--><?//$APPLICATION->IncludeComponent(
//												"bitrix:menu",
//												"left_multi_menu",
//												Array(
//													"ROOT_MENU_TYPE" => "left",
//													"MENU_CACHE_TYPE" => "A",
//													"MENU_CACHE_TIME" => "3600",
//													"MENU_CACHE_USE_GROUPS" => "Y",
//													"MENU_CACHE_GET_VARS" => array(),
//													"MAX_LEVEL" => "2",
//													"CHILD_MENU_TYPE" => "inner",
//													"USE_EXT" => "Y",
//													"DELAY" => "N",
//													"ALLOW_MULTI_SELECT" => "N"
//												)
//											);?>
											<div class="leftmenu"><br><br>
					 							<?CModule::IncludeModule("iblock");?>
					 							<p style="
    text-decoration: none; margin-bottom: 20px;
    padding-left: 25px;
    width: 240px; 	background-image: url('/images/rumb3-b.png');
	background-repeat:no-repeat;
	background-position:left 3px;"><b><a style="color: #fcaf17;
    font-size: 13px; text-decoration:none" href="/">Детские деревянные игровые площадки для дачи и дома</a></b></p>
                                                <div class="level_1_yellow">
					 								<div class="rumb">
					 									<a href="/Netshop/derevostreet/"><b>САМСОН</b></a>
                                                        <p style="color:ddd; font-size:11px">РОССИЯ, ПОКРЫТИЕ ЛАК/ГРУНТ, БРУС/МАССИВ</p>
					 									<?
														if($APPLICATION->GetCurDir()=="/Netshop/derevostreet/")
															$orange=true;
													 	if($_GET["CODE"])
													 	{
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>2, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0)
													 		{
																$orange=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}
														if($orange)
														{?>
															<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "cat_spisok_left", Array(
																"IBLOCK_TYPE" => "Catalogs",	// Тип инфоблока
																"IBLOCK_ID" => "3",	// Инфоблок
																"SECTION_ID" => "2",	// ID раздела
																"SECTION_CODE" => "",	// Код раздела
																"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
																"COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
																"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
																"SECTION_FIELDS" => "DETAIL_PICTURE",	// Поля разделов
																"SECTION_USER_FIELDS" => "",	// Свойства разделов
																"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
																"CACHE_TYPE" => "N",	// Тип кеширования
																"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
																"CACHE_GROUPS" => "N",	// Учитывать права доступа
																),
																false
															);?>
														<?}
														?> 									
					 								</div>
					 							</div>
                                                <div class="level_1_yellow">
						 							<div class="rumb"><p style="color: #fcaf17;
    font-size: 13px; "><b>САМСОН 2017</b></p>
                                                    		<?php /*?><a href="/Netshop/samson2017/"><b>САМСОН 2017</b></a><?php */?>
                                                        <p style="color:ddd; font-size:11px">РОССИЯ, ПОКРЫТИЕ 2 СЛОЯ ЛАКА/ГРУНТ, БРУС/МАССИВ</p>
					 									<?
														if($APPLICATION->GetCurDir()=="/Netshop/samson2017/")
															$samson2017=true;
													 	if($_GET["CODE"])
													 	{
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>260, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0)
													 		{
																$samson2017=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}

														if($samson2017)
														{
															echo "<div style=\"margin-bottom: 10px\" class=\"hr\"></div>";
															echo "</div>";
															echo "<div class=\"items\">";
															$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>260);
															$sres = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, true);
															while($ar_result = $sres->GetNext())
															{
																if($ar_result["ID"]==$section_id)
																	echo "<span>".$ar_result["NAME"]."</span><br>";
																else
																{
																	$arSelect = Array("ID", "NAME", "CODE");
																	$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$ar_result["ID"]);
																	$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
																	while($ob = $res->GetNextElement())
																	{
																		$arFields = $ob->GetFields();
																		$url=$arFields["CODE"];
																		break;
																	}
																	echo "<a href=\"/Netshop/samson2017/".$ar_result["CODE"]."/".$arFields["CODE"].".html\">".$ar_result["NAME"]."</a><br>";
																}
															}
														}
														?>
													</div></div>
                                                  
                                                
                                                <div class="level_1_yellow">
					 								<div class="rumb">
					 									<p style="color: #fcaf17;
    font-size: 13px; "><b>СИБЕРИКА</b></p>
                                                        <p style="color:ddd; font-size:11px">РОССИЯ, ПОКРЫТИЕ МАСЛО, БРУС/МАССИВ</p>
					 									<?php /*?><?
														if($APPLICATION->GetCurDir()=="/Netshop/derevostreet-siber/")
															$orangesiber=true;
													 	if($_GET["CODE"])
													 	{
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>2, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0)
													 		{
																$orangesiber=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}
														if($orangesiber)
														{?>
															<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "cat_spisok_left", Array(
																"IBLOCK_TYPE" => "Catalogs",	// Тип инфоблока
																"IBLOCK_ID" => "3",	// Инфоблок
																"SECTION_ID" => "2",	// ID раздела
																"SECTION_CODE" => "",	// Код раздела
																"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
																"COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
																"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
																"SECTION_FIELDS" => "DETAIL_PICTURE",	// Поля разделов
																"SECTION_USER_FIELDS" => "",	// Свойства разделов
																"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
																"CACHE_TYPE" => "N",	// Тип кеширования
																"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
																"CACHE_GROUPS" => "N",	// Учитывать права доступа
																),
																false
															);?>
														<?}
														?> 	<?php */?>								
					 								</div>
					 							</div>
                                                
                                                <div class="level_1_yellow">
					 								<div class="rumb">
					 									<p style="color: #fcaf17;
    font-size: 13px; "><b>ЭЛЕМЕНТ</b></p>
                                                        <p style="color:ddd; font-size:11px">РОССИЯ, БЕЗ ПОКРЫТИЯ, БРУС/МАССИВ</p>
					 									<?php /*?><?
														if($APPLICATION->GetCurDir()=="/Netshop/derevostreet-element/")
															$orangeelement=true;
													 	if($_GET["CODE"])
													 	{
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>2, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0)
													 		{
																$orangeelement=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}
														if($orangeelement)
														{?>
															<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "cat_spisok_left", Array(
																"IBLOCK_TYPE" => "Catalogs",	// Тип инфоблока
																"IBLOCK_ID" => "3",	// Инфоблок
																"SECTION_ID" => "2",	// ID раздела
																"SECTION_CODE" => "",	// Код раздела
																"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
																"COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
																"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
																"SECTION_FIELDS" => "DETAIL_PICTURE",	// Поля разделов
																"SECTION_USER_FIELDS" => "",	// Свойства разделов
																"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
																"CACHE_TYPE" => "N",	// Тип кеширования
																"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
																"CACHE_GROUPS" => "N",	// Учитывать права доступа
																),
																false
															);?>
														<?}
														?> <?php */?>									
					 								</div>
					 							</div>
                                                
                                                 <div class="level_1_yellow">
					 								<div class="rumb">
					 									<p style="color: #fcaf17;
    font-size: 13px; "><b>BLUE RABBIT</b></p>
                                                        <p style="color:ddd; font-size:11px">БЕЛЬГИЯ, ИМПРЕГНАЦИЯ, БРУС/МАССИВ</p>
					 									<?php /*?><?
														if($APPLICATION->GetCurDir()=="/Netshop/derevostreet-rabbit/")
															$orangerabbit=true;
													 	if($_GET["CODE"])
													 	{
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>2, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0)
													 		{
																$orangerabbit=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}
														if($orangerabbit)
														{?>
															<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "cat_spisok_left", Array(
																"IBLOCK_TYPE" => "Catalogs",	// Тип инфоблока
																"IBLOCK_ID" => "3",	// Инфоблок
																"SECTION_ID" => "2",	// ID раздела
																"SECTION_CODE" => "",	// Код раздела
																"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
																"COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
																"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
																"SECTION_FIELDS" => "DETAIL_PICTURE",	// Поля разделов
																"SECTION_USER_FIELDS" => "",	// Свойства разделов
																"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
																"CACHE_TYPE" => "N",	// Тип кеширования
																"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
																"CACHE_GROUPS" => "N",	// Учитывать права доступа
																),
																false
															);?>
														<?}
														?> 	<?php */?>								
					 								</div>
					 							</div>
                                                
                                                
                                                
                                                
                                                		
                                                    <div class="level_1_kiddy">
					 								<div class="rumb">
					 									<a href="/Netshop/kiddyloft/"><b>ИГРОВАЯ КРОВАТЬ-ЧЕРДАК</b></a><br>
                                                          <p style="color:ddd; font-size:11px">РОССИЯ, БЕЗ ПОКРЫТИЯ, МАССИВ</p>
					 									<? if($APPLICATION->GetCurDir()=="/Netshop/kiddyloft/")
															$kiddy=true;
													 	if($_GET["CODE"])
													 	{
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>238, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0)
													 		{
																$kiddy=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}
														if($kiddy)
														{?>
															<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "cat_spisok_kiddy_left", Array(
																"IBLOCK_TYPE" => "Catalogs",	// Тип инфоблока
																"IBLOCK_ID" => "3",	// Инфоблок
																"SECTION_ID" => "238",	// ID раздела
																"SECTION_CODE" => "",	// Код раздела
																"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
																"COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
																"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
																"SECTION_FIELDS" => "DETAIL_PICTURE",	// Поля разделов
																"SECTION_USER_FIELDS" => "",	// Свойства разделов
																"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
																"CACHE_TYPE" => "N",	// Тип кеширования
																"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
																"CACHE_GROUPS" => "N",	// Учитывать права доступа
																),
																false
															);?>
														<?}
														?> 									
					 								</div>
					 							</div>
                                                <div class="level_1_blue">
					 								<div class="rumb">
					 									<a href="/Netshop/dop/"><b>АКСЕССУАРЫ</b></a>
                                                          <p style="color:ddd; font-size:11px">РОССИЯ, БЕЛЬГИЯ КБТ</p>
					 									<?
														if($APPLICATION->GetCurDir()=="/Netshop/dop/") $blue=true;
														if($APPLICATION->GetCurDir()=="/Netshop/dop/mat/") $blue=true;
														if($APPLICATION->GetCurDir()=="/Netshop/dop/ka/") $blue=true;
														if($_GET["CODE"]) {
															$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>3, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
															if($res->SelectedRowsCount() > 0) {
																$blue=true;
																$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
																$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
															if($ar_res = $res->GetNext())
																 $section_id=$ar_res['ID'];
															}
														}

														if($blue)
														{
																echo "<div class=\"hr\"></div>";
																echo "</div>";
																echo "<div class=\"items\">";
																$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>3);
																$sres = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, true);
																while($ar_result = $sres->GetNext())
																{
																	
																if($ar_result["ID"]==$section_id || $APPLICATION->GetCurDir()=="/Netshop/dop/".$ar_result["CODE"]."/"){
																		echo "<span>".$ar_result["NAME"]."</span><br>";
																		if($ar_result["CODE"] == 'mat' || $ar_result["CODE"] == 'ka'){
																			$arFilterForThirdLevel = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$ar_result["ID"]);
																			$sresForThirdLevel = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilterForThirdLevel, false);
																			while($ar_result_for_third_level = $sresForThirdLevel->GetNextElement()){ 
																				$fields_for_third_level = $ar_result_for_third_level->GetFields();
																				if($_SERVER['REQUEST_URI']=="/Netshop/dop/".$ar_result["CODE"]."/".$fields_for_third_level["CODE"].".html") {
																						echo "<span class='withoutmarker'>".$fields_for_third_level["NAME"]."</span><br>";
																				}	else {
																						echo "<a class='linkswithoutmarker' href=\"/Netshop/dop/".$ar_result["CODE"]."/".$fields_for_third_level["CODE"].".html\">".$fields_for_third_level["NAME"]."</a><br>";
																 				}
																			}
																		}
																	}
																else
																{
																	$arSelect = Array("ID", "NAME", "CODE");
																	$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$ar_result["ID"]);
																	$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
																	while($ob = $res->GetNextElement())
																	{
																		$arFields = $ob->GetFields();
																		//var_dump($arFields);
																		$url=$arFields["CODE"];
																		break;
																	}
																		if($ar_result["CODE"] == 'mat' || $ar_result["CODE"] == 'ka'){
																			echo "<a href=\"/Netshop/dop/".$ar_result["CODE"]."/\">".$ar_result["NAME"]."</a><br>";
																		} else {
																			echo "<a href=\"/Netshop/dop/".$ar_result["CODE"]."/".$arFields["CODE"].".html\">".$ar_result["NAME"]."</a><br>";
																	}
																}
																}
														}
					 									?> 			 									
					 								</div>
					 							</div>
                                                <div class="grayforwintergoods">
					 								<div class="rumb">
					 									<a href="/Netshop/zima/"><b>ЗИМНИЕ ГОРКИ</b></a><br>
                                                          <p style="color:ddd; font-size:11px">РОССИЯ, БЕЗ ПОКРЫТИЯ/ЛАК/МАСЛО, БРУС/МАССИВ</p>
					 									<? if($APPLICATION->GetCurDir()=="/Netshop/zima/")
															$grey=true;
													 	if($_GET["CODE"])
													 	{
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>6, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0)
													 		{
																$grey=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}
														if($grey)
														{?>
															<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "cat_spisok_zima_left", Array(
																"IBLOCK_TYPE" => "Catalogs",	// Тип инфоблока
																"IBLOCK_ID" => "3",	// Инфоблок
																"SECTION_ID" => "6",	// ID раздела
																"SECTION_CODE" => "",	// Код раздела
																"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
																"COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
																"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
																"SECTION_FIELDS" => "DETAIL_PICTURE",	// Поля разделов
																"SECTION_USER_FIELDS" => "",	// Свойства разделов
																"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
																"CACHE_TYPE" => "N",	// Тип кеширования
																"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
																"CACHE_GROUPS" => "N",	// Учитывать права доступа
																),
																false
															);?>
														<?}
														?> 									
					 								</div>
					 							</div>
                                                
												<div class="level_1_forhomies">
						 							<div class="rumb">
                                                    	<a href="/Netshop/sad/"><b>САДОВАЯ МЕБЕЛЬ</b></a>
                                                         <p style="color:ddd; font-size:11px">РОССИЯ, ПОКРЫТИЕ ЛАК/ГРУНТ,<br> БРУС/МАССИВ</p>
					 									<?
														if($APPLICATION->GetCurDir()=="/Netshop/sad/")
															$teal=true;
													 	if($_GET["CODE"])
													 	{
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>109, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0)
													 		{
																$teal=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}

														if($teal)
														{
															echo "<div class=\"hr\"></div>";
															echo "</div>";
															echo "<div class=\"items\">";
															$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>109);
															$sres = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, true);
															while($ar_result = $sres->GetNext())
															{
																if($ar_result["ID"]==$section_id)
																	echo "<span>".$ar_result["NAME"]."</span><br>";
																else
																{
																	$arSelect = Array("ID", "NAME", "CODE");
																	$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$ar_result["ID"]);
																	$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
																	while($ob = $res->GetNextElement())
																	{
																		$arFields = $ob->GetFields();
																		$url=$arFields["CODE"];
																		break;
																	}
																	echo "<a href=\"/Netshop/sad/".$ar_result["CODE"]."/".$arFields["CODE"].".html\">".$ar_result["NAME"]."</a><br>";
																}
															}
														}
														?>
													</div></div>
                                                <div class="level_1_green">
					 								<div class="rumb">
					 									<a href="/Netshop/choice/"><b>Детские металлические спортивно-игровые комплексы для дома и улицы (ДСК, УДСК)</b></a>
					 									<?
														if($APPLICATION->GetCurDir()=="/Netshop/choice/")
															$oranges=true;
													 	if($_GET["CODE"])
													 	{
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>221, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0)
													 		{
																$oranges=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}
														if($oranges)
														{?>
															<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "cat_spisok_choice_left", Array(
																"IBLOCK_TYPE" => "Catalogs",	// Тип инфоблока
																"IBLOCK_ID" => "3",	// Инфоблок
																"SECTION_ID" => "221",	// ID раздела
																"SECTION_CODE" => "",	// Код раздела
																"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
																"COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
																"TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
																"SECTION_FIELDS" => "DETAIL_PICTURE",	// Поля разделов
																"SECTION_USER_FIELDS" => "",	// Свойства разделов
																"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
																"CACHE_TYPE" => "N",	// Тип кеширования
																"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
																"CACHE_GROUPS" => "N",	// Учитывать права доступа
																),
																false
															);?>
														<?}
														?> 									
					 								</div>
					 							</div>
                                                
                                                <?php /*?>
                                                <div class="level_1_red">
					 								<div class="rumb">
					 									<a href="/Netshop/choice/"><b>Детские спортивные комплексы для дома и улицы</b></a>
					 									<?
														if($APPLICATION->GetCurDir()=="/Netshop/choice/") $blues=true;
														if($APPLICATION->GetCurDir()=="/Netshop/choice/matlal/") $blues=true;
														if($APPLICATION->GetCurDir()=="/Netshop/choice/metalstreet/") $blues=true;
														if($_GET["CODE"]) {
															$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>219, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
															if($res->SelectedRowsCount() > 0) {
																$blues=true;
																$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
																$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
															if($ar_res = $res->GetNext())
																 $section_id=$ar_res['ID'];
															}
														}

														if($blues)
														{
																echo "<div class=\"hr\"></div>";
																echo "</div>";
																echo "<div class=\"items\">";
																$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>219);
																$sres = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, true);
																while($ar_result = $sres->GetNext())
																{
																	
																if($ar_result["ID"]==$section_id || $APPLICATION->GetCurDir()=="/Netshop/choice/".$ar_result["CODE"]."/"){
																		echo "<span>".$ar_result["NAME"]."</span><br>";
																		if($ar_result["CODE"] == 'choice' || $ar_result["CODE"] == 'matlal'){
																			$arFilterForThirdLevel = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$ar_result["ID"]);
																			$sresForThirdLevel = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilterForThirdLevel, false);
																			while($ar_result_for_third_level = $sresForThirdLevel->GetNextElement()){ 
																				$fields_for_third_level = $ar_result_for_third_level->GetFields();
																				if($_SERVER['REQUEST_URI']=="/Netshop/choice/".$ar_result["CODE"]."/".$fields_for_third_level["CODE"].".html") {
																						echo "<span class='withoutmarker'>".$fields_for_third_level["NAME"]."</span><br>";
																				}	else {
																						echo "<a class='linkswithoutmarker' href=\"/Netshop/choice/".$ar_result["CODE"]."/".$fields_for_third_level["CODE"].".html\">".$fields_for_third_level["NAME"]."</a><br>";
																 				}
																			}
																		}
																	}
																else
																{
																	$arSelect = Array("ID", "NAME", "CODE");
																	$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$ar_result["ID"]);
																	$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
																	while($ob = $res->GetNextElement())
																	{
																		$arFields = $ob->GetFields();
																		//var_dump($arFields);
																		$url=$arFields["CODE"];
																		break;
																	}
																		if($ar_result["CODE"] == 'choice' || $ar_result["CODE"] == 'metalstreet'){
																			echo "<a href=\"/Netshop/choice/".$ar_result["CODE"]."/\">".$ar_result["NAME"]."</a><br>";
																		} else {
																			echo "<a href=\"/Netshop/choice/".$ar_result["CODE"]."/\">".$ar_result["NAME"]."</a><br>";
																	}
																}
																}
														}
					 									?> 			 									
					 								</div>
					 							</div><?php */?>
                                                		<?php /*?>
                                                <div class="level_1_red">
						 							<div class="rumb">
						 								<a href="/Netshop/choice/"><b>Детские спортивные комплексы для дома и улицы</b></a>
														<?
														if($APPLICATION->GetCurDir()=="/Netshop/choice/")
															$marp=true;
														if($_GET["CODE"])
														{
															$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>219, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
															if($res->SelectedRowsCount() > 0)
															{
																$marp=true;
																$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
																$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
															if($ar_res = $res->GetNext())
																 $section_id=$ar_res['ID'];
															}
														}

														if($marp)
														{
															echo "<div class=\"hr\"></div>";
															echo "</div>";
															echo "<div class=\"items\">";
															$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>219);
															$sres = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, true);
															while($ar_result = $sres->GetNext())
															{
																if($ar_result["ID"]==$section_id)
																	echo "<span>".$ar_result["NAME"]."</span><br>";
																else
																{
																	$arSelect = Array("ID", "NAME", "CODE");
																	$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$ar_result["ID"]);
																	$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
																	while($ob = $res->GetNextElement())
																	{
																		$arFields = $ob->GetFields();
																		//var_dump($arFields);
																		$url=$arFields["CODE"];
																		break;
																	}
																	echo "<a href=\"/Netshop/choice/".$ar_result["CODE"]."/".$arFields["CODE"].".html\">".$ar_result["NAME"]."</a><br>";
																}
															}
														}
														?>	 								
						 							</div>
						 						</div><?php */?>
					 									
												<?php /*?><div class="level_1_red">
						 							<div class="rumb">
						 								<a href="/Netshop/matlal/"><b>Детские спортивные комплексы для дома и улицы</b></a>
														<?
														if($APPLICATION->GetCurDir()=="/Netshop/matlal/")
															$marp=true;
														if($_GET["CODE"])
														{
															$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>4, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
															if($res->SelectedRowsCount() > 0)
															{
																$marp=true;
																$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
																$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
															if($ar_res = $res->GetNext())
																 $section_id=$ar_res['ID'];
															}
														}

														if($marp)
														{
															echo "<div class=\"hr\"></div>";
															echo "</div>";
															echo "<div class=\"items\">";
															$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>4);
															$sres = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, true);
															while($ar_result = $sres->GetNext())
															{
																if($ar_result["ID"]==$section_id)
																	echo "<span>".$ar_result["NAME"]."</span><br>";
																else
																{
																	$arSelect = Array("ID", "NAME", "CODE");
																	$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$ar_result["ID"]);
																	$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
																	while($ob = $res->GetNextElement())
																	{
																		$arFields = $ob->GetFields();
																		//var_dump($arFields);
																		$url=$arFields["CODE"];
																		break;
																	}
																	echo "<a href=\"/Netshop/matlal/".$ar_result["CODE"]."/".$arFields["CODE"].".html\">".$ar_result["NAME"]."</a><br>";
																}
															}
														}
														?>	 								
						 							</div>
						 						</div>
					 									<div class="level_1_green">
					 								<div class="rumb">
					 									<a href="/Netshop/metalstreet/"><b class="<?=$APPLICATION->GetCurDir()?>">Садовый КУБ Самсон</b></a>
					 									<?
														if(strpos($APPLICATION->GetCurDir(),"Netshop/metalstreet/")>0) $green=true;
														if($_GET["CODE"])
													 	{
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>1, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0)
													 		{
																$orange=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}

														if($green)
														{
																echo "<div class=\"hr\"></div>";
																echo "</div>";
																echo "<div class=\"items\">";
															$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>1);
															$sres = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, true);
															while($ar_result = $sres->GetNext())
															{
																if($ar_result["ID"]==$section_id)
																	echo "<span>".$ar_result["NAME"]."</span><br>";
																else
																{
																	$arSelect = Array("ID", "NAME", "CODE");
																	$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$ar_result["ID"]);
																	$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
																	while($ob = $res->GetNextElement())
																	{
																		$arFields = $ob->GetFields();
																		//var_dump($arFields);
																		$url=$arFields["CODE"];
																		break;
																	}
																	echo "<a href=\"/Netshop/metalstreet/".$ar_result["CODE"]."/".$arFields["CODE"].".html\">".$ar_result["NAME"]."</a><br>";
																}
															}
														}
					 									?>
					 								</div>
					 							</div><?php */?>
					 							
                                                
                                                
                                                
					 							
					 							
                                                <div class="level_1_coffe">
					 								<div class="rumb">
					 									<a href="/Netshop/cube/"><b class="<?=$APPLICATION->GetCurDir()?>">Садовый КУБ Самсон</b></a>
					 									<?
														if(strpos($APPLICATION->GetCurDir(),"Netshop/cube/")>0) $green=true;
														if($_GET["CODE"])
													 	{
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>222, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0)
													 		{
																$orange=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}

														if($green)
														{
																echo "<div class=\"hr\"></div>";
																echo "</div>";
																echo "<div class=\"items\">";
															$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>222);
															$sres = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, true);
															while($ar_result = $sres->GetNext())
															{
																if($ar_result["ID"]==$section_id)
																	echo "<span>".$ar_result["NAME"]."</span><br>";

																else
																{
																	$arSelect = Array("ID", "NAME", "CODE");
																	$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$ar_result["ID"]);
																	$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
																	while($ob = $res->GetNextElement())
																	{
																		$arFields = $ob->GetFields();
																		//var_dump($arFields);
																		$url=$arFields["CODE"];
																		break;
																	}
																	echo "<a href=\"/Netshop/cube/".$ar_result["CODE"]."/".$arFields["CODE"].".html\">".$ar_result["NAME"]."</a><br>";
																}
															}
														}
					 									?>
					 								</div></br><?$APPLICATION->IncludeComponent("bitrix:search.form","",Array(
														"USE_SUGGEST" => "N",
														"PAGE" => "#SITE_DIR#search/index.php"
													)
												);?> </br>
					 							</div>
					 							<!--
					 							<div class="level_1_coffe">
						 							<div class="rumb">
						 								<a href="/Netshop/domikiiploschadki/"><b>Домики и площадки для парков и дворов</b></a>
														<?
														if($APPLICATION->GetCurDir()=="/Netshop/domikiiploschadki/") $braun=true;
														if($APPLICATION->GetCurDir()=="/Netshop/domikiiploschadki/shack/") $braun=true;
														if($APPLICATION->GetCurDir()=="/Netshop/domikiiploschadki/origami/") $braun=true;
														if($APPLICATION->GetCurDir()=="/Netshop/domikiiploschadki/fantasy/") $braun=true;
														if($_GET["CODE"]) {
															$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>5, "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
															if($res->SelectedRowsCount() > 0) {
																$braun=true;
																$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
																$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
															if($ar_res = $res->GetNext())
																 $section_id=$ar_res['ID'];
															}
														}

														if($braun)
														{
																echo "<div class=\"hr\"></div>";
																echo "</div>";
																echo "<div class=\"items\">";
																$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>5);
																$sres = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, true);
																												
																while($ar_result = $sres->GetNext())
																{
																if($ar_result["ID"]==$section_id || $APPLICATION->GetCurDir()=="/Netshop/domikiiploschadki/".$ar_result["CODE"]."/")
																		{
																			echo "<span>".$ar_result["NAME"]."</span><br>";
																		$arFilterForThirdLevel = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$ar_result["ID"]);
																			$sresForThirdLevel = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilterForThirdLevel, false);
																			while($ar_result_for_third_level = $sresForThirdLevel->GetNextElement()){ 
																				$fields_for_third_level = $ar_result_for_third_level->GetFields();
																				if($_SERVER['REQUEST_URI']=="/Netshop/domikiiploschadki/".$ar_result["CODE"]."/".$fields_for_third_level["CODE"].".html") {
																						echo "<span class='withoutmarker'>".$fields_for_third_level["NAME"]."</span><br>";
																				}	else {
																						echo "<a class='linkswithoutmarker' href=\"/Netshop/domikiiploschadki/".$ar_result["CODE"]."/".$fields_for_third_level["CODE"].".html\">".$fields_for_third_level["NAME"]."</a><br>";
																 				}
																			}
																	}
																else
																{
																		echo "<a href=\"/Netshop/domikiiploschadki/".$ar_result["CODE"]."/\">".$ar_result["NAME"]."</a><br>";
																}
																}
																
														}
					 									?>	 								
						 							</div>
						 						</div>-->	
					 							
					 					
						 						
						 						<!--<div class="level_1_forhomies">
						 							<div class="rumb">
														<a href="/Netshop/domikoizkartonadlyatvorchestva/"><b>Товары для сада и дачи</b></a>
														<?
														if($APPLICATION->GetCurDir()=="/Netshop/domikoizkartonadlyatvorchestva/") $teal=true;
													 	if($_GET["CODE"]) {
															$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>67, "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0) $teal=true;
													 	}
														if($teal)
														{
															echo "<div class=\"hr\"></div>";
															echo "</div>";
															echo "<div class=\"items\">";
															$arSelect = Array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "EXTERNAL_ID");
															$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>67);
															$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
															while($ob = $res->GetNextElement())
															{
																$arFields = $ob->GetFields();
																if($arFields["CODE"]==$_GET["CODE"])
																	echo "<span>".$arFields["NAME"]."</span><br>";
																else
																	echo "<a href=\"/Netshop/domikoizkartonadlyatvorchestva/".$arFields["CODE"]."_".$arFields["EXTERNAL_ID"].".html\">".$arFields["NAME"]."</a><br>";
															}
														}
														?>
													</div>
                                                    
												</div>	-->		
												
						 					
												<!--
												<div class="level_1_dark_blue">
							 						<div class="rumb">
							 							<a href="/certificate/"><b>Документы</b></a>
							 							<?
							 								if($APPLICATION->GetCurDir()=="/certificate/") 
							 									{ echo "<div class=\"hr\"></div>";}
							 							?>
							 						</div>
							 					</div>
												-->
												
												
												    
												<?
												$curPage = $APPLICATION->GetCurPage();
												$bGalleryPage = strpos($curPage, '/Netshop/galery/') !== false;
												?>
												<div class="level_1_dark_blue">
							 						<div class="rumb">
							 							<a href="/Netshop/galery/"><b>Фотогалерея</b></a>
							 							<?if ($bGalleryPage):?>
							 								<div class="hr"></div>



							 							<?endif?>
							 						</div>
							 						<?if ($bGalleryPage):?>
						 								<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "left-menu", Array(
															"IBLOCK_TYPE" => "Dop",
															"IBLOCK_ID" => "4",
															"SECTION_ID" => "",
															"SECTION_CODE" => "",
															"SECTION_URL" => "",
															"COUNT_ELEMENTS" => "N",
															"TOP_DEPTH" => "1",
															"SECTION_FIELDS" => "",
															"SECTION_USER_FIELDS" => "",
															"ADD_SECTIONS_CHAIN" => "N",
															"CACHE_TYPE" => "A",
															"CACHE_TIME" => "36000000",
															"CACHE_GROUPS" => "N",
															'CUR_PAGE' => $curPage,
															),
															false
														);?>
						 							<?endif?>
							 					</div>
						 						
                                                
                                              	<div class="level_1_dark_blue">
						 							<div class="rumb">
						 								<a href="/agree/"><b>Условия Соглашения</b></a>
						 								<?
							 								if($APPLICATION->GetCurDir()=="/agree/") 
							 									 { echo "<div class=\"hr\"></div>";} 
							 							?>
						 							</div>
						 						</div> <?php /*?> <?php */?>
                                                	<div class="level_1_dark_blue">
						 							<div class="rumb">
						 								<a href="/Netshop/guaranteies/"><b>Гарантийные обязательства</b></a>
						 								<?
							 								if($APPLICATION->GetCurDir()=="/Netshop/guaranteies/") 
							 									 { echo "<div class=\"hr\"></div>";} 
							 							?>
						 							</div>
						 						</div> 
                                                
                                                <?
												$curPage = $APPLICATION->GetCurPage();
												$bGalleryPage = strpos($curPage, '/certificate/') !== false;
												?>
												<div class="level_1_dark_blue">
							 						<div class="rumb">
							 							<a href="/certificate/"><b>Документы</b></a>
							 							<?if ($bGalleryPage):?>
							 								<div class="hr"></div>
							 							<?endif?>
							 						</div>
							 						<?if ($bGalleryPage):?>
						 								<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "left-menu", Array(
															"IBLOCK_TYPE" => "",
															"IBLOCK_ID" => "1",
															"SECTION_ID" => "",
															"SECTION_CODE" => "",
															"SECTION_URL" => "",
															"COUNT_ELEMENTS" => "N",
															"TOP_DEPTH" => "1",
															"SECTION_FIELDS" => "",
															"SECTION_USER_FIELDS" => "",
															"ADD_SECTIONS_CHAIN" => "N",
															"CACHE_TYPE" => "A",
															"CACHE_TIME" => "36000000",
															"CACHE_GROUPS" => "N",
															'CUR_PAGE' => $curPage,
															),
															false
														);?>
						 							<?endif?></br>
                                                   
                                                 
												
							 					</div>
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                               
                                                
                                               
							 					<div class="listofnews_in_leftblock">
							 						
							 						<div href="/news/"><div style="margin-bottom:10px !important;" class="level_1_dark_blue"><div class="rumb"><a style="font-weight: bold" href="/news/">Новости</a></div></div></div>
													<?$APPLICATION->IncludeComponent("bitrix:news.list", ".default", array(
														"IBLOCK_TYPE" => "-",
														"IBLOCK_ID" => "2",
														"NEWS_COUNT" => "3",
														"SORT_BY1" => $arParams["SORT_BY1"],
														"SORT_ORDER1" => $arParams["SORT_ORDER1"],
														"SORT_BY2" => $arParams["SORT_BY2"],
														"SORT_ORDER2" => $arParams["SORT_ORDER2"],
														"FILTER_NAME" => $arParams["FILTER_NAME"],
														"FIELD_CODE" => array(
															0 => "",
															1 => $arParams["LIST_FIELD_CODE"],
															2 => "",
														),
														"PROPERTY_CODE" => array(
															0 => "",
															1 => $arParams["LIST_PROPERTY_CODE"],
															2 => "",
														),
														"CHECK_DATES" => "N",
														"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
														"AJAX_MODE" => "Y",
														"AJAX_OPTION_JUMP" => "N",
														"AJAX_OPTION_STYLE" => "Y",
														"AJAX_OPTION_HISTORY" => "N",
														"CACHE_TYPE" => "A",
														"CACHE_TIME" => $arParams["CACHE_TIME"],
														"CACHE_FILTER" => "Y",
														"CACHE_GROUPS" => "N",
														"PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
														"ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
														"SET_TITLE" => "N",
														"SET_STATUS_404" => "N",
														"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
														"ADD_SECTIONS_CHAIN" => "Y",
														"HIDE_LINK_WHEN_NO_DETAIL" => "N",
														"PARENT_SECTION" => "",
														"PARENT_SECTION_CODE" => "",
														"DISPLAY_TOP_PAGER" => "N",
														"DISPLAY_BOTTOM_PAGER" => "N",
														"PAGER_TITLE" => $arParams["PAGER_TITLE"],
														"PAGER_SHOW_ALWAYS" => "N",
														"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
														"PAGER_DESC_NUMBERING" => "N",
														"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
														"PAGER_SHOW_ALL" => "N",
														"DISPLAY_DATE" => "N",
														"DISPLAY_NAME" => "Y",
														"DISPLAY_PICTURE" => "N",
														"DISPLAY_PREVIEW_TEXT" => "Y",
														"AJAX_OPTION_ADDITIONAL" => ""
														),
														$component
													);?>
												</div>
												<a style="	color: #999; padding-left:75px" href="/news/">архив новостей</a><br>
												<br> 
												
												<div style="color: black;font-size: 15px;font-style: italic;"> 
													<p><a style="color:#000" href="http://1090983.ru/kontakts/">Розничные продажи:</a></p>
													<p>часы работы: с 8-00 до 17-00</p>
													<p>+7(985) 769-00-12 Евгения</p>
													<?php /*?><p>+7(495) 979-09-83 офис</p><?php */?>
													<p>почта: info@samson.bz</p>
													
													<div style="color: black;font-style: italic;font-size: 15px;"> <br>
													  <p ><a style="color:#000" href="http://1090983.ru/opt/">Оптовые продажи</a>:</p>
														<p>часы работы: с <span __postbox-detected-content="__postbox-detected-date">8-00</span> до 17-00</p>
														<p>+7(985) 922-85-28 Иван</p>
														<p>+7(985) 920-18-71 Анна</p>
														<p>+7(985) 769-02-10 Татьяна</p>
              <br>                                           
                                                        <p>
                                                        <a target="_blank" href="http://vk.com/samson_company"><img src="/images/2016-04-13_11-30-11.png"></a><br>
                                                         <a target="_blank" href="https://www.facebook.com/profile.php?id=100010440333169"><img  src="/images/fbb.png"></a>
                                                        <br>
                                                        
                                                        <a target="_blank" href="http://ok.ru/group/52465934467264"><img src="/images/2016-04-13_11-28-19.png" style="margin-left: -1px"></a>
                                                      
<br>
                                                     <p style="font-size:12px">Поделиться с друзьями:</p><script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,evernote,linkedin,lj,viber,whatsapp" data-size="s"></div>
                                                        </div>
                                                    </div> 
												</div>
											</div>
										</div>
									</td> 
									 <td style="top:-40px; position: relative; height: 180px" align="left"> 
										<table width="100%">
											<tbody>
                                           <center><a href="http://1090983.ru/news/news_s_2016_goda_u_nas_ploshchadki_iz_listvennitsy.html"><img src="http://1090983.ru/images/siber.jpg"></a>
                                           </center>
                                                
                                                
												<tr>
													<td style="vertical-align: middle;text-align: center;color: #27397D;font-weight;font-size: 25px;">Компания Самсон - производитель детских площадок и спортивных игровых комплексов.</td>
													<td width="20%" align="right" id="small-cart">
															<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "small", array("PATH_TO_BASKET" => "/personal/basket/", "PATH_TO_ORDER" => "/personal/order/", 'AJAX_MODE' => 'Y', 'AJAX_OPTION_JUMP' => 'N', 'AJAX_OPTION_HISTORY' => 'N', 'SHOW_CART' => $_REQUEST['show_cart']), false);?>
													</td>
												</tr>
											</tbody>
										</table> 	
									</td> 
								</tr> 
								<tr>	
									<td class="center" style="background-color: white;position:relative; padding-bottom:200px; top: -30px" valign="top" > 
										<div class="content<?if($green):?>g<?elseif($orange):?>y<?elseif($blue):?>b<?elseif($marp):?><?elseif($braun):?>cf<?elseif($grey):?>grayforwintergoods<?elseif($teal):?>contentforhomies<?else:?>bl<?endif?>">
											<? if ($APPLICATION->GetCurDir() != '/'): ?> 
												<?$APPLICATION->IncludeComponent("bitrix:news.list", "inner_slider", array(
	"IBLOCK_TYPE" => "Dop",
	"IBLOCK_ID" => "6",
	"NEWS_COUNT" => "1000",
	"SORT_BY1" => "ACTIVE_FROM",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "SORT",
	"SORT_ORDER2" => "ASC",
	"FILTER_NAME" => "",
	"FIELD_CODE" => array(
		0 => "DETAIL_PICTURE",
		1 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "LINK",
		1 => "",
	),
	"CHECK_DATES" => "Y",
	"DETAIL_URL" => "",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_FILTER" => "N",
	"CACHE_GROUPS" => "Y",
	"PREVIEW_TRUNCATE_LEN" => "",
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "N",
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
	"ADD_SECTIONS_CHAIN" => "N",
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"PARENT_SECTION" => "",
	"PARENT_SECTION_CODE" => "",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "N",
	"PAGER_TITLE" => "",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"DISPLAY_DATE" => "N",
	"DISPLAY_NAME" => "N",
	"DISPLAY_PICTURE" => "N",
	"DISPLAY_PREVIEW_TEXT" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>
											<?endif?>
<div id="scroller" class="b-top" style="display: none;"><span class="b-top-but">наверх</span></div>	