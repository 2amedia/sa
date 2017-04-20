<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(!empty($arResult['NAME']) > 0): ?>
<div class="content-block content-block-special" itemscope itemtype = "http://schema.org/Product">
	<h3><?=GetMessage("CR_TITLE")?></h3>

	<div class="special-product">
		<?if(is_array($arResult["PICTURE_PREVIEW"])):?>
			<div class="item-image"><a href="<?=$arResult["DETAIL_PAGE_URL"]?>"><img border="0" itemprop="image" src="<?=$arResult["PICTURE_PREVIEW"]["SRC"]?>" width="<?=$arResult["PICTURE_PREVIEW"]["WIDTH"]?>" height="<?=$arResult["PICTURE_PREVIEW"]["HEIGHT"]?>" alt="<?=$arResult['NAME']?>" title="<?=$arResult['NAME']?>" /></a></div>
		<?endif;?>

		<div class="item-name"><a href="<?=$arResult["DETAIL_PAGE_URL"]?>"><span itemprop = "name"><?=$arResult['NAME']?></span></a></div>
		
		<? if (strlen($arResult["DESCRIPTION"]) > 0):?>
		<div class="item-desc" itemprop = "description"><?=$arResult["DESCRIPTION"]?></div>
		<?endif?>
		
		<?if(count($arElement["PRICE"])>0):?>
		<div class="item-price" itemprop = "offers" itemscope itemtype = "http://schema.org/Offer">
		<?if ($arResult['bDiscount']):?>
			<span itemprop = "price"><?=$arResult['PRICE']['DISCOUNT_PRICE_F']?></span> <s><span itemprop = "price"><?=$arResult['PRICE']['PRICE_F']?></span></s>
		<?else:?>
			<span itemprop = "price"><?=$arResult['PRICE']['PRICE_F']?></span>
		<?endif;?>
		</div>
		<?
		else:
			$price_from = '';
			if($arResult['DISPLAY_PROPERTIES']['MAXIMUM_PRICE']['VALUE'] > $arResult['DISPLAY_PROPERTIES']['MINIMUM_PRICE']['VALUE'])
			{
				$price_from = GetMessage("CR_PRICE_OT");	
			}
			CModule::IncludeModule("sale")
?>
			<div class="item-price" itemprop = "offers" itemscope itemtype = "http://schema.org/Offer"><span><?=$price_from?><span itemprop = "price"><?=FormatCurrency($arResult['DISPLAY_PROPERTIES']['MINIMUM_PRICE']['VALUE'], CSaleLang::GetLangCurrency(SITE_ID))?></span></span></div>
<?
		endif;?>
	</div>

</div>
<?elseif($USER->IsAdmin()):?>
<div class="content-block content-block-special">
	<h3><?=GetMessage("CR_TITLE")?></h3>

	<?=GetMessage("CR_TITLE_NULL")?>
</div>
<?endif;?>
