<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?foreach($arResult["ITEMS"] as $cell=>$arElement){?>
<?
	$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
?>
<pre><? print_r($arElement);?></pre>
<div class="img_s" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
		<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
		<img style="width: auto; max-height:90px;max-width:143px; " alt="" src="<?=$arElement['PREVIEW_PICTURE']['SRC']?>">
		<div><?=$arElement["NAME"]?></div>
		</a>
</div> 
<?}?>
<div style="clear:both;"></div>