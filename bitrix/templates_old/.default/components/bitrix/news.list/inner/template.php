<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<script type="text/javascript" src="/js/coin-slider.js"></script>
<script type="text/javascript">
$(function() {
	$("#inner_slider").coinslider({ width: 865 , height: 140 , effect: 'random',});
});
</script>

<div id="inner_slider">
	
	<ul>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
		
				<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?><a id="<?=$this->GetEditAreaId($arItem['ID']);?>" href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>"><?endif?>
					<img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>"  width="868" height="140">
				<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?></a><?endif?>
			
		<?endforeach;?>
	</ul>
	
</div>