<!DOCTYPE HTML>
<html lang="ru-RU">
	<head> 
		<meta name="yandex-verification" content="5be335d276d1de8e">
		<meta http-equiv="content-type" content="text/html; charset=windows-1251">
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
		<script type="text/javascript" src="/js/main_page.js"></script>	
		<script type="text/javascript" src="/js/script.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'] . '/js/script.js')?>"></script>
        
		<link type="text/css" rel="stylesheet" media="screen" href="/js/jquery.lightbox.css" id="lightbox-stylesheet-lightbox">
	</head> 
	<body> 
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
										<a  href="/"><img style="padding-right: 0" align="right" width="279" src="/images/logo_winter2.jpg" ></a>	
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
											</tbody>
										</table> 	
									</td> 		
								</tr> 
								<tr class="change_height"> 
									<td class="lefttd" rowspan="2" align="center" valign="top" style="vertical-align:top;">
										<div style="color:#263b81;font-size:12px;text-align:center;">
											<i>
												<div style="color:#27397D;font-size:22px;text-align:center;vertical-align:top;"><span style="font-size:13px;vertical-align:top;"></span> +7 (495) 769-00-12</div>
												<?php /*?><div style="color:#27397D;font-size:22px;text-align:center;vertical-align:top;"><span style="font-size:13px;vertical-align:top;"></span>+7 (495) 979-09-83</div><?php */?>
												<div style="color:#27397d;text-align:right;vertical-align:top;margin-right:45px;" class="all_contacts"><span style="font-size:13px;vertical-align:top;">info@samson.bz</span></div>
                                                <?php /*?><div style="color:#27397d;font-size:20px;text-align:right;vertical-align:top;margin-right:45px;" class="all_contacts"><span style="font-size:13px;vertical-align:top;">c 8 до 17 (обед с 12 до 13)</span></div><?php */?>
                                                
												<div style="color:#27397d;font-size:22px;text-align:right;vertical-align:top;margin-right:45px;" class="all_contacts"><span style="font-size:13px;vertical-align:top;"><a href="/kontakts/" style="color:#27397D;">Все контакты</a></span></div>
											</i>
										</div>
										<div align="left" style="padding-top:0px;">
					 						<div class="leftmenu">
					 							<?CModule::IncludeModule("iblock");?>
					 							<div class="level_1_yellow">
					 								<div class="rumb">
					 									<a href="/Netshop/derevostreet/"><b>Детские игровые деревянные площадки для дачи (ДИП)</b></a>
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
														{
															echo "<div class=\"hr\"></div>";
															echo "</div>";
															echo "<div class=\"items\">";
															$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>2);
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
																	echo "<a href=\"/Netshop/derevostreet/".$ar_result["CODE"]."/".$arFields["CODE"].".html\">".$ar_result["NAME"]."</a><br>";
																}
															}
														}
														?> 									
					 								</div>
					 							</div>
												<div class="level_1_red">
						 							<div class="rumb">
						 								<a href="/Netshop/matlal/"><b>Детские металлические спортивно-игровые комплексы для дома (ДСК)</b></a>
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
					 									<a href="/Netshop/metalstreet/"><b>Детские металлические спортивно-игровые площадки для улицы (УДСК)</b></a>
					 									<?
														if($APPLICATION->GetCurDir()=="/Netshop/metalstreet/") $green=true;
														if($_GET["CODE"]) {
															$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>1, "CODE"=>$_GET["CODE"]));
															if($res->SelectedRowsCount() > 0) $green=true;
														}

														if($green)
														{
																echo "<div class=\"hr\"></div>";
																echo "</div>";
																echo "<div class=\"items\">";
															$arSelect = Array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "EXTERNAL_ID");
															$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>1);
															$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
															while($ob = $res->GetNextElement())
															{
																$arFields = $ob->GetFields();
																if($arFields["CODE"]==$_GET["CODE"])
																	echo "<span>".$arFields["NAME"]."</span><br>";
																else
																	echo "<a href=\"/Netshop/metalstreet/".$arFields["CODE"]."/".$arFields["CODE"]."_".$arFields["EXTERNAL_ID"].".html\">".$arFields["NAME"]."</a><br>";
															}
														}
					 									?>
					 								</div>
					 							</div>
					 							<div class="level_1_blue">
					 								<div class="rumb">
					 									<a href="/Netshop/dop/"><b>Дополнительное спортивно-игровое оборудование для детей</b></a>
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
						 								<a href="/Netshop/zima/"><b>Зимние игровые деревянные горки</b></a>
					 									<?
														if($APPLICATION->GetCurDir()=="/Netshop/zima/") $grey=true;
													 	if($_GET["CODE"]) {
													 		$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>Array(6,119), "INCLUDE_SUBSECTIONS"=>"Y", "CODE"=>$_GET["CODE"]));
													 		if($res->SelectedRowsCount() > 0) {
																$grey=true;
														 		$ob = $res->GetNextElement();
																$arFields = $ob->GetFields();
														 		$res = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
																if($ar_res = $res->GetNext())
																	$section_id=$ar_res['ID'];
													 		}
													 	}
														if($grey)
														{
															echo "<div class=\"hr\"></div>";
															echo "</div>";
															echo "<div class=\"items\">";
															$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>6);
															$sres = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, true);
															while($ar_result = $sres->GetNext())
															{
																//echo $ar_result["ID"]." ".$section_id;
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
																	if($ar_result["CODE"] != "podzakaz"){
																		echo "<a href=\"/Netshop/zima/".$ar_result["CODE"]."/".$arFields["CODE"].".html\">".$ar_result["NAME"]."</a><br>";
																	} else {
																			echo "<a href=\"/Netshop/zima/podzakaz/\">".$ar_result["NAME"]."</a><br>";
																		}
																}
															}
														}
														?>	 								
						 							</div>
						 						</div>
					 							
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
						 						</div>
					 							
					 					
						 						
						 						<!--<div class="level_1_forhomies">
						 							<div class="rumb">
														<a href="/Netshop/domikoizkartonadlyatvorchestva/"><b>Домики из картона для игр и творчества</b></a>
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
												</div>			-->
												
						 					
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
						 							<?endif?>
							 					</div>
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
							 					<div class="listofnews_in_leftblock">
							 						
							 						<div style="	color: #999; " href="/news/">Последние новости:</div>
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
												<?$APPLICATION->IncludeComponent("bitrix:search.form","",Array(
														"USE_SUGGEST" => "N",
														"PAGE" => "#SITE_DIR#search/index.php"
													)
												);?> 
												<div style="color: black;font-size: 15px;font-style: italic;"> 
													<p style="text-decoration: underline;font-weight: bold;">Розничные продажи:</p>
													<p>часы работы: с 8-00 до 17-00</p>
													<p>+7(495) 769-00-12</p>
													<?php /*?><p>+7(495) 979-09-83 офис</p><?php */?>
													<p>почта: info@samson.bz</p>
													
													<div style="color: black;font-style: italic;font-size: 15px;"> 
													  <p style="text-decoration: underline;font-weight: bold;">Оптовые продажи:</p>
														<p>часы работы: с <span __postbox-detected-content="__postbox-detected-date">8-00</span> до 17-00</p>
														<p>+7(985) 922-85-28 Иван
													  </p>
														<p>+7(985) 920-18-71 Анна</p>
														<p>+7(985) 769-02-10 Татьяна</p>
              <br>                                           
                                                        <p><a target="_blank" href="http://vk.com/samson_company"><img  src="http://www.1090983.ru/images/social_link_vk.png"></a></p>
                                                    </div>
												</div>
											</div>
										</div>
									</td> 
									<td align="left"> 
										<table width="100%">
											<tbody>
												<tr>
													<td style="vertical-align: middle;text-align: center;color: #27397D;font-weight;font-size: 25px;"> 	
														Компания Самсон - производитель детских площадок и спортивных игровых комплексов.
													</td>
													<td width="20%" align="right" id="small-cart">
															<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "small", array("PATH_TO_BASKET" => "/personal/basket/", "PATH_TO_ORDER" => "/personal/order/", 'AJAX_MODE' => 'Y', 'AJAX_OPTION_JUMP' => 'N', 'AJAX_OPTION_HISTORY' => 'N', 'SHOW_CART' => $_REQUEST['show_cart']), false);?>
													</td>
												</tr>
											</tbody>
										</table> 	
									</td> 
								</tr> 
								<tr>	
									<td class="center" style="background-color: white;" valign="top"> 
										<div class="content<?if($green):?>g<?elseif($orange):?>y<?elseif($blue):?>b<?elseif($marp):?><?elseif($braun):?>cf<?elseif($grey):?>grayforwintergoods<?elseif($teal):?>contentforhomies<?else:?>bl<?endif?>">
											<? if ($APPLICATION->GetCurDir() != '/'): ?> 
												<?$APPLICATION->IncludeComponent(
													"bitrix:news.list",
													"inner_slider",
													Array(
														"IBLOCK_TYPE" => "Dop",
														"IBLOCK_ID" => "6",
														"NEWS_COUNT" => "1000",
														"SORT_BY1" => "ACTIVE_FROM",
														"SORT_ORDER1" => "DESC",
														"SORT_BY2" => "SORT",
														"SORT_ORDER2" => "ASC",
														"FILTER_NAME" => "",
														"FIELD_CODE" => array(0=>"DETAIL_PICTURE",1=>"",),
														"PROPERTY_CODE" => array(0=>"LINK",1=>"",),
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
													)
												);?>
											<?endif?>
											
<!DOCTYPE HTML>