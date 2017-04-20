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
		
		?>	<a href="/Netshop/kiddyloft/<?=$arSection["CODE"]?>/<?=$url?>.html" >
		
		
		<img  style="width: auto; max-height:109px " alt="" src="<?=$arSection['PICTURE']['src']?>">
		<div><?=$arSection["NAME"]?></div>
		</a>
</div>
<?endforeach?>
<div style="clear:both;"></div>
