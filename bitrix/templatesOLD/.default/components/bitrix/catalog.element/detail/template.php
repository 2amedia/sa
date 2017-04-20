<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="navigate"><span><?=$arResult["NAME"]?></span></div>
<table>
<tbody><tr><td align="center" style="padding-bottom:200px">
<?if($arResult["MORE_PHOTO"][0]):?>
	<?$big=$arResult["MORE_PHOTO"][0]["SRC"];?>
<?else:?>
	<?$big=$arResult["DETAIL_PICTURE"]["SRC"];?>
<?endif?>
<a rel="lightbox" href="<?=$big?>" title="<?=$arResult["NAME"]?>" class="lightbox-enabled">
<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="Орион - детская металлическая площадка"></a>


<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
<div style="margin-top:28px;">Цена: <span style="color:#e13626;font-size:14px;"><s></s> <b><font size="+1"><?=$arPrice["VALUE"]?> руб</font></b></span></div>
<?endforeach;?>

	<div align="center" style="clear:both; margin-top: 20px">	
		<a href="<?=$APPLICATION->GetCurPage()?>?action=ADD2BASKET&id=<?=$arResult["ID"]?>"><img src="/images/buy.png"></a>
	</div>

</td>
<td style="padding-left:30px;padding-bottom:200px">
<?=$arResult["DETAIL_TEXT"]?>
</td>
</tr>


</tbody></table>
<div style="clear:both"></div>






