<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="navigate">
	
	<p class="line_for_breadcrumbs">
			<span><a href="/">Главная</a></span>
			<span> -> </span>
			<span><a href="/Netshop/galery/">Галерея Ждем Ваши фотографии</a></span>
			<span> -> </span>
			<span><?=$arResult["NAME"]?></span>
		</p>
	
	<span>Галерея. Приглашаем Вас стать участником нашей галереи!</span></div>
<div class="nc_full nc_photogallery">
		<h3><?=$arResult["NAME"]?></h3>
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img width="500px" class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"  alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
	<?endif?>
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
	<?endif;?>
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
 	<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?echo $arResult["DETAIL_TEXT"];?>
 	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	<div style="clear:both"></div>
	<br />
	<?foreach($arResult["FIELDS"] as $code=>$value):?>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			<br />
	<?endforeach;?>
	<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

		<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
			<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
		<?else:?>
			<?=$arProperty["DISPLAY_VALUE"];?>
		<?endif?>
		<br />
	<?endforeach;?>
	<?
	if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
	{
		?>
		<div class="news-detail-share">
			<noindex>
			<?
			$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
		<?
	}
	?>
</div>
<div class="nc_prev_next">
	<?if($arResult["PREV_NEXT_NAV"]["PREV_ITEM"]):?>
	<span class="nc_prev_link">
		<a href="<?=$arResult["PREV_NEXT_NAV"]["PREV_ITEM"]["DETAIL_PAGE_URL"]?>">Назад</a>
	</span>
	<?endif?>
	<?if($arResult["PREV_NEXT_NAV"]["PREV_ITEM"] && $arResult["PREV_NEXT_NAV"]["NEXT_ITEM"]):?>|<?endif?>
	<?if($arResult["PREV_NEXT_NAV"]["NEXT_ITEM"]):?>
	<span class="nc_next_link">
		<a href="<?=$arResult["PREV_NEXT_NAV"]["NEXT_ITEM"]["DETAIL_PAGE_URL"]?>">Далее</a>
	</span>
	<?endif?>
</div>
