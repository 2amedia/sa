<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<script type="text/javascript" src="/js/jcarousellite_1.0.1.js"></script>
<script type="text/javascript">
$(function() {
	$("#main_slider").jCarouselLite({
   	auto: 7000,
    speed: 1000,
    visible: 1,
    btnNext: ".next",
    btnPrev: ".prev"
  });
});
</script>

<div id="main_slider">
	<img class="prev" src="/bitrix/templates/.default/components/bitrix/news.list/main_slider/imgs/prev_slide.png" style="display: block;position: absolute;z-index: 100;top: 135px;left: 5px;cursor: pointer;" >
	<ul>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?><a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>"><?endif?>
					<img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>"  width="868" height="292">
				<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?></a><?endif?>
			</li>
		<?endforeach;?>
	</ul>
	<img class="next" src="/bitrix/templates/.default/components/bitrix/news.list/main_slider/imgs/next_slide.png" style="display: block;position: absolute;z-index: 100;top: 135px;right: 5px;cursor: pointer;"  >
</div>