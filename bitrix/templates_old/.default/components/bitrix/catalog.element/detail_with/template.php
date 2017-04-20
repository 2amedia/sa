<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<style>
	.error {color:red;}
</style>	


<link rel="stylesheet" href="/js/reveal.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
<script src="http://test.1090983.ru/js/jquery.reveal.js" type="text/javascript"></script>

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
    
    jQuery(function(){
    	var str = location.pathname;
			if(str.indexOf('/Netshop/zima/podzakaz/') + 1) {
				var html = "";
				jQuery('.varianti_tovarov_list tr').each(function(){
					if(location.pathname != jQuery(this).find('a').attr('href')){
						html = html + "<br/><a class='linkswithoutmarker' href='" + jQuery(this).find('a').attr('href') + "'>" + jQuery(this).find('a').html() + "</a>";
					} else {
						html = html + "<br/><span class='linkswithoutmarker' style='background-image: none;' >" + jQuery(this).find('a').html() + "</span>";	
					}
				});
				jQuery('.grayforwintergoods').replaceWith('<div class="grayforwintergoods"><div class="rumb"><a href="/Netshop/zima/"><b>Зимние игровые деревянные горки</b></a><div class="hr"></div></div><div class="items"><a href="/Netshop/zima/green/greenland.html">Горка "Гренландия"</a><br><a href="/Netshop/zima/island/island.html">Горка "Исландия"</a><br><a href="/Netshop/zima/yamal/yamal_el.html">Горка "Ямал"</a><br><a href="/Netshop/zima/Ural/Ural.html">Горка "Урал"</a><br><span>Под заказ</span>' + html + '</div></div>');	
			}
    });
    
</script>   



<div class="navigate">

<p class="line_for_breadcrumbs">
<span><a href="/">Главная</a></span>
<span> -> </span>
<span><a href="/Netshop/<?=$arResult["SECTION"]['PATH'][0]['CODE'];?>/"><?=$arResult["SECTION"]['PATH'][0]['NAME'];?></a></span>
<span> -> </span>
<span><?=$arResult["NAME"]?></span>	
</p>

</div>
<table>
<tbody><tr>



<? if($arResult["PROPERTIES"]["BUY_WITH_THIS_PRODUC"]["VALUE"]) { ?>
<td valign="top" style="padding-bottom: 50px;">
<? } else { ?>
<td valign="top" style="text-align: center;">
<? } ?>
<?
//$fileID = $arResult["MORE_PHOTO"][0] ? $arResult["MORE_PHOTO"][0]['ID'] : $arResult["DETAIL_PICTURE"]['ID'];
$fileID = $arResult["DETAIL_PICTURE"]['ID'];
$arFilters = Array(
    array("name" => "watermark", "position" => "topleft", "size"=>"real", "file"=>$_SERVER['DOCUMENT_ROOT']."/upload/watermark/800_600.png")
);
$big = CFile::ResizeImageGet($fileID, array('width' => 800, 'height' => 600),BX_RESIZE_IMAGE_PROPORTIONAL_ALT,false,$arFilters);
$arFilters_s = Array(
    array("name" => "watermark", "position" => "topleft", "size"=>"real", "file"=>$_SERVER['DOCUMENT_ROOT']."/upload/watermark/302_264.png")
);
$small = CFile::ResizeImageGet($fileID, array('width' => 302, 'height' => 264),BX_RESIZE_IMAGE_PROPORTIONAL_ALT,false,$arFilters_s);
?>
<a rel="lightbox[1]" href="<?=$big['src']?>" title="<?=$arResult["NAME"]?>" class="lightbox-enabled">
<img src="<?=$small['src']?>" alt="<?=$arResult["NAME"]?>"></a>


<? if($arResult["PROPERTIES"]["ADD_PHOTO_IN_DETAIL"]["VALUE"]) { ?>
	<table width="100%" style="margin-top:10px;border-collapse: initial;border-spacing: 10px;">
<? } ?>
<? $count_col = 0; ?>
<? foreach ($arResult["PROPERTIES"]["ADD_PHOTO_IN_DETAIL"]["VALUE"] as $value) { ?>	
	<? 
		$count_col ++; 
		if ($count_col == 1) { echo '<tr>'; }
		$arFilters = Array(
    array("name" => "watermark", "position" => "topleft", "size"=>"real", "file"=>$_SERVER['DOCUMENT_ROOT']."/upload/watermark/800_600.png")
);
		$big = CFile::ResizeImageGet($value, array('width' => 800, 'height' => 600),BX_RESIZE_IMAGE_PROPORTIONAL_ALT,false,$arFilters);
$arFilters_ss = Array(
    array("name" => "watermark", "position" => "topleft", "size"=>"real", "file"=>$_SERVER['DOCUMENT_ROOT']."/upload/watermark/70_70.png")
);
		$small = CFile::ResizeImageGet($value, array('width' => 70, 'height' => 70), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true,$arFilters_ss);
	?>
			<td style="text-align:center;border: 1px solid #CCCCCC;padding: 5px;"><a style="text-decoration:none;padding:5px;background-image: none;" title="<?=$arResult["NAME"]?>" rel="lightbox[1]" href="<?=$big['src']?>" class="lightbox-enabled">
				<img src="<?=$small['src']?>" border="0" class="test">
 			</a>
 			</td>
 	<?  
		if ($count_col == 2) { $count_col = 0; echo '</tr>'; }
	?>
<? } ?>
<? if($arResult["PROPERTIES"]["ADD_PHOTO_IN_DETAIL"]["VALUE"]) { ?>
	</table>
<? } ?>


<?
		$arSelect = Array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "CATALOG_GROUP_1");
		$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$arResult["IBLOCK_SECTION_ID"]);
		$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
		
		if($res->SelectedRowsCount()-1 > 0) {
		?>
			<div style="text-align:left">
			<br><br><b style="color:#ca4c9b">Варианты товара</b><br>
			<table class="varianti_tovarov_list" width="100%" style="border-collapse:collapse; clear:both;">
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
				  <tr <?if($arResult["ID"] == $arFields["ID"]):?>style="display:none;"<?endif?> >
				  <td width="60%" height="15" style="padding:5px" nowrap="">
				  
		<? $put=$APPLICATION->sDirPath;?>
		<?$pieces = explode("/", $put);?>
		<a href="/<?=$pieces[1];?>/<?=$pieces[2];?>/<?=$arSection["CODE"]?>/<?=$url?>.html" style="display:block;">
		
				   <a href="/<?=$pieces[1];?>/<?=$pieces[2];?>/<?=$parent["CODE"]?>/<?=$arFields["CODE"]?>.html"><?=$arFields["NAME"]?></a>
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
	<div style=" text-align:center">Цена: <span style="font-size:12px;">по запросу</span></div>	
<? } ?>

  <?php /*?>  <? if($arResult["IBLOCK_SECTION_ID"] == 68){ ?>
		<div style="text-align:center; margin:0 0 15px 0"><font size="+1"><span style="color:#e13626;">Акция:</span> Рукоход в подарок!</font></span></div>	
	<? } ?><?php */?>


    
    <?php /*?><? if($arResult["IBLOCK_SECTION_ID"] == 163){ ?>
		<div style="text-align:center; margin:0 0 15px 0"><font size="+1">Ожидается поступление</font></span></div>	
	<? } ?>
    
    <? if($PRODUCT_ID_1 == 64){ ?>
		<div style="text-align:center; margin:0 0 15px 0"><font size="+1">Ожидается поступление</font></span></div>	
	<? } ?>
    
    <? if (CSite::InDir("/Netshop/dop/shturval/shturval_78.html")){
        ?><div style="text-align:center; margin:0 0 15px 0"><font size="+1">Ожидается поступление</font></span></div>	<?
}
?><?php */?>
   

	
	<?php /*?><? if($arResult["IBLOCK_SECTION_ID"] == 99){ ?>
		<div style="text-align:center; margin:0 0 15px 0">Цена: <span style="font-size:12px;"><s><font size="+1"><? echo number_format( 64000, 0, ',', ' ' ); ?> руб</font></s><br><br>АКЦИЯ! Только с 1 по 31 августа 30% скидка!</span></div>	
	<? } ?>
    	<? if($arResult["IBLOCK_SECTION_ID"] == 100){ ?>
		<div style="text-align:center; margin:0 0 15px 0">Цена: <span style="font-size:12px;"><s><font size="+1"><? echo number_format( 76400, 0, ',', ' ' ); ?> руб</font></s><br><br>АКЦИЯ! Только с 1 по 31 августа 30% скидка!</span></div>	
	<? } ?>
    	<? if($arResult["IBLOCK_SECTION_ID"] == 101){ ?>
		<div style="text-align:center; margin:0 0 15px 0">Цена: <span style="font-size:12px;"><s><font size="+1"><? echo number_format( 99900, 0, ',', ' ' ); ?> руб</font></s><br><br>АКЦИЯ! Только с 1 по 31 августа 30% скидка!</span></div>	
	<? } ?><?php */?>
    	
<? if($block_id["ID"] == 2) { ?>

<?php /*?>
		
<? if($arResult["IBLOCK_SECTION_ID"] == 48){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 255000, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 10%</b></font></span></div>	
	<? } ?>

	<? if($arResult["IBLOCK_SECTION_ID"] == 70){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 40250, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>

<? if($arResult["IBLOCK_SECTION_ID"] == 73){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 33750, 0, ',', ' ' ); ?> руб.</font></s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>
	<? } ?>
    
	<? if($arResult["IBLOCK_SECTION_ID"] == 99){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 48700, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>
	
	<? if($arResult["IBLOCK_SECTION_ID"] == 69){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 55100, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
       
	<? } ?>
    
    	<? if($arResult["IBLOCK_SECTION_ID"] == 72){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 51000, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>
    
       	<? if($arResult["IBLOCK_SECTION_ID"] == 68){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 44000, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>

	<? if($arResult["IBLOCK_SECTION_ID"] == 83){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 22000, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>
    
    	<? if($arResult["IBLOCK_SECTION_ID"] == 74){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 27500, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>
    
	<? if($arResult["IBLOCK_SECTION_ID"] == 71){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 46900, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>

	<? if($arResult["IBLOCK_SECTION_ID"] == 96){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 76000, 0, ',', ' ' ); ?> руб</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>
    
   	<? if($arResult["IBLOCK_SECTION_ID"] == 121){ ?>
			<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 16500, 0, ',', ' ' ); ?> руб</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>
	
 

	<? if($arResult["IBLOCK_SECTION_ID"] == 76){ ?>
		<div style="text-align:center; margin:0 0 15px 0;"><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>

	<?php */?>

<? } ?>
<? if($block_id["ID"] == 6) { ?>

	<?php /*?>	<? if($arResult["IBLOCK_SECTION_ID"] == 101){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 99900, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>
    <? if($arResult["IBLOCK_SECTION_ID"] == 100){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 76400, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>
    <? if($arResult["IBLOCK_SECTION_ID"] == 99){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 76400, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?>
    <? if($arResult["IBLOCK_SECTION_ID"] == 120){ ?>
		<div style="text-align:center; margin:0 0 15px 0;">Цена: <span style="font-size:12px;"><s><? echo number_format( 56000, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ!<br /> скидка 15%</b></font></span></div>	
	<? } ?><?php */?>
  
  
	<? } ?>

<? if(($arResult["ID"] != 54)) { ?>


<div class="contentnames"> 
<span class="name_span" ><?=$arResult["SECTION"]['PATH'][0]['NAME'];?></span><br>
<span class="name_main" ><?=$arResult["NAME"]?></span>
</div>

<?if (CSite::InDir('/Netshop/derevostreet/')){?>
<div  class="history">
<a href="#" data-reveal-id="myModal" >Географическое название</a>
</div>

<div id="myModal" class="reveal-modal">
<div style=" margin-top: -250px !important;">
<div class="content-history-top"></div>
<div class="content-history">
     <div class="content-text">
     <i>Много интересного на земном шаре! Путешествуйте с нами! Мы дали нашим детским деревянным игровым площадкам географические названия.</i>
     <p><?=htmlspecialcharsBack($arResult["PROPERTIES"]["TEXT_HISTORYIMP"]["VALUE"]["TEXT"])?></p>
     </div>
     <a class="close-reveal-modal"></a>
</div>
</div>
</div>
<? } ?>

<?if (CSite::InDir('/Netshop/sad/')){?>
<div class="history">
<a href="#">Это интересно!</a>
</div>
<? } ?>

<?if (CSite::InDir('/Netshop/choice/matlal/')){?>
<div class="history">
<a href="#" data-reveal-id="myModal">Спорт-это настроение!</a>
</div>

<div id="myModal" class="reveal-modal">
<div style=" margin-top: -250px !important;">
<div class="content-history-top"></div>
<div class="content-history">
     <div class="content-text">
    <i>Шведская стенка &mdash; гимнастический снаряд из вертикальных стоек с поперечными округлыми перекладинами (лестница). Изобретателем шведской стенки в её нынешнем виде стал в начале 19 века П. Линг. Подобные снаряды и упражнения с их использованием описывались ещё в 1793 году немецким педагогом И. Гутс-Мутс в его труде &laquo;Гимнастика для юношества&raquo;. В России этот товар выпускался под названием &ldquo;Детский спортивный комплекс (ДСК) “Юниор&rdquo; («Юниор», «Чемпион» и др.). НП предприятием «Калужский приборостроительный завод «Тайфун» с 1992 года.</i>
     <p><?=htmlspecialcharsBack($arResult["PROPERTIES"]["TEXT_HISTORYIMP"]["VALUE"]["TEXT"])?></p>
     </div>
     <a class="close-reveal-modal"></a>
</div>
</div>
</div>
<? } ?>

<?if (CSite::InDir('/Netshop/choice/metalstreet/')){?>
<div class="history">
<a href="#" data-reveal-id="myModal">Спорт-это настроение!</a>
</div>

<div id="myModal" class="reveal-modal">
<div style=" margin-top: -250px !important;">
<div class="content-history-top"></div>
<div class="content-history">
     <div class="content-text">
    
     <p><?=htmlspecialcharsBack($arResult["PROPERTIES"]["TEXT_HISTORYIMP"]["VALUE"]["TEXT"])?></p>
     </div>
     <a class="close-reveal-modal"></a>
</div>
</div>
</div>
<? } ?>

<?if (CSite::InDir('/Netshop/zima/')){?>
<div class="history">
<a href="#">Географическое название</a>
</div>
<? } ?>

<?if (CSite::InDir('/Netshop/cube/')){?>
<div  class="history">
<a href="#" data-reveal-id="myModal-1" >Как используют КУБ?</a>
</div>

<div id="myModal-1" class="reveal-modal">
<div style=" margin-top: -250px !important;">
<div class="content-history-top"></div>
<div class="content-history">
     <div class="content-text">
     <i>КУБ - открывает широкие возможности по созданию уникального индивидуального интерьера для Вас. </i>
     <p><?=htmlspecialcharsBack($arResult["PROPERTIES"]["TEXT_HISTORYIMP"]["VALUE"]["TEXT"])?></p>
     </div>
     <a class="close-reveal-modal"></a>
</div>
</div>
</div>
<? } ?>

<div class="clearfix"></div>

<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
<div class="clearfix" style="text-align: left; margin:0 0 15px 0; float:left">
<span style="margin-bottom:0">Цена:</span>
<?php /*?><? if (CSite::InDir("/Netshop/cube/kub-mini/")){?>
<div style="text-align:left; margin:0 0 0px 0;"><span style="font-size:14px;"><br><s><? echo number_format( 490000, 0, ',', ' ' ); ?> руб.</s><br></div><? if (CSite::InDir("/Netshop/cube/kub-mini/")){?>
<div style=" display:block;  "><span style="font-size:14px; color:#000; font-weight:bold ">СКИДКА 15%</div><?}?><?}?><?php */?>

<? if (CSite::InDir("/Netshop/derevostreet/taz/taz_48.html")){?>
<div style="text-align:left; margin:0 0 0px 0;"><span style="font-size:14px;"><br><s><? echo number_format( 60000, 0, ',', ' ' ); ?> руб.</s><br></div>
<div style=" display:block;  "><span style="font-size:14px; color:#000; font-weight:bold ">СКИДКА 18%</div><?}?>

<? if (CSite::InDir("/Netshop/derevostreet/al/al_52.html")){?>
<div style="text-align:left; margin:0 0 0px 0;"><span style="font-size:14px;"><br><s><? echo number_format( 60000, 0, ',', ' ' ); ?> руб.</s><br></div>
<div style=" display:block;  "><span style="font-size:14px; color:#000; font-weight:bold ">СКИДКА 20%</div><?}?>

<? if (CSite::InDir("/Netshop/derevostreet/mad/mad_46.html")){?>
<div style="text-align:left; margin:0 0 0px 0;"><span style="font-size:14px;"><br><s><? echo number_format( 60000, 0, ',', ' ' ); ?> руб.</s><br></div>
<div style=" display:block;  "><span style="font-size:14px; color:#000; font-weight:bold ">СКИДКА 25%</div><?}?>

<?php /*?><? if (CSite::InDir("/Netshop/cube/kub-komfort/")){?>
<div style="text-align:left; margin:0 0 0px 0;"><span style="font-size:14px;"><br><s><? echo number_format( 690000, 0, ',', ' ' ); ?> руб.</s><br></div><? if (CSite::InDir("/Netshop/cube/kub-komfort/")){?>
<div style=" display:block;  "><span style="font-size:14px; color:#000; font-weight:bold ">СКИДКА 15%</div><?}?><?}?>
<? if (CSite::InDir("/Netshop/cube/kub-lyuks/")){?>
<div style="text-align:left; margin:0 0 0px 0;"><span style="font-size:14px;"><br><s><? echo number_format( 790000, 0, ',', ' ' ); ?> руб.</s><br></div><? if (CSite::InDir("/Netshop/cube/kub-lyuks/")){?>
<div style=" display:block;  "><span style="font-size:14px; color:#000; font-weight:bold ">СКИДКА 15%</div><?}?><?}?><?php */?>

        
<span style="font-size: 1px;"><br></span>
 <span style="color:#fcaf17;font-size:24px; font-family: Tahoma; font-weight:bold"><?if($arPrice["VALUE"]):?><? echo number_format( $arPrice["VALUE"], 0, ',', ' ' ); ?> руб.<?else:?>по запросу<?endif?></span>
</div>
<?endforeach;?>

<?php /*?> <? if (CSite::InDir("/Netshop/cube/kub-mini/")){
        ?><div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="font-size:12px;"><s><? echo number_format( 490000, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#FF4239;font-size:16px"><b>АКЦИЯ! Скидка 15%</b></font></span></div>		<?
}
?><?php */?>
<?php /*?> <? if (CSite::InDir("/Netshop/cube/kub-komfort/")){
        ?><div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="font-size:12px;"><s><? echo number_format( 690000, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#FF4239;font-size:16px"><b>АКЦИЯ! Скидка 15%</b></font></span></div>		<?
}
?><?php */?>

<?php /*?> <? if (CSite::InDir("/Netshop/cube/kub-lyuks/")){
        ?><div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="font-size:12px;"><s><? echo number_format( 790000, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#FF4239;font-size:16px"><b>АКЦИЯ! Скидка 15%</b></font></span></div>		<?
}
?><?php */?>
<?php /*?>
 <? if (CSite::InDir("/Netshop/derevostreet/shack/shack_109.html")){
        ?><div style="text-align:center; margin:0 0 15px 0;">Старая цена: <span style="font-size:12px;"><s><? echo number_format( 270000, 0, ',', ' ' ); ?> руб.</s><br><br><font style="color:#e13626;font-size:16px"><b>АКЦИЯ! Скидка 15%</b></font></span></div>		<?}?><?php */?>


<? $showbtn = 0; ?>
<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
<?if($arPrice["VALUE"]):?><? $showbtn = 1; ?>
<?endif?>
<?endforeach;?>
	
	<?if($showbtn):?>
	<div style="">
   

	<div style="float: left; margin-left: 20px; margin-top: 20px; ">	
		<a href="<?=$APPLICATION->GetCurPage()?>?action=ADD2BASKET&id=<?=$arResult["ID"]?>" class="add2cart" data-id="<?=$arResult['ID']?>">Купить</a>
	</div>
	<div class="clearfix"></div>
   
	<?endif?>
    


<? } else { ?>
<td style="padding-left:30px;padding-bottom: 200px;">
<? } ?><div class="clearfix"></div>
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
						<? 
						$arFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $arResult["PROPERTIES"]["BUY_WITH_THIS_PRODUC"]["VALUE"], "ACTIVE" => "Y", "SECTION_GLOBAL_ACTIVE" => "Y");
						$dbItems = CIBlockElement::GetList(Array("NAME"=>"ASC"), $arFilter);
		
						while($arItem = $dbItems->GetNext())
						{	
							$res = $arItem;
							$res_cat = CIBlockSection::GetByID($res["IBLOCK_SECTION_ID"]);
							$res_cat = $res_cat->GetNext();	
							$res_first_level = CIBlockSection::GetByID($res_cat["IBLOCK_ID"]);
							$res_first_level = $res_first_level->GetNext();							
							$get_prd = GetCatalogProduct($res["ID"]);						
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

<?
$APPLICATION->SetTitle("Page title");
?>




