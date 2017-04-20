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

$IBLOCK_SECTION_ID_BREADCRUBS=$arResult['IBLOCK_SECTION_ID'];
$NAMEOFCATINMENU = "";
 if ($IBLOCK_SECTION_ID_BREADCRUBS) {
  $arFilter = array("IBLOCK_ID"=>$arResult['IBLOCK_ID'] , "ID"=>$IBLOCK_SECTION_ID_BREADCRUBS) ;
  $rsResult = CIBlockSection::GetList(array("SORT" => "ASC"), $arFilter  , false, $arSelect = array( "UF_*"));
  while ($ar = $rsResult -> GetNext()) { $NAMEOFCATINMENU.= $ar['UF_NAMEOFCATINMENU']; }
}
?>
<span><a href="/">Главная</a></span>
<span> -> </span>
<span><a href="/Netshop/<?=$section_id["CODE"]?>/"><?=$NAMEOFCATINMENU?></a></span>
<span> -> </span>
<span><?=$arResult["NAME"]?></span>
</p>
	
	<span><?=$arResult["NAME"]?></span></div>
<table>
<tbody><tr>

<? if($arResult["PROPERTIES"]["BUY_WITH_THIS_PRODUC"]["VALUE"]) { ?>
<td valign="top" style="padding-bottom: 50px;">
<? } else { ?>
<td valign="top" style="padding-bottom: 200px;">
<? } ?>

<?
$fileID = $arResult["DETAIL_PICTURE"]['ID'];
$big = CFile::ResizeImageGet($fileID, array('width' => 800, 'height' => 600));
$small = CFile::ResizeImageGet($fileID, array('width' => 302, 'height' => 264));
?>
<a rel="lightbox[1]" href="<?=$big['src']?>" title="<?=$arResult["NAME"]?>" class="lightbox-enabled">
<img  src="<?=$small['src']?>" alt="Орион - детская металлическая площадка"></a>

<? if($arResult["PROPERTIES"]["ADD_PHOTO_IN_DETAIL"]["VALUE"]) { ?>
	<div style="margin-top: 10px; padding-left: 15px">
<? } ?>
<? $count_col = 0; ?>
<? foreach ($arResult["PROPERTIES"]["ADD_PHOTO_IN_DETAIL"]["VALUE"] as $value) { ?>	
	<? 
		$count_col ++; 
		if ($count_col == 1) { echo '<div style="margin-top: 10px;">'; }
		$big = CFile::ResizeImageGet($value, array('width' => 800, 'height' => 600));
		$small = CFile::ResizeImageGet($value, array('width' => 110, 'height' => 100));
	?>
			<a style="text-decoration:none;" rel="lightbox[1]" href="<?=$big['src']?>" class="lightbox-enabled">
				<img  src="<?=$small['src']?>" style="border:1px solid #99CC00;float:left; margin:5px; padding:5px">
 			</a>
 	<?  
		if ($count_col == 3) { $count_col = 0; echo '</div>'; }
	?>
<? } ?>
<? if($arResult["PROPERTIES"]["ADD_PHOTO_IN_DETAIL"]["VALUE"]) { ?>
	</div>
<? } ?>


</td>

<? if($arResult["PROPERTIES"]["BUY_WITH_THIS_PRODUC"]["VALUE"]) { ?>
<td style="padding-left:30px;padding-bottom: 50px;"><div style="text-align:center; margin:0 0 15px 0;">
<? if($arResult["IBLOCK_SECTION_ID"] == 67) { ?>
	<? if($arResult["ID"] == 204){ ?>
		<div style="margin-top:28px;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 1200, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
<? } ?>
<? if($arResult["IBLOCK_SECTION_ID"] == 6) { ?>
	<? if($arResult["ID"] == 397){ ?>
		<div style="margin-top:28px;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 1200, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
<? } ?>

<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
<div style="margin-top:28px;">Цена: <span style="color:#e13626;font-size:14px;"><?if($arPrice["VALUE"]):?><s></s> <b><font size="+1"><? echo number_format( $arPrice["VALUE"], 0, ',', ' ' ); ?> руб.</font></b><?else:?>по запросу<?endif?></span></div>
<?endforeach;?>



<? $showbtn = 0; ?>
<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
<?if($arPrice["VALUE"]):?><? $showbtn = 1; ?><?endif?>
<?endforeach;?>

<?if($showbtn):?>
	<?if($arResult["SECTION"]["IBLOCK_SECTION_ID"] != '6'):?>
	<div valign="top" style="clear:both; margin-top: 20px">	
		<a href="<?=$APPLICATION->GetCurPage()?>?action=ADD2BASKET&id=<?=$arResult["ID"]?>"><img src="/images/buy.png"></a>
	</div>
	<?endif?>
	<?endif?>
</div>
<? } else { ?>
<td style="padding-left:30px;padding-bottom: 200px;"><div style="text-align:center; margin:0 0 15px 0;">
<? if($arResult["IBLOCK_SECTION_ID"] == 67) { ?>
	<? if($arResult["ID"] == 204){ ?>
		<div style="margin-top:28px;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 1200, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
<? } ?>
<? if($arResult["IBLOCK_SECTION_ID"] == 6) { ?>
	<? if($arResult["ID"] == 397){ ?>
		<div style="margin-top:28px;">Старая цена: <span style="color:#e13626;font-size:14px;"><s><font size="+1"><? echo number_format( 1200, 0, ',', ' ' ); ?> руб.</font></s></span></div>	
	<? } ?>
<? } ?>

<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
<div style="margin-top:28px;">Цена: <span style="color:#e13626;font-size:14px;"><?if($arPrice["VALUE"]):?><s></s> <b><font size="+1"><? echo number_format( $arPrice["VALUE"], 0, ',', ' ' ); ?> руб.</font></b><?else:?>по запросу<?endif?></span></div>
<?endforeach;?>



<? $showbtn = 0; ?>
<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
<?if($arPrice["VALUE"]):?><? $showbtn = 1; ?><?endif?>
<?endforeach;?>

<?if($showbtn):?>
	<?if($arResult["SECTION"]["IBLOCK_SECTION_ID"] != '6'):?>
	<div valign="top" style="clear:both; margin-top: 20px">	
		<a href="<?=$APPLICATION->GetCurPage()?>?action=ADD2BASKET&id=<?=$arResult["ID"]?>"><img src="/images/buy.png"></a>
	</div>
	<?endif?>
	<?endif?>
</div>
<? } ?>

<?=$arResult["DETAIL_TEXT"]?>

<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
<div style="float:right;" class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,gplus"></div> 
<br><br><br><br>


<?php /*?><div class="formofordering">    
	<form action="" method=post> 
 		<p style="font-weight: bold;font-size: 14px;" class="changecolor">Задать вопрос о "<?=$arResult["NAME"]?>"</p>
    <p><span >Имя (*)</span><br><input id="first_name_field" type="text" name="name" size="40"></p>
    <p><span >E-mail (*)</span><br><input id="email_field" type="text" name="email" size="40"></p>
    <p><span >Вопрос (*)</span><br><textarea id="commentaries_field"  name="commentaries" rows="6" cols="40"></textarea></p>         
    <p><input class="btnforodering" type="submit" onclick="javascript:return myValidator(jQuery(this).closest('form')[0]);" value="Отправить" name="submit"></p> 
		<p style="text-align:center;">поля отмеченные (*) - обязательны для заполнения</p>
</form> 
<?php 
// если была нажата кнопка "Отправить" 
if($_POST['submit']) { 
        $title = 'Вопрос с сайта www.1090983.ru'; 
        $mess .= '<html><head></head><body>';
        $mess .= '<p>'.$arResult["NAME"].'</p><p>Имя: '.$_POST['name'].'</p><p>E-mail: '.$_POST['email'].'</p><p>Вопрос: '.$_POST['commentaries'].'</p>';  
        $mess .= '</body></html>';
        
        $tmp = $mess;
        $mess = iconv("CP1251", "UTF-8", $tmp);
        
        $tmp = $title;
        $title = iconv("CP1251", "UTF-8", $tmp);
        
        $headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=UTF-8\r\n";
				$headers .= 'From:'.$_POST['email'];
        $to = 'info@samson.bz';  
        mail($to, $title, $mess, $headers); 
        echo '<p style="color:red;font-weight: bold;padding: 5px;text-align: center;">Благодарим вас за вопрос на нашем сайте!</p>'; 
} 
?> 
</div><?php */?>

</td>
</tr>


<? if($arResult["PROPERTIES"]["BUY_WITH_THIS_PRODUC"]["VALUE"]) { ?>
	<tr>
		<td colspan="2" style="text-align:center;">
			<p style="color:#2A3779; font-weight: bold; font-size: 25px; text-align:center;">С этим товаром покупают</p>
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






