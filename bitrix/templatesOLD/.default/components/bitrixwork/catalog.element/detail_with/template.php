<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<style>
	.error {color:red;}
</style>	
<script type="text/javascript" src="/js/jcarousellite.js"></script>
<script>
	$(function(){
		$(".box_for_gallery").jCarouselLite({
	  	btnNext: ".next",
		 	btnPrev: ".prev",
      visible: 4,
      scroll: 1,
		 	circular: true
		});
		
	if (jQuery('.box_for_gallery'). length > 0) {
		var gallery = jQuery('.box_for_gallery');
		gallery.find('.slide_of_product').css('height','auto');
		
		var max_height = 0;
		jQuery.each(gallery.find('.slide_of_product .slide_img'), function() {
			var h = jQuery(this).outerHeight();
			if (h > max_height) max_height = h;
		});
		gallery.find('.slide_of_product .slide_img').css('height', max_height + 'px');
		
		var max_height = 0;
		jQuery.each(gallery.find('.slide_of_product .slide_header'), function() {
			var h = jQuery(this).outerHeight();
			if (h > max_height) max_height = h;
		});
		gallery.find('.slide_of_product .slide_header').css('height', max_height + 'px');
		
		var max_height = 0;
		jQuery.each(gallery.find('.slide_of_product'), function() {
			var h = jQuery(this).outerHeight();
			if (h > max_height) max_height = h;
		});
		gallery.find('.slide_of_product').css('height', max_height-20 + 'px');
		
	}
  
  jQuery('.changecolor').css('color', jQuery('.navigate > p').next().css('color'));
  /*jQuery("#email_field").css("border","solid " + jQuery('.navigate span').css('color') + " 1px");
  jQuery("#first_name_field").css("border","solid " + jQuery('.navigate span').css('color') + " 1px");
  jQuery("#commentaries_field").css("border","solid " + jQuery('.navigate span').css('color') + " 1px");*/
  
  });
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script src="http://malsup.github.com/jquery.form.js"></script> 

<script type="text/javascript"> 
	jQuery.noConflict(); 
</script>
		
<script language="javascript">
    function myValidator(f, t)
    {
/*beginingscriptofvalidation*/
        jQuery("#email_field").css("border","solid black 1px");
  			jQuery("#first_name_field").css("border","solid black 1px");
  			jQuery("#commentaries_field").css("border","solid black 1px");
     		
     		jQuery(".error").hide();
        var hasError = false;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				var fioReg = /^[a-zA-Zа-яА-ЯёЁ ]{3,}$/;
				 
        var emailaddressVal = jQuery("#email_field").val();
        var firstnameVal = jQuery("#first_name_field").val();                
        var commentariesVal = jQuery("#commentaries_field").val();
        
        if (!commentariesVal) {
        		jQuery("#commentaries_field").after('<span class="error"><br>Введите Ваш вопрос.</span>');
            jQuery("#commentaries_field").css("border","solid red 1px");
            hasError = true;
        }
        
 
        if (firstnameVal){
        if(!fioReg.test(firstnameVal)) {
            jQuery("#first_name_field").after('<span class="error"><br>Введите корректное имя.</span>');
            jQuery("#first_name_field").css("border","solid red 1px");
            hasError = true;
        }} else {
        		jQuery("#first_name_field").after('<span class="error"><br>Введите Ваше имя.</span>');
            jQuery("#first_name_field").css("border","solid red 1px");
            hasError = true;
        	}
        	
                        
        if (emailaddressVal){
        if(!emailReg.test(emailaddressVal)) {
            jQuery("#email_field").after('<span class="error"><br>Введите корректный e-mail адрес.</span>');
            jQuery("#email_field").css("border","solid red 1px");
            hasError = true;
        }} else {
        		jQuery("#email_field").after('<span class="error"><br>Введите Ваш e-mail адрес.</span>');
            jQuery("#email_field").css("border","solid red 1px");
            hasError = true;
        	}
        	
/*endingscriptofvalidation*/        
        if (hasError == false) {
            return true;
        } 
        return false;
    }
</script>    


<div class="navigate">


<p class="line_for_breadcrumbs">
<?
$section_id = CIBlockSection::GetByID($arResult["IBLOCK_SECTION_ID"]);
$section_id = $section_id->GetNext();
$block_id = CIBlockSection::GetByID($section_id["IBLOCK_SECTION_ID"]);
$block_id = $block_id->GetNext();

$IBLOCK_SECTION_ID_BREADCRUBS=$section_id['IBLOCK_SECTION_ID'];
$NAMEOFCATINMENU = "";
  if ($IBLOCK_SECTION_ID_BREADCRUBS)
  {
      $arFilter = array("IBLOCK_ID"=>$arResult['IBLOCK_ID'] , "ID"=>$IBLOCK_SECTION_ID_BREADCRUBS) ; 
      $rsResult = CIBlockSection::GetList(array("SORT" => "ASC"), $arFilter  , false, $arSelect = array( "UF_*"));
      while ($ar = $rsResult -> GetNext()) { $NAMEOFCATINMENU.= $ar['UF_NAMEOFCATINMENU']; }
  }
?>

<? if($block_id["ID"] == 5) { ?>
<span><a href="/">Главная</a></span>
<span> -> </span>
<span><a href="/Netshop/<?=$block_id["CODE"]?>/"><?=$NAMEOFCATINMENU?></a></span>
<span> -> </span>
<span><a href="/Netshop/<?=$block_id["CODE"]?>/<?=$section_id["CODE"]?>/"><?=$section_id["NAME"]?></a></span>
<span> -> </span>
<span><?=$arResult["NAME"]?></span>
<? } else { ?>

<? if($block_id["ID"] == 109) { ?>
<span><a href="/">Главная</a></span>
<span> -> </span>
<span><a href="/Netshop/<?=$block_id["CODE"]?>/">Товары для сада и дачи</a></span>
<span> -> </span>
<span><a href="/Netshop/<?=$block_id["CODE"]?>/"><?=$section_id["NAME"]?></a></span>
<span> -> </span>
<span><?=$arResult["NAME"]?></span>
<? } else { ?>
<? if($block_id["ID"] == 3) { 
			if($section_id["CODE"] == 'mat' || $section_id["CODE"] == 'ka'){	
?>
			<span><a href="/">Главная</a></span>
			<span> -> </span>
			<span><a href="/Netshop/<?=$block_id["CODE"]?>/"><?=$NAMEOFCATINMENU?></a></span>
			<span> -> </span>
			<span><a href="/Netshop/<?=$block_id["CODE"]?>/<?=$section_id["CODE"]?>/"><?=$section_id["NAME"]?></a></span>
			<span> -> </span>
			<span><?=$arResult["NAME"]?></span>
<? }} else { ?>

	<span><a href="/">Главная</a></span>
	<span> -> </span>
	<span><a href="/Netshop/<?=$block_id["CODE"]?>/"><?=$NAMEOFCATINMENU?></a></span>
	<span> -> </span>
	<span><?=$arResult["NAME"]?></span>
<? } ?><? } ?>
<? } ?>
</p>	



<span><?=$arResult["NAME"]?></span></div>
<table>
<tbody><tr>
<? if($arResult["PROPERTIES"]["BUY_WITH_THIS_PRODUC"]["VALUE"]) { ?>
<td valign="top" style="padding-bottom: 50px;">
<? } else { ?>
<td valign="top">
<? } ?>
<?
//$fileID = $arResult["MORE_PHOTO"][0] ? $arResult["MORE_PHOTO"][0]['ID'] : $arResult["DETAIL_PICTURE"]['ID'];
$fileID = $arResult["DETAIL_PICTURE"]['ID'];
$big = CFile::ResizeImageGet($fileID, array('width' => 800, 'height' => 600));
$small = CFile::ResizeImageGet($fileID, array('width' => 302, 'height' => 264));
?>
<a rel="lightbox[1]" href="<?=$big['src']?>" title="<?=$arResult["NAME"]?>" class="lightbox-enabled">
<img style="width:200px" src="<?=$small['src']?>" alt="<?=$arResult["NAME"]?>"></a>


<? if($arResult["PROPERTIES"]["ADD_PHOTO_IN_DETAIL"]["VALUE"]) { ?>
	<div style="margin-top: 10px;">
<? } ?>
<? $count_col = 0; ?>
<? foreach ($arResult["PROPERTIES"]["ADD_PHOTO_IN_DETAIL"]["VALUE"] as $value) { ?>	
	<? 
		$count_col ++; 
		if ($count_col == 1) { echo '<div style="margin-top: 10px;">'; }
		$big = CFile::ResizeImageGet($value, array('width' => 800, 'height' => 600));
		$small = CFile::ResizeImageGet($value, array('width' => 110, 'height' => 100));
	?>
			<a style="text-decoration:none;padding:5px;background-image: none;" rel="lightbox[1]" href="<?=$big['src']?>" class="lightbox-enabled">
				<img src="<?=$small['src']?>" border="0">
 			</a>
 	<?  
		if ($count_col == 3) { $count_col = 0; echo '</div>'; }
	?>
<? } ?>
<? if($arResult["PROPERTIES"]["ADD_PHOTO_IN_DETAIL"]["VALUE"]) { ?>
	</div>
<? } ?>



	
<?
		$arSelect = Array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "CATALOG_GROUP_1");
		$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$arResult["IBLOCK_SECTION_ID"], "!ID"=>$arResult["ID"]);
		$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
		
		if($res->SelectedRowsCount() > 0) {
		?>
			<div style="text-align:left">
			<br><br><b style="color:#ca4c9b">Варианты товара</b><br>
			<table width="100%" style="border-collapse:collapse; clear:both;">
			  <tbody>
				<?  
				while($ob = $res->GetNextElement())
				{
				  $arFields = $ob->GetFields();
				  $sres = CIBlockSection::GetByID($arResult["IBLOCK_SECTION_ID"]);
				  $parent = $sres->GetNext();
				  $mres = CIBlockSection::GetByID($parent["IBLOCK_SECTION_ID"]);
				  $main = $mres->GetNext();
				  //var_dump($arFields);
				  ?>
				  <tr>
				  <td width="60%" height="15" style="padding:5px" nowrap="">
				   <a href="/Netshop/<?=$main["CODE"]?>/<?=$parent["CODE"]?>/<?=$arFields["CODE"]?>.html"><?=$arFields["NAME"]?></a>
				  </td>
				  <td class="cellforprice" width="15%" align="right" nowrap="" style="padding:5px;color:#e13626;font-weight:bold"> 
	
<? if($arFields["CODE"] != 'ka_64') { ?>

					<?if(intval($arFields["CATALOG_PRICE_1"])):?><?=intval($arFields["CATALOG_PRICE_1"])?>&nbsp;руб.<?endif?>
<? } ?>
					
				  </td>
				  <td>&nbsp;</td>
				  <td align="right" width="1%" nowrap="">    
				  </td>
				</tr>
				 <?
				}?>
			  </tbody>
			</table>
			</div>
		<?
		}
?>
  


  
</td>




<td valign="top" style="padding-left:30px;padding-bottom: 50px;">

<? if(($block_id["ID"] == 3) && ($arResult["IBLOCK_SECTION_ID"] == 25) && ($arResult["ID"] == 54)) { ?>
	<div style=" text-align:center">Цена: <span style="color:#e13626;font-size:14px;">по запросу</span></div>	
<? } ?>



	
	<? if($arResult["IBLOCK_SECTION_ID"] == 99){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 64000, 0, ',', ' ' ); ?> руб</font></s><br><br>АКЦИЯ! Только с 1 по 31 августа 30% скидка!</span></div>	
	<? } ?>
    	<? if($arResult["IBLOCK_SECTION_ID"] == 100){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 76400, 0, ',', ' ' ); ?> руб</font></s><br><br>АКЦИЯ! Только с 1 по 31 августа 30% скидка!</span></div>	
	<? } ?>
    	<? if($arResult["IBLOCK_SECTION_ID"] == 101){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 99900, 0, ',', ' ' ); ?> руб</font></s><br><br>АКЦИЯ! Только с 1 по 31 августа 30% скидка!</span></div>	
	<? } ?>
    	
<? if($block_id["ID"] == 2) { ?>

	
	<?php /*?><? if($arResult["IBLOCK_SECTION_ID"] == 96){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 76000, 0, ',', ' ' ); ?> руб</font></s><br>На первые 20 площадок скидка 10%.</span></div>	
	<? } ?><?php */?>
	<? if($arResult["IBLOCK_SECTION_ID"] == 99){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 48700, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
	<!--
	<? if($arResult["IBLOCK_SECTION_ID"] == 69){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 48700, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
	<? if($arResult["IBLOCK_SECTION_ID"] == 70){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 39900, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
	<? if($arResult["IBLOCK_SECTION_ID"] == 71){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 46900, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
	<? if($arResult["IBLOCK_SECTION_ID"] == 72){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 46300, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
	<? if($arResult["IBLOCK_SECTION_ID"] == 73){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 33750, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
	<? if($arResult["IBLOCK_SECTION_ID"] == 74){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 26500, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
	<? if($arResult["IBLOCK_SECTION_ID"] == 75){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 46400, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
	<? if($arResult["IBLOCK_SECTION_ID"] == 76){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 5900, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
	<? if($arResult["IBLOCK_SECTION_ID"] == 78){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 2900, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
	-->
	
<? } ?>



<? if(($arResult["ID"] != 54)) { ?>


<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="color:#e13626;font-size:14px;"><?if($arPrice["VALUE"]):?><s></s> <b><font size="+1"><? echo number_format( $arPrice["VALUE"], 0, ',', ' ' ); ?> руб.</font></b><?else:?>по запросу<?endif?></span></div>
<?endforeach;?>



<? $showbtn = 0; ?>
<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
<?if($arPrice["VALUE"]):?><? $showbtn = 1; ?><?endif?>
<?endforeach;?>
	
	<?if($showbtn):?>
	
	<div align="center" style="clear:both; margin-top: 20px; margin-bottom: 20px; ">	
		<a href="<?=$APPLICATION->GetCurPage()?>?action=ADD2BASKET&id=<?=$arResult["ID"]?>" class="add2cart" data-id="<?=$arResult['ID']?>"><img src="/images/buy.png"></a>
	</div>
	
	<?endif?>

<? } else { ?>
<td style="padding-left:30px;padding-bottom: 200px;">
<? } ?>
<?=$arResult["DETAIL_TEXT"]?>

<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
<div style="float:right;" class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,gplus"></div> 
<br><br><br><br>

	

</td>
</tr>

<? if($arResult["PROPERTIES"]["BUY_WITH_THIS_PRODUC"]["VALUE"]) { ?>
	<tr>
		<td colspan="3" style="text-align:center; margin:0 0 15px 0;">
			<p style="color:#2A3779; font-weight: bold; font-size: 25px; text-align:center; margin:0 0 15px 0;">С этим товаром покупают</p>
			<div style="display: inline-block;  vertical-align: middle;">
				<? 
					$count_products = 0;
					foreach ($arResult["PROPERTIES"]["BUY_WITH_THIS_PRODUC"]["VALUE"] as $value) {
						$count_products ++;	
					}
				?>
				<? if($count_products > 4) { ?>
					<span class="prev" style="float:left;"></span>             
					<span class="next" style="float:right;"></span>
				<? } ?>
				<div class="box_for_gallery">	
					<ul class="container_for_slides">
						<? foreach ($arResult["PROPERTIES"]["BUY_WITH_THIS_PRODUC"]["VALUE"] as $value) {
							$res = CIBlockElement::GetByID($value);
							$res = $res->GetNext();
							$res_cat = CIBlockSection::GetByID($res["IBLOCK_SECTION_ID"]);
							$res_cat = $res_cat->GetNext();	
							$res_first_level = CIBlockSection::GetByID($res_cat["IBLOCK_ID"]);
							$res_first_level = $res_first_level->GetNext();							
							$get_prd = GetCatalogProduct($value);						
							$get_prd_price = GetCatalogProductPriceList($get_prd["ID"]);
						?>
						<li class="slide_of_product">
							<div class="slide_img">
								<div class="slide_img_inside">
									
									<a href="/Netshop/<?=$res_first_level["CODE"]?>/<?=$res_cat["CODE"]?>/<?=$res["CODE"]?>.html">
										<? echo CFile::ShowImage($res["DETAIL_PICTURE"], 100, 100, "border=0", "", false); ?>
									</a>
								
							</div>
							</div>
							<div class="slide_header">
								<div class="slide_header_inside">
									
									
									<a href="/Netshop/<?=$res_first_level["CODE"]?>/<?=$res_cat["CODE"]?>/<?=$res["CODE"]?>.html">
										<? echo $res["NAME"]; ?>
									</a>
								</div>
							</div>
							<p><span>Цена: <span style="color:#e13626;font-weight:bold;"><? echo number_format( $get_prd_price["0"]["PRICE"], 0, ',', ' ' ); ?> руб.</span></span></p>
						</li>
						<? } ?>
					</ul>
				</div>
			</div>
		</td>
	</tr>
<? } ?>

</tbody></table>
<div style="clear:both"></div>






