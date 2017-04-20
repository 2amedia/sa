<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="left_news">
	<div class="caption blue">Последние новости</div>

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

	<div class="left_news_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="news_name"><?echo $arItem["NAME"]?></a>
		<span class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
	<?if ($arItem["PREVIEW_PICTURE"]) {?>
		<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
		<img class="preview_picture" border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
			 width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
			 height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
			 alt="<?=$arItem["NAME"]?>"
			 title="<?=$arItem["NAME"]?>"
		/>
	</a>
		<?}?>
		<div class="news_text"><?echo $arItem["PREVIEW_TEXT"];?></div>
		</div>
<?endforeach;?>
	</div>