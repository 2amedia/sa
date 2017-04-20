<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;
foreach($arResult["SECTIONS"] as $arSection):
	
	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
?>
	<div class="img_s">
		<?
		$arSelect = Array("ID", "NAME", "CODE");
		$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$arSection["ID"]);
		$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, Array("nPageSize"=>50), $arSelect);
		while($ob = $res->GetNextElement())
		{
		  $arFields = $ob->GetFields();
		  //var_dump($arFields);
		  $url=$arFields["CODE"];
		  break;
		}
		//print_r($arSection['PICTURE']);
		$file = CFile::ResizeImageGet($arSection['PICTURE'], array('width'=>132, 'height'=>93), BX_RESIZE_IMAGE_EXACT, true);
		?>
		<a href="/Netshop/metalstreet/<?=$arSection["CODE"]?>/<?=$url?>.html">
		<img style="width: auto; " alt="" src="<?=$arSection['PICTURE']['src']?>">
		<div><?=$arSection["NAME"]?></div>
		</a>
	</div>
<?endforeach?>
