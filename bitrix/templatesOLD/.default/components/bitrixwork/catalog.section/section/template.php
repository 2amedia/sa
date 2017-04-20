<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

		<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
		?>
		
		<div class="img_s">
			<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
			<img width="136" height="114" src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" title="<?=$arElement["NAME"]?>" alt="<?=$arElement["NAME"]?>">
			<div><?=$arElement["NAME"]?></div>
			</a>
		</div>

		<?endforeach; // foreach($arResult["ITEMS"] as $arElement):?>
