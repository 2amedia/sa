<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="gallery">
			<?foreach($arResult["SECTIONS"] as $arSection):?>
				<?
				$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
				$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
				?>

				<div class="nc_row  col-xs-3" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
					<a href="<?=$arSection["SECTION_PAGE_URL"]?>">
					<img class="nc_row_img" src="<?=$arSection["PICTURE"]["src"]?>" alt="<?=$arSection["NAME"]?>">
                    <span><?=$arSection["NAME"]?></span></a>
				</div>

			<?endforeach;?>
<div class="clearfix"></div>

</div>