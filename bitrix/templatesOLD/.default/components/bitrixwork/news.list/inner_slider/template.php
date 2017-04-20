<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<script type="text/javascript" src="/js/jcarousellite_1.0.1.js"></script>
<script type="text/javascript">
$(function() {
	$("#inner_slider").jCarouselLite({
   	auto: 7000,
    speed: 1000,
    visible: 1
  });
});
</script>

<div id="inner_slider">
	<ul>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?><a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>"><?endif?>
					<img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" width="871" height="140">
				<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?></a><?endif?>
			</li>
		<?endforeach;?>
	</ul>
</div>