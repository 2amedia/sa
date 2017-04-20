<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="items">
	<?foreach($arResult["SECTIONS"] as $arSection):?>
		<?
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
		?>
		
		<?if ($arParams['CUR_PAGE'] == $arSection['SECTION_PAGE_URL']):?>
			<span id="<?=$this->GetEditAreaId($arSection['ID']);?>"><?=$arSection['NAME']?></span><br/>
		<?else:?>
			<a href="<?=$arSection['SECTION_PAGE_URL']?>" id="<?=$this->GetEditAreaId($arSection['ID']);?>"><?=$arSection['NAME']?></a><br/>
		<?endif?>
	<?endforeach?>
</div>
