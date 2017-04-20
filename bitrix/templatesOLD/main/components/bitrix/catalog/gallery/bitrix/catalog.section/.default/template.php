<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="navigate">
	<p class="line_for_breadcrumbs">
		<span><a href="/">Главная</a></span>
		<span> -> </span>
		<span><a href="/Netshop/galery/">Галерея Ждем Ваши фотографии</a></span>
		<span><?=$arResult['NAME']?></span>
	</p>
	<span><?=$arResult['NAME']?></span>
</div>
<div class="nc_list nc_photogallery">
	<table class="nc_table">
		<colgroup>
			<col width="33%">
			<col width="33%">
			<col width="33%">
		</colgroup>
		<tbody>
			<?$cell=0;?>
			<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
				<?
				$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				?>
				<?if($cell%3 == 0):?>
					<tr>
				<?endif;?>

				<td class="nc_row" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
					<h3><?=$arElement["NAME"]?></h3>
					<a href="<?=$arElement["BIG_PICTURE"]['src']?>" rel="lightbox[2]" title="<?=$arElement['NAME']?>"><img class="nc_row_img" src="<?=$arElement["SMALL_PICTURE"]["src"]?>" alt="<?=$arElement["NAME"]?>"></a>
				</td>
				<?$cell++;
				if($cell%3 == 0):?>
					</tr>
				<?endif?>
			<?endforeach;?>
				
			<?if($cell%3 != 0):?>
				<?while(($cell++)%3 != 0):?>
					<td>&nbsp;</td>
				<?endwhile;?>
				</tr>
			<?endif?>
		</tbody>
	</table>
	<br />
	<p><a href="<?=$arParams['SEF_FOLDER']?>">Назад в галерею</a></p>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<br /><?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>