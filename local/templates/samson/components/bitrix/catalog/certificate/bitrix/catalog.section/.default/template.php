<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	<h1><?=$arResult['NAME']?></h1>
<div class="doc">
			<?
$i = 0;
foreach($arResult["ITEMS"] as $cell=>$arElement):
$i++;
if ($i == 1){
?>
<div class="row">
<?
}
?>
				<?
				$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				?>

				<div class="col-xs-3" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
					
					<a href="<?=$arElement["BIG_PICTURE"]['src']?>" rel="lightbox[2]" title="<?=$arElement['NAME']?>"><img class="nc_row_img" src="<?=$arElement["SMALL_PICTURE"]["src"]?>" alt="<?=$arElement["NAME"]?>"></a>
                    <span><?=$arElement["NAME"]?></span>
				</div>
<?
if ($i == 4){
?></div><?
$i = 0;
}
?>

			<?endforeach;?>
</div>
<div class="clearfix"></div><br>
	<p><a href="<?=$arParams['SEF_FOLDER']?>">Назад в галерею</a></p>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<br /><?=$arResult["NAV_STRING"]?>
	<?endif;?>
	<div class="clearfix"></div>
