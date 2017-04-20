<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

foreach($arResult["SECTIONS"] as $arSection):
	
	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
?>

<div class="img_s" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
		<?
		$arSelect = Array("ID", "NAME", "CODE");
		$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$arSection["ID"]);
		$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, Array("nPageSize"=>50), $arSelect);
		while($ob = $res->GetNextElement())
		{
		  $arFields = $ob->GetFields();
		  //var_dump($arSection);
		  $url=$arFields["CODE"];
		  break;
		}
		
		?>
       <? if($arSection["IBLOCK_SECTION_ID"] == '1') { ?>
			<a href="/Netshop/choice/metalstreet/<?=$arSection["CODE"]?>/<?=$url?>.html">
		<? } else { ?>
			
		<? } ?>
        
          <? if($arSection["IBLOCK_SECTION_ID"] == '4') { ?>
			<a href="/Netshop/choice/matlal/<?=$arSection["CODE"]?>/<?=$url?>.html">
		<? } else { ?>
			
		<? } ?>
		
		<img  style="width: auto; max-height:90px " alt="" src="<?=$arSection['PICTURE']['src']?>">
		<div><?=$arSection["NAME"]?></div>
		</a>
</div>
<?endforeach?>
<div style="clear:both;"></div>
