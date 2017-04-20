<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul id="left-menu">

<?
$previousLevel = 0;
foreach($arResult as $arItem):?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("<li class='clear'></li></ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li class="<?=$arItem["PARAMS"]['style']?> parent <?if ($arItem["SELECTED"]):?>selected<?endif?>" ><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a>
				<ul>
		<?else:?>
			<li class="parent_<?=$arItem["DEPTH_LEVEL"]?>" >
				<?if(($arItem["DEPTH_LEVEL"])==2):?>
					<span href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?> item-selected<?endif?>"><?=$arItem["TEXT"]?></span>

				<?else:?>
					<a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?> item-selected<?endif?>"><?=$arItem["TEXT"]?></a>
				<?endif;?>
			</li>
				<ul>
		<?endif?>

	<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li class="other"><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li>
					<?if ($arItem["PARAMS"]['NOVINKA']):?><i class="novinka"></i><?endif?>
					<?if ($arItem["PARAMS"]['ACIYA']):?><i class="aciya"></i><?endif?><a href="<?=$arItem["LINK"]?>" <?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><?=$arItem["TEXT"]?></a>
			
				</li>
			<?endif?>
	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("<li class='clear'></li></ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
<?endif?>
<?//__dump($arResult)?>