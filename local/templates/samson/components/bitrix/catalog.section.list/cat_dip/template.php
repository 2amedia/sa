<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="sections <?=$APPLICATION->GetProperty('color')?>">
<?
foreach($arResult["NEW_SECTIONS"] as $arSection):
	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));?>
	<?if (($arSection['DEPTH_LEVEL'] == 2) && ($arParams['TOP_DEPTH'] > 1)):?>
	<div class="clearfix"></div>
<div class="col-xs-12"><h6 class="spisok_cena"><?=$arSection["NAME"]?></h6></div>
	<?else: ?>

	<? if (!empty($arSection['ELEMENTS'])) {?>
		<div class="col-xs-4  inner_section">
				<div class="auto-ru" id="<?=$arSection["ID"]?>">
			<? foreach ($arSection['ELEMENTS'] as $element) { ?>
				<img src="<?= $element['PICTURE'] ?>" alt="<?= $arSection["NAME"] ?>" data-url ='<?= $element['SECTION_PAGE_URL'] ?>'>
			<? } ?>
					</div>
			<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><span><?= $arSection["NAME"] ?></span></a>
		</div>
	<?} else {?>
	<div class="col-xs-4  inner_section <?if($arSection['NOVINKA']):?> novinka_section<?endif?> <?if($arSection['ACIYA']):?> action_section<?endif?>">
		<a href="<?=$arSection["SECTION_PAGE_URL"]?>">
			<div class="wrap-img" style="background: url('<?=$arSection["PICTURE"]?>') center center no-repeat"></div>
			</a>
		<a href="<?=$arSection["SECTION_PAGE_URL"]?>">
			<span><?=$arSection["NAME"]?></span>
		</a>
	</div>
	<?}?>
	<?endif;?>
<?endforeach?>
<div class="clearfix"></div>
</div>
