<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="nc_list nc_photogallery">
	<table class="nc_table">
		<colgroup>
			<col width="33%">
			<col width="33%">
			<col width="33%">
		</colgroup>
		<tbody>
			<?$cell=0;?>
			<?foreach($arResult["SECTIONS"] as $arSection):?>
				<?
				$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
				$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
				?>
				<?if($cell%3 == 0):?>
					<tr>
				<?endif;?>

				<td class="nc_row" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
					<a href="<?=$arSection["SECTION_PAGE_URL"]?>">
					<img class="nc_row_img" src="<?=$arSection["PICTURE"]["src"]?>" alt="<?=$arSection["NAME"]?>">
                    <div><?=$arSection["NAME"]?></div></a>
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
</div>